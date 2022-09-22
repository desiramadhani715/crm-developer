<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sales;
use App\Models\agent;
use App\Models\project;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\projectagent;
use App\Models\historysales;
use Illuminate\Support\Facades\DB;
use App\Mail\MakutaproMail;
use Illuminate\Support\Facades\Mail;

class SalesController extends Controller
{
    public function nonactive( $KodeAgent, $KodeSales, $UrutAgentSales){

        $username = sales::where(['KodeAgent'=>$KodeAgent, 'KodeSales'=>$KodeSales,'UrutAgentSales'=>$UrutAgentSales])->get();
        sales::where(['KodeSales'=>$KodeSales])->update(['UrutAgentSales'=>0]);
        user::where(['UsernameKP'=>$username[0]->UsernameKP])->update(['Active'=>0]);

        $data = sales::get_sales($KodeAgent,$KodeSales,$UrutAgentSales);$ind=0;
        if(count($data)>0){
            for($i=0;$i<count($data);$i++){
                sales::where(['KodeSales'=>$data[$i]->KodeSales])->update(['UrutAgentSales'=>$data[$i]->UrutAgentSales-1]);
            }
        }
        return redirect()->back()->with('status','Sales telah di non-aktifkan!');
    }

    public function active($KodeAgent,$KodeSales){

        $UrutAgentSales = sales::get_urut_agent_sales($KodeAgent);
        if(count($UrutAgentSales)== 0){
            $UrutAgentSales = 0;
        }else{
            $UrutAgentSales = $UrutAgentSales[0]->UrutAgentSales;
        }
        $username = sales::where(['KodeAgent'=>$KodeAgent, 'KodeSales'=>$KodeSales])->get();
        sales::where(['KodeSales'=>$KodeSales])->update(['UrutAgentSales'=>$UrutAgentSales+1]);
        user::where(['UsernameKP'=>$username[0]->UsernameKP])->update(['Active'=>1]);

        return redirect()->back()->with('status','Sales telah di aktifkan!');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($KodeAgent)
    {
        $sales = sales::get_data_sales($KodeAgent);
        $KodeProject = projectagent::get_KodeProject($KodeAgent);
        if(count($sales)>0){
            $salesAll = []; $ind=0;
            foreach($sales as $item){
                if(sales::get_closing_amount($sales[$ind]->KodeSales) == null){
                    $salesAll[]=[
                        'UsernameKP' => $sales[$ind]->UsernameKP,
                        'KodeSales' => $sales[$ind]->KodeSales,
                        'NamaSales' => $sales[$ind]->NamaSales,
                        'UrutAgentSales' => $sales[$ind]->UrutAgentSales,
                        'Hp' => $sales[$ind]->Hp,
                        'Email' => $sales[$ind]->Email,
                        'prospect' => 0,
                        'JoinDate' => $sales[$ind]->JoinDate,
                        'ClosingAmount' => 0,
                        'KodeProject' => $KodeProject[0]->KodeProject,
                        'PhotoUser' => $sales[$ind]->PhotoUser,
                        'Ktp' => $sales[$ind]->Ktp,
                        'Active' => $sales[$ind]->Active
                    ]; $ind++;
                }else{
                    $closingAm= sales::get_closing_amount($sales[$ind]->KodeSales);
                    $prospect = sales::prospect($sales[$ind]->KodeSales);
                    $salesAll[]=[
                        'UsernameKP' => $sales[$ind]->UsernameKP,
                        'KodeSales' => $sales[$ind]->KodeSales,
                        'NamaSales' => $sales[$ind]->NamaSales,
                        'UrutAgentSales' => $sales[$ind]->UrutAgentSales,
                        'Hp' => $sales[$ind]->Hp,
                        'Email' => $sales[$ind]->Email,
                        'prospect' => $prospect[0]->prospect,
                        'JoinDate' => $sales[$ind]->JoinDate,
                        'ClosingAmount' => $closingAm[0]->total,
                        'KodeProject' => $KodeProject[0]->KodeProject,
                        'PhotoUser' => $sales[$ind]->PhotoUser,
                        'Ktp' => $sales[$ind]->Ktp,
                        'Active' => $sales[$ind]->Active
                    ]; $ind++;
                }
            }
            $ind=0;
        }else{
            $sales = sales::get_data_sales($KodeAgent);
            $salesAll = []; $ind=0;
            foreach($sales as $item){
                $salesAll[]=[
                    'UsernameKP' => $sales[$ind]->UsernameKP,
                    'KodeSales' => $sales[$ind]->KodeSales,
                    'NamaSales' => $sales[$ind]->NamaSales,
                    'UrutAgentSales' => $sales[$ind]->UrutAgentSales,
                    'Hp' => $sales[$ind]->Hp,
                    'Email' => $sales[$ind]->Email,
                    'prospect' => 0,
                    'JoinDate' => $sales[$ind]->JoinDate,
                    'ClosingAmount' => 0,
                    'KodeProject' => $KodeProject[0]->KodeProject,
                    'PhotoUser' => $sales[$ind]->PhotoUser,
                    'Ktp' => $sales[$ind]->Ktp,
                    'Active' => $sales[$ind]->Active
                ]; $ind++;
            }
            $ind=0;
        }

        $object = json_decode (json_encode ($salesAll), FALSE);
        // dd($object);
        return view('sales.index',compact('object','KodeAgent'));
    }

    public function history($KodeSales){

        $history = historysales::history_sales($KodeSales);
        return view('sales.history',compact('history'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($KodeAgent)
    {
        // dd(sales::get_kode_sales($KodeAgent));
        $getKode = sales::get_kode_sales($KodeAgent);
        $NoUrut= str_pad($getKode[0]->UrutKodeSales+1,7,'0',STR_PAD_LEFT);
        $KodeSales = $KodeAgent.$NoUrut;
        return view('sales.create',compact('KodeAgent','KodeSales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $KodeAgent)
    {

        $getKode = sales::get_kode_sales($KodeAgent);
        $NoUrut= str_pad($getKode[0]->UrutKodeSales+1,7,'0',STR_PAD_LEFT);

        $projectAgent = sales::get_project_agent($KodeAgent);


        $UrutAgentSales = sales::get_urut_agent_sales($KodeAgent);
        // dd(count($UrutAgentSales), $UrutAgentSales);

        if($UrutAgentSales[0]->UrutAgentSales < 1){
            $UrutAgentSales = 0;
        }else{
            $UrutAgentSales = $UrutAgentSales[0]->UrutAgentSales;
        }
        // dd( $projectAgent,$UrutAgentSales);


        // USERNAME AND PASS GENERATE
        $namaProject = project::select('NamaProject')->where('KodeProject','=',$projectAgent[0]->KodeProject)->get();
        $temp = strtolower(str_replace(' ','',$request->NamaSales) . str_replace(' ','',$namaProject[0]->NamaProject));
        $temp_username = str_replace('-','',$temp);
        $username = substr($temp_username,-strlen($temp_username),8) . substr($request->Hp, strlen($request->Hp)-4, 4);
        $password = substr($request->Hp, strlen($request->Hp)-6, 6);

        $rules = [
            'NamaSales' => 'required',
            'Email' => 'required',
            'Hp' => 'required',
            // 'UsernameKP' => 'required|unique:User,UsernameKP'
            // 'PhotoUser' => 'mimes:jpeg,png,jpg,gif,svg',
            // 'Ktp' => 'mimes:jpeg,png,jpg,gif,svg'
        ];

        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['UsernameKP'] = $username;
        $data['ProjectAgentID'] = $projectAgent[0]->ProjectAgentID;
        $data['UrutAgentSales'] = $UrutAgentSales +1;
        $data['KodeProject'] = $projectAgent[0]->KodeProject;
        $data['KodeAgent'] = $KodeAgent;
        $data['UrutKodeSales'] = $NoUrut;
        if ($request->hasFile('PhotoUser')) {
            $destination_path = 'public/uploaded';
            $PhotoUser = $request->file('PhotoUser');
            $image_pp =
                time() .
                rand(1, 100) .
                '.' .
                $PhotoUser->getClientOriginalExtension();
            $data['PhotoUser'] = $image_pp;
            $request
                ->file('PhotoUser')
                ->storeAs($destination_path, $image_pp);
        }
        if ($request->hasFile('Ktp')) {
            $destination_path = 'public/uploaded';
            $Ktp = $request->file('Ktp');
            $image_ktp=
                time() .
                rand(1, 100) .
                '.' .
                $Ktp->getClientOriginalExtension();
            $data['Ktp'] = $image_ktp;
            $request
                ->file('Ktp')
                ->storeAs($destination_path, $image_ktp);
        }


        sales::create($data);
        
        User::create([
            'UsernameKP' => $username,
            'PasswordKP' => bcrypt($password),
            'Email' => $request->Email,
            'LevelUserID' => 'sales',
            'Active' => 1
        ]);


        $Agent = agent::select('NamaAgent','Pic','KodeProject')->where('KodeAgent',$request->KodeAgent)->get()[0];
        $project = project::select('NamaProject')->where('KodeProject',$Agent->KodeProject)->get()[0];
        $nama=strtoupper($request->NamaSales);
        $telp = '62'.substr($request->Hp,1);
        $link = "https://play.google.com/store/apps/details?id=com.crm.makutapro";

        $my_apikey = "BOGY33RL8K2ZPM7LIIWI";
        $destination = $telp; 
        $message = "Hallo $nama Anda telah terdaftar sebagai Sales dengan nama koordinator $Agent->Pic untuk project $project->NamaProject, berikut akses untuk login \n\nUsername : $username \n Password : $password \n Link Download Aplikasi: $link";
        $api_url = "http://panel.rapiwha.com/send_message.php";
        $api_url .= "?apikey=". urlencode ($my_apikey);
        $api_url .= "&number=". urlencode ($destination);
        $api_url .= "&text=". urlencode ($message);
        $my_result_object = json_decode(file_get_contents($api_url, false));

        $data = [
            'nama'=> $nama,
            'pic' => $Agent->Pic,
            'project' => $project->NamaProject,
            'username' => $username,
            'pass' => $password,
            'link' => $link 
        ];

        Mail::to($request->Email)->send(new MakutaproMail($data));
        
        return redirect('/agent/sales/'.$KodeAgent)->with('status','Success !');
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
    public function update(Request $request, $KodeSales)
    {
        $image_pp = $request->PhotoUser;
        $image_ktp = $request->Ktp;

        if ($request->hasFile('PhotoUser')) {
            $destination_path = 'public/uploaded';
            $PhotoUser = $request->file('PhotoUser');
            $image_pp =
                time() .
                rand(1, 100) .
                '.' .
                $PhotoUser->getClientOriginalExtension();
            $request
                ->file('PhotoUser')
                ->storeAs($destination_path, $image_pp);
        }
        if ($request->hasFile('Ktp')) {
            $destination_path = 'public/uploaded';
            $Ktp = $request->file('Ktp');
            $image_ktp=
                time() .
                rand(1, 100) .
                '.' .
                $Ktp->getClientOriginalExtension();
            $request
                ->file('Ktp')
                ->storeAs($destination_path, $image_ktp);
        }

        sales::where(['KodeSales'=> $KodeSales])->update([
            'NamaSales' => $request->NamaSales,
            'Hp' => $request->Hp,
            'PhotoUser' => $image_pp,
            'Ktp' => $image_ktp
        ]);

        $sales = sales::where(['KodeSales'=>$KodeSales])->select(['*'])->get();
        User::where(['UsernameKP' => $sales[0]->UsernameKP])->update([
            'Email' => $request->Email,
            'PasswordKP' => bcrypt($request->PasswordKP)
        ]);

        return redirect()->back()->with('status','Data berhasil diubah !');
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

    public function delete($KodeSales){
        $sales = sales::get_prospect($KodeSales);
        if($sales[0]->prospect == 0){
            $sales = sales::where(['KodeSales'=>$KodeSales])->select(['*'])->get();
            user::where(['UsernameKP' => $sales[0]->UsernameKP])->delete(['*']);
            sales::where(['UsernameKP' => $sales[0]->UsernameKP])->delete(['*']);
            return redirect()->back()->with('status','Data berhasil di hapus !');
        }else{
            return redirect()->back()->with('error','Data tidak bisa di hapus !');
        }
    }
}
