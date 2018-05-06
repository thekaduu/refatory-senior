<?php

namespace App\Controller;

use App\Model\StudentModel;
use App\Controller\BaseController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class StudentController extends BaseController
{

    public function index(ServerRequestInterface $request, ResponseInterface $response)
    {

        $students = StudentModel::all();
        $renderer = $this->resolve("renderer");


        $a =  $renderer->render($response, 'index.phtml', ['students' => $students]);
        var_dump($a);
        die();
    }

    public static function create(ServerRequestInterface $request, ResponseInterface $response) {
        global $app;

        return $app->getContainer()->get('renderer')->render($response, 'create.phtml', ['students' => $students]);
    }

    public static function store(ServerRequestInterface $request, ResponseInterface $response){
        global $app;

        StudentModel::create($request->getParsedBody());

        return $app->getContainer()->get('renderer')->render($response, 'index.phtml', ['students' => $students]);
    }

    public static function edit(ServerRequestInterface $request, ResponseInterface $response, $args){
        global $app;

        $student = StudentModel::find($args['id']);

        return $app->getContainer()->get('renderer')->render($response, 'edit.phtml', ['student' => $student]);
    }

    public static function update(ServerRequestInterface $request, ResponseInterface $response, $args){
        global $app;

        $student = StudentModel::find($args['id'])->update($request->getParsedBody());

        return $app->getContainer()->get('renderer')->render($response, 'index.phtml', ['students' => $students]);
    }

    public static function delete(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        global $app;

        StudentModel::find($args['id'])->delete();
        $students = StudentModel::all();

        return $app->getContainer()->get('renderer')->render($response, 'index.phtml', ['students' => $students]);
    }
}
