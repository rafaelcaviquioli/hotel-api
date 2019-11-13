<?php

namespace App\Tests\Domain\Service;

use App\CrossCutting\Exception\ResourceNotFoundException;
use App\CrossCutting\Exception\ValidationEntityException;
use App\Domain\Service\AccommodationService;
use App\Infrastructure\Repository\AccommodationRepository;
use App\Tests\Helper\Mother\AccommodationMother;
use PHPUnit\Framework\TestCase;

class AccommodationServiceTest extends TestCase
{
    public function testInsert_ShouldThrowValidationEntityException_WhenCreateAccommodationWithInvalidContent()
    {
        $accommodationRepositoryMock = $this->createMock(AccommodationRepository::class);
        $accommodationService = new AccommodationService($accommodationRepositoryMock);
        $content = [
            'location' => [
                'city' => '', 'state' => '', 'country' => '',
                'address' => '', 'zip_code' => ''
            ],
            'name' => '', 'category' => '', 'price' => '',
            'availability' => '', 'image' => '',
            'reputation' => '', 'rating' => '',
        ];

        $this->expectException(ValidationEntityException::class);
        $accommodationService->createAccommodation($content);
    }

    public function testInsert_ShouldParseContentToAccommodationViewModel_WhenThereIsAValidContent()
    {
        $content = [
            'location' => [
                'city' => 'Cuernavaca',
                'state' => 'Morelos',
                'country' => 'Mexico',
                'address' => 'Boulevard Díaz Ordaz No. 9 Cantarranas',
                'zip_code' => 62448
            ],
            'name' => 'Example name',
            'category' => 'hotel',
            'price' => 1000,
            'availability' => 10,
            'image' => 'http://www.trigavo.com/hotel.jpeg',
            'reputation' => 500,
            'rating' => 4,
        ];
        $accommodationRepositoryMock = $this->createMock(AccommodationRepository::class);
        $accommodationRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->will($this->returnCallback(function ($accommodation) {
                return $accommodation;
            }));

        $accommodationService = new AccommodationService($accommodationRepositoryMock);
        $viewModel = $accommodationService->createAccommodation($content);
        $this->assertEquals($content['name'], $viewModel->name);
        $this->assertEquals($content['category'], $viewModel->category);
        $this->assertEquals($content['price'], $viewModel->price);
        $this->assertEquals($content['availability'], $viewModel->availability);
        $this->assertEquals($content['image'], $viewModel->image);
        $this->assertEquals($content['reputation'], $viewModel->reputation);
        $this->assertEquals($content['rating'], $viewModel->rating);
        $this->assertEquals($content['location']['city'], $viewModel->location->city);
        $this->assertEquals($content['location']['state'], $viewModel->location->state);
        $this->assertEquals($content['location']['country'], $viewModel->location->country);
        $this->assertEquals($content['location']['address'], $viewModel->location->address);
        $this->assertEquals($content['location']['zip_code'], $viewModel->location->zip_code);
    }

    public function testBook_ShouldThrowResourceNotFoundException_WhenRequestedAccommodationDontExists()
    {
        $accommodationRepositoryMock = $this->createMock(AccommodationRepository::class);
        $accommodationRepositoryMock
            ->expects($this->once())
            ->method('findOneById')
            ->will($this->returnValue(null));

        $accommodationService = new AccommodationService($accommodationRepositoryMock);

        $this->expectException(ResourceNotFoundException::class);
        $accommodationId = 999;
        $accommodationService->book($accommodationId);
    }

    public function testBook_ShouldPersistBook_WhenAccommodationIsBooked()
    {
        $accommodation = AccommodationMother::getAvailableAccommodation(10, 1);

        $accommodationRepositoryMock = $this->createMock(AccommodationRepository::class);
        $accommodationRepositoryMock
            ->expects($this->once())
            ->method('findOneById')
            ->with($accommodation->getId())
            ->will($this->returnValue($accommodation));

        $accommodationRepositoryMock
            ->expects($this->once())
            ->method('update')
            ->with($accommodation);

        $accommodationService = new AccommodationService($accommodationRepositoryMock);
        $bookedAccommodation = $accommodationService->book($accommodation->getId());

        $this->assertEquals(9, $bookedAccommodation->getAvailability(), "Because one accommodation was booked");
    }

    public function testBook_ShouldThrowValidationException_WhenThereIsNoAvailability()
    {
        $accommodation = AccommodationMother::getUnavailableAccommodation(1);

        $accommodationRepositoryMock = $this->createMock(AccommodationRepository::class);
        $accommodationRepositoryMock
            ->expects($this->once())
            ->method('findOneById')
            ->with($accommodation->getId())
            ->will($this->returnValue($accommodation));

        $accommodationRepositoryMock
            ->expects($this->never())
            ->method('update')
            ->with($accommodation);

        $accommodationService = new AccommodationService($accommodationRepositoryMock);

        $this->expectException(ValidationEntityException::class);
        $accommodationService->book($accommodation->getId());
    }

    public function testDelete_ShouldCallDeleteAccommodation_WhenAccommodationIsFound()
    {
        $accommodation = AccommodationMother::getAvailableAccommodation(10, 1);

        $accommodationRepositoryMock = $this->createMock(AccommodationRepository::class);
        $accommodationRepositoryMock
            ->expects($this->once())
            ->method('findOneById')
            ->with($accommodation->getId())
            ->will($this->returnValue($accommodation));

        $accommodationRepositoryMock
            ->expects($this->once())
            ->method('delete')
            ->with($accommodation);

        $accommodationService = new AccommodationService($accommodationRepositoryMock);
        $accommodationService->delete($accommodation->getId());
    }

    public function testDelete_ShouldThrowResourceNotFoundException_WhenRequestedAccommodationDontExists()
    {
        $accommodationRepositoryMock = $this->createMock(AccommodationRepository::class);
        $accommodationRepositoryMock
            ->expects($this->once())
            ->method('findOneById')
            ->will($this->returnValue(null));

        $accommodationRepositoryMock
            ->expects($this->never())
            ->method('delete');

        $accommodationService = new AccommodationService($accommodationRepositoryMock);

        $this->expectException(ResourceNotFoundException::class);
        $accommodationId = 999;
        $accommodationService->delete($accommodationId);
    }
}
