<?php

namespace App\Repository;

use App\Repository\BaseRepository;
use App\Model\StudentModel;

class StudentRepository extends BaseRepository
{
    public function getModel() : string
    {
        return StudentModel::class;
    }
}
