<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use \App\Modles\User;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $contacts = \App\Models\Contact::all();
        return view('contacts.index', ['Contacts'=>$contacts]);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function acceptContactRequest($user_id, $contact_id)
    {
        $contact_model = \App\Models\Contact::where('requester_id', $contact_id)->where('addressee_id', $user_id)->get();
        \App\Models\Contact::find($contact_model[0]->contact_id)->update(array('contact_status'=>'accepted'));

        return back();
    }


    /**
     * USE THIS FUNCTION TO REMOVE CONTACT AND REJECT A REQUEST
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        $contact_requested = \App\Models\Contact::where('requester_id', $id)->where('addressee_id', $request->contact_id)->get();
        if($contact_requested->count() > 0){
            $contact_requested[0]->delete();
        }

        $contact_addressed = \App\Models\Contact::where('requester_id', $request->contact_id)->where('addressee_id', $id)->get();
        if($contact_addressed->count() > 0){
            $contact_addressed[0]->delete();
        }

        return back();
    }

    public function addContact(Request $request, $requester_id){
        //Look for the addressee model
        
        $request->validate([
            'contact_email' => ['required', 'string', 'email', 'max:255']
        ]);
        
        $requesterModel = \App\Models\User::findOrFail($requester_id);
        
        $addressee = \App\Models\User::where('email', $request->contact_email)->get();

        //Check for existing User Model
        if($addressee->count() == 0){
            return back()->with('error', "A user with email {$request->contact_email} does not exist.");
        }

        $addresseeModel = $addressee[0];

        if($this->checkForExistingContact($requester_id, $addresseeModel->id)){
            return back()->with('error', "You have already sent a contact request to this user.");
        }elseif($this->checkForExistingContact($addresseeModel->id, $requester_id)){
            return back()->with('error', "You currently have a pending contact request from this member");
        }


        $allData = array(
            'requester_id'=>$requesterModel->id,
            'addressee_id'=>$addressee[0]->id,
            'contact_status'=>'pending'
        );
            
        \App\Models\Contact::create($allData);
        $this->sendRequestNotification($addresseeModel, $requesterModel);


        return back()->with('success', "A contact request has been sent to {$request->contact_email}.");
    }

    //Change this to a template instead
    public function checkForExistingContact($requesterId, $adreseeId){

        $existingRequests= \App\Models\Contact::where('requester_id', $requesterId)->where('addressee_id', $adreseeId)->get();

        return $existingRequests->count() > 0;
    }

    public function sendRequestNotification($addressee, $sender){
        $reportData = [
            'body'=> "{$addressee->first_name} you have a pending contact request from {$sender->first_name}",
            'reportText'=> 'View Request',
            'url'=> url('/'),
            'thankyou'=> 'Thank you',
            /**
             * Cesar:
             * The data bellow this will be used for DB notifications.
             * Index name must rename the same.
             * If you make a change here you will need to do it for all notifications.
             */
            'sender' => $sender->first_name,
            'message' => "{$addressee->first_name} you have a pending contact request from {$sender->first_name}"
        ];

        Notification::send($addressee, new \App\Notifications\ContactRequest($reportData));
    }
}
