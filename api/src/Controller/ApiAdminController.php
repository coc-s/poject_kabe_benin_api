<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Repository\AdminRepository;
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

class ApiAdminController extends AbstractController
{

    private static int $LIMIT_PAGE = 12;
    /**
     * @Route("/api/admins", name="list_Admins", methods={"GET"})
     * 
     */
    public function showAdmins(Request $request, AdminRepository $adminRepository, SerializerInterface $serializer): Response
    {
        $page = $request->get("page");
        $limit = $request->get("limit");

        if ($limit == null || $limit <= 0)
            $limit = self::$LIMIT_PAGE;
        if ($page == null || $page <= 0)
            $page = 1;

        $totalEments = $adminRepository->count(array());
        $dernierPagePossible = intdiv($totalEments, $limit);
        if ($totalEments % $limit != 0) {
            $dernierPagePossible++;
        }

        if ($page > $dernierPagePossible)
            $page = $dernierPagePossible;
        $admins = $adminRepository->findBy(
            array(),
            array('id' => 'ASC'),
            $limit,
            ($page - 1) * $limit
        );


        $paginator = new PaginatorResponse();
        $paginator->setPage($page);
        $paginator->setLimit($limit);
        $paginator->setCount($totalEments);
        $paginator->setData($admins);
        $paginator->setLastPage($dernierPagePossible);
        $dataPaginator = $serializer->serialize($paginator, 'json', ['groups' => ["PaginationAdherent"]]);

        return new JsonResponse($dataPaginator, Response::HTTP_OK, [], true);
    }
    /**
     * @Route("/api/admins/count", name="count_Admins", methods={"GET"})
     * 
     */
    public function countAdmin(AdminRepository $adminRepository, SerializerInterface $serializer): Response
    {

        $count = $adminRepository->count(array());
        return new JsonResponse("{\"nombreAdmin\":$count}", Response::HTTP_OK, [], true);
    }


    /**
     * @Route("/api/admins/{id}", name="Admin_show", methods={"GET"})
     */
    public function showAdmin(Admin $admin, SerializerInterface $serializer): Response
    {
        $data = $serializer->serialize($admin, 'json', ['groups' => ['listAdherentFull']]);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/admins/{id}", name="Admin_delete", methods={"DELETE"})
     */

    public function deleteAdmin(Admin $admin, EntityManagerInterface $em): Response
    {
        $em->remove($admin);
        $em->flush();
        return new JsonResponse("Suppression success", Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/admins", name="Admin_create", methods={"POST"})
     */

    public function createAdmin(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator): Response
    {

        $body = $request->getContent();
        $admin = $serializer->deserialize($body, Admin::class, 'json');

        $erreurs = $validator->validate($admin);


        if (count($erreurs) > 0) {
            $erreurJson = $serializer->serialize($erreurs, 'json');
            return new JsonResponse($erreurJson, Response::HTTP_BAD_REQUEST, [], true);
        }

        $em->persist($admin);
        $em->flush();

        $urlResource = $this->generateUrl(
            "Admin_show",
            [
                "id" => $admin->getId(),
                UrlGeneratorInterface::ABSOLUTE_URL
            ]
        );
        return new JsonResponse(null, Response::HTTP_CREATED, ["location" => $urlResource], false);
    }

    /**
     * @Route("/api/admins/{id}", name="Admin_update", methods={"PUT"})
     */

    public function updateAdmin(Admin $oldAdmin, Request $request, EntityManagerInterface $em, SerializerInterface $serializer): Response
    {
        $body = $request->getContent();
        $serializer->deserialize($body, Admin::class, 'json', ['object_to_populate' => $oldAdmin]);
        $em->persist($oldAdmin);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_OK, [], false);
    }
}
