<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Organization_NetworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $OrganizationNetworks = \App\Models\Organization_Network::all();
        return view('organization_networks.index', ['OrganizationNetworks'=>$OrganizationNetworks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('organization_networks.create');
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
        $validatedData = $request->validate(['network_name'=>'required']);
        $allData = array('organization_id'=>$request->organization_id,
                        'creator_id' => $request->creator_id,
                        'network_name'=> $request->network_name);

        \App\Models\Organization_Network::create($allData);

        return back();
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
        $network = \App\Models\Organization_Network::findOrFail($id);
        $memberReportsCount = $this->organizationNetworkReports($network);
        return view('organization_networks.show', ['network'=>$network, 'reportsCount'=>$memberReportsCount]);
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
        $model = \App\Models\Organization_Network::findOrFail($id);
        $organization_origin = $model->organization_id;
        $model->delete();

        return redirect()->route('organizations.show', [$organization_origin]);
    }

    public function organizationNetworkReports($networkModel){
        $reportsCount = 0;
        foreach($networkModel->members as $member){
            $reportsCount += $member->user->cases->count();
        }
        return $reportsCount;
    }

    public function search($id){
        $network = \App\Models\Organization_Network::findOrFail($id);
        $networkMembers = $network->members;
        //dd($networkMembers);

        $member_ids = $networkMembers->map(function ($item, $key){
            return $item->member_id;
        });

        $elegibleMembers = $network->organization->activeMembers;
        
        $elegibleMembers = $elegibleMembers->diff(\App\Models\Organization_Member::whereIn('member_id', $member_ids->toArray())->get());


        //dd($elegibleMembers);
        return view('organization_networks.search', ['Network'=>$network, 'Members'=>$elegibleMembers]);
    }

}
