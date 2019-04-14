<?php
declare(strict_types=1);

namespace App\Model\Yodiz;

use App\Model\Yodiz\Task\Task;
use App\Model\Yodiz\UserStory\UserStory;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
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
                'allow_extra_attributes' => true,
                'default_constructor_arguments' => [
                    UserStory::class => [
                        'owner' => null,
                        'tasks' => [],
                        'tags' => [],
                    ],
                    Task::class => [
                        'owner' => null,
                    ],
                ]
            ]
        );
    }

    protected function getSerializer(): SerializerInterface
    {
        if ($this->serializer === null) {
            $this->serializer = new Serializer(
                [
                    new DateTimeNormalizer([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d\TH:i:s.vO']),
                    new ArrayDenormalizer(),
                    $this->objectNormalizer,
                ],
                [
                    new JsonEncoder()
                ]
            );
        }

        return $this->serializer;
    }
}