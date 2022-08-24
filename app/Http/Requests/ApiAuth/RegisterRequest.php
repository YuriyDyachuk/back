<?php
declare(strict_types=1);

namespace App\Http\Requests\ApiAuth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|unique:users,email',
            'name' => 'required|string|between:3,255',
            'password' => 'required|string|between:6,255',
            'deviceName' => 'required|string|between:3,255',
        ];
    }
}
