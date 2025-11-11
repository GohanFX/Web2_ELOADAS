<?php

namespace Database\Seeders;

use App\Models\Race;
use App\utils\FileReading;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RaceSeeder extends Seeder
{

    public function run(): void
    {
        if (Race::exists()) {
            echo "Races already exist, skipping seeding.\n";
            return;
        }

        $rows = FileReading::read('eredmeny.csv');
        $rows = array_slice($rows, 1);

        foreach ($rows as $row) {
            if (empty($row[0])) continue;

            try {
                $formattedDate = Carbon::createFromFormat('Y.m.d', trim($row[0]))->format('Y-m-d');
            } catch (\Exception $e) {
                echo "Error parsing date for driver {$row[1]}: {$e->getMessage()}\n";
                $formattedDate = Carbon::parse(str_replace('.', '-', trim($row[0])))->format('Y-m-d');
            }


            $placement = isset($row[2]) && !empty(trim($row[2])) && is_numeric($row[2]) ? intval($row[2]) : null;
            $mistakeReason = isset($row[3]) && !empty(trim($row[3])) ? trim($row[3]) : null;
            $hasMistake = $mistakeReason !== null;

            $race = Race::create([
                'date' => $formattedDate,
                'driver_id' => isset($row[1]) && is_numeric($row[1]) ? intval($row[1]) : null,
                'placement' => $placement,
                'mistake' => $hasMistake,
                'team' => isset($row[4]) && !empty(trim($row[4])) ? trim($row[4]) : null,
                'type' => isset($row[5]) && !empty(trim($row[5])) ? trim($row[5]) : null,
                'engine' => isset($row[6]) && !empty(trim($row[6])) ? trim($row[6]) : null,
            ]);

            $placementText = $placement !== null ? "placement {$placement}" : "DNF ({$mistakeReason})";
            echo "Created Race: Driver ID {$race->driver_id} on {$race->date} with {$placementText}\n";
        }

    }
}
