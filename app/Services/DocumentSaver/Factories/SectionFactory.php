<?php
declare(strict_types=1);

namespace App\Services\DocumentSaver\Factories;

use App\Models\Documents\Section;
use App\Models\Documents\Article;

class SectionFactory
{
    public function __construct($data, $documentId)
    {
      $this->save($data, $documentId);
    }

    private function save($data, $documentId){
      foreach ($data as $sectionItem) {
         $section = new Section;
         $section->name = $sectionItem['title'];
         $section->description = $sectionItem['description'];
         $section->document_id = $documentId;
         $section->save();

         foreach($sectionItem['articles'] as $articleItem) {
          $article = new Article;
          $article->name = $articleItem['title'];
          $article->text = $articleItem['text'];
          $article->section_id = $section->id;
          $article->save();
         }


      }
    }
}
