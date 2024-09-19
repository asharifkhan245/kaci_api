<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Travel;
use App\Models\Sos;
use App\Models\Report;
use App\Models\Suggestion;
use App\Models\Ambulance;
use App\Models\Climate;
use App\Models\Admin_Notification;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPassword;
use App\Mail\ChangePassword;
use App\Mail\WelcomeMail;
use App\Models\Used_Code;
use App\Models\General_Countries;
use App\Models\Country;
use App\Models\Sub_Admin;
use App\Models\User_Location;
use App\Mail\ArabicWelcome;          // Arabic (Translation: "مرحبًا")
use App\Mail\ChineseWelcome;         // Chinese (Simplified) (Translation: "欢迎")
use App\Mail\FrenchWelcome;          // French (Translation: "Bienvenue")
use App\Mail\FulaWelcome;            // Fula (Translation: "Ndank ndank")
use App\Mail\HausaWelcome;           // Hausa (Translation: "Maganar")
use App\Mail\IgboWelcome;            // Igbo (Translation: "Nwokeoma")
use App\Mail\PortugueseWelcome;      // Portuguese (Translation: "Bem-vindo" for males, "Bem-vinda" for females)
use App\Mail\SpanishWelcome;         // Spanish (Translation: "Bienvenido" for males, "Bienvenida" for females)
use App\Mail\YorubaWelcome; 
use App\Mail\ArabicCp;             // Arabic (Translation: "تم تغيير كلمة المرور")
use App\Mail\ChineseCp;            // Chinese (Simplified) (Translation: "已更改密码")
use App\Mail\FrenchCp;             // French (Translation: "Mot de passe modifié")
use App\Mail\FulaCp;               // Fula (Translation: "Kalimna Terabu Laamu")
use App\Mail\HausaCp;              // Hausa (Translation: "Tuni Ta Hanyar Amfani")
use App\Mail\IgboCp;               // Igbo (Translation: "Nwere Ebe Kweghi Akwukwo")
use App\Mail\PortugueseCp;         // Portuguese (Translation: "Senha Alterada")
use App\Mail\SpanishCp;            // Spanish (Translation: "Contraseña Cambiada")
use App\Mail\YorubaCp;             // Yoruba (Translation: "Ọrọigbaniwọ́ Ayélujára")


class AuthController extends Controller
{
    public $successStatus = 200;
    public function phone_verification(Request $request){

       
          
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|unique:users,phone_number',
            'country_code'=>'required'

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input=$request->all();
        $token = rand(1000,9999);
        $country_code=$input['country_code'];
        $phoneNumber=$input['phone_number'];

     

// Remove the "+" character from the country code
$countryCode = preg_replace('/[^0-9]/', '', $country_code);
$number=$countryCode.$phoneNumber;

       
        
        try {
           
            $curl = curl_init();
$data = array(
    "api_key" => "TLsWe5NjzlDfhPVWCaPHbrnj9ggcUXlL81WYn15lhysyUjblgRQeSsLr9eAnY7",
    "to" => $number,
    "from" => "N-Alert",
    "sms" => $token. " is your One Time Password (OTP) to get started on Kaci. This code should not be shared and will expire after 15 minutes. ", 
    "type" => "plain", 
    "channel" => "dnd" 
);

$post_data = json_encode($data);

curl_setopt_array($curl, array(
CURLOPT_URL => "https://api.ng.termii.com/api/sms/send",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "POST",
CURLOPT_POSTFIELDS => $post_data,
CURLOPT_HTTPHEADER => array(
"Content-Type: application/json",
),
));

$response = curl_exec($curl);

curl_close($curl);
  


        } catch (\Exception $e) {
            
        }
        
        
        try {
           
// $data = array(
//     "phone_number" =>  $number,
//     "device_id" => "58d07e4c-799c-4873-a2e9-22cb5793d405",
//     "template_id" => "3ef5026c-dc05-4136-af4a-d5beee01f9ef",
//     "api_key" => "TLsWe5NjzlDfhPVWCaPHbrnj9ggcUXlL81WYn15lhysyUjblgRQeSsLr9eAnY7",
//     "data" => array(
       
//         "otp" =>"$token", 
//          "product_name" =>"Kaci" ,
//         "time_in_minutes" => "15 minutes"
//     )
// );

// $curl = curl_init();

// curl_setopt_array($curl, array(
//     CURLOPT_URL => "https://api.ng.termii.com/api/send/template",
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_ENCODING => "",
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 0,
//     CURLOPT_FOLLOWLOCATION => true,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => "POST",
//     CURLOPT_POSTFIELDS => json_encode($data),
//     CURLOPT_HTTPHEADER => array(
//         'Content-Type: application/json'
//     ),
// ));

// $response = curl_exec($curl);

// curl_close($curl);

$apiKey = '987eec7ae6024a5cca4d1087671678e7';
$apiEndpoint = 'http://api.gupshup.io/sm/api/v1/template/msg';

// Replace these values with your actual data
$source = '2348140040081';
$destination = $number;
$templateId = '452a657e-0758-4e72-baa9-a17da7f2e73d';
$templateParams = ["*$token*", "*15*"];

// Create a Guzzle client
$client = new \GuzzleHttp\Client();

// Prepare the request parameters
$params = [
    'headers' => [
        'apikey' => $apiKey,
        'Content-Type' => 'application/x-www-form-urlencoded',
    ],
    'form_params' => [
        'source' => $source,
        'destination' => $destination,
        'template' => json_encode(['id' => $templateId, 'params' => $templateParams]),
    ],
];

// Make the POST request
$response = $client->post($apiEndpoint, $params);

// Get the response body as a string
$responseBody = $response->getBody()->getContents();

// Output the response

        } catch (\Exception $e) {
            
        }
         
        $success['message']= 'OTP has been sent to your SMS and Whatsapp';
        $success['OTP']=$token;
        $success['status'] = 200;

        return response()->json(['success' => $success], $this->successStatus);
    }
    

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'firstname'=>'required',
            'lastname'=>'required',
            'email'=>'required|unique:users,email',
            'resident_country'=>'required',
            'country'=>'required',
            'phone_number' => 'required',
            'password'=>'required',
           'device_name'=>'required',
            'device_token'=>'required',
            'language'=>'required',
       

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input=$request->all();
        $user = User::create($input);

