<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\roas;
use App\Models\project;
use Illuminate\Support\Str;

class RoasController extends Controller
{
    public function index(){
        $project = project::get_project(Auth::user()->UsernameKP);

        $in=0; $data=[];

        foreach($project as $key){
            $roas = roas::select('*')->where(['KodeProject'=>$project[$in]->KodeProject])->orderBy('id')->get();
            $ind=0;
            foreach($roas as $key){
                if($roas[$ind]->Budget == null){
                    $budget = $roas[$ind]->Google + $roas[$ind]->Sosmed + $roas[$ind]->Detik;
                }else{
                    $budget = $roas[$ind]->Budget;
                }

                $total_leads = roas::total($roas[$ind]->Bulan,$roas[$ind]->Tahun,'total',$project[$in]->KodeProject);
                if ($total_leads[0]->total == 0){
                    $cpl = 0;
                }else{
                    $cpl = round($budget / $total_leads[0]->total, 2);
                }

                $total_closing = roas::total($roas[$ind]->Bulan,$roas[$ind]->Tahun,'closing',$project[$in]->KodeProject);
                if($total_closing[0]->total == 0){
                    $cpa= 0;
                }else{
                    $cpa= round($budget / $total_closing[0]->total, 2);
                }

                roas::where(['id' => $roas[$ind]->id])->update([
                    'CPL' => $cpl,
                    'CPA' => $cpa
                ]);
                $ind++;
            }
            $in++;
        }
        $ind=0;
        foreach($project as $item){
            $data[] = [
                'NamaProject' => $project[$ind]->NamaProject,
                'roas' => roas::select('*')->where(['KodeProject'=>$project[$ind]->KodeProject])->orderBy('id','desc')->get(),
            ];
            $ind++;
        }
        $Roas = json_decode(json_encode ($data), FALSE);
        return view('roas.index',compact('project','Roas'));
    }

    public function store(Request $request){
        $google = str_replace('Rp. ','',$request->Google);
        $Google = str_replace('.','',$google);

        $sosmed = str_replace('Rp. ','',$request->Sosmed);
        $Sosmed = str_replace('.','',$sosmed);

        $detik = str_replace('Rp. ','',$request->Detik);
        $Detik = str_replace('.','',$detik);

        $Budget = intval($Google) + intval($Sosmed) + intval($Detik) ;

        $total_leads = roas::total($request->bulan,$request->tahun,'total',$request->KodeProject);
        if($total_leads[0]->total == 0 ){
            $cpl = 0;
        }else{
            $cpl = round($Budget / $total_leads[0]->total, 2);
        }

        $total_closing = roas::total($request->bulan,$request->tahun,'closing',$request->KodeProject);
        if($total_closing[0]->total == 0){
            $cpa = 0;
        }else{
            $cpa = round($Budget / $total_closing[0]->total, 2);
        }

        roas::create([
            'Google' => intval($Google),
            'Sosmed' => intval($Sosmed),
            'Detik' => intval($Detik),
            'Bulan' => $request->bulan,
            'Tahun' => $request->tahun,
            'KodeProject' => $request->KodeProject,
            'CPA' => $cpa,
            'CPL' => $cpl
        ]);

        return redirect()->back()->with('status','Budget telah berhasil diinput');
    }

    public function update(Request $request, $id){
        $google = str_replace('Rp. ','',$request->Google);
        $Google = str_replace('.','',$google);

        $sosmed = str_replace('Rp. ','',$request->Sosmed);
        $Sosmed = str_replace('.','',$sosmed);

        $detik = str_replace('Rp. ','',$request->Detik);
        $Detik = str_replace('.','',$detik);

        $Budget = intval($Google) + intval($Sosmed) + intval($Detik) ;

        $total_leads = roas::total($request->bulan,$request->tahun,'total',$request->KodeProject);
        if($total_leads[0]->total == 0 ){
            $cpl = 0;
        }else{
            $cpl = round($Budget / $total_leads[0]->total, 2);
        }

        $total_closing = roas::total($request->bulan,$request->tahun,'closing',$request->KodeProject);
        if($total_closing[0]->total == 0){
            $cpa = 0;
        }else{
            $cpa = round($Budget / $total_closing[0]->total, 2);
        }
        roas::where(['id'=>$id])->update([
            'Google' => intval($Google),
            'Sosmed' => intval($Sosmed),
            'Detik' => intval($Detik),
            'CPA' => $cpa,
            'CPL' => $cpl
        ]);

        return redirect()->back()->with('status','Budget telah berhasil diubah');
    }

    public function destroy($id){
        roas::destroy($id);
        return redirect()->back()->with('status','Budget telah berhasil dihapus');
    }

}