<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Patient\CreatePatientRequest;
use App\Http\Requests\Api\Patient\UpdatePatientRequest;
use App\Http\Resources\Api\PatientResource;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Patient::all();

        if ($data->isEmpty()) {
            return ResponseHelper::success('There is no patient data.',);
        }

        return ResponseHelper::success(
            'Patient data has been successfully retrieved',
            PatientResource::collection($data)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePatientRequest $request)
    {
        $data = $request->validated();

        $patient = DB::transaction(function () use ($data) {
            $user = null;

            if (!empty($data['create_user']) && $data['create_user']) {
                $randomPassword = Str::random(12);

                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'role' => 'patient',
                    'password' => Hash::make($randomPassword),
                ]);
            }

            $patientData = array_merge($data, [
                'identity_number' => Crypt::encryptString($data['identity_number']),
            ]);

            if ($user) {
                $patientData['user_id'] = $user->id;
            }

            $patient = Patient::create($patientData);

            return $patient;
        });

        $patient->refresh();

        return ResponseHelper::success(
            'New patient has been successfully added',
            new PatientResource($patient),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return ResponseHelper::apiError(
                'Patient not found',
                404
            );
        }

        return ResponseHelper::success(
            'Patient detail retrieved successfully',
            new PatientResource($patient)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, string $id)
    {
        $patient = Patient::with('user')->findOrFail($id);
        $data = $request->validated();

        DB::transaction(function () use ($patient, $data) {
            if (!empty($data['create_user']) && !$patient->user) {

                if (empty($data['email'])) {
                    throw new \Exception('Email is required to create user account.');
                }

                if (User::where('email', $data['email'])->exists()) {
                    throw new \Exception('Email already exists.');
                }

                $user = User::create([
                    'name' => $data['name'] ?? $patient->name,
                    'email' => $data['email'],
                    'role' => 'patient',
                    'password' => bcrypt(Str::random(12)),
                ]);

                $patient->user_id = $user->id;
            }

            if ($patient->user && !empty($data['email'])) {
                if (
                    $data['email'] !== $patient->user->email &&
                    User::where('email', $data['email'])->exists()
                ) {
                    throw new \Exception('Email already exists.');
                }

                $patient->user->update([
                    'email' => $data['email'],
                    'name' => $data['name'] ?? $patient->user->name,
                ]);
            }

            if (isset($data['identity_number'])) {
                $data['identity_number'] = encrypt($data['identity_number']);
            }

            unset($data['email'], $data['create_user']);

            $patient->update($data);
            $patient->save();
        });

        return ResponseHelper::success(
            'Patient has been successfully updated',
            new PatientResource($patient->refresh())
        );
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::transaction(function () use ($id, &$patient) {
            $patient = Patient::with('user')->findOrFail($id);

            if ($patient->user) {
                $patient->user->delete();
            }

            $patient->delete();
        });

        return ResponseHelper::success('Patient has been successfully deleted');
    }
}
