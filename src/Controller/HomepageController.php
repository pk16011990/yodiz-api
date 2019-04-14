<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Yodiz\Project\ProjectFacade;
use App\Model\Yodiz\Sprint\SprintFacade;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomepageController extends AbstractController
{
    public function index(
        Request $request,
        ProjectFacade $projectFacade,
        SprintFacade $sprintFacade
    ): Response
    {
        $activeProjectId = $request->get('projectId');
        $activeProjectId = $activeProjectId !== null ? (int)$activeProjectId : null;
        $activeSprintId = $request->get('sprintId');
        $activeSprintId = $activeSprintId !== null ? (int)$activeSprintId : null;
        $projects = $projectFacade->getAllProjects();

        $sprints = null;
        if ($activeProjectId !== null) {
            $sprints = $sprintFacade->getProjectSprints($activeProjectId);
        }

        return $this->render('Homepage/index.html.twig', [
            'activeProjectId' => $activeProjectId,
            'activeSprintId' => $activeSprintId,
            'projects' => $projects,
            'sprints' => $sprints,
        ]);
    }
}