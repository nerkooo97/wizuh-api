<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BuslinesResource;
use App\Models\BuslinesCompany;
use Illuminate\Http\Request;
use App\Models\Buslines;
use App\Models\BuslinesStation;
use Illuminate\Support\Facades\Log;

class BuslinesController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $this->buildQuery($request);
        $buslines = $query->get();
        
        $filteredBuslines = $this->filterBuslines($buslines, $request);

        return $this->sendResponse(BuslinesResource::collection(resource: $filteredBuslines), 'Bus Lines retrieved successfully.');
    }

    private function buildQuery(Request $request)
    {
        $query = Buslines::query();

        if ($request->has('start_city') && $request['start_city'] != null) {
            $this->applyStartCityFilter($query, $request->input('start_city'));
        }

        if ($request->has('end_city') && $request['start_city'] != null) {
            $this->applyEndCityFilter($query, $request->input('end_city'));
        }

        if ($request->has('date')) {
            $this->applyDateFilter($query, $request->input('date'));
        }

        return $query;
    }

    private function applyStartCityFilter($query, $startCity)
    {
        $query->whereHas('stations.city', function ($q) use ($startCity) {
            $q->where('name', $startCity)->where('type', 0);
        });
    }

    private function applyEndCityFilter($query, $endCity)
    {
        $query->whereHas('stations.city', function ($q) use ($endCity) {
            $q->where('name', $endCity)->where('type', 1);
        });
    }

    private function applyDateFilter($query, $date)
    {
        $dayOfWeek = ucfirst(\Carbon\Carbon::parse($date)->locale('hr')->dayName);
        $query->whereJsonContains('days_in_week', $dayOfWeek);
    }

    private function filterBuslines($buslines, $request)
    {
        return $buslines->map(function ($busline) use ($request) {
            $busline->stations = $busline->stations->filter(function ($station) use ($request) {
                return ($station->city->name == $request->input('start_city') && $station->type == 0) ||
                    ($station->city->name == $request->input('end_city') && $station->type == 1);
            })->values(); // Ensure stations is always a collection
            
            return $busline;
        });
    }


    public function getUserBuslines(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $query = Buslines::query();

        if ($request->busline_id) {
            $query->where('id', $request->busline_id);
        }

        $query->where('user_id', $user->id);
        $query->with('cityStart')->with('cityEnd')->with('stations');
        $query->with([
            'stations' => function ($query) {
                $query->with('city');
            }
        ]);
        $results = $query->get();

        foreach ($results as $busline) {
            $busline->days_in_week = json_decode($busline->days_in_week);
        }

        return $this->sendResponse($results, 'Buslines retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $busline = new Buslines();
        $busline->city_start = $request->city_start;
        $busline->city_end = $request->city_end;
        $busline->departure_time = $request->departure_time;
        $busline->arrival_time = $request->arrival_time;
        $busline->company_id = $request->company_id;
        $busline->days_in_week = json_encode($request->days_in_week);
        $busline->save();

        foreach ($request->bus_stops as $key => $stop) {
            $busStations = new BuslinesStation();
            $busStations->type = $stop['type_station'];
            $busStations->city_id = $stop['city_station'];
            $busStations->time = $stop['time_station'];
            $busStations->busline_id = $busline->id;
            $busStations->company_id = $request->company_id;
            $busStations->featured = 0;
            $busStations->save();
        }

        return $busStations;
    }

    public function updateBusiness(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
        ]);

        // Pronalaženje poslovnog subjekta
        $business = BuslinesCompany::where('user_id', $user->id)->firstOrFail();

        // Ažuriranje podataka samo ako su prisutni u requestu
        if ($request->has('name')) {
            $business->name = $request->name;
        }
        if ($request->has('description')) {
            $business->description = $request->description;
        }
        if ($request->has('phone')) {
            $business->phone = $request->phone;
        }
        if ($request->has('email')) {
            $business->email = $request->email;
        }
        if ($request->has('address')) {
            $business->address = $request->address;
        }
        if ($request->has('city')) {
            $business->city = $request->city;
        }

        // Čuvanje slike ako postoji
        if ($request->hasFile('img_logo')) {
            $image = $request->file('img_logo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
            $imagePath = "uploads/{$imageName}";
            $business->img_logo = $imagePath;
        }

        $business->save();

        return response()->json(['message' => 'Business updated successfully', 'business' => $business], 200);
    }

}
