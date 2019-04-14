<?php
declare(strict_types=1);

namespace App\Model\Yodiz;

use App\Model\Yodiz\Exception\BadResponseException;
use GuzzleHttp\ClientInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class YodizClient
{
    private const CACHE_KEY_API_TOKEN = 'API_TOKEN';

    public const METHOD_GET = 'get';
    public const METHOD_POST = 'post';
    public const METHOD_PUT = 'put';
    public const METHOD_DELETE = 'delete';

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    private $quzzleClient;

    /**
     * @var \Symfony\Component\Cache\Adapter\AdapterInterface
     */
    private $requestCache;

    /**
     * @var string
     */
    private $yodizApiKey;

    /**
     * @var string
     */
    private $yodizUserEmail;

    /**
     * @var string
     */
    private $yodizUserPassword;

    public function __construct(
        ClientInterface $quzzleClient,
        AdapterInterface $requestCache,
        string $yodizApiKey,
        string $yodizUserEmail,
        string $yodizUserPassword
    )
    {
        $this->quzzleClient = $quzzleClient;
        $this->requestCache = $requestCache;
        $this->yodizApiKey = $yodizApiKey;
        $this->yodizUserEmail = $yodizUserEmail;
        $this->yodizUserPassword = $yodizUserPassword;
    }

    public function doRequest(string $method, string $uri, ?array $data = null, bool $canUseCache = true): string
    {
        if ($canUseCache === true) {
            $cacheKey = $this->getRequestCacheKey($method, $uri, $data);
            $responseCacheItem = $this->requestCache->getItem($cacheKey);
            if ($responseCacheItem->isHit() === true) {
                return $responseCacheItem->get();
            }
        }

        try {
            return $this->request($method, $uri, $data);
        } catch (BadResponseException $badResponseException) {
            if (in_array($badResponseException->getResponseStatusCode(), [400, 401], true) === true) {
                $this->authenticate();
                return $this->request($method, $uri, $data);
            }

            throw $badResponseException;
        }
    }

    private function request(string $method, string $uri, ?array $data = null): string
    {
        $options = [
            'headers' => [
                'Accept' => 'application/json',
                'api-key' => $this->yodizApiKey,
            ],
        ];
        $apiTokenCacheItem = $this->requestCache->getItem(self::CACHE_KEY_API_TOKEN);
        if ($apiTokenCacheItem->isHit() === true) {
            $options['headers']['api-token'] = $apiTokenCacheItem->get();
        }
        $apiTokenCacheItem->get();
        if ($data !== null) {
            if ($method === self::METHOD_GET) {
                $options['query'] = $data;
            } else {
                $options['json'] = $data;
            }
        }
        $response = $this->quzzleClient->request($method, $uri, $options);
        if ($response->getStatusCode() !== 200) {
            throw new BadResponseException($method, $uri, $options, $response->getStatusCode());
        }

        $responseContent = $response->getBody()->getContents();
        if ($method === self::METHOD_GET) {
            $cacheKey = $this->getRequestCacheKey($method, $uri, $data);
            $responseCacheItem = $this->requestCache->getItem($cacheKey);
            $responseCacheItem->set($responseContent);
            $this->requestCache->save($responseCacheItem);
        }

        return $responseContent;
    }

    protected function getRequestCacheKey(string $method, string $uri, ?array $data): string
    {
        return str_replace(['{', '}', '(', ')', '/', "\\", '@', ':'], '_', $uri)
            . '__' . $method
            . '__' . sha1($uri . '--' . \GuzzleHttp\json_encode($data));
    }

    private function authenticate(): void
    {
        $this->requestCache->deleteItem(self::CACHE_KEY_API_TOKEN);

        $response = $this->request(self::METHOD_POST, 'login', [
            'email' => $this->yodizUserEmail,
            'password' => $this->yodizUserPassword,
        ]);
        $responseArray = \GuzzleHttp\json_decode($response, true);

        $apiTokenCacheItem = $this->requestCache->getItem(self::CACHE_KEY_API_TOKEN);
        $apiTokenCacheItem->set($responseArray['api-token']);
        $this->requestCache->save($apiTokenCacheItem);
    }

}