<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\City;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Event::query();
        $id = $request->input('id');
        $category = $request->input('category');
        $city = $request->input('city');

        if ($request->has('category')) {
            $query->where('event_category.name', $category);
        }

        if ($request->has('city')) {
            $query->where('city.name', $city);
        }

        if ($request->has('id')) {
            $query->where('events.id', $id);
        }

        $query->orderBy('featured', 'desc');
        $query->join('city', 'events.city', '=', 'city.id')
            ->join('event_category', 'events.category', '=', 'event_category.id')
            ->select('events.*', 'city.name as city_name', 'event_category.name as category_name');

        $events = $query->get();

        return $this->sendResponse(EventResource::collection($events), 'Events retrieved successfully.');
    }

    public function getCities()
    {
        $cities = City::all();

        return $this->sendResponse($cities, 'Cities retrieved successfully.');
    }

    public function getCategories()
    {

        $categories = \DB::table('event_category')->select('id', 'name')->get();

        return $this->sendResponse($categories, 'Categories retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'city' => 'required',
            'category' => 'required',
            'date' => 'required',
            'time' => 'required',
            'image' => 'required'
        ]);

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
        }

        $event = Event::create(
            $request->only([
                'name',
                'description',
                'city',
                'category',
                'date',
                'time',
                'image',
            ])
        );

        $event->save();

        return $this->sendResponse(new EventResource($event), 'Event created successfully.');
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
