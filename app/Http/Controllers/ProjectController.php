<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\project;
use App\Models\User;
use App\Models\agent;
use App\Models\sales;
use App\Models\prospect;
use App\Models\historyprospect;
use App\Models\historysales;
use App\Models\historyblast;
use App\Models\historyprospectmove;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Helper\Helper;
use \stdClass;

class ProjectController extends Controller
{
    public function index(){
        $project = project::get_project(Auth::user()->UsernameKP);
        return view('projects.index',compact('project'));
    }

    public function create(){
        // $project = project::get_project(Auth::user()->UsernameKP);
        // $pt = $project[0]->KodePT;
        $pt = DB::table('PT')->select(['KodePT'])->where(['UsernameKP' => Auth::user()->UsernameKP])->get();
        $pt = $pt[0]->KodePT;
        return view('projects.create',compact('pt'));
    }

    public function store(Request $request){
        $request->validate([
            'KodeProject' =>'unique:Project,KodeProject'
        ]);
        Project::create([
           'KodeProject' => $request->KodeProject,
           'NamaProject' => $request->NamaProject,
           'KodePT' => $request->KodePT
        ]);
        return redirect('/projects')->with('status','Success !');
    }

    public function destroy($KodeProject){
        project::destroy($KodeProject);
        return redirect('/projects')->with('status', 'Data berhasil di Hapus!');
    }

    public function edit($KodeProject){
        $detail = project::get_project(Auth::user()->UsernameKP)->where('KodeProject','=',$KodeProject);
        return view('projects.details',compact('detail'));
    }

    public function update(Request $request, $KodeProject){
        $project = project::find($KodeProject);
        $project->NamaProject = $request->NamaProject;

        $project->save();
        return redirect('projects')->with('status','Data Berhasil di ubah');
    }

    public function leads($KodeProject){

        $prospect = project::get_leads_project($KodeProject);
        $project = project::get_project(Auth::user()->UsernameKP);
        $agent = agent::where('KodeProject',$KodeProject)->get();
        $status = prospect::get_status();

        return view('projects.leads_filter',compact('prospect','project','KodeProject','agent','status'));
    }

    public function leads_filter(Request $request){
        $KodeProject = $request->KodeProject;
        $prospect = project::leads_filter($request->KodeAgent,$request->KodeSales,$request->status);
        $project = project::get_project(Auth::user()->UsernameKP);
        $agent = agent::get_data_agent2($KodeProject);
        $status = prospect::get_status();

        return view('projects.leads_move',compact('prospect','project','KodeProject','agent','status'));

    }

    public function leads_move(Request $request){
        $rules = [
            'leads' => 'required'
        ];
        
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return redirect()->back()->with('alert','Pilih Prospect yang ingin di pindahkan.')->withInput();
        }
        
