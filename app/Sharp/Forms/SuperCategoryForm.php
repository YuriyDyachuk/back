<?php
declare(strict_types=1);

namespace App\Sharp\Forms;

use App\Models\Categories\SuperCategory;
use App\Models\Categories\Category;
use App\Models\Role;
use Code16\Sharp\Form\Eloquent\WithSharpFormEloquentUpdater;
use Code16\Sharp\Form\Fields\SharpFormSelectField;
use Code16\Sharp\Form\Fields\SharpFormCheckField;
use Code16\Sharp\Form\Fields\SharpFormTextField;
use Code16\Sharp\Form\Fields\SharpFormWysiwygField;
use Code16\Sharp\Form\Layout\FormLayoutColumn;
use Code16\Sharp\Form\SharpForm;

/**
 * Class SuperCategoryForm
 * @package App\Sharp\Forms
 */
class SuperCategoryForm extends SharpForm
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
        $data = $this->transform(
            SuperCategory::findOrFail($id)
        );
        $data['allowed_roles'] = explode(",", $data['allowed_roles'][0]);
        return $data;
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed the instance id
     */
    public function update($id, array $data)
    {
        $allowed_roles = $data['allowed_roles'];
        //dd($allowed_roles);
      //  unset($allowed_roles[0]);
        $array = [];
        foreach ($allowed_roles as $role) {
            array_push($array, $role['id']);
        }
        $data['allowed_roles'] = implode(",", $array);
        $article = $id ? SuperCategory::findOrFail($id) : new SuperCategory;
        $this->save($article, $data);

        $categories = Category::where('super_category_id', '=', $id)->get();
        foreach ($categories as $category) {
            $category->allowed_roles = $data['allowed_roles'];
            $category->save();
        }
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        SuperCategory::findOrFail($id)->find($id)->delete();
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
                ->setLabel('Название')
        )->addField(
            SharpFormTextField::make("image_id")
                ->setLabel("id фото")
        )->addField(
            SharpFormSelectField::make("allowed_roles", Role::get()->map(function($role) {
                return [
                    "id" => $role->id,
                    "label" => $role->name
                ];
            })->all())
                ->setMaxSelected(9999)
                ->setLabel("Дозволено ролям")
                ->setMultiple()
        )->addField(
            SharpFormWysiwygField::make("description")
                ->setLabel("Описание")
                ->setHeight(400)
        );
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
                ->withFields( "image_id|6")
                ->withFields( "allowed_roles");
        })->addColumn(6, function(FormLayoutColumn $column) {
            $column->withSingleField('description');
        });
    }
}
