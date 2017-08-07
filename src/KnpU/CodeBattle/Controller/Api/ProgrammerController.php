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
        $controllers->get('/api/programmers/{nickname}', array($this, 'showAction'))
            ->bind('api_programmers_show');
        $controllers->get('/api/programmers', array($this, 'listAction'));}

    public function newAction(Request $request) {
        $data = json_decode($request->getContent(), true);

        $model = new Programmer();
        $model->nickname = $data['name'];
        $model->avatarNumber = $data['age'];
        $model->powerLevel = $data['age'];
        $model->userId = $this->findUserByUsername('sydorenkovd')->id;

        $this->save($model);
        $programmerUrl = $this->generateUrl(
            'api_programmers_show',
            ['nickname' => $model->nickname]
        );
        $response = new Response(json_encode($model), 201);
        $response->headers->set('Location', $programmerUrl);

        return $response;
    }
    public function showAction($nickname)
    {
        // test case
        $programmer = $this->getProgrammerRepository()->findOneByNickname($nickname);
        if (!$programmer) {
            $this->throw404('Crap! This programmer has deserted! We\'ll send a search party');
        }
        $data = $this->serializeProgrammer($programmer);
        $response = new Response(json_encode($data), 200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function listAction() {
        $programmers = $this->getProgrammerRepository()->findAll();
        $data = array('programmers' => array());
        foreach ($programmers as $programmer) {
            $data['programmers'][] = $this->serializeProgrammer($programmer);
        }

        $response = new Response(json_encode($data), 200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
    private function serializeProgrammer(Programmer $programmer)
    {
        return array(
            'nickname' => $programmer->nickname,
            'avatarNumber' => $programmer->avatarNumber,
            'powerLevel' => $programmer->powerLevel,
            'tagLine' => $programmer->tagLine,
        );
    }
}
