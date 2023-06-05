<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientRequest;
use App\Http\Requests\ExportPatientsRequest;
use App\Service\PatientService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

class PatientController extends Controller
{
    public function __construct(private readonly PatientService $patientService)
    {
    }

    public function create(CreatePatientRequest $request): Response
    {
        $errors = [];

        try {
            $this->patientService->create($request->get('first_name'), $request->get('last_name'), $request->get('date'));
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            $errors[] = 'Something went wrong...';
        }

        return response([
            'success' => empty($errors),
            'errors' => $errors
        ]);
    }

    public function export(Request $request): Response
    {
        return response([$this->patientService->export()]);
    }
}
