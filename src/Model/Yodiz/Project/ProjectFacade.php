<?php
declare(strict_types=1);

namespace App\Model\Yodiz\Project;

use App\Model\Yodiz\YodizClient;
use App\Model\Yodiz\YodizDeserializer;

class ProjectFacade
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
     * @return \App\Model\Yodiz\Project\Project[]
     */
    public function getAllProjects(): array
    {
        $response = $this->yodizClient->doRequest(YodizClient::METHOD_GET, 'projects?fields=id,title,label');

        $projects = $this->yodizDeserializer->deserialize($response, Project::class . '[]');
        /* @var $projects \App\Model\Yodiz\Project\Project[] */

        return $projects;
    }
}