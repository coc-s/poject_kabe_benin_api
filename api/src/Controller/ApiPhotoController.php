<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Repository\PhotoRepository;
use App\ResponseModel\PaginatorResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiPhotoController extends AbstractController
{

    private static int $LIMIT_PAGE = 12;
    /**
     * @Route("/api/photos", name="list_Photos", methods={"GET"})
     * 
     */
    public function showPhotos(Request $request, PhotoRepository$photoRepository, SerializerInterface $serializer): Response
    {
        $page = $request->get("page");
        $limit = $request->get("limit");

        if ($limit == null || $limit <= 0)
            $limit = self::$LIMIT_PAGE;
        if ($page == null || $page <= 0)
            $page = 1;

        $totalEments =$photoRepository->count(array());
       $dernierPagePossible = intdiv($totalEments, $limit);
        if ($totalEments % $limit != 0) {
           $dernierPagePossible++;
        }

        if ($page >$dernierPagePossible)
            $page =$dernierPagePossible;
        // limit = 2 et total = 4       page = 4/2(int)=>2
        // limit = 2 et total = 5       page = 5/2(int)=>2
        // 5%2!=0 => page=2+1
        // AA
        // BB
        // CC
        // DD 
        // CC
       $photos =$photoRepository->findBy(
            array(),
            array('id' => 'ASC'),
            $limit,
            ($page - 1) * $limit
        );


        $paginator = new PaginatorResponse();
        $paginator->setPage($page);
        $paginator->setLimit($limit);
        $paginator->setCount($totalEments);
        $paginator->setData($photos);
        $paginator->setLastPage($dernierPagePossible);
       $dataPaginator = $serializer->serialize($paginator, 'json', ['groups' => ["PaginationAdherent"]]);

        return new JsonResponse($dataPaginator, Response::HTTP_OK, [], true);
    }
    /**
     * @Route("/api/photos/count", name="count_Photos", methods={"GET"})
     * 
     */
    public function countPhoto(PhotoRepository$photoRepository, SerializerInterface $serializer): Response
    {

        $count =$photoRepository->count(array());
        return new JsonResponse("{\"nombrePhoto\":$count}", Response::HTTP_OK, [], true);
    }


    /**
     * @Route("/api/photos/{id}", name="Photo_show", methods={"GET"})
     */
    public function showPhoto(Photo$photo, SerializerInterface $serializer): Response
    {
       $data = $serializer->serialize($photo, 'json', ['groups' => ['listAdherentFull']]);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/photos/{id}", name="Photo_delete", methods={"DELETE"})
     */

    public function deletePhoto(Photo$photo, EntityManagerInterface $em): Response
    {
        $em->remove($photo);
        $em->flush();
        return new JsonResponse("Suppression success", Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/photos", name="Photo_create", methods={"POST"})
     */

    public function createPhoto(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator): Response
    {

        $body = $request->getContent();
       $photo = $serializer->deserialize($body, Photo::class, 'json');

        $erreurs = $validator->validate($photo);


        if (count($erreurs) > 0) {
            $erreurJson = $serializer->serialize($erreurs, 'json');
            return new JsonResponse($erreurJson, Response::HTTP_BAD_REQUEST, [], true);
        }

        $em->persist($photo);
        $em->flush();

        $urlResource = $this->generateUrl(
            "Photo_show",
            [
                "id" =>$photo->getId(),
                UrlGeneratorInterface::ABSOLUTE_URL
            ]
        );
        return new JsonResponse(null, Response::HTTP_CREATED, ["location" => $urlResource], false);
    }

    /**
     * @Route("/api/photos/{id}", name="Photo_update", methods={"PUT"})
     */

    public function updatePhoto(Photo $oldPhoto, Request $request, EntityManagerInterface $em, SerializerInterface $serializer): Response
    {
        $body = $request->getContent();
        $serializer->deserialize($body, Photo::class, 'json', ['object_to_populate' => $oldPhoto]);
        $em->persist($oldPhoto);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_OK, [], false);
    }
}
