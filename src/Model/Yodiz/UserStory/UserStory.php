<?php
declare(strict_types=1);

namespace App\Model\Yodiz\UserStory;

use App\Model\Yodiz\Status\Status;
use App\Model\Yodiz\User\User;

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
     * @var \App\Model\Yodiz\User\User|null
     */
    private $owner;

    /**
     * @var \App\Model\Yodiz\Task\Task[]
     */
    private $tasks;

    /**
     * @var \App\Model\Yodiz\Tag\Tag[]
     */
    private $tags;

    /**
     * @var \DateTimeImmutable
     */
    private $updatedOn;

    /**
     * @param int $id
     * @param string $title
     * @param \App\Model\Yodiz\Status\Status $status
     * @param string $storyPoints
     * @param float $effortLogged
     * @param \App\Model\Yodiz\Task\Task[] $tasks
     * @param \App\Model\Yodiz\Tag\Tag[] $tags
     * @param \DateTimeImmutable $updatedOn
     */
    public function __construct(
        int $id,
        string $title,
        Status $status,
        string $storyPoints,
        float $effortLogged,
        array $tasks,
        array $tags,
        \DateTimeImmutable $updatedOn
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->status = $status;
        $this->storyPoints = $storyPoints;
        $this->effortLogged = $effortLogged;
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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return \App\Model\Yodiz\Task\Task[]
     */
    public function getTasks(): array
    {
        return $this->tasks;
    }

    /**
     * @return \App\Model\Yodiz\Tag\Tag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    public function getUpdatedOn(): \DateTimeImmutable
    {
        return $this->updatedOn;
    }

    public function getLastChangeOn(): \DateTimeImmutable
    {
        $allDateTimes = [
            $this->updatedOn,
        ];

        foreach ($this->tasks as $task) {
            $allDateTimes[] = $task->getUpdatedOn();
        }

        return max($allDateTimes);
    }

    /**
     * @return \App\Model\Yodiz\Task\Task[]
     */
    public function getInProgressTasks(): array
    {
        $inProgressTasks = [];

        foreach ($this->tasks as $task) {
            if ($task->isInProgress()) {
                $inProgressTasks[] = $task;
            }
        }

        return $inProgressTasks;
    }

}