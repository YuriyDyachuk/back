<?php
declare(strict_types=1);

namespace App\Components\Admin\Entity\Contracts\DbGateways;

use Illuminate\Database\Eloquent\Model;

interface EntityCudDbGatewayInterface
{
    /**
     * @param array $attributes
     *
     * @return Model|object
     */
    public function create(array $attributes): object;

    /**
     * @param array $attributes
     * @param Model|object $entity
     */
    public function update(array $attributes, object $entity): void;

    /**
     * @param Model|object $entity
     */
    public function delete(object $entity): void;
}
