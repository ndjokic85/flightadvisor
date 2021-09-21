<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Repositories\IAirportRepository;
use App\Repositories\ICityRepository;

class AirportFileProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private IAirportRepository $airPortRepository;
    private ICityRepository $cityRepository;
    public array $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data, IAirportRepository $airPortRepository, ICityRepository $cityRepository)
    {
        $this->data = $data;
        $this->airPortRepository = $airPortRepository;
        $this->cityRepository = $cityRepository;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->data as $row) {
            $attributes = array_combine(config('app.airport_import_fields'), $row);
            unset($attributes['company']);
            $city = $this->cityRepository->findByName($attributes['city']);
            $airPort = $this->airPortRepository->find($attributes['id']);
            if ($city && !$airPort) {
                $attributes['city_id'] = $city->id;
                $this->airPortRepository->create($attributes);
            }
        }
    }
}
