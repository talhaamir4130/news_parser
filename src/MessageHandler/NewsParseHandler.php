<?php

namespace App\MessageHandler;

use App\Message\ParseNews;
use App\Service\CrawlerService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class NewsParseHandler implements MessageHandlerInterface
{
    /** @var CrawlerService */
    private $crawlService;

    public function __construct(
        CrawlerService $crawlService
    ) {
        $this->crawlService = $crawlService;
    }

    public function __invoke(ParseNews $parseNews): void
    {
        $this->crawlService->saveNews($parseNews->getTitle(), $parseNews->getPicture(), $parseNews->getDescription());
    }
}
