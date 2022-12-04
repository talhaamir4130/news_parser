<?php

namespace App\Message;

class ParseNews
{
    /** @var string */
    private $title;

    /** @var string */
    private $picture;

    /** @var string */
    private $description;

    public function __construct(string $title, string $picture, string $description)
    {
        $this->title = $title;
        $this->picture = $picture;
        $this->description = $description;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPicture(): string
    {
        return $this->picture;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }
}
