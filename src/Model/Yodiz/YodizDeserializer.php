<?php
declare(strict_types=1);

namespace App\Model\Yodiz;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class YodizDeserializer
{
    /**
     * @var \Symfony\Component\Serializer\SerializerInterface|null
     */
    private $serializer;

    /**
     * @var \Symfony\Component\Serializer\Normalizer\ObjectNormalizer
     */
    private $objectNormalizer;

    public function __construct(ObjectNormalizer $objectNormalizer)
    {
        $this->objectNormalizer = $objectNormalizer;
    }

    public function deserialize(string $response, string $type)
    {
        $serializer = $this->getSerializer();

        return $serializer->deserialize(
            $response,
            $type,
            'json',
            [
                'allow_extra_attributes' => false,
            ]
        );
    }

    protected function getSerializer(): SerializerInterface
    {
        if ($this->serializer === null) {
            $this->serializer = new Serializer(
                [$this->objectNormalizer, new ArrayDenormalizer()],
                [new JsonEncoder()]
            );
        }

        return $this->serializer;
    }
}