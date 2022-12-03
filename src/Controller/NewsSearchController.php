<?php

namespace App\Controller;

use Goutte\Client;
use App\Entity\News;
use App\Service\CrawlerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewsSearchController extends AbstractController
{
    #[Route('/news/search', name: 'app_news_search')]
    public function index(CrawlerService $crawlerService): Response
    {
        $client = new Client();
        $crawler = $client->request('GET', 'https://highload.today/');

        $crawler->filter('div[class="lenta-item"]')->each(function (Crawler $node) use ($crawlerService) {
            $crawlerService->crawlAndSave($node);
            dd('done');
        });

        return $this->render('news_search/index.html.twig', [
            'controller_name' => 'NewsSearchController',
        ]);
    }
}
