<?php

namespace App\Http\Controllers;

use App\Models\unit;
use App\Models\project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unit = unit::get_unit();
        $project = project::get_project(Auth::user()->UsernameKP);

        return view('unit type.index',compact('unit','project'));
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
        $data = $request->all();
        unit::create($data);

        return redirect()->back()->with('status','Data berhasil diinput');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $UnitID)
    {
        $unit = unit::findOrFail($UnitID);

        $unit->UnitName = $request->UnitName;
        $unit->ProjectCode = $request->ProjectCode;

        $unit->update();

        return redirect()->back()->with('status','Data berhasil diubah');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy($UnitID)
    {
        unit::destroy($UnitID);

        return redirect()->back()->with('status','Data berhasil dihapus');
    }
}