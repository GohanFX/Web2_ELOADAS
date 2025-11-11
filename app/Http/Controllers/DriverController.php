<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Race;
use App\Models\GP;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::with('results')->paginate(20);
        return Inertia::render('Database/Index', [
            'drivers' => $drivers
        ]);
    }

    public function create()
    {
        return Inertia::render('Drivers/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sex' => 'required|in:F,N',
            'birth_date' => 'required|date',
            'country' => 'required|string|max:255',
        ]);

        Driver::create($validated);

        return redirect()->route('drivers.index')->with('success', 'Pilóta sikeresen hozzáadva!');
    }

    public function edit(Driver $driver)
    {
        return Inertia::render('Drivers/Edit', [
            'driver' => $driver
        ]);
    }

    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sex' => 'required|in:F,N',
            'birth_date' => 'required|date',
            'country' => 'required|string|max:255',
        ]);

        $driver->update($validated);

        return redirect()->route('drivers.index')->with('success', 'Pilóta sikeresen frissítve!');
    }

    public function destroy(Driver $driver)
    {
        $driver->delete();

        return redirect()->route('drivers.index')->with('success', 'Pilóta sikeresen törölve!');
    }
}

