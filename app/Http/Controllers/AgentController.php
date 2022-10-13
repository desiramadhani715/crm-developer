<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\agent;
use App\Models\project;
use App\Models\projectagent;
use App\Models\User;
use App\Models\prospect;
use App\Models\sales;
use App\Models\historyprospect;
use App\Models\historysales;
use App\Models\historyblast;
use App\Models\historyprospectmove;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgentController extends Controller
{
    public function nonactive($KodeAgent)
    {
        // ambil data agent yang ingin di non aktifkan
        $agent = agent::where([
            'KodeAgent' => $KodeAgent
        ])->get();
        
        // ambil data agent yang no urutnya lebih besar dari agent yg ingin di non aktifkan
        $data = agent::agent_data($KodeAgent, $agent[0]->KodeProject, $agent[0]->UrutAgent);
        $ind = 0;

        // update data agent (urut agent) yang no urut nya lebih besar dari agent yg ingin di non aktifkan
        if (count($data) > 0) {
            for ($i = 0; $i < count($data); $i++) {
                agent::where(['KodeAgent' => $data[$i]->KodeAgent])->update([
                    'UrutAgent' => $data[$i]->UrutAgent - 1,
                ]);
            }
        }
        
        agent::where(['id' => $agent[0]->id])->update([
            'UrutAgent' => 0,
        ]);

        projectagent::where(['KodeAgent' => $KodeAgent])->update([
            'UrutProjectAgent' => 0
        ]);

        user::where(['UsernameKP' => $agent[0]->UsernameKP])->update([
            'Active' => 0,
        ]);

        
        return redirect()
            ->back()
            ->with('status', 'Sales telah di non-aktifkan!');
    }

    public function active($KodeAgent)
    {
        // ambil data agent yang ingin di aktifkan
        $agent = agent::where([
            'KodeAgent' => $KodeAgent
        ])->get();
        
        $UrutAgentMax = agent::where(['KodeProject' => $agent[0]->KodeProject])->select(DB::raw('max(Agent.UrutAgent) as UrutAgent'))->get();

        agent::where(['KodeAgent' => $KodeAgent])->update([
            'UrutAgent' => $UrutAgentMax[0]->UrutAgent + 1,
        ]);

        projectagent::where(['KodeAgent' => $KodeAgent])->update([
            'UrutProjectAgent' => $UrutAgentMax[0]->UrutAgent + 1
        ]);

        user::where(['UsernameKP' => $agent[0]->UsernameKP])->update([
            'Active' => 1,
        ]);

        return redirect()
            ->back()
            ->with('status', 'Sales telah di aktifkan!');
    }

    public function filter(Request $request)
    {
        $since = strtotime($request->dateSince);
        $since = date('Y-m-d', $since);
        $To = strtotime($request->dateTo);
        $To = date('Y-m-d', $To + 86400);

        $data = agent::get_data_agent();
        $closing_amount = agent::filter_closing_amount($since, $To);
        //ubah object ke dalam bentuk array
        $closing = [];
        $ind = 0;
        foreach ($closing_amount as $item) {
            $closing[] = $closing_amount[$ind]->total;
            $ind++;
        }
        $tamp = count($data) - count($closing_amount);
        //memberi nilai 0 pada agent yang belum mempunyai prospect
        if (count($data) != count($closing_amount)) {
            for ($i = 0; $i < $tamp; $i++) {
                $closing[] = '0';
            }
        }
        $agent = [];
        $index = 0;
        foreach ($data as $item) {
            $agent[] = [
                'KodeAgent' => $data[$index]->KodeAgent,
                'NamaAgent' => $data[$index]->NamaAgent,
                'UrutAgent' => $data[$index]->UrutAgent,
                'NamaProject' => $data[$index]->NamaProject,
                'KodeProject' => $data[$index]->KodeProject,
                'Email' => $data[$index]->Email,
                'UsernameKP' => $data[$index]->UsernameKP,
                'Pic' => $data[$index]->Pic,
                'Sort' => $data[$index]->UrutAgent,
                'Hp' => $data[$index]->Hp,
                'PasswordKP' => $data[$index]->PasswordKP,
                'PhotoUser' => $data[$index]->PhotoUser,
                'total' => $closing[$index],
            ];
            $index++;
        }
        $index = 0;
        $data_agent = agent::get_data_agent();
        $object = json_decode(json_encode($agent), false);
        // dd($object);
        // dd(agent::get_data_agent());

        return view('agent.index', compact('object'));
    }

    public function index()
    {
        $data = agent::get_data_agent();
        
        $closing_amount = agent::get_closing_amount(Auth::user()->UsernameKP);
        
        //ubah object ke dalam bentuk array
        $closing = [];
        $ind = 0;
        foreach ($closing_amount as $item) {
            $closing[] = $closing_amount[$ind]->total;
            $ind++;
        }
        $tamp = count($data) - count($closing_amount);
        //memberi nilai 0 pada agent yang belum mempunyai prospect
        if (count($data) != count($closing_amount)) {
            for ($i = 0; $i < $tamp; $i++) {
                $closing[] = '0';
            }
        }
        $agent = [];
        $index = 0;
        foreach ($data as $item) {
            $agent[] = [
                'KodeAgent' => $data[$index]->KodeAgent,
                'NamaAgent' => $data[$index]->NamaAgent,
                'UrutAgent' => $data[$index]->UrutAgent,
                'NamaProject' => $data[$index]->NamaProject,
                'KodeProject' => $data[$index]->KodeProject,
                'Email' => $data[$index]->Email,
                'UsernameKP' => $data[$index]->UsernameKP,
                'Pic' => $data[$index]->Pic,
                'Sort' => $data[$index]->UrutAgent,
                'Hp' => $data[$index]->Hp,
                'PasswordKP' => $data[$index]->PasswordKP,
                'PhotoUser' => $data[$index]->PhotoUser,
                'total' => $closing[$index],
                'Active' => $data[$index]->Active,
            ];
            $index++;
        }
        $index = 0;
        $data_agent = agent::get_data_agent();
        $object = json_decode(json_encode($agent), false);

        return view('agent.index', compact('object'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $project = project::get_project(Auth::user()->UsernameKP);
        return view('agent.create', compact('project'));
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
        $UrutAgent = agent::get_urut_agent($request->KodeProject);
        // dd($UrutAgent);
        if (count($UrutAgent) == 0) {
            $UrutAgent = 0;
            // dd($UrutAgent);
        } else {
            $UrutAgent = agent::max_sort_agent($request->KodeProject)[0]->max;
        }

        $rules = [
            'KodeProject' => 'required',
            'NamaAgent' => 'required',
            'Pic' => 'required',
            'Email' => 'required',
            'Hp' => 'required',
            'KodeAgent' => 'required|unique:Agent,KodeAgent',
            'UsernameKP' => 'required|unique:Agent,UsernameKP',
            'PhotoUser' => 'mimes:jpeg,png,jpg,gif,svg',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $imageName = '';
        if ($request->PhotoUser) {
            $imageName = $request->file('PhotoUser')->getClientOriginalName();
            // $request->file('PhotoUser')->move(public_path('storage/uploaded'), $imageName);
            $request->file('PhotoUser')->storeAs('public/uploaded', $imageName);
        }

        agent::create([
            'KodeAgent' => $request->KodeAgent,
            'UrutAgent' => $UrutAgent + 1,
            'KodeProject' => $request->KodeProject,
            'NamaAgent' => $request->NamaAgent,
            'Pic' => $request->Pic,
            'Hp' => $request->Hp,
            'UsernameKP' => $request->UsernameKP,
            'PhotoUser' => $imageName,
        ]);

        User::create([
            'UsernameKP' => $request->UsernameKP,
            'PasswordKP' => md5($request->PasswordKP),
            'Email' => $request->Email,
            'LevelUserID' => 'agent',
            'Active' => 1,
        ]);

        projectagent::create([
            'KodeProject' => $request->KodeProject,
            'UrutProjectAgent' => $UrutAgent + 1,
            'KodeAgent' => $request->KodeAgent,
        ]);

        $project = project::select('NamaProject')->where('KodeProject',$request->KodeProject)->get()[0];
        $nama=strtoupper($request->Pic);
        $telp = '62'.substr($request->Hp,1);
        $link = "https://agent.makutapro.id/login.php";

        $my_apikey = "BOGY33RL8K2ZPM7LIIWI";
        $destination = $telp; 
        $message = "Hallo $nama Anda telah terdaftar sebagai salah satu Koordinator sales di project $project->NamaProject, berikut akses untuk login \n\nUsername : $request->UsernameKP \n Password : $request->PasswordKP \n Link : $link";
        $api_url = "http://panel.rapiwha.com/send_message.php";
        $api_url .= "?apikey=". urlencode ($my_apikey);
        $api_url .= "&number=". urlencode ($destination);
        $api_url .= "&text=". urlencode ($message);
        $my_result_object = json_decode(file_get_contents($api_url, false));

        return redirect('/agent')->with('status', 'Success !');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $find_agent = agent::find($id)
        // $agent = agent::get_data_agent($)
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($KodeAgent)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $KodeAgent)
    {
        $agent = agent::get_detail_agent($KodeAgent);

        if ($request->file('PhotoUser') == null) {
            $imageName = $request->PhotoUser;
        } else {
            $imageName = $request->file('PhotoUser')->getClientOriginalName();
            $request->file('PhotoUser')->storeAs('public/uploaded', $imageName);
        }

        agent::where(['KodeAgent' => $KodeAgent])->update([
            'NamaAgent' => $request->NamaAgent,
            'Pic' => $request->Pic,
            'Hp' => $request->Hp,
            'PhotoUser' => $imageName,
        ]);

        User::where(['UsernameKP' => $agent[0]->UsernameKP])->update([
            'UsernameKP' => $request->UsernameKP,
            'Email' => $request->Email,
        ]);

        if ($request->PasswordKP) {
            User::where(['UsernameKP' => $agent[0]->UsernameKP])->update([
                'PasswordKP' => bcrypt($request->PasswordKP),
            ]);
        }

        projectagent::where(['KodeAgent' => $agent[0]->KodeAgent])->update([
            'UrutProjectAgent' => $request->UrutAgent,
        ]);

        return redirect('/agent')->with('status', 'Data berhasil diubah !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($KodeAgent)
    // {
    //     agent::destroy($KodeAgent);
    //     projectagent::where(['KodeAgent' => $KodeAgent])->delete(['*']);
    //     // user::
    //     return redirect('/agent')->with('status', 'Data berhasil di Hapus!');
    // }
    public function delete($KodeAgent, $UsernameKP)
    {
        $prospect = agent::get_prospect($KodeAgent);
        if ($prospect[0]->prospect == 0) {
            // ambil data agent yang ingin di non aktifkan
            $agent = agent::where([
                'KodeAgent' => $KodeAgent
            ])->get();
             // ambil data agent yang no urutnya lebih besar dari agent yg ingin di non aktifkan
            $data = agent::agent_data($KodeAgent, $agent[0]->KodeProject, $agent[0]->UrutAgent);
            $ind = 0;

            // update data agent (urut agent) yang no urut nya lebih besar dari agent yg ingin di non aktifkan
            if (count($data) > 0) {
                for ($i = 0; $i < count($data); $i++) {
                    agent::where(['KodeAgent' => $data[$i]->KodeAgent])->update([
                        'UrutAgent' => $data[$i]->UrutAgent - 1,
                    ]);
                }
            }

            projectagent::destroy($KodeAgent);
            agent::destroy($KodeAgent);
            user::where(['UsernameKP' => $UsernameKP])->delete(['*']);
            return redirect()
                ->back()
                ->with('status', 'Data berhasil di hapus !');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Data tidak bisa di hapus !');
        }
    }

    public function prospect($KodeAgent)
    {
        $prospect = agent::get_prospect_agent($KodeAgent);
        $agent = agent::get_data_agent2($KodeAgent);
        return view(
            'agent.prospect_agent',
            compact('prospect', 'KodeAgent', 'agent')
        );
    }

    public function prospectmove(Request $request)
    {
        $prospectID = $request->prospect;
        // dd($request->all());

        $prevAgent = agent::where(['KodeAgent' => $request->KodeAgentPrev])
            ->select('UrutAgent')
            ->get();
        $nextAgent = agent::where(['KodeAgent' => $request->KodeAgentNext])
            ->select('UrutAgent')
            ->get();

        $move = sales::where(['KodeSales' => $request->KodeSalesNext])
            ->select(
                'KodeAgent',
                'KodeProject',
                'UrutAgentSales',
                'KodeSales',
                'NamaSales'
            )
            ->get();

        for ($i = 0; $i < count($prospectID); $i++) {
            // $moveID= historyprospectmove::moveID($prospectID[$i]);
            // dd($moveID);
            $prospect = prospect::find($prospectID[$i]);
            $KodeSalesPrev = historyprospect::where([
                'ProspectID' => $prospectID[$i],
            ])
                ->select('KodeSales')
                ->get();
            $salesPrev = sales::where([
                'KodeSales' => $KodeSalesPrev[0]->KodeSales,
            ])
                ->select(
                    'KodeAgent',
                    'UrutAgentSales',
                    'KodeSales',
                    'NamaSales'
                )
                ->get();
            // dd($prospect->Status);
            if ($prospect->Status == 'New' || $prospect->Status == 'Expired') {
                historyprospectmove::create([
                    'ProspectID' => $prospectID[$i],
                    'KodeProject' => $move[0]->KodeProject,
                    'MoveAgentID' => $nextAgent[0]->UrutAgent,
                    'KodeAgent' => $move[0]->KodeAgent,
                    'MoveAgentIDPrev' => $prevAgent[0]->UrutAgent,
                    'KodeAgentPrev' => $request->KodeAgentPrev,
                    'MoveSalesID' => $move[0]->UrutAgentSales,
                    'KodeSales' => $move[0]->KodeSales,
                    'MoveSalesIDPrev' => $salesPrev[0]->UrutAgentSales,
                    'KodeSalesPrev' => $salesPrev[0]->KodeSales,
                ]);

                $moveID = historyprospectmove::moveID($prospectID[$i]);
                // dd($moveID);
                $numberMove = historyprospect::select('NumberMove')
                    ->where(['ProspectID' => $prospectID[$i]])
                    ->get();

                historyprospect::where([
                    'ProspectID' => $prospectID[$i],
                ])->update([
                    'MoveID' => $moveID[0]->MoveID,
                    'NumberMove' => $numberMove[0]->NumberMove + 1,
                    'KodeAgent' => $move[0]->KodeAgent,
                    'KodeSales' => $move[0]->KodeSales,
                ]);

                $data = historyblast::get_sales($move[0]->KodeSales);
                $nama = strtoupper($data[0]->NamaSales);
                $telp = '62' . substr($data[0]->Hp, 1);
                if (
                    Auth::user()->NamaPT == 'PT Duta Wahana Permai' ||
                    Auth::user()->NamaPT == 'PT Reka Cipta' ||
                    Auth::user()->NamaPT == 'PT Kuala Jaya Realty' ||
                    Auth::user()->NamaPT == 'Makuta Test' ||
                    Auth::user()->NamaPT == 'PT Reka Cipta'
                ) {
                    $link = 'https://sales-beta.makutapro.id';
                } else {
                    $link = 'http://makutapro.id/sales/login.php';
                }

                $namaprospect = strtoupper($prospect->NamaProspect);
                $kodeproject = $move[0]->KodeProject;

                //Send WA

                $my_apikey = 'BOGY33RL8K2ZPM7LIIWI';
                $destination = $telp; //no wa pribadi
                $message = "Hallo $nama Anda telah menerima database baru an. $namaprospect untuk project $kodeproject. Harap segera Follow Up database tersebut. \n\nKlik link dibawah ini untuk login :\n$link";
                $api_url = 'http://panel.rapiwha.com/send_message.php';
                $api_url .= '?apikey=' . urlencode($my_apikey);
                $api_url .= '&number=' . urlencode($destination);
                $api_url .= '&text=' . urlencode($message);
                $my_result_object = json_decode(
                    file_get_contents($api_url, false)
                );
            } else {
                historyprospectmove::create([
                    'ProspectID' => $prospectID[$i],
                    'KodeProject' => $move[0]->KodeProject,
                    'MoveAgentID' => $nextAgent[0]->UrutAgent,
                    'KodeAgent' => $move[0]->KodeAgent,
                    'MoveAgentIDPrev' => $prevAgent[0]->UrutAgent,
                    'KodeAgentPrev' => $request->KodeAgentPrev,
                    'MoveSalesID' => $move[0]->UrutAgentSales,
                    'KodeSales' => $move[0]->KodeSales,
                    'MoveSalesIDPrev' => $salesPrev[0]->UrutAgentSales,
                    'KodeSalesPrev' => $salesPrev[0]->KodeSales,
                ]);

                $moveID = historyprospectmove::moveID($prospectID[$i]);
                $numberMove = historyprospect::select('NumberMove')
                    ->where(['ProspectID' => $prospectID[$i]])
                    ->get();

                historyprospect::where([
                    'ProspectID' => $prospectID[$i],
                ])->update([
                    'MoveID' => $moveID[0]->MoveID,
                    'NumberMove' => $numberMove[0]->NumberMove + 1,
                    'KodeAgent' => $move[0]->KodeAgent,
                    'KodeSales' => $move[0]->KodeSales,
                ]);
            }
        }

        if (count($prospectID) == 1) {
            $dataprospect = prospect::find($prospectID[0]);
            $KodeSalesPrev = historyprospectmove::where([
                'ProspectID' => $prospectID[0],
            ])
                ->select('KodeSalesPrev')
                ->get();
            $salesPrev = sales::where([
                'KodeSales' => $KodeSalesPrev[0]->KodeSalesPrev,
            ])
                ->select(
                    'KodeAgent',
                    'UrutAgentSales',
                    'KodeSales',
                    'NamaSales'
                )
                ->get();

            historysales::create([
                'KodeSales' => $request->KodeSalesNext,
                'Notes' =>
                    'Kamu menerima Prospect dari sales an. ' .
                    $salesPrev[0]->NamaSales .
                    ', Follow Up sekarang!',
                'Subject' =>
                    'Prospect : ' .
                    $move[0]->KodeProject .
                    ' - ' .
                    $dataprospect->NamaProspect,
                'KodeProject' => $move[0]->KodeProject,
                'HistoryBy' => 'Developer',
            ]);
            historysales::create([
                'KodeSales' => $KodeSalesPrev[0]->KodeSalesPrev,
                'Notes' =>
                    'Prospect Kamu dipindahkan ke sales an. ' .
                    $move[0]->NamaSales .
                    ', Follow Up sekarang!',
                'Subject' =>
                    'Prospect : ' .
                    $move[0]->KodeProject .
                    ' - ' .
                    $dataprospect->NamaProspect,
                'KodeProject' => $move[0]->KodeProject,
                'HistoryBy' => 'Developer',
            ]);
        } else {
            historysales::create([
                'KodeSales' => $request->KodeSalesNext,
                'Notes' =>
                    'Kamu menerima beberapa Prospect dari sales an. ' .
                    $salesPrev[0]->NamaSales .
                    ', Follow Up sekarang!',
                'Subject' => 'Get Move Prospect',
                'KodeProject' => $move[0]->KodeProject,
                'HistoryBy' => 'Developer',
            ]);
            historysales::create([
                'KodeSales' => $KodeSalesPrev[0]->KodeSales,
                'Notes' =>
                    'beberapa Prospect Kamu dipindahkan ke sales an. ' .
                    $move[0]->NamaSales,
                'Subject' => 'Prospect Move ',
                'KodeProject' => $move[0]->KodeProject,
                'HistoryBy' => 'Developer',
            ]);
        }

        return redirect()
            ->back()
            ->with('status', 'Prospect berhasil dipindah');
    }

    public function get_agent(Request $request)
    {
        $agent = agent::get_agent_all($request->KodeProject)->pluck(
            'NamaAgent',
            'KodeAgent'
        );

        return response()->json($agent);
    }

    public function getsales(Request $request)
    {
        $sales = agent::get_data_sales($request->KodeAgent)->pluck(
            'NamaSales',
            'KodeSales'
        );

        return response()->json($sales);
    }
}
