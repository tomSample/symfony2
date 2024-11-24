<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/api/home', name: 'app_api_home')]
    public function getHome(): JsonResponse
    {
        $response = $this->client->request('GET', 'http://localhost:1337/api/home?populate=*');
        $content = $response->getContent();

        return new JsonResponse(json_decode($content, true));
    }

    #[Route('/api/comments', name: 'app_api_comments')]
    public function getComments(): JsonResponse
    {
        $response = $this->client->request('GET', 'http://localhost:1337/api/comments?populate=*');
        $content = $response->getContent();

        return new JsonResponse(json_decode($content, true));
    }

    #[Route('/api/projects', name: 'app_api_projects')]
    public function getProjects(): JsonResponse
    {
        $response = $this->client->request('GET', 'http://localhost:1337/api/projects?populate=*');
        $content = $response->getContent();

        return new JsonResponse(json_decode($content, true));
    }

}