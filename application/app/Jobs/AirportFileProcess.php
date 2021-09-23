<?php

namespace App\Jobs;

use App\Models\Airport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Repositories\IAirportRepository;
use App\Repositories\ICityRepository;
use App\Validators\IValidator;
use Illuminate\Support\Facades\DB;

class AirportFileProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private IAirportRepository $airPortRepository;
    private ICityRepository $cityRepository;
    private IValidator $validator;
    public array $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        array $data,
        IAirportRepository $airPortRepository,
        ICityRepository $cityRepository,
        IValidator $validator
    ) {
        $this->data = $data;
        $this->airPortRepository = $airPortRepository;
        $this->cityRepository = $cityRepository;
        $this->validator = $validator;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::transaction(function () {
            foreach ($this->data as $row) {
                $attributes = array_combine(config('app.airport_import_fields'), $row);
                unset($attributes['company']);
                if ($this->validator->check($attributes)) {
                    $city = $this->cityRepository->findByName($attributes['city']);
                    $attributes['city_id'] = $city->id;
                    $matchingFields = ['id' => $attributes['id']];
                    $this->airPortRepository->firstOrCreate($matchingFields, $attributes);
                }
            }
        });
    }
}
