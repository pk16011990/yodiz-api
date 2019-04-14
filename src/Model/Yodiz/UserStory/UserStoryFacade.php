<?php
declare(strict_types=1);

namespace App\Model\Yodiz\UserStory;

use App\Model\Yodiz\YodizClient;
use App\Model\Yodiz\YodizDeserializer;

class UserStoryFacade
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
     * @param int $sprintId
     * @return \App\Model\Yodiz\UserStory\UserStory[]
     */
    public function getSprintUserStories(int $projectId, int $sprintId): array
    {
        $response = $this->yodizClient->doRequest(YodizClient::METHOD_GET, 'projects/' . $projectId . '/sprints/' . $sprintId . '/userstories?fields=id,title,storyPoints,effortLogged,status,owner,tasks,tags,updatedOn');

        $userStories = $this->yodizDeserializer->deserialize($response, UserStory::class . '[]');
        /* @var $userStories \App\Model\Yodiz\UserStory\UserStory[] */

        return $userStories;
    }
}