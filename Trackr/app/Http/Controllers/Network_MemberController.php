<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Network_MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $NetworkMembers = \App\Models\Network_Member::all();
        return view('network_members.index', ['NetworkMembers'=>$NetworkMembers]);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function removeMember($id){
        \App\Models\Network_Member::find($id)->delete();
        return back();
    }

    public function addMember($network_id, $member_id){
        //dd($member_id);
        $allData = array(
            'network_id'=>$network_id,
            'member_id'=>$member_id,
            'created_at'=> new \DateTime()
            //'created_at'=>"2022-01-01 22:58:31"
        );

        \App\Models\Network_Member::create($allData);

        return back();
    }


}
