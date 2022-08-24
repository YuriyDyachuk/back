<?php
declare(strict_types=1);

namespace App\Services\DocumentSaver;

use App\Services\DocumentSaver\Factories\FactoryManager;


class DocumentSaverManager
{

    public static function store($data, $url, $categoryId){

      new FactoryManager($data, $url, $categoryId);
      return true;
    }


}
