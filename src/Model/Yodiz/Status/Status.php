<?php
declare(strict_types=1);

namespace App\Model\Yodiz\Status;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Status
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     * @SerializedName("narrative")
     */
    private $title;

    public function __construct(string $code, string $title)
    {
        $this->code = $code;
        $this->title = $title;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function isNew(): bool
    {
        return in_array(strtolower($this->title), ['new', 'in evaluation'], true);
    }

    public function isDone(): bool
    {
        return in_array(strtolower($this->title), ['done', 'completed', 'accepted', 'rejected'], true);
    }

    public function isInProgress(): bool
    {
        return $this->isNew() === false && $this->isDone() === false;
    }

}