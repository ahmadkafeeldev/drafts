<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use App\Models\Notification;
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function ifExists($model, $id)
    {
        $data = $model::where('id', $id)->first();
        if($data){            
            return $data;
        }else{
            $modelNameString = explode("\\", $model);
            throw new \ErrorException(strtolower(preg_replace('/(?<=[a-z])[A-Z]|[A-Z](?=[a-z])/', ' $0', $modelNameString[2])).' does not Exists');            
        }
    }

    public function ifEmailExists($email)
    {
        $data = User::where('email', $email)->first();
        
        if($data){           
            throw new \ErrorException('Email has already been Taken');
        }
    }

    public function success($data)
    {
        if(sizeof($data) > 1){
            return response()->json(['status' => true, 'message' => $data[0], 'data' => $data[1]], 200)->setEncodingOptions(JSON_NUMERIC_CHECK);
        }else{
            return response()->json(['status' => true, 'message' => $data[0]], 200)->setEncodingOptions(JSON_NUMERIC_CHECK);
        }     
    }

    public function error($message)
    {
        return response()->json(['status' => false, 'message' => $message], 200)->setEncodingOptions(JSON_NUMERIC_CHECK);           
    }

    //Delete profile image
    public function deleteExistingImage($user_id)
    {
        try{          
            $user = User::where('id', $user_id)->first(['id', 'profile_image']);

            if($user->profile_image != "" && $user->profile_image != "profile_images/default.png"){
                if(realpath($user->profile_image)){
                    unlink(realpath($user->profile_image));
                }                        
            }
        }catch(\Exception $e)
        {
            throw new \ErrorException($e->getMessage());
        }
    }

    //Phone OTP
    public function phone_otp($message, $phone)
    {
        try{
            $from = '15139604811';
            $auth_SID = 'AC484ebece8bcd4947599cc950448df185';
            
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.twilio.com/2010-04-01/Accounts/'.$auth_SID.'/Messages.json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'Body='.$message.'&From=%2B'.$from.'&To=%2B'.$phone,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic QUM0ODRlYmVjZThiY2Q0OTQ3NTk5Y2M5NTA0NDhkZjE4NTphNTAxZjZkZDNkMmU3ZDRiNGY1ZmM5NmU4YWQ2MWM5Zg==',
                    'Content-Type: application/x-www-form-urlencoded'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return $response;
        }catch(\Exception $e)
        {
            throw new \ErrorException($e->getMessage());
        }
    }

    // public function create_notification1($notification_from, $notification_to, $notification_message, $notification_type, $booking_id)
    // {
    //     $notification = new Notification;
    //     $notification->notification_from = $notification_from;
    //     $notification->notification_to = $notification_to;
    //     $notification->notification = $notification_message;
    //     $notification->notification_type = $notification_type;
    //     $notification->booking_id = $booking_id;
    //     $notification->notification_time = time();
    //     $notification->save();

    //     // $user_details = User::where('id', $notification_to)->first(['id', 'device_type', 'fcm_token']);
    //     // //FCM Notification Code
    //     // $data = ["title"=>'HAYLO', 'message'=> $notification_message, 'notification_type' => $notification_type, 'notification_time' => time(), 'booking_id' => $booking_id];
                    
    //     // if($user_details->device_type == "android")
    //     // {
    //     //     $this->android_notification($user_details->fcm_token, $data);
    //     // }else{
    //     //     $this->ios_notification($user_details->fcm_token, $notification_message, $data);
    //     // }
    //     //End FCM Notifications Code 
    // }

    // //FCM Notification Code
    // $data = ["title"=>'EAZYLIFE', 'message'=> $trainer_details->name.' has Assigned a Workout to You', 'notification_type' => 'workout_assigned', 'notification_time' => time(), 'meal_plan_id' => "", 'workout_id' => $user_workout->id];
                
    // if($user_details->device_type == "android")
    // {
    //     return $this->android_notification($user_details->token, $data);
    // }else{
    //     return $this->ios_notification($user_details->token, $trainer_details->name.' has Assigned a Workout to You', $data);
    // }
    // //End FCM Notifications Code 

    //Android Notification
    public function android_notification($token, $data)
    {
        $json_data = array('priority'=>'HIGH','to'=>$token,'data'=>$data);
                                    
        $data = json_encode($json_data);
        // return $data;
        //FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = 'BEfMJI5xiFcPoBrQEiwpBmbqzrFUOh_Tri3s1vrRwiAxdOgbe8cebIwQhNCPUJW5W_MEdgeobJed19O24nH3KYM';
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );
        //CURL request to route notification to FCM connection server (provided by Google)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        
        //End FCM Android Code
    }
    
    //iOS Notification
    public function ios_notification($token, $body, $data)
    {
        //Start FCM iOS Code 
       
        // return $token;
        $json_data = array('to'=> $token, 'mutable_content' => true, 'content_available' => true, 'notification'=>array("title"=>'THOSE WHO TRAVEL', "body" => $body, "sound" => "default", "priority" => "high", "badge" => 1), 'data'=> $data);
        
        $data = json_encode($json_data);
        // return $data;                
        //FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = 'AAAAKw1AxaU:APA91bF03DRi7hBq0H7l_9iQfUhckJZazlkRk-4dXFDvJkraDHnQoUDlx-O4ICzjL68Kn72MOhHTMs6CSqohIt79dlNtd7rPsdz7MqrNhyl4q0Sfem6ztG6UIncYWysHbPp2XKRu2kDW';
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );
        //CURL request to route notification to FCM connection server (provided by Google)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        
        //End FCM iOS Code
    }

    public function calculate_age($dob)
    {
        $dateOfBirth = $dob;
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        return $diff->format('%y');
    }

    function calculate_distance($lat1, $lon1, $lat2, $lon2) {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
          return 0;
        }
        else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper('k');
        
            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }

    public function create_notification($from_id, $to_id, $booking_id, $noti, $type)
    {
        $notification = new Notification;
        $notification->from_id = $from_id;
        $notification->to_id = $to_id;
        $notification->booking_id = $booking_id;
        $notification->notification = $noti;
        $notification->type = $type;
        $notification->time = time();
        $notification->seen = 0;
        $notification->save();

        //FCM Notification Code
        $user_details = User::where('id', $to_id)->first(['id', 'device_type', 'onesignal_id']);

        $this->send_notification('KlimaRide', $noti, $user_details->onesignal_id, ['booking_id' => $booking_id, 'notification' => $noti, 'notification_type' => $type, 'time' => time()]);
    }

    public function send_notification($title, $text, $target_onesignal_id, $data = [])
    {
		$contents = array(
            "en" => $text
        );
        $headings = array(
            "en" => $title
        );
        /*$data = array(
            "foo" => "bar"
        );*/

        $fields = array(
            'app_id' => ONESIGNAL_APP_ID,
            'include_player_ids' => [$target_onesignal_id],
            'contents' => $contents,
            'headings' => $headings,
          	'data' => $data
        );
      	// return $fields;
        /*if(!empty($data)) {
            $fields['data'] = $data;
         }*/

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://onesignal.com/api/v1/notifications",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            //CURLOPT_POSTFIELDS => "{\"include_player_ids\":[\"$target_onesignal_id\"],\"contents\":{\"en\":\"$text\"}}",
            CURLOPT_POSTFIELDS => json_encode($fields),
            CURLOPT_HTTPHEADER => [
                "Authorization: Basic " . ONESIGNAL_REST_KEY,
                "accept: application/json",
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
}
