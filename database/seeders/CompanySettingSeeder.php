<?php

namespace Database\Seeders;

use App\Models\CompanySetting;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!CompanySetting::exists()) {
            CompanySetting::create([
                'company_name' => 'Ninja Company',
                'company_email' => 'ninja@gmail.com',
                'company_phone' => '09765335267',
                'company_address' => 'Mandalay, Amarapura, Myint Nge',
                'office_start_time' => '09:00:00',
                'office_end_time' => '18:00:00',
                'break_start_time' => '12:00:00',
                'break_end_time' => '13:00:00',
            ]);

        }
    }
}
