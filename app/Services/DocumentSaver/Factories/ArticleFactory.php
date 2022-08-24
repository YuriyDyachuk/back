<?php
declare(strict_types=1);

namespace App\Services\DocumentSaver\Factories;

use App\Models\Documents\Article;

class ArticleFactory
{
    public function __construct($data)
    {
      $this->save($data, $documentId);
    }

    private function save(){
      foreach ($data as $section) {
         $section = new Section;
         $section->name = $data['title'];
         $section->description = $data['description'];
         $section->document_id = $documentId;
         $section->save();
      }
    }
}
