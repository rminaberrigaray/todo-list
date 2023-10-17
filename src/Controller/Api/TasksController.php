<?php

namespace App\Controller\Api;

use Rest\Controller\RestController;

class TasksController extends RestController
{

    public function list($userId)
    {
        $tasks = $this->Tasks->findByUserId($userId);
        $this->set(compact('tasks'));
    }
}