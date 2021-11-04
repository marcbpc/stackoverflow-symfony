<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class StackOverflowController
 * Get info from stackoverlow forums
 * @package App\Controller
 *
 */
class StackOverflowController extends AbstractController {
    private string  $url;
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
        $this->url = '';
    }

    /**
     * @Route("/api/stackoverflow", name="get_all_stackoverflow", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $response = $this->client->request(
            'GET',
            $this->url
        );

        if ($response->getStatusCode() == 200) {
            $content = $response->getContent();
            $jsonContent = json_decode($content);
        }

        return new JsonResponse($jsonContent, Response::HTTP_OK);
    }

    /**
     * GET answer/{id}
     * get information of an answer if an id is provided
     * @Route("/api/stackoverflow/answer/{id}", name="get_answer_stackoverflow", methods={"GET"})
     */
    public function answer(int $id)
    {
        $this->url = 'https://api.stackexchange.com/2.3/answers/' . $id . '?order=desc&sort=activity&site=stackoverflow';
        $response = $this->client->request(
            'GET',
            $this->url
        );

        if ($response->getStatusCode() == 200) {
            $content = $response->getContent();
            $jsonContent = json_decode($content);
        }

        return new JsonResponse($jsonContent, Response::HTTP_OK);
    }

    /**
     * GET answer/{id}
     * get information of a questions if an id is provided
     * @Route("/api/stackoverflow/questions/{id}", name="get_questions_stackoverflow", methods={"GET"})
     */
    public function questions(int $id)
    {
        $this->url = 'https://api.stackexchange.com/2.3/questions/' . $id . '/comments?order=desc&sort=activity&site=stackoverflow';
        
        $jsonContent = (object)[];

        $response = $this->client->request(
            'GET',
            $this->url
        );

        if ($response->getStatusCode() == 200) {
            $content = $response->getContent();
            $jsonContent = json_decode($content);
        }

        return new JsonResponse($jsonContent, Response::HTTP_OK);
    }
}

?>