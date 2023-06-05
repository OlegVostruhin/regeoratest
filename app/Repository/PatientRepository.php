<?php

namespace App\Repository;

use App\Factory\PatientFactory;
use App\Models\Patient;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PatientRepository
{
    public function store($firstName, $lastName, $birthDate, $ageType, $age): Patient
    {
        $patient = PatientFactory::createPatient($firstName, $lastName, $birthDate, $ageType, $age);
        $patient->save();

        return $patient;
    }

    public function export(): Collection
    {
        return collect(DB::select("select CONCAT(first_name, ' ',last_name) as name,
                                 to_char(birth_date,'DD-MM-YYYY') as birth_date,
                                 CONCAT(age, ' ', age_type) as age from patients"));
    }
}
