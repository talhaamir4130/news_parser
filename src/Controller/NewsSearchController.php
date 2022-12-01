<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsSearchController extends AbstractController
{
    #[Route('/news/search', name: 'app_news_search')]
    public function index(): Response
    {
        return $this->render('news_search/index.html.twig', [
            'controller_name' => 'NewsSearchController',
        ]);
    }
}
