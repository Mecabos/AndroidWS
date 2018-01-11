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
            $projectsList = $em->getRepository('WSBundle:Project')->findBy(array(),array('startDate' => 'DESC'));
            $projectsListJson = array();
            foreach ($projectsList as $project) {
                $collaborationGroup = $em->getRepository('WSBundle:CollaborationGroup')->find($project->getCollaborationGroup());
                $category = $em->getRepository('WSBundle:Category')->find($project->getCategory());
                $projectsListJson[] = array(
                    "id" => $project->getId(),
                    "name" => $project->getName(),
                    "creationDate" => $project->getCreationDate()->format("Y/m/d H:i:s"),
                    "startDate" => $project->getStartDate()->format("Y/m/d H:i:s"),
                    "finishDate" => $project->getFinishDate()->format("Y/m/d H:i:s"), //"Y/m/d H:m:s T" for time zone
                    "description" => $project->getDescription(),
                    "shortDescription" => $project->getShortDescription(),
                    "budget" => $project->getBudget(),
                    "currentBudget" => $project->getCurrentBudget(),
                    "equipmentsList" => $project->getEquipmentsList(),
                    "servicesList" => $project->getServicesList(),
                    "isCanceled" => $project->getIsCanceled(),
                    "collaborationGroup" => array(
                        "id" => $collaborationGroup->getId(),
                        "name" => $collaborationGroup->getName(),
                        "creationDate" => $collaborationGroup->getCreationDate()->format("Y/m/d H:i:s"),
                    ),
                    "category" => array(
                        "id" => $category->getId(),
                        "label" => $category->getLabel(),
                        "color" => $category->getColor(),
                    )
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
                $collaborationGroup = $em->getRepository('WSBundle:CollaborationGroup')->find($project->getCollaborationGroup());
                $category = $em->getRepository('WSBundle:Category')->find($project->getCategory());
                $projectsListJson[] = array(
                    "id" => $project->getId(),
                    "name" => $project->getName(),
                    "creationDate" => $project->getCreationDate()->format("Y/m/d H:i:s"),
                    "startDate" => $project->getStartDate()->format("Y/m/d H:i:s"),
                    "finishDate" => $project->getFinishDate()->format("Y/m/d H:i:s"), //"Y/m/d H:m:s T" for time zone
                    "description" => $project->getDescription(),
                    "shortDescription" => $project->getShortDescription(),
                    "budget" => $project->getBudget(),
                    "currentBudget" => $project->getCurrentBudget(),
                    "equipmentsList" => $project->getEquipmentsList(),
                    "servicesList" => $project->getServicesList(),
                    "isCanceled" => $project->getIsCanceled(),
                    "collaborationGroup" => array(
                        "id" => $collaborationGroup->getId(),
                        "name" => $collaborationGroup->getName(),
                        "creationDate" => $collaborationGroup->getCreationDate()->format("Y/m/d H:i:s"),
                    ),
                    "category" => array(
                        "id" => $category->getId(),
                        "label" => $category->getLabel(),
                        "color" => $category->getColor(),
                    )
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
                $collaborationGroup = $em->getRepository('WSBundle:CollaborationGroup')->find($project->getCollaborationGroup());
                $category = $em->getRepository('WSBundle:Category')->find($project->getCategory());
                $projectsListJson[] = array(
                    "id" => $project->getId(),
                    "name" => $project->getName(),
                    "creationDate" => $project->getCreationDate()->format("Y/m/d H:i:s"),
                    "startDate" => $project->getStartDate()->format("Y/m/d H:i:s"),
                    "finishDate" => $project->getFinishDate()->format("Y/m/d H:i:s"), //"Y/m/d H:m:s T" for time zone
                    "description" => $project->getDescription(),
                    "shortDescription" => $project->getShortDescription(),
                    "budget" => $project->getBudget(),
                    "currentBudget" => $project->getCurrentBudget(),
                    "equipmentsList" => $project->getEquipmentsList(),
                    "servicesList" => $project->getServicesList(),
                    "isCanceled" => $project->getIsCanceled(),
                    "collaborationGroup" => array(
                        "id" => $collaborationGroup->getId(),
                        "name" => $collaborationGroup->getName(),
                        "creationDate" => $collaborationGroup->getCreationDate()->format("Y/m/d H:i:s"),
                    ),
                    "category" => array(
                        "id" => $category->getId(),
                        "label" => $category->getLabel(),
                        "color" => $category->getColor(),
                    )
                );

            }
            return new JsonResponse($projectsListJson);
        }
        return new JsonResponse(array("type" => "failed"));
    }

    public function createAction(Request $request)
    {
        $errors = array();
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();

        $project = new Project();

        if ($request->isMethod('POST')) {
            $name = $data['name'];
            $creationDate = new \DateTime();

            $startDate = \DateTime::createFromFormat("Y/m/d H:i:s", $data['startDate']);
            $finishDate = \DateTime::createFromFormat("Y/m/d H:i:s", $data['finishDate']);
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

            return new JsonResponse(array(
                "id" => $project->getId(),
                "name" => $project->getName(),
                "creationDate" => $project->getCreationDate()->format("Y/m/d H:i:s"),
                "startDate" => $project->getStartDate()->format("Y/m/d H:i:s"),
                "finishDate" => $project->getFinishDate()->format("Y/m/d H:i:s"),
                "description" => $project->getDescription(),
                "shortDescription" => $project->getShortDescription(),
                "budget" => $project->getBudget(),
                "currentBudget" => $project->getCurrentBudget(),
                "equipmentsList" => $project->getEquipmentsList(),
                "servicesList" => $project->getServicesList(),
                "isCanceled" => $project->getIsCanceled(),
                "collaborationGroup" => array(
                    "id" => $collaborationGroup->getId(),
                    "name" => $collaborationGroup->getName(),
                    "creationDate" => $collaborationGroup->getCreationDate()->format("Y/m/d H:i:s"),
                ),
                "category" => array(
                    "id" => $category->getId(),
                    "label" => $category->getLabel(),
                    "color" => $category->getColor(),
                )

            ));


        }
        return new JsonResponse(array("type" => "failed", 'errors' => $errors));
    }

    public function getMembersByGroupNameAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();

        if ($request->isMethod('POST')) {

            $projectId = $data['projectId'];
            $project = $em->getRepository('WSBundle:Project')->find($projectId);

            $groupId = $project->getCollaborationGroup();

            $memberList = $em->getRepository('WSBundle:Membership')->findBy(array('CollaborationGroup' => $groupId));


            $userListJson = array();
            foreach ($memberList as $membership) {

                $user = $em->getRepository('WSBundle:User')->find($membership->getUser());

                $userListJson[] = array(
                    "firstName" => $user->getFirstName(),
                    "lastName" => $user->getLastName(),
                    "email" => $user->getEmail(),
                    "id" => $user->getId(),
                    "token" => $user->getToken(),
                );

            }
            return new JsonResponse($userListJson);
        }
        return new JsonResponse(array("type" => "failed"));
    }

}