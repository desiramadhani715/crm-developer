<?php 
namespace App\Helper;

use App\Models\historyblast;
use App\Models\historyprospect;
use App\Models\historyprospectmove;
use App\Models\historysales;
use App\Models\prospect;
use App\Models\agent;
use Illuminate\Support\Facades\DB;

class Helper
{
    public static function blast($KodeProject){
        //BlastID terakhir
        $LastBlastID = historyblast::last_blastID('KodeProject',$KodeProject);
        
        $sendby=[];
        if($LastBlastID[0]->BlastID != null){
            
            $LastBlast = historyblast::last_blast($LastBlastID[0]->BlastID);
            
            $agent = agent::get_agent($LastBlast[0]->KodeProject);

            if(count($agent) == 1){
                $NextAgent = historyblast::next_agent(1,$KodeProject);
            }
            else{
                $MaxSortAgent = agent::max_sort_agent($LastBlast[0]->KodeProject);
                
                $MinSortAgent = agent::min_sort_agent($LastBlast[0]->KodeProject);
                
                if($LastBlast[0]->BlastAgentID == $MaxSortAgent[0]->max){
                    
                    $NextAgent = historyblast::next_agent($MinSortAgent[0]->min,$LastBlast[0]->KodeProject);
                    
                }
                else{
                    
                    $NextAgent = historyblast::next_agent($LastBlast[0]->BlastAgentID+1,$LastBlast[0]->KodeProject);
                }
    
            }
            
            $sendby = historyblast::sendby($LastBlast[0]->KodeProject);
        }else{
            
            $NextAgent = historyblast::next_agent(1,$KodeProject);
            $sendby = historyblast::sendby($KodeProject);
        }

         //Mencari Sales Terakhir
         $NextSales=[];
         //BlastID terakhir
         $LastBlastID = historyblast::last_blastID('KodeAgent',$NextAgent[0]->KodeAgent);
         // dd($LastBlastID);
         if($LastBlastID[0]->BlastID != null){

             $LastBlast = historyblast::last_blast($LastBlastID[0]->BlastID);
             //mencari next agent
             // dd($LastBlast);
             $sales = historyblast::sales($NextAgent[0]->KodeAgent); // pilih sales yg aktiv aja
             // dd($sales);

             if($LastBlast[0]->BlastSalesID < count($sales)){
                 $NextSales = historyblast::next_sales($LastBlast[0]->BlastSalesID+1,$NextAgent[0]->KodeAgent);

             }else{
                 $NextSales = historyblast::next_sales(1,$NextAgent[0]->KodeAgent);
             }
             // dd($NextSales);
         }else{

             $NextSales = historyblast::next_sales(1,$NextAgent[0]->KodeAgent);

         }

         $data = [
            'NextAgent' => $NextAgent,
            'NextSales' => $NextSales,
         ];

         return $data;
    }

    public static function blast_sales($KodeAgent){
        //Mencari Sales Terakhir
        $NextSales=[];
        //BlastID terakhir
        $LastBlastID = historyblast::last_blastID('KodeAgent',$KodeAgent);
        // dd($LastBlastID);
        if($LastBlastID[0]->BlastID != null){

            $LastBlast = historyblast::last_blast($LastBlastID[0]->BlastID);
            //mencari next agent
            // dd($LastBlast);
            $sales = historyblast::sales($KodeAgent); // pilih sales yg aktiv aja
            // dd($sales);

            if($LastBlast[0]->BlastSalesID < count($sales)){
                $NextSales = historyblast::next_sales($LastBlast[0]->BlastSalesID+1,$KodeAgent);

            }else{
                $NextSales = historyblast::next_sales(1,$KodeAgent);
            }
            // dd($NextSales);
        }else{

            $NextSales = historyblast::next_sales(1,$KodeAgent);

        }

        $data = [
            'NextSales' => $NextSales,
        ];

        return $data;
    }

    public static function SendWA($destination, $message){
        $my_apikey = "CTO3GH4VXNVT8CKDDP7A";
        $api_url = "http://panel.rapiwha.com/send_message.php";
        $api_url .= "?apikey=". urlencode ($my_apikey);
        $api_url .= "&number=". urlencode ($destination);
        $api_url .= "&text=". urlencode ($message);
        $my_result_object = json_decode(file_get_contents($api_url, false));
    }

    public static function PushNotif($UsernameKP, $title, $body){
        $url = 'https://fcm.googleapis.com/fcm/send';
        $FcmToken = DB::table('TokenFCM')
            ->select('TokenFCM')
            ->where('id', DB::raw("(select max(`id`) from TokenFCM where `UsernameKP` = '$UsernameKP')"))
            ->get();
        if(count($FcmToken) > 0){
            $serverKey = 'AAAA8QlsNCY:APA91bFXmxrGz5CMJxxXF_AzREaaHu4h6fW7zZv5I1T565gTSxPcEZJ1S3UgvQZkS4EmssM5IF9LkXViaBguvivjSxTxGdgNXWmbLvVJ6K2-NjNGFEIwheeEgBKjveZLrXs-Un4A255H';

            $data = [
                "registration_ids" => [$FcmToken[0]->TokenFCM],
                "notification" => [
                    "title" => $title,
                    "body" => $body,
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