        $accessToken = $user->createToken('authToken')->accessToken;
        $country=General_Countries::where('country_name','=',$user->country)->first();
        $user['country_code']=$country->country_code;
        $user['flag_code']=$country->flag_code;
        
        $resident_country=Country::where('country','=',$user->resident_country)->first();
         $user['resident_country_code']=$resident_country->country_code;
        $user['resident_flag_code']=$resident_country->flag_code;
        $user['notify_status']='Active';
        if ($user->device_name === 'Android') {
            $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
            $user['new_id'] = $new_id;
        } elseif ($user->device_name === 'IOS') {
           $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
            $user['new_id'] = $new_id;
        }
        $sub=Sub_Admin::all();
        if($sub->count()>0){
            foreach($sub as $a){
                  $admin_notification=Admin_Notification::create([
            'user_id'=>$user->id,
            'u_id'=>$user['new_id'],
            'notification'=>'New User Signup',
            'name'=>$user->firstname,
            'status'=>'Unread',
            'sub_admin_id'=>$a->id
            ]);
            }
           
        }
       
            if($request->coordinate){
                  $user_location=User_Location::create(
                ['coordinate'=>$request->coordinate,
                'user_id'=>$user->id]
                );
            }
          if ($user->language === 'Arabic') {
    Mail::to($user->email)->send(new ArabicWelcome($user));
} elseif ($user->language === 'Chinese') {
    Mail::to($user->email)->send(new ChineseWelcome($user));
} elseif ($user->language === 'French') {
    Mail::to($user->email)->send(new FrenchWelcome($user));
} elseif ($user->language === 'Fula') {
    Mail::to($user->email)->send(new FulaWelcome($user));
} elseif ($user->language === 'Hausa') {
    Mail::to($user->email)->send(new HausaWelcome($user));
} elseif ($user->language === 'Igbo') {
    Mail::to($user->email)->send(new IgboWelcome($user));
} elseif ($user->language === 'Portuguese') {
    Mail::to($user->email)->send(new PortugueseWelcome($user));
} elseif ($user->language === 'Spanish') {
    Mail::to($user->email)->send(new SpanishWelcome($user));
} elseif ($user->language === 'Yoruba') {
    Mail::to($user->email)->send(new YorubaWelcome($user));
} else {
   Mail::to($user->email)->send(new WelcomeMail($user));
}
        $success['data'] = $user;
        
        $success['token']= $accessToken;
        $success['status'] = 200;

