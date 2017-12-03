<?php
/**
 * Created by PhpStorm.
 * User: Bacem
 * Date: 11/13/2017
 * Time: 9:36 PM
 */

namespace WSBundle\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use WSBundle\Entity\Project;


class ProjectController extends Controller
{
    public function getAllAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        if ($request->isMethod('GET')) {
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
//TODO:Add category to the return
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

/*{
"name": "Project #3",
"startDate": "2017/10/01 12:00:00",
"finishDate": "2017/11/01 12:30:00",
"description": "A lonnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnng Description",
"shortDescription": "A short Description",
"budget": 475,
"equipementsList": "Equipement#1\nEquipement#2\nEquipement#3\nEquipement#4\nEquipement#5",
"servicesList": "Service#1\nService#2\nService#3",
"id_category": 2,
"id_group" : 2
}*/
    public function createAction(Request $request)
    {
        $errors = array();
        $data = json_decode($request->getContent(), true);

        $em=$this->getDoctrine()->getManager();

        $project = new Project();

        if ($request->isMethod('POST')) {
            $name = $data['name'];
            $creationDate = new \DateTime();

            $startDate = \DateTime::createFromFormat("Y/m/d H:m:s", $data['startDate']);
            $finishDate = \DateTime::createFromFormat("Y/m/d H:m:s", $data['finishDate']);
            $description = $data['description'];
            $shortDescription = $data['shortDescription'];
            $budget = $data['budget'];
            $equipementsList = $data['equipementsList'];
            $servicesList = $data['servicesList'];
            $id_category = $data['id_category'];
            $category = $em->getRepository('WSBundle:Category')->find($id_category);
            $id_collaborationGroup = $data['id_group'];
            $collaborationGroup = $em->getRepository('WSBundle:CollaborationGroup')->find($id_collaborationGroup);


            $project->setName($name);
            $project->setCreationDate($creationDate);
            $project->setStartDate($startDate);
            $project->setFinishDate($finishDate);
            $project->setDescription($description);
            $project->setShortDescription($shortDescription);
            $project->setBudget($budget);
            $project->setEquipmentsList($equipementsList);
            $project->setServicesList($servicesList);
            $project->setCategory($category);
            $project->setCollaborationGroup($collaborationGroup);



            if (count($errors) == 0) {

                $em->persist($project);
                $em->flush();
            }
            return new JsonResponse(array("type"=>"success",'errors' => $errors));


        }
        return new JsonResponse(array("type"=>"failed",'errors' => $errors));
    }




}