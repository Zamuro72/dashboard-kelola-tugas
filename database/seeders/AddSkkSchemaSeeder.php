<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jasa;
use App\Models\Skema;

class AddSkkSchemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jasa = Jasa::where('nama_jasa', 'SKK,SLO,SLF & SBU')->first();

        if ($jasa) {
            // Update jasa to enable schema
            $jasa->update(['has_skema' => true]);

            $schemas = [
                'SKK',
                'SLO',
                'SLF',
                'SBU',
            ];

            foreach ($schemas as $schema) {
                Skema::firstOrCreate([
                    'jasa_id' => $jasa->id,
                    'nama_skema' => $schema,
                ]);
            }

            $this->command->info('Schemas added successfully for SKK,SLO,SLF & SBU');
        } else {
            $this->command->error('Jasa SKK,SLO,SLF & SBU not found!');
        }
    }
}
