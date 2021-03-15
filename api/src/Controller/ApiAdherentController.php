<?php

namespace App\Controller;

use App\Entity\Adherent;
use App\Repository\AdherentRepository;
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

class ApiAdherentController extends AbstractController
{

    private static int $LIMIT_PAGE =20;
    /**
     * @Route("/api/adherents", name="list_adherents", methods={"GET"})
     * 
     */
    public function showAdherents(Request $request, AdherentRepository $adherentRepository, SerializerInterface $serializer): Response
    {
        $page = $request->get("page");
        $limit = $request->get("limit");

        if ($limit == null || $limit <= 0)
            $limit = self::$LIMIT_PAGE;
        if ($page == null || $page <= 0)
            $page = 1;

        $totalEments = $adherentRepository->count(array());
        $dernierPagePossible = intdiv($totalEments, $limit);
        if ($totalEments % $limit != 0) {
            $dernierPagePossible++;
        }

        if ($page > $dernierPagePossible)
            $page = $dernierPagePossible;

        $adherents = $adherentRepository->findBy(
            array(),
            array('id' => 'ASC'),
            $limit,
            ($page - 1) * $limit
        );


        $paginator = new PaginatorResponse();
        $paginator->setPage($page);
        $paginator->setLimit($limit);
        $paginator->setCount($totalEments);
        $paginator->setData($adherents);
        $paginator->setLastPage($dernierPagePossible);
        $dataPaginator = $serializer->serialize($paginator, 'json', ['groups' => ["PaginationAdherent"]]);

        return new JsonResponse($dataPaginator, Response::HTTP_OK, [], true);
    }
    /**
     * @Route("/api/adherents/count", name="count_adherents", methods={"GET"})
     * 
     */
    public function countAdherent(AdherentRepository $adherentRepository, SerializerInterface $serializer): Response
    {

        $count = $adherentRepository->count(array());
        return new JsonResponse("{\"nombreAdherent\":$count}", Response::HTTP_OK, [], true);
    }


    /**
     * @Route("/api/adherents/{id}", name="adherent_show", methods={"GET"})
     */
    public function showAdherent(Adherent $adherent, SerializerInterface $serializer): Response
    {
        $data = $serializer->serialize($adherent, 'json', ['groups' => ['listAdherentFull']]);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/adherents/{id}", name="adherent_delete", methods={"DELETE"})
     */

    public function deleteAdherent(Adherent $adherent, EntityManagerInterface $em): Response
    {
        $em->remove($adherent);
        $em->flush();
        return new JsonResponse("Suppression success", Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/adherents", name="adherent_create", methods={"POST"})
     */

    public function createAdherent(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator): Response
    {

        $body = $request->getContent();
        $adherent = $serializer->deserialize($body, Adherent::class, 'json');

        $erreurs = $validator->validate($adherent);


        if (count($erreurs) > 0) {
            $erreurJson = $serializer->serialize($erreurs, 'json');
            return new JsonResponse($erreurJson, Response::HTTP_BAD_REQUEST, [], true);
        }

        $em->persist($adherent);
        $em->flush();

        $urlResource = $this->generateUrl(
            "adherent_show",
            [
                "id" => $adherent->getId(),
                UrlGeneratorInterface::ABSOLUTE_URL
            ]
        );
        return new JsonResponse(null, Response::HTTP_CREATED, ["location" => $urlResource], false);
    }

    /**
     * @Route("/api/adherents/{id}", name="adherent_update", methods={"PUT"})
     */

    public function updateAdherent(Adherent $oldAdherent, Request $request, EntityManagerInterface $em, SerializerInterface $serializer): Response
    {
        $body = $request->getContent();
        $serializer->deserialize($body, Adherent::class, 'json', ['object_to_populate' => $oldAdherent]);
        $em->persist($oldAdherent);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_OK, [], false);
    }
}
