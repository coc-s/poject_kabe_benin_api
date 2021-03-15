<?php

namespace App\Controller;

use App\Entity\Parrainage;
use App\Repository\ParrainageRepository;
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

class ApiParrainageController extends AbstractController
{

    private static int $LIMIT_PAGE = 12;
    /**
     * @Route("/api/parrainages", name="list_parrainages", methods={"GET"})
     * 
     */
    public function showParrainages(Request $request, ParrainageRepository $parrainageRepository, SerializerInterface $serializer): Response
    {
        $page = $request->get("page");
        $limit = $request->get("limit");

        if ($limit == null || $limit <= 0)
            $limit = self::$LIMIT_PAGE;
        if ($page == null || $page <= 0)
            $page = 1;

        $totalEments = $parrainageRepository->count(array());
        $dernierPagePossible = intdiv($totalEments, $limit);
        if ($totalEments % $limit != 0) {
            $dernierPagePossible++;
        }

        if ($page > $dernierPagePossible)
            $page = $dernierPagePossible;
 
        $parrainages = $parrainageRepository->findBy(
            array(),
            array('id' => 'ASC'),
            $limit,
            ($page - 1) * $limit
        );


        $paginator = new PaginatorResponse();
        $paginator->setPage($page);
        $paginator->setLimit($limit);
        $paginator->setCount($totalEments);
        $paginator->setData($parrainages);
        $paginator->setLastPage($dernierPagePossible);
        $dataPaginator = $serializer->serialize($paginator, 'json', ['groups' => ["PaginationAdherent"]]);

        return new JsonResponse($dataPaginator, Response::HTTP_OK, [], true);
    }
    /**
     * @Route("/api/parrainages/count", name="count_parrainages", methods={"GET"})
     * 
     */
    public function countParrainage(ParrainageRepository $parrainageRepository, SerializerInterface $serializer): Response
    {

        $count = $parrainageRepository->count(array());
        return new JsonResponse("{\"nombreParrainage\":$count}", Response::HTTP_OK, [], true);
    }


    /**
     * @Route("/api/parrainages/{id}", name="parrainage_show", methods={"GET"})
     */
    public function showParrainage(Parrainage $parrainage, SerializerInterface $serializer): Response
    {
        $data = $serializer->serialize($parrainage, 'json', ['groups' => ['listParrainageFull']]);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/parrainages/{id}", name="parrainage_delete", methods={"DELETE"})
     */

    public function deleteParrainage(Parrainage $parrainage, EntityManagerInterface $em): Response
    {
        $em->remove($parrainage);
        $em->flush();
        return new JsonResponse("Suppression success", Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/parrainages", name="parrainage_create", methods={"POST"})
     */

    public function createParrainage(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator): Response
    {

        $body = $request->getContent();
        $parrainage = $serializer->deserialize($body, Parrainage::class, 'json');

        $erreurs = $validator->validate($parrainage);


        if (count($erreurs) > 0) {
            $erreurJson = $serializer->serialize($erreurs, 'json');
            return new JsonResponse($erreurJson, Response::HTTP_BAD_REQUEST, [], true);
        }

        $em->persist($parrainage);
        $em->flush();

        $urlResource = $this->generateUrl(
            "parrainage_show",
            [
                "id" => $parrainage->getId(),
                UrlGeneratorInterface::ABSOLUTE_URL
            ]
        );
        return new JsonResponse(null, Response::HTTP_CREATED, ["location" => $urlResource], false);
    }

    /**
     * @Route("/api/parrainages/{id}", name="parrainage_update", methods={"PUT"})
     */

    public function updateParrainage(Parrainage $oldParrainage, Request $request, EntityManagerInterface $em, SerializerInterface $serializer): Response
    {
        $body = $request->getContent();
        $serializer->deserialize($body, Parrainage::class, 'json', ['object_to_populate' => $oldParrainage]);
        $em->persist($oldParrainage);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_OK, [], false);
    }
}