        return response()->json(['success' => $success], $this->successStatus);
        
    }
    public function login(Request $request)
    {
        $data = $request->validate([
            'phone_number'=>'required',
            'password'=>'required',
            'country'=>'required',
            'device_name'=>'required',
            'device_token'=>'required',
            'coordinate'=>'required',
        ]);
        $user = User::where('phone_number', $data['phone_number'])
        ->where('password', $data['password'])
        ->where('country', $data['country'])
        ->where('status', '!=', 'Delete')->first();
        
       if($user){
           if($user->status != 'InActive'){
               
                $user->tokens()->delete();
              $token = $user->createToken('authToken')->accessToken;
            
        $user->device_name=$request->device_name;
        $user->device_token=$request->device_token;
        $user->save();
          $success['token']=$token;
           $country=General_Countries::where('country_name','=',$user->country)->first();
        $user['country_code']=$country->country_code;
        $user['flag_code']=$country->flag_code;
         if($request->coordinate){
                  $user_location=User_Location::create(
                ['coordinate'=>$request->coordinate,
                'user_id'=>$user->id]
                );
            }
            $resident_country=Country::where('country','=',$user->resident_country)->first();
         $user['resident_country_code']=$resident_country->country_code;
        $user['resident_flag_code']=$resident_country->flag_code;
            $success['data'] = $user;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus); 
           }else{
                 $success['status']=400;
        $success['message']="Account Block";
        return response()->json(['error' => $success]);
           }
        
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }


//     public function change_password(Request $request,$id){
//         $request->validate([
//             'old_password'=>'required',
//             'password'=>'required|confirmed',
//         ]);

// $user=User::find($id);
// if($user){
//     if($user->password === $request->old_password){
      
//             $user->password=$request->password;
//         $user->save();
//         $success['data']=$user;
//           if ($user->language === 'Arabic') {
//     Mail::to($user->email)->send(new ArabicCp($user));
// } elseif ($user->language === 'Chinese') {
//     Mail::to($user->email)->send(new ChineseCp($user));
// } elseif ($user->language === 'French') {
//     Mail::to($user->email)->send(new FrenchCp($user));
// } elseif ($user->language === 'Fula') {
//     Mail::to($user->email)->send(new FulaCp($user));
// } elseif ($user->language === 'Hausa') {
//     Mail::to($user->email)->send(new HausaCp($user));
// } elseif ($user->language === 'Igbo') {
//     Mail::to($user->email)->send(new IgboCp($user));
// }  elseif ($user->language === 'Portuguese') {
//     Mail::to($user->email)->send(new PortugueseCp($user));
// } elseif ($user->language === 'Spanish') {
//     Mail::to($user->email)->send(new SpanishCp($user));
// } elseif ($user->language === 'Yoruba') {
//     Mail::to($user->email)->send(new YorubaCp($user));
// } else {
//       Mail::to($user->email)->send(new ChangePassword($user));
// }
//         $success['status']=200;
//         $success['message']="Password Reset Successfully";
//         return response()->json(['success' => $success], $this->successStatus);
       
//     }else{
//         $success['status']=400;
//         $success['message']="Incorrect Old Password
        
