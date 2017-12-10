<?php

namespace WSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    public function getAllAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->isMethod('GET')) {
            $categoriesList = $em->getRepository('WSBundle:Category')->findAll();
            $categoriesListJson = array();
            foreach ($categoriesList as $category) {
                $categoriesListJson[] = array(
                    "id" => $category->getId(),
                    "label" => $category->getLabel(),
                    "color" => $category->getColor(),
                );
            }
            return new JsonResponse($categoriesListJson);
        }
        return new JsonResponse(array("type" => "failed"));
    }
}
