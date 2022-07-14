<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\historyprospect;
use App\Models\prospect;
use App\Models\historysales;
use App\Models\sales;
use App\Models\agent;
use App\Models\project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.

     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
     /**
 * Prepare a date for array / JSON serialization.
 *
 * @param  \DateTimeInterface  $date
 * @return string
 */
    public function index(Request $request)
    {
        // $top_sales = sales::get_top_sales();
        // GET TOTAL ALL
        $total_leads = historyprospect::get_total_leads();
        if($total_leads[0]->total_leads == 0){
            return view('blank');
        }
        
        $project = historyprospect::get_project();
        
        $data = new \stdClass();
        $data = project::get_project(Auth::user()->UsernameKP);
        for($i=0; $i<count($data); $i++){
            $data[$i]->agent = historyprospect::get_project_agent($data[$i]->KodeProject);
        }
        for($i=0; $i<count($data); $i++){
            $leadsProject = historyprospect::prospect_per_project_all($data[$i]->KodeProject);
            $leadsNewTotal = historyprospect::prospect_per_project($data[$i]->KodeProject, 'New');
            $leadsProcessTotal = historyprospect::prospect_per_project($data[$i]->KodeProject, 'Process');
            $leadsClosingTotal = historyprospect::prospect_per_project($data[$i]->KodeProject, 'Closing');
            $leadsExpiredTotal = historyprospect::prospect_per_project($data[$i]->KodeProject, 'Expired');
            $leadsNotInterestedTotal = historyprospect::prospect_per_project($data[$i]->KodeProject, 'Not Interested');

            $data[$i]->leadsProject = $leadsProject[0]->total;
            $data[$i]->leadsNewTotal = $leadsNewTotal[0]->total;
            $data[$i]->leadsProcessTotal = $leadsProcessTotal[0]->total;
            $data[$i]->leadsClosingTotal = $leadsClosingTotal[0]->total;
            $data[$i]->leadsExpiredTotal = $leadsExpiredTotal[0]->total;
            $data[$i]->leadsNotInterestedTotal = $leadsNotInterestedTotal[0]->total;

            for($j=0; $j<count($data[$i]->agent); $j++){
                $data[$i]->agent[$j]->leads = historyprospect::get_prospect_agent($data[$i]->agent[$j]->KodeAgent);
                $data[$i]->agent[$j]->leadsNew = historyprospect::prospect_per_agent($data[$i]->agent[$j]->KodeAgent, 'New');
                $data[$i]->agent[$j]->leadsProcess = historyprospect::prospect_per_agent($data[$i]->agent[$j]->KodeAgent, 'Process');
                $data[$i]->agent[$j]->leadsClosing = historyprospect::prospect_per_agent($data[$i]->agent[$j]->KodeAgent, 'Closing');
                $data[$i]->agent[$j]->leadsExpired = historyprospect::prospect_per_agent($data[$i]->agent[$j]->KodeAgent, 'Expired');
                $data[$i]->agent[$j]->leadsNotInterested = historyprospect::prospect_per_agent($data[$i]->agent[$j]->KodeAgent, 'Not Interested');
            }
        }
        // dd($data);
        //GET PROSPECT DATA FOR CHART PROSPECT
        $prospect = prospect::get_total_prospect($request->bulan,$request->tahun);

        $ind = 0;$prospect_mkt=[];$prospect_sales=[];
        foreach($prospect as $item){
            //ambil prospect makuta or sales berdasarkan prospect.add date
            $prospect_mkt[]= prospect::prospect_level($prospect[$ind]->date,'Makuta');
            $prospect_sales[]= prospect::prospect_level($prospect[$ind]->date,'Sales');
            $ind++;
        }
        $all = prospect::total_prospect('All',$request->bulan,$request->tahun);
        $mkt = prospect::total_prospect('Makuta',$request->bulan,$request->tahun);
        $sales = prospect::total_prospect('Sales',$request->bulan,$request->tahun);

        $total_all = $all[0]->total_prospect;
        $total_mkt = $mkt[0]->total_prospect;
        $total_sales = $sales[0]->total_prospect;

        $result=[]; //GABUNGAN TOTAL ALL, MAKUTA DAN SALES
        $ind=0;
        foreach ($prospect as $value) {
            $result[$ind] = [(int)$value->day.' '.(string)$value->month,(int)$value->total_prospect, (int)$prospect_mkt[$ind][0]->total_prospect, (int)$prospect_sales[$ind][0]->total_prospect];
            $ind++;
        }

        //FOR SPARKLINE CHART
        $prospect2 = prospect::get_total_prospect2();
        $proses = prospect::get_proses();
        $closing = prospect::get_closing();
        $notInt = prospect::get_notInterested();

        // CHART PROSPECT AND SPARKLINE
        $data_total2 = [];
        $data_proses = [];
        $data_closing = [];
        $data_notInterested = [];
        $index = 0;
        $index=0;
        foreach($prospect2 as $item){
            $data_total2[] = $prospect2[$index]->total_prospect;
            $index++;
        }
        $index=0;
        foreach($proses as $item){
            $data_proses[] = $proses[$index]->total_prospect;
            $index++;
        }
        $index=0;
        foreach($closing as $item){
            $data_closing[] = $closing[$index]->total_prospect;
            $index++;
        }
        $index=0;
        foreach($notInt as $item){
            $data_notInterested[] = $notInt[$index]->total_prospect;
            $index++;
        }
        $index=0;

        // CHART PLATFORM
        $platform = prospect::get_platform();
        $namaPlatform = []; $total_platform =[];
        foreach($platform as $item){
            $namaPlatform[] = $platform[$index]->NamaPlatform;
            $total_platform[] = $platform[$index]->total;
            $index++;
        }
        $index=0;

        // CHART source
        $source = prospect::get_source();
        $namasource = []; $total_source =[];
        foreach($source as $item){
            $namasource[] = $source[$index]->NamaSumber;
            $total_source[] = $source[$index]->total;
            $index++;
        }
        
        //FIND TOP SALES BY CLOSING AMOUNT
        // $max = [];
        // $closing_amount_top_sales = agent::get_closing_amount_sales(Auth::user()->UsernameKP);
        // // dd($closing_amount_top_sales);
        // for($i = 0; $i < count($closing_amount_top_sales); $i++){
        //     for($j = 0; $j <= $i; $j++){
        //         if($closing_amount_top_sales[$i]->total > $closing_amount_top_sales[$j]->total || $closing_amount_top_sales[$j]->total == null){
        //             $max = $closing_amount_top_sales[$i];
        //             $j++;
        //         }
        //         else if($closing_amount_top_sales[$j]->total == null || $closing_amount_top_sales[$j]->total == ){

        //         }
        //     }
        //     $i++;
        // }
        // for($i = 0; $i < count($closing_amount_top_sales); $i++){
        //     if($closing_amount_top_sales[$i]->total == null){
        //         $i++;
        //     }
        //     else{
        //         for($j = 0; $j <= $i; $j++){
        //             if($closing_amount_top_sales[$j]->total == null){
        //                 $j++;
        //             }
        //             else if($closing_amount_top_sales[$i]->total > $closing_amount_top_sales[$j]->total){
        //                 $max = $closing_amount_top_sales[$i];
        //                 $j++;
        //             }
        //         }
        //         $i++;
        //     }
        // }
        // dd($max);

        $inprocess = historyprospect::get_inprocess();
        $closing = historyprospect::get_closing();
        $notInterested = historyprospect::get_notInterested();
        $expired = historyprospect::get_expired();
        $history = historysales::history();

        //  dd($history);
        return view('index',compact(
            'data',
            'total_leads',
            'inprocess',
            'closing',
            'notInterested',
            'data_total2',
            'data_proses',
            'data_closing',
            'data_notInterested',
            // 'object',
            'namaPlatform',
            'total_platform',
            'namasource',
            'total_source',
            'history','result',
            'total_all','total_mkt','total_sales'
        ));
    }

    // filter sparkline chart di dashboard
    public function notInterested(){
        $prospect = historyprospect::notInterested();
        $project = prospect::get_project();
        $status = prospect::get_status();
        $source= prospect::data('SumberData');
        $platform= prospect::data('SumberPlatform');
        $campaign= prospect::data('ProjectCampaign');
        $sales = sales::get_all(Auth::user()->NamaPT);
        return view('prospects.index', compact('prospect','project','status','platform','sales','campaign','source'));
    }
    public function closing(){
        $prospect = historyprospect::Closing();
        $project = prospect::get_project();
        $status = prospect::get_status();
        $source= prospect::data('SumberData');
        $platform= prospect::data('SumberPlatform');
        $campaign= prospect::data('ProjectCampaign');
        $sales = sales::get_all(Auth::user()->NamaPT);
        return view('prospects.index', compact('prospect','project','status','platform','sales','campaign','source'));
    }
    public function process(){
        $prospect = historyprospect::process();
        $project = prospect::get_project();
        $status = prospect::get_status();
        $source= prospect::data('SumberData');
        $platform= prospect::data('SumberPlatform');
        $campaign= prospect::data('ProjectCampaign');
        $sales = sales::get_all(Auth::user()->NamaPT);
        return view('prospects.index', compact('prospect','project','status','platform','sales','campaign','source'));
    }


}