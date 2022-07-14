<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\notInterested;
use App\Models\historyprospect;
use Illuminate\Support\Facades\Auth;

class NotInterestedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $alasan = notInterested::get_alasan();
        $notinterested = notInterested::get_prospect();

        if(count($notinterested)>0){

            $total_prospect = notInterested::get_total_prospect();
            $totalLeads = historyprospect::get_total_leads(Auth::user()->UsernameKP);
            $total_persentasi = round($total_prospect[0]->prospect/$totalLeads[0]->total_leads * 100,2);

            $persentasi=[];$ind=0;
            foreach($notinterested as $item){
                $persentasi[$ind]=round($notinterested[$ind]->prospect/$total_prospect[0]->prospect * 100,2);
                $ind++;
            }

            if(count($alasan)!=count($notinterested)){
                $tamp = count($alasan)-count($notinterested);
                //memberi nilai 0 pada alasan yang belum mempunyai prospect
                for($i=0;$i<$tamp;$i++){
                    $persentasi[] =0;
                }
            }else{

            }
            // dd($persentasi);
            $ind=0;
            $data =[];
            foreach($notinterested as $item){
                $data[$ind] = [
                    'Alasan' => $notinterested[$ind]->Alasan,
                    'prospect' => $notinterested[$ind]->prospect,
                    'persentasi' => $persentasi[$ind]
                ];
                $ind++;
            }
            $ind=0;

            $object = json_decode (json_encode ($data), FALSE);
            // dd($object);
            $total_leads = $totalLeads[0]->total_leads;
            $totalProspect = $total_prospect[0]->prospect;
            return view("not interested.index",compact('object','total_persentasi','total_leads','totalProspect'));

        }else{
            return view('not interested.blank');
        }
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
}
