<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Travel;
use App\Models\User;
use App\Models\Response;
use Carbon\Carbon;
use App\Mail\FeedbackMail;
use Illuminate\Support\Facades\Mail;
class CheckCheckoutStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkout:check';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check users\' checkout time and send notifications if necessary';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
          \Log::info('status');
    $users = Travel::where('trip_status', 'Checkin')->where('notify_status','=',0)->get();
    $playerIds = [];
    foreach ($users as $user) {
      
        $currentDateTime = Carbon::now();

        $created_at = $user->created_at;
        $trip_duration = $user->trip_duration;
        // \Log::info($trip_duration);

        // Extract the hours and minutes using regular expressions
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
        
        // Output the final created_at value
        // \Log::info($created_at);
        if ($currentDateTime > $created_at) {
            // Perform actions here, such as sending notifications via OneSignal
            // You will need to integrate OneSignal into your Laravel app and use their API to send notifications
            // Example:
            // OneSignal::sendNotificationToUser('Your checkout time has exceeded. Please confirm your safety status.', $user->onesignal_player_id);
            
         
            
            
            $traveller=User::find($user->user_id);
            
            if($traveller->language === 'English'){
                $act_response='Hello, are you safe? The trip duration you entered has elapsed, please activate the check-out button now to let us know you are safe or we will send an SOS to your guardians in 5 minutes.';
            }else if($traveller->language === 'Spanish'){
                $act_response='Hola, ¿estás a salvo? El tiempo de viaje que ingresaste ha transcurrido, por favor activa el botón de check-out ahora para informarnos que estás a salvo, o enviaremos una señal de socorro a tus guardianes en 5 minutos.';
            }else if($traveller->language === 'Portuguese'){
                $act_response=' Olá, estás seguro? O tempo de duração da tua viagem expirou, por favor, ativa o botão de check-out agora para nos informar que estás seguro, ou enviaremos um pedido de socorro aos teus guardiões em 5 minutos.';
            }else if($traveller->language === 'Fula'){
                $act_response='Sannu, ya zama aiki? Taurari na ta ya saukaka, don Allah a ka shiga motoci na yanzu domin sanar da mu cewa kake lafiya ko muna yin amfani amma muna sa sosai na makiyan ku a lokaci 5.';
            }else if($traveller->language === 'Hausa'){
                $act_response='Sannu, kake jin duniya? Runako na musamman na nuna layin ƙidayi da kake shiga ya yi gefe, don Allah yi amfani daga bautar "check-out" yanzu domin mu sanar da mu cewa kake lafiya, ko muna yin amfani amma muna kawo misali kan ku a lokaci 5.';
            }else if($traveller->language === 'French'){
                $act_response="Bonjour, es-tu en sécurité ? La durée de voyage que tu as entrée a expiré, veuillez activer le bouton de check-out maintenant pour nous faire savoir que tu es en sécurité, sinon nous enverrons un SOS à tes gardiens dans 5 minutes.";
            }else if($traveller->language === 'Arabic'){
                $act_response="مرحبًا، هل أنت بأمان؟ مرت فترة الرحلة التي أدخلتها، يرجى تفعيل زر الخروج الآن لإعلامنا بأنك بأمان، وإلا سنرسل إشارة استغاثة إلى أقاربك في خمس دقائق.";
            }else if($traveller->language === 'Chinese'){
                $act_response="你好，你安全吗？您输入的行程持续时间已过，请立即激活退房按钮以通知我们您安全，否则我们将在5分钟内向您的亲属发送紧急求救信号。.";
            }else if($traveller->language === 'Yoruba'){
                $act_response="Bawo ni, n gbagbe o? Awon eto igbese ti o ri lo ti pari, jowo ṣeko ifa awon iroyin  pelu le, ki a ri pe o gba ase, tabi a maa fun awon agbekale re ipo ọkọlu si awọn ọkunrin ti o leẹṣẹ ninu 5 akọkọ.";
            }else if($traveller->language === 'Igbo'){
                $act_response="Ndewo, adịghị ekpe onye nke a? Igbakọ iri n'adakwasiri gị enweghị, biko weputara ihe njikọ  aha aha iwe na-agụ na kedu onye mere gị nke a nwere ike ahụrụ, ma ọ bụtara soọsụ gị na-agụ na nwa nne gị na 5 izu.";
            }
$activity_response=Response::create([
    'user_id'=>$traveller->id,
                         'type_id'=>$user->id,
                         'type'=>'travel',
                         'response'=> $act_response,
                         'admin_name'=>'Admin',
    ]);
            $playerId = [$traveller->device_token];


            $subject= $act_response;

            $content = array(
                    "en" => $subject
                );

            $fields = array(
                'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                'include_player_ids' =>   $playerId,
                'data' => array("foo" => "NewMassage","type" => 'reminder'),
                'contents' => $content
            );

            $fields = json_encode($fields);


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
          
            curl_close($ch);
            // \Log::info($currentDateTime .' '.  $checkoutTime  .' '. $user->trip_duration  .' '. $user->created_at .' '.$created_at );
            $user->notify_status=1;
            $user->save();
            \Log::info($response);
            // Update the user's trip_status to 'checkout'

return $response;






        }else{
            \Log::info('User have a time to checkout');
        }

       
    }
}
      
        // $feedback= $traveller->firstname;
        // Mail::to($traveller->email)->send(new FeedbackMail($feedback));


    
   
    
    
    
    
    
    
    
}
