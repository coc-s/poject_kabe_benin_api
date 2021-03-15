<?php

namespace App\Service;

use App\Entity\Utilisateur;
use App\Entity\PaginatorResponse;
use App\Helper\SerializerHelper;
use Exception;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UtilisateurServiceRest implements IUtilisateurService
{
    private HttpClientInterface $client;
    private SerializerHelper $serializerHelper;

    public function __construct(HttpClientInterface $client,SerializerHelper $serializerHelper)
    {
        $this->serializerHelper=$serializerHelper;
        $this->client=$client;
    }

    public function  recupererTousUtilisateurPagination(?int $page,?int $limit): PaginatorResponse
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/utilisateurs?page=".($page?$page:"")."&limit=".($limit?$limit:"")
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //envoyer à la vue
        $paginatorUtilisateur = $this->serializerHelper->deserializePaginator($content,'App\Entity\Utilisateur'); 
        return $paginatorUtilisateur;
    }

    public function recupererTousUtilisateur(): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/utilisateurs"
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $utilisateur = $this->serializerHelper->serializer->deserialize($content, "App\Entity\Utilisateur[]", 'json');
        //envoyer à la vue

        return $utilisateur;
    }

    public function recupererUtilisateurParId(int $id): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/utilisateurs/$id"
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $Utilisateurs = $this->serializerHelper->serializer->deserialize($content, "App\Entity\Utilisateur", 'json');
        //envoyer à la vue

        return $Utilisateurs;
    }

    public function enregistrerUtilisateur(Utilisateur $utilisateur): Utilisateur
    {
        $utilisateurTab = $this->serializerHelper->normalizer->normalize($utilisateur);
        //appler Api
       
        $response = $this->client->request(
            'POST',
            'http://localhost:8000/api/utilisateurs',
            ['json'=> $utilisateurTab]
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
        $utilisateur = $this->serializerHelper->serializer->deserialize($content, "App\Entity\Utilisateur", 'json');
        //envoyer à la vue

        return $utilisateur;
    }

    public function mettreAjourUtilisateur(Utilisateur $utilisateur): bool
    {
        $utilisateurTab = $this->serializerHelper->normalizer->normalize($utilisateur);
        //appler Api
        $response = $this->client->request(
            'PUT',
            "http://localhost:8000/api/utilisateurs/" . $utilisateur->getId(),
            ["json"=>$utilisateurTab]
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode != 200) {
            //possible de recuperer les messages d'erreurs ici
            return false;
        }

        return true;
    }
    public function supprimerUtilisateur(int $id): bool
    {

        $response = $this->client->request(
            "DELETE",
            "http://localhost:8000/api/utilisateurs/$id"
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode != 200) {
            //possible de recuperer les messages d'erreurs ici
            throw new Exception("Suppression impossible");
            
            return false;
        }

        return true;
    }

   
}
