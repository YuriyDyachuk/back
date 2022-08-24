<?php
declare(strict_types=1);

namespace App\Components\Entity\DbGateways;

use Illuminate\Database\Eloquent\Model;

trait EloquentGetPureModelInstanceTrait
{
    use EloquentAbstractModelTrait;

    /**
     * @return Model|object
     */
    protected function getModelInstance(): object
    {
        $classname = $this->getModelClassname();

        return new $classname();
    }
}
