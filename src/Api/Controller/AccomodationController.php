<?php

namespace App\Api\Controller;

use App\CrossCutting\Exception\ResourceNotFoundException;
use App\CrossCutting\Exception\NoContentException;
use App\Application\ViewModel\AccommodationViewModel;
use App\Infrastructure\Repository\AccommodationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AccomodationController extends AbstractController
{
    private $accommodationRepository;

    public function __construct(AccommodationRepository $accommodationRepository)
    {
        $this->accommodationRepository = $accommodationRepository;
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
}
