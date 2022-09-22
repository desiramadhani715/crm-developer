<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\project;
use App\Models\agent;
use App\Models\prospect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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

        Session::forget('KodeAgent');
        Session::forget('KodeSales');
        Session::forget('Status');
        Session::forget('move');
        Session::put('filter','filter');

        $prospect = project::get_leads_project($KodeProject);
        $project = project::get_project(Auth::user()->UsernameKP);
        $agent = agent::get_data_agent2($KodeProject);
        $status = prospect::get_status();

        return view('projects.leads',compact('prospect','project','KodeProject','agent','status'));
    }

    public function leads_filter(Request $request){
        Session::put('KodeAgent',$request->KodeAgent);
        Session::put('KodeSales',$request->KodeSales);
        Session::put('status',$request->status);
        Session::put('move','move');
        Session::forget('filter');
        

        $KodeProject = $request->KodeProject;
        $prospect = $this->getFilter();
        $project = project::get_project(Auth::user()->UsernameKP);
        $agent = agent::get_data_agent2($KodeProject);
        $status = prospect::get_status();

        return view('projects.leads',compact('prospect','project','KodeProject','agent','status'));

    }

    public function getFilter(){
        $request = new stdClass();
        $request->KodeAgent = Session::get('KodeAgent');
        $request->KodeSales = Session::get('KodeSales');
        $request->status = Session::get('status');

        return project::leads_filter($request->KodeAgent,$request->KodeSales,$request->status);
    }

    public function leads_move(Request $request){
        dd($request->all());
    }
}
