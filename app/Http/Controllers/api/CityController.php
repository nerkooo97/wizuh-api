<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use Log;

class CityController extends BaseController
{
    /**
     * Display a listing of the resource with optional longitude and latitude.
     */
    public function index(Request $request)
    {
        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');

        if (!empty($longitude) && !empty($latitude)) {
            Log::info('Longitude: ' . $latitude);
            $cities = City::selectRaw("*, ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance", [$latitude, $longitude, $latitude])
                ->orderBy('distance')
                ->get();
        } else {
            $cities = City::all();
        }

        return $this->sendResponse($cities, 'Cities retrieved successfully.');
    }

    /**
     * Get the city by longitude and latitude.
     */
    public function getCityByLongitudeAndLatitude($longitude, $latitude)
    {
        if (!empty($longitude) && !empty($latitude)) {
            Log::info("Longitude: {$longitude}, Latitude: {$latitude}");
            $city = City::selectRaw("*, ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance", [$latitude, $longitude, $latitude])
                ->orderBy('distance')
                ->first();
        } else {
            $city = City::first();
        }

        return json_decode($city);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
