<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator, Input, Redirect;
use Illuminate\Validation\Rule; 

class Organization_MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $OrganizationMembers = \App\Models\Organization_Member::all();
        return view('organization_members.index', ['OrganizationMembers'=> $OrganizationMembers]);
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
        //
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

    public function addMember(Request $request, $organization_id){
        
 

        Validator::make($request->all(), [
            'member_email' => ['required', 'string', 'email', 'max:255'],
            'role' => ['required', Rule::in(['leader', 'admin', 'support', 'member'])]
        ]);

        $member = \App\Models\User::where('email', $request->member_email)->get();
        
        if($member->count() < 1){
            return back()->with('error', "No user found with email:{$request->member_email}.");
        }elseif($member[0]->account_type == "organization"){
            return back()->with('error', "Invitation failed to send the email:{$request->member_email} belongs to an Organization.");
        }

        $existingInvitations = \App\Models\Organization_Member::where('organization_id', $organization_id)->where('member_id', $member[0]->id)->get();

        if($existingInvitations->count() > 0){
            return back()->with('error', "Invitation is already pending for email:{$request->member_email}.");
        }

        $validData = array(
            'organization_id' => $organization_id,
            'member_id' => $member[0]->id,
            'role' => $request->role,
            'invitation_status' => 'pending',
        );

        \App\Models\Organization_Member::create($validData);
        //Make Notification

        return back()->with('success', "Invitation to {$request->member_email} successfully sent.");

    }

    public function removeMember(Request $request, $id){
        $this->removeFromNetworks($request->organization_id, $id);
        \App\Models\Organization_Member::find($id)->delete();
        return back();
    }

    //EORM does not support composite keys so we have to remove user from networks manually
    public function removeFromNetworks($organizationId, $memberId){

        $network = \App\Models\Organization::find($organizationId);
        $user_id = \App\Models\Organization_Member::find($memberId)->user->id;

        $orgNets = $network->networks;
        if($orgNets){

            $network_ids = $orgNets->map(function ($item, $key){
                return $item->network_id;
            });
    
            $elegibleMembers = \App\Models\Organization_Member::find($memberId)->user->networks;
    
            $myNetworks = $elegibleMembers->map(function ($item, $key){
                return $item->network_id;
            });
    
        
    
            $toDelete = $network_ids->intersect($myNetworks);
            
            
            $elegibleMembers = \App\Models\Network_Member::whereIn('network_id', $toDelete->toArray())->where('member_id', $user_id)->get();
            foreach($elegibleMembers as $membership){
                $membership->delete();
            }
            //dd($elegibleMembers);
        }
    }

    public function respondToInvite($id, $status){
        /**
         * Iformation needed
         * organization_id
         * member_id
         */
        //dd($id);
        \App\Models\Organization_Member::find($id)->update(['invitation_status'=>$status]);
        return back();
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
}
