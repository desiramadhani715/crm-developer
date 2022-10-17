<?php

namespace App\Http\Controllers;

use App\Exports\ProspectExport;
use Illuminate\Http\Request;
use App\Models\prospect;
use App\Models\historyprospect;
use App\Models\historyblast;
use App\Models\historysales;
use App\Models\userPT;
use App\Models\User;
use App\Models\sales;
use App\Models\agent;
use App\Models\project;
use App\Models\RemindStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp;
use Excel;
use App\Exports\ProspecExport;
use App\Models\demografi;
use App\Models\historyprospectmove;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use App\Mail\MakutaproMailProspect;
use Illuminate\Support\Facades\Mail;
use App\Helper\Helper;
use \stdClass;

class ProspectsController extends Controller
{

    public function getFilter(){
        $request = new stdClass();
        $request->project = Session::get('project');
        $request->agent = Session::get('agent');
        $request->status = Session::get('status');
        $request->Source = Session::get('Source');
        $request->Platform = Session::get('Platform');
        $request->Hot = Session::get('Hot');
        $request->sales = Session::get('sales');
        $request->level = Session::get('level');
        $request->dateSince = Session::get('dateSince');
        $request->dateTo = Session::get('dateTo');

        // dd(Session::get('dateSince'));

        $since = strtotime(Session::get('dateSince'));
        $To = strtotime(Session::get('dateTo'));
        if($since == false || $To == false){
            return prospect::filter($request->project,$request->agent,$request->status,$request->Source,$request->Platform,$request->Hot,$request->sales,$request->level,$since,$To,false);
        }
        $since = date('Y-m-d',$since);
        $To = date('Y-m-d',$To+86400);


        return prospect::filter($request->project,$request->agent,$request->status,$request->Source,$request->Platform,$request->Hot,$request->sales,$request->level,$since,$To,true);

    }

    public function getDownload(){
        $request = new stdClass();
        $request->project = Session::get('project');
        $request->status = Session::get('status');
        $request->Source = Session::get('Source');
        $request->Platform = Session::get('Platform');
        $request->Hot = Session::get('Hot');
        $request->sales = Session::get('sales');
        $request->level = Session::get('level');
        $request->dateSince = Session::get('dateSince');
        $request->dateTo = Session::get('dateTo');

        // dd(Session::get('dateSince'));

        $since = strtotime(Session::get('dateSince'));
        $To = strtotime(Session::get('dateTo'));
        if($since == false || $To == false){
            return prospect::download($request->project,$request->status,$request->Source,$request->Platform,$request->Hot,$request->sales,$request->level,$since,$To,false);
        }
        $since = date('Y-m-d',$since);
        $To = date('Y-m-d',$To+86400);

        return prospect::download($request->project,$request->status,$request->Source,$request->Platform,$request->Hot,$request->sales,$request->level,$since,$To,true);

    }

    public function excel(){

        return Excel::download(new ProspectExport($this->getDownload()),'Prospect.xlsx');
    }


    public function filter(Request $request){

        Session::put('project',$request->project);
        Session::put('agent',$request->agent);
        Session::put('status',$request->status);
        Session::put('Source',$request->Source);
        Session::put('Platform',$request->Platform);
        Session::put('Hot',$request->Hot);
        Session::put('sales',$request->sales);
        Session::put('level',$request->level);
        Session::put('dateSince',$request->dateSince);
        Session::put('dateTo',$request->dateTo);
        $prospect = $this->getFilter();

        $project = prospect::get_project();
        $status = prospect::get_status();
        $source= prospect::data('SumberData');
        $platform= prospect::data('SumberPlatform');

        return view('prospects.index', compact('prospect','project','platform','status','source'))->with('alert','Filter berhasil ditampilkan');
        // return redirect()->route('prospect.index', compact('prospect','project','platform','status','source'))->with('alert','Filter berhasil ditampilkan');
    }

