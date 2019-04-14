<?php
declare(strict_types=1);

namespace App\Model\Yodiz\Sprint;

use App\Model\Yodiz\YodizClient;
use App\Model\Yodiz\YodizDeserializer;

class SprintFacade
{

    /**
     * @var \App\Model\Yodiz\YodizClient
     */
    private $yodizClient;

    /**
     * @var \App\Model\Yodiz\YodizDeserializer
     */
    private $yodizDeserializer;

    public function __construct(
        YodizClient $yodizClient,
        YodizDeserializer $yodizDeserializer
    )
    {
        $this->yodizClient = $yodizClient;
        $this->yodizDeserializer = $yodizDeserializer;
    }

    /**
     * @param int $projectId
     * @return \App\Model\Yodiz\Sprint\Sprint[]
     */
    public function getProjectSprints(int $projectId): array
    {
        $response = $this->yodizClient->doRequest(YodizClient::METHOD_GET, 'projects/' . $projectId . '/sprints?fields=id,title,status');

        $sprints = $this->yodizDeserializer->deserialize($response, Sprint::class . '[]');
        /* @var $sprints \App\Model\Yodiz\Sprint\Sprint[] */

        return $sprints;
    }
}