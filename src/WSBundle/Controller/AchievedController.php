<?php
/**
 * Created by PhpStorm.
 * User: Mohamed
 * Date: 11/30/2017
 * Time: 2:40 AM
 */

namespace WSBundle\Controller;


use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use WSBundle\Entity\Achieved;

class AchievedController extends Controller
{

    public function getByUserAction(Request $request) //success
    {
        // Json Test
 /*       {
            "id_user" : "3"
}*/
        $data=json_decode($request->getContent(),true);

        $em = $this->getDoctrine()->getManager();

        if ($request->isMethod('POST')) {

            $id_user = $data['id_user'];
            //$id_achievement = $data['id_achievement'];
            $achievedList = $em->getRepository('WSBundle:Achieved')->findBy(array('user' => $id_user));

            $achievedListJson = array();
            foreach ($achievedList as $achieved) {
                $achievement_id = $achieved->getAchievement()->getId();
                $achievement = $em->getRepository('WSBundle:Achievement')->find($achievement_id);

                $achievedListJson[] = array(
                    "achievementDate" => $achieved->getAchievementDate()->format("Y/m/d H:m:s"),
                    "achievementName" => $achievement->getName(),
                    "achievementDescription" => $achievement->getDescription()
                );

            }
            return new JsonResponse($achievedListJson);
        }
        return new JsonResponse(array("type" => "failed"));
    }

    public function addAchievedAction(Request $request) //tested
    {
        // Json test
 /*       {
achievedDate : "",
            "id_user" : "3",
	"id_achievement" : "3"
}*/
        $data=json_decode($request->getContent(),true);
        $errors = array();

        $em=$this->getDoctrine()->getManager();
        $achieved = new Achieved();

        if ($request->isMethod('POST')) {
            $achievedDate = \DateTime::createFromFormat("Y/m/d H:m:s", $data['achievedDate']);
            $id_user = $data['id_user'];
            $user = $em->getRepository('WSBundle:User')->find($id_user);
            $achievement_id = $data['id_achievement'];
            $achievement = $em->getRepository('WSBundle:Achievement')->find($achievement_id);

            $achieved->setUser($user);
            $achieved->setAchievement($achievement);
            $achieved->setAchievementDate($achievedDate);


            if (count($errors) == 0) {

                $em->persist($achieved);
                $em->flush();
            }
            return new JsonResponse(array("type"=>"success",'errors' => $errors));


        }
        return new JsonResponse(array("type"=>"failed"));

    }

}