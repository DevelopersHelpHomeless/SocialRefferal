<?php

namespace App\Controller;

use App\Service\GoogleMapsPlacesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GoogleMapsController extends AbstractController
{
    /**
     * @Route("/places/{id}", name="places", methods={"GET"})
     */
    public function getPlaceDetails(GoogleMapsPlacesService $googleMapsPlacesService, String $id): JsonResponse
   {
        if (empty($id)) {
            return new JsonResponse(['error' => 'Place ID is required.'], Response::HTTP_BAD_REQUEST);
        }
        
        $details = $googleMapsPlacesService->getPlaceDetails($id);

        return new JsonResponse($details);
    }
}
