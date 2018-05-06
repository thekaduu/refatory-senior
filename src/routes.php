<?php

use Slim\Http\Request;
use Slim\Http\Response;
use App\Controller\StudentController;

// Routes
$app->group('/students', function() {
    $this->get('', StudentController::class. ':index');

    $this->get('/create', StudentController::class . '::create');
    $this->post('/create', StudentController::class . '::store');
    $this->get('/edit/{id}', StudentController::class . '::edit');
    $this->post('/edit/{id}', StudentController::class . '::update');
    $this->get('/delete/{id}', StudentController::class . '::delete');
});
