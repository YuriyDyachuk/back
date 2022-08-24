<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Components\Entity\Contracts\Presenters\EntityShowPresenterFactoryInterface;
use App\Components\User\Presenters\UserShowPresenterFactory;
use App\Http\Controllers\Controller;
use App\Models\LinkedSocialAccount;
use App\Models\User;
use App\Models\ResetPassword;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Services\SocialAuth\SocialAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationConfirmMail;
use App\Mail\SendCodeMail;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
class UserController extends Controller
{
    private EntityShowPresenterFactoryInterface $showPresenterFactory;

    public int $successStatus = 200;

    /**
     * UserController constructor.
     * @param UserShowPresenterFactory $showPresenterFactory
     */
    public function __construct(UserShowPresenterFactory $showPresenterFactory)
    {
        $this->showPresenterFactory = $showPresenterFactory;
    }

    /**
     * socialAuth api
     *
     * @param Request $request
     * @param         $provider
     *
     * @return ResponseFactory|Response|JsonResponse
     */
    public function socialAuth(Request $request, $provider)
    {
        try {
            $validator = Validator::make($request->all(), [
                'token' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);
            }

            $token = $request->token;
            $socialAuth = new SocialAuth($provider);
            $userSocial = $socialAuth->getUserFromToken($token);

            if (empty($userSocial['email'])) {
                return response()->json(['error'=> 'Registration via Facebook is not available, try the second method'], 403);
            }

            if(!$userSocial) {
                return response()->json(['error'=> 'Token expired or invalid'], 403);
            }

            if (in_array($provider, ['apple', 'google'])) {
                $userSocialId = $userSocial['sub'];
            }else {
                $userSocialId = $userSocial['id'];
            }

            $linkedSocialAccount = LinkedSocialAccount::where(['provider_id' => $userSocialId])->first();

            if($linkedSocialAccount) {
                Log::info('user: ' . $linkedSocialAccount->id);
                Auth::loginUsingId($linkedSocialAccount->user->id);
                $accessToken = auth()->user()->createToken('authToken')->accessToken;
                if (Auth::check()) {
                    return response(['user' => auth()->user(), 'access_token' => $accessToken]);
                } else {
                    return response()->json(['error'=> 'Unauthorized'], 401);
                }
            } else {
                $user = new User;
                $user->email = $userSocial['email'];
                $user->photo_url = $userSocial['picture'];
                $user->name = $userSocial['given_name'];
                //todo reworke types
                $user->type = 0;
                $user->subscription_type = 0;
                $user->active = 1;
                $user->save();

                $user->roles()->attach(2);
                $providerId = null;

                if($provider == "facebook") {
                    $providerId = 2;
                } else {
                    $providerId = 1;
                }

                $linkedsocialAccont = new LinkedSocialAccount();
                $linkedsocialAccont->provider_id = $userSocialId;
                $linkedsocialAccont->provider_name = $provider;
                $linkedsocialAccont->user_id = $user->id;
                $linkedsocialAccont->status = 1;
                $linkedsocialAccont->save();

                Auth::loginUsingId($user->id);
                $accessToken = auth()->user()->createToken('authToken')->accessToken;
                if (Auth::check()) {
                    return response(['user' => auth()->user(), 'access_token' => $accessToken]);
                } else {
                    return response()->json(['error'=> 'Unauthorized'], 401);
                }
            }
        }catch (\Throwable $exception) {
            Log::info('message: ' . $exception->getMessage());
            Log::info('code: ' . $exception->getCode());
            Log::info('file: ' . $exception->getFile());
            Log::info('line: ' . $exception->getLine());
        }
    }

