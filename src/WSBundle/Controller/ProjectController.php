<?php
/**
 * Created by PhpStorm.
 * User: Bacem
 * Date: 11/13/2017
 * Time: 9:36 PM
 */

namespace WSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;
use WSBundle\Entity\Project;

class ProjectController extends Controller
{
    public function projectGetAllAction()
    {

        $em = $this->getDoctrine()->getManager();
        $projectsList = $em->getRepository('WSBundle:Project')->findAll();
        $projectsListJson = array();
        foreach ($projectsList as $project) {
            $projectsListJson[] = array(
                "id" => $project->getId(),
                "name" => $project->getName(),
                "creationDate" => $project->getCreationDate()->format("Y/m/d H:m:s"),
                "startDate" => $project->getStartDate()->format("Y/m/d H:m:s"),
                "finishDate" => $project->getFinishDate()->format("Y/m/d H:m:s"), //"Y/m/d H:m:s T" for timme zone
                "description" => $project->getDescription(),
                "shortDescription" => $project->getShortDescription(),
                "budget" => $project->getBudget(),
                "currentBudget" => $project->getCurrentBudget(),
                "equipmentsList" => $project->getEquipmentsList(),
                "servicesList" => $project->getServicesList(),
            );

        }
        return new JsonResponse($projectsListJson);
    }

}