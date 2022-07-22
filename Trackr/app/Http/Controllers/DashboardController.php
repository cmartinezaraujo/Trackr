<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        if(Auth::user()->hasRole('user')){
            return redirect()->route('users.show', Auth::user()->id);
        } elseif(Auth::user()->hasRole('organization')){
            return redirect()->route('organizations.show', Auth::user()->organizationOwner->organization_id);
        }
    }
}
