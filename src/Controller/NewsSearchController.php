<?php

namespace App\Controller;

use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewsSearchController extends AbstractController
{
    #[Route('/news/search/{page}', name: 'app_news_search', defaults: ['page' => 1])]
    public function index(EntityManagerInterface $manager, int $page): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MODERATOR');

        return $this->render('news_search/index.html.twig', [
            'news' => $manager->getRepository(News::class)->getNews($page, 10),
            'page' => $page,
        ]);
    }

    #[Route('/news/{id}/delete', name: 'app_news_delete')]
    public function delete(EntityManagerInterface $manager, int $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $news = $manager->getRepository(News::class)->findOneBy(['id' => $id]);

        if (!$news) {
            return $this->redirectToRoute('app_news_search');
        }

        $manager->remove($news);
        $manager->flush();

        return $this->redirectToRoute('app_news_search');
    }
}
