<?php
namespace App\Services;

use App\Models\Hotel;
use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use App\Repositories\HotelRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;

class HotelService
{
    private $hotelRepository, $cityRepository, $countryRepository;

    public function __construct(HotelRepository $hotelRepository, CityRepository $cityRepository,
                                CountryRepository $countryRepository)
    {
        $this->hotelRepository = $hotelRepository;
        $this->cityRepository = $cityRepository;
        $this->countryRepository = $countryRepository;
    }

    public function list($filters, $sortedKey, $sortedMethod)
    {
        return $this->hotelRepository->all($filters, $sortedKey, $sortedMethod);
    }

    public function create(array $data, array $roomFacilities = null): bool
    {
        try {
            $data = $this->prepareData($data);
            DB::beginTransaction();
            $hotel = $this->hotelRepository->create($data);
            if ($roomFacilities) {
                $roomFacilities = $this->prepareFacilities($hotel->id, $roomFacilities);
                $this->hotelRepository->attachRoomFacilities($hotel, $roomFacilities);
            }
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            info($exception->getMessage());
            return false;
        }
    }

    public function show(int $id): Hotel
    {
        return $this->hotelRepository->find($id);
    }

    private function prepareFacilities(int $hotelId, array $data): array
    {
        $facilities = [];
        foreach ($data as $item) {
            $facilities[] = [
                'hotel_id' => $hotelId,
                'facilities' => $item
            ];
        }
        return $facilities;
    }

    private function prepareData(array $data): array
    {
        $city = $this->cityRepository->where('name', $data['city']);
        $country = $this->countryRepository->where('name', $data['country']);
        $data['city_id'] = $city->id;
        $data['country_id'] = $country->id;
        unset($data['city']);
        unset($data['country']);
        return $data;
    }

    public function update(int $id, array $data, array $roomFacilities = null): bool
    {
        try {
            $data = $this->prepareData($data);
            $hotel = $this->hotelRepository->find($id);
            DB::beginTransaction();
            $this->hotelRepository->update($data, $id);
            $this->hotelRepository->detachRoomFacilities($hotel);
            if ($roomFacilities) {
                $roomFacilities = $this->prepareFacilities($hotel->id, $roomFacilities);
                $this->hotelRepository->attachRoomFacilities($hotel, $roomFacilities);
            }
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            info($exception->getMessage());
            return false;
        }
    }

    public function delete($id)
    {
        $hotel = $this->hotelRepository->find($id);
        $this->hotelRepository->detachRoomFacilities($hotel);
        $this->hotelRepository->destroy($id);
    }
}
