<?php

namespace App\Repository;

use App\Repository\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use App\Model\BaseModel;

/**
 * Classe mãe de todas os repositórios
 *
 * @author Carlos Eduardo L. Braz <carloseduardolbraz@gmail.com>
 */
abstract class BaseRepository implements RepositoryInterface
{
    /**
     * Nome da model a qual esse repositório representa
     *
     * @var string
     */
    protected $model;

    abstract protected function getModel() : string;

    public function __construct()
    {
        $this->model = $this->getModel();
    }

    /**
     * Retorna todos os registros do banco de dados
     *
     * @return Collection
     */
    public function all() : Collection
    {
        return $this->model::all();
    }

    /**
     * Busca no banco por um registro que tenha este id (de acordo com a model)
     *
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException
     * @param integer $id
     * @return BaseModel
     */
    public function find(int $id) : BaseModel
    {
        return $this->model::findOrFail($id);
    }

    /**
     * Inseri um registro no banco de dados
     *
     * @param BaseModel $model
     * @return boolean
     */
    public function save(BaseModel $model) : bool
    {
        return $model->save();
    }

    /**
     * Atualiza um registro dado um id
     *
     * @param integer $id
     * @param array $dateToUpdate
     * @return boolean
     */
    public function update(int $id, array $dateToUpdate) : bool
    {
        try {
            return $this->model::where('id', $id)->update($dateToUpdate);
        } catch (QueryException $queryException) {
            return false;
        }
    }

     /**
     * Apaga um aluno do banco de dados
     *
     * @param integer $studentId
     * @return boolean
     */
    public function delete(int $id) : bool
    {
        return $this->model::destroy($id);
    }
}
