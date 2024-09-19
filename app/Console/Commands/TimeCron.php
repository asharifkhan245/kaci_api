<?php

namespace App\Console\Commands;
use App\Models\Travel;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Dependant;
use App\Mail\FeedbackMail;
use App\Models\Coordinate;
use App\Models\General_Countries;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;
use App\Mail\TravelsafeMail;
use App\Mail\ArabicTravel;
use App\Mail\ChineseTravel;
use App\Mail\SpanishTravel;
use App\Mail\FulaTravel;
use App\Mail\FrenchTravel;
use App\Mail\PortugueseTravel;
use App\Mail\YorubaTravel;
use App\Mail\IgboTravel;
use App\Mail\HausaTravel;

use App\Models\Admin_Email;
class TimeCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'time:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Working after 5 minutes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info('time');
        $users = Travel::where('trip_status','=','Checkin')->where('notify_status','=',1)->where('email_status','=',0)->get();
        if($users->count()>0){
foreach($users as $u){

// Parse the existing trip duration
$tripDuration = $u->trip_duration; // Replace 'duration' with the actual field name in your database
list($hours, $minutes) = explode(':', $tripDuration);

// Convert hours and minutes to integers
$hours = (int)$hours;
$minutes = (int)$minutes;

// Add 5 minutes to the trip duration
$minutes += 5;

// Handle rollover if minutes exceed 60
if ($minutes >= 60) {
    $hours += 1;
    $minutes -= 60;
}

// Format the updated duration back to "hh:mm" format
$updatedDuration = sprintf("%02dh:%02dm", $hours, $minutes);

// // Convert the created_at timestamp to a DateTime object
// $createdAt = $u->created_at;

  $currentDateTime = Carbon::now();

        $created_at = $u->created_at;
        $trip_duration = $updatedDuration;
//         // \Log::info($trip_duration);

//         // Extract the hours and minutes using regular expressions
        if (preg_match('/(\d+)h:(\d+)m/', $trip_duration, $matches)) {
            $hours = $matches[1];
            $minutes = $matches[2];
        } else {
            // Handle the case where the trip_duration format is invalid
            // For example, throw an exception or set default values.
        }
        
        // Output the extracted hours and minutes to check their values
        // \Log::info($hours);
        // \Log::info($minutes);
        
        // Create a Carbon instance from the created_at string
        $created_at = Carbon::parse($created_at);
        
        // Add the trip_duration to the created_at
        $created_at = $created_at->addHours($hours)->addMinutes($minutes);
        


// Save the changes
\Log::info(  $created_at);

if($currentDateTime > $created_at){
       $user=User::find($u->user_id);
    $coordinate=Coordinate::where('travel_id','=',$u->id)->where('user_id','=',$u->user_id) ->latest()
    ->first();

if($coordinate) {


    $coordinatesString = $coordinate->coordinate;
    $coordinatesArray = json_decode($coordinatesString, true);

    // Check if $coordinatesArray is an array before accessing the 'latitude'
    if (is_array($coordinatesArray) && isset($coordinatesArray['latitude'])) {
        $latitude = $coordinatesArray['latitude'];


    } else {
        $latitude=null;
    }
    if (is_array($coordinatesArray) && isset($coordinatesArray['longitude'])) {
        $longitude = $coordinatesArray['longitude'];

    } else {
        $longitude = null;
    }





    // The Google Maps embed link with placeholders for latitude and longitude
    $embed_link = "https://www.google.com/maps/embed/v1/view?key=YOUR_API_KEY&center={latitude},{longitude}&zoom=18&maptype=satellite";

    // Replace the placeholders with actual values
    $map = str_replace(
        ['{latitude}', '{longitude}', 'YOUR_API_KEY'],
        [$latitude, $longitude, 'AIzaSyCfxiXntIfBzrcRCETjXcLk_Akq0Qyv2j4'],
        $embed_link
    );
     $u->email_status=true;
    $u->save();
    $u['longitude']=  $longitude;
    $u['latitude']=$latitude;

    $travel=$u;
     
    $travel['link']="https://kacihelp.com/travelsafe/$travel->reference_code";
    \Log::info($travel['link']);
  
    $dependant=Dependant::where('user_id', '=', $u->user_id)->get();
    $travel['created_at']=Carbon::parse($travel->created_at)->addHour();
   if($dependant->count()>0) {
        $count = 0;
        foreach($dependant as $d) {
           
       
               if ($count < 2) {
           
          \Log::info($d->email);
            $dependentname=$d->name;
                   
          if ($user->language === 'English') {

    Mail::to($d->email)->send(new TravelsafeMail($user, $map, $dependentname, $travel));
} elseif ($user->language === 'Arabic') {
  
    Mail::to($d->email)->send(new ArabicTravel($user, $map, $dependentname, $travel));
} elseif ($user->language === 'Yoruba') {
   
    Mail::to($d->email)->send(new YorubaTravel($user, $map, $dependentname, $travel));
} elseif ($user->language === 'Chinese') {
   
    Mail::to($d->email)->send(new ChineseTravel($user, $map, $dependentname, $travel));
} elseif ($user->language === 'Igbo') {
  
    Mail::to($d->email)->send(new IgboTravel($user, $map, $dependentname, $travel));
} elseif ($user->language === 'French') {
    
    Mail::to($d->email)->send(new FrenchTravel($user, $map, $dependentname, $travel));
} elseif ($user->language === 'Fula') {
    
    Mail::to($d->email)->send(new FulaTravel($user, $map, $dependentname, $travel));
} elseif ($user->language === 'Portuguese') {
    
    Mail::to($d->email)->send(new PortugueseTravel($user, $map, $dependentname, $travel));
} elseif ($user->language === 'Spanish') {
  
    Mail::to($d->email)->send(new SpanishTravel($user, $map, $dependentname, $travel));
} elseif ($user->language === 'Hausa') {
  
    Mail::to($d->email)->send(new HausaTravel($user, $map, $dependentname, $travel));
} else {
    
      Mail::to($d->email)->send(new TravelsafeMail($user, $map, $dependentname, $travel));
}
               $phone_number=$d->phone_nubmer;
            $country=General_Countries::where('country_name','=',$d->country)->first();
            $country_code=$country->country_code;
            $countryCode = preg_replace('/[^0-9]/', '', $country_code);
$number=$countryCode.$phone_number;
  \Log::info('hello');
$link=$travel['link'];
              try {
           
// $data = array(
//     "phone_number" =>  $number,
//     "device_id" => "58d07e4c-799c-4873-a2e9-22cb5793d405",
//     "template_id" => "dea507fe-7af7-4f24-92af-a24ff02cbd7c",
//     "api_key" => "TLsWe5NjzlDfhPVWCaPHbrnj9ggcUXlL81WYn15lhysyUjblgRQeSsLr9eAnY7",
//     "data" => array(
//         "user_full_name" => "*$d->name*",
//         "user_dependant_name" => "*$user->firstname $user->lastname*",
//         "travelsafe_link" => "$link",
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
$templateId = 'd1dc1004-f1b1-4c64-8748-1687d797c2e3';
$templateParams = ["*$d->name*", "*$user->firstname $user->lastname*","$link"];

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


        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while sending the Whatsapp']);
        }
          
        try {
           
            $curl = curl_init();
$data = array(
    "api_key" => "TLsWe5NjzlDfhPVWCaPHbrnj9ggcUXlL81WYn15lhysyUjblgRQeSsLr9eAnY7",
    "to" => $number,
    "from" => "N-Alert",
    "sms" => "Dear $d->name, Your Dependent $user->firstname $user->lastname is in an emergency; follow this link to view the details:  $link ", 
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
            return response()->json(['message' => 'An error occurred while sending the SMS']);
        }
        
          $count++;
                     \Log::info($count);
        }
        }

    }
      $adminemail = Admin_Email::find(1);
              if ($adminemail) {
                  $email[] = $adminemail->email;
              
                  foreach ($email as $key => $value) {
                      $emailAddress = str_replace(['[', ']', '\\', '\"'], '', $value); // Remove unwanted characters
                      $emailAddress = explode(',', $emailAddress); // Convert the string to an array
              
                      foreach ($emailAddress as $email) {
                          $email = trim($email, "\""); // Remove double quotes from the email address
                          $dependentname='Admin';
                              
                            $travel['line']='The Dependent of';
                          Mail::to($email)->send(new TravelsafeMail($user, $map, $dependentname, $travel));
                          $mail[]=$email;
                          
                             \Log::info($email);
                      }
                    
                      
                  }
              }
}else{

 $coordinatesString = $u->coordinate;
    $coordinatesArray = json_decode($coordinatesString, true);
     \Log::info( $coordinatesArray);
      
      $coordinateString = json_decode( $coordinatesArray, true);

if (isset($coordinateString['latitude'])) {
    $latitude = floatval($coordinateString['latitude']);
      \Log::info($latitude);
} else {
    $latitude = null;
}
if (isset($coordinateString['longitude'])) {
    $longitude = floatval($coordinateString['longitude']);
      \Log::info($longitude);
} else {
    $longitude = null;
}


 

    // The Google Maps embed link with placeholders for latitude and longitude
    $embed_link = "https://www.google.com/maps/embed/v1/view?key=YOUR_API_KEY&center={latitude},{longitude}&zoom=18&maptype=satellite";

    // Replace the placeholders with actual values
    $map = str_replace(
        ['{latitude}', '{longitude}', 'YOUR_API_KEY'],
        [$latitude, $longitude, 'AIzaSyCfxiXntIfBzrcRCETjXcLk_Akq0Qyv2j4'],
        $embed_link
    );
   
 $u->email_status=true;
    $u->save();
    $u['longitude']=  $longitude;
    $u['latitude']=$latitude;

    $travel=$u;
 
    $travel['link']="https://kacihelp.com/travelsafe/$travel->reference_code/";
    
    \Log::info($travel['link']);
   
    $dependant=Dependant::where('user_id', '=', $u->user_id)->get();
    $travel['created_at']=Carbon::parse($travel->created_at)->addHour();
   if($dependant->count()>0) {
        $count = 0;
        foreach($dependant as $d) {
           
      
               if ($count < 2) {
         
         \Log::info($d->email);
                  
            $dependentname=$d->name;
          if ($user->language === 'English') {
    $travel['line'] = 'Your Dependent';
    Mail::to($d->email)->send(new TravelsafeMail($user, $map, $dependentname, $travel));
} elseif ($user->language === 'Arabic') {
    $travel['line'] = 'المعالَمُون الخاصون بك';
    Mail::to($d->email)->send(new ArabicTravel($user, $map, $dependentname, $travel));
} elseif ($user->language === 'Yoruba') {
    $travel['line'] = 'Igbẹkẹle Rẹ';
    Mail::to($d->email)->send(new YorubaTravel($user, $map, $dependentname, $travel));
} elseif ($user->language === 'Chinese') {
    $travel['line'] = '您的受托人';
    Mail::to($d->email)->send(new ChineseTravel($user, $map, $dependentname, $travel));
} elseif ($user->language === 'Igbo') {
    $travel['line'] = 'Ndabere gị';
    Mail::to($d->email)->send(new IgboTravel($user, $map, $dependentname, $travel));
} elseif ($user->language === 'French') {
    $travel['line'] = 'Votre personne à charge';
    Mail::to($d->email)->send(new FrenchTravel($user, $map, $dependentname, $travel));
} elseif ($user->language === 'Fula') {
    $travel['line'] = 'Masoyi na ku';
    Mail::to($d->email)->send(new FulaTravel($user, $map, $dependentname, $travel));
} elseif ($user->language === 'Portuguese') {
    $travel['line'] = 'Seu Dependente';
    Mail::to($d->email)->send(new PortugueseTravel($user, $map, $dependentname, $travel));
} elseif ($user->language === 'Spanish') {
    $travel['line'] = 'Su dependiente';
    Mail::to($d->email)->send(new SpanishTravel($user, $map, $dependentname, $travel));
} elseif ($user->language === 'Hausa') {
    $travel['line'] = 'Dogaran ku';
    Mail::to($d->email)->send(new HausaTravel($user, $map, $dependentname, $travel));
} else {
     $travel['line'] = 'Your Dependent';
      Mail::to($d->email)->send(new TravelsafeMail($user, $map, $dependentname, $travel));
}
               $phone_number=$d->phone_number;
            $country=General_Countries::where('country_name','=',$d->country)->first();
            $country_code=$country->country_code;
            $countryCode = preg_replace('/[^0-9]/', '', $country_code);
$number=$countryCode.$phone_number;
  \Log::info('hello');
$link=$travel['link'];
              try {
           
// $data = array(
//     "phone_number" =>  $number,
//     "device_id" => "58d07e4c-799c-4873-a2e9-22cb5793d405",
//     "template_id" => "dea507fe-7af7-4f24-92af-a24ff02cbd7c",
//     "api_key" => "TLsWe5NjzlDfhPVWCaPHbrnj9ggcUXlL81WYn15lhysyUjblgRQeSsLr9eAnY7",
//     "data" => array(
//         "user_full_name" => "*$d->name*",
//         "user_dependant_name" => "*$user->firstname $user->lastname*",
//         "travelsafe_link" => "$link",
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
$templateId = 'd1dc1004-f1b1-4c64-8748-1687d797c2e3';
$templateParams = ["*$d->name*", "*$user->firstname $user->lastname*","$link"];

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



        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while sending the Whatsapp']);
        }
          
        try {
           
            $curl = curl_init();
$data = array(
    "api_key" => "TLsWe5NjzlDfhPVWCaPHbrnj9ggcUXlL81WYn15lhysyUjblgRQeSsLr9eAnY7",
    "to" => $number,
    "from" => "N-Alert",
    "sms" => "Dear $d->name, Your Dependent $user->firstname $user->lastname is in an emergency; follow this link to view the details:  $link ", 
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
            return response()->json(['message' => 'An error occurred while sending the SMS']);
        }
        
          $count++;
                     \Log::info($count);
               }
        }

    }
       $adminemail = Admin_Email::find(1);
              if ($adminemail) {
                  $email[] = $adminemail->email;
              
                  foreach ($email as $key => $value) {
                      $emailAddress = str_replace(['[', ']', '\\', '\"'], '', $value); // Remove unwanted characters
                      $emailAddress = explode(',', $emailAddress); // Convert the string to an array
              
                      foreach ($emailAddress as $email) {
                          $email = trim($email, "\""); // Remove double quotes from the email address
                          $dependentname='Admin';
                            
                           $travel['line']='The Dependent of';
                          Mail::to($email)->send(new TravelsafeMail($user, $map, $dependentname, $travel));
                          $mail[]=$email;
                           \Log::info($email);
                      }
                    
                      
                  }
              }
              
              
}
}else{
     \Log::info('Time remaining');
}




 
}
        }
    
    
}}
