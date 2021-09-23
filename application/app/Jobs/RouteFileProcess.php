<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Repositories\IAirportRepository;
use App\Repositories\IRouteRepository;
use App\Validators\IValidator;
use Illuminate\Support\Facades\DB;

class RouteFileProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private IAirportRepository $airPortRepository;
    private IRouteRepository $routeRepository;
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
        IRouteRepository $routeRepository,
        IValidator $validator
    ) {
        $this->data = $data;
        $this->airPortRepository = $airPortRepository;
        $this->routeRepository = $routeRepository;
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
                $attributes = array_combine(config('app.route_import_fields'), $row);
                if ($this->validator->check($attributes)) {
                    $matchingFields = [
                        'source_airport_id' => $attributes['source_airport_id'],
                        'destination_airport_id' => $attributes['destination_airport_id'],
                    ];
                    $this->routeRepository->firstOrCreate($matchingFields, $attributes);
                }
            }
        });
    }
}
