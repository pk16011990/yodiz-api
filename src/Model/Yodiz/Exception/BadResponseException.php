<?php
declare(strict_types=1);

namespace App\Model\Yodiz\Exception;

class BadResponseException extends \Exception
{
    /**
     * @var array
     */
    private $requestOptions;

    /**
     * @var int
     */
    private $responseStatusCode;

    public function __construct(string $requestMethod, string $requestUri, array $requestOptions, int $responseStatusCode)
    {
        $message = sprintf(
            'Request %s to `%s` was not successful wit response code %d',
            $requestMethod,
            $requestUri,
            $responseStatusCode
        );
        parent::__construct($message);
        $this->requestOptions = $requestOptions;
        $this->responseStatusCode = $responseStatusCode;
    }

    public function getRequestOptions(): array
    {
        return $this->requestOptions;
    }

    /**
     * @return int
     */
    public function getResponseStatusCode(): int
    {
        return $this->responseStatusCode;
    }
}