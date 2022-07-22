<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Models\Organization;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Cesar:
     * Display the organization registration view.
     *
     * @return \Illuminate\View\View
     */
    public function createOrganization()
    {
        return view('auth.register_organization');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
    
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required']
        ]);

        if($request->role_id == 'organization'){
            $request->validate([
                'organization_name'=> ['required', 'string', 'max:255']
            ]);
        }

        //dd($request->user_type);
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'email' => $request->email,
            'status' => 'healthy',
            'vaccinated' => 'NA',
            'account_type' =>  $request->role_id ,
            'last_login' => new \DateTime(),
            'password' => Hash::make($request->password),
        ]);

        if($request->role_id == 'organization'){
            $this->attachOrganization($user, $request->organization_name);
        }

        $user->attachRole($request->role_id);


        event(new Registered($user));


        Auth::login($user);
        
        return redirect(RouteServiceProvider::HOME);
    }

    public function attachOrganization($user, $organization_name){

        $organization = Organization::create([
            'leader_id' => $user->id,
            'organization_name' =>$organization_name
        ]);
    }

}
