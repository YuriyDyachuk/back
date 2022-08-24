<?php
declare(strict_types=1);

namespace App\Services\DocumentSaver\Factories;

use App\Models\Documents\Document;

class DocumentFactory
{
  public $id;

  public function __construct($data, $url, $categoryId)
     {
       $this->save($data, $url, $categoryId);
     }

     private function save($data, $url, $categoryId){
          $data = $data['data'];

          $document = new Document;
          $document->name = $data['name'];
          $document->description = $data['description'];
          $document->url = $url;
          $document->category_id = $categoryId;
          $document->save();

          $this->id = $document->id;
          return $document->id;

     }
}
