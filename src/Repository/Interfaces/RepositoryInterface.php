<?php

namespace App\Repository\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use App\Model\BaseModel;

interface RepositoryInterface
{
    public function all() : Collection;

    public function find(int $id) : BaseModel;

    public function save(BaseModel $model) : bool;

    public function update(int $id, array $dateToUpdate) : bool;
}
