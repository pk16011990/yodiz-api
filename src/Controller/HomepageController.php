<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Yodiz\Project\ProjectFacade;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomepageController extends AbstractController
{
    public function index(Request $request, ProjectFacade $projectFacade): Response
    {
        $activeProjectId = $request->get('projectId');
        $projects = $projectFacade->getAllProjects();

        return $this->render('Homepage/index.html.twig', [
            'activeProjectId' => $activeProjectId,
            'projects' => $projects,
        ]);
    }
}