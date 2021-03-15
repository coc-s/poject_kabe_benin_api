<?php

namespace App\Service;

use App\Entity\Admin;
use App\Entity\PaginatorResponse;
use App\Helper\SerializerHelper;
use Exception;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AdminServiceRest implements IAdminService
{
    private HttpClientInterface $client;
    private SerializerHelper $serializerHelper;

    public function __construct(HttpClientInterface $client,SerializerHelper $serializerHelper)
    {
        $this->serializerHelper=$serializerHelper;
        $this->client=$client;
    }

    public function  recupererTousAdminPagination(?int $page,?int $limit): PaginatorResponse
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/admins?page=".($page?$page:"")."&limit=".($limit?$limit:"")
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //envoyer à la vue
        $paginatorAdmin = $this->serializerHelper->deserializePaginator($content,'App\Entity\Admin'); 
        return $paginatorAdmin;
    }

    public function recupererTousAdmin(): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/admins"
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $admin = $this->serializerHelper->serializer->deserialize($content, "App\Entity\Admin[]", 'json');
        //envoyer à la vue

        return $admin;
    }

    public function recupererAdminParId(int $id): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/admins/$id"
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $departements = $this->serializerHelper->serialize->deserialize($content, "App\Entity\Departement", 'json');
        //envoyer à la vue

        return $departements;
    }

    public function enregistrerAdmin(Admin $admin): Admin
    {
        $adminTab = $this->serializerHelper->normalizer->normalize($admin);
        //appler Api
       
        $response = $this->client->request(
            'POST',
            'http://localhost:8000/api/admins',
            ['json'=> $adminTab]
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode != 201) {
            throw new Exception("Creation impossible");
        }

        $url = $response->getHeaders()["location"][0];

        $response = $this->client->request(
            'GET',
            'http://localhost:8000' . $url
        );

        $statusCode = $response->getStatusCode();
        if ($statusCode != 200) {
            throw new Exception("Creation ok mais recuperation impossible");
        }

        $content = $response->getContent();
        //deserialiser l'objet
        $admin = $this->serializerHelper->serializer->deserialize($content, "App\Entity\Admin", 'json');
        //envoyer à la vue

        return $admin;
    }

    public function mettreAjourAdmin(Admin $admin): bool
    {
        $adminTab = $this->serializerHelper->normalizer->normalize($admin);
        //appler Api
        $response = $this->client->request(
            'PUT',
            "http://localhost:8000/api/admins/" . $admin->getId(),
            ["json"=>$adminTab]
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode != 200) {
            //possible de recuperer les messages d'erreurs ici
            return false;
        }

        return true;
    }
    public function supprimerAdmin(int $id): bool
    {

        $response = $this->client->request(
            "DELETE",
            "http://localhost:8000/api/admins/$id"
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode != 200) {
            //possible de recuperer les messages d'erreurs ici
            return false;
        }

        return true;
    }

   
}
