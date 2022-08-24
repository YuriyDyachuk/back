<?php
declare(strict_types=1);

namespace App\Components\Admin\Article;

use App\Components\Admin\Article\DbGateways\ArticlePluralCascadeDeletionDbGateway;
use App\Components\Admin\Entity\Contracts\DbGateways\EntityPluralCascadeDeletionDbGatewayInterface;
use App\Components\Admin\Entity\Contracts\EntityPluralCascadeDeletionFactoryInterface;
use App\Components\Admin\Entity\Contracts\EntityPluralCascadeDeletionInterface;

class ArticlePluralCascadeDeletionFactory implements EntityPluralCascadeDeletionFactoryInterface
{
    private EntityPluralCascadeDeletionDbGatewayInterface $cascadeDeletionDbGateway;

    public function __construct(ArticlePluralCascadeDeletionDbGateway $articlePluralCascadeDeletionDbGateway)
    {
        $this->cascadeDeletionDbGateway = $articlePluralCascadeDeletionDbGateway;
    }

    public function make(): EntityPluralCascadeDeletionInterface
    {
        return new ArticleCascadeDeletionService(
            $this->cascadeDeletionDbGateway
        );
    }
}
