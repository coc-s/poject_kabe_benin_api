<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
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

class ApiProduitController extends AbstractController
{

    private static int $LIMIT_PAGE =20;
    /**
     * @Route("/api/produits", name="list_produits", methods={"GET"})
     * 
     */
    public function showProduits(Request $request, ProduitRepository $produitRepository, SerializerInterface $serializer): Response
    {
        $page = $request->get("page");
        $limit = $request->get("limit");

        if ($limit == null || $limit <= 0)
            $limit = self::$LIMIT_PAGE;
        if ($page == null || $page <= 0)
            $page = 1;

        $totalEments = $produitRepository->count(array());
        $dernierPagePossible = intdiv($totalEments, $limit);
        if ($totalEments % $limit != 0) {
            $dernierPagePossible++;
        }

        if ($page > $dernierPagePossible)
            $page = $dernierPagePossible;
     
        $produits = $produitRepository->findBy(
            array(),
            array('id' => 'ASC'),
            $limit,
            ($page - 1) * $limit
        );


        $paginator = new PaginatorResponse();
        $paginator->setPage($page);
        $paginator->setLimit($limit);
        $paginator->setCount($totalEments);
        $paginator->setData($produits);
        $paginator->setLastPage($dernierPagePossible);
        $dataPaginator = $serializer->serialize($paginator, 'json', ['groups' => ["PaginationAdherent"]]);

        return new JsonResponse($dataPaginator, Response::HTTP_OK, [], true);
    }
    /**
     * @Route("/api/produits/count", name="count_produits", methods={"GET"})
     * 
     */
    public function countProduit(ProduitRepository $produitRepository, SerializerInterface $serializer): Response
    {

        $count = $produitRepository->count(array());
        return new JsonResponse("{\"nombreProduit\":$count}", Response::HTTP_OK, [], true);
    }


    /**
     * @Route("/api/produits/{id}", name="produit_show", methods={"GET"})
     */
    public function showProduit(Produit $produit, SerializerInterface $serializer): Response
    {
        $data = $serializer->serialize($produit, 'json', ['groups' => ['listAdherentFull']]);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/produits/{id}", name="produit_delete", methods={"DELETE"})
     */

    public function deleteProduit(Produit $produit, EntityManagerInterface $em): Response
    {
        $em->remove($produit);
        $em->flush();
        return new JsonResponse("Suppression success", Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/produits", name="produit_create", methods={"POST"})
     */

    public function createProduit(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator): Response
    {

        $body = $request->getContent();
        $produit = $serializer->deserialize($body, Produit::class, 'json');

        $erreurs = $validator->validate($produit);


        if (count($erreurs) > 0) {
            $erreurJson = $serializer->serialize($erreurs, 'json');
            return new JsonResponse($erreurJson, Response::HTTP_BAD_REQUEST, [], true);
        }

        $em->persist($produit);
        $em->flush();

        $urlResource = $this->generateUrl(
            "produit_show",
            [
                "id" => $produit->getId(),
                UrlGeneratorInterface::ABSOLUTE_URL
            ]
        );
        return new JsonResponse(null, Response::HTTP_CREATED, ["location" => $urlResource], false);
    }

    /**
     * @Route("/api/produits/{id}", name="produit_update", methods={"PUT"})
     */

    public function updateProduit(Produit $oldProduit, Request $request, EntityManagerInterface $em, SerializerInterface $serializer): Response
    {
        $body = $request->getContent();
        $serializer->deserialize($body, Produit::class, 'json', ['object_to_populate' => $oldProduit]);
        $em->persist($oldProduit);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_OK, [], false);
    }
}
