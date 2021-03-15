<?php

namespace App\Controller;

use App\Entity\ProjetHumanitaire;
use App\Repository\ProjetHumanitaireRepository;
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

class ApiProjetHumanitaireController extends AbstractController
{

    private static int $LIMIT_PAGE = 12;
    /**
     * @Route("/api/ProjetHumanitaires", name="list_ProjetHumanitaires", methods={"GET"})
     * 
     */
    public function showProjetHumanitaires(Request $request, ProjetHumanitaireRepository $projetHumanitaireRepository, SerializerInterface $serializer): Response
    {
        $page = $request->get("page");
        $limit = $request->get("limit");

        if ($limit == null || $limit <= 0)
            $limit = self::$LIMIT_PAGE;
        if ($page == null || $page <= 0)
            $page = 1;

        $totalEments = $projetHumanitaireRepository->count(array());
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
        $projetHumanitaires = $projetHumanitaireRepository->findBy(
            array(),
            array('id' => 'ASC'),
            $limit,
            ($page - 1) * $limit
        );


        $paginator = new PaginatorResponse();
        $paginator->setPage($page);
        $paginator->setLimit($limit);
        $paginator->setCount($totalEments);
        $paginator->setData($projetHumanitaires);
        $paginator->setLastPage($dernierPagePossible);
        $dataPaginator = $serializer->serialize($paginator, 'json', ['groups' => ["PaginationAdherent"]]);

        return new JsonResponse($dataPaginator, Response::HTTP_OK, [], true);
    }
    /**
     * @Route("/api/ProjetHumanitaires/count", name="count_ProjetHumanitaires", methods={"GET"})
     * 
     */
    public function countProjetHumanitaire(ProjetHumanitaireRepository $projetHumanitaireRepository, SerializerInterface $serializer): Response
    {

        $count = $projetHumanitaireRepository->count(array());
        return new JsonResponse("{\"nombreProjetHumanitaire\":$count}", Response::HTTP_OK, [], true);
    }


    /**
     * @Route("/api/ProjetHumanitaires/{id}", name="ProjetHumanitaire_show", methods={"GET"})
     */
    public function showProjetHumanitaire(ProjetHumanitaire $projetHumanitaire, SerializerInterface $serializer): Response
    {
        $data = $serializer->serialize($projetHumanitaire, 'json', ['groups' => ['listAdherentFull']]);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/ProjetHumanitaires/{id}", name="ProjetHumanitaire_delete", methods={"DELETE"})
     */

    public function deleteProjetHumanitaire(ProjetHumanitaire $projetHumanitaire, EntityManagerInterface $em): Response
    {
        $em->remove($projetHumanitaire);
        $em->flush();
        return new JsonResponse("Suppression success", Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/ProjetHumanitaires", name="ProjetHumanitaire_create", methods={"POST"})
     */

    public function createProjetHumanitaire(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator): Response
    {

        $body = $request->getContent();
        $projetHumanitaire = $serializer->deserialize($body, ProjetHumanitaire::class, 'json');

        $erreurs = $validator->validate($projetHumanitaire);


        if (count($erreurs) > 0) {
            $erreurJson = $serializer->serialize($erreurs, 'json');
            return new JsonResponse($erreurJson, Response::HTTP_BAD_REQUEST, [], true);
        }

        $em->persist($projetHumanitaire);
        $em->flush();

        $urlResource = $this->generateUrl(
            "ProjetHumanitaire_show",
            [
                "id" => $projetHumanitaire->getId(),
                UrlGeneratorInterface::ABSOLUTE_URL
            ]
        );
        return new JsonResponse(null, Response::HTTP_CREATED, ["location" => $urlResource], false);
    }

    /**
     * @Route("/api/ProjetHumanitaires/{id}", name="ProjetHumanitaire_update", methods={"PUT"})
     */

    public function updateProjetHumanitaire(ProjetHumanitaire $oldProjetHumanitaire, Request $request, EntityManagerInterface $em, SerializerInterface $serializer): Response
    {
        $body = $request->getContent();
        $serializer->deserialize($body, ProjetHumanitaire::class, 'json', ['object_to_populate' => $oldProjetHumanitaire]);
        $em->persist($oldProjetHumanitaire);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_OK, [], false);
    }
}
