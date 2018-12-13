<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DriverSeeder extends Seeder
{
    public function run()
    {
        DB::table('drivers')->insert(
            [
                'first_name' => 'Olu', 
                'last_name' => 'Omo',
                'password' => 'somerandompassword',
                'email' => 'hgarhuivh@gaol.com',
                'phone_no' => '080587474747',
                'address' => 'ghauhfuiahfiuayiufg7etb87tftd76ft',
                'driver_id' => 'driver_one'

            ]);
            DB::table('reports')->insert([
                [
                    'accident_address' => 'Somolu', 
                    'accident_report' => 'sending report 2',
                    'driver_id' => 4
                ], [
                    'accident_address' => 'Bsriga', 
                    'accident_report' => 'Report 658j',
                    'driver_id' => 4
                ], [
                    'accident_address' => 'VI', 
                    'accident_report' => 'lsending report 6',
                    'driver_id' => 4
                ]
            ]);
            DB::table('buses')->insert([
                [
                    'bus_product_name' => 'Nissan', 
                    'bus_plate_no' => '34trf6',
                    'driver_id' => 4
                ]
            ]);
    }

}