//         ";
//         return response()->json(['error' => $success]);
//     }
// }else{
//     $success['status']=400;
//     $success['message']="not found";
//     return response()->json(['error' => $success]);
// }
//     }
    
    
    
    
    public function change_password(Request $request, $id)
{
    $request->validate([
        'old_password' => 'required',
        'password' => 'required|confirmed',
    ]);

    $user = User::find($id);
    if ($user) {
        if ($user->password === $request->old_password) {
            
            
            if ($user->password === $request->password) {
                $success['status'] = 400;
                $success['message'] = "You have previously used this password; please create a new one";
                return response()->json(['error' => $success]);
            }

            $user->password = $request->password;
            $user->save();
            $success['data'] = $user;

            if ($user->language === 'Arabic') {
                Mail::to($user->email)->send(new ArabicCp($user));
            } elseif ($user->language === 'Chinese') {
                Mail::to($user->email)->send(new ChineseCp($user));
            } elseif ($user->language === 'French') {
                Mail::to($user->email)->send(new FrenchCp($user));
            } elseif ($user->language === 'Fula') {
                Mail::to($user->email)->send(new FulaCp($user));
            } elseif ($user->language === 'Hausa') {
                Mail::to($user->email)->send(new HausaCp($user));
            } elseif ($user->language === 'Igbo') {
                Mail::to($user->email)->send(new IgboCp($user));
            } elseif ($user->language === 'Portuguese') {
                Mail::to($user->email)->send(new PortugueseCp($user));
            } elseif ($user->language === 'Spanish') {
                Mail::to($user->email)->send(new SpanishCp($user));
            } elseif ($user->language === 'Yoruba') {
                Mail::to($user->email)->send(new YorubaCp($user));
            } else {
                Mail::to($user->email)->send(new ChangePassword($user));
            }

            $success['status'] = 200;
            $success['message'] = "Password Reset Successfully";
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = "Incorrect Old Password";
            return response()->json(['error' => $success]);
        }
    } else {
        $success['status'] = 400;
        $success['message'] = "User not found";
        return response()->json(['error' => $success]);
    }
}

    
    public function phone_verify_passowrd(Request $request){
        $request->validate([
            'phone_number'=>'required',
            'country'=>'required',
            ]);
            
            $user=User::where('phone_number','=',$request->phone_number)->where('country','=',$request->country)->first();
            
            if($user!=null){
                $token=rand(1000,9999);
                 $country=General_Countries::where('country_name','=',$user->country)->first();
        $user['country_code']=$country->country_code;
        $user['flag_code']=$country->flag_code;
                $success['data'] = $user;
        $success['OTP']= $token;
          Mail::to($user->email)->send(new ForgotPassword($user, $token));
           $country_code=$country->country_code;
        $phoneNumber=$user->phone_number;
// Remove the "+" character from the country code
$countryCode = preg_replace('/[^0-9]/', '', $country_code);
$number=$countryCode.$phoneNumber;
        
        
         try {
           
            $curl = curl_init();
$data = array(
    "api_key" => "TLsWe5NjzlDfhPVWCaPHbrnj9ggcUXlL81WYn15lhysyUjblgRQeSsLr9eAnY7",
    "to" => $number,
    "from" => "N-Alert",
    "sms" => $token. " is your One Time Password (OTP) to reset your Kaci password. This code should not be shared and will expire after 15 minutes. ", 
    "type" => "plain", 
    "channel" => "dnd" 
);

$post_data = json_encode($data);

curl_setopt_array($curl, array(
CURLOPT_URL => "https://api.ng.termii.com/api/sms/send",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "POST",
CURLOPT_POSTFIELDS => $post_data,
CURLOPT_HTTPHEADER => array(
"Content-Type: application/json"
),
));

$response = curl_exec($curl);

curl_close($curl);
  


        } catch (\Exception $e) {
            
        }
        $success['status'] = 200;
  $success['message']="OTP sent to your phone number and Email Successfully";
        return response()->json(['success' => $success], $this->successStatus);
            }else{
                  $success['status']=400;
    $success['message']="Phone Number not exist";
    return response()->json(['error' => $success]);
            }
    }
    
    
     public function reset_password(Request $request, $id)
    {
        $user = User::find($id);
        $data = $request->validate([
            'password' => "required|confirmed",
        ]);
        $password =$data['password'];
        $user->password = $password;
        $user->save();
        $success['id'] = $user['id'];
        $success['name'] = $user['firstname'];
      if ($user->language === 'Arabic') {
    Mail::to($user->email)->send(new ArabicCp($user));
} elseif ($user->language === 'Chinese') {
    Mail::to($user->email)->send(new ChineseCp($user));
} elseif ($user->language === 'French') {
    Mail::to($user->email)->send(new FrenchCp($user));
} elseif ($user->language === 'Fula') {
    Mail::to($user->email)->send(new FulaCp($user));
} elseif ($user->language === 'Hausa') {
    Mail::to($user->email)->send(new HausaCp($user));
} elseif ($user->language === 'Igbo') {
    Mail::to($user->email)->send(new IgboCp($user));
}  elseif ($user->language === 'Portuguese') {
    Mail::to($user->email)->send(new PortugueseCp($user));
} elseif ($user->language === 'Spanish') {
    Mail::to($user->email)->send(new SpanishCp($user));
} elseif ($user->language === 'Yoruba') {
    Mail::to($user->email)->send(new YorubaCp($user));
} else {
      Mail::to($user->email)->send(new ChangePassword($user));
}

        $success['status'] = 200;

        $success['message'] = "Password Changed Successfully";
        return response()->json(['success' => $success], $this->successStatus);
    }
    
    
    public function show_all_users(){
        $user=User::all();
        $data=[];
        
        foreach($user as $u){
            $country=General_Countries::where('country_name','=',$u->country)->first();
        
            if($country){
                $u['flag_code'] = $country->flag_code;
                $u['country_code'] = $country->country_code;
            }
        
            if ($u->device_name === 'Android') {
                $new_id = 'AND' . str_pad($u->id, 7, '0', STR_PAD_LEFT);
                $u['new_id'] = $new_id;
               
            } elseif ($u->device_name === 'IOS') {
                $new_id = 'IOS' . str_pad($u->id, 7, '0', STR_PAD_LEFT);
                $u['new_id'] = $new_id;
            }
            
            $verifyBadge = Used_code::where('user_id', $u->id)
                ->where('expiry_date', '>', now())
                ->first();
            $u['verify_badge'] = $verifyBadge ? true : false;

            $data[]= $u;
        
        }
        
        $success['data'] =$data;
        $success['status'] = 200;

        $success['message'] = "Users found Successfully";
        return response()->json(['success' => $success], $this->successStatus);
    }
    
    public function show_user_id($id){
        $user = User::find($id);
          $success['data'] = $user;
        $success['status'] = 200;

        $success['message'] = "User found Successfully";
        return response()->json(['success' => $success], $this->successStatus);
    }
    
    public function delete_user($id){
          $user=User::find($id);
                if($user){
                    $travel=Travel::where('user_id','=',$user->id)->get();
                    if($travel){
                        foreach($travel as $t){
                            $t->delete();
                        }
                    }
                     $emergency=Sos::where('user_id','=',$user->id)->get();
                    if($emergency){
                        foreach($emergency as $t){
                            $t->delete();
                        }
                    }
                     $ireport=Report::where('user_id','=',$user->id)->get();
                    if($ireport){
                        foreach($ireport as $t){
                            $t->delete();
                        }
                    }
                     $suggestion=Suggestion::where('user_id','=',$user->id)->get();
                    if( $suggestion){
                        foreach( $suggestion as $t){
                            $t->delete();
                        }
                    }
                   $climate=Climate::where('user_id','=',$user->id)->get();
                    if($climate){
                        foreach($climate as $t){
                            $t->delete();
                        }
                    }
                    $user->delete();
                       $success['data']=$user;
                $success['status']=200;
                $success['message']="user deleted"; 
                return response()->json(['success' => $success],$this->successStatus);
                }else{
                    $success['status']=400;
$success['message']="not found";


return response()->json(['error' => $success]);
                }
    }
    
    public function ban_unban(Request $request, $id){
            $user = User::find($id);
            if($user->status === 'Active'){
                $user->status = 'InActive';
                $user->save();
                    $success['data'] = $user;
        $success['status'] = 200;

        $success['message'] = "User BAN Successfully";
        return response()->json(['success' => $success], $this->successStatus);
            }else{
                  $user->status = 'Active';
                $user->save();
                     $success['data'] = $user;
        $success['status'] = 200;

        $success['message'] = "User UNBAN Successfully";
          return response()->json(['success' => $success], $this->successStatus);
            }
    }
    
   public function user_location($id){
       $user_location=User_Location::where('user_id','=',$id)->latest()->first();
       if($user_location){
          $success['data'] =$user_location;
        $success['status'] = 200;

        $success['message'] = "User location found Successfully";
          return response()->json(['success' => $success], $this->successStatus);
       }else{
             $success['status']=400;
$success['message']="not found";


return response()->json(['error' => $success]);
       }
   }
  public function check_block($id){
     $user=User::find($id);
     if($user){
         if($user->status==='Active'){
               $success['data'] =$user;
        $success['status'] = 200;

        $success['message'] = "User Active";
          return response()->json(['success' => $success], $this->successStatus); 
         }else{
               $success['data'] =$user;
        $success['status'] = 200;

        $success['message'] = "User InActive";
          return response()->json(['success' => $success], $this->successStatus); 
         }
       
     }else{
             $success['status']=400;
$success['message']="not found";


return response()->json(['error' => $success]);
       }
  }
  
  public function login_test(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password'=>'required'

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        
        $user=User::where('email','=',$request->email)->where('password','=',$request->password)->first();
        if($user){
             $success['data'] =$user;
        $success['status'] = 200;

        $success['message'] = "Login Successfully";
          return response()->json(['success' => $success], $this->successStatus); 
        }else{
              $success['status']=400;
$success['message']="Login Credential Incorrect";


return response()->json(['error' => $success]);
        }
  }
}
