<?php
declare(strict_types=1);

namespace App\Model\Yodiz\Sprint;

use App\Model\Yodiz\Status\Status;

class Sprint
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
     * @param int $id
     * @param string $title
     * @param \App\Model\Yodiz\Status\Status $status
     */
    public function __construct(int $id, string $title, Status $status)
    {
        $this->id = $id;
        $this->title = $title;
        $this->status = $status;
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
}