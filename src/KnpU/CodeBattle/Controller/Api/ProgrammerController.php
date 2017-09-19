<?php

namespace KnpU\CodeBattle\Controller\Api;

use KnpU\CodeBattle\Api\ApiProblem;
use KnpU\CodeBattle\Api\ApiProblemException;
use KnpU\CodeBattle\Controller\BaseController;
use KnpU\CodeBattle\Model\Programmer;
use Silex\Application;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ProgrammerController extends BaseController
{
    protected function addRoutes(ControllerCollection $controllers)
    {
        $controllers->post('/api/programmers', array($this, 'newAction'));
        $controllers->get('/api/programmers/{nickname}', array($this, 'showAction'))
            ->bind('api_programmers_show');
        $controllers->get('/api/programmers', array($this, 'listAction'));
        $controllers->put('/api/programmers/{nickname}', array($this, 'updateAction'));
        $controllers->delete('/api/programmers/{nickname}', array($this, 'deleteAction'));
        $controllers->match('/api/programmers/{nickname}', array($this, 'updateAction'))
            ->method('PATCH');
    }

    public function deleteAction($nickname)
    {
        // ...
        $programmer = $this->getProgrammerRepository()->findOneByNickname($nickname);
        if ($programmer) {
            $this->delete($programmer);
        }

        return new Response(null, 204);
    }

//    public function showAction($nickname)
//    {
//        throw new \Exception('I made a mistake!');
//    }

    public function newAction(Request $request) {
        $data = json_decode($request->getContent(), true);

        $model = new Programmer();
     $this->handleRequest($request, $model);

        if ($errors = $this->validate($model)) {
            $this->throwApiProblemValidationException($errors);
        }
        $this->save($model);
        $programmerUrl = $this->generateUrl(
            'api_programmers_show',
            ['nickname' => $model->nickname]
        );
        $response = $this->createApiResponse($model, 201);
        $response->headers->set('Location', $programmerUrl);

        return $response;
    }

    private function throwApiProblemValidationException(array $errors)
    {
        $apiProblem = new ApiProblem(
            400,
            ApiProblem::TYPE_VALIDATION_ERROR
        );
        $apiProblem->set('errors', $errors);

        throw new ApiProblemException($apiProblem);
    }

    public function updateAction($nickname, Request $request) {
        $data = json_decode($request->getContent(), true);
        $model = $this->getProgrammerRepository()->findOneByNickname($nickname);;
        $this->handleRequest($request, $model);
        if ($errors = $this->validate($model)) {
            $this->throwApiProblemValidationException($errors);
        }
        $this->save($model);
        $response = $this->createApiResponse($model, 200);

        return $response;
    }
    public function showAction($nickname)
    {
        // test case
        $programmer = $this->getProgrammerRepository()->findOneByNickname($nickname);
        if (!$programmer) {
            $this->throw404('Crap! This programmer has deserted! We\'ll send a search party');
        }
        $response = $this->createApiResponse($programmer, 200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function listAction() {
        $programmers = $this->getProgrammerRepository()->findAll();
        $data = array('programmers' => $programmers);
        $response = $this->createApiResponse($programmers, 201);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    private function handleRequest(Request $request, Programmer $programmer)
    {
        $data = json_decode($request->getContent(), true);
        $isNew = !$programmer->id;

        if ($data === null) {
            $problem = new ApiProblem(
                400,
                ApiProblem::TYPE_INVALID_REQUEST_BODY_FORMAT
            );
            throw new ApiProblemException($problem);
        }

        // determine which properties should be changeable on this request
        $apiProperties = array('avatarNumber', 'tagLine');
        if ($isNew) {
            $apiProperties[] = 'nickname';
        }

        // update the properties
        foreach ($apiProperties as $property) {
            if (!isset($data[$property]) && $request->isMethod('PATCH')) {
                continue;
            }
            $val = isset($data[$property]) ? $data[$property] : null;
            $programmer->$property = $val;
        }

        $programmer->userId = $this->findUserByUsername('sydorenkovd')->id;
    }
}
