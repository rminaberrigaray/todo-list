<?php

namespace App\Controller\Api;

use Cake\Event\Event;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

class UsersController extends ApiController
{

    public function initialize() 
    {
        parent::initialize();
        $this->Auth->allow(['add', 'token']);
    }

    public function view() 
    {    
        $this->Crud->on('beforeFind', function(Event $event) {
            $event->getSubject()->query->contain(['Tasks']);
        });
        return $this->Crud->execute();
    }

    public function add()
    {
        $this->Crud->on('afterSave', function(Event $event) {
            if ($event->subject->created) {
                $this->set('data', [
                    'id' => $event->subject->entity->id,
                    'token' => JWT::encode(
                        [
                            'sub' => $event->subject->entity->id,
                            'exp' =>  time() + 604800
                        ],
                    Security::getSalt())
                ]);
                $this->Crud->action()->config('serialize.data', 'data');
            }
        });
        return $this->Crud->execute();
    }

    public function token()
    {
        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Invalid username or password');
        }

        $this->set([
            'success' => true,
            'data' => [
                'token' => JWT::encode([
                    'sub' => $user['id'],
                    'exp' =>  time() + 604800
                ],
                Security::getSalt())
            ],
            '_serialize' => ['success', 'data']
        ]);
    }

}