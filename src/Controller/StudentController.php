<?php

namespace App\Controller;

use Slim\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\StudentService;
use App\Model\StudentModel;
use App\Controller\BaseController;
use App\Services\Validator\Exceptions\ValidationRuleException;

class StudentController extends BaseController
{

    private $renderer;
    private $studentService;

    public function __construct(Container $container)
    {
        parent::__construct($container);

        $this->renderer       = resolve("renderer");
        $this->studentService = resolve(StudentService::class);
    }

    public function index(ServerRequestInterface $request, ResponseInterface $response)
    {
        $students = $this->studentService->all();

        return $this->renderer
                    ->render($response, 'index.phtml', ['students' => $students]);
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response)
    {
        return $this->renderer
                    ->render($response, 'create.phtml');
    }

    public function store(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {
            $this->studentService->save($request->getParsedBody());
            return $response->withRedirect("/students");
        } catch (ValidationRuleException $validationException) {
            $erros = $validationException->getValidationErrors();

            $this->renderer
                 ->render($response, 'create.phtml', ["erros" => $erros, "oldInput" => $request->getParsedBody()]);
        }
    }

    public function edit(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        try {
            $studentId = $args['id'];
            $student   = $this->studentService->find($args['id']);
            $student->phone_masked;

            return $this->renderer
                        ->render($response, 'edit.phtml', ["student" => $student]);
        } catch (ModelNotFoundException $modelNotFoundException) {
            return $response->withRedirect('/students');
        }
    }

    public function update(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        try {
            $studentId = $args["id"];

            $this->studentService->update($studentId, $request->getParsedBody());
            return $response->withRedirect("/students");
        } catch (ValidationRuleException $validationException) {
            $erros   = $validationException->getValidationErrors();
            $datas = $request->getParsedBody();
            $student = new StudentModel($request->getParsedBody());
            $this->renderer
                 ->render($response, 'edit.phtml', ["erros" => $erros, "student" => $student]);
        }
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $studentId = $args['id'];
        $this->studentService->delete($studentId);
        return $response->withRedirect('/students');
    }
}
