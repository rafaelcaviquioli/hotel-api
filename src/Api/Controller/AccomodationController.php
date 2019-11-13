<?php

namespace App\Api\Controller;

use App\CrossCutting\Exception\ResourceNotFoundException;
use App\CrossCutting\Exception\NoContentException;
use App\Application\ViewModel\AccommodationViewModel;
use App\Application\ViewModel\AccommodationPayload;
use App\Domain\Entity\Accommodation;
use App\Domain\Entity\Location;
use App\Application\Filter\AccommodationFilter;
use App\Domain\Service\AccommodationService;
use App\Infrastructure\Repository\AccommodationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @Route("/api/accommodation")
 */
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
     * @Route("/{id}", methods={"GET"})
     * @SWG\Parameter(name="id", in="path", type="integer", description="Accommodation Id")
     * @SWG\Response(
     *     response=200,
     *     description="Found accommodation",
     *     @Model(type=AccommodationViewModel::class)
     * )
     * @SWG\Response(response=404, description="Accommodation was not found")
     */
    public function getAccommodation(int $id): Response
    {
        $accommodation = $this->accommodationRepository->findOneById($id);

        if ($accommodation == null) {
            throw new ResourceNotFoundException();
        }
        $viewModel = new AccommodationViewModel();
        $viewModel->parseOne($accommodation);

        return $this->json($viewModel, Response::HTTP_OK);
    }

    /**
     * @Route("", methods={"GET"})
     * @SWG\Response(response=204, description="There are no accommodations")
     * @SWG\Response(
     *     response=200,
     *     description="Found accommodations",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=AccommodationViewModel::class))
     *     )
     * )
     * @SWG\Parameter(name="rating", type="integer", in="query")
     * @SWG\Parameter(name="availabilityMoreThan", type="integer", in="query")
     * @SWG\Parameter(name="availabilityLessThan", type="integer", in="query")
     * @SWG\Parameter(name="category", type="string", in="query")
     */
    public function getAccommodations(Request $request): Response
    {
        $accommodationFilter = new AccommodationFilter(
            $request->query->get('rating'),
            $request->query->get('city'),
            $request->query->get('reputationBadge'),
            $request->query->get('availabilityMoreThan'),
            $request->query->get('availabilityLessThan'),
            $request->query->get('category')
        );

        $accommodations = $this->accommodationRepository->findWithFilters($accommodationFilter);

        if ($accommodations == null) {
            throw new NoContentException();
        }

        $viewModels = AccommodationViewModel::parseList($accommodations);

        return $this->json($viewModels, Response::HTTP_OK);
    }

    /**
     * @Route("", methods={"POST"})
     * @SWG\Parameter(
     *     name="accommodation",
     *     in="body",
     *     description="Accommodation",
     *     required=true,
     *     @Model(type=AccommodationPayload::class)
     * )
     * @SWG\Response(
     *     response=201,
     *     description="Accommodation created",
     *     @Model(type=AccommodationViewModel::class)
     * )
     * @SWG\Response(response=400, description="Bad request")
     */
    public function createAccommodation(Request $request)
    {
        $content = json_decode($request->getContent(), true);

        $accommodationViewModel = $this->accommodationService
            ->createAccommodation($content);

        return $this->json($accommodationViewModel, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}/book", methods={"PUT"})
     * @SWG\Parameter(name="id", in="path", type="integer", description="Accommodation Id")
     * @SWG\Response(
     *     response=200,
     *     description="Accommodation booked",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="availability", type="integer")
     *     )
     * )
     * @SWG\Response(response=400, description="Accommodation is not availability")
     * @SWG\Response(response=404, description="Accommodation was not found")
     */
    public function book(int $id): Response
    {
        $accommodation = $this->accommodationService->book($id);

        return $this->json([
            'availability' => $accommodation->getAvailability()
        ], Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     * @SWG\Parameter(name="id", in="path", type="integer", description="Accommodation Id")
     * @SWG\Response(response=200, description="Accommodation deleted")
     * @SWG\Response(response=404, description="Accommodation was not found")
     */
    public function delete(int $id): Response
    {
        $this->accommodationService->delete($id);

        return new Response(null, Response::HTTP_OK);
    }
}
