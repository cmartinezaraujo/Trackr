<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add all users to new organization
        \App\Models\Organization::query()->delete();

        \App\Models\User::create([
            "first_name"=>"Cesar",
            "last_name"=>"Martinez",
            "middle_name"=>"M",
            "email"=>"cesar@gmail.com",
            "password"=>"qqqwwweee",
            "status"=>"healthy",
            "vaccinated"=>"yes",
            "last_login"=> new \DateTime(), 
            "account_type" => "organization"
        ]);

        \App\Models\Organization::create([
            'leader_id'=> 101,
            'organization_name'=> "Fullfillment Center GEG1"
        ]);

        foreach(range(1,100) as $user){
            \App\Models\Organization_Member::create([
                'organization_id'=> 1,
                'member_id'=> $user,
                'role'=> 'member',
                'invitation_status'=> 'accepted',
            ]);
        }
    }
}
