<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        // dd($request);
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
        // dd($request);
        $project = project::find($KodeProject);
        $project->NamaProject = $request->NamaProject;

        $project->save();
        return redirect('projects')->with('status','Data Berhasil di ubah');

    }
}
