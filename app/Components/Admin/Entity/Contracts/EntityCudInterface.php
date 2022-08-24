<?php
declare(strict_types=1);

namespace App\Components\Admin\Entity\Contracts;

use Illuminate\Database\Eloquent\Model;

interface EntityCudInterface
{
    /**
     * @param array $data
     *
     * @return Model|object
     */
    public function makeStore(array $data): object;

    /**
     * @param array $updatable
     *
     * @return Model|object
     */
    public function makeUpdate(array $updatable): object;

    /**
     * @param object $deletable
     *
     * @return Model|object
     */
    public function makeDelete(object $deletable): object;
}
