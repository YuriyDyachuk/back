<?php

namespace App\Sharp;

use App\Models\LinkedSocialAccount;
use App\Models\Role;
use App\Models\Subscription;
use App\Models\User;
use Code16\Sharp\Form\Eloquent\Transformers\FormUploadModelTransformer;
use Code16\Sharp\Form\Eloquent\WithSharpFormEloquentUpdater;
use Code16\Sharp\Form\Fields\SharpFormDateField;
use Code16\Sharp\Form\Fields\SharpFormSelectField;
use Code16\Sharp\Form\Fields\SharpFormTextField;
use Code16\Sharp\Form\Layout\FormLayoutColumn;
use Code16\Sharp\Form\SharpForm;

/**
 * Class UserForm
 * @package App\Sharp
 */
class UserForm extends SharpForm
{
    use WithSharpFormEloquentUpdater;

    /**
     * Retrieve a Model for the form and pack all its data as JSON.
     *
     * @param $id
     * @return array
     */
    public function find($id): array
    {
        return $this->setCustomTransformer(
            "picture",
            new FormUploadModelTransformer()
        )->transform(
            User::with('picture')->findOrFail($id)
        );
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed the instance id
     */
    public function update($id, array $data)
    {
        $data['type'] = 4;
        $user = $id ? User::findOrFail($id) : new User;
        $this->save($user, $data);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        User::findOrFail($id)->find($id)->delete();
        LinkedSocialAccount::where(["user_id" => $id])->delete();
    }

    /**
     * Build form fields using ->addField()
     *
     * @return void
     */
    public function buildFormFields()
    {
        $this->addField(
            SharpFormTextField::make('name')
                ->setLabel('Name')
        )->addField(
            SharpFormTextField::make("email")
                ->setLabel("E-mail")
        )->addField(
            SharpFormSelectField::make('subscription_type', Subscription::pluck('name', 'id')->all())
                ->setLabel(Subscription::FILTER_NAME)
                ->setDisplayAsDropdown()
        )->addField(
            SharpFormSelectField::make('role_id', Role::pluck('name', 'id')->all())
                ->setLabel(Subscription::FILTER_NAME)
                ->setDisplayAsDropdown()
        )->addField(
            SharpFormTextField::make("type")
                ->setLabel("Тип")
        )->addField(
            SharpFormTextField::make("photo_url")
                ->setLabel("Урл фото")
        )->addField(
            SharpFormDateField::make(User::SUBSCRIBED_TO)
                ->setLabel("Подписан до")
        )
//            ->addField(
//            SharpFormUploadField::make("picture")
//                ->setLabel("Picture")
//                ->setFileFilterImages()
//                ->setStorageDisk("local")
//                ->setStorageBasePath("data/Users")
//        )
        ;
    }

    /**
     * Build form layout using ->addTab() or ->addColumn()
     *
     * @return void
     */
    public function buildFormLayout()
    {
        $this->addColumn(6, function(FormLayoutColumn $column) {
            $column->withSingleField('name')
                ->withFields("role_id")
                ->withFields("email|6", User::SUBSCRIBED_TO.'|6', "subscription_type|12");
        })->addColumn(6, function(FormLayoutColumn $column) {
            $column->withSingleField('photo_url');
        });
    }
}
