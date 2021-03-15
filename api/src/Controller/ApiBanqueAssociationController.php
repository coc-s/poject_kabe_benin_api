<?php

namespace App\Controller;

use App\Entity\BanqueAssociation;
use App\Repository\BanqueAssociationRepository;
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

class ApiBanqueAssociationController extends AbstractController
{

    private static int $LIMIT_PAGE = 12;
    /**
     * @Route("/api/banqueAssociations", name="list_BanqueAssociations", methods={"GET"})
     * 
     */
    public function showBanqueAssociations(Request $request, banqueAssociationRepository $banqueAssociationRepository, SerializerInterface $serializer): Response
    {
        $page = $request->get("page");
        $limit = $request->get("limit");

        if ($limit == null || $limit <= 0)
            $limit = self::$LIMIT_PAGE;
        if ($page == null || $page <= 0)
            $page = 1;

        $totalEments =$banqueAssociationRepository->count(array());
       $dernierPagePossible = intdiv($totalEments, $limit);
        if ($totalEments % $limit != 0) {
           $dernierPagePossible++;
        }

        if ($page >$dernierPagePossible)
            $page =$dernierPagePossible;
   
       $banqueAssociations =$banqueAssociationRepository->findBy(
            array(),
            array('id' => 'ASC'),
            $limit,
            ($page - 1) * $limit
        );


        $paginator = new PaginatorResponse();
        $paginator->setPage($page);
        $paginator->setLimit($limit);
        $paginator->setCount($totalEments);
        $paginator->setData($banqueAssociations);
        $paginator->setLastPage($dernierPagePossible);
       $dataPaginator = $serializer->serialize($paginator, 'json', ['groups' => ["PaginationAdherent"]]);

        return new JsonResponse($dataPaginator, Response::HTTP_OK, [], true);
    }
    /**
     * @Route("/api/banqueAssociations/count", name="count_BanqueAssociations", methods={"GET"})
     * 
     */
    public function countBanqueAssociation(BanqueAssociationRepository $banqueAssociationRepository, SerializerInterface $serializer): Response
    {

        $count = $banqueAssociationRepository->count(array());
        return new JsonResponse("{\"nombreBanqueAssociation\":$count}", Response::HTTP_OK, [], true);
    }


    /**
     * @Route("/api/banqueAssociations/{id}", name="BanqueAssociation_show", methods={"GET"})
     */
    public function showBanqueAssociation(BanqueAssociation $banqueAssociation, SerializerInterface $serializer): Response
    {
       $data = $serializer->serialize($banqueAssociation, 'json', ['groups' => ['listAdherentFull']]);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/banqueAssociations/{id}", name="BanqueAssociation_delete", methods={"DELETE"})
     */

    public function deleteBanqueAssocation(BanqueAssociation $banqueAssociation, EntityManagerInterface $em): Response
    {
        $em->remove($banqueAssociation);
        $em->flush();
        return new JsonResponse("Suppression success", Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/banqueAssociations", name="BanqueAssociation_create", methods={"POST"})
     */

    public function createBanqueAssociation(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator): Response
    {

        $body = $request->getContent();
        $banqueAssociation = $serializer->deserialize($body, BanqueAssociation::class, 'json');

        $erreurs = $validator->validate($banqueAssociation);


        if (count($erreurs) > 0) {
            $erreurJson = $serializer->serialize($erreurs, 'json');
            return new JsonResponse($erreurJson, Response::HTTP_BAD_REQUEST, [], true);
        }

        $em->persist($banqueAssociation);
        $em->flush();

        $urlResource = $this->generateUrl(
            "BanqueAssociation_show",
            [
                "id" =>$banqueAssociation->getId(),
                UrlGeneratorInterface::ABSOLUTE_URL
            ]
        );
        return new JsonResponse(null, Response::HTTP_CREATED, ["location" => $urlResource], false);
    }

    /**
     * @Route("/api/banqueAssociations/{id}", name="BanqueAssociation_update", methods={"PUT"})
     */

    public function updateBanqueAssociation(BanqueAssociation $oldBanqueAssociation, Request $request, EntityManagerInterface $em, SerializerInterface $serializer): Response
    {
        $body = $request->getContent();
        $serializer->deserialize($body, BanqueAssociation::class, 'json', ['object_to_populate' => $oldBanqueAssociation]);
        $em->persist($oldBanqueAssociation);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_OK, [], false);
    }
}
