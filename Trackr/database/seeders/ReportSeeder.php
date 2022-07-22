<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Report::query()->delete();

        $faker = \Faker\Factory::create();

        foreach(range(1,100) as $id){
            foreach(range(0,rand(0,10)) as $report){
                \App\Models\Report::create([
                    'user_id'=> $id,
                    'type'=> (rand(0,1)==1) ? "sick" : "exposed",
                    'reported' => new \DateTime(),
                    'notes' => $faker->text($maxNbChars = 200),
                    'has_attachment'=> 'false',
                    'is_anonymous'=>"false",
                    'created_at'=> Carbon::now()->sub(rand(0,80),'day')
                ]);
            }
        }
    }
}
