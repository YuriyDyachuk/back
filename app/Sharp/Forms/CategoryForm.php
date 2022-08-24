<?php
declare(strict_types=1);

namespace App\Sharp\Forms;

use App\Models\Categories\SuperCategory;
use App\Models\Role;
use Code16\Sharp\Form\Eloquent\WithSharpFormEloquentUpdater;
use Code16\Sharp\Form\Fields\SharpFormSelectField;
use Code16\Sharp\Form\Fields\SharpFormTextField;
use Code16\Sharp\Form\Fields\SharpFormWysiwygField;
use Code16\Sharp\Form\Layout\FormLayoutColumn;
use Code16\Sharp\Form\SharpForm;
use App\Models\Categories\Category;

/**
 * Class CategoryForm
 * @package App\Sharp\Forms
 */
class CategoryForm extends SharpForm
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
            Category::findOrFail($id)
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
       // unset($allowed_roles[0]);
        $array = [];
        foreach ($allowed_roles as $role) {
            array_push($array, $role['id']);
        }
        $data['allowed_roles'] = implode(",", $array);;
        $article = $id ? Category::findOrFail($id) : new Category;
        $this->save($article, $data);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        Category::findOrFail($id)->find($id)->delete();
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
            SharpFormSelectField::make("super_category_id", SuperCategory::pluck('name','id')->all())
                ->setLabel("Супер категория")
                ->setDisplayAsDropdown()
        )->addField(
            SharpFormSelectField::make("allowed_roles", Role::get()->map(function($role) {
                return [
                    "id" => $role->id,
                    "label" => $role->name
                ];
            })->all())
                ->setLabel("Дозволено ролям")
                ->setMultiple()
//                ->setIdAttribute('id: 1')
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
                ->withFields( "super_category_id|6")
                ->withFields( "allowed_roles");
        })->addColumn(6, function(FormLayoutColumn $column) {
            $column->withSingleField('description');
        });
    }
}
