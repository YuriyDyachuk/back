<?php
declare(strict_types=1);

namespace App\Components\Admin\Article;

use App\Components\Admin\Article\DbGateways\ArticlePluralCascadeDeletionDbGateway;
use App\Components\Admin\Entity\Contracts\DbGateways\EntityPluralCascadeDeletionDbGatewayInterface;
use App\Components\Admin\Entity\Contracts\EntityCascadeDeletionFactoryInterface;
use App\Components\Admin\Entity\Contracts\EntityCascadeDeletionInterface;

class ArticleCascadeDeletionFactory implements EntityCascadeDeletionFactoryInterface
{
    private EntityPluralCascadeDeletionDbGatewayInterface $cascadeDeletionDbGateway;

    public function __construct(ArticlePluralCascadeDeletionDbGateway $articlePluralCascadeDeletionDbGateway)
    {
        $this->cascadeDeletionDbGateway = $articlePluralCascadeDeletionDbGateway;
    }

    public function make(): EntityCascadeDeletionInterface
    {
        return new ArticleCascadeDeletionService(
            $this->cascadeDeletionDbGateway
        );
    }
}
