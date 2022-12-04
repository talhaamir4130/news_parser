<?php

namespace App\Command;

use Goutte\Client;
use App\Message\ParseNews;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CrawlCommand extends Command
{
    /** @var MessageBusInterface */
    private $bus;

    protected static $defaultName = 'app:news:crawl';

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;

        parent::__construct();
    }

    protected function configure()
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = new Client();
        $crawler = $client->request('GET', 'https://highload.today/');

        $bus = $this->bus;
        try {
            $crawler->filter('div[class="lenta-item"]')->each(function (Crawler $node) use ($bus) {
                $title = $node->filter('a > h2')->text();
                $picture = $node->filter('div[class="lenta-image"]')->filter('img')->eq(1)->attr('src');
                $description = $node->filter('p')->eq(2)->text();

                $bus->dispatch(new ParseNews($title, $picture, $description));
            });
        } catch (\Exception $e) {
            // leave as is
        }

        echo 'Parsing is done.';

        return Command::SUCCESS;
    }
}
