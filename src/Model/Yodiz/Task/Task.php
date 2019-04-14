<?php
declare(strict_types=1);

namespace App\Model\Yodiz\Task;

use App\Model\Yodiz\Status\Status;
use App\Model\Yodiz\User\User;

class Task
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
     * @var float
     */
    private $effortLogged;

    /**
     * @var \App\Model\Yodiz\User\User|null
     */
    private $owner;

    /**
     * @var \App\Model\Yodiz\Status\Status
     */
    private $status;

    /**
     * @var \DateTimeImmutable
     */
    private $updatedOn;

    public function __construct(
        int $id,
        string $title,
        float $effortLogged,
        Status $status,
        \DateTimeImmutable $updatedOn
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->effortLogged = $effortLogged;
        $this->status = $status;
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

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getUpdatedOn(): \DateTimeImmutable
    {
        return $this->updatedOn;
    }

}