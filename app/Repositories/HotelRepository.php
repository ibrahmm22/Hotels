<?php

namespace App\Repositories;

use App\Models\Hotel;

class HotelRepository extends Repository
{
    public function __construct(Hotel $model)
    {
        $this->model = $model;
    }

    public function attachRoomFacilities(Hotel $hotel, array $facilities)
    {
        $hotel->roomFacilities()->createMany($facilities);
    }

    public function detachRoomFacilities(Hotel $hotel)
    {
        $hotel->roomFacilities()->delete();
    }

    public function all($filters, $sortedKey = 'id', $sortedMethod = 'ASC')
    {
        $query = $this->prepareFilters($filters);
        return $query->with(['country', 'city'])->orderBy($sortedKey, $sortedMethod)->get();
    }

    private function prepareFilters($filters): \Illuminate\Database\Eloquent\Builder
    {
        $query = $this->model->query();

        if (isset($filters['name']) and $filters['name'])
            $query->where('name', 'like', '%' . $filters['name'] . '%');

        if (isset($filters['price']) and $filters['price'])
            $query->where('price', $filters['price']);

        if (isset($filters['country']) && $filters['country']) {
            $query->whereHas('country', function ($q) use ($filters){
                return $q->where('countries.name', 'like', '%' . $filters['country'] . '%');
            });
        }

        if (isset($filters['city']) && $filters['city']) {
            $query->whereHas('city', function ($q) use ($filters) {
                return $q->where('cities.name', 'like', '%' . $filters['city'] . '%');
            });
        }

        return $query;
    }
}
