<?php

namespace App\Controller;

use App\Entity\Vente;
use App\Repository\VenteRepository;
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

class ApiVenteController extends AbstractController
{

    private static int $LIMIT_PAGE = 12;
    /**
     * @Route("/api/ventes", name="list_ventes", methods={"GET"})
     * 
     */
    public function showVentes(Request $request, VenteRepository $venteRepository, SerializerInterface $serializer): Response
    {
        $page = $request->get("page");
        $limit = $request->get("limit");

        if ($limit == null || $limit <= 0)
            $limit = self::$LIMIT_PAGE;
        if ($page == null || $page <= 0)
            $page = 1;

        $totalEments = $venteRepository->count(array());
        $dernierPagePossible = intdiv($totalEments, $limit);
        if ($totalEments % $limit != 0) {
            $dernierPagePossible++;
        }

        if ($page > $dernierPagePossible)
            $page = $dernierPagePossible;
        
        $ventes = $venteRepository->findBy(
            array(),
            array('id' => 'ASC'),
            $limit,
            ($page - 1) * $limit
        );


        $paginator = new PaginatorResponse();
        $paginator->setPage($page);
        $paginator->setLimit($limit);
        $paginator->setCount($totalEments);
        $paginator->setData($ventes);
        $paginator->setLastPage($dernierPagePossible);
        $dataPaginator = $serializer->serialize($paginator, 'json', ['groups' => ["PaginationAdherent"]]);

        return new JsonResponse($dataPaginator, Response::HTTP_OK, [], true);
    }
    /**
     * @Route("/api/ventes/count", name="count_ventes", methods={"GET"})
     * 
     */
    public function countVente(VenteRepository $venteRepository, SerializerInterface $serializer): Response
    {

        $count = $venteRepository->count(array());
        return new JsonResponse("{\"nombreVente\":$count}", Response::HTTP_OK, [], true);
    }


    /**
     * @Route("/api/ventes/{id}", name="Vente_show", methods={"GET"})
     */
    public function showVente(Vente $vente, SerializerInterface $serializer): Response
    {
        $data = $serializer->serialize($vente, 'json', ['groups' => ['listAdherentFull']]);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/ventes/{id}", name="Vente_delete", methods={"DELETE"})
     */

    public function deleteVente(Vente $vente, EntityManagerInterface $em): Response
    {
        $em->remove($vente);
        $em->flush();
        return new JsonResponse("Suppression success", Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/ventes", name="Vente_create", methods={"POST"})
     */

    public function createVente(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator): Response
    {

        $body = $request->getContent();
        $vente = $serializer->deserialize($body, Vente::class, 'json');

        $erreurs = $validator->validate($vente);


        if (count($erreurs) > 0) {
            $erreurJson = $serializer->serialize($erreurs, 'json');
            return new JsonResponse($erreurJson, Response::HTTP_BAD_REQUEST, [], true);
        }

        $em->persist($vente);
        $em->flush();

        $urlResource = $this->generateUrl(
            "Vente_show",
            [
                "id" => $vente->getId(),
                UrlGeneratorInterface::ABSOLUTE_URL
            ]
        );
        return new JsonResponse(null, Response::HTTP_CREATED, ["location" => $urlResource], false);
    }

    /**
     * @Route("/api/ventes/{id}", name="Vente_update", methods={"PUT"})
     */

    public function updateVente(Vente $oldVente, Request $request, EntityManagerInterface $em, SerializerInterface $serializer): Response
    {
        $body = $request->getContent();
        $serializer->deserialize($body, Vente::class, 'json', ['object_to_populate' => $oldVente]);
        $em->persist($oldVente);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_OK, [], false);
    }
}
