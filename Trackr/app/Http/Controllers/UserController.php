<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = \App\Models\User::all();
        return view('users.index', ['People'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response 
     */
    public function show($id)
    {


        $user = \App\Models\User::findOrFail($id);
        $contacts  =  $this->fetchContacts($id, 'accepted');
        $pendingContacts = $user->pendingContactsOf;
        $Cases = $this->casesInNetwork($contacts);
        $organizations = $this->casesInOrganizations($user->organizations); //Organization Models
        $pendingOrganizations = $user->pendingOrganizations; //Organization_Member Models
        $notifications = $user->unreadNotifications;
        return view('users.show', ['User'=>$user, 'Network'=>$contacts, 'NetworkOrg'=>$organizations,
    'Reports'=>$Cases, 'PendingContacts' => $pendingContacts, 'PendingOrganizations'=>$pendingOrganizations, 'Notifications'=>$notifications]);
    }

    public function casesInNetwork($Network){
        $Cases = 0;
        foreach($Network as $person){
            $Cases = $Cases + $person->cases->count();
        }

        return $Cases;
    }

    public function casesInOrganizations($organizations){

        if($organizations->count() < 1){
            return array(); //Empty array so that we dont have to include a check in the blade file
        }

        $orgs = $organizations->map(function($organization,$key){

            $members = $organization->activeMembers;
            $reportsTotal  = 0;
            $reportsSick = 0;
            $reportsExposed =0;
            foreach($members as $member){
                $reportsTotal += $member->user->cases->count();
                $reportsSick += $member->user->cases->where('type', 'sick')->count();
                $reportsExposed += $member->user->cases->where('type', 'exposed')->count();
            }
            return array('org'=>$organization, 'reportsTotal'=>$reportsTotal, 'reportsSick'=>$reportsSick, 'reportsExposed'=>$reportsExposed);
        });

        return $orgs;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateStatus(Request $request, $id){
        \App\Models\User::findOrFail($id)->update(array('status'=>$request->new_status));
        return back();
    }

    /** 
     * Cesar: This function fetches the user contacts from sent
     * and recieved requests.
     * 
     * @param int $id
     * @param string $type 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function fetchContacts($id){
        $userReq = \App\Models\User::findOrFail($id)->contactsOfMine;
        $userAcc= \App\Models\User::findOrFail($id)->contactsOf;
        return $userReq->merge($userAcc);
    }
}
