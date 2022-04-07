<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permissions = ['validasi', 'lolos', 'pembayaran', 'rekom-internal', 'rekom-eksternal', 'nim', 'manajamen'];

        for ($i=0; $i < count($permissions); $i++) {
            Permission::create([
                "name" => $permissions[$i],
            ]);
        }
    }
}
