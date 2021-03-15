<?php

namespace App\Controller;

use App\Entity\Don;
use App\Repository\DonRepository;
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

class ApiDonController extends AbstractController
{

    private static int $LIMIT_PAGE = 12;
    /**
     * @Route("/api/dons", name="list_Dons", methods={"GET"})
     * 
     */
    public function showDons(Request $request, DonRepository$donRepository, SerializerInterface $serializer): Response
    {
        $page = $request->get("page");
        $limit = $request->get("limit");

        if ($limit == null || $limit <= 0)
            $limit = self::$LIMIT_PAGE;
        if ($page == null || $page <= 0)
            $page = 1;

        $totalEments =$donRepository->count(array());
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
       $dons =$donRepository->findBy(
            array(),
            array('id' => 'ASC'),
            $limit,
            ($page - 1) * $limit
        );


        $paginator = new PaginatorResponse();
        $paginator->setPage($page);
        $paginator->setLimit($limit);
        $paginator->setCount($totalEments);
        $paginator->setData($dons);
        $paginator->setLastPage($dernierPagePossible);
       $dataPaginator = $serializer->serialize($paginator, 'json', ['groups' => ["PaginationAdherent"]]);

        return new JsonResponse($dataPaginator, Response::HTTP_OK, [], true);
    }
    /**
     * @Route("/api/dons/count", name="count_Dons", methods={"GET"})
     * 
     */
    public function countDon(DonRepository$donRepository, SerializerInterface $serializer): Response
    {

        $count =$donRepository->count(array());
        return new JsonResponse("{\"nombreDon\":$count}", Response::HTTP_OK, [], true);
    }


    /**
     * @Route("/api/dons/{id}", name="Don_show", methods={"GET"})
     */
    public function showDon(Don$don, SerializerInterface $serializer): Response
    {
       $data = $serializer->serialize($don, 'json', ['groups' => ['listAdherentFull']]);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/dons/{id}", name="Don_delete", methods={"DELETE"})
     */

    public function deleteDon(Don$don, EntityManagerInterface $em): Response
    {
        $em->remove($don);
        $em->flush();
        return new JsonResponse("Suppression success", Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/dons", name="Don_create", methods={"POST"})
     */

    public function createDon(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator): Response
    {

        $body = $request->getContent();
       $don = $serializer->deserialize($body, Don::class, 'json');

        $erreurs = $validator->validate($don);


        if (count($erreurs) > 0) {
            $erreurJson = $serializer->serialize($erreurs, 'json');
            return new JsonResponse($erreurJson, Response::HTTP_BAD_REQUEST, [], true);
        }

        $em->persist($don);
        $em->flush();

        $urlResource = $this->generateUrl(
            "Don_show",
            [
                "id" =>$don->getId(),
                UrlGeneratorInterface::ABSOLUTE_URL
            ]
        );
        return new JsonResponse(null, Response::HTTP_CREATED, ["location" => $urlResource], false);
    }

    /**
     * @Route("/api/dons/{id}", name="Don_update", methods={"PUT"})
     */

    public function updateDon(Don $oldDon, Request $request, EntityManagerInterface $em, SerializerInterface $serializer): Response
    {
        $body = $request->getContent();
        $serializer->deserialize($body, Don::class, 'json', ['object_to_populate' => $oldDon]);
        $em->persist($oldDon);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_OK, [], false);
    }
}
