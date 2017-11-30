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
use Symfony\Component\HttpFoundation\Request;


class ProjectController extends Controller
{
    public function getAllAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        if ($request->isMethod('POST')) {
            $projectsList = $em->getRepository('WSBundle:Project')->findAll();
            $projectsListJson = array();
            foreach ($projectsList as $project) {
                $projectsListJson[] = array(
                    "id" => $project->getId(),
                    "name" => $project->getName(),
                    "creationDate" => $project->getCreationDate()->format("Y/m/d H:m:s"),
                    "startDate" => $project->getStartDate()->format("Y/m/d H:m:s"),
                    "finishDate" => $project->getFinishDate()->format("Y/m/d H:m:s"), //"Y/m/d H:m:s T" for time zone
                    "description" => $project->getDescription(),
                    "shortDescription" => $project->getShortDescription(),
                    "budget" => $project->getBudget(),
                    "currentBudget" => $project->getCurrentBudget(),
                    "equipmentsList" => $project->getEquipmentsList(),
                    "servicesList" => $project->getServicesList(),
                    "isCanceled" => $project->getIsCanceled(),
                );

            }
            return new JsonResponse($projectsListJson);
        }
        return new JsonResponse(array("type" => "failed"));
    }

    public function getByIdAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {

            $id = $data['id'];

            $projectsList = $em->getRepository('WSBundle:Project')->findBy(array('id' => $id));
            $projectsListJson = array();
            foreach ($projectsList as $project) {
                $projectsListJson[] = array(
                    "id" => $project->getId(),
                    "name" => $project->getName(),
                    "creationDate" => $project->getCreationDate()->format("Y/m/d H:m:s"),
                    "startDate" => $project->getStartDate()->format("Y/m/d H:m:s"),
                    "finishDate" => $project->getFinishDate()->format("Y/m/d H:m:s"), //"Y/m/d H:m:s T" for time zone
                    "description" => $project->getDescription(),
                    "shortDescription" => $project->getShortDescription(),
                    "budget" => $project->getBudget(),
                    "currentBudget" => $project->getCurrentBudget(),
                    "equipmentsList" => $project->getEquipmentsList(),
                    "servicesList" => $project->getServicesList(),
                    "isCanceled" => $project->getIsCanceled(),
                );

            }
            return new JsonResponse($projectsListJson);
        }
        return new JsonResponse(array("type" => "failed"));
    }

    public function getByNameAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {

            $name = $data['name'];

            $projectsList = $em->getRepository('WSBundle:Project')->findBy(array('name' => $name));
            $projectsListJson = array();
            foreach ($projectsList as $project) {
                $projectsListJson[] = array(
                    "id" => $project->getId(),
                    "name" => $project->getName(),
                    "creationDate" => $project->getCreationDate()->format("Y/m/d H:m:s"),
                    "startDate" => $project->getStartDate()->format("Y/m/d H:m:s"),
                    "finishDate" => $project->getFinishDate()->format("Y/m/d H:m:s"), //"Y/m/d H:m:s T" for time zone
                    "description" => $project->getDescription(),
                    "shortDescription" => $project->getShortDescription(),
                    "budget" => $project->getBudget(),
                    "currentBudget" => $project->getCurrentBudget(),
                    "equipmentsList" => $project->getEquipmentsList(),
                    "servicesList" => $project->getServicesList(),
                    "isCanceled" => $project->getIsCanceled(),
                );

            }
            return new JsonResponse($projectsListJson);
        }
        return new JsonResponse(array("type" => "failed"));
    }


}