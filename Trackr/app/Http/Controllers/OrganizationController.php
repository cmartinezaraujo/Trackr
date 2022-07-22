<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Organizations = \App\Models\Organization::all();
        return view('organizations.index', ['Organizations'=>$Organizations]);
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
        $org = \App\Models\Organization::findOrFail($id);
        $members = $org->members;
        $pendingMembers = $this->pendingMembers($org->members);
        $activeMembers = $org->activeMembers;
        $memberReportsCount = $this->organizationReports($org);
        //dd($pendingMembers);

        $notifications = $org->owner->unreadNotifications;

        //$arr = array("chart":{"labels":["Mon","Tue","Wed","Thur","Fri","Sat","Sun"],"extra":null},"datasets":[{"name":"Cases","values":[1,2,3],"extra":null},{"name":"Members","values":[3,2,1],"extra":null}]}
        return view('organizations.show', ['Organization'=>$org, 
        'Members'=>$members, 
        'ReportCount'=>$memberReportsCount, 
        'Notifications'=>$notifications,
        'activeMembers' => $activeMembers,
        'pendingMembers' => $pendingMembers]);
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

    public function pendingMembers($members){
        $pendingMembers = collect();

        foreach($members as $member){

            if($member->invitation_status != 'accepted'){
                $pendingMembers->push($member);
            }
        }

        return $pendingMembers;
    }
    
    public function organizationReports($organizationModel){
        $reportsCount = 0;

        foreach($organizationModel->activeMembers as $member){
            $reportsCount += $member->user->cases->count();
        }
        return $reportsCount;
    }

    public function sendMessage(Request $request, $organization_id){

        $organization = \App\Models\Organization::findOrFail($organization_id);
        $organizationMembers = $organization->activeMembers;
        $memberModels = $organizationMembers->map(function($member, $key){
            return $member->user;
        });

        $messageData = [
            'body'=> "You have a pednding notification. Message from {$organization->organization_name}.",
            'reportText'=> 'View Message',
            'url'=> url('/'),
            'thankyou'=> 'Thank you',
             /**
             * Cesar:
             * The data bellow this will be used for DB notifications.
             * Index name must rename the same.
             * If you make a change here you will need to do it for all notifications.
             */
            'sender' => $organization->organization_name,
            'message' => $request->message
        ];

        Notification::send($memberModels, new \App\Notifications\OrganizationMessage($messageData));
        
        return back();
    }
}
