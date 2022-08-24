<?php
declare(strict_types=1);

namespace App\Sharp\Forms;

use App\Models\Documents\Document;
use App\Models\Documents\Section;
use Code16\Sharp\Form\Eloquent\WithSharpFormEloquentUpdater;
use Code16\Sharp\Form\Fields\SharpFormSelectField;
use Code16\Sharp\Form\Fields\SharpFormTextField;
use Code16\Sharp\Form\Fields\SharpFormWysiwygField;
use Code16\Sharp\Form\Layout\FormLayoutColumn;
use Code16\Sharp\Form\SharpForm;

class SectionForm extends SharpForm
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
        return $this->transform(
            Section::findOrFail($id)
        );
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed the instance id
     */
    public function update($id, array $data)
    {
        $article = $id ? Section::findOrFail($id) : new Section;
        $this->save($article, $data);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        Section::findOrFail($id)->find($id)->delete();
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
            SharpFormSelectField::make("document_id", Document::pluck('name','id')->all())
                ->setLabel("Документ")
                ->setDisplayAsDropdown()
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
                ->withFields( "document_id|6");
        })->addColumn(6, function(FormLayoutColumn $column) {
            $column->withSingleField('description');
        });
    }
}
