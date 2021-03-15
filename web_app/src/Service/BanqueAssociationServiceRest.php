<?php

namespace App\Service;

use App\Entity\BanqueAssociation;
use App\Entity\PaginatorResponse;
use App\Helper\SerializerHelper;
use Exception;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BanqueAssociationServiceRest implements IBanqueAssociationService
{
    private HttpClientInterface $client;
    private SerializerHelper $serializerHelper;

    public function __construct(HttpClientInterface $client,SerializerHelper $serializerHelper)
    {
        $this->serializerHelper=$serializerHelper;
        $this->client=$client;
    }

    public function  recupererTousBanqueAssociationPagination(?int $page,?int $limit): PaginatorResponse
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/banqueAssociations?page=".($page?$page:"")."&limit=".($limit?$limit:"")
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //envoyer à la vue
        $paginatorBanqueAssociation = $this->serializerHelper->deserializePaginator($content,'App\Entity\BanqueAssociation'); 
        return $paginatorBanqueAssociation;
    }

    public function recupererTousBanqueAssociation(): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/banqueAssociations"
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $banqueAssociation = $this->serializerHelper->serializer->deserialize($content, "App\Entity\BanqueAssociation[]", 'json');
        //envoyer à la vue

        return $banqueAssociation;
    }

    public function recupererBanqueAssociationParId(int $id): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/banqueAssociations/$id"
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $banqueAssociations = $this->serializerHelper->serialize->deserialize($content, "App\Entity\BanqueAssociation", 'json');
        //envoyer à la vue

        return $banqueAssociations;
    }

    public function enregistrerBanqueAssociation(BanqueAssociation $banqueAssociation): BanqueAssociation
    {
        $banqueAssociationTab = $this->serializerHelper->normalizer->normalize($banqueAssociation);
        //appler Api
       
        $response = $this->client->request(
            'POST',
            'http://localhost:8000/api/banqueAssociations',
            ['json'=> $banqueAssociationTab]
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
        $banqueAssociation = $this->serializerHelper->serializer->deserialize($content, "App\Entity\BanqueAssociation", 'json');
        //envoyer à la vue

        return $banqueAssociation;
    }

    public function mettreAjourBanqueAssociation(BanqueAssociation $banqueAssociation): bool
    {
        $banqueAssociationTab = $this->serializerHelper->normalizer->normalize($banqueAssociation);
        //appler Api
        $response = $this->client->request(
            'PUT',
            "http://localhost:8000/api/banqueAssociations/" . $banqueAssociation->getId(),
            ["json"=>$banqueAssociationTab]
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode != 200) {
            //possible de recuperer les messages d'erreurs ici
            return false;
        }

        return true;
    }
    public function supprimerBanqueAssociation(int $id): bool
    {

        $response = $this->client->request(
            "DELETE",
            "http://localhost:8000/api/banqueAssociations/$id"
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode != 200) {
            //possible de recuperer les messages d'erreurs ici
            return false;
        }

        return true;
    }

   
}
