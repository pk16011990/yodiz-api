<?php
declare(strict_types=1);

namespace App\Model\Yodiz\Tag;

class Tag
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    public function __construct(string $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

}