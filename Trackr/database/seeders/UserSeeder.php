<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    //const statusOptions = array('1'=>"healthy", '2'=>"sick", '3'=>"quarantine");
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Delete all current users to start fresh
        \App\Models\User::query()->delete();

        $faker = \Faker\Factory::create();

        foreach(range(1,100) as $number){
            $firstName = $faker->firstName();
            $lasName = $faker->lastName();
            $email= $faker->email();

            \App\Models\User::create([
                "first_name"=>$firstName,
                "last_name"=>$lasName,
                "middle_name"=>"M",
                "email"=>$email,
                "password"=>"qqqwwweee",
                "status"=>$this->status(),
                "vaccinated"=>(rand(0,1)==0) ? "no" : "yes",
                "last_login"=> new \DateTime(), 
                "account_type" => "user"
            ]);
        }
    }

    public function status(){
        $statusOptions = array('1'=>"healthy", '2'=>"sick", '3'=>"quarantine");
        return $statusOptions[rand(1,3)];
    }
}
