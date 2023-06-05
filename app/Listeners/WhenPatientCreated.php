<?php

namespace App\Listeners;

use App\Events\PatientCreated;
use App\Jobs\ProcessPatient;
use App\Service\CacheService;

class WhenPatientCreated
{
    /**
     * Create the event listener.
     */
    public function __construct(private readonly CacheService $cacheService)
    {}

    /**
     * Handle the event.
     */
    public function handle(PatientCreated $event): void
    {
        ProcessPatient::dispatch($event->patient);
        $this->cacheService->setLastCreatedPatient($event->patient);
    }
}
