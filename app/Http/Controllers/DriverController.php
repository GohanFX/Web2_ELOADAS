<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Race;
use App\Models\GP;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::with('results')->paginate(20);
        // Render the Drivers CRUD index (paginated) for admin
        return view('drivers.index', [
            'drivers' => $drivers
        ]);
    }

    public function create()
    {
        return view('drivers.create');
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
        return view('drivers.edit', [
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

