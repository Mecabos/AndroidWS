<?php
/**
 * Created by PhpStorm.
 * User: Bacem
 * Date: 12/13/2017
 * Time: 7:34 AM
 */

namespace WSBundle\Controller;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WSBundle\Entity\ProjectMedia;

class MediaController extends Controller
{
    public function projectMediaCreateAction(Request $request)
    {
        //$imagesDir =$request->getBasePath();
        //$imagesDir = $this->get('kernel')->getRootDir() . '/../web/UploadedMedia/Images';
        $data = json_decode($request->getContent(), true);
        $errors = array();

        $em = $this->getDoctrine()->getManager();

        $projectMedia = new ProjectMedia();

        if ($request->isMethod('POST')) {

            $id_project = $data['id_project'];
            $project = $em->getRepository('WSBundle:Project')->find($id_project);
            if ($project != null) {
                $mediaType = $data['media_type'];

                if ($mediaType == "image") {
                    $mediaName = $data['media_name'];
                    $media = $data['media'];
                    $isPrimary = $data['is_primary'];
                    $uploadDate = new \DateTime();
                    $path = "UploadedMedia/Project/Images/" . "Project_" . $project->getId() . "_" . $mediaName . ".png";
                    file_put_contents($path, base64_decode($media));

                    $projectMedia->setName($mediaName);
                    $projectMedia->setPath($request->getBasePath() . "/" . $path);
                    $projectMedia->setUploadDate($uploadDate);
                    $projectMedia->setProject($project);
                    $projectMedia->setIsPrimary($isPrimary);
                    $projectMedia->setType("image");

                    $em->persist($projectMedia);
                    $em->flush();

                    return new JsonResponse(array(
                        "id" => $projectMedia->getId(),
                        "type" => $projectMedia->getType(),
                        "uploadDate" => $projectMedia->getUploadDate()->format("Y/m/d H:m:s"),
                        "path" => $projectMedia->getPath(),
                        "isPrimary" => $projectMedia->getisPrimary(),
                    ));
                }


            } else {
                return new JsonResponse(array("type" => "Project not found"));
            }
        }
        return new JsonResponse(array("type" => "Not a post request"));


    }

    public function getProjectMediaByProjectAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {

            $project_id = $data['id_project'];
            $mediaType = $data['media_type'];
            if ($mediaType == "image"){
                $imagesList = $em->getRepository('WSBundle:ProjectMedia')->findBy(array('project' => $project_id,'type' => 'image'));
                $imagesListJson = array();
                foreach ($imagesList as $image) {

                    $imagesListJson[] = array(
                        "id" => $image->getId(),
                        "type" => $image->getType(),
                        "uploadDate" => $image->getUploadDate()->format("Y/m/d H:m:s"),
                        "path" => $image->getPath(),
                        "isPrimary" => $image->getisPrimary(),
                    );
                }
                return new JsonResponse($imagesListJson);
            }
        }
        return new JsonResponse(array("type" => "Not a post request"));
    }

}