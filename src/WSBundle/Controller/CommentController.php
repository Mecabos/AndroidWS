<?php

namespace WSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use WSBundle\Entity\Comment;

class CommentController extends Controller
{
/*{
"text": "This project is so good! i'm hyped",
"id_user": 1,
"id_project": 1
}*/
    public function createAction(Request $request)
    {
        $errors = array();
        $data = json_decode($request->getContent(), true);

        $em=$this->getDoctrine()->getManager();

        $comment = new Comment();

        if ($request->isMethod('POST')) {
            $text = $data['text'];
            $commentDate = new \DateTime();
            $email_user = $data['email_user'];
            $user = $em->getRepository('WSBundle:User')->findOneBy(array('email'=>$email_user));
            $id_project = $data['id_project'];
            $project = $em->getRepository('WSBundle:Project')->find($id_project);

            $comment->setCommentDate($commentDate);
            $comment->setText($text) ;
            $comment->setProject($project) ;
            $comment->setUser($user) ;

            if (count($errors) == 0) {
                $em->persist($comment);
                $em->flush();
            }
            return new JsonResponse(array(
                "id" => $comment->getId(),
                "text" => $comment->getText(),
                "commentDate" => $comment->getCommentDate()->format("Y/m/d H:m:s"),
                "user" => array(
                    "id" => $user->getId(),
                    "firstName" => $user->getFirstName(),
                    "lastName" => $user->getLastName(),
                    "email" => $user->getEmail()
                )
            ));


        }
        return new JsonResponse(array("type"=>"failed",'errors' => $errors));
    }

    public function getByProjectAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {

            $project_id = $data['project_id'];

            $commentsList = $em->getRepository('WSBundle:Comment')->findBy(array('project' => $project_id), array('commentDate' => 'DESC'));
            $commentsListJson = array();
            foreach ($commentsList as $comment) {
                $user = $em->getRepository('WSBundle:User')->find($comment->getUser());
                $commentsListJson[] = array(
                    "id" => $comment->getId(),
                    "text" => $comment->getText(),
                    "commentDate" => $comment->getCommentDate()->format("Y/m/d H:m:s"),
                    "user" => array(
                        "id" => $user->getId(),
                        "firstName" => $user->getFirstName(),
                        "lastName" => $user->getLastName(),
                        "email" => $user->getEmail()
                    )
                );
            }
            return new JsonResponse($commentsListJson);
        }
        return new JsonResponse(array("type" => "failed"));
    }
    public function getByUserAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {

            $user_id = $data['user_id'];

            $commentsList = $em->getRepository('WSBundle:Comment')->findBy(array('user' => $user_id));
            $commentsListJson = array();
            foreach ($commentsList as $comment) {
                $project = $em->getRepository('WSBundle:Project')->find($comment->getProject());
                $commentsListJson[] = array(
                    "id" => $comment->getId(),
                    "text" => $comment->getText(),
                    "commentDate" => $comment->getCommentDate()->format("Y/m/d H:m:s"),
                    "project" => $project->getId()
                );
            }
            return new JsonResponse($commentsListJson);
        }
        return new JsonResponse(array("type" => "failed"));
    }

}
