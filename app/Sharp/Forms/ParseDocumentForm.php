<?php
declare(strict_types=1);

namespace App\Sharp\Forms;

use App\Models\Categories\Category;
use Code16\Sharp\Form\Eloquent\WithSharpFormEloquentUpdater;
use Code16\Sharp\Form\Fields\SharpFormSelectField;
use Code16\Sharp\Form\Fields\SharpFormTextField;
use Code16\Sharp\Form\Fields\SharpFormButtonField;
use Code16\Sharp\Form\Fields\SharpFormWysiwygField;
use Code16\Sharp\Form\Layout\FormLayoutColumn;
use Code16\Sharp\Form\SharpForm;
use App\Models\Documents\Document;

class ParseDocumentForm extends SharpForm
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
            Document::findOrFail($id)
        );
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed the instance id
     */
    public function update($id, array $data)
    {
        $article = $id ? Document::findOrFail($id) : new Document;
        $this->save($article, $data);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        Document::findOrFail($id)->find($id)->delete();
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
            SharpFormTextField::make('testName')
                ->setLabel('Название2')
        )->addField(
            SharpFormTextField::make('url')
                ->setLabel('URL')
        )->addField(
            SharpFormButtonField::make('parse')
                ->setLabel('parse')
        )->addField(
            SharpFormSelectField::make("category_id", Category::pluck('name','id')->all())
                ->setLabel("Категория")
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
                ->withFields( "category_id|6", "url|12");
        })->addColumn(6, function(FormLayoutColumn $column) {
            $column->withSingleField('description');
        });
    }
}
