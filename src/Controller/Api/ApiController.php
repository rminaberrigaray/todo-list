<?php
namespace App\Controller\Api;

use Cake\Controller\Controller;
use Crud\Controller\ControllerTrait;

class ApiController extends Controller {

    use ControllerTrait;

    public $components = [
        'RequestHandler',
        'Crud.Crud' => [
            'actions' => [
                'Crud.Index',
                'Crud.View',
                'Crud.Add',
                'Crud.Edit',
                'Crud.Delete'
            ],
            'listeners' => [
                'Crud.Api',
            ]
        ]
    ];
}