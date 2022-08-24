<?php
declare(strict_types=1);

namespace App\Services\DocumentSaver\Factories;

use App\Services\DocumentSaver\Factories\SectionFactory;
use App\Services\DocumentSaver\Factories\ArticleFactory;
use App\Services\DocumentSaver\Factories\DocumentFactory;

class FactoryManager
{
    private $section;

    private $document;

    public function __construct($data, $url, $categoryId)
    {
     $this->document = new DocumentFactory($data, $url, $categoryId);
     $this->section = new SectionFactory($data['data']['sections'], $this->document->id);
    }
}
