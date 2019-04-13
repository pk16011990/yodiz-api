<?php
declare(strict_types=1);

namespace App\Model\Yodiz\Project;

class Project
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $label;

    public function __construct(int $id, string $title, string $label)
    {
        $this->id = $id;
        $this->title = $title;
        $this->label = $label;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLabel(): string
    {
        return $this->label;
    }
}