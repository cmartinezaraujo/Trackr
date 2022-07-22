<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Reports = \App\Models\Report::all();
        return view('reports.index', ['Reports'=>$Reports]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
       //
        //return view('reports.create', ['user'=>Auth::user()]);
    }

    public function makeReport($user_id){
        $user = \App\Models\User::find($user_id);
        return view('reports.create-form', ['user'=>$user]);
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

        $user = \App\Models\User::find($request->user_id);
        $validatedData = $request->validate(['type'=>'required']);
        $allData = array(
            'user_id'=>$request->user_id, 
            'type'=> $request->type,
            'reported'=> new \DateTime(),
            'notes'=> (empty($request->notes)) ? 'No notes.' : $request->notes,
            'has_attachment' =>'false', //CHANGE THIS WHEN FILES ARE IMPLEMENTED
            // 'is_anonymous' => ($request->anonymous == 'on') ? 'true' : 'false');
            'is_anonymous' => 'false');
        

       \App\Models\Report::create($allData);
       $this->sendReportNotification($user);
       return redirect()->route('users.show', $user); 
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
        $case = \App\Models\Report::find($id);

        return view('reports.show', ['caseInfo'=>$case]);
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

    /**
     * Cesar: Show all the reports in a users network.
     *
     * @param  int  $id
     * @return Illuminate\Support\Collection
     */
    public function showContactReports($id){
        $userReq = \App\Models\User::find($id)->contactsOfMine;
        $userAcc= \App\Models\User::find($id)->contactsOf;
        $contacts = $userReq->merge($userAcc);
        $cases  = collect([]);
        foreach($contacts as $user){
            $userCases = $user->cases;
            foreach($userCases as $case){
                $cases->push($case);
            }
        }
        //dd($cases);
        return view('reports.user.contact_reports', ['cases'=>$cases, 'user_id'=>$id]);
    }

    public function sendReportNotification($user){
        $reportData = [
            'body'=> "A user in your network has made a report please login to check your network.",
            'reportText'=> 'View Report',
            'url'=> url('/'),
            'thankyou'=> 'Thank you',
            /**
             * Cesar:
             * The data bellow this will be used for DB notifications.
             * Index name must rename the same.
             * If you make a change here you will need to do it for all notifications.
             */
            'sender' => $user->first_name,
            'message' => "A report has been made by {$user->first_name}."
        ];
        $users = $this->fetchContacts($user->id);

        $organizations = $user->organizations;
        foreach($organizations as $org){
            $users->push($org->owner);
        }
      
        Notification::send($users, new \App\Notifications\Report($reportData));
    }

    public function viewMemberReports($member_id){
        /* 
        * Need Member id
        * Grab reports from model
        * Send them to view
        */

        if(!$member_id){
            return back();
        }

        $memberUserModel = \App\Models\User::find($member_id);
        $reports = $memberUserModel->cases;

        return view('reports.network_member.network_member_reports', ['member'=>$memberUserModel, 'memberReports'=>$reports]);
    }


     /** 
     * Cesar: This function fetches the user contacts from sent
     * and recieved requests.
     * 
     * @param int $id
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function fetchContacts($id){
        $userReq = \App\Models\User::find($id)->contactsOfMine;
        $userAcc= \App\Models\User::find($id)->contactsOf;
        return $userReq->merge($userAcc);
    }

}
