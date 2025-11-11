<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\GP;
use App\utils\FileReading;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Driver::exists()) {
            echo "Drivers already exist, skipping seeding.\n";
            return;
        }

        $rows = FileReading::read('pilota.csv');
        // Skip the first row (header)
        $rows = array_slice($rows, 1);

        foreach ($rows as $row) {
            // Row is now properly parsed as: [id, name, sex, birth_date, country]
            if (empty($row[0])) continue;

            try {
                $birthDate = isset($row[3]) && !empty($row[3])
                    ? Carbon::createFromFormat('Y.m.d', trim($row[3]))->format('Y-m-d')
                    : Carbon::now()->format('Y-m-d');
            } catch (\Exception $e) {
                echo "Error parsing date for {$row[1]}: {$e->getMessage()}\n";
                $birthDate = Carbon::now()->format('Y-m-d');
            }

            $driver = Driver::create([
                'id' => intval($row[0]),
                'name' => $row[1] ?? "",
                'sex' => $row[2] ?? "",
                'birth_date' => $birthDate,
                'country' => $row[4] ?? "",
            ]);

            echo "Created Driver: {$driver->name}, Sex: {$driver->sex}, Country: {$driver->country}\n";
        }

    }
}
