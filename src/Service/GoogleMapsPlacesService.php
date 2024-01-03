<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoogleMapsPlacesService
{
    private $httpClient;

    public function __construct(HttpClientInterface $placesApiClient)
    {
        $this->httpClient = $placesApiClient;
    }

    public function getPlaceDetails(String $placeId): array
    {
        $response = $this->httpClient->request(
            'GET',
            '',
            [
                'query' => [
                    'fields' => 'place_id,name,formatted_address,business_status,formatted_phone_number,geometry,opening_hours,address_components,editorial_summary,wheelchair_accessible_entrance',
                    'place_id' => $placeId,
                    'language' => 'fr',
                ]
            ]
        );
        
        return $response->toArray();
    }
}