    /**
     * login api
     *
     * @param Request $request
     * @return ResponseFactory|Response|JsonResponse
     */
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required|min:1'
        ]);


        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        if (auth()->user()->active === 0) {
            return response(['message' => 'User Inactive']);
        }

        if (Auth::check()) {
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            return response(['user' => auth()->user(), 'access_token' => $accessToken]);
        } else {
            return response()->json(['error'=> 'Unauthorized'], 401);
        }
    }

    /**
     * Register api
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:3,255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|between:6,255',
            'c_password' => 'required|same:password',
            'image' => 'image:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $input = $request->all();

        if ($request->file('image')) {
            $input['photo_url'] = str_replace('public', 'storage', $request->file('image')->store('public/avatars'));
        }

        $randomCode = rand(1111, 9999);

        $input['password'] = bcrypt($input['password']);
        //todo delete
        $input['type'] = 0;
        $input['subscription_type'] = 0;

        $user = User::create($input);
        $verificationHash = Hash::make($randomCode.$user->id);
        $user->verification_code = $verificationHash;
        $user->save();
        $user->roles()->attach(2);

        $this->sendVerificationMail($user->email, $verificationHash);

        if (isset($input['photo_url'])) {
            $success['image'] = $input['photo_url'];
        }

        //$success['token'] = $user->createToken('MyApp')-> accessToken;
        $success['name']  = $user->name;

        return response()->json(['success' => $success], $this->successStatus);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $user = Auth::user()->token();
        if ($user && $user->revoke()) {
            return response()->json(['success'=> true], $this->successStatus);
        }
        return response()->json(['success'=> false], $this->successStatus);
    }

    /**
     * Надсилає код віновлення пароля на пошту
     */
    public function resetPasswordRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $passwordResetRecord = ResetPassword::where(['email' => $request->email])->first();
        if ($passwordResetRecord) {
            ResetPassword::where(['email' => $request->email])->delete();
        }

        $code = rand(1111, 9999);
        $passwordResetRecord = new ResetPassword();
        $passwordResetRecord->email = $request->email;
        $passwordResetRecord->token = $code;
        $passwordResetRecord->save();

        $this->sendCodeMail($request->email, $code);
        return response(['message' => 'success']);
    }

    /**
     * Міняє пароль з кодом з пошти. для зміни пароля залогіненого юзера
     * changePassword
     *
     * @param Request $request
     *
     * @return Exception|Application|ResponseFactory|JsonResponse|Response
     */
    public function resetPassword(Request $request)
    {
        Log::info('start method');
        Log::info('method: resetPassword');

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $passwordResetRecord = ResetPassword::where(['email' => $request->email])->first();

        if (!$passwordResetRecord) {
            return response()->json(['error'=> "password Record not found"], 404);
        }
        $user = User::where(['email' => $passwordResetRecord->email])->first();

        if ($passwordResetRecord->token === $request->code) {
            try {
                Log::info('token password : ' . $passwordResetRecord->token);
                $user->fill([
                    'password' => bcrypt($request->password)
                ])->save();
                ResetPassword::where(['email' => $request->email])->delete();
            } catch (Exception $e) {
                Log::info('file : ' . $e->getFile());
                Log::info('line : ' . $e->getLine());
                Log::info('message : ' . $e->getMessage());
                Log::info('code :' . $e->getCode());
                Log::error($e->getMessage() . ' ~~~~~ ' . $e->getTraceAsString());
                return $e;
            }
        } else {
            return response()->json(['error'=> "invalid code"], 403);
        }

        return response(['message' => 'success']);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function changePassword(Request $request): JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false], 401);
        }
        $validator = Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        if (Hash::check($request->oldPassword, $user->password))
        {
            $user->password = bcrypt($request->newPassword);
            $user->save();

            return response()->json(['message'=> 'success'], 200);
        }

        return response()->json(['error'=> 'something went wrong'], 404);
    }

    /**
     * details api
     *
     * @return JsonResponse
     */
    public function details() : JsonResponse
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateUserInfo(Request $request) : JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string',
            // 'image' => 'image:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $input = $request->all();

        if ($request->file('image')) {
            $input['photo_url'] = str_replace('public', 'storage', $request->file('image')->store('public/avatars'));
            $user->photo_url = $input['photo_url'];
            $user->save();
        }

        if(isset($input['name'])) {
            $user->name = $input['name'];
            $user->save();
        }


        return response()->json(['success' => $user], $this->successStatus);
    }

    /**
     * @return JsonResponse
     */
    public function showIm(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $showPresenter = $this->showPresenterFactory->make();
        $formatted = $showPresenter->format($user);

        return response()->json($formatted);
    }

    /**
     * @return JsonResponse
     */
    public function getUserInfo() : JsonResponse
    {
        if (Auth::check()) {
            $user = auth()->user();
            $showPresenter = $this->showPresenterFactory->make();
            $formatted = $showPresenter->format($user);

            return response()->json($formatted);
        } else {
            return response()->json(['error'=> 'Unauthorized'], 401);
        }
    }

    public function linkSocialAccount(Request $request, $provider) {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        if (Auth::check()) {
            $user = auth()->user();
            $token = $request->token;

            $socialAuth = new SocialAuth($provider);

            $userSocial = $socialAuth->getUserFromToken($token);
            if(!$userSocial) {
                return response()->json(['error'=> 'Token expired or invalid'], 403);
            }

            $userSocialId = $userSocial['id'];

            if (!isset($userSocial['email'])) {
                return response()->json(['error'=> 'Empty Email'], 403);
            }
            $linkedSocialAccount = LinkedSocialAccount::where(['provider_id' => $userSocialId])->first();

            if ($linkedSocialAccount) {
                return response()->json(['error' => "Already linked"], 403);
//                $linkedSocialAccount->status = 1;
//                $linkedSocialAccount->save();
            } else {
                try {
                    $linkedsocialAccont = new LinkedSocialAccount();
                    $linkedsocialAccont->provider_id = $userSocialId;
                    $linkedsocialAccont->provider_name = $provider;
                    $linkedsocialAccont->user_id = $user->id;
                    $linkedsocialAccont->status = 1;
                    $linkedsocialAccont->save();
                } catch (Throwable $e) {
                    return response()->json(['error'=> $e], 403);
                }
            }
            return response()->json(['success' => "success"]);
        } else {
            return response()->json(['error'=> 'Unauthorized'], 401);
        }
    }

    public function unlinkSocialAccount(Request $request, $provider) {
        if (Auth::check()) {
            $user = auth()->user();
            $linkedSocialAccount = LinkedSocialAccount::where(['user_id' => $user->id])
                ->where(['provider_name' => $provider])
                ->first();

            if (!$linkedSocialAccount) {
                return response()->json(['error' => "social not found"]);
            }
            //$linkedSocialAccount->status = 0;
            $linkedSocialAccount->delete();

        } else {
            return response()->json(['error'=> 'Unauthorized'], 401);
        }
    }


    public static function sendVerificationMail($email, $code)
    {

        $link = url('/').'/user/verify?code='.$code;
        try {
//                Mail::to($email)->send(new RegistrationConfirmMail(json_decode($msg, true)));
            Mail::to($email)->send(new RegistrationConfirmMail($link));
        }
        catch (Exception $e) {
            //dd($e->getMessage());
        }
        return true;
    }

    /**
     * @param $email
     * @param $code
     *
     * @return bool
     */
    public function sendCodeMail($email, $code): bool
    {
        try {
            Mail::to($email)->send(new SendCodeMail($code));
        }
        catch (Exception $e) {
            //dd($e->getMessage());
        }
        return true;
    }

    public function userVerifyByEmailLink(Request $request) {
        if ($request->code) {
            $hash = $request->code;
            $user = User::where(['verification_code' => $hash])->first();

            if($user) {
                $user->active = 1;
                $user->save();
                $success = true;
            } else {
                $success = false;
            }

        } else {
            $success = false;
        }

        return view('user.verified', ['success' => $success]);
    }
}
