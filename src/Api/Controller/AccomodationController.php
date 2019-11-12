<?php

namespace App\Api\Controller;

use App\CrossCutting\Exception\ResourceNotFoundException;
use App\CrossCutting\Exception\NoContentException;
use App\Application\ViewModel\AccommodationViewModel;
use App\Application\ViewModel\AccommodationPayload;
use App\Domain\Entity\Accommodation;
use App\Domain\Entity\Location;
use App\Domain\Service\AccommodationService;
use App\Infrastructure\Repository\AccommodationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;

class AccomodationController extends AbstractController
{
    private $accommodationRepository;
    private $accommodationService;

    public function __construct(
        AccommodationRepository $accommodationRepository,
        AccommodationService $accommodationService
    ) {
        $this->accommodationRepository = $accommodationRepository;
        $this->accommodationService = $accommodationService;
    }

    /**
     * @Route("/api/accommodation/{id}", methods={"GET"})
     */
    public function getAccommodation($id): Response
    {
        $accommodation = $this->accommodationRepository->findOneById($id);

        if ($accommodation == null) {
            throw new ResourceNotFoundException();
        }
        $viewModel = new AccommodationViewModel();
        $viewModel->parseOne($accommodation);

        return $this->json($viewModel);
    }

    /**
     * @Route("/api/accommodation", methods={"GET"})
     */
    public function getAccommodations(): Response
    {
        $accommodations = $this->accommodationRepository->findAll();

        if ($accommodations == null) {
            throw new NoContentException();
        }

        $viewModels = AccommodationViewModel::parseList($accommodations);

        return $this->json($viewModels);
    }

    /**
     * @Route("/api/accommodation", methods={"POST"})
     * 
     * @SWG\Parameter(
     *     name="accommodation",
     *     in="body",
     *     description="Accommodation",
     *     required=true,
     *     @Model(type=AccommodationPayload::class)
     * )
     * 
     * @SWG\Response(
     *     response=201,
     *     description="Accommodation created",
     *     @Model(type=AccommodationViewModel::class)
     * )
     * */
    public function createAccommodation(Request $request)
    {
        $content = json_decode($request->getContent(), true);

        $accommodationViewModel = $this->accommodationService
            ->createAccommodation($content);

        return $this->json($accommodationViewModel, Response::HTTP_CREATED);
    }
}
