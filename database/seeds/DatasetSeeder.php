<?php

use App\Dataset;
use Illuminate\Database\Seeder;

class DatasetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $people = factory(Dataset::class, 10)->create();
    }
}
