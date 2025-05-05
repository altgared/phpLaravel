
<?php

namespace Database\Seeders;

use App\Models\Estatus;
use Illuminate\Database\Seeder;

class EstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estatus::create(['nombre' => 'abierto']);
        Estatus::create(['nombre' => 'en proceso']);
        Estatus::create(['nombre' => 'concluido']);
    }
}