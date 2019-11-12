<?php

namespace App\Api\Controller;

use App\CrossCutting\Exception\ResourceNotFoundException;
use App\CrossCutting\Exception\NoContentException;
use App\Application\ViewModel\AccommodationViewModel;
use App\Application\ViewModel\AccommodationPayload;
use App\Domain\Entity\Accommodation;
use App\Domain\Entity\Location;
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
    public function insert(Request $request)
    {
        $content = json_decode($request->getContent(), true);

        $location = new Location();
        $location
            ->setCity($content["location"]["city"])
            ->setState($content["location"]["state"])
            ->setCountry($content["location"]["country"])
            ->setAddress($content["location"]["address"])
            ->setZipCode((int) $content["location"]["zip_code"]);

        $accommodation = new Accommodation();
        $accommodation
            ->setName($content["name"])
            ->setCategory($content["category"])
            ->setLocation($location)
            ->setPrice((int) $content["price"])
            ->setAvailability((int) $content["availability"])
            ->setImage($content["image"])
            ->setReputation((int) $content["reputation"])
            ->setRating((int) $content["rating"]);

        $this->accommodationRepository->insert($accommodation);

        $viewModel = new AccommodationViewModel();
        $viewModel->parseOne($accommodation);

        return $this->json($viewModel, Response::HTTP_CREATED);
    }
}
