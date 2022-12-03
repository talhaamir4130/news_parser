<?php

namespace App\Command;

use Goutte\Client;
use App\Service\CrawlerService;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CrawlCommand extends Command
{
    /** @var CrawlerService */
    private $crawlerService;

    protected static $defaultName = 'app:news:crawl';

    public function __construct(CrawlerService $crawlerService)
    {
        $this->crawlerService = $crawlerService;

        parent::__construct();
    }

    protected function configure()
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = new Client();
        $crawler = $client->request('GET', 'https://highload.today/');

        $crawlerService = $this->crawlerService;
        try {
            $crawler->filter('div[class="lenta-item"]')->each(function (Crawler $node) use ($crawlerService) {
                $crawlerService->crawlAndSave($node);
            });
        } catch (\Exception $e) {
            // leave as is
        }

        echo 'Parsing is done.';

        return Command::SUCCESS;
    }
}
