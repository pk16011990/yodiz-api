<?php
declare(strict_types=1);

namespace App\Model\Yodiz\UserStory;

use App\Model\Yodiz\Status\Status;

class UserStory
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
     * @var \App\Model\Yodiz\Status\Status
     */
    private $status;

    /**
     * @var string
     */
    private $storyPoints;

    /**
     * @var float
     */
    private $effortLogged;

    /**
     * @var array
     */
    private $owner;

    /**
     * @var array
     */
    private $tasks;

    /**
     * @var array
     */
    private $tags;

    /**
     * @var string
     */
    private $updatedOn;

    /**
     * @param int $id
     * @param string $title
     * @param \App\Model\Yodiz\Status\Status $status
     * @param string $storyPoints
     * @param float $effortLogged
     * @param array $owner
     * @param array $tasks
     * @param array $tags
     * @param string $updatedOn
     */
    public function __construct(
        int $id,
        string $title,
        Status $status,
        string $storyPoints,
        float $effortLogged,
        array $owner,
        array $tasks,
        array $tags,
        string $updatedOn
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->status = $status;
        $this->storyPoints = $storyPoints;
        $this->effortLogged = $effortLogged;
        $this->owner = $owner;
        $this->tasks = $tasks;
        $this->tags = $tags;
        $this->updatedOn = $updatedOn;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getStoryPoints(): string
    {
        return $this->storyPoints;
    }

    public function getEffortLogged(): float
    {
        return $this->effortLogged;
    }

    public function getOwner(): array
    {
        return $this->owner;
    }

    /**
     * @return array
     */
    public function getTasks(): array
    {
        return $this->tasks;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    public function getUpdatedOn(): string
    {
        return $this->updatedOn;
    }

}