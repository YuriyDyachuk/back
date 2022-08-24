<?php

namespace App\Sharp\Shows;

use App\Models\Categories\Category;
use Code16\Sharp\Show\Fields\SharpShowEntityListField;
use Code16\Sharp\Show\Fields\SharpShowTextField;
use Code16\Sharp\Show\Layout\ShowLayoutColumn;
use Code16\Sharp\Show\Layout\ShowLayoutSection;
use Code16\Sharp\Show\SharpShow;

/**
 * Class CategoryShow
 * @package App\Sharp\Shows
 */
class CategoryShow extends SharpShow
{
    /**
     * Retrieve a Model for the form and pack all its data as JSON.
     *
     * @param $id
     * @return array
     */
    public function find($id) : array
    {
        return $this->transform(
            Category::findOrFail($id)
        );
    }

    /**
     * Build show fields using ->addField()
     *
     * @return void
     */
    public function buildShowFields()
    {
        $this->addField(
            SharpShowTextField::make('name')
                ->setLabel('Название')
        )
            ->addField(
                SharpShowTextField::make('name')
                    ->setLabel('Название')
            )
//            ->addField(
//            SharpShowTextField::make("super_category_id", SuperCategory::pluck('name','id')->all())
//                ->setLabel("Супер категория")
//            )
//            ->addField(
//                SharpShowEntityListField::make("super_category_id", "super_category")
//            )
            ->addField(
                SharpShowTextField::make("description")
                ->setLabel("Описание")
        );
    }

    /**
     * Build show layout using ->addTab() or ->addColumn()
     *
     * @return void
     */
    public function buildShowLayout()
    {
        $this->addSection(
            'Description',
            function(ShowLayoutSection $section) {
                $section->addColumn(
                    9,
                    function(ShowLayoutColumn $column) {
                        $column->withSingleField("description");
                    }
                );
            }
        );
        $this->addSection(
            'Name',
            function(ShowLayoutSection $section) {
                $section->addColumn(
                    3,
                    function(ShowLayoutColumn $column) {
                        $column->withSingleField("name");
                    }
                );
            }
        );

//        $this->addEntityListSection('members');
    }

    function buildShowConfig()
    {
        //
    }
}
