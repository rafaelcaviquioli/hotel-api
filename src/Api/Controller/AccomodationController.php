<?php

namespace App\Api\Controller;

use App\Application\ViewModel\AccommodationViewModel;
use App\Domain\Constant\Category;
use App\Domain\Entity\Accommodation;
use App\Infrastructure\Repository\AccommodationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Domain\Entity\Location;

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
        $viewModels = AccommodationViewModel::parseList($accommodations);

        return $this->json($viewModels);
    }
}
