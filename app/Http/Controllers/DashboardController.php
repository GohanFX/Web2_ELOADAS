<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Race;
use App\Models\GP;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard');
    }

    public function database()
    {
        $drivers = Driver::with('results')->limit(50)->get();
        $gps = GP::limit(50)->get();
        $races = Race::with('driver')->limit(50)->get();

        return Inertia::render('Database/Index', [
            'drivers' => $drivers,
            'gps' => $gps,
            'races' => $races
        ]);
    }

    public function chart()
    {
        // Get statistics for charts
        $driversByCountry = Driver::select('country', DB::raw('count(*) as total'))
            ->groupBy('country')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        $racesByYear = Race::select(DB::raw('YEAR(date) as year'), DB::raw('count(*) as total'))
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        $topDrivers = Driver::withCount('results')
            ->orderBy('results_count', 'desc')
            ->limit(10)
            ->get();

        return Inertia::render('Chart/Index', [
            'driversByCountry' => $driversByCountry,
            'racesByYear' => $racesByYear,
            'topDrivers' => $topDrivers
        ]);
    }

    public function admin()
    {
        $stats = [
            'total_drivers' => Driver::count(),
            'total_races' => Race::count(),
            'total_gps' => GP::count(),
            'total_contacts' => \App\Models\Contact::count(),
        ];

        return Inertia::render('Admin/Index', [
            'stats' => $stats
        ]);
    }
}