    public function index(){
        
        Session::forget('project');
        Session::forget('agent');
        Session::forget('status');
        Session::forget('Source');
        Session::forget('Platform');
        Session::forget('Hot');
        Session::forget('sales');
        Session::forget('level');
        Session::forget('dateSince');
        Session::forget('dateTo');

        $prospect_new = prospect::get_new_prospect();
        $prospect_cold = prospect::get_leads('Cold');
        $prospect_warm = prospect::get_leads('Warm');
        $prospect_hot = prospect::get_leads('Hot');

        // dd(count($prospect_new),count($prospect_cold),count($prospect_warm),count($prospect_hot));
        // dd($prospect_warm);
         

        // $prospect = prospect::join('PT','PT.KodePT','=','Prospect.KodePT')
        //                     ->join('HistoryProspect','HistoryProspect.ProspectID','Prospect.ProspectID')
        //                     ->select('Prospect.*','HistoryProspect.MoveDate')
        //                     ->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
        //                     ->where('Prospect.Status','=','Process')
        //                     ->where('Prospect.AddDate','<=','2022-04-11')
        //                     ->get();
        // dd(count($prospect));


        // for ($i=0; $i < count($prospect); $i++) { 
        //     prospect::where('ProspectID',$prospect[$i]->ProspectID)->update([
        //         'Status' => 'Not Interested',
        //         'StatusDate' => date(now()),
        //         'NotInterestedID' => 10
        //     ]);

        //     historyprospect::where('ProspectID',$prospect[$i]->ProspectID)->update([
        //         'NotInterestedDate' => date(now())
        //     ]);
        // }
        // die;
        // $prospect = prospect::join('PT','PT.KodePT','=','Prospect.KodePT')
        //                     ->join('HistoryProspect','HistoryProspect.ProspectID','Prospect.ProspectID')
        //                     ->select('Prospect.*','HistoryProspect.MoveDate')
        //                     ->where('PT.UsernameKP','=',Auth::User()->UsernameKP)
        //                     ->where('Prospect.Status','=','Warm')
        //                     ->where('Prospect.AddDate','>=','2022-04-11')
        //                     ->get();

        // dd(count($prospect));

        // for ($i=0; $i < count($prospect); $i++) { 
        //     prospect::where('ProspectID',$prospect[$i]->ProspectID)->update([
        //         'Status' => 'Warm',
        //         'StatusDate' => date(now()),
        //     ]);
        // }
        // die;
        
        // $expired = DB::table('Prospect')
        //                 ->where('Status','=','Expired')
        //                 ->where('ProspectID','!=',17279)
        //                 ->where('ProspectID','!=',17272)
        //                 ->where('ProspectID','!=',17252)
        //                 ->where('ProspectID','!=',17220)
        //                 ->where('ProspectID','!=',16395)
        //                 ->where('ProspectID','!=',16045)
        //                 ->where('ProspectID','!=',15692)
        //                 ->get();

                        
        // // dd($expired);
        // for($i=0;$i<count($expired);$i++){
        //     // dump($expired[$i]->KodePT);
        //     // historyblast::where(['ProspectID' => $expired[$i]->ProspectID])->delete();
        //     // historyprospect::where(['ProspectID' => $expired[$i]->ProspectID])->delete();
        //     // prospect::destroy($expired[$i]->ProspectID);

        //     // dump($expired[$i]->AddDate);
        //     prospect::where(['ProspectID' => $expired[$i]->ProspectID])->update([
        //         'Status' => 'Process'
        //     ]);
        //     historyprospect::where(['ProspectID' => $expired[$i]->ProspectID])->update([
        //         'AcceptDate' => $expired[$i]->AddDate,
        //         'AcceptStatus' => 1
        //     ]);

        //     historyblast::where(['ProspectID' => $expired[$i]->ProspectID])->update([
        //         'AcceptStatus' => 1
        //     ]);
        // }
        // dd(count($expired));

        // for($i=0;$i<count($prospect_new);$i++){
        //     $last_prospect = prospect::last_prospect($prospect_new[$i]->ProspectID);
        //     $to_time = strtotime(now());
        //     $from_time = strtotime($last_prospect[0]->MoveDate);
        //     $diffTime = round(abs($to_time - $from_time) / 60,2);
        //     // dd($diffTime);
        //     // dd($prospect_new[$i]);

        //     if($diffTime > 1440){

        //         $pt = userPT::get_KodePT();

        //         //BlastID terakhir
        //         $LastBlastID = historyblast::last_blastID('KodeProject',$prospect_new[$i]->KodeProject);
        //         // dd($LastBlastID);
        //         $sendby=[];

        //         if($LastBlastID[0]->BlastID != null){
                    
        //             $LastBlast = historyblast::last_blast($LastBlastID[0]->BlastID);

        //             $agent = agent::get_agent($LastBlast[0]->KodeProject);

        //             if(count($agent) == 1){
        //                 $NextAgent = historyblast::next_agent(1,$LastBlast[0]->KodeProject);
        //             }
        //             else{
        //                 $MaxSortAgent = agent::max_sort_agent($LastBlast[0]->KodeProject);
                        
        //                 $MinSortAgent = agent::min_sort_agent($LastBlast[0]->KodeProject);
                        
        //                 if($LastBlast[0]->BlastAgentID == $MaxSortAgent[0]->max){
                            
        //                     $NextAgent = historyblast::next_agent($MinSortAgent[0]->min,$LastBlast[0]->KodeProject);
                            
        //                 }
        //                 else{
        //                     $NextAgent = historyblast::next_agent($LastBlast[0]->BlastAgentID+1,$LastBlast[0]->KodeProject);
        //                 }
            
        //             }
                    
        //             $sendby = historyblast::sendby($LastBlast[0]->KodeProject);
        //         }else{
                    
        //             $NextAgent = historyblast::next_agent(1,$prospect_new[$i]->KodeProject);
        //             $sendby = historyblast::sendby($prospect_new[$i]->KodeProject);
        //         }

        //         //Mencari Sales Terakhir
        //         $NextSales=[];
        //         // dd($NextAgent);
        //         //BlastID terakhir
        //         $LastBlastID = historyblast::last_blastID('KodeAgent',$NextAgent[0]->KodeAgent);
        //         // dd($LastBlastID);
        //         if($LastBlastID[0]->BlastID != null){

        //             $LastBlast = historyblast::last_blast($LastBlastID[0]->BlastID);
                    
        //             $sales = historyblast::sales($NextAgent[0]->KodeAgent); // pilih sales yg aktiv aja
        //             // dd($sales);

        //             if($LastBlast[0]->BlastSalesID < count($sales)){
        //                 $NextSales = historyblast::next_sales($LastBlast[0]->BlastSalesID+1,$NextAgent[0]->KodeAgent);

        //             }else{
        //                 $NextSales = historyblast::next_sales(1,$NextAgent[0]->KodeAgent);
        //             }
        //             // dd($NextSales);
        //         }else{

        //             $NextSales = historyblast::next_sales(1,$NextAgent[0]->KodeAgent);

        //         }
        //         // dd($NextSales);

        //         prospect::where(['ProspectID' => $prospect_new[$i]->ProspectID])->update([
        //             'Status' => 'Expired'
        //         ]);

        //         $BlastPrev = historyblast::last_blast($LastBlastID[0]->BlastID);
                
        //         $salesPrev = sales::select('*')->where(['KodeSales' => $BlastPrev[0]->KodeSales])->get();
        //         // dd($BlastPrev);
        //          // input historyblast
        //          historyblast::create([
        //             'KodeProject' => $prospect_new[$i]->KodeProject,
        //             'ProspectID' => $prospect_new[$i]->ProspectID,
        //             'KodeAgent' => $NextAgent[0]->KodeAgent,
        //             'KodeSales' => $NextSales[0]->KodeSales,
        //             'BlastAgentID' => $NextAgent[0]->UrutProjectAgent,
        //             'BlastSalesID' => $NextSales[0]->UrutAgentSales,
        //             'LevelInputID' => 'system'
        //         ]);

        //         historyprospectmove::create([
        //             'ProspectID' => $prospect_new[$i]->ProspectID,
        //             'KodeProject' => $prospect_new[$i]->KodeProject,
        //             'MoveAgentID' => $NextAgent[0]->UrutProjectAgent,
        //             'KodeAgent' => $NextAgent[0]->KodeAgent,
        //             'MoveAgentIDPrev' => $BlastPrev[0]->BlastAgentID,
        //             'KodeAgentPrev' => $BlastPrev[0]->KodeAgent,
        //             'MoveSalesID' => $NextSales[0]->UrutAgentSales,
        //             'KodeSales' => $NextSales[0]->KodeSales,
        //             'MoveSalesIDPrev' => $BlastPrev[0]->BlastSalesID,
        //             'KodeSalesPrev' => $BlastPrev[0]->KodeSales,
        //         ]);

        //         $moveID= historyprospectmove::moveID($prospect_new[$i]->ProspectID);
        //         $numberMove = historyprospect::select('NumberMove')->where(['ProspectID' => $prospect_new[$i]->ProspectID])->get();
        //         historyprospect::where(['ProspectID' => $prospect_new[$i]->ProspectID])->update([
        //             'MoveID' => $moveID[0]->MoveID,
        //             'MoveDate' => date(now()),
        //             'NumberMove' => $numberMove[0]->NumberMove+1,
        //             'KodeAgent' => $NextAgent[0]->KodeAgent,
        //             'KodeSales' => $NextSales[0]->KodeSales,
        //             'BlastAgentID' => $NextAgent[0]->UrutProjectAgent,
        //             'BlastSalesID' => $NextSales[0]->UrutAgentSales,
        //         ]);

        //         historysales::create([
        //             'KodeSales'=> $NextSales[0]->KodeSales,
        //             'Notes' => 'Kamu menerima Prospect dari sales an. '.$salesPrev[0]->NamaSales.', Follow Up sekarang!',
        //             'Subject' => 'Prospect : '.$prospect_new[$i]->KodeProject.' - '.$prospect_new[$i]->NamaProspect,
        //             'KodeProject' => $prospect_new[$i]->KodeProject,
        //             'HistoryBy' => 'Developer'
        //         ]);

        //         historysales::create([
        //             'KodeSales'=> $BlastPrev[0]->KodeSales,
        //             'Notes' => 'Prospect Kamu dipindahkan ke sales an. '.$NextSales[0]->NamaSales,
        //             'Subject' => 'Prospect : '.$prospect_new[$i]->KodeProject.' - '.$prospect_new[$i]->NamaProspect,
        //             'KodeProject' => $prospect_new[$i]->KodeProject,
        //             'HistoryBy' => 'Developer'
        //         ]);

        //         historysales::create([
        //             'KodeSales'=> $BlastPrev[0]->KodeSales,
        //             'NotesDev' => $salesPrev[0]->NamaSales.' tidak follow up Prospect, Prospect dipidahkan ke Sales an. '.$NextSales[0]->NamaSales,
        //             'SubjectDev' => 'Prospect : '.$prospect_new[$i]->KodeProject.' - '.$prospect_new[$i]->NamaProspect,
        //             'KodeProject' => $prospect_new[$i]->KodeProject,
        //             'HistoryBy' => 'Sales'
        //         ]);


        //         $data = historyblast::get_sales($NextSales[0]->KodeSales);
        //         $nama=strtoupper($data[0]->NamaSales);
        //         $telp = '62'.substr($data[0]->Hp,1);
        //         $link = "https://sales-beta.makutapro.id";

        //         //Send WA
        //         $namaprospect = $prospect_new[$i]->NamaProspect;
        //         $kodeproject = $prospect_new[$i]->KodeProject;
        //         $namaProject = project::where('KodeProject',$kodeproject)->get()[0];

        //         $my_apikey = "CTO3GH4VXNVT8CKDDP7A";
        //         $destination = $telp; //no wa pribadi
        //         $message = "Hallo $nama Anda menerima database terusan dari sales agent lain yang belum follow up an. $namaProject->NamaProject untuk project $kodeproject. Harap segera Follow Up database tersebut. \n\nKlik link dibawah ini untuk login :\n$link";
        //         $api_url = "http://panel.rapiwha.com/send_message.php";
        //         $api_url .= "?apikey=". urlencode ($my_apikey);
        //         $api_url .= "&number=". urlencode ($destination);
        //         $api_url .= "&text=". urlencode ($message);
        //         $my_result_object = json_decode(file_get_contents($api_url, false));

        //         // FCM
        //         $this->pushNotif($data[0]->UsernameKP, $kodeproject, $namaprospect);
                
        //         $this->pushNotifKotlin(
        //             $data[0]->UsernameKP,
        //             $kodeproject,
        //             $namaprospect
        //         );

        //     }elseif($diffTime > 1440 &&  Auth::user()->NamaPT=='PT. Agung Graha Persada Utama'){
        //         prospect::where(['ProspectID' => $prospect_new[$i]->ProspectID])->update([
        //             'Status' => 'Expired'
        //         ]);
        //     }
        // }

        // for ($i=0; $i < count($prospect_cold); $i++) { 

        //     $NamaProspect = strtoupper($prospect_cold[$i]->NamaProspect);
        //     $NamaProject = strtoupper($prospect_cold[$i]->NamaProject);
        //     $destination = '62'.substr($prospect_cold[$i]->Hp,1);
        //     $title = 'Reminder !';

        //     $status_remind = RemindStatus::where('ProspectID',$prospect_cold[$i]->ProspectID)
        //                         ->where('KodeSales',$prospect_cold[$i]->KodeSales)
        //                         ->get();

        //     if(round(abs(strtotime(now()) - strtotime($prospect_cold[$i]->FuDate)) / 60, 2) > 2880){
                
        //         if(count($status_remind) == 0){
        //             RemindStatus::create([
        //                 'KodeSales' => $prospect_cold[$i]->KodeSales,
        //                 'ProspectID' => $prospect_cold[$i]->ProspectID
        //             ]);
        //         }
                
        //         $status_remind = RemindStatus::where('ProspectID',$prospect_cold[$i]->ProspectID)
        //                                     ->where('KodeSales',$prospect_cold[$i]->KodeSales)
        //                                     ->select('*',DB::raw('MAX(id) as id'))
        //                                     ->get()[0];
                
        //         if(!$status_remind->ColdDay3){
        //             $body = "Hallo, Data ini sudah hari ke-3 belum berubah status. Harap segera update status konsumen an. $NamaProspect untuk Project $NamaProject jika sudah ada progress.";
                    
        //             Helper::SendWA($destination, $body);
        //             Helper::PushNotif($prospect_cold[$i]->UsernameKP, $title, $body);
    
        //             historysales::create([
        //                 'KodeSales'=> $prospect_cold[$i]->KodeSales,
        //                 'Notes' => $body,
        //                 'Subject' => $title,
        //                 'KodeProject' => $prospect_cold[$i]->KodeProject,
        //                 'HistoryBy' => 'Developer'
        //             ]);

        //             $status_remind->ColdDay3 = true;
        //             $status_remind->save();
        //         }

        //     }

        //     else if(round(abs(strtotime(now()) - strtotime($prospect_cold[$i]->FuDate)) / 60, 2) > 5760){
                
        //         if(!$status_remind->ColdDay6){
        //             $body = "Apakah Anda sudah follow up konsumen atas nama $NamaProspect untuk Project $NamaProject  yang berstatus COLD, agar mengetahui Promo dan Keunggulan Produk?";

        //             Helper::SendWA($destination, $body);
    
        //             Helper::PushNotif($prospect_cold[$i]->UsernameKP, $title, $body);
    
        //             historysales::create([
        //                 'KodeSales'=> $prospect_cold[$i]->KodeSales,
        //                 'Notes' => $body,
        //                 'Subject' => $title,
        //                 'KodeProject' => $prospect_cold[$i]->KodeProject,
        //                 'HistoryBy' => 'Developer'
        //             ]);

        //             $status_remind->ColdDay6 = true;
        //             $status_remind->save();
        //         }

        //     }

        // }

        for ($i=0; $i < count($prospect_warm); $i++) { 
            $NamaProspect = strtoupper($prospect_warm[$i]->NamaProspect);
            $NamaProject = strtoupper($prospect_warm[$i]->NamaProject);
            $destination = '62'.substr($prospect_warm[$i]->Hp,1);
            $title = 'Reminder !';
            $body = "Apakah Anda sudah follow up konsumen atas nama $NamaProspect untuk Project $NamaProject  yang berstatus WARM, agar dapat mengundang ke Marketing Gallery ?";

            $status_remind = RemindStatus::where('ProspectID',$prospect_cold[$i]->ProspectID)
                                            ->where('KodeSales',$prospect_cold[$i]->KodeSales)
                                            ->get();

            if(is_null($status_remind)){
                RemindStatus::create([
                    'KodeSales' => $prospect_cold[$i]->KodeSales,
                    'ProspectID' => $prospect_warm[$i]->ProspectID
                ]);
            }
            
            $status_remind = RemindStatus::where('ProspectID',$prospect_cold[$i]->ProspectID)
                                            ->where('KodeSales',$prospect_cold[$i]->KodeSales)
                                            ->select('*',DB::raw('MAX(id) as id'))
                                            ->get()[0];

            if(round(abs(strtotime(now()) - strtotime($prospect_warm[$i]->StatusDate)) / 60, 2) > 5760){
                
                if(!$status_remind->WarmDay5){
                    $body = "Apakah Anda sudah follow up konsumen atas nama $NamaProspect untuk Project $NamaProject  yang berstatus WARM, agar mengetahui Promo dan Keunggulan Produk?";

                    Helper::SendWA($destination, $body);
    
                    Helper::PushNotif($prospect_warm[$i]->UsernameKP, $title, $body);
    
                    historysales::create([
                        'KodeSales'=> $prospect_warm[$i]->KodeSales,
                        'Notes' => $body,
                        'Subject' => $title,
                        'KodeProject' => $prospect_warm[$i]->KodeProject,
                        'HistoryBy' => 'Developer'
                    ]);

                    $status_remind->WarmDay5 = true;
                    $status_remind->save();
                }

            }

            else if(round(abs(strtotime(now()) - strtotime($prospect_warm[$i]->StatusDate)) / 60, 2) > 12960){
                
                if(!$status_remind->WarmDay10){

                    Helper::SendWA($destination, $body);
    
                    Helper::PushNotif($prospect_warm[$i]->UsernameKP, $title, $body);
    
                    historysales::create([
                        'KodeSales'=> $prospect_warm[$i]->KodeSales,
                        'Notes' => $body,
                        'Subject' => $title,
                        'KodeProject' => $prospect_warm[$i]->KodeProject,
                        'HistoryBy' => 'Developer'
                    ]);

                    $status_remind->WarmDay10 = true;
                    $status_remind->save();
                }
            }

            else if(round(abs(strtotime(now()) - strtotime($prospect_warm[$i]->StatusDate)) / 60, 2) > 20160){
                
                if(!$status_remind->WarmDay15){

                    Helper::SendWA($destination, $body);
    
                    Helper::PushNotif($prospect_warm[$i]->UsernameKP, $title, $body);
    
                    historysales::create([
                        'KodeSales'=> $prospect_warm[$i]->KodeSales,
                        'Notes' => $body,
                        'Subject' => $title,
                        'KodeProject' => $prospect_warm[$i]->KodeProject,
                        'HistoryBy' => 'Developer'
                    ]);

                    $status_remind->WarmDay15 = true;
                    $status_remind->save();
                }
            }

            else if(round(abs(strtotime(now()) - strtotime($prospect_warm[$i]->StatusDate)) / 60, 2) > 25920){
                
                if(!$status_remind->WarmDay19){
                    
                    $body = "Apakah Anda sudah follow up konsumen atas nama $NamaProspect untuk Project $NamaProject ? Dikarenakan Sudah 14 hari berstatus WARM. untuk menghindari status berubah menjadi Not Interested secara otomatis";

                    Helper::SendWA($destination, $body);
    
                    Helper::PushNotif($prospect_warm[$i]->UsernameKP, $title, $body);
    
                    historysales::create([
                        'KodeSales'=> $prospect_warm[$i]->KodeSales,
                        'Notes' => $body,
                        'Subject' => $title,
                        'KodeProject' => $prospect_warm[$i]->KodeProject,
                        'HistoryBy' => 'Developer'
                    ]);

                    $status_remind->WarmDay19 = true;
                    $status_remind->save();
                }
            }

            else{
                if ($status_remind->WarmDay19) {
                    historyprospect::where(['ProspectID'=>$ProspectID])->update([
                        'NotInterestedDate' => date('Y-m-d H:i:s')
                    ]);
                    Prospect::where(['ProspectID' => $ProspectID])->update([
                        'EditBy' => 'system',
                        'Status' => 'Not Interested',
                        'NotInterestedID' => 10,
                    ]);
                }
                // dump($prospect_warm[0]);
            }

        }

        // for($i=0; $i<count($prospect_hot); $i++){
        //     if()
        // }
        

        $prospect = prospect::get_prospect();
        $project = prospect::get_project();
        $status = prospect::get_status();
        $source = prospect::data('SumberData');
        $platform = prospect::data('SumberPlatform');
        $campaign = prospect::data('ProjectCampaign');

        return view('prospects.index', compact('prospect','project','status','source','platform','campaign'));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $campaign= DB::table('ProjectCampaign')
                        ->join('Project','Project.KodeProject','=','ProjectCampaign.KodeProject')
                        ->join('PT','PT.KodePT','=','Project.KodePT')
                        ->select('ProjectCampaign.*')
                        ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                        ->get();
        $source = DB::table('SumberData')->select('*')->get();
        $platform = DB::table('SumberPlatform')->select('*')->get();
        $kode_iklan = DB::table('SumberAds')->select('*')->get();
        $project = prospect::get_project();

        return view('prospects.create', compact('source','platform','kode_iklan','project','campaign'));
    }

