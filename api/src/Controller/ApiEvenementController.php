<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Repository\EvenementRepository;
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

class ApiEvenementController extends AbstractController
{

    private static int $LIMIT_PAGE = 12;
    /**
     * @Route("/api/evenements", name="list_evenements", methods={"GET"})
     * 
     */
    public function showEvenements(Request $request, EvenementRepository $evenementRepository, SerializerInterface $serializer): Response
    {
        $page = $request->get("page");
        $limit = $request->get("limit");

        if ($limit == null || $limit <= 0)
            $limit = self::$LIMIT_PAGE;
        if ($page == null || $page <= 0)
            $page = 1;

        $totalEments = $evenementRepository->count(array());
        $dernierPagePossible = intdiv($totalEments, $limit);
        if ($totalEments % $limit != 0) {
            $dernierPagePossible++;
        }

        if ($page > $dernierPagePossible)
            $page = $dernierPagePossible;
        // limit = 2 et total = 4       page = 4/2(int)=>2
        // limit = 2 et total = 5       page = 5/2(int)=>2
        // 5%2!=0 => page=2+1
        // AA
        // BB
        // CC
        // DD 
        // CC
        $evenements = $evenementRepository->findBy(
            array(),
            array('id' => 'ASC'),
            $limit,
            ($page - 1) * $limit
        );


        $paginator = new PaginatorResponse();
        $paginator->setPage($page);
        $paginator->setLimit($limit);
        $paginator->setCount($totalEments);
        $paginator->setData($evenements);
        $paginator->setLastPage($dernierPagePossible);
        $dataPaginator = $serializer->serialize($paginator, 'json', ['groups' => ["PaginationAdherent"]]);

        return new JsonResponse($dataPaginator, Response::HTTP_OK, [], true);
    }
    /**
     * @Route("/api/evenements/count", name="count_evenements", methods={"GET"})
     * 
     */
    public function countEvenement(EvenementRepository $evenementRepository, SerializerInterface $serializer): Response
    {

        $count = $evenementRepository->count(array());
        return new JsonResponse("{\"nombreEvenement\":$count}", Response::HTTP_OK, [], true);
    }


    /**
     * @Route("/api/evenements/{id}", name="evenement_show", methods={"GET"})
     */
    public function showEvenement(Evenement $evenement, SerializerInterface $serializer): Response
    {
        $data = $serializer->serialize($evenement, 'json', ['groups' => ['listAdherentFull']]);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/evenements/{id}", name="evenement_delete", methods={"DELETE"})
     */

    public function deleteEvenement(Evenement $evenement, EntityManagerInterface $em): Response
    {
        $em->remove($evenement);
        $em->flush();
        return new JsonResponse("Suppression success", Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/evenements", name="evenement_create", methods={"POST"})
     */

    public function createEvenement(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator): Response
    {

        $body = $request->getContent();
        $evenement = $serializer->deserialize($body, Evenement::class, 'json');

        $erreurs = $validator->validate($evenement);


        if (count($erreurs) > 0) {
            $erreurJson = $serializer->serialize($erreurs, 'json');
            return new JsonResponse($erreurJson, Response::HTTP_BAD_REQUEST, [], true);
        }

        $em->persist($evenement);
        $em->flush();

        $urlResource = $this->generateUrl(
            "evenement_show",
            [
                "id" => $evenement->getId(),
                UrlGeneratorInterface::ABSOLUTE_URL
            ]
        );
        return new JsonResponse(null, Response::HTTP_CREATED, ["location" => $urlResource], false);
    }

    /**
     * @Route("/api/evenements/{id}", name="evenement_update", methods={"PUT"})
     */

    public function updateEvenement(Evenement $oldEvenement, Request $request, EntityManagerInterface $em, SerializerInterface $serializer): Response
    {
        $body = $request->getContent();
        $serializer->deserialize($body, Evenement::class, 'json', ['object_to_populate' => $oldEvenement]);
        $em->persist($oldEvenement);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_OK, [], false);
    }
}
