<?php
declare(strict_types=1);

namespace App\Sharp\Forms;

use App\Models\Documents\Section;
use Code16\Sharp\Form\Eloquent\WithSharpFormEloquentUpdater;
use Code16\Sharp\Form\Fields\SharpFormSelectField;
use Code16\Sharp\Form\Fields\SharpFormTextField;
use Code16\Sharp\Form\Fields\SharpFormNumberField;
use Code16\Sharp\Form\Fields\SharpFormWysiwygField;
use Code16\Sharp\Form\Layout\FormLayoutColumn;
use Code16\Sharp\Form\SharpForm;
use App\Models\Documents\Article;

/**
 * Class ArticleForm
 * @package App\Sharp\Forms
 */
class ArticleForm extends SharpForm
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
        $article = Article::findOrFail($id);   
        $article->section_id_manual = $article->section_id;
        return $this->transform(
           $article
        );
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed the instance id
     */
    public function update($id, array $data)
    {
           if ($data['section_id_manual'] === 0) {           
             unset($data['section_id_manual']);
        }
        if (isset($data['section_id_manual'])) {
        $data['section_id'] = $data['section_id_manual'];
        unset($data['section_id_manual']);
        }
        $article = $id ? Article::findOrFail($id) : new Article;
        $this->save($article, $data);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        Article::findOrFail($id)->find($id)->delete();
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
            SharpFormSelectField::make('section_id', Section::pluck('name', 'id')->all())
                ->setLabel(Section::FILTER_NAME)
                ->setDisplayAsDropdown()
        )->addField(
            SharpFormNumberField::make('section_id_manual')
                ->setLabel('ID СЕКЦІЇ')
        )->addField(
            SharpFormWysiwygField::make("text")
                ->setLabel("Текст")
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
                ->withFields( "section_id|6")
                ->withFields( "section_id_manual");
        })->addColumn(6, function(FormLayoutColumn $column) {
            $column->withSingleField('text');
        });
    }
}
