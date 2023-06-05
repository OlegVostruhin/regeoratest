<?php

namespace App\Service;

use App\Models\Patient;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;

class CacheService
{
    const LAST_CREATED_PATIENT = 'lastCreatedPatient';
    const PATIENT_LIST = 'patientList';

    public function setLastCreatedPatient(Patient $patient)
    {
        return Redis::set(self::LAST_CREATED_PATIENT, $patient, 'EX', 300);
    }

    public function getPatientList()
    {
        return Redis::get(self::PATIENT_LIST);
    }

    public function setPatientList(Collection $patientList)
    {
        return Redis::set(self::PATIENT_LIST, $patientList, 'EX', 30);
    }
}