    public function sewa()
    {
        $campaign= DB::table('ProjectCampaign')
                        ->join('Project','Project.KodeProject','=','ProjectCampaign.KodeProject')
                        ->join('PT','PT.KodePT','=','Project.KodePT')
                        ->select('ProjectCampaign.*')
                        ->where('PT.UsernameKP','=',Auth::user()->UsernameKP)
                        ->get();
        $source = DB::table('SumberData')->select('*')->get();
        $platform = DB::table('SumberPlatform')->select('*')->get();
        $kode_iklan = DB::table('SumberAds')->select('*')->get();
        $project = prospect::get_project();
        $sales = sales::where(['KodeAgent'=>'PPR-RENT'])->select('*')->get();

        return view('prospects.create-sewa', compact('sales','source','platform','kode_iklan','project','campaign'));
    }

    public function SewaStore(Request $request){
        $rules = [
            'KodeProject' => 'required',
            'NamaProspect' => 'required',
            'Hp' => ['required',
                    Rule::unique('Prospect')->where(function ($query){
                        return $query->where('Prospect.KodeProject','=',request()->KodeProject);
                    })],
            'KodePlatform' => 'required'
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pt = userPT::get_KodePT();
        if($request->KodeNegara != '+62'){
            $KodeNegara = $request->KodeNegara;
        }else{
            $KodeNegara = '+62';
        }

         //input prospect
         prospect::create([
            'NamaProspect' => $request->NamaProspect,
            'EmailProspect' => $request->EmailProspect,
            'Hp' => $request->Hp,
            'KodeNegara' => $KodeNegara,
            'Message' => $request->Message,
            'SumberDataID' => $request->SumberDataID,
            'LevelInputID' => 'system',
            'Status' => 'New',
            'Campaign' => $request->Campaign,
            'KodeProject' => $request->KodeProject,
            'KodePT' => $pt[0]->KodePT,
            'KodeAds' => $request->KodeAds,
            'KodePlatform' => $request->KodePlatform
        ]);

        $ProspectID = historyblast::prospectID();

        //input historyprospect
        historyprospect::create([
            'KodePT' => $pt[0]->KodePT,
            'KodeProject' => $request->KodeProject,
            'ProspectID' => $ProspectID[0]->ProspectID,
            'KodeAgent' => 'PPR-RENT',
            'KodeSales' => $request->KodeSales,
            'LevelInputID' => 'system'
        ]);

        historysales::create([
            'KodeSales'=> $request->KodeSales,
            'Notes' => 'yeay! Kamu menerima Prospect baru, Follow Up sekarang!',
            'Subject' => 'Prospect : '.$request->KodeProject.' - '.$request->NamaProspect,
            'KodeProject' => $request->KodeProject,
            'HistoryBy' => 'Developer'
        ]);


        $data = historyblast::get_sales($request->KodeSales);
        $nama=strtoupper($data[0]->NamaSales);
        $telp = '62'.substr($data[0]->Hp,1);
        $link = "https://sales-beta.makutapro.id";
        $namaprospect= strtoupper($request->NamaProspect);
        $kodeproject= $request->KodeProject;
        $namaProject = project::where('KodeProject',$kodeproject)->get()[0];

        //Send WA

        $my_apikey = "CTO3GH4VXNVT8CKDDP7A";
        $destination = $telp; //no wa pribadi
        $message = "Hallo $nama Anda telah menerima database untuk sewa pada project $namaProject->NamaProject an. $namaprospect . Harap segera Follow Up database tersebut. \n\nKlik link dibawah ini untuk login :\n$link";
        $api_url = "http://panel.rapiwha.com/send_message.php";
        $api_url .= "?apikey=". urlencode ($my_apikey);
        $api_url .= "&number=". urlencode ($destination);
        $api_url .= "&text=". urlencode ($message);
        $my_result_object = json_decode(file_get_contents($api_url, false));

        // FCM
        $this->pushNotif($data[0]->UsernameKP, $kodeproject, $namaprospect);
        $this->pushNotifKotlin($data[0]->UsernameKP, $kodeproject, $namaprospect);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request);
        $rules = [
            'KodeProject' => 'required',
            'NamaProspect' => 'required',
            'Hp' => ['required',
                    Rule::unique('Prospect')->where(function ($query){
                        return $query->where('Prospect.KodeProject','=',request()->KodeProject);
                    })],
            'KodePlatform' => 'required'
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pt = userPT::get_KodePT();
        if($request->KodeNegara != '+62'){
            $KodeNegara = $request->KodeNegara;
        }else{
            $KodeNegara = '+62';
        }
        //Mencari Agent Terakhir

        //BlastID terakhir
        $LastBlastID = historyblast::last_blastID('KodeProject',$request->KodeProject);
        
        $sendby=[];
        if($LastBlastID[0]->BlastID != null){
            
            $LastBlast = historyblast::last_blast($LastBlastID[0]->BlastID);
            
            $agent = agent::get_agent($LastBlast[0]->KodeProject);

            if(count($agent) == 1){
                $NextAgent = historyblast::next_agent(1,$request->KodeProject);
            }
            else{
                $MaxSortAgent = agent::max_sort_agent($LastBlast[0]->KodeProject);
                
                $MinSortAgent = agent::min_sort_agent($LastBlast[0]->KodeProject);
                
                if($LastBlast[0]->BlastAgentID == $MaxSortAgent[0]->max){
                    
                    $NextAgent = historyblast::next_agent($MinSortAgent[0]->min,$LastBlast[0]->KodeProject);
                    
                }
                else{
                    
                    $NextAgent = historyblast::next_agent($LastBlast[0]->BlastAgentID+1,$LastBlast[0]->KodeProject);
                }
    
            }
            
            $sendby = historyblast::sendby($LastBlast[0]->KodeProject);
        }else{
            
            $NextAgent = historyblast::next_agent(1,$request->KodeProject);
            $sendby = historyblast::sendby($request->KodeProject);
        }

        if($sendby[0]->SendBy == 'agent'){
             //input prospect
            prospect::create([
                'NamaProspect' => $request->NamaProspect,
                'EmailProspect' => $request->EmailProspect,
                'Hp' => $request->Hp,
                'KodeNegara' => $KodeNegara,
                'Message' => $request->Message,
                'SumberDataID' => $request->SumberDataID,
                'NoteSumberData' => $request->NoteSumberData,
                'LevelInputID' => 'system',
                'Status' => 'New',
                'Campaign' => $request->Campaign,
                'KodeProject' => $request->KodeProject,
                'KodePT' => $pt[0]->KodePT,
                'KodeAds' => $request->KodeAds,
                'KodePlatform' => $request->KodePlatform
            ]);

            $ProspectID = historyblast::prospectID();

            // input historyblast
            historyblast::create([
                'KodeProject' => $request->KodeProject,
                'ProspectID' => $ProspectID[0]->ProspectID,
                'KodeAgent' => $NextAgent[0]->KodeAgent,
                'BlastAgentID' => $NextAgent[0]->UrutProjectAgent,
                'LevelInputID' => 'system'
            ]);
            // //input historyprospect
            historyprospect::create([
                'KodePT' => $pt[0]->KodePT,
                'KodeProject' => $request->KodeProject,
                'ProspectID' => $ProspectID[0]->ProspectID,
                'KodeAgent' => $NextAgent[0]->KodeAgent,
                'BlastAgentID' => $NextAgent[0]->UrutProjectAgent,
                'LevelInputID' => 'system'
            ]);
            $data = historyblast::get_agent($NextAgent[0]->KodeAgent);
            $nama = strtoupper($data[0]->NamaAgent);
            $telp = '62'.substr($data[0]->Hp,1);
            $link = "http://makutapro.id/agent/login.php";

        }else{
            //Mencari Sales Terakhir
            $NextSales=[];
            //BlastID terakhir
            $LastBlastID = historyblast::last_blastID('KodeAgent',$NextAgent[0]->KodeAgent);
            // dd($LastBlastID);
            if($LastBlastID[0]->BlastID != null){

                $LastBlast = historyblast::last_blast($LastBlastID[0]->BlastID);
                //mencari next agent
                // dd($LastBlast);
                $sales = historyblast::sales($NextAgent[0]->KodeAgent); // pilih sales yg aktiv aja
                // dd($sales);

                if($LastBlast[0]->BlastSalesID < count($sales)){
                    $NextSales = historyblast::next_sales($LastBlast[0]->BlastSalesID+1,$NextAgent[0]->KodeAgent);

                }else{
                    $NextSales = historyblast::next_sales(1,$NextAgent[0]->KodeAgent);
                }
                // dd($NextSales);
            }else{

                $NextSales = historyblast::next_sales(1,$NextAgent[0]->KodeAgent);

            }


            //input prospect
            prospect::create([
                'NamaProspect' => $request->NamaProspect,
                'EmailProspect' => $request->EmailProspect,
                'Hp' => $request->Hp,
                'KodeNegara' => $KodeNegara,
                'Message' => $request->Message,
                'SumberDataID' => $request->SumberDataID,
                'NoteSumberData' => $request->NoteSumberData,
                'LevelInputID' => 'system',
                'Status' => 'New',
                'Campaign' => $request->Campaign,
                'KodeProject' => $request->KodeProject,
                'KodePT' => $pt[0]->KodePT,
                'KodeAds' => $request->KodeAds,
                'KodePlatform' => $request->KodePlatform
            ]);

            $ProspectID = historyblast::prospectID();
            // dd($NextSales[0]->KodeSales);
            // input historyblast
            historyblast::create([
                'KodeProject' => $request->KodeProject,
                'ProspectID' => $ProspectID[0]->ProspectID,
                'KodeAgent' => $NextAgent[0]->KodeAgent,
                'KodeSales' => $NextSales[0]->KodeSales,
                'BlastAgentID' => $NextAgent[0]->UrutProjectAgent,
                'BlastSalesID' => $NextSales[0]->UrutAgentSales,
                'LevelInputID' => 'system'
            ]);
            // dd("dsds");
            //input historyprospect
            historyprospect::create([
                'KodePT' => $pt[0]->KodePT,
                'KodeProject' => $request->KodeProject,
                'ProspectID' => $ProspectID[0]->ProspectID,
                'KodeAgent' => $NextAgent[0]->KodeAgent,
                'KodeSales' => $NextSales[0]->KodeSales,
                'BlastAgentID' => $NextAgent[0]->UrutProjectAgent,
                'BlastSalesID' => $NextSales[0]->UrutAgentSales,
                'LevelInputID' => 'system'
            ]);

            historysales::create([
                'KodeSales'=> $NextSales[0]->KodeSales,
                'Notes' => 'yeay! Kamu menerima Prospect baru, Follow Up sekarang!',
                'Subject' => 'Prospect : '.$request->KodeProject.' - '.$request->NamaProspect,
                'KodeProject' => $request->KodeProject,
                'HistoryBy' => 'Developer'
            ]);

            $data = historyblast::get_sales($NextSales[0]->KodeSales);
            $nama=strtoupper($data[0]->NamaSales);
            $telp = '62'.substr($data[0]->Hp,1);
            $link = "https://sales-beta.makutapro.id";
            $namaprospect= strtoupper($request->NamaProspect);
            $kodeproject= $request->KodeProject;
            // FCM
            $this->pushNotif($NextSales[0]->UsernameKP, $kodeproject, $namaprospect);
            $this->pushNotifKotlin($NextSales[0]->UsernameKP, $kodeproject, $namaprospect);
        }

        $namaprospect= strtoupper($request->NamaProspect);
        $kodeproject= $request->KodeProject;
        $namaProject = project::where('KodeProject',$request->KodeProject)->get()[0];
        //Send WA

        $agent = DB::table('Agent')->select('*')->where('KodeAgent',$NextAgent[0]->KodeAgent)->get();
        $user_agent = User::where('UsernameKP',$agent[0]->UsernameKP)->get();
        $user_sales = User::where('UsernameKP',$NextSales[0]->UsernameKP)->get();
        $link_apps = "https://play.google.com/store/apps/details?id=com.crm.makutapro";

        if ($user_agent[0]->notif_wa == 1) {

            $my_apikey = "CTO3GH4VXNVT8CKDDP7A";
            $destination = '62'.substr($agent[0]->Hp,1); //no wa pribadi
            $message = "Saat ini Team Anda a/n $nama menerima prospek konsumen a/n $namaprospect untuk project $namaProject->NamaProject.\nMohon untuk segera di follow up.\nTerima kasih";
            $api_url = "http://panel.rapiwha.com/send_message.php";
            $api_url .= "?apikey=". urlencode ($my_apikey);
            $api_url .= "&number=". urlencode ($destination);
            $api_url .= "&text=". urlencode ($message);
            $my_result_object = json_decode(file_get_contents($api_url, false));
        }

        if($user_sales[0]->notif_wa == 1){
            
            $my_apikey = "CTO3GH4VXNVT8CKDDP7A";
            $destination = $telp; //no wa pribadi
            $message = "Hallo $nama Anda telah menerima database baru an. $namaprospect untuk project $namaProject->NamaProject. Harap segera Follow Up database tersebut. \n\nKlik link dibawah ini untuk login :\n$link";
            $api_url = "http://panel.rapiwha.com/send_message.php";
            $api_url .= "?apikey=". urlencode ($my_apikey);
            $api_url .= "&number=". urlencode ($destination);
            $api_url .= "&text=". urlencode ($message);
            $my_result_object = json_decode(file_get_contents($api_url, false));
        }

        if($user_sales[0]->notif_email == 1 && $user_sales[0]->Email != null){
            $data = [
                'nama' => $nama,
                'namaprospect'=> $namaprospect,
                'namaproject' => $namaProject->NamaProject,
                'link_apps' => $link_apps, 
                'link_web' => $link 
            ];
            Mail::to($user_sales[0]->Email)->send(new MakutaproMailProspect($data));
        }



        return redirect('prospects')->with('alert','Prospect berhasil di tambah');
    }
    
    
    public function createManual()
    {
        $campaign = DB::table('ProjectCampaign')
            ->join(
                'Project',
                'Project.KodeProject',
                '=',
                'ProjectCampaign.KodeProject'
            )
            ->join('PT', 'PT.KodePT', '=', 'Project.KodePT')
            ->select('ProjectCampaign.*')
            ->where('PT.UsernameKP', '=', Auth::user()->UsernameKP)
            ->get();
        $source = DB::table('SumberData')
            ->select('*')
            ->get();
        $platform = DB::table('SumberPlatform')
            ->select('*')
            ->get();
        $kode_iklan = DB::table('SumberAds')
            ->select('*')
            ->get();
        $project = prospect::get_project();

        return view(
            'prospects.create-manual',
            compact('source', 'platform', 'kode_iklan', 'project', 'campaign')
        );
    }
    
    public function storeManual(Request $request)
    {
        // dd($request);
        $rules = [
            'KodeProject' => 'required',
            'NamaProspect' => 'required',
            'Hp' => [
                'required',
                Rule::unique('Prospect')->where(function ($query) {
                    return $query->where(
                        'Prospect.KodeProject',
                        '=',
                        request()->KodeProject
                    );
                }),
            ],
            'KodePlatform' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        
        $agent = DB::table('Agent')->select('*')->where('KodeAgent',$request->KodeAgent)->get();
        $sales = DB::table('Sales')->select('*')->where('KodeSales',$request->KodeSales)->get();

        $pt = userPT::get_KodePT();
        if ($request->KodeNegara != '+62') {
            $KodeNegara = $request->KodeNegara;
        } else {
            $KodeNegara = '+62';
        }

            //input prospect
        prospect::create([
            'NamaProspect' => $request->NamaProspect,
            'EmailProspect' => $request->EmailProspect,
            'Hp' => $request->Hp,
            'KodeNegara' => $KodeNegara,
            'Message' => $request->Message,
            'SumberDataID' => $request->SumberDataID,
            'NoteSumberData' => $request->NoteSumberData,
            'LevelInputID' => 'system',
            'Status' => 'New',
            'Campaign' => $request->Campaign,
            'KodeProject' => $request->KodeProject,
            'KodePT' => $pt[0]->KodePT,
            'KodeAds' => $request->KodeAds,
            'KodePlatform' => $request->KodePlatform,
        ]);

        $ProspectID = historyblast::prospectID();
        
        historyprospect::create([
            'KodePT' => $pt[0]->KodePT,
            'KodeProject' => $request->KodeProject,
            'ProspectID' => $ProspectID[0]->ProspectID,
            'KodeAgent' => $agent[0]->KodeAgent,
            'KodeSales' => $sales[0]->KodeSales,
            'BlastAgentID' => $agent[0]->UrutAgent,
            'BlastSalesID' => $sales[0]->UrutAgentSales,
            'LevelInputID' => 'system',
        ]);

        historysales::create([
            'KodeSales' => $sales[0]->KodeSales,
            'Notes' =>
                'yeay! Kamu menerima Prospect baru, Follow Up sekarang!',
            'Subject' =>
                'Prospect : ' .
                $request->KodeProject .
                ' - ' .
                $request->NamaProspect,
            'KodeProject' => $request->KodeProject,
            'HistoryBy' => 'Developer',
        ]);

        $data = historyblast::get_sales($sales[0]->KodeSales);
        $nama = strtoupper($data[0]->NamaSales);
        $telp = '62' . substr($data[0]->Hp, 1);
        $link = 'https://sales-beta.makutapro.id';
        // FCM
        $this->pushNotif(
            $sales[0]->UsernameKP,
            $request->KodeProject,
            $request->NamaProspect
        );
        $this->pushNotifKotlin(
            $sales[0]->UsernameKP,
            $request->KodeProject,
            $request->NamaProspect
        );
        

        $namaprospect = strtoupper($request->NamaProspect);
        $kodeproject = $request->KodeProject;
        $namaProject = project::where('KodeProject',$request->KodeProject)->get()[0];

        //Send WA
        
        $user_agent = User::where('UsernameKP',$agent[0]->UsernameKP)->get();
        $user_sales = User::where('UsernameKP',$sales[0]->UsernameKP)->get();
        $link_apps = "https://play.google.com/store/apps/details?id=com.crm.makutapro";

        if($user_agent[0]->notif_wa == 1){
            $my_apikey = 'CTO3GH4VXNVT8CKDDP7A';
            $destination = '62'.substr($agent[0]->Hp,1);  //no wa pribadi
            $message = "Saat ini Team Anda a/n $nama menerima prospek konsumen a/n $namaprospect untuk project $namaProject->NamaProject.\nMohon untuk segera di follow up.\nTerima kasih";
            $api_url = 'http://panel.rapiwha.com/send_message.php';
            $api_url .= '?apikey=' . urlencode($my_apikey);
            $api_url .= '&number=' . urlencode($destination);
            $api_url .= '&text=' . urlencode($message);
            $my_result_object = json_decode(file_get_contents($api_url, false));
        }

        if($user_sales[0]->notif_wa == 1){
            $my_apikey = 'CTO3GH4VXNVT8CKDDP7A';
            $destination = $telp; //no wa pribadi
            $message = "Hallo $nama Anda telah menerima database baru an. $namaprospect untuk project $namaProject->NamaProject. Harap segera Follow Up database tersebut. \n\nKlik link dibawah ini untuk login :\n$link";
            $api_url = 'http://panel.rapiwha.com/send_message.php';
            $api_url .= '?apikey=' . urlencode($my_apikey);
            $api_url .= '&number=' . urlencode($destination);
            $api_url .= '&text=' . urlencode($message);
            $my_result_object = json_decode(file_get_contents($api_url, false));
        }

        if($user_sales[0]->notif_email == 1 && $user_sales[0]->Email != null){
            $data = [
                'nama' => $nama,
                'namaprospect'=> $namaprospect,
                'namaproject' => $namaProject->NamaProject,
                'link_apps' => $link_apps, 
                'link_web' => $link 
            ];
            Mail::to($user_sales[0]->Email)->send(new MakutaproMailProspect($data));
        }

        return redirect('prospects')->with(
            'alert',
            'Prospect berhasil di tambah'
        );
    }

    public function pushNotif($UsernameKP, $KodeProject, $NamaProspect){
        $url = 'https://fcm.googleapis.com/fcm/send';
        $FcmToken = sales::select('DeviceKey')->where(['UsernameKP' => $UsernameKP])->get();
        if(count($FcmToken) > 0){
            $serverKey = 'AAAAQyv47zc:APA91bEB7xsWscXlavBPdv7aT6s-9B9SpflsR_cdz1_EPhQUx7BwxcVCH2C7tQpjeOgh31cxtNbxASZVjOeR9ZPytSYYQVDKJOHMdmwtlFeVAAYRZwwEdt9IqAOdo12grFxuOCuWciEV';

            $data = [
                "registration_ids" => [$FcmToken[0]->DeviceKey],
                "notification" => [
                    "title" => 'Prospect : '.$KodeProject.' - '.$NamaProspect,
                    "body" => 'yeay! Kamu menerima Prospect baru, Follow Up sekarang!',
                ]
            ];
            $encodedData = json_encode($data);

            $headers = [
                'Authorization:key=' . $serverKey,
                'Content-Type: application/json',
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

            // Execute post
            $result = curl_exec($ch);

            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }

            // Close connection
            curl_close($ch);
        }
    }

    public function pushNotifKotlin($UsernameKP, $KodeProject, $NamaProspect){
        $url = 'https://fcm.googleapis.com/fcm/send';
        $FcmToken = DB::table('TokenFCM')
            ->select('TokenFCM')
            // ->where(['UsernameKP' => $UsernameKP])
            ->where('id', DB::raw("(select max(`id`) from TokenFCM where `UsernameKP` = '$UsernameKP')"))
            ->get();
        if(count($FcmToken) > 0){
            $serverKey = 'AAAA8QlsNCY:APA91bFXmxrGz5CMJxxXF_AzREaaHu4h6fW7zZv5I1T565gTSxPcEZJ1S3UgvQZkS4EmssM5IF9LkXViaBguvivjSxTxGdgNXWmbLvVJ6K2-NjNGFEIwheeEgBKjveZLrXs-Un4A255H';

            $data = [
                "registration_ids" => [$FcmToken[0]->TokenFCM],
                "notification" => [
                    "title" => 'Prospect : '.$KodeProject.' - '.$NamaProspect,
                    "body" => 'yeay! Kamu menerima Prospect baru, Follow Up sekarang!',
                ]
            ];
            $encodedData = json_encode($data);
  
            $headers = [
                'Authorization:key=' . $serverKey,
                'Content-Type: application/json',
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

            // Execute post
            $result = curl_exec($ch);

            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }

            // Close connection
            curl_close($ch);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($ProspectID)
    {
        $prospect = prospect::data_prospect2($ProspectID);
        // dd($prospect);

        $agent = DB::table('Agent')->select('*')->where('KodeProject', $prospect[0]->KodeProject)->get();


        $provTinggal = demografi::getIDPRov($prospect[0]->TempatTinggalID);
        if(count($provTinggal)==0){
            $provTinggal = null;
            $namaProvTinggal = null;
        }else{
            $namaProvTinggal = $provTinggal[0]->province;
            $provTinggal = $provTinggal[0]->province_id;
        }

        $provKerja = demografi::getIDPRov($prospect[0]->TempatKerjaID);
        if(count($provKerja)==0){
            $provKerja = null;
            $namaProvKerja = null;
        }else{
            $namaProvKerja = $provKerja[0]->province;
            $provKerja = $provKerja[0]->province_id;
        }

        $TempatTinggal = demografi::get_city($prospect[0]->TempatTinggalID);
        if(count($TempatTinggal) == 0 ){
            $namaTempatTinggal = null;
        }else{
            $namaTempatTinggal = $TempatTinggal[0]->city;
        }

        $TempatKerja = demografi::get_city($prospect[0]->TempatKerjaID);
        if(count($TempatKerja) == 0 ){
            $namaTempatKerja = null;
        }else{
            $namaTempatKerja = $TempatKerja[0]->city;
        }

        $data = new stdClass();

        $data->property = [
            'ProspectID' => $prospect[0]->ProspectID,
            'NamaProspect' => $prospect[0]->NamaProspect,
            'Hp' => $prospect[0]->Hp,
            'EmailProspect' => $prospect[0]->EmailProspect,
            'Message' => $prospect[0]->Message,
            'KodeSales' => $prospect[0]->KodeSales,
            'GenderID' => $prospect[0]->GenderID,
            'JenisKelamin' => $prospect[0]->JenisKelamin,
            'UsiaID' => $prospect[0]->UsiaID,
            'provTinggalID' => $provTinggal,
            'namaProvTinggal' => $namaProvTinggal,
            'TempatTinggalID' => $prospect[0]->TempatTinggalID,
            'provKerjaID' => $provKerja,
            'namaProvKerja' => $namaProvKerja,
            'TempatKerjaID' => $prospect[0]->TempatKerjaID,
            'PekerjaanID' => $prospect[0]->PekerjaanID,
            'PenghasilanID' => $prospect[0]->PenghasilanID,
            'SumberDataID' => $prospect[0]->SumberDataID,
            'KodeAds' => $prospect[0]->KodeAds,
            'RangeUsia' => $prospect[0]->RangeUsia,
            'NamaTempatTinggal' => $namaTempatTinggal,
            'NamaTempatKerja' => $namaTempatKerja,
            'TipePekerjaan' => $prospect[0]->TipePekerjaan,
            'RangePenghasilan' => $prospect[0]->RangePenghasilan,
            'NamaSumber' => $prospect[0]->NamaSumber,
            'JenisAds' => $prospect[0]->JenisAds,
            'KodeProject' => $prospect[0]->KodeProject,
            'unit' => prospect::get_unit($prospect[0]->KodeProject),
            'gender' => prospect::data('Gender'),
            'usia' => prospect::data('Usia'),
            'provinsi' => prospect::data('Provinsi'),
            'pekerjaan' => prospect::data('Pekerjaan'),
            'penghasilan' => prospect::data('Penghasilan'),
            'notinterest' => prospect::data('NotInterested'),
            'status' =>  DB::table('Status')->where('KetStatus','!=','New')->where('KetStatus','!=','Expired')->get(),
            'Status' => $prospect[0]->Status,
            'source' => prospect::data('SumberData'),
            'ads' => prospect::data('SumberAds'),
            'KodeAgent' => $prospect[0]->KodeAgent,
            'NamaAgent' => $prospect[0]->NamaAgent,
            'NamaSales' => $prospect[0]->NamaSales,
            'JenisKelamin' => $prospect[0]->JenisKelamin,
            'GenderID' => $prospect[0]->GenderID,
            'RangeUsia' => $prospect[0]->RangeUsia,
            'UsiaID' => $prospect[0]->UsiaID,
            'TempatTinggalID' => $prospect[0]->TempatTinggalID,
            'TempatKerjaID' => $prospect[0]->TempatKerjaID,
            'TipePekerjaan' => $prospect[0]->TipePekerjaan,
            'PekerjaanID' => $prospect[0]->PekerjaanID,
            'PenghasilanID' => $prospect[0]->PenghasilanID,
            'RangePenghasilan' => $prospect[0]->RangePenghasilan,
            'JenisAds' => $prospect[0]->JenisAds,
            'CatatanAdmin' => $prospect[0]->CatatanAdmin,
        ];

        $prospect2 = json_decode (json_encode ($data), FALSE);

        // dd($prospect2);
        
        return view('prospects.update',compact('prospect2','agent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function update(Request $request, $ProspectID)
    {
        $prospect = prospect::find($ProspectID);
        $historyprospect = DB::table('HistoryProspect')->select('*')->where('ProspectID',$ProspectID)->get();
        
        
        if($request->KodeSales != null){
            
            if($historyprospect[0]->KodeAgent == null && $prospect->Status == "New"){
                
                $agent = DB::table('Agent')->select('*')->where('KodeAgent', $request->KodeAgent)->get();
                $sales = DB::table('Sales')->select('*')->where('KodeSales', $request->KodeSales)->get();
    
                historyprospect::where(['ProspectID' => $ProspectID])->update([
                    'KodeProject' => $request->KodeProject,
                    'KodeAgent' => $request->KodeAgent,
                    'KodeSales' => $request->KodeSales,
                    'BlastAgentID' => $agent[0]->UrutProjectAgent,
                    'BlastSalesID' => $sales[0]->UrutAgentSales,
                ]);
    
                $data = historyblast::get_sales($request->KodeSales);
                $nama=strtoupper($data[0]->NamaSales);
                $telp = '62'.substr($data[0]->Hp,1);
                $link = "https://sales-beta.makutapro.id";
                $namaprospect= strtoupper($request->NamaProspect);
                $kodeproject= $request->KodeProject;
                // FCM
                $this->pushNotif($sales[0]->UsernameKP, $kodeproject, $namaprospect);
                $this->pushNotifKotlin($sales[0]->UsernameKP, $kodeproject, $namaprospect);
    
                //Send WA
    
                $my_apikey = "CTO3GH4VXNVT8CKDDP7A";
                $destination = $telp; //no wa pribadi
                $message = "Hallo $nama Anda telah menerima database baru an. $namaprospect untuk project $kodeproject. Harap segera Follow Up database tersebut. \n\nKlik link dibawah ini untuk login :\n$link";
                $api_url = "http://panel.rapiwha.com/send_message.php";
                $api_url .= "?apikey=". urlencode ($my_apikey);
                $api_url .= "&number=". urlencode ($destination);
                $api_url .= "&text=". urlencode ($message);
                $my_result_object = json_decode(file_get_contents($api_url, false));
            }
            
        }

        if($request->NotInterestedID != 0){
            Prospect::where(['ProspectID' => $ProspectID])->update([
                'Hot' => 0
            ]);
            historyprospect::where(['ProspectID'=>$ProspectID])->update([
                'NotInterestedDate' => date('Y-m-d H:i:s')
            ]);
        }
        if($request->UnitID != 0){
            Prospect::where(['ProspectID' => $ProspectID])->update([
                'Hot' => 0
            ]);
            historyprospect::where(['ProspectID'=>$ProspectID])->update([
                'UnitID' => $request->UnitID,
                'Unit' =>$request->KetUnit,
                'ClosingAmount' => $request->HargaJual,
                'ClosingDate' => date('Y-m-d H:i:s')
            ]);
        }

        if($request->Status == 'Process'){
            historyprospect::where(['ProspectID'=>$ProspectID])->update([
                'UnitID' => 0,
                'Unit' => "",
                'ClosingAmount' => "",
                'ClosingDate' => "",
                'NotInterestedDate' => "",
            ]);
        }
        
        prospect::where(['ProspectID' => $ProspectID])->update([
            'NamaProspect' => $request->NamaProspect,
            'EmailProspect' => $request->EmailProspect,
            'Status' => $request->Status,
            'Hp' => $request->Hp,
            'GenderID' => $request->GenderID,
            'UsiaID' => $request->UsiaID,
            'TempatTinggalID' => $request->TempatTinggalID,
            'TempatKerjaID' => $request->TempatKerjaID,
            'PekerjaanID' => $request->PekerjaanID,
            'PenghasilanID' => $request->PenghasilanID,
            'KodeProject' => $request->KodeProject,
            'SumberDataID' => $request->SumberDataID,
            'KodeAds' => $request->KodeAds,
            'NotInterestedID' => $request->NotInterestedID,
            'UnitID' => $request->UnitID,
        ]);


        historysales::create([
            'KodeSales'=> $request->KodeSales,
            'Notes' => 'Data Prospect telah di ubah by Developer',
            'Subject' => 'Prospect : '.$request->KodeProject.' - '.$request->NamaProspect,
            'KodeProject' => $request->KodeProject,
            'HistoryBy' => 'Developer'
        ]);

        return redirect('/prospects')->with('alert','Prospect berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($ProspectID)
    {
        historyblast::where(['ProspectID' => $ProspectID])->delete(['*']);
        historyprospect::where(['ProspectID' => $ProspectID])->delete(['*']);
        prospect::destroy($ProspectID);
        return redirect()->back()->with('alert','Prospect berhasil di hapus !');
    }

    public function delete_selected(Request $request)
    {
        dd($request->all());
    }

    public function prospect_sales($KodeAgent, $KodeSales){
        $sales = sales::get_data_sales2($KodeAgent,$KodeSales);
        $prospect = prospect::prospect_sales2($KodeSales);
        $status = prospect::get_status();
        $source= prospect::data('SumberData');
        $NamaSales = sales::where(['KodeSales' => $KodeSales])->select('NamaSales')->get();
        return view('prospects.prospectsales', compact('prospect','NamaSales','sales','KodeSales'));
    }

    public function prospect_sales_move(Request $request){
        
        $prospectID= $request->prospect;
        $move = sales::where(['KodeSales'=>$request->KodeSalesNext])->select('KodeAgent','KodeProject','UrutAgentSales','KodeSales','NamaSales')->get();
        $movePrev = sales::where(['KodeSales'=>$request->KodeSalesPrev])->select('KodeAgent','UrutAgentSales','KodeSales','NamaSales')->get();

        for($i=0;$i<count($prospectID);$i++){
            $prospect = prospect::find($prospectID[$i]);
            // dd($prospect->Status);
            if($prospect->Status == 'New' || $prospect->Status == 'Expired'){
                historyprospectmove::create([
                    'ProspectID' => $prospectID[$i],
                    'KodeProject' => $move[0]->KodeProject,
                    'KodeAgent' => $move[0]->KodeAgent,
                    'MoveSalesID' => $move[0]->UrutAgentSales,
                    'KodeSales' => $move[0]->KodeSales,
                    'MoveSalesIDPrev' => $movePrev[0]->UrutAgentSales,
                    'KodeSalesPrev' => $movePrev[0]->KodeSales,
                ]);

                $moveID= historyprospectmove::moveID($prospectID[$i]);
                $numberMove = historyprospect::select('NumberMove')->where(['ProspectID' => $prospectID[$i]])->get();

                historyprospect::where(['ProspectID' => $prospectID[$i]])->update([
                    'MoveID' => $moveID[$i]->MoveID,
                    'NumberMove' => $numberMove[0]->NumberMove+1,
                    'KodeSales' => $move[0]->KodeSales,
                    'MoveDate' => date('m/d/Y h:i:s'),
                ]);

                $data = historyblast::get_sales($move[0]->KodeSales);
                $nama=strtoupper($data[0]->NamaSales);
                $telp = '62'.substr($data[0]->Hp,1);
                $link = "https://sales-beta.makutapro.id";

                $namaprospect= strtoupper($prospect->NamaProspect);
                $kodeproject= $move[0]->KodeProject;
                $namaProject = project::where('KodeProject',$kodeproject)->get()[0];


                //Send WA

                $my_apikey = "CTO3GH4VXNVT8CKDDP7A";
                $destination = $telp; //no wa pribadi
                $message = "Hallo $nama Anda telah menerima database baru an. $namaProject->NamaProject untuk project $kodeproject. Harap segera Follow Up database tersebut. \n\nKlik link dibawah ini untuk login :\n$link";
                $api_url = "http://panel.rapiwha.com/send_message.php";
                $api_url .= "?apikey=". urlencode ($my_apikey);
                $api_url .= "&number=". urlencode ($destination);
                $api_url .= "&text=". urlencode ($message);
                $my_result_object = json_decode(file_get_contents($api_url, false));

                // FCM
                $this->pushNotif($data[0]->UsernameKP, $kodeproject, $namaprospect);
                $this->pushNotifKotlin($data[0]->UsernameKP, $kodeproject, $namaprospect);


            }else{
                historyprospectmove::create([
                    'ProspectID' => $prospectID[$i],
                    'KodeProject' => $move[0]->KodeProject,
                    'KodeAgent' => $move[0]->KodeAgent,
                    'MoveSalesID' => $move[0]->UrutAgentSales,
                    'KodeSales' => $move[0]->KodeSales,
                    'MoveSalesIDPrev' => $movePrev[0]->UrutAgentSales,
                    'KodeSalesPrev' => $movePrev[0]->KodeSales,
                ]);

                $moveID= historyprospectmove::moveID($prospectID[$i]);
                $numberMove = historyprospect::select('NumberMove')->where(['ProspectID' => $prospectID[$i]])->get();

                historyprospect::where(['ProspectID' => $prospectID[$i]])->update([
                    'MoveID' => $moveID[0]->MoveID,
                    'NumberMove' => $numberMove[0]->NumberMove+1,
                    'KodeSales' => $move[0]->KodeSales
                ]);
            }
        }

        if(count($prospectID)==1){
            $dataprospect = prospect::find($prospectID[0]);
            historysales::create([
                'KodeSales'=> $request->KodeSalesNext,
                'Notes' => 'Kamu menerima Prospect dari sales an. '.$movePrev[0]->NamaSales.', Follow Up sekarang!',
                'Subject' => 'Prospect : '.$move[0]->KodeProject.' - '.$dataprospect->NamaProspect,
                'KodeProject' => $move[0]->KodeProject,
                'HistoryBy' => 'Developer'
            ]);
            historysales::create([
                'KodeSales'=> $request->KodeSalesPrev,
                'Notes' => 'Prospect Kamu dipindahkan ke sales an. '.$move[0]->NamaSales,
                'Subject' => 'Prospect : '.$move[0]->KodeProject.' - '.$dataprospect->NamaProspect,
                'KodeProject' => $move[0]->KodeProject,
                'HistoryBy' => 'Developer'
            ]);
        }else{
            historysales::create([
                'KodeSales'=> $request->KodeSalesNext,
                'Notes' => 'Kamu menerima beberapa Prospect dari sales an. '.$movePrev[0]->NamaSales.', Follow Up sekarang!',
                'Subject' => 'Get Move Prospect',
                'KodeProject' => $move[0]->KodeProject,
                'HistoryBy' => 'Developer'
            ]);
            historysales::create([
                'KodeSales'=> $request->KodeSalesPrev,
                'Notes' => 'beberapa Prospect Kamu dipindahkan ke sales an. '.$move[0]->NamaSales,
                'Subject' => 'Prospect Move ',
                'KodeProject' => $move[0]->KodeProject,
                'HistoryBy' => 'Developer'
            ]);
        }

        return redirect()->back()->with('alert','Prospect berhasil dipindah');
    }

    public function history (Request $request){

        // $history = prospect::history_fu($request->ProspectID)->pluck('day','month','hour','minute','NamaSales','NamaMedia');
        // return response()->json($history);
        $prospect = prospect::where(['ProspectID' => $request->ProspectID])->select('NamaProspect')->get();
        $NamaProspect = $prospect[0]->NamaProspect;
        $history = prospect::history_fu($request->ProspectID);
        // dd($history);

        $historyMove = prospect::history_prospect_move($request->ProspectID);

        return view('prospects.history',compact('history','NamaProspect','historyMove'));
    }

    public function prospect_verifikasi($ProspectID){

        $dataVerifikasi = prospect::data_verifikasi($ProspectID);

        prospect::where(['ProspectID' => $ProspectID])->update([
            'VerifiedStatus' => 1,
            'VerifiedDate' => date(now()),
        ]);

        historyprospect::where(['ProspectID' => $ProspectID])->update([
            'MoveDate' => date(now())
        ]);

        historysales::create([
            'KodeSales'=> $dataVerifikasi[0]->KodeSales,
            'Notes' => 'yeay! Kamu menerima Prospect baru, Follow Up sekarang!',
            'Subject' => 'Prospect : '.$dataVerifikasi[0]->KodeProject.' - '.$dataVerifikasi[0]->NamaProspect,
            'KodeProject' => $dataVerifikasi[0]->KodeProject,
            'HistoryBy' => 'Developer'
        ]);


        $data = historyblast::get_sales($dataVerifikasi[0]->KodeSales);
        $nama=strtoupper($data[0]->NamaSales);
        $telp = '62'.substr($data[0]->Hp,1);
        $link = "https://sales-beta.makutapro.id";

        $namaprospect= strtoupper($dataVerifikasi[0]->NamaProspect);
        $kodeproject= $dataVerifikasi[0]->KodeProject;
        $namaProject = project::where('KodeProject',$kodeproject)->get()[0];

        // // Send WA

        $my_apikey = "CTO3GH4VXNVT8CKDDP7A";
        $destination = $telp; //no wa pribadi
        $message = "Hallo $nama Anda telah menerima database baru an. $namaProject->NamaProject untuk project $kodeproject. Harap segera Follow Up database tersebut. \n\nKlik link dibawah ini untuk login :\n$link";
        $api_url = "http://panel.rapiwha.com/send_message.php";
        $api_url .= "?apikey=". urlencode ($my_apikey);
        $api_url .= "&number=". urlencode ($destination);
        $api_url .= "&text=". urlencode ($message);
        $my_result_object = json_decode(file_get_contents($api_url, false));

        // FCM
        $this->pushNotif($data[0]->UsernameKP, $kodeproject, $namaprospect);
        $this->pushNotifKotlin($data[0]->UsernameKP, $kodeproject, $namaprospect);

        return redirect()->back()->with('alert','Prospect berhasil di Verifikasi !');
    }


}