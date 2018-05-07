<?php

namespace App\Services;

use App\Model\StudentModel;
use App\Repository\StudentRepository;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class StudentService
{
    /**
     * Repositorio de alunos para manipulação de banco de dados
     *
     * @var StudentRepository
     */
    private $studentRepository;


    /**
     * Construtor da classe
     */
    public function __construct()
    {
        $this->studentRepository = resolve(StudentRepository::class);
    }

    /**
     * Retorna todos os alunos cadastrados no banco de dados
     *
     * @return Collection
     */
    public function all() : Collection
    {
        return $this->studentRepository->all();
    }

    /**
     * Valida os dados recebidos e insere um novo aluno no banco de dados
     *
     * @author Carlos Edaurdo L. Braz  <carloseduardolbraz@gmail.com>
     * @throws App\Services\Validator\Exceptions\ValidationRuleException
     * @param array $values
     * @return boolean
     */
    public function save(array $values) : bool
    {
        $validator = new Validator([
            'name'     => ['required'],
            'cpf'      => ['required', 'cpf', 'unique:StudentModel,cpf'],
            'birthday' => ['required', 'date']
        ]);

        if ($validator->validate($values)) {
            $student = new StudentModel($values);
            return $this->studentRepository->save($student);
        }
        return false;
    }

    /**
     * Busca um aluno que pelo seu id
     *
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException
     * @param integer $id
     * @return StudentModel
     */
    public function find(int $id) : StudentModel
    {
        return $this->studentRepository->find($id);
    }

    /**
     * Autaliza os dados de um aluno
     *
     * @author Carlos Edaurdo L. Braz  <carloseduardolbraz@gmail.com>
     * @throws App\Services\Validator\Exceptions\ValidationRuleException
     * @param integer $studentId
     * @param array $dataToUpdate
     * @return void
     */
    public function update(int $studentId, array $dataToUpdate)
    {
        $validator = new Validator([
            'name'     => ['required'],
            'cpf'      => ['required', 'cpf', "unique:StudentModel,cpf,$studentId"],
            'birthday' => ['required', 'date']
        ]);

        if ($validator->validate($dataToUpdate)) {
            $dataToUpdate['birthday'] = Carbon::createFromFormat('d/m/Y', $dataToUpdate['birthday']);
            return $this->studentRepository->update($studentId, $dataToUpdate);
        }

        return false;
    }

    /**
     * Apaga um aluno do banco de dados
     *
     * @author Carlos Eduardo L. Braz    <carloseduardolbraz@gmail.com>
     * @param integer $studentId
     * @return boolean
     */
    public function delete(int $studentId) : bool
    {
        return $this->studentRepository->delete($studentId);
    }
}
