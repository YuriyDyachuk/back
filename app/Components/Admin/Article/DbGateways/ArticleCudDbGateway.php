<?php
declare(strict_types=1);

namespace App\Components\Admin\Article\DbGateways;

use App\Components\Admin\Entity\DbGateways\AbstractEloquentEntityCudDbGateway;
use App\Models\Documents\Article;

class ArticleCudDbGateway extends AbstractEloquentEntityCudDbGateway
{
    protected function getModelClassname(): string
    {
        return Article::class;
    }
}
