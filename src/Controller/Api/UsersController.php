<?php

namespace App\Controller\Api;

use Rest\Controller\RestController;

class UsersController extends RestController
{

    public function list()
    {
        $users = $this->Users->find();
        $this->set(compact('users'));
    }
}