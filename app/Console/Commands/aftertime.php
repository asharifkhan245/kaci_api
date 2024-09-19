<?php

namespace App\Console\Commands;
use App\Models\Travel;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Dependant;
use App\Mail\FeedbackMail;
use App\Models\Coordinate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;
use App\Mail\TravelsafeMail;
class aftertime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'after:time';

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
        $users = Travel::where('trip_status', 'Checkin')->where('notify_status','=',1)->where('email_status','=',0)->get();
        if($users->count()>0){
foreach($users as $u){
    $user=User::find($u->user_id);
    
    $coordinate=Coordinate::where('travel_id','=',$u->id)->where('user_id','=',$u->user_id) ->latest()
    ->first();;

if($coordinate->count()>0) {


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
    $map= str_replace(
        ['{latitude}', '{longitude}', 'YOUR_API_KEY'],
        [$latitude, $longitude, 'AIzaSyCfxiXntIfBzrcRCETjXcLk_Akq0Qyv2j4'],
        $embed_link
    );
    $u['longitude']=  $longitude;
    $u['latitude']=$latitude;

    $travel=$u;
    echo ('upar');
    $dependant=Dependant::where('user_id', '=', $user->id)->get();
    if($dependant->count()>0) {
        foreach($dependant as $d) {
            $dependentname=$d->name;
            Mail::to($d->email)->send(new TravelsafeMail($user, $map, $dependentname, $travel));
        }

    }
}else{
    $coordinatesString = $u->coordinate;
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
$map=[];
    // Replace the placeholders with actual values
    $map['link'] = str_replace(
        ['{latitude}', '{longitude}', 'YOUR_API_KEY'],
        [$latitude, $longitude, 'AIzaSyCfxiXntIfBzrcRCETjXcLk_Akq0Qyv2j4'],
        $embed_link
    );
    $map['longitude']=  $longitude;
    $map['latitude']=$latitude;
    $travel=$u;
    echo ('niche');
    $dependant=Dependant::where('user_id', '=', $user->id)->get();
    if($dependant->count()>0) {
        foreach($dependant as $d) {
            $dependentname=$d->name;
            Mail::to($d->email)->send(new TravelsafeMail($user, $map, $dependentname, $travel));
        }

    }
}
}
        }
    }
}
