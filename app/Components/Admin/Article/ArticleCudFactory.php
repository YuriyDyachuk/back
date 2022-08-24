<?php
declare(strict_types=1);

namespace App\Components\Admin\Article;

use App\Components\Admin\Article\DbGateways\ArticleCudDbGateway;
use App\Components\Admin\Entity\Contracts\DbGateways\EntityCudDbGatewayInterface;
use App\Components\Admin\Entity\Contracts\EntityCudFactoryInterface;
use App\Components\Admin\Entity\Contracts\EntityCudInterface;

class ArticleCudFactory implements EntityCudFactoryInterface
{
    private EntityCudDbGatewayInterface $entityCudDbGateway;

    public function __construct(ArticleCudDbGateway $entityCudDbGateway)
    {
        $this->entityCudDbGateway = $entityCudDbGateway;
    }

    public function make(): EntityCudInterface
    {
        return new ArticleCudService(
            $this->entityCudDbGateway
        );
    }
}