        if(count($request->leads)>0){

            if($request->KodeAgentNext == ""){

                for ($i=0; $i < count($request->leads) ; $i++) { 

                    $data = Helper::blast($request->KodeProjectNext);

                    $NextAgent = agent::where('KodeAgent',$data['NextAgent'][0]->KodeAgent)->get();
                    $NextSales = sales::where('KodeSales',$data['NextSales'][0]->KodeSales)->get();


                    $prospect = historyprospect::where('ProspectID',$request->leads[$i])->get();
                    // dd($prospect);
                  
                    historyprospectmove::create([
                        'ProspectID' => $request->leads[$i],
                        'KodeProjectPrev' => $request->KodeProjectPrev,
                        'KodeProject' => $request->KodeProjectNext,
                        'MoveAgentID' => $NextAgent[0]->UrutAgent,
                        'KodeAgent' => $NextAgent[0]->KodeAgent,
                        'MoveAgentIDPrev' => $prospect[0]->BlastAgentID,
                        'KodeAgentPrev' => $prospect[0]->KodeAgent,
                        'MoveSalesID' => $NextSales[0]->UrutAgentSales,
                        'KodeSales' => $NextSales[0]->KodeSales,
                        'MoveSalesIDPrev' => $prospect[0]->BlastSalesID,
                        'KodeSalesPrev' => $prospect[0]->KodeSales,
                    ]);

                    $moveID = historyprospectmove::moveID($request->leads[$i]);
                    
                    $history = historyprospect::where(['ProspectID' => $request->leads[$i]])->get();

                    historyprospect::where('ProspectID',$request->leads[$i])->update([
                        'MoveID' => $moveID[0]->MoveID,
                        'NumberMove' => $history[0]->NumberMove + 1,
                        'NumberMoveProject' => $history[0]->NumberMoveProject + 1,
                        'MoveDate' => date(now()),
                        'KodeProject' => $request->KodeProjectNext,
                        'KodeAgent' => $NextAgent[0]->KodeAgent,
                        'KodeSales' => $NextSales[0]->KodeSales,
                        'AcceptStatus' => 0,
                        'BlastAgentID' => $NextAgent[0]->UrutAgent,
                        'BlastSalesID' => $NextSales[0]->UrutAgentSales,
                    ]);

                    historyblast::create([
                        'KodeProject' => $request->KodeProjectNext,
                        'ProspectID' => $request->leads[$i],
                        'KodeAgent' => $NextAgent[0]->KodeAgent,
                        'KodeSales' => $NextSales[0]->KodeSales,
                        'BlastAgentID' => $NextAgent[0]->UrutAgent,
                        'BlastSalesID' => $NextSales[0]->UrutAgentSales,
                        'LevelInputID' => 'system'
                    ]);

                    if($prospect[0]->Status != 'New' && $prospect[0]->Status != 'Closing'){
                        prospect::where('ProspectID',$request->leads[$i])->update([
                            'Status' => 'New'
                        ]);
                    }
                    
                    $project = project::where('KodeProject',$request->KodeProjectPrev)->get();
                    $projectNext = project::where('KodeProject',$request->KodeProjectNext)->get();

                    historysales::create([
                        'KodeSales' => $NextSales[0]->KodeSales,
                        'Notes' =>
                            'Kamu menerima Prospect pindahan dari project ' .
                            $project[0]->NamaProject .
                            ',Segera Follow Up sekarang!',
                        'Subject' => 'Leads Transfer',
                        'KodeProject' => $request->KodeProjectNext,
                        'HistoryBy' => 'Developer',
                    ]);

                    $this->pushNotifKotlin($NextSales[0]->UsernameKP, $project[0]->NamaProject);

                    $user_agent = User::where('UsernameKP',$NextAgent[0]->UsernameKP)->get();
    
                    if($user_agent[0]->notif_wa == 1){
                        $namasales = strtoupper($NextSales[0]->NamaSales);
                        $namaproject = $project[0]->NamaProject;
                        $namaprojectnext = $projectNext[0]->NamaProject;
                        $link = "https://sales-beta.makutapro.id";
                        $my_apikey = 'CTO3GH4VXNVT8CKDDP7A';
                        $destination = '62'.substr($NextAgent[0]->Hp,1);  //no wa pribadi
                        $message = "Saat ini Team Anda a/n $namasales menerima pengalihan prospek dari project $namaproject untuk project $namaprojectnext.\nCek catatan dari admin, untuk alasan pengalihan tersebut.\nMohon untuk segera di follow up.\nTerima kasih";
                        $api_url = 'http://panel.rapiwha.com/send_message.php';
                        $api_url .= '?apikey=' . urlencode($my_apikey);
                        $api_url .= '&number=' . urlencode($destination);
                        $api_url .= '&text=' . urlencode($message);
                        $my_result_object = json_decode(file_get_contents($api_url, false));
                    }
                }
                // die;
            }

            else if($request->KodeAgentNext != "" && $request->KodeSalesNext == ""){

                $NextAgent = agent::where('KodeAgent',$request->KodeAgentNext)->get();
                // dd($NextAgent);

                for ($i=0; $i < count($request->leads) ; $i++) { 

                    $data = Helper::blast_sales($request->KodeAgentNext);

                    $NextSales = sales::where('KodeSales',$data['NextSales'][0]->KodeSales)->get();

                     $prospect = historyprospect::where('ProspectID',$request->leads[$i])->get();
                    // dd($prospect);
                  
                    historyprospectmove::create([
                        'ProspectID' => $request->leads[$i],
                        'KodeProjectPrev' => $request->KodeProjectPrev,
                        'KodeProject' => $request->KodeProjectNext,
                        'MoveAgentID' => $NextAgent[0]->UrutAgent,
                        'KodeAgent' => $NextAgent[0]->KodeAgent,
                        'MoveAgentIDPrev' => $prospect[0]->BlastAgentID,
                        'KodeAgentPrev' => $prospect[0]->KodeAgent,
                        'MoveSalesID' => $NextSales[0]->UrutAgentSales,
                        'KodeSales' => $NextSales[0]->KodeSales,
                        'MoveSalesIDPrev' => $prospect[0]->BlastSalesID,
                        'KodeSalesPrev' => $prospect[0]->KodeSales,
                    ]);

                    $moveID = historyprospectmove::moveID($request->leads[$i]);
                    
                    $history = historyprospect::where(['ProspectID' => $request->leads[$i]])->get();

                    historyprospect::where('ProspectID',$request->leads[$i])->update([
                        'MoveID' => $moveID[0]->MoveID,
                        'NumberMove' => $history[0]->NumberMove + 1,
                        'NumberMoveProject' => $history[0]->NumberMoveProject + 1,
                        'MoveDate' => date(now()),
                        'KodeProject' => $request->KodeProjectNext,
                        'KodeAgent' => $NextAgent[0]->KodeAgent,
                        'KodeSales' => $NextSales[0]->KodeSales,
                        'AcceptStatus' => 0,
                        'BlastAgentID' => $NextAgent[0]->UrutAgent,
                        'BlastSalesID' => $NextSales[0]->UrutAgentSales,
                    ]);

                    historyblast::create([
                        'KodeProject' => $request->KodeProjectNext,
                        'ProspectID' => $request->leads[$i],
                        'KodeAgent' => $NextAgent[0]->KodeAgent,
                        'KodeSales' => $NextSales[0]->KodeSales,
                        'BlastAgentID' => $NextAgent[0]->UrutAgent,
                        'BlastSalesID' => $NextSales[0]->UrutAgentSales,
                        'LevelInputID' => 'system'
                    ]);

                    if($prospect[0]->Status != 'New' && $prospect[0]->Status != 'Closing'){
                        prospect::where('ProspectID',$request->leads[$i])->update([
                            'Status' => 'New'
                        ]);
                    }
                    
                    $project = project::where('KodeProject',$request->KodeProjectPrev)->get();
                    $projectNext = project::where('KodeProject',$request->KodeProjectNext)->get();

                    historysales::create([
                        'KodeSales' => $NextSales[0]->KodeSales,
                        'Notes' =>
                            'Kamu menerima Prospect pindahan dari project ' .
                            $project[0]->NamaProject .
                            ',Segera Follow Up sekarang!',
                        'Subject' => 'Leads Transfer',
                        'KodeProject' => $request->KodeProjectNext,
                        'HistoryBy' => 'Developer',
                    ]);

                    $user_agent = User::where('UsernameKP',$NextAgent[0]->UsernameKP)->get();
    
                    if($user_agent[0]->notif_wa == 1){
                        $namasales = strtoupper($NextSales[0]->NamaSales);
                        $namaproject = $project[0]->NamaProject;
                        $namaprojectnext = $projectNext[0]->NamaProject;
                        $link = "https://sales-beta.makutapro.id";
                        $my_apikey = 'CTO3GH4VXNVT8CKDDP7A';
                        $destination = '62'.substr($NextAgent[0]->Hp,1);  //no wa pribadi
                        $message = "Saat ini Team Anda a/n $namasales menerima pengalihan prospek dari project $namaproject untuk project $namaprojectnext.\nCek catatan dari admin, untuk alasan pengalihan tersebut.\nMohon untuk segera di follow up.\nTerima kasih";
                        $api_url = 'http://panel.rapiwha.com/send_message.php';
                        $api_url .= '?apikey=' . urlencode($my_apikey);
                        $api_url .= '&number=' . urlencode($destination);
                        $api_url .= '&text=' . urlencode($message);
                        $my_result_object = json_decode(file_get_contents($api_url, false));
                    }

                    $this->pushNotifKotlin($NextSales[0]->UsernameKP, $project[0]->NamaProject);
                }

            }
            else{
                
                $NextAgent = agent::where('KodeAgent',$request->KodeAgentNext)->get();
                $NextSales = sales::where('KodeSales',$request->KodeSalesNext)->get();
                
                for ($i=0; $i < count($request->leads); $i++) { 
    
                    $prospect = historyprospect::where('ProspectID',$request->leads[$i])->get();
    
                    historyprospectmove::create([
                        'ProspectID' => $request->leads[$i],
                        'KodeProjectPrev' => $prospect[0]->KodeProject,
                        'KodeProject' => $request->KodeProjectNext,
                        'MoveAgentID' => $NextAgent[0]->UrutAgent,
                        'KodeAgent' => $request->KodeAgentNext,
                        'MoveAgentIDPrev' => $prospect[0]->BlastAgentID,
                        'KodeAgentPrev' => $prospect[0]->KodeAgent,
                        'MoveSalesID' => $NextSales[0]->UrutAgentSales,
                        'KodeSales' => $request->KodeSalesNext,
                        'MoveSalesIDPrev' => $prospect[0]->BlastSalesID,
                        'KodeSalesPrev' => $prospect[0]->KodeSales,
                    ]);
    
                    $moveID = historyprospectmove::moveID($request->leads[$i]);
                    
                    $history = historyprospect::where(['ProspectID' => $request->leads[$i]])->get();
    
                    historyprospect::where('ProspectID',$request->leads[$i])->update([
                        'MoveID' => $moveID[0]->MoveID,
                        'NumberMove' => $history[0]->NumberMove + 1,
                        'NumberMoveProject' => $history[0]->NumberMoveProject + 1,
                        'MoveDate' => date(now()),
                        'KodeProject' => $request->KodeProjectNext,
                        'KodeAgent' => $request->KodeAgentNext,
                        'KodeSales' => $request->KodeSalesNext,
                        'AcceptStatus' => 0,
                        'BlastAgentID' => $NextAgent[0]->UrutAgent,
                        'BlastSalesID' => $NextSales[0]->UrutAgentSales,
                    ]);
    
                    if($prospect[0]->Status != 'New'){
                        prospect::where('ProspectID',$request->leads[$i])->update([
                            'Status' => 'New'
                        ]);
                    }
    
                }
    
                $project = project::where('KodeProject',$request->KodeProjectPrev)->get();
                $projectNext = project::where('KodeProject',$request->KodeProjectNext)->get();
                // dd($project);
    
                historysales::create([
                    'KodeSales' => $request->KodeSalesNext,
                    'Notes' =>
                        'Kamu menerima Prospect pindahan dari project ' .
                        $project[0]->NamaProject .
                        ',Segera Follow Up sekarang!',
                    'Subject' => 'Leads Transfer',
                    'KodeProject' => $request->KodeProjectNext,
                    'HistoryBy' => 'Developer',
                ]);
    
                $namasales = strtoupper($NextSales[0]->NamaSales);
                $namaproject = $project[0]->NamaProject;
                $namaprojectnext = $projectNext[0]->NamaProject;
                $link = "https://sales-beta.makutapro.id";
                $my_apikey = 'CTO3GH4VXNVT8CKDDP7A';
                $destination = '62'.substr($NextSales[0]->Hp,1); //no wa pribadi
                $message = "Hallo $namasales Anda telah menerima database pindahan dari project $namaproject. Harap segera Follow Up database tersebut. \n\nKlik link dibawah ini untuk login :\n$link";
                $api_url = 'http://panel.rapiwha.com/send_message.php';
                $api_url .= '?apikey=' . urlencode($my_apikey);
                $api_url .= '&number=' . urlencode($destination);
                $api_url .= '&text=' . urlencode($message);
                $my_result_object = json_decode(file_get_contents($api_url, false));
            
                $this->pushNotifKotlin($NextSales[0]->UsernameKP, $namaproject);

                $user_agent = User::where('UsernameKP',$NextAgent[0]->UsernameKP)->get();

                if($user_agent[0]->notif_wa == 1){
                    $my_apikey = 'CTO3GH4VXNVT8CKDDP7A';
                    $destination = '62'.substr($NextAgent[0]->Hp,1);  //no wa pribadi
                    $message = "Saat ini Team Anda a/n $namasales menerima pengalihan prospek dari project $namaproject untuk project $namaprojectnext.\nCek catatan dari admin, untuk alasan pengalihan tersebut.\nMohon untuk segera di follow up.\nTerima kasih";
                    $api_url = 'http://panel.rapiwha.com/send_message.php';
                    $api_url .= '?apikey=' . urlencode($my_apikey);
                    $api_url .= '&number=' . urlencode($destination);
                    $api_url .= '&text=' . urlencode($message);
                    $my_result_object = json_decode(file_get_contents($api_url, false));
                }
            }


            return redirect('/projects');
        }
    }

    public function pushNotifKotlin($UsernameKP, $NamaProject){
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
                    "title" => 'Leads Transfer',
                    "body" => 'Kamu menerima prospect pindahan dari project '.$NamaProject.', Segera Follow Up sekarang!',
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
}
