<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Doctor\CreateDoctorRequest;
use App\Http\Requests\Api\Doctor\UpdateDoctorRequest;
use App\Http\Resources\Api\DoctorResource;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Doctor::all();

        if ($data->isEmpty()) {
            return ResponseHelper::success('There is no doctor data.',);
        }

        return ResponseHelper::success(
            'Doctor data has been successfully retrieved',
            DoctorResource::collection($data)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateDoctorRequest $request)
    {
        $data = $request->validated();

        $doctor = DB::transaction(function () use ($data) {
            $randomPassword = Str::random(12);

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => 'doctor',
                'password' => Hash::make($randomPassword),
            ]);

            return Doctor::create(
                array_merge($data, [
                    'user_id' => $user->id,
                    'is_active' => true,
                ])
            );
        });

        $doctor->refresh();

        return ResponseHelper::success(
            'New doctor has been successfully added',
            new DoctorResource($doctor),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return ResponseHelper::apiError(
                'Doctor not found',
                null,
                404
            );
        }

        return ResponseHelper::success(
            'Doctor detail retrieved successfully',
            new DoctorResource($doctor)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request, string $id)
    {
        $doctor = Doctor::with('user')->find($id);

        if (!$doctor) {
            return ResponseHelper::apiError(
                'Doctor not found',
                null,
                404
            );
        }

        $data = $request->validated();

        DB::transaction(function () use ($doctor, $data) {

            if ($doctor->user) {

                if (
                    isset($data['email']) &&
                    $data['email'] !== $doctor->user->email
                ) {
                    $emailExists = User::where('email', $data['email'])->exists();

                    if ($emailExists) {
                        throw new \Exception('Email already exists.');
                    }
                }

                $userData = [];

                if (isset($data['name'])) {
                    $userData['name'] = $data['name'];
                }

                if (isset($data['email'])) {
                    $userData['email'] = $data['email'];
                }

                if (!empty($userData)) {
                    $doctor->user->update($userData);
                }
            }

            $doctorData = collect($data)
                ->except(['email'])
                ->toArray();

            if (!empty($doctorData)) {
                $doctor->update($doctorData);
            }
        });

        $doctor->refresh();

        return ResponseHelper::success(
            'Doctor data has been successfully updated',
            new DoctorResource($doctor)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doctor = Doctor::with('user')->find($id);

        if (!$doctor) {
            return ResponseHelper::apiError(
                'Doctor not found',
                null,
                404,
            );
        }

        DB::transaction(function () use ($doctor) {
            $doctor->delete();

            if ($doctor->user) {
                $doctor->user->delete();
            }
        });

        return ResponseHelper::success(
            'Doctor has been successfully deleted'
        );
    }
}
