<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\project;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaign = DB::table('ProjectCampaign')
                        ->join('Project','Project.KodeProject','ProjectCampaign.KodeProject')
                        ->join('PT','PT.KodePT','Project.KodePT')
                        ->join('User','User.UsernameKP','PT.UsernameKP')
                        ->where('PT.UsernameKP',Auth::user()->UsernameKP)
                        ->get();
        $project = project::get_project(Auth::user()->UsernameKP);
        // dd($campaign);
        return view('campaign.index',compact('campaign','project'));
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
        DB::table('ProjectCampaign')->insert([
            'KodeProject' => $request->KodeProject,
            'NamaCampaign' => $request->NamaCampaign
        ]);
        
        return redirect('/campaign');
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
        // dd($id); 
        DB::table('ProjectCampaign')->where('CampaignID',$id)->update([
           'NamaCampaign' => $request->NamaCampaign, 
        ]);

        return redirect('/campaign');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('ProjectCampaign')->where('CampaignID',$id)->delete();
        return redirect()->back();
    }
}