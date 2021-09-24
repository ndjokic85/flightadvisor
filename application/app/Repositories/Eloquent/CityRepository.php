<?php

namespace App\Repositories\Eloquent;

use App\Models\City;
use App\Repositories\ICityRepository;
use Illuminate\Database\Eloquent\Collection;

class CityRepository extends BaseRepository implements ICityRepository
{

    private array $defaultArgs = ['search' => '', 'comments_limit' => null];

    public function __construct(City $model)
    {
        parent::__construct($model);
    }

    public function findByName(string $name): ?City
    {
        return $this->model->whereName($name)->first();
    }

    public function filter(array $args = []): Collection
    {
        $args = array_merge($this->defaultArgs, $args);
        return $this->model->search($args['search'])->with(['comments'])
            ->get()->map(function ($query) use ($args) {
                return $query->setRelation('comments', $query->latestComments->take($args['comments_limit']));
            });
    }
}
