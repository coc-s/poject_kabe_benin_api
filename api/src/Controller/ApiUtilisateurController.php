<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
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

class ApiUtilisateurController extends AbstractController
{

    private static int $LIMIT_PAGE = 12;
    /**
     * @Route("/api/utilisateurs", name="list_utilisateurs", methods={"GET"})
     * 
     */
    public function showUtilisateurs(Request $request, UtilisateurRepository $utilisateurRepository, SerializerInterface $serializer): Response
    {
        $page = $request->get("page");
        $limit = $request->get("limit");

        if ($limit == null || $limit <= 0)
            $limit = self::$LIMIT_PAGE;
        if ($page == null || $page <= 0)
            $page = 1;

        $totalEments = $utilisateurRepository->count(array());
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
        $utilisateurs = $utilisateurRepository->findBy(
            array(),
            array('id' => 'ASC'),
            $limit,
            ($page - 1) * $limit
        );


        $paginator = new PaginatorResponse();
        $paginator->setPage($page);
        $paginator->setLimit($limit);
        $paginator->setCount($totalEments);
        $paginator->setData($utilisateurs);
        $paginator->setLastPage($dernierPagePossible);
        $dataPaginator = $serializer->serialize($paginator, 'json', ['groups' => ["PaginationAdherent"]]);

        return new JsonResponse($dataPaginator, Response::HTTP_OK, [], true);
    }
    /**
     * @Route("/api/utilisateurs/count", name="count_utilisateurs", methods={"GET"})
     * 
     */
    public function countUtilisateur(UtilisateurRepository $utilisateurRepository, SerializerInterface $serializer): Response
    {

        $count = $utilisateurRepository->count(array());
        return new JsonResponse("{\"nombreUtilisateur\":$count}", Response::HTTP_OK, [], true);
    }


    /**
     * @Route("/api/utilisateurs/{id}", name="Utilisateur_show", methods={"GET"})
     */
    public function showUtilisateur(Utilisateur $utilisateur, SerializerInterface $serializer): Response
    {
        $data = $serializer->serialize($utilisateur, 'json', ['groups' => ['listAdherentFull']]);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/utilisateurs/{id}", name="Utilisateur_delete", methods={"DELETE"})
     */

    public function deleteUtilisateur(Utilisateur $utilisateur, EntityManagerInterface $em): Response
    {
        $em->remove($utilisateur);
        $em->flush();
        return new JsonResponse("Suppression success", Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/utilisateurs", name="Utilisateur_create", methods={"POST"})
     */

    public function createUtilisateur(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator): Response
    {

        $body = $request->getContent();
        $utilisateur = $serializer->deserialize($body, Utilisateur::class, 'json');

        $erreurs = $validator->validate($utilisateur);


        if (count($erreurs) > 0) {
            $erreurJson = $serializer->serialize($erreurs, 'json');
            return new JsonResponse($erreurJson, Response::HTTP_BAD_REQUEST, [], true);
        }

        $em->persist($utilisateur);
        $em->flush();

        $urlResource = $this->generateUrl(
            "Utilisateur_show",
            [
                "id" => $utilisateur->getId(),
                UrlGeneratorInterface::ABSOLUTE_URL
            ]
        );
        return new JsonResponse(null, Response::HTTP_CREATED, ["location" => $urlResource], false);
    }

    /**
     * @Route("/api/utilisateurs/{id}", name="Utilisateur_update", methods={"PUT"})
     */

    public function updateUtilisateur(Utilisateur $oldUtilisateur, Request $request, EntityManagerInterface $em, SerializerInterface $serializer): Response
    {
        $body = $request->getContent();
        $serializer->deserialize($body, Utilisateur::class, 'json', ['object_to_populate' => $oldUtilisateur]);
        $em->persist($oldUtilisateur);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_OK, [], false);
    }
}
