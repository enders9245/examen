<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Company::create([
            'id' => 1,
            'user_id' => 1, // asegúrate que exista el user con id=1
            'business_name' => 'Capachica Tours',
            'trade_name' => 'Capachica Tours Oficial',
            'service_type' => 'Tour Operador',
            'contact_email' => 'info@capachicatours.com',
            'phone' => '987654321',
            'website' => 'https://capachicatours.com',
            'description' => 'Operador turístico especializado en actividades en Capachica.',
            'ruc' => '12345678901',
            'logo_url' => 'logo.png',
            'location_id' => 1, // Asegúrate que exista en tabla locations
            'status' => 'aprobada',
            'verified_at' => now(),
        ]);
    }
}
