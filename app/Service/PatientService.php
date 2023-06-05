<?php

namespace App\Service;

use App\Events\PatientCreated;
use App\Repository\PatientRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PatientService
{
    private const DAYS_IN_MONTH = 30;
    private const DAYS_IN_YEAR = 365;

    public function __construct(private readonly PatientRepository $repository, private readonly CacheService $cacheService)
    {}

    public function create(string $firstName, string $lastName, string $birthDate)
    {
        $birthDate = Carbon::createFromFormat('d.m.Y', $birthDate);
        $ageInDays = $birthDate->diffInDays(Carbon::now());
        $ageAttributes = $this->calculateAgeAttributes($ageInDays);

        $patient = $this->repository->store($firstName, $lastName, $birthDate, $ageAttributes['ageType'], $ageAttributes['age']);

        PatientCreated::dispatch($patient);
    }

    public function export(): Collection
    {
        $patients = $this->cacheService->getPatientList();

        if ($patients) {
            return collect(json_decode($patients));
        }

        $patients = $this->repository->export();
        $this->cacheService->setPatientList($patients);

        return $patients;
    }

    private function calculateAgeAttributes(int $ageInDays): array
    {
        return match (true) {
            $ageInDays < self::DAYS_IN_MONTH => ['age' => $ageInDays, 'ageType' => 'день'],
            $ageInDays < self::DAYS_IN_YEAR => ['age' => intdiv($ageInDays, self::DAYS_IN_MONTH), 'ageType' => 'месяц'],
            default => ['age' => intdiv($ageInDays, 365), 'ageType' => 'год'],
        };
    }
}
