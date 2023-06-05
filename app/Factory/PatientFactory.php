<?php

namespace App\Factory;

use App\Models\Patient;

class PatientFactory
{
    public static function createPatient(string $firstName, string $lastName, string $birthDate, string $ageType, int $age): Patient
    {
        return new Patient([
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'birth_date'  => $birthDate,
            'age_type'    => $ageType,
            'age'        => $age
        ]);
    }
}
