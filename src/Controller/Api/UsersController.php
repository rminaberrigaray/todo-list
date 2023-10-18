<?php

namespace App\Controller\Api;

class UsersController extends ApiController
{

    public function view() {
    
        $this->Crud->on('beforeFind', function(\Cake\Event\Event $event) {
            $event->getSubject()->query->contain(['Tasks']);
        });
        return $this->Crud->execute();
    }

}