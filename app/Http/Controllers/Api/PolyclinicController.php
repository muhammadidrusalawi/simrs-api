<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Polyclinic\CreatePolyclinicRequest;
use App\Http\Requests\Api\Polyclinic\UpdatePolyclinicRequest;
use App\Http\Resources\Api\PolyclinicResource;
use App\Models\Polyclinic;
use Illuminate\Http\Request;

class PolyclinicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Polyclinic::all();

        if ($data->isEmpty()) {
            return ResponseHelper::success(
                'There is no polyclinic data.'
            );
        }

        return ResponseHelper::success(
            'Polyclinic data has been successfully retrieved',
            PolyclinicResource::collection($data)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePolyclinicRequest $request)
    {
        $data = $request->validated();

        $polyclinic = Polyclinic::create($data);

        return ResponseHelper::success(
            'New polyclinic has been successfully added',
            new PolyclinicResource($polyclinic),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $polyclinic = Polyclinic::find($id);

        if (!$polyclinic) {
            return ResponseHelper::apiError(
                'Polyclinic not found',
                404
            );
        }

        return ResponseHelper::success(
            'Polyclinic detail retrieved successfully',
            new PolyclinicResource($polyclinic)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePolyclinicRequest $request, string $id)
    {
        $data = $request->validated();

        $polyclinic = Polyclinic::find($id);

        if (!$polyclinic) {
            return ResponseHelper::apiError(
                'Polyclinic not found',
                404
            );
        }

        $polyclinic->update($data);

        return ResponseHelper::success(
            'Polyclinic has been successfully updated',
            new PolyclinicResource($polyclinic)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $polyclinic = Polyclinic::find($id);

        if (!$polyclinic) {
            return ResponseHelper::apiError(
                'Polyclinic not found',
                404
            );
        }

        $polyclinic->delete();

        return ResponseHelper::success(
            'Polyclinic has been successfully deleted'
        );
    }
}
