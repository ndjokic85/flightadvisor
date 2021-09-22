<?php

namespace App\Repositories\Eloquent;

use App\Models\City;
use App\Repositories\ICityRepository;
use Illuminate\Database\Eloquent\Collection;

class CityRepository extends BaseRepository implements ICityRepository
{

    public function __construct(City $model)
    {
        parent::__construct($model);
    }

    public function findByName(string $name): ?City
    {
        return $this->model->where('name', $name)->first();
    }

    public function all(?int $commentsLimit): Collection
    {
        return $this->model->with(['comments'])->get()->map(function ($query) use ($commentsLimit) {
            return $query->setRelation('comments', $query->latestComments->take($commentsLimit));
        });
    }
}
