<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('categories')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('categories')->insert([
            [
                'name' => 'Movies',
                'description' => '',
            ],
            [
                'name' => 'Games',
                'description' => '',
            ],
            [
                'name' => 'Sport',
                'description' => '',
            ],
            [
                'name' => 'TV series',
                'description' => '',
            ],
            [
                'name' => 'Science',
                'description' => '',
            ],
            [
                'name' => 'Programming',
                'description' => '',
            ],
            [
                'name' => 'Art',
                'description' => '',
            ],
            [
                'name' => 'Food',
                'description' => '',
            ],
        ]);
    }
}
