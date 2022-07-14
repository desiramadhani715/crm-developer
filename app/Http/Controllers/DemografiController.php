<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\demografi;
use App\Models\historyprospect;
use Illuminate\Support\Facades\Auth;

class DemografiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalLeads = historyprospect::get_total_leads(Auth::user()->UsernameKP);
        $total_leads = $totalLeads[0]->total_leads;

        // TEMPAT TINGGAL
        if($total_leads != 0){

            $prospectTinggal = demografi::get_prospectTinggal();
            $prospectTinggal = $prospectTinggal[0]->prospect;
            $tempat_tinggal = demografi::get_tempat_tinggal();
            $persentasiTempatTinggal = round($prospectTinggal/$total_leads * 100,2);

            $persentasi=[];$ind=0;
            foreach($tempat_tinggal as $item){
                $persentasi[$ind]=round($tempat_tinggal[$ind]->prospect/$prospectTinggal * 100,2);
                $ind++;
            }

            $ind=0;
            $data =[];
            foreach($tempat_tinggal as $item){
                $data[$ind] = [
                    'nama' => $tempat_tinggal[$ind]->city,
                    'prospect' => $tempat_tinggal[$ind]->prospect,
                    'persentasi' => $persentasi[$ind]
                ];
                $ind++;
            }
            $ind=0;

            $objectTempatTinggal = json_decode (json_encode ($data), FALSE);

            // TEMPAT KERJA

            $prospectKerja = demografi::get_prospectKerja();
            $prospectKerja = $prospectKerja[0]->prospect;
            $tempat_kerja = demografi::get_tempat_kerja();
            $persentasiTempatKerja = round($prospectKerja/$total_leads * 100,2);

            $persentasi=[];$ind=0;
            foreach($tempat_kerja as $item){
                $persentasi[$ind]=round($tempat_kerja[$ind]->prospect/$prospectKerja * 100,2);
                $ind++;
            }

            $ind=0;
            $data =[];
            foreach($tempat_kerja as $item){
                $data[$ind] = [
                    'nama' => $tempat_kerja[$ind]->city,
                    'prospect' => $tempat_kerja[$ind]->prospect,
                    'persentasi' => $persentasi[$ind]
                ];
                $ind++;
            }
            $ind=0;

            $objectTempatKerja = json_decode (json_encode ($data), FALSE);

            // PEKERJAAN

            $prospectPekerjaan = demografi::get_prospectPekerjaan();
            $prospectPekerjaan = $prospectPekerjaan[0]->prospect;
            $tempat_Pekerjaan = demografi::get_Pekerjaan();
            $persentasiTempatPekerjaan = round($prospectPekerjaan/$total_leads * 100,2);

            $persentasi=[];$ind=0;
            foreach($tempat_Pekerjaan as $item){
                $persentasi[$ind]=round($tempat_Pekerjaan[$ind]->prospect/$prospectPekerjaan * 100,2);
                $ind++;
            }

            $ind=0;
            $data =[];
            foreach($tempat_Pekerjaan as $item){
                $data[$ind] = [
                    'nama' => $tempat_Pekerjaan[$ind]->TipePekerjaan,
                    'prospect' => $tempat_Pekerjaan[$ind]->prospect,
                    'persentasi' => $persentasi[$ind]
                ];
                $ind++;
            }
            $ind=0;

            $objectTempatPekerjaan = json_decode (json_encode ($data), FALSE);

            $usia = demografi::get_usia();
            $gender = demografi::get_gender();
            $penghasilan = demografi::get_penghasilan();
            $range_penghasilan = [];
            $data_total = [];
            foreach($penghasilan as $item){
                $data_total[] = $item->y;
                $range_penghasilan[] = $item->name;
            }

            return view("demografi.index",compact(
                'usia',
                'gender',
                'range_penghasilan',
                'data_total',
                'objectTempatTinggal',
                'persentasiTempatTinggal',
                'objectTempatKerja',
                'persentasiTempatKerja',
                'objectTempatPekerjaan',
                'persentasiTempatPekerjaan',
                'total_leads',
                'prospectTinggal',
                'prospectPekerjaan',
                'prospectKerja'
            ));
        }else{
            return view('demografi.blank');
        }

    }

    public function getkota(Request $request){
        $kota = demografi::getkota($request->provinsi)->pluck('city','id');
        return response()->json($kota);
    }

}
