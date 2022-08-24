<?php
declare(strict_types=1);

namespace App\Sharp\Forms;

use App\Models\Permission;
use App\Models\Role;
use Code16\Sharp\Form\Eloquent\WithSharpFormEloquentUpdater;
use Code16\Sharp\Form\Fields\SharpFormListField;
use Code16\Sharp\Form\Fields\SharpFormSelectField;
use Code16\Sharp\Form\Fields\SharpFormTextField;
use Code16\Sharp\Form\Layout\FormLayoutColumn;
use Code16\Sharp\Form\SharpForm;
use Exception;

/**
 * Class RoleForm
 * @package App\Sharp\Forms
 */
class RoleForm extends SharpForm
{
    use WithSharpFormEloquentUpdater;

    /**
     * Retrieve a Model for the form and pack all its data as JSON.
     *
     * @param $id
     * @return array
     */
    public function find($id) : array
    {
        return $this->transform(
            Role::with('permissions')->findOrFail($id)
        );
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed the instance id
     */
    public function update($id, array $data)
    {
        $role = $id ? Role::with('permissions')->findOrFail($id) : new Role;

        if (isset($data['permissions']) && !empty($data['permissions'])) {
            $permissions = collect($data['permissions']);
            $ids = $permissions->pluck('id');
            $role->permissions()->sync($ids->all());
            unset($data['permissions']);
        }

        $this->save($role, $data);
    }

    /**
     * @param $id
     * @throws Exception
     */
    public function delete($id)
    {
        Role::with('permissions')->findOrFail($id)->find($id)->delete();
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
            SharpFormTextField::make('slug')
                ->setLabel('ЧПУ')
        )           ->addField(
            SharpFormListField::make("permissions")
                ->setLabel("Разрешения")
                ->setAddable(true)
                ->setRemovable()
                ->setAddText("Добавить разрешение")
                ->addItemField(
                    SharpFormSelectField::make('id', Permission::pluck('name', 'id')->all())
                        ->setLabel('Разрешение:')
                )
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
            $column->withSingleField('name');
        })->addColumn(6, function(FormLayoutColumn $column) {
            $column->withSingleField('slug');
        })->addColumn(12, function(FormLayoutColumn $column) {
            $column->withSingleField('permissions', function(FormLayoutColumn $listItem) {
                $listItem->withSingleField('id');
            });
        });
    }
}
