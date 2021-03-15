<?php

namespace App\Service;

use App\Entity\Adherent;
use App\Entity\PaginatorResponse;
use App\Helper\SerializerHelper;
use Exception;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AdherentServiceRest implements IAdherentService
{
    private HttpClientInterface $client;
    private SerializerHelper $serializerHelper;

    public function __construct(HttpClientInterface $client,SerializerHelper $serializerHelper)
    {
        $this->serializerHelper=$serializerHelper;
        $this->client=$client;
    }

    public function  recupererTousAdherentPagination(?int $page,?int $limit): PaginatorResponse
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/adherents?page=".($page?$page:"")."&limit=".($limit?$limit:"")
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //envoyer à la vue
        $paginatorAdherent = $this->serializerHelper->deserializePaginator($content,'App\Entity\Adherent'); 
        return $paginatorAdherent;
    }

    public function recupererTousAdherent(): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/adherents"
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $adherent = $this->serializerHelper->serializer->deserialize($content, "App\Entity\Adherent[]", 'json');
        //envoyer à la vue

        return $adherent;
    }

    public function recupererAdherentParId(int $id): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/adherents/$id"
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $adherents[]= $this->serializerHelper->serializer->deserialize($content, "App\Entity\Adherent", 'json');
        //envoyer à la vue

        return $adherents;
    }

    public function enregistrerAdherent(Adherent $adherent): Adherent
    {
        $adherentTab = $this->serializerHelper->normalizer->normalize($adherent);
        //appler Api
       
        $response = $this->client->request(
            'POST',
            'http://localhost:8000/api/adherents',
            ['json'=> $adherentTab]
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
        $adherent = $this->serializerHelper->serializer->deserialize($content, "App\Entity\Adherent", 'json');
        //envoyer à la vue

        return $adherent;
    }

    public function mettreAjourAdherent(Adherent $adherent): bool
    {
        $adherentTab = $this->serializerHelper->normalizer->normalize($adherent);
        //appler Api
        $response = $this->client->request(
            'PUT',
            "http://localhost:8000/api/adherents/" . $adherent->getId(),
            ["json"=>$adherentTab]
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode != 200) {
            //possible de recuperer les messages d'erreurs ici
            return false;
        }

        return true;
    }
    public function supprimerAdherent(int $id): bool
    {

        $response = $this->client->request(
            "DELETE",
            "http://localhost:8000/api/adherents/$id"
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
