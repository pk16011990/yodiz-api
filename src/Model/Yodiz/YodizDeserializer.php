<?php
declare(strict_types=1);

namespace App\Model\Yodiz;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class YodizDeserializer
{

    /**
     * @var \Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface
     */
    private $classMetadataFactory;

    /**
     * @var \Symfony\Component\Serializer\SerializerInterface|null
     */
    private $serializer;

    public function __construct(ClassMetadataFactoryInterface $classMetadataFactory)
    {
        $this->classMetadataFactory = $classMetadataFactory;
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
            $objectNormalizer = new ObjectNormalizer($this->classMetadataFactory);
            $this->serializer = new Serializer(
                [$objectNormalizer, new ArrayDenormalizer()],
                [new JsonEncoder()]
            );
        }

        return $this->serializer;
    }
}