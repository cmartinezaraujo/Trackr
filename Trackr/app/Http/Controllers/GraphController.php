<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class GraphController extends Controller
{
    
    /*
    *   Organization Network Graphs
    */

    //-------------------Organization Graph Respond-----------------------
    public function showOrganizationGraphs($organization_id){
        $enDate = Carbon::now()->locale('en_US');//Grab current date info first
        $organizationModel = \App\Models\Organization::find($organization_id);

        $weekData = $this->getWeeklyStats($organizationModel, $enDate)->toJson();
        $weekLabels = $this->getWeeklyLabels();
        $monthData = $this->getMonthlyStats($organizationModel, $enDate)->toJson();
        $monthLabels = $this->getMonthlyLabels($enDate);
        $yearData = $this->getYearlyStats($organizationModel, $enDate)->toJson();
        $yearLabels = $this->getYearLabels();
        return view('graphs.organization_graphs', 
        [
            'organizationModel'=>$organizationModel, 
            'weekData'=>$weekData,
            'monthData'=>$monthData, 
            'monthLabels'=>$monthLabels, 
            'weekLabels'=>$weekLabels,
            'yearData'=>$yearData,
            'yearLabels'=>$yearLabels
        ]);
    }

    //-------------------Organization Week Graph-----------------------
    public function getWeeklyStats($organizationModel, $enDate){
        /*
            Carbon date format 
            start day (int value 0) Sunday
            start day (int value 1) Monday
        */

        //Structure to hold data for each day fo the week 
        $validDataRaw = collect();
        for($i = 0; $i <= 6; $i++){
            $validDataRaw->put($i, collect());
        }

        //dd(Carbon::parse($enDate->format('Y-m-d'))->dayOfWeek);

     
        $allReports = collect();
        //Grab reports from all active users
        foreach($organizationModel->activeMembers as $member){
            $memberCases = $member->user->cases;
            if($memberCases->count() > 0){
                $memberData = collect();
                $memberData->put('cases', $memberCases);
                $memberData->put('joined', $member->updated_at);
                $allReports->push($memberData);
            }
        }

        //Grab all valid reports
        foreach($allReports as $memberData){
            $reports = $memberData['cases'];
            $joinedDate = $memberData['joined'];
            $startOfWeek = $enDate->startOfWeek()->toDateTimeString();

            foreach($reports as $report){
                $reportDate = $report->created_at;
                if($reportDate->greaterThan($joinedDate)){
                    if($reportDate->greaterThan($startOfWeek)){
                        $validDataRaw[Carbon::parse($report->created_at->format('Y-m-d'))->dayOfWeek]->push($report);
                    }
                }
            }
        }

        
        $dataCount = collect();
        for($i = 0; $i <= 6; $i++){
            $dataCount->push($validDataRaw[$i]->count());
        }

        //dd($organizationModel->created_at->lessThan($en->toDateTimeString()));
        
        //dd($en->startOfWeek()->format('Y-m-d H:i'));

          return $dataCount;
    }

    public function getWeeklyLabels(){
        $labels = '["Sun","Mon","Tue","Wed","Thur","Fri","Sat"]';
        return $labels;
    }


    //-------------------Organization Month Graph-----------------------
    public function getMonthlyStats($organizationModel, $enDate){
            /*
            Carbon date format 
            start day (int value 0) Sunday
            start day (int value 1) Monday
        */
        $numberOfDays = $enDate->daysInMonth;
    

        //Structure to hold data for each day fo the week 
        $validDataRaw = collect();
        for($i = 1; $i <= $numberOfDays; $i++){
            $validDataRaw->put($i, collect());
        }

        //dd($validDataRaw);

        //dd(Carbon::parse($enDate->format('Y-m-d'))->dayOfWeek);

     
        $allReports = collect();
        //Grab reports from all active users
        foreach($organizationModel->activeMembers as $member){
            $memberCases = $member->user->cases;
            if($memberCases->count() > 0){
                $memberData = collect();
                $memberData->put('cases', $memberCases);
                $memberData->put('joined', $member->updated_at);
                $allReports->push($memberData);
            }
        }

        //Grab all valid reports
        foreach($allReports as $memberData){
            $reports = $memberData['cases'];
            $joinedDate = $memberData['joined'];
            $startOfMonth = $enDate->startOfMonth();

            
            foreach($reports as $report){
                $reportDate = $report->created_at;
                if($reportDate->greaterThan($joinedDate)){
                    if($reportDate->greaterThan($startOfMonth) && $reportDate->month == $startOfMonth->month && $reportDate->year == $startOfMonth->year ){
                        $validDataRaw[$report->created_at->day]->push($report);
                    }
                }
            }
        }
        
        
        $dataCount = collect();
        for($i = 1; $i <= $numberOfDays; $i++){
            $dataCount->push($validDataRaw[$i]->count());
        }

          return $dataCount;
    }

    public function getMonthlyLabels($enDate){
        $numberOfDays = $enDate->daysInMonth;
        $month = $enDate->month;
        $labels = collect();
        for($i = 1; $i <= $numberOfDays; $i++){
            $label = "{$month}-{$i}";
            $labels->push($label);
        }
        //dd($labels->toJson());
        return $labels->toJson();
    }

     //-------------------Organization Year Graph-----------------------
     public function getYearlyStats($organizationModel, $enDate){

        $currentMonth = $enDate;
        $yearDataCount = collect();

        for($i = 0; $i < 12; $i++){
            $currentMonth = $enDate->startOfYear()->add($i,'month');
            $monthDataRaw = $this->getMonthlyStats($organizationModel, $currentMonth);
            $monthDataCount = 0;
            foreach($monthDataRaw as $dayCount){
                $monthDataCount += $dayCount;
            }
            $yearDataCount->push($monthDataCount);
        }
         return $yearDataCount;
     }

     public function getYearLabels(){
        $labels = '["Jan","Feb","Mar","Apr","May","Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]';
        return $labels;
     }


      /*
    *   Organization Network Graphs-------------------------------------
    */

    public function showOrganizationNetworkGraphs($network_id){
        $enDate = Carbon::now()->locale('en_US');//Grab current date info first
        $networkModel = \App\Models\Organization_Network::find($network_id);
        $weekData = $this->getOrganizationNetworksWeeklyStats($networkModel, $enDate);
        $weekLabels = $this->getWeeklyLabels();
        $monthData = $this->getOrganizationNetworksMonthlyStats($networkModel, $enDate);
        $monthLabels = $this->getMonthlyLabels($enDate);
        $yearData = $this->getOrganizationNetworksYearlyStats($networkModel, $enDate);
        $yearLabels = $this->getYearLabels();
        
        return view('graphs.organization_network_graphs', 
        [
            'networkModel'=>$networkModel, 
            'weekData'=>$weekData,
            'monthData'=>$monthData, 
            'monthLabels'=>$monthLabels, 
            'weekLabels'=>$weekLabels,
            'yearData'=>$yearData,
            'yearLabels'=>$yearLabels
        ]);
    }

     public function getOrganizationNetworksWeeklyStats($networkModel, $enDate){
                /*
            Carbon date format 
            start day (int value 0) Sunday
            start day (int value 1) Monday
        */

        //Structure to hold data for each day fo the week 
        $validDataRaw = collect();
        for($i = 0; $i <= 6; $i++){
            $validDataRaw->put($i, collect());
        }

        //dd(Carbon::parse($enDate->format('Y-m-d'))->dayOfWeek);

     
        $allReports = collect();
        //Grab reports from all active users
        foreach($networkModel->members as $member){
            $memberCases = $member->user->cases;
            if($memberCases->count() > 0){
                $memberData = collect();
                $memberData->put('cases', $memberCases);
                $memberData->put('joined', $member->created_at);
                $allReports->push($memberData);
            }
        }

        //Grab all valid reports
        foreach($allReports as $memberData){
            $reports = $memberData['cases'];
            $joinedDate = $memberData['joined'];
            $startOfWeek = $enDate->startOfWeek()->toDateTimeString();

            foreach($reports as $report){
                $reportDate = $report->created_at;
                if($reportDate->greaterThan($joinedDate)){
                    if($reportDate->greaterThan($startOfWeek)){
                        $validDataRaw[Carbon::parse($report->created_at->format('Y-m-d'))->dayOfWeek]->push($report);
                    }
                }
            }
        }

        
        $dataCount = collect();
        for($i = 0; $i <= 6; $i++){
            $dataCount->push($validDataRaw[$i]->count());
        }
        
        //dd($organizationModel->created_at->lessThan($en->toDateTimeString()));
        
        //dd($en->startOfWeek()->format('Y-m-d H:i'));

          return $dataCount;
     }

     public function getOrganizationNetworksMonthlyStats($networkModel, $enDate){
         /*
            Carbon date format 
            start day (int value 0) Sunday
            start day (int value 1) Monday
        */
        $numberOfDays = $enDate->daysInMonth;
    

        //Structure to hold data for each day fo the week 
        $validDataRaw = collect();
        for($i = 1; $i <= $numberOfDays; $i++){
            $validDataRaw->put($i, collect());
        }

        //dd($validDataRaw);

        //dd(Carbon::parse($enDate->format('Y-m-d'))->dayOfWeek);

     
        $allReports = collect();
        //Grab reports from all active users
        foreach($networkModel->members as $member){
            $memberCases = $member->user->cases;
            if($memberCases->count() > 0){
                $memberData = collect();
                $memberData->put('cases', $memberCases);
                $memberData->put('joined', $member->created_at);
                $allReports->push($memberData);
            }
        }

        //Grab all valid reports
        foreach($allReports as $memberData){
            $reports = $memberData['cases'];
            $joinedDate = $memberData['joined'];
            $startOfMonth = $enDate->startOfMonth();

            
            foreach($reports as $report){
                $reportDate = $report->created_at;
                if($reportDate->greaterThan($joinedDate)){
                    if($reportDate->greaterThan($startOfMonth) && $reportDate->month == $startOfMonth->month && $reportDate->year == $startOfMonth->year ){
                        $validDataRaw[$report->created_at->day]->push($report);
                    }
                }
            }
        }
        
        
        $dataCount = collect();
        for($i = 1; $i <= $numberOfDays; $i++){
            $dataCount->push($validDataRaw[$i]->count());
        }

          return $dataCount;
     }

     public function getOrganizationNetworksYearlyStats($networkModel, $enDate){
        $currentMonth = $enDate;
        $yearDataCount = collect();

        for($i = 0; $i < 12; $i++){
            $currentMonth = $enDate->startOfYear()->add($i,'month');
            $monthDataRaw = $this->getOrganizationNetworksMonthlyStats($networkModel, $currentMonth);
            $monthDataCount = 0;
            foreach($monthDataRaw as $dayCount){
                $monthDataCount += $dayCount;
            }
            $yearDataCount->push($monthDataCount);
        }
         return $yearDataCount;
     }


      /*
    *   User Network Graphs-------------------------------------------
    */

    public function showUserGraphs($user_id){
        $enDate = Carbon::now()->locale('en_US');//Grab current date info first
        $user_model = \App\Models\User::find($user_id);
        $weekData = $this->getWeeklyUserStats($user_model, $enDate)->toJson();
        $weekLabels = '["Inner Network Cases", "Outter Network Cases"]';
        return view('graphs.user_graphs', [
            'user' => $user_model,
            'weekData' => $weekData,
            'weekLabels' => $weekLabels
        ]);
    }

    public function getWeeklyUserStats($user_model, $enDate){

  
        $contacts = $this->fetchUserContacts($user_model->id);

        $allReportCollections = collect();
        
        foreach($contacts as $user){
            $contactReports = $user->cases;
            if($contactReports->count() > 0){
                $allReportCollections->push($contactReports);
            }
        }

        
        //Filter all inner network cases
        $allInnerReports = $this->reduceMatrixCollections($allReportCollections);
        $filteredInnerReports= $this->filterReportCollectionByWeek($allInnerReports, $enDate->startOfWeek());
        $allInnerReportsId = $this->getCollectionIds($filteredInnerReports, 'report_id');

        //Filter and subtract inner cases from outer cases and ignore cases reported by current user
        $allOuterReports = $this->casesAroundNetwork($contacts, $user_model->id);
        $filteredOuterReports= $this->filterReportCollectionByWeek($allOuterReports, $enDate->startOfWeek());
        $outerReportsId = $this->getCollectionIds($filteredOuterReports, 'report_id');
        $allValidOuterReports = $outerReportsId->diff($allInnerReportsId->toArray())->unique();

        
        return collect([$allInnerReportsId->count(),$allValidOuterReports->count()]);
    }

    public function filterReportCollectionByWeek($reports, $startOfWeek){
        $filteredCollection = collect();
        foreach($reports as $report){
            $reportDate = $report->created_at;
                if($reportDate->greaterThan($startOfWeek)){
                    $filteredCollection->push($report);
                }
            
        }
        return $filteredCollection;
    }

    public function reduceMatrixCollections($collections){
        $reducedCollection = collect();
        foreach($collections as $collection){
            foreach($collection as $item){
                $reducedCollection->push($item);
            }
        }
        return $reducedCollection;
    }

    public function getCollectionIds($collection, $key){
        $collectionKeys = collect();
            foreach($collection as $item){
                $collectionKeys->push($item->$key);
            }
        return $collectionKeys;
    }


    public function casesAroundNetwork($contacts, $originUser_id){
        
        $outerNetwork = collect();

        foreach($contacts as $user){
            $network = $this->fetchUserContacts($user->id);
            if($network->count() > 0 ){
                $outerNetwork->push($network);
            }
        }

        $outerCases = collect();

        foreach($outerNetwork as $contacts){
            foreach($contacts as $user){
                if($user->id != $originUser_id){
                    $cases = $user->cases;
                    if($cases->count() > 0){
                        $outerCases->push($cases);
                    }
                }
            }
        }

        return $this->reduceMatrixCollections($outerCases);
    }


    public function fetchUserContacts($id){
        $userReq = \App\Models\User::find($id)->contactsOfMine;
        $userAcc= \App\Models\User::find($id)->contactsOf;
        return $userReq->merge($userAcc);
    }
}
