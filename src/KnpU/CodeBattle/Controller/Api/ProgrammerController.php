<?php

namespace KnpU\CodeBattle\Controller\Api;

use KnpU\CodeBattle\Controller\BaseController;
use KnpU\CodeBattle\Model\Programmer;
use Silex\Application;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProgrammerController extends BaseController
{
    protected function addRoutes(ControllerCollection $controllers)
    {
        $controllers->post('/api/programmers', array($this, 'newAction'));
    }

    public function newAction(Request $request) {
        $data = json_decode($request->getContent(), true);

        $model = new Programmer();
        $model->nickname = $data['name'];
        $model->avatarNumber = $data['age'];
        $model->powerLevel = $data['age'];
        $model->userId = $this->findUserByUsername('sydorenkovd')->id;

        $this->save($model);

        $response = new Response('works fo sure', 201);
        $response->headers->set('Location', '/programmers/locatiomn');

        return $response;
    }
}
