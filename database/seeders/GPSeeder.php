<?php

namespace Database\Seeders;

use App\Models\GP;
use App\utils\FileReading;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GPSeeder extends Seeder
{

    public function run(): void
    {
        if (GP::exists()) {
            echo "GPs already exist, skipping seeding.\n";
            return;
        }

        $rows = FileReading::read('gp.csv');
        // Skip the first row (header: datum, nev, helyszin)
        $rows = array_slice($rows, 1);

        foreach ($rows as $row) {
            // Row is now properly parsed as: [date, name, location]
            if (empty($row[0])) continue;

            try {
                $formattedDate = Carbon::createFromFormat('Y.m.d', trim($row[0]))->format('Y-m-d');
            } catch (\Exception $e) {
                echo "Error parsing date for {$row[1]}: {$e->getMessage()}\n";
                $formattedDate = Carbon::parse(str_replace('.', '-', trim($row[0])))->format('Y-m-d');
            }

            $gp = GP::create([
                'date' => $formattedDate,
                'name' => $row[1] ?? null,
                'location' => $row[2] ?? null,
            ]);

            echo "Created GP: {$gp->name} on {$gp->date} at {$gp->location}\n";
        }

    }
}
