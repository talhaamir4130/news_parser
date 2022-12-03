<?php

namespace App\Service;

use App\Entity\News;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function crawlAndSave(Crawler $node): void
    {
        $title = $node->filter('a > h2')->text();
        $picture = $node->filter('div[class="lenta-image"]')->filter('img')->eq(1)->attr('src');
        $description = $node->filter('p')->eq(2)->text();

        $dbNews = $this->getNews($title);
        if (!is_null($dbNews)) {
            $dbNews->setCreatedAt(new DateTimeImmutable());
            $dbNews->setPicture($picture);
            $dbNews->setDescription($description);

            $this->entityManager->flush();

            return;
        }

        $news = new News();
        $news->setTitle($title);
        $news->setPicture($picture);
        $news->setDescription($description);

        $this->entityManager->persist($news);
        $this->entityManager->flush();
    }

    private function getNews(string $title): ?News
    {
        $newsRepo = $this->entityManager->getRepository(News::class);
        return $newsRepo->findOneBy(['title' => $title]);
    }
}
