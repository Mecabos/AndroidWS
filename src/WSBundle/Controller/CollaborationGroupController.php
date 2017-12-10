<?php
/**
 * Created by PhpStorm.
 * User: Mohamed
 * Date: 11/29/2017
 * Time: 9:40 PM
 */

namespace WSBundle\Controller;


use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;
use WSBundle\Entity\CollaborationGroup;

class CollaborationGroupController extends Controller
{

    public function newAction(Request $request)//success
    {

        //Json test
 /*       {
            "name": "group 1",
    "creator": "1"
}*/
        $data=json_decode($request->getContent(),true);
        $errors = array();

        $em=$this->getDoctrine()->getManager();

        $collaborationGroup = new CollaborationGroup();

        if ($request->isMethod('POST')) {
            $name = $data['name'];
            $creationDate = new DateTime();
            $creator = $data['creator'];

            $collaborationGroup->setName($name);
            $collaborationGroup->setCreationDate($creationDate);
            $user = $em->getRepository('WSBundle:User')->find($creator);
            $collaborationGroup->setCreator($user);

            if (count($errors) == 0) {

                $em->persist($collaborationGroup);
                $em->flush();
            }
            return new JsonResponse(array("type"=>"success",'errors' => $errors));


        }
        return new JsonResponse(array("type"=>"failed"));

    }

    public function updateNameAction(Request $request)//success
    {
        //Json test
       /* {
            "id" : "4",
	"name" : "new group"
}
*/

        $data=json_decode($request->getContent(),true);
        $errors = array();

        $em=$this->getDoctrine()->getManager();

        if ($request->isMethod('POST')) {
            $oldName = $data['oldName'];
            $newName = $data['newName'];
            $collaborationGroup = $em->getRepository('WSBundle:CollaborationGroup')->findOneBy(array('name' => $oldName));
            $collaborationGroup->setName($newName);

            if (count($errors) == 0) {

                $em->persist($collaborationGroup);
                $em->flush();
            }
            return new JsonResponse(array("type"=>"success",'errors' => $errors));


        }
        return new JsonResponse(array("type"=>"failed"));

    }

}