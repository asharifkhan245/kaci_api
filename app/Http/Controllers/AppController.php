<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Help_Book;
use App\Models\User;
use App\Models\Info_Bank;
use App\Models\Country;
use App\Models\Location;
use App\Models\Consult;
use App\Models\Beep;
use App\Models\BeepLike;
use App\Models\BeepSave;
use App\Models\BeepComment;
use App\Models\CommentLike;
use App\Models\SharedBeep;
use App\Models\Notification;
use App\Models\Ambulance_Service;
use App\Models\Agencies;
use App\Models\Feedback;
use Illuminate\Support\Str;
use App\Mail\FeedbackMail;
use App\Mail\EmailChangedMail;
use App\Models\Dependant;
use App\Models\Medication;
use App\Models\Ambulance;
use App\Models\Travel;
use App\Models\Sos;
use Illuminate\Support\Facades\Mail;
use App\Models\Report;
use App\Models\Suggestion;
use App\Models\General_Countries;
use App\Models\Climate;
use App\Models\Module_Request;
use App\Models\Response;
use App\Models\Coordinate;
use App\Models\Admin_Notification;
use App\Models\Activity;
use App\Models\Popup;
use App\Models\Faq;
use App\Models\Sub_Account;
use App\Models\Kaci_Code;
use App\Models\Used_Code;
use App\Models\Admin_Email;
use App\Models\Relation;
use App\Models\Sub_Admin;
use App\Models\ReportItem;
use App\Models\ReportType;
use App\Models\SearchHistory;
use App\Models\SponsoredBeep;
use App\Models\CommentReply;
use App\Models\Agency_Notification;
use App\Models\ClimateBeeplike;
use App\Models\ClimateBeepComment;
use App\Models\ClimateCommentReply;
use App\Models\ClimateCommentLike;
use App\Models\ShareClimateBeep;
use App\Models\ClimateSaveBeep;
use Carbon\Carbon;
use App\Mail\SosMail;
use App\Mail\TravelMail;
use App\Mail\AmbulanceMail;
use App\Mail\FDAdminMail;
use App\Mail\ReportMail;
use App\Mail\SuggestionMail;
use App\Mail\Emergency;
use App\Mail\Arabicfeedback;
use App\Mail\Chinesefeedback;
use App\Mail\Frenchfeedback;
use App\Mail\Fulafeedback;
use App\Mail\Hausafeedback;
use App\Mail\Igbofeedback;
use App\Mail\Portuguesefeedback;
use App\Mail\Spanishfeedback;
use App\Mail\Yorubafeedback;
use App\Mail\ArabicEmergency;
use App\Mail\ChineseEmergency;
use App\Mail\FrenchEmergency;
use App\Mail\FulaEmergency;
use App\Mail\IgboEmergency;
use App\Mail\PortugueseEmergency;
use App\Mail\SpanishEmergency;
use App\Mail\YorubaEmergency;
use App\Mail\HuasaEmergency;
use App\Mail\TravelsafeMail;
use App\Mail\Auto_Reply_Mail;
use App\Mail\EnglishOtp;
use App\Mail\HausaOtp;
use App\Mail\FulaOtp;
use App\Mail\FrenchOtp;
use App\Mail\PortugueseOtp;
use App\Mail\SpanishOtp;
use App\Mail\YorubaOtp;
use App\Mail\IgboOtp;
use App\Mail\ChineseOtp;
use App\Mail\ArabicOtp;
use App\Mail\BeepReportMail;
use App\Mail\ConsultMail;
use Symfony\Component\Mailer\Exception\TransportException;
use App\Models\Auto_Reply;
use App\Models\Group_Chat;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AppController extends Controller
{
    public $successStatus = 200;

    public function device_banner(Request $request)
    {
        $request->validate([
            'device_name' => 'required',
            'resident_country' => 'required'
        ]);
        $banner = Banner::where('device', '=', $request->device_name)->where('country', '=', $request->resident_country)->get();
        if ($banner->count() > 0) {
            $success['data'] = $banner;
            $success['status'] = 200;


            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['message'] = 'Not found';
            $success['status'] = 200;


            return response()->json(['success' => $success], $this->successStatus);
        }
    }

    public function android_banner()
    {

        $banner = Banner::where('device', '=', 'Android')->get();
        if ($banner->count() > 0) {
            $success['data'] = $banner;
            $success['status'] = 200;


            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['message'] = 'Not found';
            $success['status'] = 200;


            return response()->json(['success' => $success], $this->successStatus);
        }
    }


    public function ios_banner()
    {

        $banner = Banner::where('device', '=', 'IOS')->get();
        if ($banner->count() > 0) {
            $success['data'] = $banner;
            $success['status'] = 200;


            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['message'] = 'Not found';
            $success['status'] = 200;


            return response()->json(['success' => $success], $this->successStatus);
        }
    }


    //     public function edit_profile(Request $request,$id){

    //             $user = User::find($id);
    //             if($request->otp === false){
    //                 $token=rand(0000,9999);
    //                 if($request->email != $user->email){
    //                      if ($user->language === 'Arabic') {
    //     Mail::to($request->email)->send(new ArabicOtp($user,$token));
    // } elseif ($user->language === 'Chinese') {
    //     Mail::to($request->email)->send(new ChineseOtp($user,$token));
    // } elseif ($user->language === 'French') {
    //     Mail::to($request->email)->send(new FrenchOtp($user,$token));
    // } elseif ($user->language === 'Fula') {
    //     Mail::to($request->email)->send(new FulaOtp($user,$token));
    // } elseif ($user->language === 'Hausa') {
    //     Mail::to($request->email)->send(new HausaOtp($user,$token));
    // } elseif ($user->language === 'Igbo') {
    //     Mail::to($request->email)->send(new IgboOtp($user,$token));
    // } elseif ($user->language === 'Portuguese') {
    //     Mail::to($request->email)->send(new PortugueseOtp($user,$token));
    // } elseif ($user->language === 'Spanish') {
    //     Mail::to($request->email)->send(new SpanishOtp($user,$token));
    // } elseif ($user->language === 'Yoruba') {
    //     Mail::to($request->email)->send(new YorubaOtp($user,$token));
    // } else {
    //       Mail::to($request->email)->send(new EnglishOtp($user,$token));
    // }
    // $success['status']=150;
    // $success['token']=$token;
    //                 }else{
    //                     $success['status']=200;
    //                 }

    //                 if($request->phone_number != $user->phone_number){
    //                       $country=General_Countries::where('country_name','=',$request->country)->first();
    //           $country_code=$country->country_code;
    //         $phoneNumber=$request->phone_number;
    // // Remove the "+" character from the country code
    // $countryCode = preg_replace('/[^0-9]/', '', $country_code);
    // $number=$countryCode.$phoneNumber;


    //          try {

    //             $curl = curl_init();
    // $data = array(
    //     "api_key" => "TLsWe5NjzlDfhPVWCaPHbrnj9ggcUXlL81WYn15lhysyUjblgRQeSsLr9eAnY7",
    //     "to" => $number,
    //     "from" => "N-Alert",
    //     "sms" => $token. " is your One Time Password (OTP) to reset your Kaci password. This code should not be shared and will expire after 15 minutes. ",
    //     "type" => "plain",
    //     "channel" => "dnd"
    // );

    // $post_data = json_encode($data);

    // curl_setopt_array($curl, array(
    // CURLOPT_URL => "https://api.ng.termii.com/api/sms/send",
    // CURLOPT_RETURNTRANSFER => true,
    // CURLOPT_ENCODING => "",
    // CURLOPT_MAXREDIRS => 10,
    // CURLOPT_TIMEOUT => 0,
    // CURLOPT_FOLLOWLOCATION => true,
    // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    // CURLOPT_CUSTOMREQUEST => "POST",
    // CURLOPT_POSTFIELDS => $post_data,
    // CURLOPT_HTTPHEADER => array(
    // "Content-Type: application/json"
    // ),
    // ));

    // $response = curl_exec($curl);

    // curl_close($curl);



    //         } catch (\Exception $e) {

    //         }
    //          if ($user->language === 'Arabic') {
    //     Mail::to($user->email)->send(new ArabicOtp($user,$token));
    // } elseif ($user->language === 'Chinese') {
    //     Mail::to($user->email)->send(new ChineseOtp($user,$token));
    // } elseif ($user->language === 'French') {
    //     Mail::to($user->email)->send(new FrenchOtp($user,$token));
    // } elseif ($user->language === 'Fula') {
    //     Mail::to($user->email)->send(new FulaOtp($user,$token));
    // } elseif ($user->language === 'Hausa') {
    //     Mail::to($user->email)->send(new HausaOtp($user,$token));
    // } elseif ($user->language === 'Igbo') {
    //     Mail::to($user->email)->send(new IgboOtp($user,$token));
    // } elseif ($user->language === 'Portuguese') {
    //     Mail::to($user->email)->send(new PortugueseOtp($user,$token));
    // } elseif ($user->language === 'Spanish') {
    //     Mail::to($user->email)->send(new SpanishOtp($user,$token));
    // } elseif ($user->language === 'Yoruba') {
    //     Mail::to($user->email)->send(new YorubaOtp($user,$token));
    // } else {
    //       Mail::to($user->email)->send(new EnglishOtp($user,$token));
    // }
    //               $success['status']=150;
    // $success['token']=$token;
    //                 }else{
    //                     $success['status']=200;
    //                 }
    //                  return response()->json(['success' => $success], $this->successStatus);

    //             }

    //           if($request->otp === true){
    //                  $validator = Validator::make($request->all(), [
    //                 'profile_image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
    //                 'email' => 'unique:users',
    //                 'phone_number' => 'unique:users',

    //             ]);

    //             $input = $request->all();
    //             if ($request->hasfile('profile_image')) {


    //     $image = time().'.'.$request->file('profile_image')->extension();
    //     $path = $request->file('profile_image')->storeAs('profile', $image, ['disk' => 's3']);
    //     $url = Storage::disk('s3')->url('profile/'.$image);
    //     $user->profile_image = "https://storage.kacihelp.com/".$path;
    //             } elseif ($request->filled('profile_image')) {
    //                 $user->profile_image = $request->profile_image;
    //             }

    //             // dd($input['old_password'],$user->password);


    //             if ($request->firstname) {
    //                 $user->firstname = $request->firstname;
    //             } else {
    //             }
    //             if ($request->lastname) {
    //                 $user->lastname = $request->lastname;
    //             } else {
    //             }
    //             if ($request->birth_date) {
    //                 $user->birth_date = $request->birth_date;
    //             } else {
    //             }
    //             if ($request->location) {
    //                 $user->location = $request->location;
    //             } else {
    //             }
    //             if ($request->address) {
    //                 $user->address = $request->address;
    //             } else {
    //             }
    //             if ($request->gender) {
    //                 $user->gender = $request->gender;
    //             } else {
    //             }
    //             if ($request->blood_group) {
    //                 $user->blood_group = $request->blood_group;
    //             }  if ($request->resident_country) {
    //                 $user->resident_country = $request->resident_country;
    //             } else {
    //             }
    //             if ($request->email) {
    //                 $user->email = $input['email'];
    //             } else {
    //             }
    //             if ($request->phone_number) {
    //                 $user->phone_number = $input['phone_number'];
    //             } else {
    //             }
    //             if ($request->country) {
    //                 $user->country = $request->country;
    //             } else {
    //             }
    // $dependant=Dependant::where('user_id','=',$id)->get();
    // if($dependant->count() >= 2){
    //     $formattedSerial = str_pad($id, 9, '0', STR_PAD_LEFT);

    //             // Concatenate the module code, random code, and formatted serial number
    //             $referenceCode = '1'.$formattedSerial;

    //         $user->ksn =  $referenceCode;

    // }else{

    // }

    //             $user->save();
    //              $country=General_Countries::where('country_name','=',$user->country)->first();
    //         $user['country_code']=$country->country_code;
    //         $user['flag_code']=$country->flag_code;
    //         $resident_country=Country::where('country','=',$user->resident_country)->first();
    //          $user['resident_country_code']=$resident_country->country_code;
    //         $user['resident_flag_code']=$resident_country->flag_code;
    //             $success['data'] = $user;
    //             $success['status'] = 200;
    //             return response()->json(['success' => $success], $this->successStatus);
    //           }

    //         }


    public function edit_profile(Request $request, $id)
    {
        $user = User::find($id);

        if ($request->otp === 'true') {
            $validator = Validator::make($request->all(), [
                'email' => 'unique:users,email',
                'phone_number' => 'unique:users,phone_number',
            ]);

            $all_user = User::where('id', '!=', $id)->get();
            
            foreach ($all_user as $au) {
                
                if ($au->email === $request->email) {
                    $success['status'] = 400;
                    $success['message'] = $validator->errors();
                    return response()->json(['error' => $success]);
                }
                if ($au->phone_number === $request->phone_number) {
                    $success['status'] = 400;
                    $success['message'] = $validator->errors();
                    return response()->json(['error' => $success]);
                }
            }

            $dependant = Dependant::where('user_id', '=', $user->id)->get();
            if ($dependant->count() > 0) {
                foreach ($dependant as $d) {
                    if ($d->email === $request->email) {
                        $success['status'] = 400;
                        $success['message'] = 'This Email already use in Dependant';
                        return response()->json(['error' => $success]);
                    }
                    if ($d->phone_number === $request->phone_number) {
                        $success['status'] = 400;
                        $success['message'] = 'This Phone Number already use in Dependant';
                        return response()->json(['error' => $success]);
                    }
                }
            }


            $input = $request->all();

            if ($request->hasfile('profile_image')) {
                $image = rand(00000000000, 35321231251231) . '.' . $request->file('profile_image')->extension();
                $path = $request->file('profile_image')->storeAs('profile', $image, ['disk' => 's3']);
                $url = Storage::disk('s3')->url('profile/' . $image);
                $user->profile_image = "https://storage.kacihelp.com/" . $path;
                
            } elseif ($request->filled('profile_image')) {
                $user->profile_image = $request->profile_image;
                $success['profile_image'] = $request->profile_image;
            }

            // dd($input['old_password'],$user->password);


            if ($request->firstname) {
                $user->firstname = $request->firstname;
            } else {
            }
            if ($request->lastname) {
                $user->lastname = $request->lastname;
            } else {
            }
            if ($request->birth_date) {
                $user->birth_date = $request->birth_date;
            } else {
                $success['status'] = 400;
                $success['message'] = 'Date of Birth Required';
                return response()->json(['error' => $success]);
            }
            if ($request->location) {
                $user->location = $request->location;
            } else {
                $success['status'] = 400;
                $success['message'] = 'Location Required';
                return response()->json(['error' => $success]);
            }
            if ($request->address) {
                $user->address = $request->address;
            } else {
                $success['status'] = 400;
                $success['message'] = 'Address Required';
                return response()->json(['error' => $success]);
            }
            if ($request->language) {
                $user->language = $request->language;
            } else {
            }
            if ($request->gender) {
                $user->gender = $request->gender;
            } else {
                $success['status'] = 400;
                $success['message'] = 'Gender Required';
                return response()->json(['error' => $success]);
            }
            if ($request->blood_group) {
                $user->blood_group = $request->blood_group;
            }
            if ($request->resident_country) {
                $user->resident_country = $request->resident_country;
            } else {
            }
            if ($request->email) {
                if ($user->email != $request->email) {
                    // Define translations for subjects and content for each language
                    $translations = [
                        'English' => [
                            'subject' => 'Email Address Updated',
                            'content' => "You have just changed your email address  ($user->updated_at) on your Kaci account. If you did not perform this action, please contact our Account Support Team immediately on support@kaci.help.",
                        ],
                        'Fula' => [
                            'subject' => 'Adiresu Imẹlụ Nje: Tarihi ya Yi',
                            'content' => "Ko kuwa ka yi canja email address ka  ($user->updated_at) a cikin akauntin Kaci. Idan kake tunani cikin wannan aiki, don Allah yi tafiya zuwa Tufafi na Akaunti a wannan adireshin: support@kaci.help.",
                        ],
                        'Hausa' => [
                            'subject' => 'Adirẹsa Imẹlụ a Kasa Yi',
                            'content' => "Ku yi canje email adires  ($user->updated_at) a kan akauntin Kaci a cikin. Idan kun baiwa wani aiki wannan, don Allah ku tuntu da Taron Aikin Akaunti ta amfani a wannan adires: support@kaci.help.",
                        ],
                        'Spanish' => [
                            'subject' => 'Cambio de Dirección de Correo Electrónico',
                            'content' => "Acabas de cambiar tu dirección de correo electrónico  ($user->updated_at) en tu cuenta de Kaci. Si no realizaste esta acción, por favor contacta inmediatamente a nuestro Equipo de Soporte de Cuenta en support@kaci.help.",
                        ],
                        'Portuguese' => [
                            'subject' => 'Endereço de Email Alterado',
                            'content' => "Você acabou de alterar o seu endereço de email  ($user->updated_at) na sua conta Kaci. Se você não realizou esta ação, por favor entre em contato imediatamente com nossa Equipe de Suporte de Conta em support@kaci.help.",
                        ],
                        'Arabic' => [
                            'subject' => 'تغيير عنوان البريد الإلكتروني',
                            'content' => "لقد قمت للتو بتغيير عنوان بريدك الإلكتروني ({{$user->updated_at}}) في  على :إذا لم تقم بهذا الإجراء، يرجى الاتصال على الفور بفريق دعم الحساب لدينا على العنوان التالي: support@kaci.help."
                        ],
                        'Chinese' => [
                            'subject' => '电子邮件地址已更改',
                            'content' => "您刚刚在您的Kaci帐户中更改了您的电子邮件地址 ($user->updated_at).如果您没有执行此操作，请立即联系我们的帐户支持团队，发送电子邮件至support@kaci.help。",
                        ],
                        'Igbo' => [
                            'subject' => 'Adiresi Imelụ Nkeji Gụnyere',
                            'content' => "Ị na-achọ email adrees gị  ($user->updated_at) n'aka Kaci gị.Ọ bụrụ na ọ ga-enye ihe a na-enweta ya, biko kpọtụrụ gbasara anya anyanwụ a maka Okwu Support ndị Akaụntụ gị n’ime support@kaci.help.",
                        ],
                        'French' => [
                            'subject' => 'Adresse Email Modifiée',
                            'content' => "Vous venez de changer votre adresse e-mail ($user->updated_at) sur votre compte Kaci.Si vous n'avez pas effectué cette action, veuillez contacter immédiatement notre équipe de support de compte à l'adresse support@kaci.help.",
                        ],
                        'Yoruba' => [
                            'subject' => 'Adirẹsì Imẹlù Rẹtí Gége Ti Gbọdọ',
                            'content' => "O ti ṣe iṣẹ rẹ lati yipada adirẹsì imẹlù rẹ ($user->updated_at) ni akọkọ Kaci rẹ.Ti o bá ti ṣe iṣẹ yii, jọwọ tẹlẹ lọ pẹlu abojuto ti aye Akaunti wa ni support@kaci.help.",
                        ],
                    ];

                    // Check if the user's language is in the translations array
                    if (array_key_exists($user->language, $translations)) {
                        $translation = $translations[$user->language];
                        $subject = $translation['subject'];
                        $response = $translation['content'];
                    } else {
                        // Default to English if the language is not recognized
                        $translation = $translations['English'];
                        $subject = $translation['subject'];
                        $response = $translation['content'];
                    }

                    Mail::to($request->email)->send(new EmailChangedMail($user, $subject, $response));
                }
                $user->email = $request->email;
            } else {
            }
            if ($request->phone_number) {
                if ($user->phone_number != $request->phone_number) {
                    $translations = [
                        'English' => [
                            'subject' => 'Phone Number Updated',
                            'content' => "You have just changed your phone number  ($user->updated_at) on your Kaci account. If you did not perform this action, please contact our Account Support Team immediately on support@kaci.help.",
                        ],
                        'Fula' => [
                            'subject' => 'Adiresu Tarihin Wayar Hannu Ta Yi',
                            'content' => "Ko kuwa ka yi canja adiresu na hannu  ($user->updated_at) a cikin akauntin Kaci. Idan kake tunani cikin wannan aiki, don Allah yi tafiya zuwa Tufafi na Akaunti a wannan adireshin: support@kaci.help.",
                        ],
                        'Hausa' => [
                            'subject' => 'Adirẹsa Wayar Hannu Ta Yi',
                            'content' => "Ku yi canje adiresu na hannu  ($user->updated_at) a kan akauntin Kaci a cikin. Idan kun baiwa wani aiki wannan, don Allah ku tuntu da Taron Aikin Akaunti ta amfani a wannan adires: support@kaci.help.",
                        ],
                        'Spanish' => [
                            'subject' => 'Número de Teléfono Cambiado',
                            'content' => "Acabas de cambiar tu número de teléfono  ($user->updated_at) en tu cuenta de Kaci. Si no realizaste esta acción, por favor contacta inmediatamente a nuestro Equipo de Soporte de Cuenta en support@kaci.help.",
                        ],
                        'Portuguese' => [
                            'subject' => 'Número de Telefone Alterado',
                            'content' => "Você acabou de alterar o seu número de telefone  ($user->updated_at) na sua conta Kaci. Se você não realizou esta ação, por favor entre em contato imediatamente com nossa Equipe de Suporte de Conta em support@kaci.help.",
                        ],
                        'Arabic' => [
                            'subject' => 'رقم الهاتف تغييره',
                            'content' => "لقد قمت للتو بتغيير رقم هاتفك ({{$user->updated_at}}) في حسابك على إذا لم تقم بهذا الإجراء، يرجى الاتصال على الفور بفريق دعم الحساب لدينا على العنوان التالي: support@kaci.help."
                        ],
                        'Chinese' => [
                            'subject' => '电话号码已更改',
                            'content' => "您刚刚在您的Kaci帐户中更改了您的电话号码 ($user->updated_at)。如果您没有执行此操作，请立即联系我们的帐户支持团队，发送电子邮件至support@kaci.help.",
                        ],
                        'Igbo' => [
                            'subject' => 'Nọmbà Nọmbà Gbanwune',
                            'content' => "Ị na-achọ nọmbà nọmbà gbanwune gị  ($user->updated_at) n'aka Kaci gị.Ọ bụrụ na ọ ga-enye ihe a na-enweta ya, biko kpọtụrụ gbasara anya anyanwụ a maka Okwu Support ndị Akaụntụ gị n’ime support@kaci.help.",
                        ],
                        'French' => [
                            'subject' => 'Numéro de Téléphone Modifié',
                            'content' => "Vous venez de changer votre numéro de téléphone  ($user->updated_at) sur votre compte Kaci.Si vous n'avez pas effectué cette action, veuillez contacter immédiatement notre équipe de support de compte à l'adresse support@kaci.help.",
                        ],
                        'Yoruba' => [
                            'subject' => 'Nọmbà nọmbà tó Gba Gọdọ',
                            'content' => "O ti ṣe iṣẹ rẹ lati yipada nọmbà nọmbà rẹ  ($user->updated_at) ni akọkọ Kaci rẹ.Ti o bá ti ṣe iṣẹ yii, jọwọ tẹlẹ lọ pẹlu abojuto ti aye Akaunti wa ni support@kaci.help.",
                        ],
                    ];

                    // Check if the user's language is in the translations array
                    if (array_key_exists($user->language, $translations)) {
                        $translation = $translations[$user->language];
                        $subject = $translation['subject'];
                        $response = $translation['content'];
                    } else {
                        // Default to English if the language is not recognized
                        $translation = $translations['English'];
                        $subject = $translation['subject'];
                        $response = $translation['content'];
                    }

                    Mail::to($user->email)->send(new EmailChangedMail($user, $subject, $response));
                }
                $user->phone_number = $request->phone_number;
            } else {
            }
            if ($request->country) {
                $user->country = $request->country;
            } else {
            }
            $dependant = Dependant::where('user_id', '=', $id)->get();
            if ($dependant->count() >= 2) {
                $formattedSerial = str_pad($id, 9, '0', STR_PAD_LEFT);

                // Concatenate the module code, random code, and formatted serial number
                $referenceCode = '1' . $formattedSerial;

                $user->ksn =  $referenceCode;
            } else {
                
            }
            $user->save();
            $country = General_Countries::where('country_name', '=', $user->country)->first();
            $user['country_code'] = $country->country_code;
            $user['flag_code'] = $country->flag_code;
            $resident_country = Country::where('country', '=', $user->resident_country)->first();
            $user['resident_country_code'] = $resident_country->country_code;
            $user['resident_flag_code'] = $resident_country->flag_code;
            $success['data'] = $user;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $validator = Validator::make($request->all(), [
                'email' => 'unique:users,email',
                'phone_number' => 'unique:users,phone_number',
                // Add other validation rules here
            ]);

            $all_user = User::where('id', '!=', $id)->get();
            foreach ($all_user as $au) {
                if ($au->email === $request->email) {
                    $success['status'] = 400;
                    $success['message'] = $validator->errors();
                    return response()->json(['error' => $success]);
                }
                if ($au->phone_number === $request->phone_number) {
                    $success['status'] = 400;
                    $success['message'] = $validator->errors();
                    return response()->json(['error' => $success]);
                }
            }

            $dependant = Dependant::where('user_id', '=', $user->id)->get();
            if ($dependant->count() > 0) {
                foreach ($dependant as $d) {
                    if ($d->email === $request->email) {
                        $success['status'] = 400;
                        $success['message'] = 'This Email alredy use in Dependant';
                        return response()->json(['error' => $success]);
                    }
                    if ($d->phone_number === $request->phone_number) {
                        $success['status'] = 400;
                        $success['message'] = 'This Phone Number alredy use in Dependant';
                        return response()->json(['error' => $success]);
                    }
                }
            }
            if ($request->email) {
                $emailChanged = $request->email != $user->email;
            } else {
                $emailChanged = false;
            }
            if ($request->phone_number) {
                $phoneChanged = $request->phone_number != $user->phone_number;
            } else {
                $phoneChanged = false;
            }

            $otp = true;
            if ($emailChanged || $phoneChanged) {
                // Generate and send OTP
                $token = rand(1000, 9999);

                if ($emailChanged) {
                    // Send OTP via email based on user's language
                    if ($user->language === 'Arabic') {
                        Mail::to($request->email)->send(new ArabicOtp($user, $token));
                    } elseif ($user->language === 'Chinese') {
                        Mail::to($request->email)->send(new ChineseOtp($user, $token));
                    } elseif ($user->language === 'French') {
                        Mail::to($request->email)->send(new FrenchOtp($user, $token));
                    } elseif ($user->language === 'Fula') {
                        Mail::to($request->email)->send(new FulaOtp($user, $token));
                    } elseif ($user->language === 'Hausa') {
                        Mail::to($request->email)->send(new HausaOtp($user, $token));
                    } elseif ($user->language === 'Igbo') {
                        Mail::to($request->email)->send(new IgboOtp($user, $token));
                    } elseif ($user->language === 'Portuguese') {
                        Mail::to($request->email)->send(new PortugueseOtp($user, $token));
                    } elseif ($user->language === 'Spanish') {
                        Mail::to($request->email)->send(new SpanishOtp($user, $token));
                    } elseif ($user->language === 'Yoruba') {
                        Mail::to($request->email)->send(new YorubaOtp($user, $token));
                    } else {
                        Mail::to($request->email)->send(new EnglishOtp($user, $token));
                    }
                    $success['type'] = 'email';
                }

                if ($phoneChanged) {
                    $country = General_Countries::where('country_name', '=', $request->country)->first();
                    $country_code = $country->country_code;
                    $phoneNumber = $request->phone_number;
                    // Remove the "+" character from the country code
                    $countryCode = preg_replace('/[^0-9]/', '', $country_code);
                    $number = $countryCode . $phoneNumber;


                    try {

                        $curl = curl_init();
                        $data = array(
                            "api_key" => "TLsWe5NjzlDfhPVWCaPHbrnj9ggcUXlL81WYn15lhysyUjblgRQeSsLr9eAnY7",
                            "to" => $number,
                            "from" => "N-Alert",
                            "sms" => $token . " is your One Time Password (OTP) to reset your Kaci password. This code should not be shared and will expire after 15 minutes. ",
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
                        $destination = ' $number';
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
                    $success['type'] = 'phone_number';
                }
                if ($phoneChanged && $emailChanged) {
                    $success['type'] = 'both';
                }
                $success['status'] = 150;
                $success['token'] = $token;
                return response()->json(['success' => $success], $this->successStatus);
            }

            // If email and phone number are not changed, update other fields

            $input = $request->all();
            if ($request->hasfile('profile_image')) {


                $image = rand(00000000000, 35321231251231) . '.' . $request->file('profile_image')->extension();
                $path = $request->file('profile_image')->storeAs('profile', $image, ['disk' => 's3']);
                $url = Storage::disk('s3')->url('profile/' . $image);
                $user->profile_image = "https://storage.kacihelp.com/profile_image" . $path;
            } elseif ($request->filled('profile_image')) {
                $user->profile_image = $request->profile_image;
            }

            // dd($input['old_password'],$user->password);


            if ($request->firstname) {
                $user->firstname = $request->firstname;
            } else {
            }
            if ($request->lastname) {
                $user->lastname = $request->lastname;
            } else {
            }
            if ($request->birth_date) {
                $user->birth_date = $request->birth_date;
            } else {
                $success['status'] = 400;
                $success['message'] = 'Date of Birth Required';
                return response()->json(['error' => $success]);
            }
            if ($request->location) {
                $user->location = $request->location;
            } else {
                $success['status'] = 400;
                $success['message'] = 'Location Required';
                return response()->json(['error' => $success]);
            }
            if ($request->address) {
                $user->address = $request->address;
            } else {
                $success['status'] = 400;
                $success['message'] = 'Address Required';
                return response()->json(['error' => $success]);
            }
            if ($request->gender) {
                $user->gender = $request->gender;
            } else {
                $success['status'] = 400;
                $success['message'] = 'Gender Required';
                return response()->json(['error' => $success]);
            }
            if ($request->blood_group) {
                $user->blood_group = $request->blood_group;
            }
            if ($request->resident_country) {
                $user->resident_country = $request->resident_country;
            } else {
            }
            if ($request->email) {
                $user->email = $input['email'];
            } else {
            }
            if ($request->phone_number) {
                $user->phone_number = $input['phone_number'];
            } else {
            }
            if ($request->country) {
                $user->country = $request->country;
            } else {
            }
            $dependant = Dependant::where('user_id', '=', $id)->get();
            if ($dependant->count() >= 2) {
                $formattedSerial = str_pad($id, 9, '0', STR_PAD_LEFT);

                // Concatenate the module code, random code, and formatted serial number
                $referenceCode = '1' . $formattedSerial;

                $user->ksn =  $referenceCode;
            } else {
            }


            $user->save();
            $country = General_Countries::where('country_name', '=', $user->country)->first();
            $user['country_code'] = $country->country_code;
            $user['flag_code'] = $country->flag_code;
            $resident_country = Country::where('country', '=', $user->resident_country)->first();
            $user['resident_country_code'] = $resident_country->country_code;
            $user['resident_flag_code'] = $resident_country->flag_code;
            $success['data'] = $user;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        }
    }


    public function show_info_bank($id)
    {
        $bank = Info_Bank::find($id);
        if ($bank) {
            $code = Country::where('country', '=', $bank->country)->first();
            if ($code) {
                $bank['flag_code'] = $code->flag_code;
            }

            $success['data'] = $bank;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['Message'] = 'Not found';
            $success['status'] = 400;
            return response()->json(['error' => $success]);
        }
    }



    public function info_bank()
    {
        $bank = Info_Bank::all();
        $data = [];
        foreach ($bank as $b) {
            $code = Country::where('country', '=', $b->country)->first();
            if ($code) {
                $b['flag_code'] = $code->flag_code;
                $data[] = $b;
            }
        }
        $success['data'] = $data;
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }





    public function show_help_book($id)
    {
        $help = Help_Book::find($id);
        if ($help) {
            $success['data'] = $help;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['message'] = 'not found';
            $success['status'] = 400;
            return response()->json(['error' => $success]);
        }
    }

    public function help_book()
    {
        $bank = Help_Book::all();
        $data = [];
        foreach ($bank as $b) {
            $help = Help_Book::find($b->id);
            if ($help) {
                $b['website'] = $help->website_email;
            }
            $data[] = $b;
        }
        $success['data'] = $data;
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function help_book_country(Request $request)
    {
        $help = Help_Book::where('country', '=', $request->resident_country)->where('status', '=', 'Active')->get();
        $data = [];
        if ($help->count() > 0) {
            foreach ($help as $h) {
                $h['images'] = json_decode($h->images);
                $data[] = $h;
            }
            $success['data'] = $data;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['message'] = 'not found';
            $success['status'] = 400;
            return response()->json(['error' => $success]);
        }
    }


    public function show_country($id)
    {
        $help = Country::find($id);
        if ($help) {
            $success['data'] = $help;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['message'] = 'not found';
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        }
    }


    public function country()
    {
        $bank = Country::where('status', '=', 'Active')->get();
    
        $success['data'] = $bank;
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }





    public function show_location($id)
    {
        $help = Location::find($id);
        if ($help) {
            $success['data'] = $help;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['message'] = 'not found';
            $success['status'] = 400;
            return response()->json(['error' => $success]);
        }
    }



    public function location()
    {
        $bank = Location::all();
        $success['data'] = $bank;
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function resident_location(Request $request)
    {
        if ($request->resident_country) {
            $location = Location::where('country', '=', $request->resident_country)->where('status', '=', 'Active')->get();
            if ($location->count() > 0) {
                $success['data'] = $location;
                $success['status'] = 200;
                return response()->json(['success' => $success], $this->successStatus);
            } else {
                $location = Location::all();
                $success['data'] = $location;
                $success['status'] = 200;
                return response()->json(['success' => $success], $this->successStatus);
            }
        } else {
            $success['message'] = 'Resident Country Required';
            $success['status'] = 400;
            return response()->json(['error' => $success]);
        }
    }


    public function show_ambulance_service($id)
    {
        $help = Ambulance_Service::find($id);
        if ($help) {
            $success['data'] = $help;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['message'] = 'not found';
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        }
    }

    public function ambulance_service()
    {
        $bank = Ambulance_Service::all();
        $success['data'] = $bank;
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }



    public function show_agencies($id)
    {
        $help = Agencies::find($id);
        if ($help) {
            $success['data'] = $help;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['message'] = 'not found';
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        }
    }

    public function agencies()
    {
        $bank = Agencies::all();
        $success['data'] = $bank;
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function generateReferenceCode($moduleCode, $serialNumber)
    {
        // Generate a random 4-letter code using uppercase letters


        // Format the serial number with leading zeros up to 10 digits
        $formattedSerial = str_pad($serialNumber, 10, '0', STR_PAD_LEFT);

        // Concatenate the module code, random code, and formatted serial number
        $referenceCode = $moduleCode . $formattedSerial;

        return $referenceCode;
    }


    public function store_feedback(Request $request, $id)
    {

        $user = User::find($id);

        $found = Feedback::where('user_id', '=', $user->id)->latest()->first();
        if ($found) {
            if ($found->status === 'Resolved' || 'Deleted') {
                $validator = Validator::make($request->all(), [
                    'text' => 'required',

                ]);
                if ($validator->fails()) {
                    return response()->json(['error' => $validator->errors()], 401);
                }
                if ($request->images) {
                    $uploadedFiles = [];

                    foreach ($request->file('images') as $file) {
                        $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

                        $extension = $file->extension(); // Get the file extension

                        // Determine the type of the file based on its extension
                        if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                            $uploadedFile->type = 'image';
                        } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
                            $uploadedFile->type = 'video';
                        } elseif (in_array($extension, ['mp3', 'ogg'])) {
                            $uploadedFile->type = 'audio';
                        } elseif (in_array($extension, ['pptx', 'ppt'])) {
                            $uploadedFile->type = 'ppt';
                        } elseif (in_array($extension, ['docx', 'doc'])) {
                            $uploadedFile->type = 'docx';
                        } elseif (in_array($extension, ['pdf'])) {
                            $uploadedFile->type = 'pdf';
                        } else {
                            $uploadedFile->type = 'unknown';
                        }
                        $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
                        $path = $file->storeAs('feedback_images', $uploadedImage, ['disk' => 's3']);
                        $uploadedFile->url = "https://storage.kacihelp.com/" . $path;
                        // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
                        $uploadedFiles[] = $uploadedFile;
                    }

                    $input['image'] = json_encode($uploadedFiles);
                }
                $input['text'] = $request->text;
                $input['user_id'] = $user->id;
                $input['name'] = $user->firstname;
                $input['email'] = $user->email;
                $input['phone_number'] = $user->phone_number;
                $input['device'] = $user->device_name;
                $input['country'] = $user->country;

                $model = Feedback::latest()->first(); // Replace 1 with the actual ID of your record

                if ($model) {

                    // Extract the numeric part of the code and increment it by 1
                    $numericPart = (int) substr($model->reference_code, 4) + 1;

                    // Combine it with the non-numeric part and update the code field
                    $model->reference_code = substr($model->code, 0, 4) . str_pad($numericPart, 10, '0', STR_PAD_LEFT);
                    $ref_code = $model->reference_code;
                    $input['reference_code'] = 'KHFK' . $ref_code;
                } else {
                    $input['reference_code'] = 'KHFK' . '0000000001';
                }

                try {
                    $feedback = Feedback::create($input);
                    if ($user->language === 'Arabic') {
                        Mail::to($user->email)->send(new ArabicFeedback($feedback, $user));
                    } elseif ($user->language === 'Chinese') {
                        Mail::to($user->email)->send(new ChineseFeedback($feedback, $user));
                    } elseif ($user->language === 'French') {
                        Mail::to($user->email)->send(new FrenchFeedback($feedback, $user));
                    } elseif ($user->language === 'Fula') {
                        Mail::to($user->email)->send(new FulaFeedback($feedback, $user));
                    } elseif ($user->language === 'Hausa') {
                        Mail::to($user->email)->send(new HausaFeedback($feedback, $user));
                    } elseif ($user->language === 'Igbo') {
                        Mail::to($user->email)->send(new IgboFeedback($feedback, $user));
                    } elseif ($user->language === 'Portuguese') {
                        Mail::to($user->email)->send(new PortugueseFeedback($feedback, $user));
                    } elseif ($user->language === 'Spanish') {
                        Mail::to($user->email)->send(new SpanishFeedback($feedback, $user));
                    } elseif ($user->language === 'Yoruba') {
                        Mail::to($user->email)->send(new YorubaFeedback($feedback, $user));
                    } else {
                        Mail::to($user->email)->send(new FeedbackMail($feedback, $user));
                    }
                } catch (TransportException $e) {

                    $success['data'] =  $feedback;
                    $success['status'] = 200;
                    $success['message'] = 'Created successfully';
                    return response()->json(['success' => $success], $this->successStatus);
                }
                $activity = Activity::create([
                    'user_id' => $user->id,
                    'type_id' => $feedback->id,
                    'type' => 'feedback',
                ]);
                if ($user->device_name === 'Android') {
                    $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                    $user['new_id'] = $new_id;
                } elseif ($user->device_name === 'IOS') {
                    $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                    $user['new_id'] = $new_id;
                }

                $sub = Sub_Admin::all();
                if ($sub->count() > 0) {
                    foreach ($sub as $a) {

                        $admin_notification = Admin_Notification::create([
                            'user_id' => $user->id,
                            'u_id' => $user['new_id'],
                            'notification' => 'New Feedback Created ',
                            'name' => $user->firstname,
                            'status' => 'Unread',
                            'sub_admin_id' => $a->id
                        ]);
                    }
                }

                $auto_reply = Auto_Reply::where('type', '=', 'feedback')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();

                if ($auto_reply) {
                    $response = $auto_reply->description;
                    $save_reply = Response::create(
                        [
                            'user_id' => $user->id,
                            'type_id' => $feedback->storeid,
                            'type' => 'feedback',
                            'response' => $response,
                            'admin_name' => 'Admin',
                            'status' => 'unseen'
                        ]
                    );
                }



                $image = json_decode($feedback->image);

                $adminemail = Admin_Email::find(1);
                try {
                    if ($adminemail) {
                        $email[] = $adminemail->email;

                        foreach ($email as $key => $value) {
                            $emailAddress = str_replace(['[', ']', '\\', '\"'], '', $value); // Remove unwanted characters
                            $emailAddress = explode(',', $emailAddress); // Convert the string to an array

                            foreach ($emailAddress as $email) {
                                $email = trim($email, "\""); // Remove double quotes from the email address
                                $dependentname = 'Admin';


                                Mail::to($email)->send(new FDAdminMail($user, $dependentname, $feedback, $image));

                                $mail[] = $email;
                            }
                        }
                    }
                } catch (TransportException $e) {

                    $success['data'] =  $feedback;
                    $success['status'] = 200;
                    $success['message'] = 'Created successfully';
                    return response()->json(['success' => $success], $this->successStatus);
                }
                $success['data'] =  $feedback;
                $success['status'] = 200;
                $success['message'] = 'Created successfully';
                return response()->json(['success' => $success], $this->successStatus);
            } else {

                $success['status'] = 400;
                $success['message'] = 'Your previous Request in pending';
                return response()->json(['error' => $success]);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'text' => 'required',

            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }
            if ($request->images) {
                $uploadedFiles = [];

                foreach ($request->file('images') as $file) {
                    $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

                    $extension = $file->extension(); // Get the file extension

                    // Determine the type of the file based on its extension
                    if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                        $uploadedFile->type = 'image';
                    } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
                        $uploadedFile->type = 'video';
                    } elseif (in_array($extension, ['mp3', 'ogg'])) {
                        $uploadedFile->type = 'audio';
                    } elseif (in_array($extension, ['pptx'])) {
                        $uploadedFile->type = 'ppt';
                    } elseif (in_array($extension, ['docx'])) {
                        $uploadedFile->type = 'docx';
                    } elseif (in_array($extension, ['pdf'])) {
                        $uploadedFile->type = 'pdf';
                    } else {
                        // You can handle other file types if needed
                        $uploadedFile->type = 'unknown';
                    }
                    $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
                    $path = $file->storeAs('feedback_images', $uploadedImage, ['disk' => 's3']);
                    $uploadedFile->url = "https://storage.kacihelp.com/feedback_images/" . $path;
                    // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
                    $uploadedFiles[] = $uploadedFile;
                }

                $input['image'] = json_encode($uploadedFiles);
            }
            $input['text'] = $request->text;
            $input['user_id'] = $user->id;
            $input['name'] = $user->firstname;
            $input['email'] = $user->email;
            $input['phone_number'] = $user->phone_number;
            $input['device'] = $user->device_name;
            $input['country'] = $user->country;
            $model = Feedback::latest()->first(); // Replace 1 with the actual ID of your record

            if ($model) {

                // Extract the numeric part of the code and increment it by 1
                $numericPart = (int) substr($model->reference_code, 4) + 1;

                // Combine it with the non-numeric part and update the code field
                $model->reference_code = substr($model->code, 0, 4) . str_pad($numericPart, 10, '0', STR_PAD_LEFT);
                $ref_code = $model->reference_code;
                $input['reference_code'] = 'KHFK' . $ref_code;
            } else {
                $input['reference_code'] = 'KHFK' . '0000000001';
            }
            try {
                $feedback = Feedback::create($input);
                if ($user->language === 'Arabic') {
                    Mail::to($user->email)->send(new ArabicFeedback($feedback, $user));
                } elseif ($user->language === 'Chinese') {
                    Mail::to($user->email)->send(new ChineseFeedback($feedback, $user));
                } elseif ($user->language === 'French') {
                    Mail::to($user->email)->send(new FrenchFeedback($feedback, $user));
                } elseif ($user->language === 'Fula') {
                    Mail::to($user->email)->send(new FulaFeedback($feedback, $user));
                } elseif ($user->language === 'Hausa') {
                    Mail::to($user->email)->send(new HausaFeedback($feedback, $user));
                } elseif ($user->language === 'Igbo') {
                    Mail::to($user->email)->send(new IgboFeedback($feedback, $user));
                } elseif ($user->language === 'Portuguese') {
                    Mail::to($user->email)->send(new PortugueseFeedback($feedback, $user));
                } elseif ($user->language === 'Spanish') {
                    Mail::to($user->email)->send(new SpanishFeedback($feedback, $user));
                } elseif ($user->language === 'Yoruba') {
                    Mail::to($user->email)->send(new YorubaFeedback($feedback, $user));
                } else {
                    Mail::to($user->email)->send(new FeedbackMail($feedback, $user));
                }
            } catch (TransportException $e) {

                $success['data'] =  $feedback;
                $success['status'] = 200;
                $success['message'] = 'Created successfully';
                return response()->json(['success' => $success], $this->successStatus);
            }
            $activity = Activity::create([
                'user_id' => $user->id,
                'type_id' => $feedback->id,
                'type' => 'feedback',
            ]);
            if ($user->device_name === 'Android') {
                $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                $user['new_id'] = $new_id;
            } elseif ($user->device_name === 'IOS') {
                $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                $user['new_id'] = $new_id;
            }

            $sub = Sub_Admin::all();
            if ($sub->count() > 0) {
                foreach ($sub as $a) {

                    $admin_notification = Admin_Notification::create([
                        'user_id' => $user->id,
                        'u_id' => $user['new_id'],
                        'notification' => 'New Feedback Created ',
                        'name' => $user->firstname,
                        'status' => 'Unread',
                        'sub_admin_id' => $a->id
                    ]);
                }
            }

            $auto_reply = Auto_Reply::where('type', '=', 'feedback')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();

            if ($auto_reply) {
                $response = $auto_reply->description;
                $save_reply = Response::create(
                    [
                        'user_id' => $user->id,
                        'type_id' => $feedback->id,
                        'type' => 'feedback',
                        'response' => $response,
                        'admin_name' => 'Admin',
                        'status' => 'unseen'
                    ]
                );
            }



            $image = json_decode($feedback->image);

            $adminemail = Admin_Email::find(1);
            try {
                if ($adminemail) {
                    $email[] = $adminemail->email;

                    foreach ($email as $key => $value) {
                        $emailAddress = str_replace(['[', ']', '\\', '\"'], '', $value); // Remove unwanted characters
                        $emailAddress = explode(',', $emailAddress); // Convert the string to an array

                        foreach ($emailAddress as $email) {
                            $email = trim($email, "\""); // Remove double quotes from the email address
                            $dependentname = 'Admin';


                            Mail::to($email)->send(new FDAdminMail($user, $dependentname, $feedback, $image));

                            $mail[] = $email;
                        }
                    }
                }
            } catch (TransportException $e) {

                $success['data'] =  $feedback;
                $success['status'] = 200;
                $success['message'] = 'Created successfully';
                return response()->json(['success' => $success], $this->successStatus);
            }
            $success['data'] =  $feedback;
            $success['status'] = 200;
            $success['message'] = 'Created successfully';
            return response()->json(['success' => $success], $this->successStatus);
        }
    }
    public function isProfileComplete()
    {
        // Define the required fields for a complete profile
        $requiredFields = ['birth_date', 'blood_group', 'address', 'gender', 'language', 'profile_image', 'location'];

        // Check if any required field is empty
        foreach ($requiredFields as $field) {
            if (empty($this->$field)) {
                return false;
            }
        }

        return true;
    }
    public function store_dependant(Request $request, $id)
    {
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'relation_type' => 'required',
            'phone_number' => 'required',
            'country' => 'required',
        ]);
        if ($validator->fails()) {
            $success['status'] = 400;
            $success['message'] = $validator->errors();
            return response()->json(['error' => $success]);
        }
        $input = $request->all();

        $dependant = Dependant::where('user_id', '=', $id)->get();
        if ($dependant->count() > 0) {
            foreach ($dependant as $d) {
                if ($d->email === $input['email'] || $user->email === $input['email']) {
                    $success['status'] = 400;
                    $success['message'] = 'This Email already added.';
                    return response()->json(['error' => $success]);
                } else if ($d->phone_number === $input['phone_number'] || $user->phone_number === $input['phone_number']) {
                    $success['status'] = 400;
                    $success['message'] = 'This Phone number already added.';
                    return response()->json(['error' => $success]);
                }
            }
        }

        $input['user_id'] = $user->id;
        $dependent = Dependant::create($input);
        $dependant_user = Dependant::where('user_id', '=', $id)->get();
        if ($dependant_user->count() >= 2) {


            $requiredFields = ['birth_date', 'address', 'gender', 'profile_image', 'location'];
            $isProfileComplete = true;

            // Check if any required field is empty
            foreach ($requiredFields as $field) {
                if (empty($user->$field)) {
                    $isProfileComplete = false;
                    break;
                }
            }

            if ($isProfileComplete) {
                $formattedSerial = str_pad($id, 9, '0', STR_PAD_LEFT);

                // Concatenate the module code, random code, and formatted serial number
                $referenceCode = '1' . $formattedSerial;

                $user->ksn =  $referenceCode;
                $dependent['ksn'] = $referenceCode;
                $user->save();
            } else {
                $success['message'] = 'Complete Profile';
            }
        } else {
        }
        $country = General_Countries::where('country_name', '=', $input['country'])->first();
        $dependant['country_code'] = $country->country_code;
        $dependent['flag_code'] = $country->flag_code;
        $success['data'] = $dependent;
        $success['status'] = 200;
        // $success['message']='Created successfully';
        return response()->json(['success' => $success], $this->successStatus);
    }


    public function show_dependant($id)
    {
        $user = Dependant::where('user_id', '=', $id)->get();
        $data = [];
        if ($user->count() > 0) {
            foreach ($user as $u) {
                $country = General_Countries::where('country_name', '=', $u->country)->first();

                if ($country) {
                    $u['country_code'] = $country->country_code;
                    $u['flag_code'] = $country->flag_code;
                    $data[] = $u;
                } else {
                    $data[] = $u;
                }
            }
            $success['data'] = $data;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {

            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }

    public function dependant_delete($id)
    {
        $dependant = Dependant::find($id);
        if ($dependant) {
            $dependant->delete();
            $success['status'] = 200;
            $success['message'] = 'Delete Successfully';
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }

    public function medication_delete($id)
    {
        $dependant = Medication::find($id);
        if ($dependant) {
            $dependant->delete();
            $success['status'] = 200;
            $success['message'] = 'Delete Successfully';
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }

    public function dependant()
    {
        $dependant = Dependant::all();
        $success['data'] = $dependant;
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }




    public function store_medication(Request $request, $id)
    {
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'dosage' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['user_id'] = $user->id;
        $dependent = Medication::create($input);
        $success['data'] = $dependent;
        $success['status'] = 200;
        $success['message'] = 'Created successfully';
        return response()->json(['success' => $success], $this->successStatus);
    }



    public function show_medication($id)
    {
        $user = Medication::where('user_id', '=', $id)->get();
        if ($user->count() > 0) {
            $success['data'] = $user;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {

            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }


    public function medication()
    {
        $dependant = Medication::all();
        $success['data'] = $dependant;
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }


    // public function store_ambulance(Request $request, $id)
    // {
    //     $user = User::find($id);

    //     $now_date = Carbon::now();
    //     $past_seven_days = $now_date->subDays(7)->toDateString();
    //     $latest = Ambulance::where('user_id', '=', $user->id)->whereDate('created_at', '>=', now()->subDays(7))->count();
    //     $module_request = Module_Request::find(1);
    //     $ambulane_req = $module_request->ambulance;

    //     if ($ambulane_req > $latest) {
    //         $validator = Validator::make($request->all(), [
    //             'ambulance_service' => 'required',
    //             'people_involved' => 'required',
    //             'incidence_nature' => 'required',
    //             'previous_hospital' => 'required',
    //             'medication' => 'required',
    //             'location' => 'required',
    //             'address' => 'required',

    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json(['error' => $validator->errors()], 401);
    //         }


    //         $input = $request->all();

    //         if ($user->ksn != null) {
    //             if ($request->images) {
    //                 $uploadedFiles = [];

    //                 foreach ($request->file('images') as $file) {
    //                     $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

    //                     $extension = $file->extension(); // Get the file extension

    //                     // Determine the type of the file based on its extension
    //                     if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
    //                         $uploadedFile->type = 'image';
    //                     } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
    //                         $uploadedFile->type = 'video';
    //                     } elseif (in_array($extension, ['mp3', 'ogg'])) {
    //                         $uploadedFile->type = 'audio';
    //                     } elseif (in_array($extension, ['pptx', 'ppt'])) {
    //                         $uploadedFile->type = 'ppt';
    //                     } elseif (in_array($extension, ['docx', 'doc'])) {
    //                         $uploadedFile->type = 'docx';
    //                     } elseif (in_array($extension, ['pdf'])) {
    //                         $uploadedFile->type = 'pdf';
    //                     } else {
    //                         // You can handle other file types if needed
    //                         $uploadedFile->type = 'unknown';
    //                     }
    //                     $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
    //                     $path = $file->storeAs('ambulance_images', $uploadedImage, ['disk' => 's3']);
    //                     $uploadedFile->url = "https://storage.kacihelp.com/" . $path;
    //                     // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
    //                     $uploadedFiles[] = $uploadedFile;
    //                 }

    //                 $input['images'] = json_encode($uploadedFiles);
    //             }
    //             $map = '';
    //             if ($request->map) {

    //                 $coordinatesString = $request->map;
    //                 $coordinatesArray = json_decode($coordinatesString, true);

    //                 // Check if $coordinatesArray is an array before accessing the 'latitude'
    //                 if (is_array($coordinatesArray) && isset($coordinatesArray['latitude'])) {
    //                     $latitude = $coordinatesArray['latitude'];
    //                 } else {
    //                     $latitude = null;
    //                 }
    //                 if (is_array($coordinatesArray) && isset($coordinatesArray['longitude'])) {
    //                     $longitude = $coordinatesArray['longitude'];
    //                 } else {
    //                     $longitude = null;
    //                 }

    //                 if ($latitude != null && $longitude != null) {
    //                     $embed_link = "https://www.google.com/maps/search/?api=1&query={latitude}%2C{longitude}";

    //                     // Replace the placeholders with actual values
    //                     $final_link = str_replace(
    //                         ['{latitude}', '{longitude}'],
    //                         [$latitude, $longitude],
    //                         $embed_link
    //                     );
    //                     $map = $final_link;
    //                 }
    //                 // Ensure the 'latitude' key is present in the 'coordinate' JSON object
    //                 $input['map'] = json_encode($request->map);
    //             } else {
    //                 $latitude = null;
    //                 $longitude = null;
    //             }
    //             $input['ksn'] = $user->ksn;
    //             $input['user_id'] = $user->id;
    //             $input['name'] = $user->firstname;
    //             $input['email'] = $user->email;
    //             $input['phone_number'] = $user->phone_number;
    //             $input['device'] = $user->device_name;



    //             $country = Location::where('location', '=', $input['location'])->first();
    //             $input['country'] = $country->country;
    //             $model = Ambulance::latest()->first(); // Replace 1 with the actual ID of your record

    //             if ($model) {

    //                 // Extract the numeric part of the code and increment it by 1
    //                 $numericPart = (int) substr($model->reference_code, 4) + 1;

    //                 // Combine it with the non-numeric part and update the code field
    //                 $model->reference_code = substr($model->code, 0, 4) . str_pad($numericPart, 10, '0', STR_PAD_LEFT);
    //                 $ref_code = $model->reference_code;
    //                 $input['reference_code'] = 'KHAE' . $ref_code;
    //             } else {
    //                 $input['reference_code'] = 'KHAE' . '0000000001';
    //             }

    //             $ambulance = Ambulance::create($input);
    //             $activity = Activity::create([
    //                 'user_id' => $user->id,
    //                 'type_id' => $ambulance->id,
    //                 'type' => 'ambulance',
    //             ]);
    //             if ($user->device_name === 'Android') {
    //                 $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
    //                 $user['new_id'] = $new_id;
    //             } elseif ($user->device_name === 'IOS') {
    //                 $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
    //                 $user['new_id'] = $new_id;
    //             }

    //             $sub = Sub_Admin::all();
    //             if ($sub->count() > 0) {
    //                 foreach ($sub as $a) {
    //                     $admin_notification = Admin_Notification::create([
    //                         'user_id' => $user->id,
    //                         'u_id' => $user['new_id'],
    //                         'notification' => 'New Ambulance Request',
    //                         'name' => $user->firstname,
    //                         'status' => 'Unread',
    //                         'sub_admin_id' => $a->id
    //                     ]);
    //                 }
    //             }


    //             $auto_reply = Auto_Reply::where('type', '=', 'ambulance')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();
    //             if ($auto_reply) {
    //                 $response = $auto_reply->description;
    //                 $save_reply = Response::create(
    //                     [
    //                         'user_id' => $user->id,
    //                         'type_id' => $ambulance->id,
    //                         'type' => 'ambulance',
    //                         'response' => $response,
    //                         'admin_name' => 'Admin',
    //                         'status' => 'unseen'
    //                     ]
    //                 );
    //             }

    //             $medication = Medication::where('user_id', '=', $user->id)->get();



    //             $service = Ambulance_Service::where('title', '=', $input['ambulance_service'])->first();
                
    //             $agency = Agencies::where('title', '=', $service->title)->first();
    //             $sub_account = Sub_Account::where('agency_id', '=', $agency->id)->first();
                
    //              $admin_notification = Agency_Notification::create([
    //                         'user_id' => $user->id,
    //                         'u_id' => $user['new_id'],
    //                         'notification' => 'New Ambulance Request',
    //                         'name' => $user->firstname,
    //                         'status' => 'Unread',
    //                         'agency_id' => $sub_account->id
    //                     ]);
                
                
    //             $image = json_decode($ambulance->images);
    //             if ($service) {
    //                 $dependentname = $service->title;

    //                 if ($service->head_email1) {
                        
    //                     Mail::to($service->head_email1)->send(new AmbulanceMail($user, $map, $dependentname, $ambulance, $image, $medication));
                        
    //                 }
    //                 if ($service->head_email2) {
                        
    //                     Mail::to($service->head_email2)->send(new AmbulanceMail($user, $map, $dependentname, $ambulance, $image, $medication));
                        
    //                 }
    //                 $location = json_decode($service->location);
    //                 $count = 0;
    //                 $allLocationsEmailSent = false;
    //                 foreach ($location as $l) {
    //                     if ($l->location == $input['location']) {
    //                         Mail::to($l->email)->send(new AmbulanceMail($user, $map, $dependentname, $ambulance, $image, $medication));
    //                     } else if ($l->location == 'All Locations' && !$allLocationsEmailSent) {
    //                         Mail::to($l->email)->send(new AmbulanceMail($user, $map, $dependentname, $ambulance, $image, $medication));
    //                         $allLocationsEmailSent = true;
    //                     }
    //                 }
    //             }
    //             $adminemail = Admin_Email::find(1);
    //             if ($adminemail) {
    //                 $email[] = $adminemail->email;

    //                 foreach ($email as $key => $value) {
    //                     $emailAddress = str_replace(['[', ']', '\\', '\"'], '', $value); // Remove unwanted characters
    //                     $emailAddress = explode(',', $emailAddress); // Convert the string to an array

    //                     foreach ($emailAddress as $email) {
    //                         $email = trim($email, "\""); // Remove double quotes from the email address
    //                         $dependentname = 'Admin';

    //                         $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
    //                         $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ' ' . ')';

    //                         Mail::to($email)->send(new AmbulanceMail($user, $map, $dependentname, $ambulance, $image, $medication));

    //                         $mail[] = $email;
    //                     }
    //                 }
    //             }

    //             $success['data'] = $ambulance;
    //             $success['status'] = 200;
    //             return response()->json(['success' => $success], $this->successStatus);
    //         } else {
    //             $success['status'] = 400;
    //             $success['message'] = 'Complete your Profile or Add Atleast 2 dependant';
    //             return response()->json(['error' => $success]);
    //         }
            
            
    //     } else {
            
            
    //         $used_code = Used_Code::where('user_id', '=', $user->id)->where('status', '=', 'Active')->first();
    //         if ($used_code) {
    //             $validator = Validator::make($request->all(), [
    //                 'ambulance_service' => 'required',
    //                 'people_involved' => 'required',
    //                 'incidence_nature' => 'required',
    //                 'previous_hospital' => 'required',
    //                 'medication' => 'required',
    //                 // Allow image, video, doc, ppt, and pdf extensions
    //                 'location' => 'required',
    //                 'address' => 'required',

    //             ]);

    //             if ($validator->fails()) {
    //                 return response()->json(['error' => $validator->errors()], 401);
    //             }


    //             $input = $request->all();

    //             if ($user->ksn != null) {
    //                 if ($request->images) {
    //                     $uploadedFiles = [];

    //                     foreach ($request->file('images') as $file) {
    //                         $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

    //                         $extension = $file->extension(); // Get the file extension

    //                         // Determine the type of the file based on its extension
    //                         if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
    //                             $uploadedFile->type = 'image';
    //                         } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
    //                             $uploadedFile->type = 'video';
    //                         } elseif (in_array($extension, ['mp3', 'ogg'])) {
    //                             $uploadedFile->type = 'audio';
    //                         } elseif (in_array($extension, ['pptx'])) {
    //                             $uploadedFile->type = 'ppt';
    //                         } elseif (in_array($extension, ['docx'])) {
    //                             $uploadedFile->type = 'docx';
    //                         } elseif (in_array($extension, ['pdf'])) {
    //                             $uploadedFile->type = 'pdf';
    //                         } else {
    //                             // You can handle other file types if needed
    //                             $uploadedFile->type = 'unknown';
    //                         }
    //                         $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
    //                         $path = $file->storeAs('ambulance_images', $uploadedImage, ['disk' => 's3']);
    //                         $uploadedFile->url = "https://storage.kacihelp.com/" . $path;
    //                         // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
    //                         $uploadedFiles[] = $uploadedFile;
    //                     }

    //                     $input['images'] = json_encode($uploadedFiles);
    //                 }
    //                 $map = '';
    //                 if ($request->map) {

    //                     $coordinatesString = $request->map;
    //                     $coordinatesArray = json_decode($coordinatesString, true);

    //                     // Check if $coordinatesArray is an array before accessing the 'latitude'
    //                     if (is_array($coordinatesArray) && isset($coordinatesArray['latitude'])) {
    //                         $latitude = $coordinatesArray['latitude'];
    //                     } else {
    //                         $latitude = null;
    //                     }
    //                     if (is_array($coordinatesArray) && isset($coordinatesArray['longitude'])) {
    //                         $longitude = $coordinatesArray['longitude'];
    //                     } else {
    //                         $longitude = null;
    //                     }

    //                     if ($latitude != null && $longitude != null) {
    //                         $embed_link = "https://www.google.com/maps/search/?api=1&query={latitude}%2C{longitude}";

    //                         // Replace the placeholders with actual values
    //                         $final_link = str_replace(
    //                             ['{latitude}', '{longitude}'],
    //                             [$latitude, $longitude],
    //                             $embed_link
    //                         );
    //                         $map = $final_link;
    //                     }
    //                     // Ensure the 'latitude' key is present in the 'coordinate' JSON object
    //                     $input['map'] = json_encode($request->map);
    //                 } else {
    //                     $latitude = null;
    //                     $longitude = null;
    //                 }
    //                 $input['ksn'] = $user->ksn;
    //                 $input['user_id'] = $user->id;
    //                 $input['name'] = $user->firstname;
    //                 $input['email'] = $user->email;
    //                 $input['phone_number'] = $user->phone_number;
    //                 $input['device'] = $user->device_name;



    //                 $country = Location::where('location', '=', $input['location'])->first();
    //                 $input['country'] = $country->country;
    //                 $model = Ambulance::latest()->first(); // Replace 1 with the actual ID of your record

    //                 if ($model) {

    //                     // Extract the numeric part of the code and increment it by 1
    //                     $numericPart = (int) substr($model->reference_code, 4) + 1;

    //                     // Combine it with the non-numeric part and update the code field
    //                     $model->reference_code = substr($model->code, 0, 4) . str_pad($numericPart, 10, '0', STR_PAD_LEFT);
    //                     $ref_code = $model->reference_code;
    //                     $input['reference_code'] = 'KHAE' . $ref_code;
    //                 } else {
    //                     $input['reference_code'] = 'KHAE' . '0000000001';
    //                 }

    //                 $ambulance = Ambulance::create($input);
    //                 $activity = Activity::create([
    //                     'user_id' => $user->id,
    //                     'type_id' => $ambulance->id,
    //                     'type' => 'ambulance',
    //                 ]);
    //                 if ($user->device_name === 'Android') {
    //                     $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
    //                     $user['new_id'] = $new_id;
    //                 } elseif ($user->device_name === 'IOS') {
    //                     $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
    //                     $user['new_id'] = $new_id;
    //                 }

    //                 $sub = Sub_Admin::all();
    //                 if ($sub->count() > 0) {
    //                     foreach ($sub as $a) {

    //                         $admin_notification = Admin_Notification::create([
    //                             'user_id' => $user->id,
    //                             'u_id' => $user['new_id'],
    //                             'notification' => 'New Ambulance Request',
    //                             'name' => $user->firstname,
    //                             'status' => 'Unread',
    //                             'sub_admin_id' => $a->id
    //                         ]);
    //                     }
    //                 }
    //                 $auto_reply = Auto_Reply::where('type', '=', 'ambulance')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();
    //                 if ($auto_reply) {
    //                     $response = $auto_reply->description;
    //                     $save_reply = Response::create(
    //                         [
    //                             'user_id' => $user->id,
    //                             'type_id' => $ambulance->id,
    //                             'type' => 'ambulance',
    //                             'response' => $response,
    //                             'admin_name' => 'Admin',
    //                             'status' => 'unseen'
    //                         ]
    //                     );
    //                 }
    //                 $medication = Medication::where('user_id', '=', $user->id)->get();

    //                 $service = Ambulance_Service::where('title', '=', $input['ambulance_service'])->first();
                    
                    
    //                  $agency = Agencies::where('title', '=', $service->title)->first();
    //                  $sub_account = Sub_Account::where('agency_id', '=',$agency->id)->first();
                
    //                 $admin_notification = Agency_Notification::create([
    //                         'user_id' => $user->id,
    //                         'u_id' => $user['new_id'],
    //                         'notification' => 'New Ambulance Request',
    //                         'name' => $user->firstname,
    //                         'status' => 'Unread',
    //                         'agency_id' => $sub_account->id
    //                     ]);
    //                 $image = json_decode($ambulance->images);
    //                 if ($service) {
    //                     $dependentname = $service->title;
    //                     if ($service->head_email1) {
    //                         Mail::to($service->head_email1)->send(new AmbulanceMail($user, $map, $dependentname, $ambulance, $image, $medication));
    //                     }
    //                     if ($service->head_email2) {
    //                         Mail::to($service->head_email2)->send(new AmbulanceMail($user, $map, $dependentname, $ambulance, $image, $medication));
    //                     }
    //                     $location = json_decode($service->location);
    //                     $count = 0;
    //                     $allLocationsEmailSent = false;
    //                     foreach ($location as $l) {
    //                         if ($l->location == $input['location']) {
    //                             Mail::to($l->email)->send(new AmbulanceMail($user, $map, $dependentname, $ambulance, $image, $medication));
    //                         } else if ($l->location == 'All Locations' && !$allLocationsEmailSent) {
    //                             Mail::to($l->email)->send(new AmbulanceMail($user, $map, $dependentname, $ambulance, $image, $medication));
    //                             $allLocationsEmailSent = true;
    //                         }
    //                     }
    //                 }
    //                 $adminemail = Admin_Email::find(1);
    //                 if ($adminemail) {
    //                     $email[] = $adminemail->email;

    //                     foreach ($email as $key => $value) {
    //                         $emailAddress = str_replace(['[', ']', '\\', '\"'], '', $value); // Remove unwanted characters
    //                         $emailAddress = explode(',', $emailAddress); // Convert the string to an array

    //                         foreach ($emailAddress as $email) {
    //                             $email = trim($email, "\""); // Remove double quotes from the email address
    //                             $dependentname = 'Admin';

    //                             $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
    //                             $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ' ' . ')';

    //                             Mail::to($email)->send(new AmbulanceMail($user, $map, $dependentname, $ambulance, $image, $medication));

    //                             $mail[] = $email;
    //                         }
    //                     }
    //                 }
    //                 $used_code->status = 'InActive';
    //                 $used_code->save();
    //                 $success['data'] = $ambulance;
    //                 $success['status'] = 200;
    //                 return response()->json(['success' => $success], $this->successStatus);
    //             } else {
    //                 $success['status'] = 400;
    //                 $success['message'] = 'Complete your Profile or Add Atleast 2 dependant';
    //                 return response()->json(['error' => $success]);
    //             }
    //         } else {
    //             $success['status'] = 400;
    //             $success['message'] =  'kaci code is required';
    //             return response()->json(['error' => $success]);
    //         }
    //     }

    // }
    
    
    
    
    
    
        public function store_ambulance(Request $request, $id)
    {
        $user = User::find($id);

        $latest = Ambulance::where('user_id', '=', $user->id)->whereDate('created_at', '>=', now()->subDays(7))->count();
            
            $code = Used_Code::where('user_id', $user->id)->where('status', 'Active')->first();

      
            if ($code) {
                $kaci_code = Kaci_Code::where('code', $code->code)->first();
        
            }
        
         
            $moduleRequestLimit = $kaci_code->ambulance_requests;
        
            if ($latest >= $moduleRequestLimit) {
                $error['status'] = 400;
                $error['message'] = 'Your week limit is reached';
                return response()->json(['error' => $error]);
            }

        if ($moduleRequestLimit > $latest) {
            $validator = Validator::make($request->all(), [
                'ambulance_service' => 'required',
                'people_involved' => 'required',
                'incidence_nature' => 'required',
                'previous_hospital' => 'required',
                'medication' => 'required',
                'location' => 'required',
                'address' => 'required',

            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }


            $input = $request->all();

            if ($user->ksn != null) {
                if ($request->images) {
                    $uploadedFiles = [];

                    foreach ($request->file('images') as $file) {
                        $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

                        $extension = $file->extension(); // Get the file extension

                        // Determine the type of the file based on its extension
                        if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                            $uploadedFile->type = 'image';
                        } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
                            $uploadedFile->type = 'video';
                        } elseif (in_array($extension, ['mp3', 'ogg'])) {
                            $uploadedFile->type = 'audio';
                        } elseif (in_array($extension, ['pptx', 'ppt'])) {
                            $uploadedFile->type = 'ppt';
                        } elseif (in_array($extension, ['docx', 'doc'])) {
                            $uploadedFile->type = 'docx';
                        } elseif (in_array($extension, ['pdf'])) {
                            $uploadedFile->type = 'pdf';
                        } else {
                            // You can handle other file types if needed
                            $uploadedFile->type = 'unknown';
                        }
                        $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
                        $path = $file->storeAs('ambulance_images', $uploadedImage, ['disk' => 's3']);
                        $uploadedFile->url = "https://storage.kacihelp.com/ambulance_images" . $path;
                        // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
                        $uploadedFiles[] = $uploadedFile;
                    }

                    $input['images'] = json_encode($uploadedFiles);
                }
                $map = '';
                if ($request->map) {

                    $coordinatesString = $request->map;
                    $coordinatesArray = json_decode($coordinatesString, true);

                    // Check if $coordinatesArray is an array before accessing the 'latitude'
                    if (is_array($coordinatesArray) && isset($coordinatesArray['latitude'])) {
                        $latitude = $coordinatesArray['latitude'];
                    } else {
                        $latitude = null;
                    }
                    if (is_array($coordinatesArray) && isset($coordinatesArray['longitude'])) {
                        $longitude = $coordinatesArray['longitude'];
                    } else {
                        $longitude = null;
                    }

                    if ($latitude != null && $longitude != null) {
                        $embed_link = "https://www.google.com/maps/search/?api=1&query={latitude}%2C{longitude}";

                        // Replace the placeholders with actual values
                        $final_link = str_replace(
                            ['{latitude}', '{longitude}'],
                            [$latitude, $longitude],
                            $embed_link
                        );
                        $map = $final_link;
                    }
                    // Ensure the 'latitude' key is present in the 'coordinate' JSON object
                    $input['map'] = json_encode($request->map);
                } else {
                    $latitude = null;
                    $longitude = null;
                }
                $input['ksn'] = $user->ksn;
                $input['user_id'] = $user->id;
                $input['name'] = $user->firstname;
                $input['email'] = $user->email;
                $input['phone_number'] = $user->phone_number;
                $input['device'] = $user->device_name;



                $country = Location::where('location', '=', $input['location'])->first();
                $input['country'] = $country->country;
                $model = Ambulance::latest()->first(); // Replace 1 with the actual ID of your record

                if ($model) {

                    // Extract the numeric part of the code and increment it by 1
                    $numericPart = (int) substr($model->reference_code, 4) + 1;

                    // Combine it with the non-numeric part and update the code field
                    $model->reference_code = substr($model->code, 0, 4) . str_pad($numericPart, 10, '0', STR_PAD_LEFT);
                    $ref_code = $model->reference_code;
                    $input['reference_code'] = 'KHAE' . $ref_code;
                } else {
                    $input['reference_code'] = 'KHAE' . '0000000001';
                }

                $ambulance = Ambulance::create($input);
                $activity = Activity::create([
                    'user_id' => $user->id,
                    'type_id' => $ambulance->id,
                    'type' => 'ambulance',
                ]);
                if ($user->device_name === 'Android') {
                    $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                    $user['new_id'] = $new_id;
                } elseif ($user->device_name === 'IOS') {
                    $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                    $user['new_id'] = $new_id;
                }

                $sub = Sub_Admin::all();
                if ($sub->count() > 0) {
                    foreach ($sub as $a) {
                        $admin_notification = Admin_Notification::create([
                            'user_id' => $user->id,
                            'u_id' => $user['new_id'],
                            'notification' => 'New Ambulance Request',
                            'name' => $user->firstname,
                            'status' => 'Unread',
                            'sub_admin_id' => $a->id
                        ]);
                    }
                }


                $auto_reply = Auto_Reply::where('type', '=', 'ambulance')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();
                if ($auto_reply) {
                    $response = $auto_reply->description;
                    $save_reply = Response::create(
                        [
                            'user_id' => $user->id,
                            'type_id' => $ambulance->id,
                            'type' => 'ambulance',
                            'response' => $response,
                            'admin_name' => 'Admin',
                            'status' => 'unseen'
                        ]
                    );
                }

                $medication = Medication::where('user_id', '=', $user->id)->get();



                $service = Ambulance_Service::where('title', '=', $input['ambulance_service'])->first();
                
                $agency = Agencies::where('title', '=', $service->title)->first();
                // $sub_account = Sub_Account::where('agency_id', '=', $agency->id)->first();
                
                 $admin_notification = Agency_Notification::create([
                            'user_id' => $user->id,
                            'u_id' => $user['new_id'],
                            'notification' => 'New Ambulance Request',
                            'name' => $user->firstname,
                            'status' => 'Unread',
                            'agency_id' => $agency->id,
                            'type' => 'ambulance'
                        ]);
                
                
                $image = json_decode($ambulance->images);
                if ($service) {
                    $dependentname = $service->title;

                    if ($service->head_email1) {
                        
                        Mail::to($service->head_email1)->send(new AmbulanceMail($user, $map, $dependentname, $ambulance, $image, $medication));
                        
                    }
                    if ($service->head_email2) {
                        
                        Mail::to($service->head_email2)->send(new AmbulanceMail($user, $map, $dependentname, $ambulance, $image, $medication));
                        
                    }
                    $location = json_decode($service->location);
                    $count = 0;
                    $allLocationsEmailSent = false;
                    foreach ($location as $l) {
                        if ($l->location == $input['location']) {
                            Mail::to($l->email)->send(new AmbulanceMail($user, $map, $dependentname, $ambulance, $image, $medication));
                        } else if ($l->location == 'All Locations' && !$allLocationsEmailSent) {
                            Mail::to($l->email)->send(new AmbulanceMail($user, $map, $dependentname, $ambulance, $image, $medication));
                            $allLocationsEmailSent = true;
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
                            $dependentname = 'Admin';

                            $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
                            $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ' ' . ')';

                            Mail::to($email)->send(new AmbulanceMail($user, $map, $dependentname, $ambulance, $image, $medication));

                            $mail[] = $email;
                        }
                    }
                }

                $success['data'] = $ambulance;
                $success['status'] = 200;
                return response()->json(['success' => $success], $this->successStatus);
            } else {
                $success['status'] = 400;
                $success['message'] = 'Complete your Profile or Add Atleast 2 dependant';
                return response()->json(['error' => $success]);
            }
            
            
        } else {
            
            
            $used_code = Used_Code::where('user_id', '=', $user->id)->where('status', '=', 'Active')->first();
            if ($used_code) {
                $validator = Validator::make($request->all(), [
                    'ambulance_service' => 'required',
                    'people_involved' => 'required',
                    'incidence_nature' => 'required',
                    'previous_hospital' => 'required',
                    'medication' => 'required',
                    // Allow image, video, doc, ppt, and pdf extensions
                    'location' => 'required',
                    'address' => 'required',

                ]);

                if ($validator->fails()) {
                    return response()->json(['error' => $validator->errors()], 401);
                }


                $input = $request->all();

                if ($user->ksn != null) {
                    if ($request->images) {
                        $uploadedFiles = [];

                        foreach ($request->file('images') as $file) {
                            $uploadedFile = new \stdClass(); 
                            $extension = $file->extension(); 
                            if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                                $uploadedFile->type = 'image';
                            } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
                                $uploadedFile->type = 'video';
                            } elseif (in_array($extension, ['mp3', 'ogg'])) {
                                $uploadedFile->type = 'audio';
                            } elseif (in_array($extension, ['pptx'])) {
                                $uploadedFile->type = 'ppt';
                            } elseif (in_array($extension, ['docx'])) {
                                $uploadedFile->type = 'docx';
                            } elseif (in_array($extension, ['pdf'])) {
                                $uploadedFile->type = 'pdf';
                            } else {
                                $uploadedFile->type = 'unknown';
                            }
                            $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
                            $path = $file->storeAs('ambulance_images', $uploadedImage, ['disk' => 's3']);
                            $uploadedFile->url = "https://storage.kacihelp.com/ambulance_images" . $path;
                            
                            // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
                            $uploadedFiles[] = $uploadedFile;
                        }

                        $input['images'] = json_encode($uploadedFiles);
                    }
                    $map = '';
                    if ($request->map) {

                        $coordinatesString = $request->map;
                        $coordinatesArray = json_decode($coordinatesString, true);

                        // Check if $coordinatesArray is an array before accessing the 'latitude'
                        if (is_array($coordinatesArray) && isset($coordinatesArray['latitude'])) {
                            $latitude = $coordinatesArray['latitude'];
                        } else {
                            $latitude = null;
                        }
                        if (is_array($coordinatesArray) && isset($coordinatesArray['longitude'])) {
                            $longitude = $coordinatesArray['longitude'];
                        } else {
                            $longitude = null;
                        }

                        if ($latitude != null && $longitude != null) {
                            $embed_link = "https://www.google.com/maps/search/?api=1&query={latitude}%2C{longitude}";

                            // Replace the placeholders with actual values
                            $final_link = str_replace(
                                ['{latitude}', '{longitude}'],
                                [$latitude, $longitude],
                                $embed_link
                            );
                            $map = $final_link;
                        }
                        // Ensure the 'latitude' key is present in the 'coordinate' JSON object
                        $input['map'] = json_encode($request->map);
                    } else {
                        $latitude = null;
                        $longitude = null;
                    }
                    $input['ksn'] = $user->ksn;
                    $input['user_id'] = $user->id;
                    $input['name'] = $user->firstname;
                    $input['email'] = $user->email;
                    $input['phone_number'] = $user->phone_number;
                    $input['device'] = $user->device_name;



                    $country = Location::where('location', '=', $input['location'])->first();
                    $input['country'] = $country->country;
                    $model = Ambulance::latest()->first(); // Replace 1 with the actual ID of your record

                    if ($model) {

                        // Extract the numeric part of the code and increment it by 1
                        $numericPart = (int) substr($model->reference_code, 4) + 1;

                        // Combine it with the non-numeric part and update the code field
                        $model->reference_code = substr($model->code, 0, 4) . str_pad($numericPart, 10, '0', STR_PAD_LEFT);
                        $ref_code = $model->reference_code;
                        $input['reference_code'] = 'KHAE' . $ref_code;
                    } else {
                        $input['reference_code'] = 'KHAE' . '0000000001';
                    }

                    $ambulance = Ambulance::create($input);
                    $activity = Activity::create([
                        'user_id' => $user->id,
                        'type_id' => $ambulance->id,
                        'type' => 'ambulance',
                    ]);
                    if ($user->device_name === 'Android') {
                        $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                        $user['new_id'] = $new_id;
                    } elseif ($user->device_name === 'IOS') {
                        $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                        $user['new_id'] = $new_id;
                    }

                    $sub = Sub_Admin::all();
                    if ($sub->count() > 0) {
                        foreach ($sub as $a) {

                            $admin_notification = Admin_Notification::create([
                                'user_id' => $user->id,
                                'u_id' => $user['new_id'],
                                'notification' => 'New Ambulance Request',
                                'name' => $user->firstname,
                                'status' => 'Unread',
                                'sub_admin_id' => $a->id
                            ]);
                        }
                    }
                    $auto_reply = Auto_Reply::where('type', '=', 'ambulance')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();
                    if ($auto_reply) {
                        $response = $auto_reply->description;
                        $save_reply = Response::create(
                            [
                                'user_id' => $user->id,
                                'type_id' => $ambulance->id,
                                'type' => 'ambulance',
                                'response' => $response,
                                'admin_name' => 'Admin',
                                'status' => 'unseen'
                            ]
                        );
                    }
                    $medication = Medication::where('user_id', '=', $user->id)->get();

                    $service = Ambulance_Service::where('title', '=', $input['ambulance_service'])->first();
                    
                    
                     $agency = Agencies::where('title', '=', $service->title)->first();
                    //  $sub_account = Sub_Account::where('agency_id', '=',$agency->id)->first();
                
                    $admin_notification = Agency_Notification::create([
                            'user_id' => $user->id,
                            'u_id' => $user['new_id'],
                            'notification' => 'New Ambulance Request',
                            'name' => $user->firstname,
                            'status' => 'Unread',
                           'agency_id' => $agency->id,
                            'type' => 'ambulance',
                        ]);
                    $image = json_decode($ambulance->images);
                    if ($service) {
                        $dependentname = $service->title;
                        if ($service->head_email1) {
                            Mail::to($service->head_email1)->send(new AmbulanceMail($user, $map, $dependentname, $ambulance, $image, $medication));
                        }
                        if ($service->head_email2) {
                            Mail::to($service->head_email2)->send(new AmbulanceMail($user, $map, $dependentname, $ambulance, $image, $medication));
                        }
                        $location = json_decode($service->location);
                        $count = 0;
                        $allLocationsEmailSent = false;
                        foreach ($location as $l) {
                            if ($l->location == $input['location']) {
                                Mail::to($l->email)->send(new AmbulanceMail($user, $map, $dependentname, $ambulance, $image, $medication));
                            } else if ($l->location == 'All Locations' && !$allLocationsEmailSent) {
                                Mail::to($l->email)->send(new AmbulanceMail($user, $map, $dependentname, $ambulance, $image, $medication));
                                $allLocationsEmailSent = true;
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
                                $dependentname = 'Admin';

                                $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
                                $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ' ' . ')';

                                Mail::to($email)->send(new AmbulanceMail($user, $map, $dependentname, $ambulance, $image, $medication));

                                $mail[] = $email;
                            }
                        }
                    }
                    $used_code->status = 'InActive';
                    $used_code->save();
                    $success['data'] = $ambulance;
                    $success['status'] = 200;
                    return response()->json(['success' => $success], $this->successStatus);
                } else {
                    $success['status'] = 400;
                    $success['message'] = 'Complete your Profile or Add Atleast 2 dependant';
                    return response()->json(['error' => $success]);
                }
            } else {
                $success['status'] = 400;
                $success['message'] =  'kaci code is required';
                return response()->json(['error' => $success]);
            }
        }

    }

    // public function store_travelsafe(Request $request, $id)
    // {
    //     $user = User::find($id);

    //     $now_date = Carbon::now();
    //     $past_seven_days = $now_date->subDays(7)->toDateString();
    //     $latest = Travel::where('user_id', '=', $user->id)
    //         ->whereDate('created_at', '>=', now()->subDays(7))
    //         ->count();
    //     $module_request = Module_Request::find(1);
    //     $travel_req = $module_request->travel;


    //     if ($travel_req > $latest) {

    //         $validator = Validator::make($request->all(), [
    //             'boarding' => 'required',
    //             'destination' => 'required',
    //             'vehicle_type' => 'required',
    //             'vehicle_detail' => 'required',
    //             'trip_duration' => 'required', // Allow image, video, doc, ppt, and pdf extensions


    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json(['error' => $validator->errors()], 401);
    //         }


    //         $input = $request->all();

    //         if ($user->ksn != null) {
    //             if ($request->images) {
    //                 $uploadedFiles = [];

    //                 foreach ($request->file('images') as $file) {
    //                     $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

    //                     $extension = $file->extension(); // Get the file extension

    //                     // Determine the type of the file based on its extension
    //                     if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
    //                         $uploadedFile->type = 'image';
    //                     } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
    //                         $uploadedFile->type = 'video';
    //                     } elseif (in_array($extension, ['mp3', 'ogg'])) {
    //                         $uploadedFile->type = 'audio';
    //                     } elseif (in_array($extension, ['pptx', 'ppt'])) {
    //                         $uploadedFile->type = 'ppt';
    //                     } elseif (in_array($extension, ['docx', 'doc'])) {
    //                         $uploadedFile->type = 'docx';
    //                     } elseif (in_array($extension, ['pdf'])) {
    //                         $uploadedFile->type = 'pdf';
    //                     } else {
    //                         // You can handle other file types if needed
    //                         $uploadedFile->type = 'unknown';
    //                     }
    //                     $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
    //                     $path = $file->storeAs('travel_images', $uploadedImage, ['disk' => 's3']);
    //                     $uploadedFile->url = "https://storage.kacihelp.com/" . $path;
    //                     // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
    //                     $uploadedFiles[] = $uploadedFile;
    //                 }

    //                 $input['images'] = json_encode($uploadedFiles);
    //             }

    //             if ($request->coordinate) {

    //                 $coordinatesString = $request->coordinate;
    //                 $coordinatesArray = json_decode($coordinatesString, true);

    //                 // Check if $coordinatesArray is an array before accessing the 'latitude'
    //                 if (is_array($coordinatesArray) && isset($coordinatesArray['latitude'])) {
    //                     $latitude = $coordinatesArray['latitude'];
    //                 } else {
    //                     $latitude = null;
    //                 }
    //                 if (is_array($coordinatesArray) && isset($coordinatesArray['longitude'])) {
    //                     $longitude = $coordinatesArray['longitude'];
    //                 } else {
    //                     $longitude = null;
    //                 }

    //                 if ($latitude != null && $longitude != null) {
    //                     $embed_link = "https://www.google.com/maps/embed/v1/view?key=YOUR_API_KEY&center={latitude},{longitude}&zoom=18&maptype=satellite";

    //                     // Replace the placeholders with actual values
    //                     $final_link = str_replace(
    //                         ['{latitude}', '{longitude}', 'YOUR_API_KEY'],
    //                         [$latitude, $longitude, 'AIzaSyCfxiXntIfBzrcRCETjXcLk_Akq0Qyv2j4'],
    //                         $embed_link
    //                     );
    //                     $input['map'] = $final_link;
    //                 }
    //                 // Ensure the 'latitude' key is present in the 'coordinate' JSON object
    //                 $input['coordinate'] = json_encode($request->coordinate);
    //             } else {
    //                 $latitude = null;
    //                 $longitude = null;
    //             }
    //             // Ensure the 'latitude' key is present in the 'coordinate' JSON object
    //             if ($request->additional_info) {
    //                 $input['additional_info'] = $request->additional_info;
    //             }

    //             $input['ksn'] = $user->ksn;
    //             $input['user_id'] = $user->id;
    //             $input['name'] = $user->firstname;
    //             $input['email'] = $user->email;
    //             $input['phone_number'] = $user->phone_number;
    //             $input['device'] = $user->device_name;
    //             $input['country'] = $user->resident_country;
    //             $input['trip_status'] = 'Checkin';
    //             $model = Travel::latest()->first(); // Replace 1 with the actual ID of your record

    //             if ($model) {

    //                 // Extract the numeric part of the code and increment it by 1
    //                 $numericPart = (int) substr($model->reference_code, 4) + 1;

    //                 // Combine it with the non-numeric part and update the code field
    //                 $model->reference_code = substr($model->code, 0, 4) . str_pad($numericPart, 10, '0', STR_PAD_LEFT);
    //                 $ref_code = $model->reference_code;
    //                 $input['reference_code'] = 'KHTE' . $ref_code;
    //             } else {
    //                 $input['reference_code'] = 'KHTE' . '0000000001';
    //             }

    //             $ambulance = Travel::create($input);
    //             $activity = Activity::create([
    //                 'user_id' => $user->id,
    //                 'type_id' => $ambulance->id,
    //                 'type' => 'travel',
    //             ]);

    //             if ($user->device_name === 'Android') {
    //                 $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
    //                 $user['new_id'] = $new_id;
    //             } elseif ($user->device_name === 'IOS') {
    //                 $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
    //                 $user['new_id'] = $new_id;
    //             }
    //             $sub = Sub_Admin::all();
    //             if ($sub->count() > 0) {
    //                 foreach ($sub as $a) {
    //                     $admin_notification = Admin_Notification::create([
    //                         'user_id' => $user->id,
    //                         'u_id' => $user['new_id'],
    //                         'notification' => 'New Travelsafe Request',
    //                         'name' => $user->firstname,
    //                         'status' => 'Unread',
    //                         'sub_admin_id' => $a->id
    //                     ]);
    //                 }
    //             }

    //             $auto_reply = Auto_Reply::where('type', '=', 'travelsafe')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();
    //             if ($auto_reply) {
    //                 $response = $auto_reply->description;
    //                 $save_reply = Response::create(
    //                     [
    //                         'user_id' => $user->id,
    //                         'type_id' => $ambulance->id,
    //                         'type' => 'travel',
    //                         'response' => $response,
    //                         'admin_name' => 'Admin',
    //                         'status' => 'unseen'
    //                     ]
    //                 );
    //             }

    //             $dependant = Dependant::where('user_id', '=', $user->id)->get();
    //             if ($dependant->count() > 0) {
    //                 $image = json_decode($ambulance->images);
    //                 foreach ($dependant as $d) {
    //                 }
    //             }
    //             $success['data'] = $ambulance;
    //             $success['status'] = 200;
    //             return response()->json(['success' => $success], $this->successStatus);
    //         } else {
    //             $success['status'] = 400;
    //             $success['message'] = 'Complete your Profile or Add Atleast 2 dependant';
    //             return response()->json(['error' => $success]);
    //         }
    //     } else {
    //         $used_code = Used_Code::where('user_id', '=', $user->id)->where('status', '=', 'Active')->first();
    //         if ($used_code) {
    //             $validator = Validator::make($request->all(), [
    //                 'boarding' => 'required',
    //                 'destination' => 'required',
    //                 'vehicle_type' => 'required',
    //                 'vehicle_detail' => 'required',
    //                 'trip_duration' => 'required', // Allow image, video, doc, ppt, and pdf extensions


    //             ]);

    //             if ($validator->fails()) {
    //                 return response()->json(['error' => $validator->errors()], 401);
    //             }


    //             $input = $request->all();

    //             if ($user->ksn != null) {
    //                 if ($request->images) {
    //                     $uploadedFiles = [];

    //                     foreach ($request->file('images') as $file) {
    //                         $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

    //                         $extension = $file->extension(); // Get the file extension

    //                         // Determine the type of the file based on its extension
    //                         if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
    //                             $uploadedFile->type = 'image';
    //                         } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
    //                             $uploadedFile->type = 'video';
    //                         } elseif (in_array($extension, ['mp3', 'ogg'])) {
    //                             $uploadedFile->type = 'audio';
    //                         } elseif (in_array($extension, ['pptx', 'ppt'])) {
    //                             $uploadedFile->type = 'ppt';
    //                         } elseif (in_array($extension, ['docx', 'doc'])) {
    //                             $uploadedFile->type = 'docx';
    //                         } elseif (in_array($extension, ['pdf'])) {
    //                             $uploadedFile->type = 'pdf';
    //                         } else {
    //                             // You can handle other file types if needed
    //                             $uploadedFile->type = 'unknown';
    //                         }
    //                         $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
    //                         $path = $file->storeAs('travel_images', $uploadedImage, ['disk' => 's3']);
    //                         $uploadedFile->url = "https://storage.kacihelp.com/" . $path;
    //                         // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
    //                         $uploadedFiles[] = $uploadedFile;
    //                     }

    //                     $input['images'] = json_encode($uploadedFiles);
    //                 }

    //                 if ($request->coordinate) {

    //                     $coordinatesString = $request->coordinate;
    //                     $coordinatesArray = json_decode($coordinatesString, true);

    //                     // Check if $coordinatesArray is an array before accessing the 'latitude'
    //                     if (is_array($coordinatesArray) && isset($coordinatesArray['latitude'])) {
    //                         $latitude = $coordinatesArray['latitude'];
    //                     } else {
    //                         $latitude = null;
    //                     }
    //                     if (is_array($coordinatesArray) && isset($coordinatesArray['longitude'])) {
    //                         $longitude = $coordinatesArray['longitude'];
    //                     } else {
    //                         $longitude = null;
    //                     }

    //                     if ($latitude != null && $longitude != null) {
    //                         $embed_link = "https://www.google.com/maps/embed/v1/view?key=YOUR_API_KEY&center={latitude},{longitude}&zoom=18&maptype=satellite";

    //                         // Replace the placeholders with actual values
    //                         $final_link = str_replace(
    //                             ['{latitude}', '{longitude}', 'YOUR_API_KEY'],
    //                             [$latitude, $longitude, 'AIzaSyCfxiXntIfBzrcRCETjXcLk_Akq0Qyv2j4'],
    //                             $embed_link
    //                         );
    //                         $input['map'] = $final_link;
    //                     }
    //                     // Ensure the 'latitude' key is present in the 'coordinate' JSON object
    //                     $input['coordinate'] = json_encode($request->coordinate);
    //                 } else {
    //                     $latitude = null;
    //                     $longitude = null;
    //                 }
    //                 // Ensure the 'latitude' key is present in the 'coordinate' JSON object

    //                 $input['country'] = $user->resident_country;
    //                 $input['ksn'] = $user->ksn;
    //                 $input['user_id'] = $user->id;
    //                 $input['name'] = $user->firstname;
    //                 $input['email'] = $user->email;
    //                 $input['phone_number'] = $user->phone_number;
    //                 $input['device'] = $user->device_name;
    //                 $input['trip_status'] = 'Checkin';
    //                 $model = Travel::latest()->first(); // Replace 1 with the actual ID of your record

    //                 if ($model) {

    //                     // Extract the numeric part of the code and increment it by 1
    //                     $numericPart = (int) substr($model->reference_code, 4) + 1;

    //                     // Combine it with the non-numeric part and update the code field
    //                     $model->reference_code = substr($model->code, 0, 4) . str_pad($numericPart, 10, '0', STR_PAD_LEFT);
    //                     $ref_code = $model->reference_code;
    //                     $input['reference_code'] = 'KHTE' . $ref_code;
    //                 } else {
    //                     $input['reference_code'] = 'KHTE' . '0000000001';
    //                 }
    //                 $ambulance = Travel::create($input);
    //                 $activity = Activity::create([
    //                     'user_id' => $user->id,
    //                     'type_id' => $ambulance->id,
    //                     'type' => 'travel',
    //                 ]);

    //                 if ($user->device_name === 'Android') {
    //                     $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
    //                     $user['new_id'] = $new_id;
    //                 } elseif ($user->device_name === 'IOS') {
    //                     $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
    //                     $user['new_id'] = $new_id;
    //                 }

    //                 $sub = Sub_Admin::all();
    //                 if ($sub->count() > 0) {
    //                     foreach ($sub as $a) {
    //                         $admin_notification = Admin_Notification::create([
    //                             'user_id' => $user->id,
    //                             'u_id' => $user['new_id'],
    //                             'notification' => 'New Travelsafe Request',
    //                             'name' => $user->firstname,
    //                             'status' => 'Unread',
    //                             'sub_Admin_id' => $a->id
    //                         ]);
    //                     }
    //                 }


    //                 $auto_reply = Auto_Reply::where('type', '=', 'travelsafe')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();
    //                 if ($auto_reply) {
    //                     $response = $auto_reply->description;
    //                     $save_reply = Response::create(
    //                         [
    //                             'user_id' => $user->id,
    //                             'type_id' => $ambulance->id,
    //                             'type' => 'travel',
    //                             'response' => $response,
    //                             'admin_name' => 'Admin',
    //                             'status' => 'unseen'
    //                         ]
    //                     );
    //                 }

    //                 $dependant = Dependant::where('user_id', '=', $user->id)->get();
    //                 if ($dependant->count() > 0) {
    //                     $image = json_decode($ambulance->images);
    //                     foreach ($dependant as $d) {
    //                     }
    //                 }
    //                 //   $adminemail = Admin_Email::find(1);
    //                 //   if ($adminemail) {
    //                 //       $email[] = $adminemail->email;

    //                 //       foreach ($email as $key => $value) {
    //                 //           $emailAddress = str_replace(['[', ']', '\\', '\"'], '', $value); // Remove unwanted characters
    //                 //           $emailAddress = explode(',', $emailAddress); // Convert the string to an array

    //                 //           foreach ($emailAddress as $email) {
    //                 //               $email = trim($email, "\""); // Remove double quotes from the email address

    //                 //               Mail::to($email)->send(new TravelMail($user, $ambulance,$dependant, $latitude,$longitude, $image ));
    //                 //               $mail[]=$email;

    //                 //           }


    //                 //       }
    //                 //   }
    //                 $used_code->status = 'InActive';
    //                 $used_code->save();
    //                 $success['data'] = $ambulance;
    //                 $success['status'] = 200;
    //                 return response()->json(['success' => $success], $this->successStatus);
    //             } else {
    //                 $success['status'] = 400;
    //                 $success['message'] = 'Complete your Profile or Add Atleast 2 dependant';
    //                 return response()->json(['error' => $success]);
    //             }
    //         } else {

    //             $success['status'] = 150;

    //             return response()->json(['error' => $success]);
    //         }
    //     }

    // }





public function store_travelsafe(Request $request, $id)
    {
        $user = User::find($id);

             $latest = Travel::where('user_id', '=', $user->id)->whereDate('created_at', '>=', now()->subDays(7))->count();
                
                $code = Used_Code::where('user_id', $user->id)->where('status', 'Active')->first();
                
                if ($code) {
                    $kaci_code = Kaci_Code::where('code', $code->code)->first();
                }
            
             
                $moduleRequestLimit = $kaci_code->travelsafe_requests;
            
                if ($latest >= $moduleRequestLimit) {
                    $error['status'] = 400;
                    $error['message'] = 'Your week limit is reached';
                    return response()->json(['error' => $error]);
                }
                
    


        if ($moduleRequestLimit > $latest) {

            $validator = Validator::make($request->all(), [
                'boarding' => 'required',
                'destination' => 'required',
                'vehicle_type' => 'required',
                'vehicle_detail' => 'required',
                'trip_duration' => 'required', // Allow image, video, doc, ppt, and pdf extensions


            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }


            $input = $request->all();

            if ($user->ksn != null) {
                if ($request->images) {
                    $uploadedFiles = [];

                    foreach ($request->file('images') as $file) {
                        $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

                        $extension = $file->extension(); // Get the file extension

                        // Determine the type of the file based on its extension
                        if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                            $uploadedFile->type = 'image';
                        } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
                            $uploadedFile->type = 'video';
                        } elseif (in_array($extension, ['mp3', 'ogg'])) {
                            $uploadedFile->type = 'audio';
                        } elseif (in_array($extension, ['pptx', 'ppt'])) {
                            $uploadedFile->type = 'ppt';
                        } elseif (in_array($extension, ['docx', 'doc'])) {
                            $uploadedFile->type = 'docx';
                        } elseif (in_array($extension, ['pdf'])) {
                            $uploadedFile->type = 'pdf';
                        } else {
                            // You can handle other file types if needed
                            $uploadedFile->type = 'unknown';
                        }
                        $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
                        $path = $file->storeAs('travel_images', $uploadedImage, ['disk' => 's3']);
                        $uploadedFile->url = "https://storage.kacihelp.com/travel_images/" . $path;
                        // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
                        $uploadedFiles[] = $uploadedFile;
                    }

                    $input['images'] = json_encode($uploadedFiles);
                }

                if ($request->coordinate) {

                    $coordinatesString = $request->coordinate;
                    $coordinatesArray = json_decode($coordinatesString, true);

                    // Check if $coordinatesArray is an array before accessing the 'latitude'
                    if (is_array($coordinatesArray) && isset($coordinatesArray['latitude'])) {
                        $latitude = $coordinatesArray['latitude'];
                    } else {
                        $latitude = null;
                    }
                    if (is_array($coordinatesArray) && isset($coordinatesArray['longitude'])) {
                        $longitude = $coordinatesArray['longitude'];
                    } else {
                        $longitude = null;
                    }

                    if ($latitude != null && $longitude != null) {
                        $embed_link = "https://www.google.com/maps/embed/v1/view?key=YOUR_API_KEY&center={latitude},{longitude}&zoom=18&maptype=satellite";

                        // Replace the placeholders with actual values
                        $final_link = str_replace(
                            ['{latitude}', '{longitude}', 'YOUR_API_KEY'],
                            [$latitude, $longitude, 'AIzaSyCfxiXntIfBzrcRCETjXcLk_Akq0Qyv2j4'],
                            $embed_link
                        );
                        $input['map'] = $final_link;
                    }
                    // Ensure the 'latitude' key is present in the 'coordinate' JSON object
                    $input['coordinate'] = json_encode($request->coordinate);
                } else {
                    $latitude = null;
                    $longitude = null;
                }
                // Ensure the 'latitude' key is present in the 'coordinate' JSON object
                if ($request->additional_info) {
                    $input['additional_info'] = $request->additional_info;
                }

                $input['ksn'] = $user->ksn;
                $input['user_id'] = $user->id;
                $input['name'] = $user->firstname;
                $input['email'] = $user->email;
                $input['phone_number'] = $user->phone_number;
                $input['device'] = $user->device_name;
                $input['country'] = $user->resident_country;
                $input['trip_status'] = 'Checkin';
                $model = Travel::latest()->first(); // Replace 1 with the actual ID of your record

                if ($model) {

                    // Extract the numeric part of the code and increment it by 1
                    $numericPart = (int) substr($model->reference_code, 4) + 1;

                    // Combine it with the non-numeric part and update the code field
                    $model->reference_code = substr($model->code, 0, 4) . str_pad($numericPart, 10, '0', STR_PAD_LEFT);
                    $ref_code = $model->reference_code;
                    $input['reference_code'] = 'KHTE' . $ref_code;
                } else {
                    $input['reference_code'] = 'KHTE' . '0000000001';
                }

                $ambulance = Travel::create($input);
                $activity = Activity::create([
                    'user_id' => $user->id,
                    'type_id' => $ambulance->id,
                    'type' => 'travel',
                ]);

                if ($user->device_name === 'Android') {
                    $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                    $user['new_id'] = $new_id;
                } elseif ($user->device_name === 'IOS') {
                    $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                    $user['new_id'] = $new_id;
                }
                $sub = Sub_Admin::all();
                if ($sub->count() > 0) {
                    foreach ($sub as $a) {
                        $admin_notification = Admin_Notification::create([
                            'user_id' => $user->id,
                            'u_id' => $user['new_id'],
                            'notification' => 'New Travelsafe Request',
                            'name' => $user->firstname,
                            'status' => 'Unread',
                            'sub_admin_id' => $a->id
                        ]);
                    }
                }

                $auto_reply = Auto_Reply::where('type', '=', 'travelsafe')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();
                if ($auto_reply) {
                    $response = $auto_reply->description;
                    $save_reply = Response::create(
                        [
                            'user_id' => $user->id,
                            'type_id' => $ambulance->id,
                            'type' => 'travel',
                            'response' => $response,
                            'admin_name' => 'Admin',
                            'status' => 'unseen'
                        ]
                    );
                }

                $dependant = Dependant::where('user_id', '=', $user->id)->get();
                if ($dependant->count() > 0) {
                    $image = json_decode($ambulance->images);
                    foreach ($dependant as $d) {
                    }
                }
                $success['data'] = $ambulance;
                $success['status'] = 200;
                return response()->json(['success' => $success], $this->successStatus);
            } else {
                $success['status'] = 400;
                $success['message'] = 'Complete your Profile or Add Atleast 2 dependant';
                return response()->json(['error' => $success]);
            }
        } else {
            $used_code = Used_Code::where('user_id', '=', $user->id)->where('status', '=', 'Active')->first();
            if ($used_code) {
                $validator = Validator::make($request->all(), [
                    'boarding' => 'required',
                    'destination' => 'required',
                    'vehicle_type' => 'required',
                    'vehicle_detail' => 'required',
                    'trip_duration' => 'required', // Allow image, video, doc, ppt, and pdf extensions


                ]);

                if ($validator->fails()) {
                    return response()->json(['error' => $validator->errors()], 401);
                }


                $input = $request->all();

                if ($user->ksn != null) {
                    if ($request->images) {
                        $uploadedFiles = [];

                        foreach ($request->file('images') as $file) {
                            $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

                            $extension = $file->extension(); // Get the file extension

                            // Determine the type of the file based on its extension
                            if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                                $uploadedFile->type = 'image';
                            } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
                                $uploadedFile->type = 'video';
                            } elseif (in_array($extension, ['mp3', 'ogg'])) {
                                $uploadedFile->type = 'audio';
                            } elseif (in_array($extension, ['pptx', 'ppt'])) {
                                $uploadedFile->type = 'ppt';
                            } elseif (in_array($extension, ['docx', 'doc'])) {
                                $uploadedFile->type = 'docx';
                            } elseif (in_array($extension, ['pdf'])) {
                                $uploadedFile->type = 'pdf';
                            } else {
                                // You can handle other file types if needed
                                $uploadedFile->type = 'unknown';
                            }
                            $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
                            $path = $file->storeAs('travel_images', $uploadedImage, ['disk' => 's3']);
                            $uploadedFile->url = "https://storage.kacihelp.com/travel_images" . $path;
                            // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
                            $uploadedFiles[] = $uploadedFile;
                        }

                        $input['images'] = json_encode($uploadedFiles);
                    }

                    if ($request->coordinate) {

                        $coordinatesString = $request->coordinate;
                        $coordinatesArray = json_decode($coordinatesString, true);

                        // Check if $coordinatesArray is an array before accessing the 'latitude'
                        if (is_array($coordinatesArray) && isset($coordinatesArray['latitude'])) {
                            $latitude = $coordinatesArray['latitude'];
                        } else {
                            $latitude = null;
                        }
                        if (is_array($coordinatesArray) && isset($coordinatesArray['longitude'])) {
                            $longitude = $coordinatesArray['longitude'];
                        } else {
                            $longitude = null;
                        }

                        if ($latitude != null && $longitude != null) {
                            $embed_link = "https://www.google.com/maps/embed/v1/view?key=YOUR_API_KEY&center={latitude},{longitude}&zoom=18&maptype=satellite";

                            // Replace the placeholders with actual values
                            $final_link = str_replace(
                                ['{latitude}', '{longitude}', 'YOUR_API_KEY'],
                                [$latitude, $longitude, 'AIzaSyCfxiXntIfBzrcRCETjXcLk_Akq0Qyv2j4'],
                                $embed_link
                            );
                            $input['map'] = $final_link;
                        }
                        // Ensure the 'latitude' key is present in the 'coordinate' JSON object
                        $input['coordinate'] = json_encode($request->coordinate);
                    } else {
                        $latitude = null;
                        $longitude = null;
                    }
                    // Ensure the 'latitude' key is present in the 'coordinate' JSON object

                    $input['country'] = $user->resident_country;
                    $input['ksn'] = $user->ksn;
                    $input['user_id'] = $user->id;
                    $input['name'] = $user->firstname;
                    $input['email'] = $user->email;
                    $input['phone_number'] = $user->phone_number;
                    $input['device'] = $user->device_name;
                    $input['trip_status'] = 'Checkin';
                    $model = Travel::latest()->first(); // Replace 1 with the actual ID of your record

                    if ($model) {

                        // Extract the numeric part of the code and increment it by 1
                        $numericPart = (int) substr($model->reference_code, 4) + 1;

                        // Combine it with the non-numeric part and update the code field
                        $model->reference_code = substr($model->code, 0, 4) . str_pad($numericPart, 10, '0', STR_PAD_LEFT);
                        $ref_code = $model->reference_code;
                        $input['reference_code'] = 'KHTE' . $ref_code;
                    } else {
                        $input['reference_code'] = 'KHTE' . '0000000001';
                    }
                    $ambulance = Travel::create($input);
                    $activity = Activity::create([
                        'user_id' => $user->id,
                        'type_id' => $ambulance->id,
                        'type' => 'travel',
                    ]);

                    if ($user->device_name === 'Android') {
                        $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                        $user['new_id'] = $new_id;
                    } elseif ($user->device_name === 'IOS') {
                        $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                        $user['new_id'] = $new_id;
                    }

                    $sub = Sub_Admin::all();
                    if ($sub->count() > 0) {
                        foreach ($sub as $a) {
                            $admin_notification = Admin_Notification::create([
                                'user_id' => $user->id,
                                'u_id' => $user['new_id'],
                                'notification' => 'New Travelsafe Request',
                                'name' => $user->firstname,
                                'status' => 'Unread',
                                'sub_Admin_id' => $a->id
                            ]);
                        }
                    }


                    $auto_reply = Auto_Reply::where('type', '=', 'travelsafe')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();
                    if ($auto_reply) {
                        $response = $auto_reply->description;
                        $save_reply = Response::create(
                            [
                                'user_id' => $user->id,
                                'type_id' => $ambulance->id,
                                'type' => 'travel',
                                'response' => $response,
                                'admin_name' => 'Admin',
                                'status' => 'unseen'
                            ]
                        );
                    }

                    $dependant = Dependant::where('user_id', '=', $user->id)->get();
                    if ($dependant->count() > 0) {
                        $image = json_decode($ambulance->images);
                        foreach ($dependant as $d) {
                        }
                    }
                    //   $adminemail = Admin_Email::find(1);
                    //   if ($adminemail) {
                    //       $email[] = $adminemail->email;

                    //       foreach ($email as $key => $value) {
                    //           $emailAddress = str_replace(['[', ']', '\\', '\"'], '', $value); // Remove unwanted characters
                    //           $emailAddress = explode(',', $emailAddress); // Convert the string to an array

                    //           foreach ($emailAddress as $email) {
                    //               $email = trim($email, "\""); // Remove double quotes from the email address

                    //               Mail::to($email)->send(new TravelMail($user, $ambulance,$dependant, $latitude,$longitude, $image ));
                    //               $mail[]=$email;

                    //           }


                    //       }
                    //   }
                    $used_code->status = 'InActive';
                    $used_code->save();
                    $success['data'] = $ambulance;
                    $success['status'] = 200;
                    return response()->json(['success' => $success], $this->successStatus);
                } else {
                    $success['status'] = 400;
                    $success['message'] = 'Complete your Profile or Add Atleast 2 dependant';
                    return response()->json(['error' => $success]);
                }
            } else {

                $success['status'] = 150;

                return response()->json(['error' => $success]);
            }
        }

    }
    
    
    // public function store_sos(Request $request, $id)
    // {
    //     $user = User::find($id);

    //     $now_date = Carbon::now();
    //     $past_seven_days = $now_date->subDays(7)->toDateString();
    //     $latest = Sos::where('user_id', '=', $user->id)
    //         ->whereDate('created_at', '>=', now()->subDays(7))
    //         ->count();
    //     $module_request = Module_Request::find(1);
    //     $emergency_req = $module_request->emergency;

    //     if ($emergency_req > $latest) {
    //         $validator = Validator::make($request->all(), [
    //             'location' => 'required',
    //             'address' => 'required',
    //             'target_agency' => 'required',
    //             'map' => 'nullable',

    //             'coordinate' => 'nullable',

    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json(['error' => $validator->errors()], 401);
    //         }


    //         $input = $request->all();

    //         if ($user->ksn != null) {
    //             if ($request->images) {
    //                 $uploadedFiles = [];

    //                 foreach ($request->file('images') as $file) {
    //                     $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

    //                     $extension = $file->extension(); // Get the file extension

    //                     // Determine the type of the file based on its extension
    //                     if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
    //                         $uploadedFile->type = 'image';
    //                     } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
    //                         $uploadedFile->type = 'video';
    //                     } elseif (in_array($extension, ['mp3', 'ogg'])) {
    //                         $uploadedFile->type = 'audio';
    //                     } elseif (in_array($extension, ['pptx', 'ppt'])) {
    //                         $uploadedFile->type = 'ppt';
    //                     } elseif (in_array($extension, ['docx', 'doc'])) {
    //                         $uploadedFile->type = 'docx';
    //                     } elseif (in_array($extension, ['pdf'])) {
    //                         $uploadedFile->type = 'pdf';
    //                     } else {
    //                         // You can handle other file types if needed
    //                         $uploadedFile->type = 'unknown';
    //                     }
    //                     $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
    //                     $path = $file->storeAs('sos_images', $uploadedImage, ['disk' => 's3']);
    //                     $uploadedFile->url = "https://storage.kacihelp.com/" . $path;
    //                     // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);

    //                     $uploadedFiles[] = $uploadedFile;
    //                 }

    //                 $input['images'] = json_encode($uploadedFiles);
    //             }
    //             if ($request->coordinate) {

    //                 $coordinatesString = $request->coordinate;
    //                 $coordinatesArray = json_decode($coordinatesString, true);

    //                 // Check if $coordinatesArray is an array before accessing the 'latitude'
    //                 if (is_array($coordinatesArray) && isset($coordinatesArray['latitude'])) {
    //                     $latitude = $coordinatesArray['latitude'];
    //                 } else {
    //                     $latitude = null;
    //                 }
    //                 if (is_array($coordinatesArray) && isset($coordinatesArray['longitude'])) {
    //                     $longitude = $coordinatesArray['longitude'];
    //                 } else {
    //                     $longitude = null;
    //                 }

    //                 if ($latitude != null && $longitude != null) {
    //                     $embed_link = "https://www.google.com/maps/embed/v1/view?key=YOUR_API_KEY&center={latitude},{longitude}&zoom=18&maptype=satellite";

    //                     // Replace the placeholders with actual values
    //                     $final_link = str_replace(
    //                         ['{latitude}', '{longitude}', 'YOUR_API_KEY'],
    //                         [$latitude, $longitude, 'AIzaSyCfxiXntIfBzrcRCETjXcLk_Akq0Qyv2j4'],
    //                         $embed_link
    //                     );
    //                     $input['map'] = '';
    //                 }

    //                 // Ensure the 'latitude' key is present in the 'coordinate' JSON object
    //                 $input['coordinate'] = json_encode($request->coordinate);
    //             }
    



    //             $input['ksn'] = $user->ksn;
    //             $input['user_id'] = $user->id;
    //             $input['name'] = $user->firstname;
    //             $input['email'] = $user->email;
    //             $input['phone_number'] = $user->phone_number;
    //             $input['device'] = $user->device_name;

    //             $country = Location::where('location', '=', $input['location'])->first();
    //             $input['country'] = $country->country;
    //             $model = Sos::latest()->first(); // Replace 1 with the actual ID of your record

    //             if ($model) {

    //                 // Extract the numeric part of the code and increment it by 1
    //                 $numericPart = (int) substr($model->reference_code, 4) + 1;

    //                 // Combine it with the non-numeric part and update the code field
    //                 $model->reference_code = substr($model->code, 0, 4) . str_pad($numericPart, 10, '0', STR_PAD_LEFT);
    //                 $ref_code = $model->reference_code;
    //                 $input['reference_code'] = 'KHEY' . $ref_code;
    //             } else {
    //                 $input['reference_code'] = 'KHEY' . '0000000001';
    //             }

    //             $ambulance = Sos::create($input);
    //             $activity = Activity::create([
    //                 'user_id' => $user->id,
    //                 'type_id' => $ambulance->id,
    //                 'type' => 'emergency',
    //             ]);

    //             if ($user->device_name === 'Android') {
    //                 $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
    //                 $user['new_id'] = $new_id;
    //             } elseif ($user->device_name === 'IOS') {
    //                 $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
    //                 $user['new_id'] = $new_id;
    //             }

    //             $sub = Sub_Admin::all();
    //             if ($sub->count() > 0) {
    //                 foreach ($sub as $a) {
    //                     $admin_notification = Admin_Notification::create([
    //                         'user_id' => $user->id,
    //                         'u_id' => $user['new_id'],
    //                         'notification' => 'New Emergency Request',
    //                         'name' => $user->firstname,
    //                         'status' => 'Unread',
    //                         'sub_admin_id' => $a->id
    //                     ]);
    //                 }
    //             }
    //             $auto_reply = Auto_Reply::where('type', '=', 'emergency')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();
    //             if ($auto_reply) {
    //                 $response = $auto_reply->description;
    //                 $save_reply = Response::create(
    //                     [
    //                         'user_id' => $user->id,
    //                         'type_id' => $ambulance->id,
    //                         'type' => 'emergency',
    //                         'response' => $response,
    //                         'admin_name' => 'Admin',
    //                         'status' => 'unseen'
    //                     ]
    //                 );
    //             }


    //             $dependant = Dependant::where('user_id', '=', $user->id)->get();
    //             $map = '';
    //             if ($dependant->count() > 0) {
    //                 $count = 0;
    //                 foreach ($dependant as $d) {
    //                     if ($count >= 2) {
    //                         break;
    //                     }

    //                     // Your code here


    //                     $dependentname = $d->name;

    //                     $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
    //                     $ambulance['line'] = 'Your Dependent' . ' ' . $user->firstname . ' ' . $user->lastname;

    //                     try {

    //                         if ($user->language === "English") {
    //                             Mail::to($d->email)->send(new Emergency($user, $map, $dependentname, $ambulance));
    //                         } else if ($user->language === "Arabic") {
    //                             Mail::to($d->email)->send(new ArabicEmergency($user, $map, $dependentname, $ambulance));
    //                         } else if ($user->language === "Yoruba") {
    //                             Mail::to($d->email)->send(new YorubaEmergency($user, $map, $dependentname, $ambulance));
    //                         } else if ($user->language === "Chinese") {
    //                             Mail::to($d->email)->send(new ChineseEmergency($user, $map, $dependentname, $ambulance));
    //                         } else if ($user->language === "Igbo") {
    //                             Mail::to($d->email)->send(new IgboEmergency($user, $map, $dependentname, $ambulance));
    //                         } else if ($user->language === "French") {
    //                             Mail::to($d->email)->send(new FrenchEmergency($user, $map, $dependentname, $ambulance));
    //                         } else if ($user->language === "Fula") {
    //                             Mail::to($d->email)->send(new FulaEmergency($user, $map, $dependentname, $ambulance));
    //                         } else if ($user->language === "Portuguese") {
    //                             Mail::to($d->email)->send(new PortugueseEmergency($user, $map, $dependentname, $ambulance));
    //                         } else if ($user->language === "Spanish") {
    //                             Mail::to($d->email)->send(new SpanishEmergency($user, $map, $dependentname, $ambulance));
    //                         } else if ($user->language === "Hausa") {
    //                             Mail::to($d->email)->send(new HausaEmergency($user, $map, $dependentname, $ambulance));
    //                         } else {
    //                             Mail::to($d->email)->send(new Emergency($user, $map, $dependentname, $ambulance));
    //                         }
    //                     } catch (TransportException $e) {
    //                         $success['data'] = $ambulance;
    //                         $success['status'] = 200;
    //                         return response()->json(['success' => $success], $this->successStatus);
    //                     }

    //                     $country = General_Countries::where('country_name', '=', $d->country)->first();
    //                     $phone_number = $d->phone_number;
    //                     $country_code = $country->country_code;
    //                     $countryCode = preg_replace('/[^0-9]/', '', $country_code);
    //                     $number = $countryCode . $phone_number;


    //                     $link = $ambulance['link'];
    //                     try {

    //                         $apiKey = '987eec7ae6024a5cca4d1087671678e7';
    //                         $apiEndpoint = 'http://api.gupshup.io/sm/api/v1/template/msg';

    //                         // Replace these values with your actual data
    //                         $source = '2348140040081';
    //                         $destination =  $number;
    //                         $templateId = 'b8ea8351-f93b-4218-bd0e-25ae08a04626';
    //                         $templateParams = ["*$d->name*", "*$user->firstname $user->lastname*", "$link"];

    //                         // Create a Guzzle client
    //                         $client = new \GuzzleHttp\Client();

    //                         // Prepare the request parameters
    //                         $params = [
    //                             'headers' => [
    //                                 'apikey' => $apiKey,
    //                                 'Content-Type' => 'application/x-www-form-urlencoded',
    //                             ],
    //                             'form_params' => [
    //                                 'source' => $source,
    //                                 'destination' => $destination,
    //                                 'template' => json_encode(['id' => $templateId, 'params' => $templateParams]),
    //                             ],
    //                         ];

    //                         // Make the POST request
    //                         $response = $client->post($apiEndpoint, $params);

    //                         // Get the response body as a string
    //                         $responseBody = $response->getBody()->getContents();

    //                         // Output the response

    //                     } catch (\Exception $e) {
    //                         return response()->json(['message' => 'An error occurred while sending the Whatsapp']);
    //                     }

    //                     try {

    //                         $curl = curl_init();
    //                         $data = array(
    //                             "api_key" => "TLsWe5NjzlDfhPVWCaPHbrnj9ggcUXlL81WYn15lhysyUjblgRQeSsLr9eAnY7",
    //                             "to" => $number,
    //                             "from" => "N-Alert",
    //                             "sms" => "Dear $d->name, Your dependent $user->firstname $user->lastname is in an emergency; follow this link to view the details:  $link ",
    //                             "type" => "plain",
    //                             "channel" => "dnd"
    //                         );

    //                         $post_data = json_encode($data);

    //                         curl_setopt_array($curl, array(
    //                             CURLOPT_URL => "https://api.ng.termii.com/api/sms/send",
    //                             CURLOPT_RETURNTRANSFER => true,
    //                             CURLOPT_ENCODING => "",
    //                             CURLOPT_MAXREDIRS => 10,
    //                             CURLOPT_TIMEOUT => 0,
    //                             CURLOPT_FOLLOWLOCATION => true,
    //                             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //                             CURLOPT_CUSTOMREQUEST => "POST",
    //                             CURLOPT_POSTFIELDS => $post_data,
    //                             CURLOPT_HTTPHEADER => array(
    //                                 "Content-Type: application/json"
    //                             ),
    //                         ));

    //                         $response = curl_exec($curl);

    //                         curl_close($curl);

    //                         \Log::info('sos:' . $response);
    //                     } catch (\Exception $e) {
    //                         return response()->json(['message' => 'An error occurred while sending the SMS']);
    //                     }
    //                     $count++;
    //                 }
    //             }

    //             $agency = Agencies::where('title', '=', $input['target_agency'])->first();
    //             $sub_account = Sub_Account::where('agency_id','=', $agency->id)->first();
                
    //              $admin_notification = Agency_Notification::create([
    //                             'user_id' => $user->id,
    //                             'u_id' => $user['new_id'],
    //                             'notification' => 'New Emergency Request',
    //                             'name' => $user->firstname,
    //                             'status' => 'Unread',
    //                             'agency_id' => $sub_account->id
    //                         ]);

    //             if ($agency) {
    //                 try {
    //                     if ($agency->head_email1 != null) {
    //                         $image = json_decode($ambulance->images);
    //                         $dependentname = $agency->title;

    //                         $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
    //                         $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ')';

    //                         Mail::to($agency->head_email1)->send(new Emergency($user, $map, $dependentname, $ambulance));
    //                     }
    //                     if ($agency->head_email2 != null) {
    //                         $image = json_decode($ambulance->images);
    //                         $dependentname = $agency->title;

    //                         $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
    //                         $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ')';

    //                         Mail::to($agency->head_email2)->send(new Emergency($user, $map, $dependentname, $ambulance));
    //                     }
    //                     $location = json_decode($agency->location);
    //                     $count = 0;
    //                     $allLocationsEmailSent = false;
    //                     foreach ($location as $l) {
    //                         if ($l->location == $input['location']) {
    //                             $image = json_decode($ambulance->images);
    //                             $dependentname = $agency->title;

    //                             $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
    //                             $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ')';
    //                             Mail::to($l->email)->send(new Emergency($user, $map, $dependentname, $ambulance));
    //                             $count++;
    //                         } else if ($l->location == 'All Locations' && !$allLocationsEmailSent) {
    //                             $image = json_decode($ambulance->images);
    //                             $dependentname = $agency->title;

    //                             $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
    //                             $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ')';
    //                             Mail::to($l->email)->send(new Emergency($user, $map, $dependentname, $ambulance));
    //                             $allLocationsEmailSent = true;
    //                         }
    //                     }
    //                 } catch (TransportException $e) {
    //                     $success['data'] = $ambulance;
    //                     $success['status'] = 200;
    //                     return response()->json(['success' => $success], $this->successStatus);
    //                 }
    //             }
    //             $adminemail = Admin_Email::find(1);
    //             if ($adminemail) {
    //                 try {

    //                     $email[] = $adminemail->email;

    //                     foreach ($email as $key => $value) {
    //                         $emailAddress = str_replace(['[', ']', '\\', '\"'], '', $value); // Remove unwanted characters
    //                         $emailAddress = explode(',', $emailAddress); // Convert the string to an array

    //                         foreach ($emailAddress as $email) {
    //                             $email = trim($email, "\""); // Remove double quotes from the email address
    //                             $dependentname = 'Admin';

    //                             $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
    //                             $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ')';

    //                             Mail::to($email)->send(new Emergency($user, $map, $dependentname, $ambulance));

    //                             $mail[] = $email;
    //                         }
    //                     }
    //                 } catch (TransportException $e) {
    //                     $success['data'] = $ambulance;
    //                     $success['status'] = 200;
    //                     return response()->json(['success' => $success], $this->successStatus);
    //                 }
    //             }
    //             $success['data'] = $ambulance;
    //             $success['status'] = 200;
    //             return response()->json(['success' => $success], $this->successStatus);
    //         } else {
    //             $success['status'] = 400;
    //             $success['message'] = 'Complete your Profile or Add Atleast 2 dependant';
    //             return response()->json(['error' => $success]);
    //         }
            
            
    //     } else {
    //         $used_code = Used_Code::where('user_id', '=', $user->id)->where('status', '=', 'Active')->first();
    //         if ($used_code) {
    //             $validator = Validator::make($request->all(), [
    //                 'location' => 'required',
    //                 'address' => 'required',
    //                 'target_agency' => 'required',
    //                 'map' => 'nullable',

    //                 'coordinate' => 'nullable',

    //             ]);

    //             if ($validator->fails()) {
    //                 return response()->json(['error' => $validator->errors()], 401);
    //             }


    //             $input = $request->all();

    //             if ($user->ksn != null) {
    //                 if ($request->images) {
    //                     $uploadedFiles = [];

    //                     foreach ($request->file('images') as $file) {
    //                         $uploadedFile = new \stdClass(); 
    //                         $extension = $file->extension();
    //                         if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
    //                             $uploadedFile->type = 'image';
    //                         } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
    //                             $uploadedFile->type = 'video';
    //                         } elseif (in_array($extension, ['mp3', 'ogg'])) {
    //                             $uploadedFile->type = 'audio';
    //                         } elseif (in_array($extension, ['pptx', 'ppt'])) {
    //                             $uploadedFile->type = 'ppt';
    //                         } elseif (in_array($extension, ['docx', 'doc'])) {
    //                             $uploadedFile->type = 'docx';
    //                         } elseif (in_array($extension, ['pdf'])) {
    //                             $uploadedFile->type = 'pdf';
    //                         } else {
    //                             // You can handle other file types if needed
    //                             $uploadedFile->type = 'unknown';
    //                         }
    //                         $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
    //                         $path = $file->storeAs('sos_images', $uploadedImage, ['disk' => 's3']);
    //                         $uploadedFile->url = "https://storage.kacihelp.com/" . $path;
    //                         $uploadedFiles[] = $uploadedFile;
    //                     }

    //                     $input['images'] = json_encode($uploadedFiles);
    //                 }
    //                 if ($request->coordinate) {

    //                     $coordinatesString = $request->coordinate;
    //                     $coordinatesArray = json_decode($coordinatesString, true);


    //                     if (is_array($coordinatesArray) && isset($coordinatesArray['latitude'])) {
    //                         $latitude = $coordinatesArray['latitude'];
    //                     } else {
    //                         $latitude = null;
    //                     }
    //                     if (is_array($coordinatesArray) && isset($coordinatesArray['longitude'])) {
    //                         $longitude = $coordinatesArray['longitude'];
    //                     } else {
    //                         $longitude = null;
    //                     }

    //                     if ($latitude != null && $longitude != null) {
    //                         $embed_link = "https://www.google.com/maps/embed/v1/view?key=YOUR_API_KEY&center={latitude},{longitude}&zoom=18&maptype=satellite";

    //                         $final_link = str_replace(
    //                             ['{latitude}', '{longitude}', 'YOUR_API_KEY'],
    //                             [$latitude, $longitude, 'AIzaSyCfxiXntIfBzrcRCETjXcLk_Akq0Qyv2j4'],
    //                             $embed_link
    //                         );
    //                         $input['map'] = '';
    //                     }

    //                     $input['coordinate'] = json_encode($request->coordinate);
    //                 }
    
    //                 $input['ksn'] = $user->ksn;
    //                 $input['user_id'] = $user->id;
    //                 $input['name'] = $user->firstname;
    //                 $input['email'] = $user->email;
    //                 $input['phone_number'] = $user->phone_number;
    //                 $input['device'] = $user->device_name;


    //                 $country = Location::where('location', '=', $input['location'])->first();

    //                 $input['country'] = $country->country;
    //                 $model = Sos::latest()->first(); // Replace 1 with the actual ID of your record

    //                 if ($model) {

    //                     // Extract the numeric part of the code and increment it by 1
    //                     $numericPart = (int) substr($model->reference_code, 4) + 1;

    //                     // Combine it with the non-numeric part and update the code field
    //                     $model->reference_code = substr($model->code, 0, 4) . str_pad($numericPart, 10, '0', STR_PAD_LEFT);
    //                     $ref_code = $model->reference_code;
    //                     $input['reference_code'] = 'KHEY' . $ref_code;
    //                 } else {
    //                     $input['reference_code'] = 'KHEY' . '0000000001';
    //                 }

    //                 $ambulance = Sos::create($input);
    //                 $activity = Activity::create([
    //                     'user_id' => $user->id,
    //                     'type_id' => $ambulance->id,
    //                     'type' => 'emergency',
    //                 ]);

    //                 if ($user->device_name === 'Android') {
    //                     $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
    //                     $user['new_id'] = $new_id;
    //                 } elseif ($user->device_name === 'IOS') {
    //                     $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
    //                     $user['new_id'] = $new_id;
    //                 }
    //                 $sub = Sub_Admin::all();
    //                 if ($sub->count() > 0) {
    //                     foreach ($sub as $a) {
    //                         $admin_notification = Admin_Notification::create([
    //                             'user_id' => $user->id,
    //                             'u_id' => $user['new_id'],
    //                             'notification' => 'New Emergency Request',
    //                             'name' => $user->firstname,
    //                             'status' => 'Unread',
    //                             'sub_admin_id' => $a->id
    //                         ]);
    //                     }
    //                 }


    //                 $auto_reply = Auto_Reply::where('type', '=', 'emergency')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();
    //                 if ($auto_reply) {
    //                     $response = $auto_reply->description;
    //                     $save_reply = Response::create(
    //                         [
    //                             'user_id' => $user->id,
    //                             'type_id' => $ambulance->id,
    //                             'type' => 'emergency',
    //                             'response' => $response,
    //                             'admin_name' => 'Admin',
    //                             'status' => 'unseen'
    //                         ]
    //                     );
    //                 }
    //                 $dependant = Dependant::where('user_id', '=', $user->id)->get();
    //                 $map = '';
    //                 if ($dependant->count() > 0) {
    //                     $count = 0;
    //                     foreach ($dependant as $d) {
    //                         if ($count >= 2) {
    //                             break;
    //                         }

    //                         $dependentname = $d->name;

    //                         $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
    //                         $ambulance['line'] = 'Your Dependent' . ' ' . $user->firstname . ' ' . $user->lastname;
    //                         try {

    //                             if ($user->language === "English") {
    //                                 Mail::to($d->email)->send(new Emergency($user, $map, $dependentname, $ambulance));
    //                             } else if ($user->language === "Arabic") {
    //                                 Mail::to($d->email)->send(new ArabicEmergency($user, $map, $dependentname, $ambulance));
    //                             } else if ($user->language === "Yoruba") {
    //                                 Mail::to($d->email)->send(new YorubaEmergency($user, $map, $dependentname, $ambulance));
    //                             } else if ($user->language === "Chinese") {
    //                                 Mail::to($d->email)->send(new ChineseEmergency($user, $map, $dependentname, $ambulance));
    //                             } else if ($user->language === "Igbo") {
    //                                 Mail::to($d->email)->send(new IgboEmergency($user, $map, $dependentname, $ambulance));
    //                             } else if ($user->language === "French") {
    //                                 Mail::to($d->email)->send(new FrenchEmergency($user, $map, $dependentname, $ambulance));
    //                             } else if ($user->language === "Fula") {
    //                                 Mail::to($d->email)->send(new FulaEmergency($user, $map, $dependentname, $ambulance));
    //                             } else if ($user->language === "Portuguese") {
    //                                 Mail::to($d->email)->send(new PortugueseEmergency($user, $map, $dependentname, $ambulance));
    //                             } else if ($user->language === "Spanish") {
    //                                 Mail::to($d->email)->send(new SpanishEmergency($user, $map, $dependentname, $ambulance));
    //                             } else if ($user->language === "Hausa") {
    //                                 Mail::to($d->email)->send(new HausaEmergency($user, $map, $dependentname, $ambulance));
    //                             } else {
    //                                 Mail::to($d->email)->send(new Emergency($user, $map, $dependentname, $ambulance));
    //                             }
    //                         } catch (TransportException $e) {
    //                             $success['data'] = $ambulance;
    //                             $success['status'] = 200;
    //                             return response()->json(['success' => $success], $this->successStatus);
    //                         }
    //                         $country = General_Countries::where('country_name', '=', $d->country)->first();
    //                         $phone_number = $d->phone_number;
    //                         $country_code = $country->country_code;
    //                         $countryCode = preg_replace('/[^0-9]/', '', $country_code);
    //                         $number = $countryCode . $phone_number;


    //                         $link = $ambulance['link'];
    //                         try {


    //                             $apiKey = '987eec7ae6024a5cca4d1087671678e7';
    //                             $apiEndpoint = 'http://api.gupshup.io/sm/api/v1/template/msg';

    //                             // Replace these values with your actual data
    //                             $source = '2348140040081';
    //                             $destination =  $number;
    //                             $templateId = 'b8ea8351-f93b-4218-bd0e-25ae08a04626';
    //                             $templateParams = ["*$d->name*", "*$user->firstname $user->lastname*", "$link"];

    //                             // Create a Guzzle client
    //                             $client = new \GuzzleHttp\Client();

    //                             // Prepare the request parameters
    //                             $params = [
    //                                 'headers' => [
    //                                     'apikey' => $apiKey,
    //                                     'Content-Type' => 'application/x-www-form-urlencoded',
    //                                 ],
    //                                 'form_params' => [
    //                                     'source' => $source,
    //                                     'destination' => $destination,
    //                                     'template' => json_encode(['id' => $templateId, 'params' => $templateParams]),
    //                                 ],
    //                             ];

    //                             // Make the POST request
    //                             $response = $client->post($apiEndpoint, $params);

    //                             // Get the response body as a string
    //                             $responseBody = $response->getBody()->getContents();
    //                         } catch (\Exception $e) {
    //                             return response()->json(['message' => 'An error occurred while sending the Whatsapp']);
    //                         }

    //                         try {

    //                             $curl = curl_init();
    //                             $data = array(
    //                                 "api_key" => "TLsWe5NjzlDfhPVWCaPHbrnj9ggcUXlL81WYn15lhysyUjblgRQeSsLr9eAnY7",
    //                                 "to" => $number,
    //                                 "from" => "N-Alert",
    //                                 "sms" => "Dear $d->name, Your dependent $user->firstname $user->lastname is in an emergency; follow this link to view the details:  $link ",
    //                                 "type" => "plain",
    //                                 "channel" => "dnd"
    //                             );

    //                             $post_data = json_encode($data);

    //                             curl_setopt_array($curl, array(
    //                                 CURLOPT_URL => "https://api.ng.termii.com/api/sms/send",
    //                                 CURLOPT_RETURNTRANSFER => true,
    //                                 CURLOPT_ENCODING => "",
    //                                 CURLOPT_MAXREDIRS => 10,
    //                                 CURLOPT_TIMEOUT => 0,
    //                                 CURLOPT_FOLLOWLOCATION => true,
    //                                 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //                                 CURLOPT_CUSTOMREQUEST => "POST",
    //                                 CURLOPT_POSTFIELDS => $post_data,
    //                                 CURLOPT_HTTPHEADER => array(
    //                                     "Content-Type: application/json"
    //                                 ),
    //                             ));

    //                             $response = curl_exec($curl);

    //                             curl_close($curl);

    //                             \Log::info('sos:' . $response);
    //                         } catch (\Exception $e) {
    //                             return response()->json(['message' => 'An error occurred while sending the SMS']);
    //                         }
    //                         $count++;
    //                     }
    //                 }


    //             $agency = Agencies::where('title', '=', $input['target_agency'])->first();
    //             $sub_account = Sub_Account::where('agency_id', '=', $agency->id)->first();
                
    //             $admin_notification = Agency_Notification::create([
    //                             'user_id' => $user->id,
    //                             'u_id' => $user['new_id'],
    //                             'notification' => 'New Emergency Request',
    //                             'name' => $user->firstname,
    //                             'status' => 'Unread',
    //                             'agency_id' => $sub_account->id
    //                         ]);

    //                 if ($agency) {
    //                     try {
    //                         if ($agency->head_email1 != null) {
    //                             $image = json_decode($ambulance->images);
    //                             $dependentname = $agency->title;

    //                             $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
    //                             $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ')';

    //                             Mail::to($agency->head_email1)->send(new Emergency($user, $map, $dependentname, $ambulance));
    //                         }
    //                         if ($agency->head_email2 != null) {
    //                             $image = json_decode($ambulance->images);
    //                             $dependentname = $agency->title;

    //                             $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
    //                             $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ')';

    //                             Mail::to($agency->head_email2)->send(new Emergency($user, $map, $dependentname, $ambulance));
    //                         }
    //                         $location = json_decode($agency->location);
    //                         $count = 0;
    //                         $allLocationsEmailSent = false;
    //                         foreach ($location as $l) {
    //                             if ($l->location == $input['location']) {

    //                                 $image = json_decode($ambulance->images);
    //                                 $dependentname = $agency->title;

    //                                 $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
    //                                 $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ')';

    //                                 Mail::to($l->email)->send(new Emergency($user, $map, $dependentname, $ambulance));
    //                                 $count++;
    //                             } else if ($l->location == 'All Locations' && !$allLocationsEmailSent) {
    //                                 $image = json_decode($ambulance->images);
    //                                 $dependentname = $agency->title;

    //                                 $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
    //                                 $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ')';

    //                                 Mail::to($l->email)->send(new Emergency($user, $map, $dependentname, $ambulance));
    //                                 $allLocationsEmailSent = true;
    //                             }
    //                         }
    //                     } catch (TransportException $e) {
    //                         $success['data'] = $ambulance;
    //                         $success['status'] = 200;
    //                         return response()->json(['success' => $success], $this->successStatus);
    //                     }
    //                 }
    //                 $adminemail = Admin_Email::find(1);
    //                 if ($adminemail) {
    //                     try {
    //                         $email[] = $adminemail->email;

    //                         foreach ($email as $key => $value) {
    //                             $emailAddress = str_replace(['[', ']', '\\', '\"'], '', $value); // Remove unwanted characters
    //                             $emailAddress = explode(',', $emailAddress); // Convert the string to an array

    //                             foreach ($emailAddress as $email) {
    //                                 $email = trim($email, "\""); // Remove double quotes from the email address
    //                                 $dependentname = 'Admin';

    //                                 $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
    //                                 $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ')';

    //                                 Mail::to($email)->send(new Emergency($user, $map, $dependentname, $ambulance));

    //                                 $mail[] = $email;
    //                             }
    //                         }
    //                     } catch (TransportException $e) {

    //                         $success['data'] = $ambulance;
    //                         $success['status'] = 200;
    //                         return response()->json(['success' => $success], $this->successStatus);
    //                     }
    //                 }
    //                 $used_code->status = 'InActive';
    //                 $used_code->save();
    //                 $success['data'] = $ambulance;
    //                 $success['status'] = 200;
    //                 return response()->json(['success' => $success], $this->successStatus);
    //             } else {
    //                 $success['status'] = 400;
    //                 $success['message'] = 'Complete your Profile or Add Atleast 2 dependant';
    //                 return response()->json(['error' => $success]);
    //             }
    //         } else {

    //             $success['status'] = 150;
    //             return response()->json(['error' => $success]);
    //         }
    //     }

    // }





 public function store_sos(Request $request, $id)
    {
        $user = User::find($id);

    $latest = Sos::where('user_id', '=', $user->id)->whereDate('created_at', '>=', now()->subDays(7))->count();
    
    $code = Used_Code::where('user_id', $user->id)->where('status', 'Active')->first();
    
    if ($code) {
        $kaci_code = Kaci_Code::where('code', $code->code)->first();
    }

 
    $moduleRequestLimit = $kaci_code->emergnecy_requests;

    if ($latest >= $moduleRequestLimit) {
        $error['status'] = 400;
        $error['message'] = 'Your week limit is reached';
        return response()->json(['error' => $error]);
    }
    

        if ($moduleRequestLimit > $latest) {
            $validator = Validator::make($request->all(), [
                'location' => 'required',
                'address' => 'required',
                'target_agency' => 'required',
                'map' => 'nullable',
                'coordinate' => 'nullable',

            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }


            $input = $request->all();

            if ($user->ksn != null) {
                if ($request->images) {
                    $uploadedFiles = [];

                    foreach ($request->file('images') as $file) {
                        $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

                        $extension = $file->extension(); // Get the file extension

                        // Determine the type of the file based on its extension
                        if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                            $uploadedFile->type = 'image';
                        } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
                            $uploadedFile->type = 'video';
                        } elseif (in_array($extension, ['mp3', 'ogg'])) {
                            $uploadedFile->type = 'audio';
                        } elseif (in_array($extension, ['pptx', 'ppt'])) {
                            $uploadedFile->type = 'ppt';
                        } elseif (in_array($extension, ['docx', 'doc'])) {
                            $uploadedFile->type = 'docx';
                        } elseif (in_array($extension, ['pdf'])) {
                            $uploadedFile->type = 'pdf';
                        } else {
                            // You can handle other file types if needed
                            $uploadedFile->type = 'unknown';
                        }
                        $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
                        $path = $file->storeAs('sos_images', $uploadedImage, ['disk' => 's3']);
                        $uploadedFile->url = "https://storage.kacihelp.com/sos_images/" . $path;
                        // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);

                        $uploadedFiles[] = $uploadedFile;
                    }

                    $input['images'] = json_encode($uploadedFiles);
                }
                if ($request->coordinate) {

                    $coordinatesString = $request->coordinate;
                    $coordinatesArray = json_decode($coordinatesString, true);

                    // Check if $coordinatesArray is an array before accessing the 'latitude'
                    if (is_array($coordinatesArray) && isset($coordinatesArray['latitude'])) {
                        $latitude = $coordinatesArray['latitude'];
                    } else {
                        $latitude = null;
                    }
                    if (is_array($coordinatesArray) && isset($coordinatesArray['longitude'])) {
                        $longitude = $coordinatesArray['longitude'];
                    } else {
                        $longitude = null;
                    }

                    if ($latitude != null && $longitude != null) {
                        $embed_link = "https://www.google.com/maps/embed/v1/view?key=YOUR_API_KEY&center={latitude},{longitude}&zoom=18&maptype=satellite";

                        // Replace the placeholders with actual values
                        $final_link = str_replace(
                            ['{latitude}', '{longitude}', 'YOUR_API_KEY'],
                            [$latitude, $longitude, 'AIzaSyCfxiXntIfBzrcRCETjXcLk_Akq0Qyv2j4'],
                            $embed_link
                        );
                        $input['map'] = '';
                    }

                    // Ensure the 'latitude' key is present in the 'coordinate' JSON object
                    $input['coordinate'] = json_encode($request->coordinate);
                }
    



                $input['ksn'] = $user->ksn;
                $input['user_id'] = $user->id;
                $input['name'] = $user->firstname;
                $input['email'] = $user->email;
                $input['phone_number'] = $user->phone_number;
                $input['device'] = $user->device_name;

                $country = Location::where('location', '=', $input['location'])->first();
                $input['country'] = $country->country;
                $model = Sos::latest()->first(); // Replace 1 with the actual ID of your record

                if ($model) {

                    // Extract the numeric part of the code and increment it by 1
                    $numericPart = (int) substr($model->reference_code, 4) + 1;

                    // Combine it with the non-numeric part and update the code field
                    $model->reference_code = substr($model->code, 0, 4) . str_pad($numericPart, 10, '0', STR_PAD_LEFT);
                    $ref_code = $model->reference_code;
                    $input['reference_code'] = 'KHEY' . $ref_code;
                } else {
                    $input['reference_code'] = 'KHEY' . '0000000001';
                }

                $ambulance = Sos::create($input);
                $activity = Activity::create([
                    'user_id' => $user->id,
                    'type_id' => $ambulance->id,
                    'type' => 'emergency',
                ]);

                if ($user->device_name === 'Android') {
                    $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                    $user['new_id'] = $new_id;
                } elseif ($user->device_name === 'IOS') {
                    $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                    $user['new_id'] = $new_id;
                }

                $sub = Sub_Admin::all();
                if ($sub->count() > 0) {
                    foreach ($sub as $a) {
                        $admin_notification = Admin_Notification::create([
                            'user_id' => $user->id,
                            'u_id' => $user['new_id'],
                            'notification' => 'New Emergency Request',
                            'name' => $user->firstname,
                            'status' => 'Unread',
                            'sub_admin_id' => $a->id
                        ]);
                    }
                }
                $auto_reply = Auto_Reply::where('type', '=', 'emergency')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();
                if ($auto_reply) {
                    $response = $auto_reply->description;
                    $save_reply = Response::create(
                        [
                            'user_id' => $user->id,
                            'type_id' => $ambulance->id,
                            'type' => 'emergency',
                            'response' => $response,
                            'admin_name' => 'Admin',
                            'status' => 'unseen'
                        ]
                    );
                }


                $dependant = Dependant::where('user_id', '=', $user->id)->get();
                $map = '';
                if ($dependant->count() > 0) {
                    $count = 0;
                    foreach ($dependant as $d) {
                        if ($count >= 2) {
                            break;
                        }

                        // Your code here


                        $dependentname = $d->name;

                        $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
                        $ambulance['line'] = 'Your Dependent' . ' ' . $user->firstname . ' ' . $user->lastname;

                        try {

                            if ($user->language === "English") {
                                Mail::to($d->email)->send(new Emergency($user, $map, $dependentname, $ambulance));
                            } else if ($user->language === "Arabic") {
                                Mail::to($d->email)->send(new ArabicEmergency($user, $map, $dependentname, $ambulance));
                            } else if ($user->language === "Yoruba") {
                                Mail::to($d->email)->send(new YorubaEmergency($user, $map, $dependentname, $ambulance));
                            } else if ($user->language === "Chinese") {
                                Mail::to($d->email)->send(new ChineseEmergency($user, $map, $dependentname, $ambulance));
                            } else if ($user->language === "Igbo") {
                                Mail::to($d->email)->send(new IgboEmergency($user, $map, $dependentname, $ambulance));
                            } else if ($user->language === "French") {
                                Mail::to($d->email)->send(new FrenchEmergency($user, $map, $dependentname, $ambulance));
                            } else if ($user->language === "Fula") {
                                Mail::to($d->email)->send(new FulaEmergency($user, $map, $dependentname, $ambulance));
                            } else if ($user->language === "Portuguese") {
                                Mail::to($d->email)->send(new PortugueseEmergency($user, $map, $dependentname, $ambulance));
                            } else if ($user->language === "Spanish") {
                                Mail::to($d->email)->send(new SpanishEmergency($user, $map, $dependentname, $ambulance));
                            } else if ($user->language === "Hausa") {
                                Mail::to($d->email)->send(new HausaEmergency($user, $map, $dependentname, $ambulance));
                            } else {
                                Mail::to($d->email)->send(new Emergency($user, $map, $dependentname, $ambulance));
                            }
                        } catch (TransportException $e) {
                            $success['data'] = $ambulance;
                            $success['status'] = 200;
                            return response()->json(['success' => $success], $this->successStatus);
                        }

                        $country = General_Countries::where('country_name', '=', $d->country)->first();
                        $phone_number = $d->phone_number;
                        $country_code = $country->country_code;
                        $countryCode = preg_replace('/[^0-9]/', '', $country_code);
                        $number = $countryCode . $phone_number;


                        $link = $ambulance['link'];
                        try {

                            $apiKey = '987eec7ae6024a5cca4d1087671678e7';
                            $apiEndpoint = 'http://api.gupshup.io/sm/api/v1/template/msg';

                            // Replace these values with your actual data
                            $source = '2348140040081';
                            $destination =  $number;
                            $templateId = 'b8ea8351-f93b-4218-bd0e-25ae08a04626';
                            $templateParams = ["*$d->name*", "*$user->firstname $user->lastname*", "$link"];

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
                            return response()->json(['message' => 'An error occurred while sending the Whatsapp']);
                        }

                        try {

                            $curl = curl_init();
                            $data = array(
                                "api_key" => "TLsWe5NjzlDfhPVWCaPHbrnj9ggcUXlL81WYn15lhysyUjblgRQeSsLr9eAnY7",
                                "to" => $number,
                                "from" => "N-Alert",
                                "sms" => "Dear $d->name, Your dependent $user->firstname $user->lastname is in an emergency; follow this link to view the details:  $link ",
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

                            \Log::info('sos:' . $response);
                        } catch (\Exception $e) {
                            return response()->json(['message' => 'An error occurred while sending the SMS']);
                        }
                        $count++;
                    }
                }

                $agency = Agencies::where('title', '=', $input['target_agency'])->first();
                // $sub_account = Sub_Account::where('agency_id','=', $agency->id)->first();
                
                 $admin_notification = Agency_Notification::create([
                                'user_id' => $user->id,
                                'u_id' => $user['new_id'],
                                'notification' => 'New Emergency Request',
                                'name' => $user->firstname,
                                'status' => 'Unread',
                                'agency_id' => $agency->id,
                                'type' => 'emergency'
                            ]);

                if ($agency) {
                    try {
                        if ($agency->head_email1 != null) {
                            $image = json_decode($ambulance->images);
                            $dependentname = $agency->title;

                            $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
                            $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ')';

                            Mail::to($agency->head_email1)->send(new Emergency($user, $map, $dependentname, $ambulance));
                        }
                        if ($agency->head_email2 != null) {
                            $image = json_decode($ambulance->images);
                            $dependentname = $agency->title;

                            $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
                            $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ')';

                            Mail::to($agency->head_email2)->send(new Emergency($user, $map, $dependentname, $ambulance));
                        }
                        $location = json_decode($agency->location);
                        $count = 0;
                        $allLocationsEmailSent = false;
                        foreach ($location as $l) {
                            if ($l->location == $input['location']) {
                                $image = json_decode($ambulance->images);
                                $dependentname = $agency->title;

                                $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
                                $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ')';
                                Mail::to($l->email)->send(new Emergency($user, $map, $dependentname, $ambulance));
                                $count++;
                            } else if ($l->location == 'All Locations' && !$allLocationsEmailSent) {
                                $image = json_decode($ambulance->images);
                                $dependentname = $agency->title;

                                $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
                                $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ')';
                                Mail::to($l->email)->send(new Emergency($user, $map, $dependentname, $ambulance));
                                $allLocationsEmailSent = true;
                            }
                        }
                    } catch (TransportException $e) {
                        $success['data'] = $ambulance;
                        $success['status'] = 200;
                        return response()->json(['success' => $success], $this->successStatus);
                    }
                }
                $adminemail = Admin_Email::find(1);
                if ($adminemail) {
                    try {

                        $email[] = $adminemail->email;

                        foreach ($email as $key => $value) {
                            $emailAddress = str_replace(['[', ']', '\\', '\"'], '', $value); // Remove unwanted characters
                            $emailAddress = explode(',', $emailAddress); // Convert the string to an array

                            foreach ($emailAddress as $email) {
                                $email = trim($email, "\""); // Remove double quotes from the email address
                                $dependentname = 'Admin';

                                $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
                                $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ')';

                                Mail::to($email)->send(new Emergency($user, $map, $dependentname, $ambulance));

                                $mail[] = $email;
                            }
                        }
                    } catch (TransportException $e) {
                        $success['data'] = $ambulance;
                        $success['status'] = 200;
                        return response()->json(['success' => $success], $this->successStatus);
                    }
                }
                $success['data'] = $ambulance;
                $success['status'] = 200;
                return response()->json(['success' => $success], $this->successStatus);
            } else {
                $success['status'] = 400;
                $success['message'] = 'Complete your Profile or Add Atleast 2 dependant';
                return response()->json(['error' => $success]);
            }
            
            
        } else {
            $used_code = Used_Code::where('user_id', '=', $user->id)->where('status', '=', 'Active')->first();
            if ($used_code) {
                $validator = Validator::make($request->all(), [
                    'location' => 'required',
                    'address' => 'required',
                    'target_agency' => 'required',
                    'map' => 'nullable',

                    'coordinate' => 'nullable',

                ]);

                if ($validator->fails()) {
                    return response()->json(['error' => $validator->errors()], 401);
                }


                $input = $request->all();

                if ($user->ksn != null) {
                    if ($request->images) {
                        $uploadedFiles = [];

                        foreach ($request->file('images') as $file) {
                            $uploadedFile = new \stdClass(); 
                            $extension = $file->extension();
                            if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                                $uploadedFile->type = 'image';
                            } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
                                $uploadedFile->type = 'video';
                            } elseif (in_array($extension, ['mp3', 'ogg'])) {
                                $uploadedFile->type = 'audio';
                            } elseif (in_array($extension, ['pptx', 'ppt'])) {
                                $uploadedFile->type = 'ppt';
                            } elseif (in_array($extension, ['docx', 'doc'])) {
                                $uploadedFile->type = 'docx';
                            } elseif (in_array($extension, ['pdf'])) {
                                $uploadedFile->type = 'pdf';
                            } else {
                                // You can handle other file types if needed
                                $uploadedFile->type = 'unknown';
                            }
                            $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
                            $path = $file->storeAs('sos_images', $uploadedImage, ['disk' => 's3']);
                            $uploadedFile->url = "https://storage.kacihelp.com/sos_images" . $path;
                            $uploadedFiles[] = $uploadedFile;
                        }

                        $input['images'] = json_encode($uploadedFiles);
                    }
                    if ($request->coordinate) {

                        $coordinatesString = $request->coordinate;
                        $coordinatesArray = json_decode($coordinatesString, true);


                        if (is_array($coordinatesArray) && isset($coordinatesArray['latitude'])) {
                            $latitude = $coordinatesArray['latitude'];
                        } else {
                            $latitude = null;
                        }
                        if (is_array($coordinatesArray) && isset($coordinatesArray['longitude'])) {
                            $longitude = $coordinatesArray['longitude'];
                        } else {
                            $longitude = null;
                        }

                        if ($latitude != null && $longitude != null) {
                            $embed_link = "https://www.google.com/maps/embed/v1/view?key=YOUR_API_KEY&center={latitude},{longitude}&zoom=18&maptype=satellite";

                            $final_link = str_replace(
                                ['{latitude}', '{longitude}', 'YOUR_API_KEY'],
                                [$latitude, $longitude, 'AIzaSyCfxiXntIfBzrcRCETjXcLk_Akq0Qyv2j4'],
                                $embed_link
                            );
                            $input['map'] = '';
                        }

                        $input['coordinate'] = json_encode($request->coordinate);
                    }
    
                    $input['ksn'] = $user->ksn;
                    $input['user_id'] = $user->id;
                    $input['name'] = $user->firstname;
                    $input['email'] = $user->email;
                    $input['phone_number'] = $user->phone_number;
                    $input['device'] = $user->device_name;


                    $country = Location::where('location', '=', $input['location'])->first();

                    $input['country'] = $country->country;
                    $model = Sos::latest()->first(); // Replace 1 with the actual ID of your record

                    if ($model) {

                        // Extract the numeric part of the code and increment it by 1
                        $numericPart = (int) substr($model->reference_code, 4) + 1;

                        // Combine it with the non-numeric part and update the code field
                        $model->reference_code = substr($model->code, 0, 4) . str_pad($numericPart, 10, '0', STR_PAD_LEFT);
                        $ref_code = $model->reference_code;
                        $input['reference_code'] = 'KHEY' . $ref_code;
                    } else {
                        $input['reference_code'] = 'KHEY' . '0000000001';
                    }

                    $ambulance = Sos::create($input);
                    $activity = Activity::create([
                        'user_id' => $user->id,
                        'type_id' => $ambulance->id,
                        'type' => 'emergency',
                    ]);

                    if ($user->device_name === 'Android') {
                        $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                        $user['new_id'] = $new_id;
                    } elseif ($user->device_name === 'IOS') {
                        $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                        $user['new_id'] = $new_id;
                    }
                    $sub = Sub_Admin::all();
                    if ($sub->count() > 0) {
                        foreach ($sub as $a) {
                            $admin_notification = Admin_Notification::create([
                                'user_id' => $user->id,
                                'u_id' => $user['new_id'],
                                'notification' => 'New Emergency Request',
                                'name' => $user->firstname,
                                'status' => 'Unread',
                                'sub_admin_id' => $a->id
                            ]);
                        }
                    }


                    $auto_reply = Auto_Reply::where('type', '=', 'emergency')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();
                    if ($auto_reply) {
                        $response = $auto_reply->description;
                        $save_reply = Response::create(
                            [
                                'user_id' => $user->id,
                                'type_id' => $ambulance->id,
                                'type' => 'emergency',
                                'response' => $response,
                                'admin_name' => 'Admin',
                                'status' => 'unseen'
                            ]
                        );
                    }
                    $dependant = Dependant::where('user_id', '=', $user->id)->get();
                    $map = '';
                    if ($dependant->count() > 0) {
                        $count = 0;
                        foreach ($dependant as $d) {
                            if ($count >= 2) {
                                break;
                            }

                            $dependentname = $d->name;

                            $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
                            $ambulance['line'] = 'Your Dependent' . ' ' . $user->firstname . ' ' . $user->lastname;
                            try {

                                if ($user->language === "English") {
                                    Mail::to($d->email)->send(new Emergency($user, $map, $dependentname, $ambulance));
                                } else if ($user->language === "Arabic") {
                                    Mail::to($d->email)->send(new ArabicEmergency($user, $map, $dependentname, $ambulance));
                                } else if ($user->language === "Yoruba") {
                                    Mail::to($d->email)->send(new YorubaEmergency($user, $map, $dependentname, $ambulance));
                                } else if ($user->language === "Chinese") {
                                    Mail::to($d->email)->send(new ChineseEmergency($user, $map, $dependentname, $ambulance));
                                } else if ($user->language === "Igbo") {
                                    Mail::to($d->email)->send(new IgboEmergency($user, $map, $dependentname, $ambulance));
                                } else if ($user->language === "French") {
                                    Mail::to($d->email)->send(new FrenchEmergency($user, $map, $dependentname, $ambulance));
                                } else if ($user->language === "Fula") {
                                    Mail::to($d->email)->send(new FulaEmergency($user, $map, $dependentname, $ambulance));
                                } else if ($user->language === "Portuguese") {
                                    Mail::to($d->email)->send(new PortugueseEmergency($user, $map, $dependentname, $ambulance));
                                } else if ($user->language === "Spanish") {
                                    Mail::to($d->email)->send(new SpanishEmergency($user, $map, $dependentname, $ambulance));
                                } else if ($user->language === "Hausa") {
                                    Mail::to($d->email)->send(new HausaEmergency($user, $map, $dependentname, $ambulance));
                                } else {
                                    Mail::to($d->email)->send(new Emergency($user, $map, $dependentname, $ambulance));
                                }
                            } catch (TransportException $e) {
                                $success['data'] = $ambulance;
                                $success['status'] = 200;
                                return response()->json(['success' => $success], $this->successStatus);
                            }
                            $country = General_Countries::where('country_name', '=', $d->country)->first();
                            $phone_number = $d->phone_number;
                            $country_code = $country->country_code;
                            $countryCode = preg_replace('/[^0-9]/', '', $country_code);
                            $number = $countryCode . $phone_number;


                            $link = $ambulance['link'];
                            try {


                                $apiKey = '987eec7ae6024a5cca4d1087671678e7';
                                $apiEndpoint = 'http://api.gupshup.io/sm/api/v1/template/msg';

                                // Replace these values with your actual data
                                $source = '2348140040081';
                                $destination =  $number;
                                $templateId = 'b8ea8351-f93b-4218-bd0e-25ae08a04626';
                                $templateParams = ["*$d->name*", "*$user->firstname $user->lastname*", "$link"];

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
                                    "sms" => "Dear $d->name, Your dependent $user->firstname $user->lastname is in an emergency; follow this link to view the details:  $link ",
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

                                \Log::info('sos:' . $response);
                            } catch (\Exception $e) {
                                return response()->json(['message' => 'An error occurred while sending the SMS']);
                            }
                            $count++;
                        }
                    }


                $agency = Agencies::where('title', '=', $input['target_agency'])->first();
                // $sub_account = Sub_Account::where('agency_id', '=', $agency->id)->first();
                
                $admin_notification = Agency_Notification::create([
                                'user_id' => $user->id,
                                'u_id' => $user['new_id'],
                                'notification' => 'New Emergency Request',
                                'name' => $user->firstname,
                                'status' => 'Unread',
                                 'agency_id' => $agency->id,
                                'type' => 'emergency'
                            ]);

                    if ($agency) {
                        try {
                            if ($agency->head_email1 != null) {
                                $image = json_decode($ambulance->images);
                                $dependentname = $agency->title;

                                $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
                                $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ')';

                                Mail::to($agency->head_email1)->send(new Emergency($user, $map, $dependentname, $ambulance));
                            }
                            if ($agency->head_email2 != null) {
                                $image = json_decode($ambulance->images);
                                $dependentname = $agency->title;

                                $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
                                $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ')';

                                Mail::to($agency->head_email2)->send(new Emergency($user, $map, $dependentname, $ambulance));
                            }
                            $location = json_decode($agency->location);
                            $count = 0;
                            $allLocationsEmailSent = false;
                            foreach ($location as $l) {
                                if ($l->location == $input['location']) {

                                    $image = json_decode($ambulance->images);
                                    $dependentname = $agency->title;

                                    $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
                                    $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ')';

                                    Mail::to($l->email)->send(new Emergency($user, $map, $dependentname, $ambulance));
                                    $count++;
                                } else if ($l->location == 'All Locations' && !$allLocationsEmailSent) {
                                    $image = json_decode($ambulance->images);
                                    $dependentname = $agency->title;

                                    $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
                                    $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ')';

                                    Mail::to($l->email)->send(new Emergency($user, $map, $dependentname, $ambulance));
                                    $allLocationsEmailSent = true;
                                }
                            }
                        } catch (TransportException $e) {
                            $success['data'] = $ambulance;
                            $success['status'] = 200;
                            return response()->json(['success' => $success], $this->successStatus);
                        }
                    }
                    $adminemail = Admin_Email::find(1);
                    if ($adminemail) {
                        try {
                            $email[] = $adminemail->email;

                            foreach ($email as $key => $value) {
                                $emailAddress = str_replace(['[', ']', '\\', '\"'], '', $value); // Remove unwanted characters
                                $emailAddress = explode(',', $emailAddress); // Convert the string to an array

                                foreach ($emailAddress as $email) {
                                    $email = trim($email, "\""); // Remove double quotes from the email address
                                    $dependentname = 'Admin';

                                    $ambulance['link'] = "https://kacihelp.com/emergency/$ambulance->reference_code";
                                    $ambulance['line'] = $user->firstname . ' ' . $user->lastname . ' ' . '(KSN:' . ' ' . $user->ksn . ')';

                                    Mail::to($email)->send(new Emergency($user, $map, $dependentname, $ambulance));

                                    $mail[] = $email;
                                }
                            }
                        } catch (TransportException $e) {

                            $success['data'] = $ambulance;
                            $success['status'] = 200;
                            return response()->json(['success' => $success], $this->successStatus);
                        }
                    }
                    $used_code->status = 'InActive';
                    $used_code->save();
                    $success['data'] = $ambulance;
                    $success['status'] = 200;
                    return response()->json(['success' => $success], $this->successStatus);
                } else {
                    $success['status'] = 400;
                    $success['message'] = 'Complete your Profile or Add Atleast 2 dependant';
                    return response()->json(['error' => $success]);
                }
            } else {

                $success['status'] = 150;
                return response()->json(['error' => $success]);
            }
        }

    }








    public function store_report(Request $request, $id)
    {
        $user = User::find($id);
        $found = Report::where('user_id', '=', $user->id)->latest()->first();
        if ($found) {
            if ($found->status === 'Resolved' || $found->status === 'Deleted') {
                $validator = Validator::make($request->all(), [
                    'location' => 'required',
                    'address' => 'required',
                    'date' => 'required',
                    'time' => 'required',
                    'subject' => 'required', 
                    'details' => 'required',
                    'anonymous' => 'required',
                    'target_agency' => 'required',
                ]);

                if ($validator->fails()) {
                    return response()->json(['error' => $validator->errors()], 401);
                }

                $input = $request->all();

                if ($request->images) {
                    $uploadedFiles = [];

                    foreach ($request->file('images') as $file) {
                        $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

                        $extension = $file->extension(); // Get the file extension

                        if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                            $uploadedFile->type = 'image';
                        } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
                            $uploadedFile->type = 'video';
                        } elseif (in_array($extension, ['mp3', 'ogg'])) {
                            $uploadedFile->type = 'audio';
                        } elseif (in_array($extension, ['pptx', 'ppt'])) {
                            $uploadedFile->type = 'ppt';
                        } elseif (in_array($extension, ['docx', 'doc'])) {
                            $uploadedFile->type = 'docx';
                        } elseif (in_array($extension, ['pdf'])) {
                            $uploadedFile->type = 'pdf';
                        } else {
                            // You can handle other file types if needed
                            $uploadedFile->type = 'unknown';
                        }
                        $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
                        $path = $file->storeAs('report_images', $uploadedImage, ['disk' => 's3']);
                        $uploadedFile->url = "https://storage.kacihelp.com/report_images" . $path;
                        // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
                        $uploadedFiles[] = $uploadedFile;
                    }

                    $input['images'] = json_encode($uploadedFiles);
                }
                if ($request->map) {

                    $coordinatesString = $request->map;
                    $coordinatesArray = json_decode($coordinatesString, true);

                    // Check if $coordinatesArray is an array before accessing the 'latitude'
                    if (is_array($coordinatesArray) && isset($coordinatesArray['latitude'])) {
                        $latitude = $coordinatesArray['latitude'];
                    } else {
                        $latitude = null;
                    }
                    if (is_array($coordinatesArray) && isset($coordinatesArray['longitude'])) {
                        $longitude = $coordinatesArray['longitude'];
                    } else {
                        $longitude = null;
                    }

                    if ($latitude != null && $longitude != null) {
                        $embed_link = "https://www.google.com/maps/search/?api=1&query={latitude}%2C{longitude}";

                        // Replace the placeholders with actual values
                        $final_link = str_replace(
                            ['{latitude}', '{longitude}'],
                            [$latitude, $longitude],
                            $embed_link
                        );

                        $map = $final_link;

                        $input['map_link'] = $map;
                    }
                    // Ensure the 'latitude' key is present in the 'coordinate' JSON object
                    $input['map'] = json_encode($request->map);
                } else {
                    $latitude = null;
                    $longitude = null;
                }
                if ($user->ksn != null) {
                    $input['ksn'] = $user->ksn;
                }
                $input['user_id'] = $user->id;
                $input['name'] = $user->firstname;
                $input['email'] = $user->email;
                $input['phone_number'] = $user->phone_number;
                $input['device'] = $user->device_name;

                $country = Location::where('location', '=', $input['location'])->first();
                $input['country'] = $country->country;


                $model = Report::latest()->first(); // Replace 1 with the actual ID of your record

                if ($model) {

                    // Extract the numeric part of the code and increment it by 1
                    $numericPart = (int) substr($model->reference_code, 4) + 1;

                    // Combine it with the non-numeric part and update the code field
                    $model->reference_code = substr($model->code, 0, 4) . str_pad($numericPart, 10, '0', STR_PAD_LEFT);
                    $ref_code = $model->reference_code;
                    $input['reference_code'] = 'KHIT' . $ref_code;
                } else {
                    $input['reference_code'] = 'KHIT' . '0000000001';
                }
                $ambulance = Report::create($input);
                $activity = Activity::create([
                    'user_id' => $user->id,
                    'type_id' => $ambulance->id,
                    'type' => 'report',
                ]);

                if ($user->device_name === 'Android') {
                    $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                    $user['new_id'] = $new_id;
                } elseif ($user->device_name === 'IOS') {
                    $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                    $user['new_id'] = $new_id;
                }
                $sub = Sub_Admin::all();
                if ($sub->count() > 0) {
                    foreach ($sub as $a) {
                        $admin_notification = Admin_Notification::create([
                            'user_id' => $user->id,
                            'u_id' => $user['new_id'],
                            'notification' => 'New Report Request',
                            'name' => $user->firstname,
                            'status' => 'Unread',
                            'sub_admin_id' => $a->id
                        ]);
                    }
                }
                $auto_reply = Auto_Reply::where('type', '=', 'report')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();
                if ($auto_reply) {
                    $response = $auto_reply->description;
                    $save_reply = Response::create(
                        [
                            'user_id' => $user->id,
                            'type_id' => $ambulance->id,
                            'type' => 'report',
                            'response' => $response,
                            'admin_name' => 'Admin',
                            'status' => 'unseen'
                        ]
                    );
                }
                $image = json_decode($ambulance->images);
                $agency = Agencies::where('title', '=', $input['target_agency'])->first();
                $sub_account = Sub_Account::where('agency_id', '=', $agency_id)->first();
                
                
                  $admin_notification = Agency_Notification::create([
                            'user_id' => $user->id,
                            'u_id' => $user['new_id'],
                            'notification' => 'New Report Request',
                            'name' => $user->firstname,
                            'agency_id' => $agency->id,
                            'type' => 'ireport'
                        ]);

                try {
                    if ($agency) {
                        if ($agency->head_email1 != null) {

                            $dependentname = $agency->title;



                            Mail::to($agency->head_email1)->send(new ReportMail($user, $dependentname, $ambulance, $image));
                        }
                        if ($agency->head_email2 != null) {

                            $dependentname = $agency->title;



                            Mail::to($agency->head_email2)->send(new ReportMail($user, $dependentname, $ambulance, $image));
                        }

                        $location = json_decode($agency->location);
                        $count = 0;
                        $allLocationsEmailSent = false;
                        foreach ($location as $l) {
                            if ($l->location == $input['location']) {

                                $dependentname = $agency->title;

                                Mail::to($l->email)->send(new ReportMail($user, $dependentname, $ambulance, $image));
                                $count++;
                            } else if ($l->location == 'All Locations' && !$allLocationsEmailSent) {
                                $dependentname = $agency->title;

                                Mail::to($l->email)->send(new ReportMail($user, $dependentname, $ambulance, $image));
                                $allLocationsEmailSent = true;
                            }
                        }
                    }
                } catch (TransportException $e) {
                    $success['data'] = $ambulance;
                    $success['status'] = 200;
                    return response()->json(['success' => $success], $this->successStatus);
                }
                $adminemail = Admin_Email::find(1);
                if ($adminemail) {
                    $ambulance['anonymous'] = 'No';
                    $email[] = $adminemail->email;

                    foreach ($email as $key => $value) {
                        $emailAddress = str_replace(['[', ']', '\\', '\"'], '', $value); // Remove unwanted characters
                        $emailAddress = explode(',', $emailAddress); // Convert the string to an array

                        foreach ($emailAddress as $email) {
                            $email = trim($email, "\""); // Remove double quotes from the email address
                            $dependentname = 'Admin';


                            Mail::to($email)->send(new ReportMail($user, $dependentname, $ambulance, $image));

                            $mail[] = $email;
                        }
                    }
                }
                $success['data'] = $ambulance;
                $success['status'] = 200;
                return response()->json(['success' => $success], $this->successStatus);
            } else {
                $success['status'] = 400;
                $success['message'] = 'Your previous Request in pending';
                return response()->json(['error' => $success]);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'location' => 'required',
                'address' => 'required',
                'date' => 'required',
                'time' => 'required',
                'subject' => 'required', // Allow image, video, doc, ppt, and pdf extensions
                'details' => 'required',
                'anonymous' => 'required',
                'target_agency' => 'required',


            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }


            $input = $request->all();


            if ($request->images) {
                $uploadedFiles = [];

                foreach ($request->file('images') as $file) {
                    $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

                    $extension = $file->extension(); // Get the file extension

                    if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                        $uploadedFile->type = 'image';
                    } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
                        $uploadedFile->type = 'video';
                    } elseif (in_array($extension, ['mp3', 'ogg'])) {
                        $uploadedFile->type = 'audio';
                    } elseif (in_array($extension, ['pptx', 'ppt'])) {
                        $uploadedFile->type = 'ppt';
                    } elseif (in_array($extension, ['docx', 'doc'])) {
                        $uploadedFile->type = 'docx';
                    } elseif (in_array($extension, ['pdf'])) {
                        $uploadedFile->type = 'pdf';
                    } else {
                        // You can handle other file types if needed
                        $uploadedFile->type = 'unknown';
                    }
                    $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
                    $path = $file->storeAs('report_images', $uploadedImage, ['disk' => 's3']);
                    $uploadedFile->url = "https://storage.kacihelp.com/report_images" . $path;
                    // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
                    $uploadedFiles[] = $uploadedFile;
                }

                $input['images'] = json_encode($uploadedFiles);
            }
            if ($request->map) {

                $coordinatesString = $request->map;
                $coordinatesArray = json_decode($coordinatesString, true);

                // Check if $coordinatesArray is an array before accessing the 'latitude'
                if (is_array($coordinatesArray) && isset($coordinatesArray['latitude'])) {
                    $latitude = $coordinatesArray['latitude'];
                } else {
                    $latitude = null;
                }
                if (is_array($coordinatesArray) && isset($coordinatesArray['longitude'])) {
                    $longitude = $coordinatesArray['longitude'];
                } else {
                    $longitude = null;
                }

                if ($latitude != null && $longitude != null) {
                    $embed_link = "https://www.google.com/maps/search/?api=1&query={latitude}%2C{longitude}";

                    // Replace the placeholders with actual values
                    $final_link = str_replace(
                        ['{latitude}', '{longitude}'],
                        [$latitude, $longitude],
                        $embed_link
                    );

                    $map = $final_link;

                    $input['map_link'] = $map;
                }
                // Ensure the 'latitude' key is present in the 'coordinate' JSON object
                $input['map'] = json_encode($request->map);
            } else {
                $latitude = null;
                $longitude = null;
            }
            if ($user->ksn != null) {
                $input['ksn'] = $user->ksn;
            }
            $input['user_id'] = $user->id;
            $input['name'] = $user->firstname;
            $input['email'] = $user->email;
            $input['phone_number'] = $user->phone_number;
            $input['device'] = $user->device_name;

            $country = Location::where('location', '=', $input['location'])->first();
            $input['country'] = $country->country;


            $model = Report::latest()->first(); // Replace 1 with the actual ID of your record

            if ($model) {

                // Extract the numeric part of the code and increment it by 1
                $numericPart = (int) substr($model->reference_code, 4) + 1;

                // Combine it with the non-numeric part and update the code field
                $model->reference_code = substr($model->code, 0, 4) . str_pad($numericPart, 10, '0', STR_PAD_LEFT);
                $ref_code = $model->reference_code;
                $input['reference_code'] = 'KHIT' . $ref_code;
            } else {
                $input['reference_code'] = 'KHIT' . '0000000001';
            }
            $ambulance = Report::create($input);
            $activity = Activity::create([
                'user_id' => $user->id,
                'type_id' => $ambulance->id,
                'type' => 'report',
            ]);

            if ($user->device_name === 'Android') {
                $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                $user['new_id'] = $new_id;
            } elseif ($user->device_name === 'IOS') {
                $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                $user['new_id'] = $new_id;
            }
            $sub = Sub_Admin::all();
            if ($sub->count() > 0) {
                foreach ($sub as $a) {
                    $admin_notification = Admin_Notification::create([
                        'user_id' => $user->id,
                        'u_id' => $user['new_id'],
                        'notification' => 'New Report Request',
                        'name' => $user->firstname,
                        'status' => 'Unread',
                        'sub_admin_id' => $a->id
                    ]);
                }
            }
            $auto_reply = Auto_Reply::where('type', '=', 'report')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();
            if ($auto_reply) {
                $response = $auto_reply->description;
                $save_reply = Response::create(
                    [
                        'user_id' => $user->id,
                        'type_id' => $ambulance->id,
                        'type' => 'report',
                        'response' => $response,
                        'admin_name' => 'Admin',
                        'status' => 'unseen'
                    ]
                );
            }
            $image = json_decode($ambulance->images);
            $agency = Agencies::where('title', '=', $input['target_agency'])->first();
            // $sub_account = Sub_Account::where('agency_id', '=', $agency->id)->first();
              $admin_notification = Agency_Notification::create([
                            'user_id' => $user->id,
                            'u_id' => $user['new_id'],
                            'notification' => 'New Report Request',
                            'name' => $user->firstname,
                            'status' => 'Unread',
                        'agency_id' => $agency->id,
                            'type' => 'ireport'
                        ]);
            try {

                if ($agency) {
                    if ($agency->head_email1 != null) {

                        $dependentname = $agency->title;



                        Mail::to($agency->head_email1)->send(new ReportMail($user, $dependentname, $ambulance, $image));
                    }
                    if ($agency->head_email2 != null) {

                        $dependentname = $agency->title;



                        Mail::to($agency->head_email2)->send(new ReportMail($user, $dependentname, $ambulance, $image));
                    }
                    $location = json_decode($agency->location);
                    $count = 0;
                    $allLocationsEmailSent = false;
                    foreach ($location as $l) {
                        if ($l->location == $input['location']) {

                            $dependentname = $agency->title;

                            Mail::to($l->email)->send(new ReportMail($user, $dependentname, $ambulance, $image));
                            $count++;
                        } else if ($l->location == 'All Locations' && !$allLocationsEmailSent) {
                            $dependentname = $agency->title;
                            Mail::to($l->email)->send(new ReportMail($user, $dependentname, $ambulance, $image));
                            $allLocationsEmailSent = true;
                        }
                    }
                }
            } catch (TransportException $e) {
                $success['data'] = $ambulance;
                $success['status'] = 200;
                return response()->json(['success' => $success], $this->successStatus);
            }
            try {
                $adminemail = Admin_Email::find(1);
                if ($adminemail) {
                    $ambulance['anonymous'] = 'No';
                    $email[] = $adminemail->email;

                    foreach ($email as $key => $value) {
                        $emailAddress = str_replace(['[', ']', '\\', '\"'], '', $value); // Remove unwanted characters
                        $emailAddress = explode(',', $emailAddress); // Convert the string to an array

                        foreach ($emailAddress as $email) {
                            $email = trim($email, "\""); // Remove double quotes from the email address
                            $dependentname = 'Admin';


                            Mail::to($email)->send(new ReportMail($user, $dependentname, $ambulance, $image));

                            $mail[] = $email;
                        }
                    }
                }
            } catch (TransportException $e) {
                $success['data'] = $ambulance;
                $success['status'] = 200;
                return response()->json(['success' => $success], $this->successStatus);
            }
            $success['data'] = $ambulance;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        }
    }


//   public function store_consult(Request $request, $id)
//     {
//         $user = User::find($id);
        
//         $found = Consult::where('user_id', '=', $user->id)->latest()->first();

//         if ($found) {
//             if ($found->status === 'Resolved' || $found->status === 'Deleted') {
//                 $validator = Validator::make($request->all(), [
//                     'location' => 'required',
//                     'agency' => 'required',
//                     'subject' => 'required',
//                     'description' => 'required',
//                     'anonymous' => 'required',
//                     'target_agency' => 'required',
//                     'country' => 'required'
//                 ]);

//                 if ($validator->fails()) {
//                     return response()->json(['error' => $validator->errors()], 401);
//                 }

//                 $input = $request->all();

//                 if ($request->images) {

//                     $uploadedFiles = [];

//                     foreach ($request->file('images') as $file) {
//                         $uploadedFile = new \stdClass();

//                         $extension = $file->extension();

//                         if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
//                             $uploadedFile->type = 'image';
//                         } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
//                             $uploadedFile->type = 'video';
//                         } elseif (in_array($extension, ['mp3', 'ogg'])) {
//                             $uploadedFile->type = 'audio';
//                         } elseif (in_array($extension, ['pptx', 'ppt'])) {
//                             $uploadedFile->type = 'ppt';
//                         } elseif (in_array($extension, ['docx', 'doc'])) {
//                             $uploadedFile->type = 'docx';
//                         } elseif (in_array($extension, ['pdf'])) {
//                             $uploadedFile->type = 'pdf';
//                         } else {

//                             $uploadedFile->type = 'unknown';
//                         }
//                         $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
//                         $path = $file->storeAs('consult_images', $uploadedImage, ['disk' => 's3']);
//                         $uploadedFile->url = "https://storage.kacihelp.com/" . $path;

//                         $uploadedFiles[] = $uploadedFile;
//                     }

//                     $input['images'] = json_encode($uploadedFiles);
//                 }

//                 $input['user_id'] = $user->id;
//                 $input['name'] = $user->firstname;
//                 $input['email'] = $user->email;
//                 $input['phone_number'] = $user->phone_number;
//                 $input['device'] = $user->device_name;
//                 $input['ksn'] = $user->ksn;

//                 $country = Location::where('location', '=', $input['location'])->first();
//                 $input['country'] = $country->country;
//                 $model = Consult::latest()->first();

//                 if ($model) {
//                     $numericPart = (int) substr($model->reference_code, 4) + 1;
//                     $model->reference_code = substr($model->code, 0, 4) . str_pad($numericPart, 10, '0', STR_PAD_LEFT);

//                     $ref_code = $model->reference_code;
//                     $input['reference_code'] = 'KHCN' . $ref_code;
//                 } else {
//                     $input['reference_code'] = 'KHCN' . '0000000001';
//                 }
//                 $ambulance = Consult::create($input);
                
//                 $activity = Activity::create([
//                     'user_id' => $user->id,
//                     'type_id' => $ambulance->id,
//                     'type' => 'consult',
//                 ]);

//                 if ($user->device_name === 'Android') {
//                     $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
//                     $user['new_id'] = $new_id;
//                 } elseif ($user->device_name === 'IOS') {
//                     $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
//                     $user['new_id'] = $new_id;
//                 }
//                 $sub = Sub_Admin::all();

//                 if ($sub->count() > 0) {
//                     foreach ($sub as $a) {
//                         $admin_notification = Admin_Notification::create([
//                             'user_id' => $user->id,
//                             'u_id' => $user['new_id'],
//                             'notification' => 'New Consult Request',
//                             'name' => $user->firstname,
//                             'status' => 'Unread',
//                             'sub_admin_id' => $a->id,
//                         ]);
//                     }
//                 }
                
                
//                 $auto_reply = Auto_Reply::where('type', '=', 'consult')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();
                
//                 if ($auto_reply) {

//                     $response = $auto_reply->description;

//                     $save_reply = Response::create(
//                         [
//                             'user_id' => $user->id,
//                             'type_id' => $ambulance->id,
//                             'type' => 'consult',
//                             'response' => $response,
//                             'admin_name' => 'Admin',
//                             'status' => 'unseen'
//                         ]
//                     );
//                 }
//                 $image = json_decode($ambulance->images);

//                 $agency = Agencies::where('title', '=', $input['target_agency'])->first();
                
//                 $sub_account = Sub_Account::where('agency_id', '=', $agency->id)->first();
                

//                 $admin_notification = Agency_Notification::create([
//                     'user_id' => $user->id,
//                     'u_id' => $user['new_id'],
//                     'notification' => 'New Consult Request',
//                     'name' => $user->firstname,
//                     'status' => 'Unread',
//                     'agency_id' => $sub_account->id
//                 ]);

//                 try {
//                     if ($agency) {
//                         if ($agency->head_email1 != null) {

//                             $dependentname = $agency->title;

//                             Mail::to($agency->head_email1)->send(new Consult($user, $dependentname, $ambulance, $image));
//                         }
//                         if ($agency->head_email2 != null) {

//                             $dependentname = $agency->title;
                            
//                             Mail::to($agency->head_email2)->send(new Consult($user, $dependentname, $ambulance,$image));
                            
//                         }

//                         $location = json_decode($agency->location);
//                         $count = 0;
                        
//                         $allLocationsEmailSent = false;
                        
//                         foreach ($location as $l) {
//                             if ($l->location == $input['location']) {

//                                 $dependentname = $agency->title;

//                                 Mail::to($l->email)->send(new ConsultMail($user, $dependentname, $ambulance, $image));
                                
//                                 $count++;
//                             } else if ($l->location == 'All Locations' && !$allLocationsEmailSent) {
//                                 $dependentname = $agency->title;

//                                 Mail::to($l->email)->send(new ConsultMail($user, $dependentname, $ambulance,$image));
//                                 $allLocationsEmailSent = true;
//                             }
//                         }
//                     }
//                 } catch (TransportException $e) {
//                     $success['data'] = $ambulance;
//                     $success['status'] = 200;
//                     return response()->json(['success' => $success], $this->successStatus);
//                 }
//                 $adminemail = Admin_Email::find(1);
//                 if ($adminemail) {
//                     $ambulance['anonymous'] = 'No';
//                     $email[] = $adminemail->email;

//                     foreach ($email as $key => $value) {
//                         $emailAddress = str_replace(['[', ']', '\\', '\"'], '', $value); // Remove unwanted characters
//                         $emailAddress = explode(',', $emailAddress); // Convert the string to an array

//                         foreach ($emailAddress as $email) {
//                             $email = trim($email, "\""); // Remove double quotes from the email address
//                             $dependentname = 'Admin';
                            
//                             Mail::to($email)->send(new ConsultMail($user, $dependentname, $ambulance, $image));

//                             $mail[] = $email;
//                         }
//                     }
//                 }
//                 $success['data'] = $ambulance;
//                 $success['status'] = 200;
//                 return response()->json(['success' => $success], $this->successStatus);
                
//             } else {
//                 $success['status'] = 400;
//                 $success['message'] = 'Your previous Request in pending';
//                 return response()->json(['error' => $success]);
//             }
            
//         } else {

//             $used_code = Used_Code::where('user_id', '=', $user->id)->where('status', '=', 'Active')->first();

//             if ($used_code) {

//                 $validator = Validator::make($request->all(), [
//                     'location' => 'required',
//                     'agency' => 'required',
//                     'subject' => 'required',
//                     'description' => 'required',
//                     'anonymous' => 'required',
//                     'target_agency' => 'required',
//                     'country' => 'required'


//                 ]);

//                 if ($validator->fails()) {
//                     return response()->json(['error' => $validator->errors()], 401);
//                 }


//                 $input  =  $request->all();


//                 if ($request->images) {
//                     $uploadedFiles = [];

//                     foreach ($request->file('images') as $file) {
//                         $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

//                         $extension = $file->extension(); // Get the file extension

//                         if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
//                             $uploadedFile->type = 'image';
//                         } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
//                             $uploadedFile->type = 'video';
//                         } elseif (in_array($extension, ['mp3', 'ogg'])) {
//                             $uploadedFile->type = 'audio';
//                         } elseif (in_array($extension, ['pptx', 'ppt'])) {
//                             $uploadedFile->type = 'ppt';
//                         } elseif (in_array($extension, ['docx', 'doc'])) {
//                             $uploadedFile->type = 'docx';
//                         } elseif (in_array($extension, ['pdf'])) {
//                             $uploadedFile->type = 'pdf';
//                         } else {
//                             // You can handle other file types if needed
//                             $uploadedFile->type = 'unknown';
//                         }
//                         $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
//                         $path = $file->storeAs('consult_images', $uploadedImage, ['disk' => 's3']);
//                         $uploadedFile->url = "https://storage.kacihelp.com/" . $path;
//                         // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
//                         $uploadedFiles[] = $uploadedFile;
//                     }

//                     $input['images'] = json_encode($uploadedFiles);
//                 }
//                 $input['user_id'] = $user->id;
//                 $input['name'] = $user->firstname;
//                 $input['email'] = $user->email;
//                 $input['phone_number'] = $user->phone_number;
//                 $input['device'] = $user->device_name;
//                 $input['ksn'] = $user->ksn;

//                 $country = Location::where('location', '=', $input['location'])->first();
//                 $input['country'] = $country->country;


//                 $model = Consult::latest()->first(); // Replace 1 with the actual ID of your record

//                 if ($model) {
//                     $numericPart = (int) substr($model->reference_code, 4) + 1;
//                     $model->reference_code = substr($model->code, 0, 4) . str_pad($numericPart, 10, '0', STR_PAD_LEFT);
//                     $ref_code = $model->reference_code;
//                     $input['reference_code'] = 'KHCN' . $ref_code;
//                 } else {
//                     $input['reference_code'] = 'KHCN' . '0000000001';
//                 }
//                 $ambulance = Consult::create($input);


//                 $activity = Activity::create([
//                     'user_id' => $user->id,
//                     'type_id' => $ambulance->id,
//                     'type' => 'consult',
//                 ]);

//                 if ($user->device_name === 'Android') {

//                     $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
//                     $user['new_id'] = $new_id;
//                 } elseif ($user->device_name === 'IOS') {

//                     $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
//                     $user['new_id'] = $new_id;
//                 }


//                 $sub = Sub_Admin::all();
//                 if ($sub->count() > 0) {


//                     foreach ($sub as $a) {
//                         $admin_notification = Admin_Notification::create([
//                             'user_id' => $user->id,
//                             'u_id' => $user['new_id'],
//                             'notification' => 'New consult Request',
//                             'name' => $user->firstname,
//                             'status' => 'Unread',
//                             'sub_admin_id' => $a->id
//                         ]);
//                     }
//                 }

//                 $auto_reply = Auto_Reply::where('type', '=', 'consult')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();

//                 if ($auto_reply) {
//                     $response = $auto_reply->description;
//                     $save_reply = Response::create(
//                         [
//                             'user_id' => $user->id,
//                             'type_id' => $ambulance->id,
//                             'type' => 'consult',
//                             'response' => $response,
//                             'admin_name' => 'Admin',
//                             'status' => 'unseen'
//                         ]
//                     );
//                 }
//                 $image = json_decode($ambulance->images);

//                 $agency = Agencies::where('title', '=', $input['target_agency'])->first();

//                 $sub_account = Sub_Account::where('agency_id', '=', $agency->id)->first();
                

//                 $admin_notification = Agency_Notification::create([
//                     'user_id' => $user->id,
//                     'u_id' => $user['new_id'],
//                     'notification' => 'New Consult Request',
//                     'name' => $user->firstname,
//                     'status' => 'Unread',
//                     'agency_id' => $sub_account->id,
//                 ]);

//                 try {

//                     if ($agency) {


//                         if ($agency->head_email1 != null) {

//                             $dependentname = $agency->title;

//                             Mail::to($agency->head_email1)->send(new ConsultMail($user, $dependentname, $ambulance, $image));
//                         }

//                         if ($agency->head_email2 != null) {

//                             $dependentname = $agency->title;

//                             Mail::to($agency->head_email2)->send(new ConsultMail($user, $dependentname, $ambulance, $image));
//                         }


//                         $location = json_decode($agency->location);
//                         $count = 0;
//                         $allLocationsEmailSent = false;
//                         foreach ($location as $l) {
//                             if ($l->location == $input['location']) {

//                                 $dependentname = $agency->title;

//                                 Mail::to($l->email)->send(new ConsultMail($user, $dependentname, $ambulance, $image));
//                                 $count++;
//                             } else if ($l->location == 'All Locations' && !$allLocationsEmailSent) {
//                                 $dependentname = $agency->title;
//                                 Mail::to($l->email)->send(new ConsultMail($user, $dependentname, $ambulance, $image));
//                                 $allLocationsEmailSent = true;
//                             }
//                         }
//                     }
//                 } catch (TransportException $e) {
//                     $success['data'] = $ambulance;
//                     $success['status'] = 200;
//                     return response()->json(['success' => $success], $this->successStatus);
//                 }



//                 try {
//                     $adminemail = Admin_Email::find(1);


//                     if ($adminemail) {

//                         $ambulance['anonymous'] = 'No';

//                         $email[] = $adminemail->email;

//                         foreach ($email as $key => $value) {

//                             $emailAddress = str_replace(['[', ']', '\\', '\"'], '', $value); // Remove unwanted characters

//                             $emailAddress = explode(',', $emailAddress); // Convert the string to an array

//                             foreach ($emailAddress as $email) {
//                                 $email = trim($email, "\""); // Remove double quotes from the email address
//                                 $dependentname = 'Admin';


//                                 Mail::to($email)->send(new ConsultMail($user, $dependentname, $ambulance, $image));

//                                 $mail[] = $email;
//                             }
//                         }
//                     }
//                 } catch (TransportException $e) {
//                     $success['data'] = $ambulance;
//                     $success['status'] = 200;
//                     return response()->json(['success' => $success], $this->successStatus);
//                 }
//                 $success['data'] = $ambulance;
//                 $success['status'] = 200;
//                 return response()->json(['success' => $success], $this->successStatus);
//             } else {

//                 $success['status'] = 400;
//                 $success['message'] = 'Kaci code is required';

//                 return response()->json(['error' => $success]);
//             }
//         }
//     }
    
    
    
    
    
    
    
    
    
public function store_consult(Request $request, $id)
{
    $user = User::find($id);
    
    $latest = Consult::where('user_id', '=', $user->id)->whereDate('created_at', '>=', now()->subDays(7))->count();
    
    $code = Used_Code::where('user_id', $user->id)->where('status', 'Active')->first();
    
    if ($code) {
        $kaci_code = Kaci_Code::where('code', $code->code)->first();
    }

 
    $moduleRequestLimit = $kaci_code->consultation_requests;

    if ($latest >= $moduleRequestLimit) {
        $error['status'] = 400;
        $error['message'] = 'Your week limit is reached';
        return response()->json(['error' => $error]);
    }
    
    
    
    $found = Consult::where('user_id', '=', $user->id)->latest()->first();

    if ($found) {
        if ($found->status === 'Resolved' || $found->status === 'Deleted') {
            $validator = Validator::make($request->all(), [
                'location' => 'required',
                'agency' => 'required',
                'subject' => 'required',
                'description' => 'required',
                'anonymous' => 'required',
                'target_agency' => 'required',
                'country' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }

            $input = $request->all();

            if ($request->images) {
                $uploadedFiles = [];

                foreach ($request->file('images') as $file) {
                    $uploadedFile = new \stdClass();

                    $extension = $file->extension();

                    if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                        $uploadedFile->type = 'image';
                    } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
                        $uploadedFile->type = 'video';
                    } elseif (in_array($extension, ['mp3', 'ogg'])) {
                        $uploadedFile->type = 'audio';
                    } elseif (in_array($extension, ['pptx', 'ppt'])) {
                        $uploadedFile->type = 'ppt';
                    } elseif (in_array($extension, ['docx', 'doc'])) {
                        $uploadedFile->type = 'docx';
                    } elseif (in_array($extension, ['pdf'])) {
                        $uploadedFile->type = 'pdf';
                    } else {
                        $uploadedFile->type = 'unknown';
                    }
                    $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
                    $path = $file->storeAs('consult_images', $uploadedImage, ['disk' => 's3']);
                    $uploadedFile->url = "https://storage.kacihelp.com/consult_images" . $path;

                    $uploadedFiles[] = $uploadedFile;
                }

                $input['images'] = json_encode($uploadedFiles);
            }

            $input['user_id'] = $user->id;
            $input['name'] = $user->firstname;
            $input['email'] = $user->email;
            $input['phone_number'] = $user->phone_number;
            $input['device'] = $user->device_name;
            $input['ksn'] = $user->ksn;

            $country = Location::where('location', '=', $input['location'])->first();
            $input['country'] = $country->country;
            $model = Consult::latest()->first();

            if ($model) {
                $numericPart = (int) substr($model->reference_code, 4) + 1;
                $model->reference_code = substr($model->code, 0, 4) . str_pad($numericPart, 10, '0', STR_PAD_LEFT);

                $ref_code = $model->reference_code;
                $input['reference_code'] = 'KHCN' . $ref_code;
            } else {
                $input['reference_code'] = 'KHCN' . '0000000001';
            }
            $ambulance = Consult::create($input);
            
            $activity = Activity::create([
                'user_id' => $user->id,
                'type_id' => $ambulance->id,
                'type' => 'consult',
            ]);

            if ($user->device_name === 'Android') {
                $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                $user['new_id'] = $new_id;
            } elseif ($user->device_name === 'IOS') {
                $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                $user['new_id'] = $new_id;
            }
            $sub = Sub_Admin::all();

            if ($sub->count() > 0) {
                foreach ($sub as $a) {
                    $admin_notification = Admin_Notification::create([
                        'user_id' => $user->id,
                        'u_id' => $user['new_id'],
                        'notification' => 'New Consult Request',
                        'name' => $user->firstname,
                        'status' => 'Unread',
                        'sub_admin_id' => $a->id,
                    ]);
                }
            }
            
            $auto_reply = Auto_Reply::where('type', '=', 'consult')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();
            
            if ($auto_reply) {
                $response = $auto_reply->description;

                $save_reply = Response::create(
                    [
                        'user_id' => $user->id,
                        'type_id' => $ambulance->id,
                        'type' => 'consult',
                        'response' => $response,
                        'admin_name' => 'Admin',
                        'status' => 'unseen'
                    ]
                );
            }
            $image = json_decode($ambulance->images);

            $agency = Agencies::where('title', '=', $input['target_agency'])->first();
            
            // $sub_account = Sub_Account::where('agency_id', '=', $agency->id)->first();
            

            $admin_notification = Agency_Notification::create([
                'user_id' => $user->id,
                'u_id' => $user['new_id'],
                'notification' => 'New Consult Request',
                'name' => $user->firstname,
                'status' => 'Unread',
                'agency_id' => $agency->id,
                'type' => 'consultation',
            ]);

            try {
                if ($agency) {
                    if ($agency->head_email1 != null) {
                        $dependentname = $agency->title;

                        Mail::to($agency->head_email1)->send(new ConsultMail($user, $dependentname, $ambulance, $image));
                    }
                    if ($agency->head_email2 != null) {
                        $dependentname = $agency->title;
                        
                        Mail::to($agency->head_email2)->send(new ConsultMail($user, $dependentname, $ambulance,$image));
                        
                    }

                    $location = json_decode($agency->location);
                    $count = 0;
                    
                    $allLocationsEmailSent = false;
                    
                    foreach ($location as $l) {
                        if ($l->location == $input['location']) {
                            $dependentname = $agency->title;

                            Mail::to($l->email)->send(new ConsultMail($user, $dependentname, $ambulance, $image));
                            
                            $count++;
                        } else if ($l->location == 'All Locations' && !$allLocationsEmailSent) {
                            $dependentname = $agency->title;

                            Mail::to($l->email)->send(new ConsultMail($user, $dependentname, $ambulance,$image));
                            $allLocationsEmailSent = true;
                        }
                    }
                }
            } catch (TransportException $e) {
                $success['data'] = $ambulance;
                $success['status'] = 200;
                $success['message'] = 'Consultation Store successfully';
                return response()->json(['success' => $success], $this->successStatus);
            }
            $adminemail = Admin_Email::find(1);
            if ($adminemail) {
                $ambulance['anonymous'] = 'No';
                $email[] = $adminemail->email;

                foreach ($email as $key => $value) {
                    $emailAddress = str_replace(['[', ']', '\\', '\"'], '', $value); // Remove unwanted characters
                    $emailAddress = explode(',', $emailAddress); // Convert the string to an array

                    foreach ($emailAddress as $email) {
                        $email = trim($email, "\""); // Remove double quotes from the email address
                        $dependentname = 'Admin';
                        
                        Mail::to($email)->send(new ConsultMail($user, $dependentname, $ambulance, $image));

                        $mail[] = $email;
                    }
                }
            }
            $success['data'] = $ambulance;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $error['status'] = 400;
            $error['message'] = 'Your previous request is still pending';
            return response()->json(['error' => $error]);
        }
        
        
    } else {
        
          $used_code = Used_Code::where('user_id', '=', $user->id)->where('status', '=', 'Active')->first();
          if(!$used_code){
              
              $error['status'] = 400;
              $error['message'] = "Kaci code is required";
              
              
              return response()->json(['error' => $error ]);
          }
          
          
        $validator = Validator::make($request->all(), [
            'location' => 'required',
            'agency' => 'required',
            'subject' => 'required',
            'description' => 'required',
            'anonymous' => 'required',
            'target_agency' => 'required',
            'country' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();

        if ($request->images) {
            $uploadedFiles = [];

            foreach ($request->file('images') as $file) {
                $uploadedFile = new \stdClass();

                $extension = $file->extension();

                if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                    $uploadedFile->type = 'image';
                } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
                    $uploadedFile->type = 'video';
                } elseif (in_array($extension, ['mp3', 'ogg'])) {
                    $uploadedFile->type = 'audio';
                } elseif (in_array($extension, ['pptx', 'ppt'])) {
                    $uploadedFile->type = 'ppt';
                } elseif (in_array($extension, ['docx', 'doc'])) {
                    $uploadedFile->type = 'docx';
                } elseif (in_array($extension, ['pdf'])) {
                    $uploadedFile->type = 'pdf';
                } else {
                    $uploadedFile->type = 'unknown';
                }
                $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
                $path = $file->storeAs('consult_images', $uploadedImage, ['disk' => 's3']);
                $uploadedFile->url = "https://storage.kacihelp.com/consult_images" . $path;

                $uploadedFiles[] = $uploadedFile;
            }

            $input['images'] = json_encode($uploadedFiles);
        }

        $input['user_id'] = $user->id;
        $input['name'] = $user->firstname;
        $input['email'] = $user->email;
        $input['phone_number'] = $user->phone_number;
        $input['device'] = $user->device_name;
        $input['ksn'] = $user->ksn;

        $country = Location::where('location', '=', $input['location'])->first();
        $input['country'] = $country->country;
        $model = Consult::latest()->first();

        if ($model) {
            $numericPart = (int) substr($model->reference_code, 4) + 1;
            $model->reference_code = substr($model->code, 0, 4) . str_pad($numericPart, 10, '0', STR_PAD_LEFT);

            $ref_code = $model->reference_code;
            $input['reference_code'] = 'KHCN' . $ref_code;
        } else {
            $input['reference_code'] = 'KHCN' . '0000000001';
        }
        $ambulance = Consult::create($input);
        
        $activity = Activity::create([
            'user_id' => $user->id,
            'type_id' => $ambulance->id,
            'type' => 'consult',
        ]);

        if ($user->device_name === 'Android') {
            $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
            $user['new_id'] = $new_id;
        } elseif ($user->device_name === 'IOS') {
            $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
            $user['new_id'] = $new_id;
        }
        $sub = Sub_Admin::all();

        if ($sub->count() > 0) {
            foreach ($sub as $a) {
                $admin_notification = Admin_Notification::create([
                    'user_id' => $user->id,
                    'u_id' => $user['new_id'],
                    'notification' => 'New Consult Request',
                    'name' => $user->firstname,
                    'status' => 'Unread',
                    'sub_admin_id' => $a->id,
                ]);
            }
        }
        
        $auto_reply = Auto_Reply::where('type', '=', 'consult')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();
        
        if ($auto_reply) {
            $response = $auto_reply->description;

            $save_reply = Response::create(
                [
                    'user_id' => $user->id,
                    'type_id' => $ambulance->id,
                    'type' => 'consult',
                    'response' => $response,
                    'admin_name' => 'Admin',
                    'status' => 'unseen'
                ]
            );
        }
        $image = json_decode($ambulance->images);

        $agency = Agencies::where('title', '=', $input['target_agency'])->first();
        
        
        // $sub_account = Sub_Account::where('agency_id', '=', $agency->id)->first();
        
        

        $admin_notification = Agency_Notification::create([
            'user_id' => $user->id,
            'u_id' => $user['new_id'],
            'notification' => 'New Consult Request',
            'name' => $user->firstname,
            'status' => 'Unread',
            'agency_id' => $agency->id,
            'type' => 'consultation',
        ]);

        try {
            if ($agency) {
                if ($agency->head_email1 != null) {
                    $dependentname = $agency->title;

                    Mail::to($agency->head_email1)->send(new ConsultMail($user, $dependentname, $ambulance, $image));
                }
                if ($agency->head_email2 != null) {
                    $dependentname = $agency->title;
                    
                    Mail::to($agency->head_email2)->send(new ConsultMail($user, $dependentname, $ambulance,$image));
                    
                }

                $location = json_decode($agency->location);
                $count = 0;
                
                $allLocationsEmailSent = false;
                
                foreach ($location as $l) {
                    if ($l->location == $input['location']) {
                        $dependentname = $agency->title;

                        Mail::to($l->email)->send(new ConsultMail($user, $dependentname, $ambulance, $image));
                        
                        $count++;
                    } else if ($l->location == 'All Locations' && !$allLocationsEmailSent) {
                        $dependentname = $agency->title;

                        Mail::to($l->email)->send(new ConsultMail($user, $dependentname, $ambulance,$image));
                        $allLocationsEmailSent = true;
                    }
                }
            }
        } catch (TransportException $e) {
            $success['data'] = $ambulance;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        }
        $adminemail = Admin_Email::find(1);
        if ($adminemail) {
            $ambulance['anonymous'] = 'No';
            $email[] = $adminemail->email;

            foreach ($email as $key => $value) {
                $emailAddress = str_replace(['[', ']', '\\', '\"'], '', $value); // Remove unwanted characters
                $emailAddress = explode(',', $emailAddress); // Convert the string to an array

                foreach ($emailAddress as $email) {
                    $email = trim($email, "\""); // Remove double quotes from the email address
                    $dependentname = 'Admin';
                    
                    Mail::to($email)->send(new ConsultMail($user, $dependentname, $ambulance, $image));

                    $mail[] = $email;
                }
            }
        }
        $success['data'] = $ambulance;
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }
}


    public function store_suggestion(Request $request, $id)
    {
        $user = User::find($id);

        $found = Suggestion::where('user_id', '=', $user->id)->latest()->first();
        if ($found) {
            if ($found->status === 'Resolved' || $found->status === 'Deleted') {
                $validator = Validator::make($request->all(), [
                    'location' => 'required',

                    'problem_statement' => 'required',
                    'situation_suggestion' => 'required',
                    'target_agency' => 'required',
                    'desired_outcome' => 'required',


                ]);

                if ($validator->fails()) {
                    return response()->json(['error' => $validator->errors()], 401);
                }


                $input = $request->all();


                if ($request->images) {
                    $uploadedFiles = [];

                    foreach ($request->file('images') as $file) {
                        $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

                        $extension = $file->extension(); // Get the file extension

                        if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                            $uploadedFile->type = 'image';
                        } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
                            $uploadedFile->type = 'video';
                        } elseif (in_array($extension, ['mp3'])) {
                            $uploadedFile->type = 'audio';
                        } elseif (in_array($extension, ['pptx'])) {
                            $uploadedFile->type = 'ppt';
                        } elseif (in_array($extension, ['docx'])) {
                            $uploadedFile->type = 'docx';
                        } elseif (in_array($extension, ['pdf'])) {
                            $uploadedFile->type = 'pdf';
                        } else {
                            // You can handle other file types if needed
                            $uploadedFile->type = 'unknown';
                        }
                        $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
                        $path = $file->storeAs('suggestion_images', $uploadedImage, ['disk' => 's3']);
                        $uploadedFile->url = "https://storage.kacihelp.com/suggestion_images" . $path;
                        // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
                        $uploadedFiles[] = $uploadedFile;
                    }

                    $input['images'] = json_encode($uploadedFiles);
                }
                if ($user->ksn != null) {
                    $input['ksn'] = $user->ksn;
                }

                $input['user_id'] = $user->id;
                $input['name'] = $user->firstname;
                $input['email'] = $user->email;
                $input['phone_number'] = $user->phone_number;
                $input['device'] = $user->device_name;

                $country = Location::where('location', '=', $input['location'])->first();
                $input['country'] = $country->country;
                $serialNumber = Suggestion::count() + 1;
                $input['reference_code'] = $this->generateReferenceCode('KHSN', $serialNumber);
                $ambulance = Suggestion::create($input);

                $activity = Activity::create([
                    'user_id' => $user->id,
                    'type_id' => $ambulance->id,
                    'type' => 'suggestion',
                ]);
                if ($user->device_name === 'Android') {
                    $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                    $user['new_id'] = $new_id;
                } elseif ($user->device_name === 'IOS') {
                    $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                    $user['new_id'] = $new_id;
                }
                $sub = Sub_Admin::all();
                if ($sub->count() > 0) {
                    foreach ($sub as $a) {
                        $admin_notification = Admin_Notification::create([
                            'user_id' => $user->id,
                            'u_id' => $user['new_id'],
                            'notification' => 'New Suggestion Request',
                            'name' => $user->firstname,
                            'status' => 'Unread',
                            'sub_admin_id' => $a->id
                        ]);
                    }
                }
                $auto_reply = Auto_Reply::where('type', '=', 'suggestion')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();
                if ($auto_reply) {
                    $response = $auto_reply->description;
                    $save_reply = Response::create(
                        [
                            'user_id' => $user->id,
                            'type_id' => $ambulance->id,
                            'type' => 'suggestion',
                            'response' => $response,
                            'admin_name' => 'Admin',
                        ]
                    );
                }

                $image = json_decode($ambulance->images);
                $agency = Agencies::where('title', '=', $input['target_agency'])->first();
                
                // $sub_account = Sub_Account::where('agency_id', '=', $agency_id)->first();
                $admin_notification = Agency_Notification::create([
                            'user_id' => $user->id,
                            'u_id' => $user['new_id'],
                            'notification' => 'New Suggestion Request',
                            'name' => $user->firstname,
                            'status' => 'Unread',
                            'agency_id' => $agency->id,
                            'type' => 'suggestion'
                        ]);
                
                try {
                    if ($agency) {
                        if ($agency->head_email1 != null) {

                            $dependentname = $agency->title;



                            Mail::to($agency->head_email1)->send(new SuggestionMail($user, $dependentname, $ambulance, $image));
                        }
                        if ($agency->head_email2 != null) {

                            $dependentname = $agency->title;



                            Mail::to($agency->head_email2)->send(new SuggestionMail($user, $dependentname, $ambulance, $image));
                        }
                        $location = json_decode($agency->location);
                        $count = 0;
                        $allLocationsEmailSent = false;
                        foreach ($location as $l) {
                            if ($l->location == $input['location']) {

                                $dependentname = $agency->title;

                                Mail::to($l->email)->send(new SuggestionMail($user, $dependentname, $ambulance, $image));
                                $count++;
                            } else if ($l->location == 'All Locations' && !$allLocationsEmailSent) {
                                $dependentname = $agency->title;

                                Mail::to($l->email)->send(new SuggestionMail($user, $dependentname, $ambulance, $image));
                                $allLocationsEmailSent = true;
                            }
                        }
                    }
                } catch (TransportException $e) {
                    $success['data'] = $ambulance;
                    $success['status'] = 200;
                    return response()->json(['success' => $success], $this->successStatus);
                }
                $adminemail = Admin_Email::find(1);
                try {
                    if ($adminemail) {
                        $email[] = $adminemail->email;

                        foreach ($email as $key => $value) {
                            $emailAddress = str_replace(['[', ']', '\\', '\"'], '', $value); // Remove unwanted characters
                            $emailAddress = explode(',', $emailAddress); // Convert the string to an array

                            foreach ($emailAddress as $email) {
                                $email = trim($email, "\""); // Remove double quotes from the email address
                                $dependentname = 'Admin';


                                Mail::to($email)->send(new SuggestionMail($user, $dependentname, $ambulance, $image));

                                $mail[] = $email;
                            }
                        }
                    }
                } catch (TransportException $e) {
                    $success['data'] = $ambulance;
                    $success['status'] = 200;
                    return response()->json(['success' => $success], $this->successStatus);
                }
                $success['data'] = $ambulance;
                $success['status'] = 200;
                return response()->json(['success' => $success], $this->successStatus);
            } else {
                $success['status'] = 400;
                $success['message'] = 'Your previous Request in pending';
                return response()->json(['error' => $success]);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'location' => 'required',

                'problem_statement' => 'required',
                'situation_suggestion' => 'required',
                'target_agency' => 'required',
                'desired_outcome' => 'required',


            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }


            $input = $request->all();


            if ($request->images) {
                $uploadedFiles = [];

                foreach ($request->file('images') as $file) {
                    $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

                    $extension = $file->extension(); // Get the file extension

                    if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                        $uploadedFile->type = 'image';
                    } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
                        $uploadedFile->type = 'video';
                    } elseif (in_array($extension, ['mp3'])) {
                        $uploadedFile->type = 'audio';
                    } elseif (in_array($extension, ['pptx'])) {
                        $uploadedFile->type = 'ppt';
                    } elseif (in_array($extension, ['docx'])) {
                        $uploadedFile->type = 'docx';
                    } elseif (in_array($extension, ['pdf'])) {
                        $uploadedFile->type = 'pdf';
                    } else {
                        // You can handle other file types if needed
                        $uploadedFile->type = 'unknown';
                    }
                    $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
                    $path = $file->storeAs('suggestion_images', $uploadedImage, ['disk' => 's3']);
                    $uploadedFile->url = "https://storage.kacihelp.com/suggestion_images" . $path;
                    // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
                    $uploadedFiles[] = $uploadedFile;
                }

                $input['images'] = json_encode($uploadedFiles);
            }
            if ($user->ksn != null) {
                $input['ksn'] = $user->ksn;
            }
            $input['user_id'] = $user->id;
            $input['name'] = $user->firstname;
            $input['email'] = $user->email;
            $input['phone_number'] = $user->phone_number;
            $input['device'] = $user->device_name;

            $country = Location::where('location', '=', $input['location'])->first();
            $input['country'] = $country->country;
            $serialNumber = Suggestion::count() + 1;
            $input['reference_code'] = $this->generateReferenceCode('KHSN', $serialNumber);
            $ambulance = Suggestion::create($input);

            $activity = Activity::create([
                'user_id' => $user->id,
                'type_id' => $ambulance->id,
                'type' => 'suggestion',
            ]);
            if ($user->device_name === 'Android') {
                $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                $user['new_id'] = $new_id;
            } elseif ($user->device_name === 'IOS') {
                $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                $user['new_id'] = $new_id;
            }
            $sub = Sub_Admin::all();
            if ($sub->count() > 0) {
                foreach ($sub as $a) {
                    $admin_notification = Admin_Notification::create([
                        'user_id' => $user->id,
                        'u_id' => $user['new_id'],
                        'notification' => 'New Suggestion Request',
                        'name' => $user->firstname,
                        'status' => 'Unread',
                        'sub_admin_id' => $a->id
                    ]);
                }
            }
            $auto_reply = Auto_Reply::where('type', '=', 'suggestion')->where('language', '=', $user->language)->where('status', '=', 'Activated')->first();
            if ($auto_reply) {
                $response = $auto_reply->description;
                $save_reply = Response::create(
                    [
                        'user_id' => $user->id,
                        'type_id' => $ambulance->id,
                        'type' => 'suggestion',
                        'response' => $response,
                        'admin_name' => 'Admin',
                    ]
                );
            }

            $image = json_decode($ambulance->images);
            
            
            $agency = Agencies::where('title', '=', $input['target_agency'])->first();
            // $sub_account = Sub_Account::where('agency_id', '=', $agency->id)->first();
            $admin_notification = Agency_Notification::create([
                        'user_id' => $user->id,
                        'u_id' => $user['new_id'],
                        'notification' => 'New Suggestion Request',
                        'name' => $user->firstname,
                        'status' => 'Unread',
                        'agency_id' => $agency->id,
                            'type' => 'suggestion'
                    ]);
                    
                    
            try {
                if ($agency) {
                    if ($agency->head_email1 != null) {

                        $dependentname = $agency->title;



                        Mail::to($agency->head_email1)->send(new SuggestionMail($user, $dependentname, $ambulance, $image));
                    }
                    if ($agency->head_email2 != null) {

                        $dependentname = $agency->title;



                        Mail::to($agency->head_email2)->send(new SuggestionMail($user, $dependentname, $ambulance, $image));
                    }
                    $location = json_decode($agency->location);
                    $allLocationsEmailSent = false;
                    foreach ($location as $l) {
                        if ($l->location == $input['location']) {

                            $dependentname = $agency->title;

                            Mail::to($l->email)->send(new SuggestionMail($user, $dependentname, $ambulance, $image));
                            $count++;
                        } else if ($l->location == 'All Locations' && !$allLocationsEmailSent) {
                            $dependentname = $agency->title;

                            Mail::to($l->email)->send(new SuggestionMail($user, $dependentname, $ambulance, $image));
                            $allLocationsEmailSent = true;
                        }
                    }
                }
            } catch (TransportException $e) {
                $success['data'] = $ambulance;
                $success['status'] = 200;
                return response()->json(['success' => $success], $this->successStatus);
            }
            $adminemail = Admin_Email::find(1);
            if ($adminemail) {
                $email[] = $adminemail->email;

                foreach ($email as $key => $value) {
                    $emailAddress = str_replace(['[', ']', '\\', '\"'], '', $value); // Remove unwanted characters
                    $emailAddress = explode(',', $emailAddress); // Convert the string to an array

                    foreach ($emailAddress as $email) {
                        $email = trim($email, "\""); // Remove double quotes from the email address
                        $dependentname = 'Admin';


                        Mail::to($email)->send(new SuggestionMail($user, $dependentname, $ambulance, $image));

                        $mail[] = $email;
                    }
                }
            }
            $success['data'] = $ambulance;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        }
    }
    
    public function store_climate(Request $request, $id)
    {
        $user = User::find($id);
        $validator = Validator::make($request->all(), [

            'question.*.type' => 'required',
            'question.*.question' => 'required',
            'question.*.kg' => 'required',
            'question.*.action' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $questions = $request->input('question');
        $questionsJson = json_encode($questions);
        $total_kgs = 0;
        $yesCount = 0;
        $noCount = 0;
        $maybeCount = 0;

        $questions = $request->input('question');

        foreach ($questions as $question) {
            if (isset($question['kg'])) {

                $total_kgs += (float)$question['kg'];
            }

            if (isset($question['action'])) {
                switch ($question['action']) {
                    case 'yes':
                        $yesCount++;
                        break;
                    case 'no':
                        $noCount++;
                        break;
                    case 'maybe':
                        $maybeCount++;
                        break;
                        // Handle other cases if necessary
                }
            }
        }
        $climate = Climate::create([
            'user_id' => $user->id,
            'name' => $user->firstname,
            'question' => $questionsJson,
            'total' => $total_kgs,
            'resident_country' => $user->resident_country,
        ]);
        $climate['yesCount'] = $yesCount;
        $climate['noCount'] = $noCount;
        $climate['maybeCount'] = $maybeCount;
        $success['data'] = $climate;
        $success['status'] = 200;
        $success['message'] = 'Successfully';

        return response()->json(['success' => $success]);
    }
    
    
    public function show_climate()
    {
        $climate = Climate::all();
        foreach ($climate as $c) {
            $user = User::find($c->user_id);
            if ($user) {
                $c->firstname = $user->firstname;
                $c->lastname = $user->lastname;
                $c->phone_number = $user->phone_number;
                $c->profile_image = $user->profile_image;
                $c->country = $user->country;
                $country = General_Countries::where('country_name', '=', $c->country)->first();
                $c->country_code = $country->country_code;
                $c->email = $user->email;
                
                $verifyBadge = Used_code::where('user_id', $c->user_id)
                             ->where('expiry_date', '>', now())
                             ->first();
                $c->verify_badge = $verifyBadge ? true : false;
            }
        }
        $success['data'] = $climate;
        $success['status'] = 200;
        $success['message'] = 'Successfully';

        return response()->json(['success' => $success]);
    }
    
    public function delete_climate($id)
    {
        $climate = Climate::find($id);
        $climate->delete();
        $success['data'] = $climate;
        $success['status'] = 200;
        $success['message'] = 'Successfully';

        return response()->json(['success' => $success]);
    }
    
    public function show_id_climate($id)
    {
        $climate = Climate::find($id);
        $success['data'] = $climate;
        $success['status'] = 200;
        $success['message'] = 'Successfully';

        return response()->json(['success' => $success]);
    }

    public function show_action_climate(Request $request, $id)
    {
        $request->validate(['action' => 'required']);
        $climate = Climate::find($id);
        if ($request->input('action') === 'yes' && $climate) {
            // Convert the 'questions' JSON string to an array
            $questionsArray = json_decode($climate->question, true);

            // Filter the 'question' array to include only 'action' === 'yes' objects
            $filteredQuestions = array_filter($questionsArray, function ($question) {
                return isset($question['action']) && $question['action'] === 'yes';
            });

            // Replace the 'questions' property with the filtered 'question' array
            $climate->questions = array_values($filteredQuestions);
        } else if ($request->input('action') === 'no' && $climate) {
            $questionsArray = json_decode($climate->question, true);

            // Filter the 'question' array to include only 'action' === 'yes' objects
            $filteredQuestions = array_filter($questionsArray, function ($question) {
                return isset($question['action']) && $question['action'] === 'no';
            });

            // Replace the 'questions' property with the filtered 'question' array
            $climate->questions = array_values($filteredQuestions);
        } else if ($request->input('action') === 'maybe' && $climate) {
            $questionsArray = json_decode($climate->question, true);

            // Filter the 'question' array to include only 'action' === 'yes' objects
            $filteredQuestions = array_filter($questionsArray, function ($question) {
                return isset($question['action']) && $question['action'] === 'maybe';
            });

            // Replace the 'questions' property with the filtered 'question' array
            $climate->questions = array_values($filteredQuestions);
        }

        $success['data'] = $climate;
        $success['status'] = 200;
        $success['message'] = 'Successfully';

        return response()->json(['success' => $success]);
    }


    public function notify_status($id)
    {
        $user = User::find($id);
        if ($user) {
            if ($user->notify_status === 'Active') {
                $user->notify_status = 'InActive';
                $user->save();
                $success['data'] =  $user;
                $success['status'] = 200;
                $success['message'] = 'Notification Status inactive Successfully';

                return response()->json(['success' => $success]);
            } else {
                $user->notify_status = 'Active';
                $user->save();
                $success['data'] =  $user;
                $success['status'] = 200;
                $success['message'] = 'Notification Status active Successfully';

                return response()->json(['success' => $success]);
            }
        }
    }


    public function delete_activity($id)
    {
        $activity = Activity::find($id);

        if ($activity->type === 'travel') {
            $travel = Travel::find($activity->type_id);
            if ($travel->trip_status === 'Checkout') {
                $activity->delete();
                $travel->status = 'Deleted';
                $travel->save();
                $success['data'] =  $activity;
                $success['status'] = 200;
                $success['message'] = ' Delete Successfully';

                return response()->json(['success' => $success]);
            } else {
                $success['status'] = 400;
                $success['message'] = 'Please Checkout first';
                return response()->json(['error' => $success]);
            }
        } else if ($activity->type === 'emergency') {
            $travel = Sos::find($activity->type_id);
            if ($travel->check_status === 'Checkout') {
                $activity->delete();
                $travel->status = 'Deleted';
                $travel->save();
                $success['data'] =  $activity;
                $success['status'] = 200;
                $success['message'] = ' Delete Successfully';

                return response()->json(['success' => $success]);
            } else {
                $success['status'] = 400;
                $success['message'] = 'Your Request in Pending';
                return response()->json(['error' => $success]);
            }
        } else if ($activity->type === 'suggestion') {
            $suggestion = Suggestion::find($activity->type_id);
            $activity->delete();
            $suggestion->status = 'Deleted';
            $suggestion->save();
            $success['data'] =  $activity;
            $success['status'] = 200;
            $success['message'] = ' Delete Successfully';

            return response()->json(['success' => $success]);
        } else if ($activity->type === 'report') {
            $suggestion = Report::find($activity->type_id);
            $activity->delete();
            $suggestion->status = 'Deleted';
            $suggestion->save();
            $success['data'] =  $activity;
            $success['status'] = 200;
            $success['message'] = ' Delete Successfully';

            return response()->json(['success' => $success]);
            
        } else if ($activity->type === 'consult') {
            $suggestion = Consult::find($activity->type_id);
            $activity->delete();
            $suggestion->status = 'Deleted';
            $suggestion->save();
            $success['data'] =  $activity;
            $success['status'] = 200;
            $success['message'] = ' Delete Successfully';

            return response()->json(['success' => $success]);
        } else if ($activity->type === 'ambulance') {
            $suggestion = Ambulance::find($activity->type_id);
            $activity->delete();
            $suggestion->status = 'Deleted';
            $suggestion->save();
            $success['data'] =  $activity;
            $success['status'] = 200;
            $success['message'] = ' Delete Successfully';

            return response()->json(['success' => $success]);
        } else if ($activity->type === 'feedback') {
            $suggestion = Feedback::find($activity->type_id);
            $activity->delete();
            $suggestion->status = 'Deleted';
            $suggestion->save();
            $success['data'] =  $activity;
            $success['status'] = 200;
            $success['message'] = ' Delete Successfully';

            return response()->json(['success' => $success]);
        }
    }


    public function popup()
    {
        $popup = Popup::all();
        $success['data'] = $popup;
        $success['status'] = 200;


        return response()->json(['success' => $success], $this->successStatus);
    }
    
    public function popup_id($id)
    {
        $popup = Popup::find($id);
        if ($popup) {
            $success['data'] = $popup;
            $success['status'] = 200;
            
            $success['message'] = "Pop-up " . $popup->id . " successfully";


            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = "Popup not found";


            return response()->json(['error' => $success]);
        }
    }
    
    public function popup_active(Request $request)
    {
        $request->validate([

            'platform' => 'required',
            'resident_country' => 'required',
        ]);
        $popup = Popup::where('status', '=', 'ACTIVE')->where('platform', '=', $request->platform)->where('country', '=', $request->resident_country)->inRandomOrder() // This will retrieve a random result
            ->first();
        if ($popup != null) {

            $success['data'] = $popup;


            $success['status'] = 200;
            $success['message'] = "Active Popup";


            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = "Active Popup not found";


            return response()->json(['error' => $success]);
        }
    }
    
    
    public function checkout(Request $request, $id)
    {
        $travel = Travel::find($id);
        if ($travel) {
            if ($travel->trip_status === 'Checkin') {
                $travel->trip_status = 'Checkout';
                if ($request->checkout_time) {
                    $travel->checkout_time = $request->checkout_time;
                }
                $travel->save();
                $success['status'] = 200;
                $success['message'] = "Checkout Successfully";


                return response()->json(['success' => $success], $this->successStatus);
            } else {
                $success['status'] = 200;
                $success['message'] = "Already Checkout";


                return response()->json(['success' => $success]);
            }
        }
    }
    
    
    public function coordinate(Request $request, $id, $user_id)
    {
        //     $request->validate([
        //         'coordinate'=>'required',
        //         ]);
        //         $latlong=json_encode($request->coordinate);
        //         $coordinate=Coordinate::create([
        //             'coordinate'=> $latlong,
        //             'user_id'=>$user_id,
        //             'travel_id'=>$id,
        //             ]);

        //           dd($latlong);
        //             $latitude =  $latlong['latitude'];
        // $longitude =  $latlong['longitude'];

        // // The Google Maps embed link with placeholders for latitude and longitude
        // $embed_link = "https://www.google.com/maps/embed/v1/view?key=YOUR_API_KEY&center={latitude},{longitude}&zoom=18&maptype=satellite";

        // // Replace the placeholders with actual values
        // $final_link = str_replace(
        //     ['{latitude}', '{longitude}', 'YOUR_API_KEY'],
        //     [$latitude, $longitude, 'your_google_maps_api_key'],
        //     $embed_link
        // );

        // // Now $final_link contains the link with the actual latitude, longitude, and your API key
        // $coordinate['map']=$final_link;
        $request->validate([
            'coordinate' => 'required',
        ]);

        $latlong = json_decode($request->coordinate, true);

        // Extract latitude and longitude values from the array
        $latitude = $latlong['latitude'];
        $longitude = $latlong['longitude'];

        // The Google Maps embed link with placeholders for latitude and longitude
        $embed_link = "https://www.google.com/maps/embed/v1/view?key=YOUR_API_KEY&center={latitude},{longitude}&zoom=18&maptype=satellite";

        // Replace the placeholders with actual values
        $final_link = str_replace(
            ['{latitude}', '{longitude}', 'YOUR_API_KEY'],
            [$latitude, $longitude, 'your_google_maps_api_key'],
            $embed_link
        );

        // Now $final_link contains the link with the actual latitude, longitude, and your API key

        // Save the data to the database (assuming you have the Coordinate model)
        $coordinate = Coordinate::create([
            'coordinate' => $request->coordinate, // Save the original JSON string if needed
            'user_id' => $user_id,
            'travel_id' => $id,
        ]);
        $coordinate['map'] =  $final_link;
        $success['data'] = $coordinate;


        $success['status'] = 200;
        $success['message'] = "Successfull";


        return response()->json(['success' => $success], $this->successStatus);
    }

    public function show_faq()
    {

        $faq = Faq::all();
        $success['data'] = $faq;
        $success['status'] = 200;
        $success['message'] = "All FAQ found Successfully";
        return response()->json(['success' => $success], $this->successStatus);
    }
    public function show_faq_language(Request $request)
    {
        $request->validate([
            'language' => 'required',
        ]);
        $faq = Faq::where('language', '=', $request->language)->get();
        if ($faq->count() > 0) {
            $success['data'] = $faq;
            $success['status'] = 200;
            $success['message'] = "All FAQ found Successfully";
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $faq = Faq::where('language', '=', 'English')->get();
            $success['data'] = $faq;
            $success['status'] = 200;
            $success['message'] = "All FAQ found Successfully";
            return response()->json(['success' => $success], $this->successStatus);
        }
    }


    public function delete_account($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->status = 'Delete';
            $user->save();
            $success['data'] = $user;
            $success['status'] = 200;
            $success['message'] = "user deleted";
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = "not found";


            return response()->json(['error' => $success]);
        }
    }


    public function timeup_coordinate($id, $user_id)
    {
        $coordinate = Coordinate::where('travel_id', '=', $id)->where('user_id', '=', $user_id)->latest()
            ->first();

        if ($coordinate) {
            $user = User::find($user_id);
            $travel = Travel::find($id);

            $coordinatesString = $coordinate->coordinate;
            $coordinatesArray = json_decode($coordinatesString, true);

            // Check if $coordinatesArray is an array before accessing the 'latitude'
            if (is_array($coordinatesArray) && isset($coordinatesArray['latitude'])) {
                $latitude = $coordinatesArray['latitude'];
            } else {
                $latitude = null;
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
            $dependant = Dependant::where('user_id', '=', $user_id)->get();
            if ($dependant->count() > 0) {
                foreach ($dependant as $d) {
                    $dependentname = $d->name;
                    Mail::to($d->email)->send(new TravelsafeMail($user, $map, $dependentname, $travel));
                }
            }
            $success['data'] = $coordinate;
            $success['status'] = 200;
            $success['message'] = "Email Sent";
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = "not found";


            return response()->json(['error' => $success]);
        }
    }


    // public function create_code(Request $request)
    // {

    //     $validator = Validator::make($request->all(), [
    //         'expiry_date' => 'required',
    //         'user_count' => 'required',
    //         'request_day' => 'required',
    //         'status' => 'required',

    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()], 401);
    //     }

    //     $input = $request->All();
    //     if ($request->amount) {
    //         $input['amount'] = $request->amount;
    //     }
    //     if ($request->type === 'Manual') {
    //         $input['code'] = $request->code;
    //         $input['type'] = $request->type;
    //     } else {
    //         $code = 'KC' . rand(00000000, 99999999);
    //         $input['code'] = $code;
    //         $input['type'] = 'Auto';
    //     }
    //     $input['request_week'] = (float)$input['request_day'] * 7;
    //     $input['request_monthly'] = (float)$input['request_day'] * 30;
    //     $kaci_code = Kaci_Code::create($input);
    //     $success['data'] = $kaci_code;
    //     $success['status'] = 200;
    //     return response()->json(['success' => $success], $this->successStatus);
    // }
    
    
    
    
    public function create_code(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'expiry_date' => 'required',
            'user_count' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->All();
        if ($request->amount) {
            $input['amount'] = $request->amount;
        }
        if ($request->type === 'Manual') {
            $input['code'] = $request->code;
            $input['type'] = $request->type;
        } else {
            $code = 'KC' . rand(00000000, 99999999);
            $input['code'] = $code;
            $input['type'] = 'Auto';
        }


        $input['consultation_requests'] = $request->consultation_requests;
        $input['ambulance_requests'] = $request->ambulance_requests;
        $input['travelsafe_requests'] = $request->travelsafe_requests;
        $input['emergnecy_requests'] = $request->emergnecy_requests;

        $kaci_code = Kaci_Code::create($input);
        $success['data'] = $kaci_code;
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }



    public function request_code(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $request->validate(
                ['code' => 'required']
            );
            $code = Kaci_Code::where('code', '=', $request->code)->first();
            if ($code) {
                $currentdate = Carbon::now();

                if ($code->expiry_date > $currentdate) {
                    if ($code->status === 'Active') {

                        $used_code = Used_Code::where('user_id', '=', $id)->where('code_id', '=', $code->id)->latest()->first();
                        if ($used_code) {
                            if ($used_code->status === 'InActive') {
                                $startDate = Carbon::now()->startOfDay(); // Start of the current day
                                $endDate = Carbon::now()->endOfDay();

                                $count_request = Used_Code::where('user_id', '=', $id)->where('code_id', '=', $code->id)->where('status', '=', 'InActive')->whereBetween('created_at', [$startDate, $endDate])->count();

                                if ($count_request < $code->request_day) {
                                    $avail = Used_Code::create([
                                        'user_id' => $id,
                                        'code_id' => $code->id,
                                        'code' => $code->code,
                                        'expiry_date' => $code->expiry_date,
                                        'status' => 'Active'
                                    ]);
                                    $success['data'] = $avail;
                                    $success['message'] = 'Successful';
                                    $success['status'] = 200;
                                    return response()->json(['success' => $success], $this->successStatus);
                                } else {
                                    $success['status'] = 400;
                                    $success['message'] = 'you have exceeded your daily limit.';
                                    return response()->json(['error' => $success]);
                                }
                            } else {
                                $success['status'] = 400;
                                $success['message'] = 'Your previous Kaci Code request is already active';
                                return response()->json(['error' => $success]);
                            }
                        } else {
                            $uniqueUserCount = Used_Code::where('code', '=', $code->code)->distinct('user_id')->count('user_id');

                            if ($uniqueUserCount < $code->user_count) {
                                $avail = Used_Code::create([
                                    'user_id' => $id,
                                    'code_id' => $code->id,
                                    'code' => $code->code,
                                    'expiry_date' => $code->expiry_date,
                                    'status' => 'Active',
                                ]);
                                $success['data'] = $avail;
                                $success['message'] = 'Successful';
                                $success['status'] = 200;
                                return response()->json(['success' => $success], $this->successStatus);
                            } else {
                                $success['status'] = 400;
                                $success['message'] = 'User count Exceed';
                                return response()->json(['error' => $success]);
                            }
                        }
                    } else {
                        $success['status'] = 400;
                        $success['message'] = 'Code InActive right now';
                        return response()->json(['error' => $success]);
                    }
                } else {
                    $success['status'] = 400;
                    $success['message'] = 'Code Expired';
                    return response()->json(['error' => $success]);
                }
            } else {
                $success['status'] = 400;
                $success['message'] = 'Invalid Code';
                return response()->json(['error' => $success]);
            }
        } else {
            $success['status'] = 400;
            $success['message'] = 'User not found';
            return response()->json(['error' => $success]);
        }
    }

    public function country_bank(Request $request)
    {
        $request->validate(['country' => 'required']);
        $info = Info_Bank::where('country', '=', $request->country)->first();
        if ($info) {
            $info->special_call_center = json_decode($info->special_call_center);
            $country = General_Countries::where('country_name', '=', $request->country)->first();
            if ($country) {
                $info['flag_code'] = $country->flag_code;
                $info['country_code'] = $country->country_code;
            }

            $success['data'] = $info;
            $success['message'] = 'Successful';
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $info = Info_Bank::where('country', '=', 'Nigeria')->first();
            $country = General_Countries::where('country_name', '=', 'Nigeria')->first();
            if ($country) {
                $info['flag_code'] = $country->flag_code;
                $info['country_code'] = $country->country_code;
            }
            $success['data'] = $info;
            $success['message'] = 'Successful';
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        }
    }

    public function relation_language(Request $request)
    {
        $request->validate(['language' => 'required',]);

        $relation = Relation::where('language', '=', $request->language)->get();
        if ($relation) {
            $success['data'] = $relation;
            $success['message'] = 'Successful';
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $relation = Relation::where('language', '=', 'English')->get();
            $success['data'] = $relation;
            $success['message'] = 'Successful';
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        }
    }

    public function kaci_code()
    {
        $code = Kaci_Code::all();
        $success['data'] = $code;
        $success['message'] = 'Successful';
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }


    public function kaci_code_id($id)
    {
        $code = Kaci_Code::find($id);
        if ($code) {
            $uniqueUserCount = Used_Code::where('code_id', '=', $code->id)->distinct('user_id')->pluck('user_id');
            if ($uniqueUserCount) {
                $user_count = $uniqueUserCount->toArray();
                $data = [];
                foreach ($user_count as $u) {
                    $user = User::find($u);
                    if ($user) {
                        $data[] = $user;
                        $code['user'] = $data;
                    }
                }
            }
            $success['data'] =   $code;
            $success['message'] = 'Successful';
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'Code not found';
            return response()->json(['error' => $success]);
        }
    }

    public function edit_code(Request $request, $id)
    {
        $code = Kaci_Code::find($id);
        if ($code) {

            if ($request->type === 'Auto') {
                if (!$request->code) {
                    $generate_code = "KC" . rand(00000000, 99999999);
                    $code->code = $generate_code;
                    $code->type = $request->type;
                } else {
                }
            }

            if ($request->type === 'Manual') {
                if ($request->code) {
                    $code->code = $request->code;
                    $code->type = $request->type;
                }
            }
            if ($request->request_day) {
                $code->request_day = $request->request_day;
                $code->request_week = (float)$request->request_day * 7;
                $code->request_monthly = (float)$request->request_day * 30;
            }
            if ($request->amount) {
                $code->amount = $request->amount;
            }
            if ($request->expiry_date) {
                $code->expiry_date = $request->expiry_date;
            }
            if ($request->status) {
                $code->status = $request->status;
            }
            if ($request->user_count) {
                $code->user_count = $request->user_count;
            }

            $code->save();
            $success['data'] = $code;
            $success['message'] = 'Updated Successful';
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'Code not found';
            return response()->json(['error' => $success]);
        }
    }

    public function delete_code($id)
    {
        $code = Kaci_Code::find($id);
        if ($code) {
            $code->delete();
            $success['data'] = $code;
            $success['message'] = 'Deleted Successful';
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'Code not found';
            return response()->json(['error' => $success]);
        }
    }


    public function check_latest_module(Request $request, $id)
    {
        $user = User::find($id);
        $request->validate(['type' => 'required']);
        if ($user) {
            if ($request->type === 'emergency') {
                $emergency = Sos::where('user_id', '=', $user->id)->latest()->first();
                if ($emergency->check_status === 'Checkout') {
                    $success['data'] = $emergency;
                    $success['message'] = 'Checkout Successful';
                    $success['status'] = 200;
                    return response()->json(['success' => $success], $this->successStatus);
                } else {
                    $success['message'] = 'ALready Checkin';
                    $success['status'] = 202;
                    return response()->json(['success' => $success], $this->successStatus);
                }
            } else if ($request->type === 'travelsafe') {
                $emergency = Travel::where('user_id', '=', $user->id)->latest()->first();
                if ($emergency->status === 'Resolved') {
                    $success['data'] = $emergency;
                    $success['message'] = 'Resolved Successful';
                    $success['status'] = 200;
                    return response()->json(['success' => $success], $this->successStatus);
                } else {
                    $success['message'] = 'ALready in Pending';
                    $success['status'] = 202;
                    return response()->json(['success' => $success], $this->successStatus);
                }
            }
        } else {
            $success['status'] = 400;
            $success['message'] = 'USer not found';
            return response()->json(['error' => $success]);
        }
    }
    public function module_link(Request $request, $id)
    {
        $request->validate(['type' => 'required']);
        if ($request->type === 'emergency') {
            $emergency = Sos::where('reference_code', '=', $id)->first();
            if ($emergency) {
                $user = User::find($emergency->user_id);
                if ($user) {
                    $country = General_Countries::where('country_name', '=', $user->country)->first();
                    $user['country_code'] = $country->country_code;
                    $emergency['user'] = $user;
                    $dependent = Dependant::where('user_id', '=', $user->id)->get();
                    $data = [];
                    if ($dependent->count() > 0) {
                        foreach ($dependent as $d) {
                            $country = General_Countries::where('country_name', '=', $d->country)->first();
                            $d['country_code'] = $country->country_code;
                            $data[] = $d;
                        }
                        $emergency['dependent'] = $data;
                    }
                }
                $success['data'] = $emergency;
                $success['message'] = 'found Successful';
                $success['status'] = 200;
                return response()->json(['success' => $success], $this->successStatus);
            } else {
                $success['status'] = 400;
                $success['message'] = 'Emergency not found';
                return response()->json(['error' => $success]);
            }
        } else if ($request->type === 'travelsafe') {
            $emergency = Travel::where('reference_code', '=', $id)->first();;
            if ($emergency) {
                $user = User::find($emergency->user_id);
                $coordinate = Coordinate::where('user_id', '=', $emergency->user_id)->where('travel_id', '=', $emergency->id)->get();
                if ($coordinate->count() > 0) {
                    $emergency['coordinate'] = $coordinate;
                }
                if ($user) {
                    $country = General_Countries::where('country_name', '=', $user->country)->first();
                    $user['country_code'] = $country->country_code;
                    $emergency['user'] = $user;
                    $dependent = Dependant::where('user_id', '=', $user->id)->get();
                    $data = [];
                    if ($dependent->count() > 0) {
                        foreach ($dependent as $d) {
                            $country = General_Countries::where('country_name', '=', $d->country)->first();
                            $d['country_code'] = $country->country_code;
                            $data[] = $d;
                        }
                        $emergency['dependent'] = $data;
                    }
                }
                $success['data'] = $emergency;
                $success['message'] = 'found Successful';
                $success['status'] = 200;
                return response()->json(['success' => $success], $this->successStatus);
            } else {
                $success['status'] = 400;
                $success['message'] = 'Travel not found';
                return response()->json(['error' => $success]);
            }
        }
    }
    public function check_status_sos(Request $request, $id)
    {
        $emergency = Sos::find($id);
        if ($emergency) {
            if ($emergency->check_status === 'Checkin') {
                $emergency->check_status = 'Checkout';
                if ($request->checkout_time) {
                    $emergency->checkout_time = $request->checkout_time;
                }
                $emergency->save();
                $success['data'] = $emergency;
                $success['message'] = 'found Successful';
                $success['status'] = 200;
                return response()->json(['success' => $success], $this->successStatus);
            } else {
                $success['data'] = $emergency;
                $success['message'] = 'found Successfully';
                $success['status'] = 200;
                return response()->json(['success' => $success], $this->successStatus);
            }
        } else {
            $success['status'] = 400;
            $success['message'] = 'Emergency not found';
            return response()->json(['error' => $success]);
        }
    }


    public function show_date_code($id)
    {
        $used = Used_Code::where('user_id', '=', $id)->latest()->first();
        if ($used) {
            $kaci = Kaci_Code::find($used->code_id);
            if ($kaci) {
                $success['data'] = $kaci;
                $success['message'] = 'found Successfully';
                $success['status'] = 200;
                return response()->json(['success' => $success], $this->successStatus);
            }
        } else {
            $success['status'] = 400;
            $success['message'] = 'No request yet';
            return response()->json(['error' => $success]);
        }
    }

    public function count_activity($id)
    {
        $activity = Activity::where('user_id', '=', $id)->where('status', '=', 'UnRead')->count();
        $success['data'] = $activity;
        $success['message'] = 'found Successfully';
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }

    //      public function click_activity($id){
    //          $activity=Activity::where('user_id','=',$id)->where('status','=','UnRead')->get();
    //          if($activity->count()>0){
    //              foreach($activity as $a){
    //                  $a->status='Read';
    //                  $a->save();

    //              }
    //               $success['data'] = $activity;
    //     $success['message']='found Successfully';
    // $success['status'] = 200;
    // return response()->json(['success' => $success], $this->successStatus);

    //          }
    //      }

    public function click_activity(Request $request, $id)
    {
        $response = Response::where('type_id', '=', $id)->where('type', '=', $request->type)->get();

        if ($response->count() > 0) {
            
            foreach ($response as $r) {
                
                if ($r->status === 'unseen') {
                    $r->status = 'seen';
                    $r->save();
                }
                
            }
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        }
    }

    public function get_request_module()
    {
        $module = Module_Request::all();
        if ($module) {
            $success['data'] = $module;
            $success['message'] = 'found Successfully';
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'Not found';
            return response()->json(['error' => $success]);
        }
    }
    public function change_time_request_module(Request $request)
    {
        $module = Module_Request::find(1);
        if ($module) {
            if ($request->travel) {
                $module->travel = $request->travel;
            }
            if ($request->ambulance) {
                $module->ambulance = $request->ambulance;
            }
            if ($request->emergency) {
                $module->emergency = $request->emergency;
            }
            
            if($request->consult){
                
                $module->consult = $request->consult;
            }
            $module->save();
            $success['data'] = $module;
            $success['message'] = 'found Successfully';
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        }
    }
    //               public function $id){
    //           $activity = Activity::where('user_id','=',$id)->get();
    //           $data=[];
    //           foreach($activity as $a){
    //               if($a->type==='feedback'){
    //                     $feedback=Feedback::where('id','=',$a->type_id)->first();
    //                     if($feedback){
    //                         $feedback->images=json_decode($feedback->images);
    //                          if($feedback->response === null){
    //                           $feedback['response_status']=null;
    //                     }else if($feedback->response != null){
    //                          $feedback['response_status']='R';
    //                     }
    //                     $responses=Response::where('user_id','=',$feedback->user_id)->where('type_id','=',$feedback->id)->where('type','=',$a->type)->get();
    //                     if($responses->count()>0){
    //                         $feedback['responses']=$responses;
    //                           $feedback['response_status']='R';
    //                     }else{
    //                          $feedback['response_status']=null;
    //                     }
    //                     $feedback['type']=$a->type;
    //                       $feedback['activity_id']=$a->id;
    //                     $data[]= $feedback;
    //                     }

    //               }else if($a->type==='travel'){
    //                     $feedback=Travel::where('id','=',$a->type_id)->first();
    //                     if($feedback){
    //                          $feedback->images=json_decode($feedback->images);
    //                           if($feedback->response === null){
    //                           $feedback['response_status']=null;
    //                     }else if($feedback->response != null){
    //                          $feedback['response_status']='R';
    //                     }

    //                       $responses=Response::where('user_id','=',$feedback->user_id)->where('type_id','=',$feedback->id)->where('type','=',$a->type)->get();
    //                     if($responses->count()>0){
    //                         $feedback['responses']=$responses;
    //                           $feedback['response_status']='R';
    //                     }else{
    //                          $feedback['response_status']=null;
    //                     }
    //                  if($feedback->trip_status === 'Checkin'){
    //                       $currentDateTime = Carbon::now();

    //         $created_at =$feedback->created_at;
    //         $trip_duration =$feedback->trip_duration;

    //         if (preg_match('/(\d+)h:(\d+)m/', $trip_duration, $matches)) {
    //             $hours = $matches[1];
    //             $minutes = $matches[2];
    //         } else {

    //         }


    //         $created_at = Carbon::parse($created_at);


    //         $created_at = $created_at->addHours($hours)->addMinutes($minutes);

    // $time_remaining = $currentDateTime->diff($created_at);


    // $remaining_format = $time_remaining->invert ? '-%hh %im' : '%hh %im';
    // $feedback['time_remaining'] = $time_remaining->format($remaining_format);


    // $feedback['time_remaining_second'] = $time_remaining->invert
    //     ? -$currentDateTime->diffInSeconds($created_at)
    //     : $currentDateTime->diffInSeconds($created_at);

    // if ($time_remaining->invert && $feedback['time_remaining_second'] < 0) {
    //     $feedback['time_remaining'] = '0h 0m';
    //     $feedback['time_remaining_second'] = 0;
    // }

    //                  }else{

    //                  }







    //                           $feedback['type']=$a->type;
    //                             $feedback['activity_id']=$a->id;
    //                     $data[]= $feedback;
    //                     }

    //               }else if($a->type==='emergency'){
    //                     $feedback=Sos::where('id','=',$a->type_id)->first();
    //                     if($feedback){
    //                          $feedback->images=json_decode($feedback->images);
    //                           if($feedback->response === null){
    //                           $feedback['response_status']=null;
    //                     }else if($feedback->response != null){
    //                          $feedback['response_status']='R';
    //                     }
    //                       $responses=Response::where('user_id','=',$feedback->user_id)->where('type_id','=',$feedback->id)->where('type','=',$a->type)->get();
    //                   if($responses->count()>0){
    //                         $feedback['responses']=$responses;
    //                           $feedback['response_status']='R';
    //                     }else{
    //                          $feedback['response_status']=null;
    //                     }
    //                     $dependent=Dependant::where('user_id','=',$feedback->user_id)->get();
    //                      $feedback['dependent']=$dependent;
    //                     if($feedback->check_status==='Checkin'){
    //                         $created=$feedback->created_at;
    //                         $now=Carbon::now();
    //                           // Calculate the difference
    //   $timeDifferenceInSeconds = $created->diffInSeconds($now);

    // $feedback['time'] = $timeDifferenceInSeconds;
    //                     }
    //                           $feedback['type']=$a->type;
    //                             $feedback['activity_id']=$a->id;
    //                     $data[]= $feedback;
    //                     }
    //               }else if($a->type === 'suggestion'){

    //                     $feedback=Suggestion::where('id','=',$a->type_id)->first();

    //                      if($feedback){
    //                           $feedback->images=json_decode($feedback->images);
    //                          if($feedback->response === null){
    //                           $feedback['response_status']=null;
    //                     }else if($feedback->response != null){
    //                          $feedback['response_status']='R';
    //                     }
    //                       $responses=Response::where('user_id','=',$feedback->user_id)->where('type_id','=',$feedback->id)->where('type','=',$a->type)->get();
    //                     if($responses->count()>0){
    //                         $feedback['responses']=$responses;
    //                           $feedback['response_status']='R';
    //                     }else{
    //                          $feedback['response_status']=null;
    //                     }
    //                           $feedback['type']=$a->type;
    //                             $feedback['activity_id']=$a->id;
    //                     $data[]= $feedback;
    //                     }




    //               } else if($a->type==='report'){
    //                     $feedback=Report::where('id','=',$a->type_id)->first();
    //                     if($feedback){
    //                     $feedback->images=json_decode($feedback->images);


    //                          if($feedback->response === null){
    //                           $feedback['response_status']=null;
    //                     }else if($feedback->response != null){
    //                          $feedback['response_status']='R';
    //                     }
    //                       $responses=Response::where('user_id','=',$feedback->user_id)->where('type_id','=',$feedback->id)->where('type','=',$a->type)->get();
    //                   if($responses->count()>0){
    //                         $feedback['responses']=$responses;
    //                           $feedback['response_status']='R';
    //                     }else{
    //                          $feedback['response_status']=null;
    //                     }
    //                           $feedback['type']=$a->type;
    //                             $feedback['activity_id']=$a->id;
    //                     $data[]= $feedback;
    //                     }

    //               }
    //               else if($a->type==='ambulance'){
    //                     $feedback=Ambulance::where('id','=',$a->type_id)->first();
    //                     if($feedback){
    //                          $feedback->images=json_decode($feedback->images);
    //                           if($feedback->response === null){
    //                           $feedback['response_status']=null;
    //                     }else if($feedback->response != null){
    //                          $feedback['response_status']='R';
    //                     }
    //                       $responses=Response::where('user_id','=',$feedback->user_id)->where('type_id','=',$feedback->id)->where('type','=',$a->type)->get();
    //                     if($responses->count()>0){
    //                          $responsedata=[];
    //                         foreach($responses as $r){
    //                             $r->image=json_decode($r->image);
    //                             $responsedata[]=$r;
    //                         }
    //                         $feedback['responses']= $responsedata;
    //                           $feedback['response_status']='R';
    //                     }else{
    //                          $feedback['response_status']=null;
    //                     }
    //                           $feedback['type']=$a->type;
    //                             $feedback['activity_id']=$a->id;
    //                     $data[]= $feedback;
    //                     }

    //               }

    //           }
    //           $success['data'] = $data;
    //             $success['status'] = 200;
    //             return response()->json(['success' => $success], $this->successStatus);

    // }

    public function activity($id)
    {
        $activities = Activity::where('user_id', '=', $id)
            ->orderBy('id', 'desc')
            ->get();

        $data = [];
        $count_unseen = 0; // Initialize count_unseen as a counter.

        foreach ($activities as $activity) {
            $feedback = null;
            $resp_status = []; // Initialize $resp_status for each activity.

            switch ($activity->type) {
                case 'feedback':
                    $feedback = Feedback::where('id', '=', $activity->type_id)->first();
                    if ($feedback) {
                       
                       $group_chat  = Group_Chat::where('module', '=', 'feedback')->where('module_id', '=', $activity->type_id)->first();
                       
                       if($group_chat){
                           
                                $messages = json_decode($group_chat->message);

                                $decoded_messages = [];
   
                                    foreach ($messages as $message) {
                                     $decoded_messages[] = $message;
                                }

                                $messages = $decoded_messages;
                                $feedback['messages'] = $messages;
                       }else{
                           
                           $feedback['messages'] = null;
                       }
                    }
                    break;

                case 'travel':
                    $feedback = Travel::where('id', '=', $activity->type_id)->first();
                    if ($feedback) {
                        if ($feedback->trip_status === 'Checkin') {
                            $currentDateTime = Carbon::now();

                            $created_at = $feedback->created_at;
                            $trip_duration = $feedback->trip_duration;

                            if (preg_match('/(\d+)h:(\d+)m/', $trip_duration, $matches)) {
                                $hours = $matches[1];
                                $minutes = $matches[2];
                            } else {
                            }


                            $created_at = Carbon::parse($created_at);


                            $created_at = $created_at->addHours($hours)->addMinutes($minutes);

                            $time_remaining = $currentDateTime->diff($created_at);


                            $remaining_format = $time_remaining->invert ? '-%hh %im' : '%hh %im';
                            $feedback['time_remaining'] = $time_remaining->format($remaining_format);


                            $feedback['time_remaining_second'] = $time_remaining->invert
                                ? -$currentDateTime->diffInSeconds($created_at)
                                : $currentDateTime->diffInSeconds($created_at);

                            if ($time_remaining->invert && $feedback['time_remaining_second'] < 0) {
                                $feedback['time_remaining'] = '0h 0m';
                                $feedback['time_remaining_second'] = 0;
                            }
                        } else {
                        }
                        
                        
                                $group_chat  = Group_Chat::where('module', '=', 'travel')->where('module_id', '=', $activity->type_id)->first();
                                
                                if($group_chat){
                                    
                                $messages = json_decode($group_chat->message);

                                $decoded_messages = [];
   
                                    foreach ($messages as $message) {
                                     $decoded_messages[] = $message;
                                }

                                $messages = $decoded_messages;
                                $feedback['messages'] = $messages;
                                }else{
                                    
                                    $feedback['messages'] = null;
                                }
                      
                             
                    }
                    break;

                case 'emergency':
                    $feedback = Sos::where('id', '=', $activity->type_id)->first();
                    if ($feedback) {
                        
                        $dependent = Dependant::where('user_id', '=', $feedback->user_id)->get();
                        $feedback['dependent'] = $dependent;
                        if ($feedback->check_status === 'Checkin') {
                            $created = $feedback->created_at;
                            $now = Carbon::now();
                            // Calculate the difference
                            $timeDifferenceInSeconds = $created->diffInSeconds($now);

                            $feedback['time'] = $timeDifferenceInSeconds;
                        }
                        
                                $group_chat  = Group_Chat::where('module', '=', 'emergency')->where('module_id', '=', $activity->type_id)->first();
                                if($group_chat){
                                    
                                $messages = json_decode($group_chat->message);

                                $decoded_messages = [];
   
                                    foreach ($messages as $message) {
                                     $decoded_messages[] = $message;
                                }

                                $messages = $decoded_messages;
                                $feedback['messages'] = $messages;
                                
                                }else{
                                    $feedback['messages'] = null;
                                }
                    }
                    break;

                case 'suggestion':
                    $feedback = Suggestion::where('id', '=', $activity->type_id)->first();
                    if ($feedback) {
                        $group_chat  = Group_Chat::where('module', '=', 'suggestion')->where('module_id', '=', $activity->type_id)->first();
                        
                        if($group_chat){
                                $messages = json_decode($group_chat->message);

                                $decoded_messages = [];
   
                                    foreach ($messages as $message) {
                                     $decoded_messages[] = $message;
                                }
                                $messages = $decoded_messages;
                                $feedback['messages'] = $messages;
                        }else{
                            
                            $feedback['messages'] = null;
                        }
                    }
                    break;

                case 'report':
                    $feedback = Report::where('id', '=', $activity->type_id)->first();
                    
                    if ($feedback) {
                        
                        $group_chat  = Group_Chat::where('module', '=', 'report')->where('module_id', '=', $activity->type_id)->first();
                        
                        if($group_chat){
                            $messages = json_decode($group_chat->message);
                                $decoded_messages = [];
   
                                    foreach ($messages as $message) {
                                     $decoded_messages[] = $message;
                                }

                                $messages = $decoded_messages;
                                $feedback['messages'] = $messages;
                        }else{
                            
                                $feedback['messages'] = null;
                        }
                    }
                    break;
                case 'consult':
                    $feedback = Consult::where('id', '=', $activity->type_id)->first();
                    
                    if ($feedback) {
                      $group_chat  = Group_Chat::where('module', '=', 'consultation')->where('module_id', '=', $activity->type_id)->first();
                      
                      if($group_chat){
                                     $messages = json_decode($group_chat->message);

                                $decoded_messages = [];
   
                                    foreach ($messages as $message) {
                                     $decoded_messages[] = $message;
                                }

                                $messages = $decoded_messages;
                                $feedback['messages'] = $messages;
                      }else{
                           $feedback['messages'] = null;
                      }
                    }
                    break;

                case 'ambulance':
                    $feedback = Ambulance::where('id', '=', $activity->type_id)->first();
                    if ($feedback) {
                        $medication = Medication::where('user_id', '=', $feedback->user_id)->get();
                        $feedback['user_medication'] = $medication;
                        
                        $group_chat  = Group_Chat::where('module', '=', 'ambulance')->where('module_id', '=', $activity->type_id)->first();
                        if($group_chat){
                            
                                $messages = json_decode($group_chat->message);
                                $decoded_messages = [];
   
                                    foreach ($messages as $message) {
                                     $decoded_messages[] = $message;
                                }

                                $messages = $decoded_messages;
                                $feedback['messages'] = $messages;
                                
                        }else{
                            $feedback['messages'] =  null;
                        }
                    }
                    break;

                default:
                    
                    
                    break;
            }

            if ($feedback) {
                if ($feedback->images) {
                    $feedback->images = json_decode($feedback->images);
                }
                if ($feedback->image) {
                    $feedback->image = json_decode($feedback->image);
                }
                $responses_time = Response::where('user_id', '=', $feedback->user_id)
                    ->where('type_id', '=', $feedback->id)
                    ->where('type', '=', $activity->type)
                    ->latest()->first();
                    
                if ($responses_time) {
                    $feedback->new_updated = $responses_time->created_at;
                }
                
                $responses = Response::where('user_id', '=', $feedback->user_id)
                    ->where('type_id', '=', $feedback->id)
                    ->where('type', '=', $activity->type)
                    ->get();

                if ($responses->count() > 0) {
                    foreach ($responses as $r) {
                        
                        $feedback->response_status = 'R';
                        
                        if ($r->status === 'unseen') {
                            $feedback->seen_status = 'dot';
                            $count_unseen++;
                        }
                        
                        $resp_status[] = $r;
                    }
                    $feedback->responses = $resp_status;
                }

                $feedback->logo = 'https://kacinew.s3.amazonaws.com/kaci_logo/WhatsApp+Image+2023-09-11+at+4.06.10+PM.jpeg';
                $feedback->type = $activity->type;
                $feedback->activity_id = $activity->id;
                $data[] = $feedback;
            }
        }

        $success['status'] = 200;
        $success['data'] = $data;
        $success['response_unseen'] = $count_unseen;

        return response()->json(['success' => $success]);
    }

    public function notify_count($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->notify_count = 0;
            $user->save();
            $success['data'] = $user;
            $success['status'] = 200;

            return response()->json(['success' => $success]);
        } else {
            $success['status'] = 400;

            return response()->json(['error' => $success]);
        }
    }
    public function users_data($id)
    {
        $user = User::find($id);
        if ($user) {

            $country = General_Countries::where('country_name', '=', $user->country)->first();
            $user['country_code'] = $country->country_code;
            $user['flag_code'] = $country->flag_code;

            $resident_country = Country::where('country', '=', $user->resident_country)->first();
            $user['resident_country_code'] = $resident_country->country_code;
            $user['resident_flag_code'] = $resident_country->flag_code;
            $success['data'] = $user;
            $success['status'] = 200;

            return response()->json(['success' => $success]);
        } else {
            $success['status'] = 400;

            return response()->json(['error' => $success]);
        }
    }


// Beep section start


    public function create_beep(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'anonymous' => 'required',
            'description' => 'required'
        ]);

        if ($request->type == 'Admin') {

            $input = $request->all();

            if ($request->media) {

                $uploadedFiles = [];

                foreach ($request->file('media') as $file) {
                    $uploadedFile = new \stdClass(); 

                    $extension = $file->extension();

                    if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                        $uploadedFile->type = 'image';
                    } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
                        $uploadedFile->type = 'video';
                    } elseif (in_array($extension, ['mp3', 'ogg'])) {
                        $uploadedFile->type = 'audio';
                    } elseif (in_array($extension, ['pptx', 'ppt'])) {
                        $uploadedFile->type = 'ppt';
                    } elseif (in_array($extension, ['docx', 'doc'])) {
                        $uploadedFile->type = 'docx';
                    } elseif (in_array($extension, ['pdf'])) {
                        $uploadedFile->type = 'pdf';
                    } else {
                        $uploadedFile->type = 'unknown';
                    }
                    $uploadedImage =rand(1000,9999). '.' . $file->extension();
                    $path = $file->storeAs('beep-media', $uploadedImage, ['disk' => 's3']);
                    // $uploadedFile->url= Storage::disk('s3')->url('beep-media/' . $uploadedImage);
                     $uploadedFile->url = 'https://storage.kacihelp.com/beep-media/' . $uploadedImage;
                    $uploadedFiles[] = $uploadedFile;
                }

                $input['media'] = json_encode($uploadedFiles);
            }

            $beep = Beep::create($input);
            
            
            $success['status'] = 200;
            $success['message'] = 'Created successfully';
            $success['data'] = $beep;
            
            
            return response()->json(['success' => $success]);


        } else if ($request->type == 'User') {

            $user = User::find($request->user_id);

            if ($user->ksn) {
                $input = $request->all();

                if ($request->media) {
                    $uploadedFiles = [];

                    foreach ($request->file('media') as $file) {
                        $uploadedFile = new \stdClass(); 

                        $extension = $file->extension(); 

                        if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                            $uploadedFile->type = 'image';
                        } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {
                            $uploadedFile->type = 'video';
                        } elseif (in_array($extension, ['mp3', 'ogg'])) {
                            $uploadedFile->type = 'audio';
                        } elseif (in_array($extension, ['pptx', 'ppt'])) {
                            $uploadedFile->type = 'ppt';
                        } elseif (in_array($extension, ['docx', 'doc'])) {
                            $uploadedFile->type = 'docx';
                        } elseif (in_array($extension, ['pdf'])) {
                            $uploadedFile->type = 'pdf';
                        } else {
                            $uploadedFile->type = 'unknown';
                        }
                     $uploadedImage =rand(1000,9999). '.' . $file->extension();
                    $path = $file->storeAs('beep-media', $uploadedImage, ['disk' => 's3']);
                    // $uploadedFile->url= Storage::disk('s3')->url('beep-media/' . $uploadedImage);
                     $uploadedFile->url = 'https://storage.kacihelp.com/beep-media/' . $uploadedImage;
                    $uploadedFiles[] = $uploadedFile;
                    }

                    $input['media'] = json_encode($uploadedFiles);
                }

                $input['user_id'] = $request->user_id;
                $input['location'] = $user->location;
                $input['country'] = $user->country;
                $input['featured'] =  $request->featured;



                $model =  Beep::latest()->first();


                if ($model) {
                    $numericPart = (int) substr($model->reference_code, 4) + 1;
                    $model->reference_code = substr($model->code, 0, 4) . str_pad($numericPart, 10, '0', STR_PAD_LEFT);
                    $ref_code = $model->reference_code;
                    $input['reference_code'] = 'KHBP' . $ref_code;
                } else {
                    $input['reference_code'] = 'KHBP' . '0000000001';
                }


                $beep = Beep::create($input);

            
                $success['status'] = 200;
                $success['data'] = $beep;
                $success['message'] = 'Beep created successfully';
    
                return response()->json(['success' => $success]);
            }else {

                $success['status'] = 400;
                $success['message'] = 'User does not have a KSN number';
    
                return response()->json(['success' => $success]);
            }
            
           
        } 
    }






    // public function like_beep(Request $request, $id, $beep_id)
    // {
    //     $like = BeepLike::where('user_id', '=', $id)->where('beep_id', '=', $beep_id)->first();

    //     $beep = Beep::find($beep_id);

    //     if ($like) {
    //         if ($like->status == 'true') {
    //             $like->status = 'false';
    //             if ($beep->like > 0) {
    //                 $beep->like = $beep->like - 1;
    //             }
    //         } else {
    //             $like->status = 'true';

    //             $beep->like = $beep->like + 1;



    //             $user = User::find($id);
    //             $notification = Notification::create([
    //                 'user_id' => $beep->user_id,
    //                 'title' => $user->firstname. ' likes your beep',
    //                 'status' => 'Unread',
    //                 'type' => 'Beep',
    //                 'item_id' => $beep_id
    //             ]);

    //             $content = [
    //                 'en' => $user->name . ' likes your beep',
    //             ];
                
    //             $notifyUser = User::find($beep->user_id);
                
            
    //             $fields = [
    //                 'app_id' => env('a548e8e7-f1d6-44f5-8863-bb4d1edaf004'),
    //                 'include_player_ids' => [$notifyUser->device_token],
    //                 'contents' => $content,
    //             ];

    //             $fields = json_encode($fields);

    //             $ch = curl_init();
    //             curl_setopt_array($ch, [
    //                 CURLOPT_URL => "https://onesignal.com/api/v1/notifications",
    //                 CURLOPT_HTTPHEADER => [
    //                     'Content-Type: application/json; charset=utf-8',
    //                     'Authorization: Basic ' . env('a548e8e7-f1d6-44f5-8863-bb4d1edaf004')
    //                 ],
    //                 CURLOPT_RETURNTRANSFER => true,
    //                 CURLOPT_HEADER => false,
    //                 CURLOPT_POST => true,
    //                 CURLOPT_POSTFIELDS => $fields,
    //                 CURLOPT_SSL_VERIFYPEER => false,
    //             ]);

    //             $response = curl_exec($ch);
    //             $error = curl_error($ch);
    //             curl_close($ch);
    //         }

    //         $like->save();
    //         $beep->save();
    //         $success['data'] = $like;
    //         $success['status'] = 200;

    //         return response()->json(['success' => $success]);
    //     } else {

    //         $beep_like = BeepLike::create([
    //             'user_id' => $id,
    //             'beep_id' => $beep_id,
    //             'status' => 'true'
    //         ]);
    //         $beep->like = $beep->like + 1;
    //         $beep->save();
    //         $success['data'] = $beep_like;
    //         $success['status'] = 200;

    //         return response()->json(['success' => $success]);
    //     }
    // } 
    
   public function like_beep(Request $request, $id, $beep_id)
    {
        if ($request->type == 'Climate') {

            $like = ClimateBeeplike::where('user_id', '=', $id)->where('climate_id', '=', $beep_id)->first();

            $beep = Climate::find($beep_id);

            if ($like) {
                if ($like->status == 'true') {
                    $like->status = 'false';
                    if ($beep->like > 0) {
                        $beep->like = $beep->like - 1;
                    }
                } else {
                    $like->status = 'true';

                    $beep->like = $beep->like + 1;

                    $user = User::find($id);
                    $notification = Notification::create([
                        'user_id' => $beep->user_id,
                        'title' => $user->firstname . ' likes your beep',
                        'status' => 'Unread',
                        'type' => 'Beep',
                        'item_id' => $beep_id
                    ]);

                    $content = [
                        'en' => $user->name . ' likes your beep',
                    ];

                    $notifyUser = User::find($beep->user_id);


                    $fields = [
                        'app_id' => env('a548e8e7-f1d6-44f5-8863-bb4d1edaf004'),
                        'include_player_ids' => [$notifyUser->device_token],
                        'contents' => $content,
                    ];

                    $fields = json_encode($fields);

                    $ch = curl_init();
                    curl_setopt_array($ch, [
                        CURLOPT_URL => "https://onesignal.com/api/v1/notifications",
                        CURLOPT_HTTPHEADER => [
                            'Content-Type: application/json; charset=utf-8',
                            'Authorization: Basic ' . env('a548e8e7-f1d6-44f5-8863-bb4d1edaf004')
                        ],
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HEADER => false,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => $fields,
                        CURLOPT_SSL_VERIFYPEER => false,
                    ]);

                    $response = curl_exec($ch);
                    $error = curl_error($ch);
                    curl_close($ch);
                }

                $like->save();
                $beep->save();
                $success['data'] = $like;
                $success['status'] = 200;

                return response()->json(['success' => $success]);
            } else {

                $beep_like = ClimateBeeplike::create([
                    'user_id' => $id,
                    'climate_id' => $beep_id,
                    'status' => 'true'
                ]);
                $beep->like = $beep->like + 1;
                $beep->save();
                $success['data'] = $beep_like;
                $success['status'] = 200;

                return response()->json(['success' => $success]);
            }
            
        } else {

            $like = BeepLike::where('user_id', '=', $id)->where('beep_id', '=', $beep_id)->first();


            $beep = Beep::find($beep_id);

            if ($like) {
                if ($like->status == 'true') {
                    $like->status = 'false';
                    if ($beep->like > 0) {
                        $beep->like = $beep->like - 1;
                    }
                } else {
                    $like->status = 'true';

                    $beep->like = $beep->like + 1;



                    $user = User::find($id);
                    $notification = Notification::create([
                        'user_id' => $beep->user_id,
                        'title' => $user->firstname . ' likes your beep',
                        'status' => 'Unread',
                        'type' => 'Beep',
                        'item_id' => $beep_id
                    ]);

                    $content = [
                        'en' => $user->name . ' likes your beep',
                    ];

                    $notifyUser = User::find($beep->user_id);


                    $fields = [
                        'app_id' => env('a548e8e7-f1d6-44f5-8863-bb4d1edaf004'),
                        'include_player_ids' => [$notifyUser->device_token],
                        'contents' => $content,
                    ];

                    $fields = json_encode($fields);

                    $ch = curl_init();
                    curl_setopt_array($ch, [
                        CURLOPT_URL => "https://onesignal.com/api/v1/notifications",
                        CURLOPT_HTTPHEADER => [
                            'Content-Type: application/json; charset=utf-8',
                            'Authorization: Basic ' . env('a548e8e7-f1d6-44f5-8863-bb4d1edaf004')
                        ],
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HEADER => false,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => $fields,
                        CURLOPT_SSL_VERIFYPEER => false,
                    ]);

                    $response = curl_exec($ch);
                    $error = curl_error($ch);
                    curl_close($ch);
                }

                $like->save();
                $beep->save();
                $success['data'] = $like;
                $success['status'] = 200;

                return response()->json(['success' => $success]);
            } else {

                $beep_like = BeepLike::create([
                    'user_id' => $id,
                    'beep_id' => $beep_id,
                    'status' => 'true'
                ]);
                $beep->like = $beep->like + 1;
                $beep->save();
                $success['data'] = $beep_like;
                $success['status'] = 200;

                return response()->json(['success' => $success]);
            }
        }
    }



    // public function beep_comment(Request $request, $id, $beep_id)


    // {
    //     $beeps = Beep::find($beep_id);

    //     $user = User::find($id);

    //     if ($user->ksn) {

    //         $beep = BeepComment::create([
    //             'beep_id' => $beep_id,
    //             'user_id' => $id,
    //             'comment' => $request->comment
    //         ]);
    //         $beeps->comment = $beeps->comment + 1;
            
            
            
    //         $user = User::find($id);
    //             $notification = Notification::create([
    //                 'user_id' => $beeps->user_id,
    //                 'title' => $user->firstname. ' commented on your beep',
    //                 'status' => 'Unread',
    //                 'type' => 'Beep',
    //                 'item_id' => $beep_id
    //             ]);
                
    //             $notifyUser = User::find($beeps->user_id);

    //             $content = [
    //                 'en' => $user->name . ' commented on your beep',
    //             ];
    //             $fields = [
    //                 'app_id' => env('a548e8e7-f1d6-44f5-8863-bb4d1edaf004'),
    //                 'include_player_ids' => [$notifyUser->device_token],
    //                 'contents' => $content,
    //             ];

    //             $fields = json_encode($fields);

    //             $ch = curl_init();
    //             curl_setopt_array($ch, [
    //                 CURLOPT_URL => "https://onesignal.com/api/v1/notifications",
    //                 CURLOPT_HTTPHEADER => [
    //                     'Content-Type: application/json; charset=utf-8',
    //                     'Authorization: Basic ' . env('a548e8e7-f1d6-44f5-8863-bb4d1edaf004')
    //                 ],
    //                 CURLOPT_RETURNTRANSFER => true,
    //                 CURLOPT_HEADER => false,
    //                 CURLOPT_POST => true,
    //                 CURLOPT_POSTFIELDS => $fields,
    //                 CURLOPT_SSL_VERIFYPEER => false,
    //             ]);

    //             $response = curl_exec($ch);
    //             $error = curl_error($ch);
    //             curl_close($ch);
    //         $beep->save();
    //         $beeps->save();
    //         $success['data'] = $beep;
    //         $success['status'] = 200;

    //         return response()->json(['success' => $success]);
    //     } else {

    //         $success['status'] = 400;
    //         $success['message'] = 'KSN is required please complete your profile';

    //         return response()->json(['success' => $success]);
    //     }
    // }




public function beep_comment(Request $request, $id, $beep_id)
    {

        if ($request->type == 'Climate') {

            $beeps = Climate::find($beep_id);

            $user = User::find($id);

            if ($user->ksn) {

                $beep = ClimateBeepComment::create([
                    'climate_id' => $beep_id,
                    'user_id' => $id,
                    'comment' => $request->comment
                ]);
                $beeps->comment = $beeps->comment + 1;


                $user = User::find($id);
                
                $notification = Notification::create([
                    'user_id' => $beeps->user_id,
                    'title' => $user->firstname . ' commented on your beep',
                    'status' => 'Unread',
                    'type' => 'Beep',
                    'item_id' => $beep_id
                ]);

                $notifyUser = User::find($beeps->user_id);

                $content = [
                    'en' => $user->name . ' commented on your beep',
                ];
                $fields = [
                    'app_id' => env('a548e8e7-f1d6-44f5-8863-bb4d1edaf004'),
                    'include_player_ids' => [$notifyUser->device_token],
                    'contents' => $content,
                ];

                $fields = json_encode($fields);

                $ch = curl_init();
                curl_setopt_array($ch, [
                    CURLOPT_URL => "https://onesignal.com/api/v1/notifications",
                    CURLOPT_HTTPHEADER => [
                        'Content-Type: application/json; charset=utf-8',
                        'Authorization: Basic ' . env('a548e8e7-f1d6-44f5-8863-bb4d1edaf004')
                    ],
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HEADER => false,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $fields,
                    CURLOPT_SSL_VERIFYPEER => false,
                ]);

                $response = curl_exec($ch);
                $error = curl_error($ch);
                curl_close($ch);
                $beep->save();
                $beeps->save();
                $success['data'] = $beep;
                $success['status'] = 200;

                return response()->json(['success' => $success]);
            } else {

                $success['status'] = 400;
                $success['message'] = 'KSN is required please complete your profile';

                return response()->json(['success' => $success]);
            }
            
        } else {


            $beeps = Beep::find($beep_id);

            $user = User::find($id);

            if ($user->ksn) {

                $beep = BeepComment::create([
                    'beep_id' => $beep_id,
                    'user_id' => $id,
                    'comment' => $request->comment
                ]);
                $beeps->comment = $beeps->comment + 1;



                $user = User::find($id);
                $notification = Notification::create([
                    'user_id' => $beeps->user_id,
                    'title' => $user->firstname . ' commented on your beep',
                    'status' => 'Unread',
                    'type' => 'Beep',
                    'item_id' => $beep_id
                ]);

                $notifyUser = User::find($beeps->user_id);

                $content = [
                    'en' => $user->name . ' commented on your beep',
                ];
                $fields = [
                    'app_id' => env('a548e8e7-f1d6-44f5-8863-bb4d1edaf004'),
                    'include_player_ids' => [$notifyUser->device_token],
                    'contents' => $content,
                ];

                $fields = json_encode($fields);

                $ch = curl_init();
                curl_setopt_array($ch, [
                    CURLOPT_URL => "https://onesignal.com/api/v1/notifications",
                    CURLOPT_HTTPHEADER => [
                        'Content-Type: application/json; charset=utf-8',
                        'Authorization: Basic ' . env('a548e8e7-f1d6-44f5-8863-bb4d1edaf004')
                    ],
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HEADER => false,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $fields,
                    CURLOPT_SSL_VERIFYPEER => false,
                ]);

                $response = curl_exec($ch);
                $error = curl_error($ch);
                curl_close($ch);
                $beep->save();
                $beeps->save();
                $success['data'] = $beep;
                $success['status'] = 200;

                return response()->json(['success' => $success]);
            } else {

                $success['status'] = 400;
                $success['message'] = 'KSN is required please complete your profile';

                return response()->json(['success' => $success]);
            }
        }
    }



    public function beep_comment_delete(Request $request, $id, $beep_id)
{
    if ($request->type == 'Climate') {

        $climateComment = ClimateBeepComment::find($id);
        if ($climateComment) {
            $climateComment->delete();

            $commentReplies = ClimateCommentReply::where('comment_id', $id)->get();
            foreach ($commentReplies as $reply) {
                $reply->delete();
            }


            $climateBeep = Climate::find($beep_id);
            if ($climateBeep) {
                $climateBeep->comment -= (1 + $commentReplies->count());
                $climateBeep->save();
            }

            $success['status'] = 200;
            $success['message'] = 'Climate comment deleted successfully';
            return response()->json(['success' => $success]);
        }
    } else {

        $beepComment = BeepComment::find($id);
        if ($beepComment) {
            $beepComment->delete();

            $commentReplies = CommentReply::where('comment_id', $id)->get();
            foreach ($commentReplies as $reply) {
                $reply->delete();
            }

            $beep = Beep::find($beep_id);
            if ($beep) {
                $beep->comment -= (1 + $commentReplies->count());
                $beep->save();
            }

            $success['status'] = 200;
            $success['message'] = 'Beep comment deleted successfully';
            return response()->json(['success' => $success]);
        }
    }
}



    public function store_comment_reply(Request $request, $id, $beep_id)
    {

        $request->validate([

            'comment_id' => 'required',
            'comment' => 'required',
        ]);

        if ($request->type  == 'Climate') {



            $commentReply = ClimateCommentReply::create([
                'user_id' => $id,
                'comment_id' => $request->comment_id,
                'comment' => $request->comment,
                'climate_id' => $beep_id
            ]);


            if ($commentReply) {

                $beep = Climate::find($beep_id);
                $beep->comment =  $beep->comment + 1;
                $beep->save();

                $success['status'] = 200;
                $success['message'] = 'Reply comment store successfully';
                $success['data'] = $commentReply;

                return response()->json(['success' => $success]);
            }
            
        } else {

            $commentReply = CommentReply::create([
                'user_id' => $id,
                'comment_id' => $request->comment_id,
                'comment' => $request->comment,
                'beep_id' => $beep_id
            ]);


            if ($commentReply) {

                $beep = beep::find($beep_id);
                $beep->comment =  $beep->comment + 1;
                $beep->save();

                $success['status'] = 200;
                $success['message'] = 'Reply comment store successfully';
                $success['data'] = $commentReply;

                return response()->json(['success' => $success]);
            }
        }
    }


    public function edit_comment_reply(Request $request, $id)
    {
    
    if($request->type == 'Climate'){
        
        
         $comment = ClimateCommentReply::find($id);

        if ($comment) {

            if ($request->comment) {

                $comment->comment =  $request->comment;
            }

            $comment->save();

            $success['status'] = 200;
            $success['message'] = 'Comment reply Updated Successfully';
            $success['data'] = $comment;

            return response()->json(['success' => $success]);
        } else {


            $success['status'] = 400;
            $success['message'] = 'Comment not found';

            return response()->json(['success' => $success], $this->successStatus);
        }
        
        
        
    }else{
        
        
         $comment = CommentReply::find($id);

        if ($comment) {

            if ($request->comment) {

                $comment->comment =  $request->comment;
            }

            $comment->save();

            $success['status'] = 200;
            $success['message'] = 'Comment reply Updated Successfully';
            $success['data'] = $comment;

            return response()->json(['success' => $success]);
        } else {


            $success['status'] = 400;
            $success['message'] = 'Comment not found';

            return response()->json(['success' => $success], $this->successStatus);
        }
         $comment = CommentReply::find($id);

        if ($comment) {

            if ($request->comment) {

                $comment->comment =  $request->comment;
            }

            $comment->save();

            $success['status'] = 200;
            $success['message'] = 'Comment reply Updated Successfully';
            $success['data'] = $comment;

            return response()->json(['success' => $success]);
        } else {


            $success['status'] = 400;
            $success['message'] = 'Comment not found';

            return response()->json(['success' => $success], $this->successStatus);
        }
    }
    
    }


    public function delete_comment_reply($id, $beep_id)
    {
        
        if($request->type  == 'Climate'){
            
        $comment = ClimateCommentReply::find($id);
        $comment->delete();

        $beep = Beep::find($beep_id);

        $beep->comment = $beep->comment - 1;
        $beep->save();
        
        }else{
            
        $comment = CommentReply::find($id);
        $comment->delete();

        $beep = Beep::find($beep_id);

        $beep->comment = $beep->comment - 1;
        $beep->save();
        }

        $success['status'] = 200;
        $success['message'] = 'comment delete successfully';
        $success['data'] = $comment;

        return response()->json(['success' => $success], $this->successStatus);
    }





public function like_comment(Request $request, $id, $comment_id)
    {

        if ($request->type  == 'Climate') {

            $like = ClimateCommentLike::where('user_id', $id)->where('comment_id', $comment_id)->first();

            $comment = ClimateBeepComment::find($comment_id);

            if ($like) {
                if ($like->status == 'true') {
                    $like->status = 'false';
                    if ($comment->like > 0) {
                        $comment->like = $comment->like - 1;
                    }
                } else {

                    $like->status = 'true';
                    $comment->like = $comment->like + 1;


                    $user = User::find($id);

                    $notification = Notification::create([
                        'user_id' => $comment->user_id,
                        'title' => $user->firstname . ' liked your comment',
                        'status' => 'Unread',
                        'type' => 'Comment',
                        'item_id' => $comment_id
                    ]);

                    $content = [
                        'en' => $user->name . ' likes your comment',
                    ];

                    $notifyUser = User::find($comment->user_id);

                    $fields = [
                        'app_id' => env('a548e8e7-f1d6-44f5-8863-bb4d1edaf004'),
                        'include_player_ids' => [$notifyUser->device_token],
                        'contents' => $content,
                    ];

                    $fields = json_encode($fields);

                    $ch = curl_init();
                    curl_setopt_array($ch, [
                        CURLOPT_URL => "https://onesignal.com/api/v1/notifications",
                        CURLOPT_HTTPHEADER => [
                            'Content-Type: application/json; charset=utf-8',
                            'Authorization: Basic ' . env('a548e8e7-f1d6-44f5-8863-bb4d1edaf004')
                        ],
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HEADER => false,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => $fields,
                        CURLOPT_SSL_VERIFYPEER => false,
                    ]);

                    $response = curl_exec($ch);
                    $error = curl_error($ch);
                    curl_close($ch);
                }
                $like->save();
                $comment->save();

                $success['data'] = $like;
                $success['status'] = 200;

                return response()->json(['success' => $success]);
            } else {

                $comment_like = ClimateCommentLike::create([
                    'user_id' => $id,
                    'comment_id' => $comment_id,
                    'status' => 'true'
                ]);


                $comment->like = $comment->like + 1;
                $comment->save();

                $success['data'] = $comment_like;
                $success['status'] = 200;

                return response()->json(['success' => $success]);
            }
            
            
        } else {


            $like = CommentLike::where('user_id', $id)->where('comment_id', $comment_id)->first();


            $comment = BeepComment::find($comment_id);

            if ($like) {
                if ($like->status == 'true') {
                    $like->status = 'false';
                    if ($comment->like > 0) {
                        $comment->like = $comment->like - 1;
                    }
                } else {

                    $like->status = 'true';
                    $comment->like = $comment->like + 1;


                    $user = User::find($id);

                    $notification = Notification::create([
                        'user_id' => $comment->user_id,
                        'title' => $user->firstname . ' liked your comment',
                        'status' => 'Unread',
                        'type' => 'Comment',
                        'item_id' => $comment_id
                    ]);

                    $content = [
                        'en' => $user->name . ' likes your comment',
                    ];

                    $notifyUser = User::find($comment->user_id);

                    $fields = [
                        'app_id' => env('a548e8e7-f1d6-44f5-8863-bb4d1edaf004'),
                        'include_player_ids' => [$notifyUser->device_token],
                        'contents' => $content,
                    ];

                    $fields = json_encode($fields);

                    $ch = curl_init();
                    curl_setopt_array($ch, [
                        CURLOPT_URL => "https://onesignal.com/api/v1/notifications",
                        CURLOPT_HTTPHEADER => [
                            'Content-Type: application/json; charset=utf-8',
                            'Authorization: Basic ' . env('a548e8e7-f1d6-44f5-8863-bb4d1edaf004')
                        ],
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HEADER => false,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => $fields,
                        CURLOPT_SSL_VERIFYPEER => false,
                    ]);

                    $response = curl_exec($ch);
                    $error = curl_error($ch);
                    curl_close($ch);
                }
                $like->save();
                $comment->save();

                $success['data'] = $like;
                $success['status'] = 200;

                return response()->json(['success' => $success]);
            } else {

                $comment_like = CommentLike::create([
                    'user_id' => $id,
                    'comment_id' => $comment_id,
                    'status' => 'true'
                ]);


                $comment->like = $comment->like + 1;
                $comment->save();

                $success['data'] = $comment_like;
                $success['status'] = 200;

                return response()->json(['success' => $success]);
            }
        }
    }



      public function comment_save(Request $request, $id, $comment_id)
    {
        $commentsave = CommentSave::where('user_id', $id)->where('comment_id', $comment_id)->first();
        if ($commentsave) {
            if ($commentsave->status == 'true') {
                $commentsave->status = 'false';
            } else {
                $commentsave->status = 'true';
            }
            $commentsave->save();
            $success['data'] = $beepsave;
            $success['status'] = 200;

            return response()->json(['success' => $success]);
        } else {
            $commentsave = CommentSave::create([
                'user_id' => $id,
                'beep_id' => $comment_id,
                'status' => 'true'
            ]);
            $success['data'] = $commentsave;
            $success['status'] = 200;

            return response()->json(['success' => $success]);
        }
    }
    
    
 public function get_all_beeps(Request $request)
{
    $query = Beep::query();
    $sponsoredQuery = SponsoredBeep::query();

    if ($request->country != 'all') {
        $query->where('country', '=', $request->country);
        $sponsoredQuery->where('country', '=', $request->country);
    }

    if ($request->status != 'all') {
        $query->where('status', '=', $request->status);
        $sponsoredQuery->where('status', '=', $request->status);
    }
    
    $beeps = $query->get();
    $sponsoredBeeps = $sponsoredQuery->get();
    $data = [];
    
    foreach ($beeps as $b) {
        $shareCount = $b->share;
        if ($shareCount >= 1000) {
            $shareCount = round($shareCount / 1000, 1) . 'k';
        }
        $b['share'] = $shareCount;

        $commentCount = $b->comment;
        if ($commentCount >= 1000) {
            $commentCount = round($commentCount / 1000, 1) . 'k';
        }
        $b['comment'] = $commentCount;

        $likeCount = $b->like;
        if ($likeCount >= 1000) {
            $likeCount = round($likeCount / 1000, 1) . 'k';
        }
        $b['like'] = $likeCount;

        $b['media'] = json_decode($b->media);
        
        $user = $b->user_id ? User::find($b->user_id) : null;
        $verifyBadge = $b->user_id ? Used_code::where('user_id', $b->user_id)
                             ->where('expiry_date', '>', now())
                             ->first() : null;
        $b['verify_badge'] = $verifyBadge ? true : false;
        
        $b['user'] = $user;
        $b['profile_image'] = $user->profile_image ?? null;
        $b['ksn'] = $user->ksn ?? null;
        $b['first_name'] = $user->firstname ?? null;
        $b['last_name'] = $user->lastname ?? null;
        $b['device'] = $user->device_name ?? null;
        $b['phone_number'] = $user->phone_number ?? null;
        $b['address'] = $user->address ?? null;

        $reportItem = ReportItem::where('user_id', $b->user_id)
                                ->where('item_id', '=', $b->id)
                                ->where('type', '=', 'Beep')
                                ->first();

        $b['report_status'] = $reportItem ? $reportItem->status : false;

        $created_at = Carbon::parse($b->created_at);
        $b['time_elapsed'] = $created_at->diffForHumans();

        $data[] = $b;
    }
    
    foreach ($sponsoredBeeps as $sbeep) {
        $shareCount = $sbeep->share;
        if ($shareCount >= 1000) {
            $shareCount = round($shareCount / 1000, 1) . 'k';
        }
        $sbeep['share'] = $shareCount;

        $commentCount = $sbeep->comment;
        if ($commentCount >= 1000) {
            $commentCount = round($commentCount / 1000, 1) . 'k';
        }
        $sbeep['comment'] = $commentCount;

        $likeCount = $sbeep->like;
        if ($likeCount >= 1000) {
            $likeCount = round($likeCount / 1000, 1) . 'k';
        }
        $sbeep['like'] = $likeCount;

        $sbeep['media'] = json_decode($sbeep->media);
        
        $user = $sbeep->user_id ? User::find($sbeep->user_id) : null;
        $sbeep['user'] = $user;

        $reportItem = ReportItem::where('user_id', $sbeep->user_id)
                                ->where('item_id', '=', $sbeep->id)
                                ->where('type', '=', 'SponsoredBeep')
                                ->first();

        $sbeep['report_status'] = $reportItem ? $reportItem->status : false;

        $created_at = Carbon::parse($sbeep->created_at);
        $sbeep['time_elapsed'] = $created_at->diffForHumans();

        $data[] = $sbeep;
    }

    $success['data'] = $data;
    $success['status'] = 200;
    $success['message'] = 'All beeps found successfully';

    return response()->json(['success' => $success]);
}


public function show_beep_to_user($id)
{
    $user = User::find($id);

    $beeps = Beep::where('user_id', '=', $id)->where('status', '=', 'Active')->get();

    $data = [];

    if ($beeps->count() > 0) {
        foreach ($beeps as $b) {
            if ($b->edit_status == 1) {
                $b['edit_status'] = 'Edited';
            }

            $shareCount = $b->share;
            if ($shareCount >= 1000) {
                $b['share'] = round($shareCount / 1000, 1) . 'k';
            }

            $commentCount = $b->comment;
            if ($commentCount >= 1000) {
                $commentCount = round($commentCount / 1000, 1) . 'k';
            }
            $b['comment'] = $commentCount;

            $likeCount = $b->like;
            if ($likeCount >= 1000) {
                $likeCount = round($likeCount / 1000, 1) . 'k';
            }
            $b['like'] = $likeCount;

            $created_at = Carbon::parse($b->created_at);
            $b['time_elapsed'] = $created_at->diffForHumans();

            $b['media'] = json_decode($b->media);
            $user = User::find($b->user_id);
            if ($user) {
                $b['user'] = $user;

                $like = BeepLike::where('user_id', $user->id)->where('beep_id', $b->id)->first();
                $b['like_status'] = $like ? $like->status : false;

                $save = BeepSave::where('user_id', $user->id)->where('beep_id', $b->id)->first();
                $b['save_status'] = $save ? $save->status : false;

                $comments = BeepComment::where('beep_id', $b->id)->get();
                foreach ($comments as $c) {
                    $created_at = Carbon::parse($c->created_at);
                    $c['time_elapsed'] = $created_at->diffForHumans();
                    $c['comment_reply'] = CommentReply::where('comment_id', '=', $c->id)->where('beep_id', '=', $c->beep_id)->get();
                }
                $b['comments'] = $comments;

                // $sharedBeeps = SharedBeep::where('user_id', $id)->where('status', '=', 'true')->get();
                // foreach ($sharedBeeps as $s) {
                //     $s->shared_beeps = Beep::find($s->beep_id);
                // }
                // $b['shared_beeps'] = $sharedBeeps;
                
                // $climateBeeps = ShareClimateBeep::where('user_id', $id)->get();
                // foreach ($climateBeeps as $s) {
                //     $s->shared_beeps = Climate::find($s->climate_id);
                // }
                // $b['climate_beeps'] = $climateBeeps;
                
                
                foreach($data as $d){
                    
                 $d['beeps_count'] = Beep::where('user_id', $id)->count();
                    
                }
                
                
                $data[] = $b;
            }
        }
    } 


    // $sharedBeeps = SharedBeep::where('user_id', $id)->where('status', '=', 'true')->get();

    // $climateBeeps = ShareClimateBeep::where('user_id', $id)->get();

    // $data['total_comments'] = BeepComment::where('user_id', $id)->count();
    // $data['total_likes'] = BeepLike::where('user_id', $id)->count();
    // $data['total_report'] = ReportItem::where('user_id', $id)->where('status', '=', 'true')->count();

    // $data['shared_beeps'] = $sharedBeeps;
    // $data['climate_beeps'] = $climateBeeps;

    $success['data'] = $data;
    $success['status'] = 200;

    return response()->json(['success' => $success]);
}




 public function beep_save(Request $request, $id, $beep_id)
    {

        if ($request->type  == 'Climate') {
            $beepsave = ClimateSaveBeep::where('user_id', $id)->where('climate_id', $beep_id)->first();
            if ($beepsave) {
                if ($beepsave->status == 'true') {
                    $beepsave->status = 'false';
                } else {
                    $beepsave->status = 'true';
                }
                $beepsave->save();
                $success['data'] = $beepsave;
                $success['status'] = 200;

                return response()->json(['success' => $success]);
            } else {
                $beep_like = ClimateSaveBeep::create([
                    'user_id' => $id,
                    'climate_id' => $beep_id,
                    'status' => 'true'
                ]);
                $success['data'] = $beep_like;
                $success['status'] = 200;

                return response()->json(['success' => $success]);
            }
        } else {

            $beepsave = BeepSave::where('user_id', $id)->where('beep_id', $beep_id)->first();
            if ($beepsave) {
                if ($beepsave->status == 'true') {
                    $beepsave->status = 'false';
                } else {
                    $beepsave->status = 'true';
                }
                $beepsave->save();
                $success['data'] = $beepsave;
                $success['status'] = 200;

                return response()->json(['success' => $success]);
            } else {
                $beep_like = BeepSave::create([
                    'user_id' => $id,
                    'beep_id' => $beep_id,
                    'status' => 'true'
                ]);
                $success['data'] = $beep_like;
                $success['status'] = 200;

                return response()->json(['success' => $success]);
            }
        }
    }

    public function get_user_saved_beeps($id)
{
    $savedBeeps = BeepSave::where('user_id', '=', $id)->where('status', '=', 'true')->get();
    $climateBeeps = ClimateSaveBeep::where('user_id', '=', $id)->where('status', '=', 'true')->get();

    $response = [];

    if ($savedBeeps->count() > 0) {
        foreach ($savedBeeps as $b) {
            $b['beep'] = Beep::find($b->beep_id);

            $created_at = Carbon::parse($b->created_at);
            $b['time_elapsed'] = $created_at->diffForHumans();

            $b['comments'] = BeepComment::where('beep_id', '=', $b->beep_id)->get();
        }

        $response['saved_beeps'] = $savedBeeps;
    } else {
        $response['saved_beeps'] = [];
    }

    if ($climateBeeps->count() > 0) {
        foreach ($climateBeeps as $c) {
            
            $c['beep']  =  Climate::find($c->climate_id);

            $created_at = Carbon::parse($c->created_at);
            $c['time_elapsed'] = $created_at->diffForHumans();

            $c['comments'] = BeepComment::where('beep_id', '=', $c->beep_id)->get();
        }
  
        $response['climate_beeps'] = $climateBeeps;
        
        
    } else {
        $response['climate_beeps'] = [];
    }

    $success['status'] = 200;
    $success['message'] = 'Beeps found successfully';
    $success['data'] = $response;

    return response()->json(['success' => $success]);
}





    // public function show_beep_filter(Request $request, $id)
    // {
    //     $user = User::find($id);
    //     if ($request->filter == "All") {
    //         $beep = Beep::where('status', '=', 'Active')->get();
    //     } else if ($request->filter == "My Country") {
    //         $beep = Beep::where('country', $user->country)->where('status', '=', 'Active')->get();
    //     } else if ($request->filter == "My location") {
    //         $beep = Beep::where('location', $user->location)->where('status', '=', 'Active')->get();
    //     } else {
    //         $beep = Beep::where('country', $user->country)->where('location', $user->location)->where('status', '=', 'Active')->get();
    //     }

    //     $data = [];


    //         $beepCount = count($beep);


    //     if ($beep->count() > 0) {
    //          $sponsoredBeepCounter = 0;
    //         foreach ($beep as $index => $b) {

    //              $commentCount = $b->comment;
    //         if ($commentCount >= 1000) {
    //             $commentCount = round($commentCount / 1000, 1) . 'k';
    //         }
    //         $b['comment'] = $commentCount;


    //         $likeCount = $b->like;
    //         if ($likeCount >= 1000) {
    //             $likeCount = round($likeCount / 1000, 1) . 'k';
    //         }
    //         $b['like'] = $likeCount;


    //             $created_at = Carbon::parse($b->created_at);
    //             $b['time_elapsed'] = $created_at->diffForHumans();

    //             $b['media'] = json_decode($b->media);

    //             $user = User::find($b->user_id);
    //             if ($user) {

    //               if ($b->anonymous == 'Yes') {
    //                 $user->firstname = ' KHEY0000000004';
    //                 $user->profile_image = 'https://kacinew.s3.amazonaws.com/admin-profile/1691395550.svg';
    //                 }

    //                 $b['user'] = $user;
    //                 $like = BeepLike::where('user_id', $user->id)->where('beep_id', $b->id)->first();
    //                 if ($like) {
    //                     $b['like_status'] = $like->status;
    //                 } else {
    //                     $b['like_status'] = false;
    //                 }

    //                 $save = BeepSave::where('user_id', $user->id)->where('beep_id', $b->id)->first();
    //                 if ($save) {
    //                     $b['save_status'] = $save->status;
    //                 } else {
    //                     $b['save_status'] = "false";
    //                 }



    //                  $reportItem =  ReportItem::where('user_id', $b->user_id)->where('item_id', '=', $b->id)->where('type', '=', 'Beep')->first();

    //                  if ($reportItem) {
    //                     $b['report_status'] = $reportItem->status;
    //                 } else {
    //                     $b['report_status'] = "false";
    //                  }


    //                 $comment = BeepComment::where('beep_id', $b->id)->get();

    //                  foreach($comment as $c){

    //                     $reportItem =  ReportItem::where('user_id', $c->user_id)->where('item_id', '=', $c->id)->where('type', '=', 'Comment')->first();


    //                      if ($reportItem) {
    //                         $c['report_status'] = $reportItem->status;
    //                     } else {
    //                         $c['report_status'] = false;
    //                     }


    //                     $created_at = Carbon::parse($c->created_at);
    //                     $c['time_elapsed'] = $created_at->diffForHumans();
    //                 }


    //                 $b['comments'] = $comment;
    //                 $data[] = $b;


    //              $sponsoredBeepCounter++;

    //             if ($sponsoredBeepCounter % 3 == 0 && $index < $beepCount - 1) {
    //                 $sponsoredBeep = SponsoredBeep::all()->random();
    //                 $data[] = $sponsoredBeep;
    //             }
    //             }
    //         }


    //       shuffle($data);
    //     }
    //     $success['data'] = $data;
    //     $success['status'] = 200;

    //     return response()->json(['success' => $success]);
    // }



// public function show_beep_filter(Request $request, $id)
// {
//     $user = User::find($id);
//     $perPage = 10; // Number of items per page

//     if ($request->filter == "All") {
//         $beepQuery = Beep::where('status', '=', 'Active')
//             ->whereRaw('JSON_SEARCH(read_beeps, "one", ?) IS NULL', [$id]);
//     } elseif ($request->filter == "My Country") {
//         $beepQuery = Beep::where('country', $user->country)
//             ->where('status', '=', 'Active')
//             ->whereRaw('JSON_SEARCH(read_beeps, "one", ?) IS NULL', [$id]);
//     } elseif ($request->filter == "My location") {
//         $beepQuery = Beep::where('location', $user->location)
//             ->where('status', '=', 'Active')
//             ->whereRaw('JSON_SEARCH(read_beeps, "one", ?) IS NULL', [$id]);
//     } else {
//         $beepQuery = Beep::where('country', $user->country)
//             ->where('location', $user->location)
//             ->where('status', '=', 'Active')
//             ->whereRaw('JSON_SEARCH(read_beeps, "one", ?) IS NULL', [$id]);
//     }

//     // Paginate the results
//     $beeps = $beepQuery->paginate($perPage);


//     $data = [];

//     if ($beeps->count() > 0) {
//         $sponsoredBeepCounter = 0;

//         $availableSponsoredBeeps = SponsoredBeep::where('location', '=', $user->location)
//             ->where('country', '=', $user->country)
//             ->where('status', '=', 'Active')
//             ->where('device_type', '=', $user->device_name)
//             ->get()->toArray();

//         foreach ($beeps as $index => $b) {
            
            
//             // $readBeeps = json_decode($b->read_beeps, true) ?? [];

//             // if (!in_array($id, $readBeeps)) {
//             //     $readBeeps[] = $id;
//             // }
//             // $b->read_beeps = json_encode($readBeeps);
//             // $b->save();

//             if ($b->edit_status == 1) {
//                 $b['edit_status'] = 'Edited';
//             }

//             // Format share count
//             $shareCount = $b->share;
//             if ($shareCount >= 1000000) {
//                 $shareCount = round($shareCount / 1000000) . 'M';
//             } elseif ($shareCount >= 1000) {
//                 $shareCount = round($shareCount / 1000, 1) . 'k';
//             }
//             $b['share'] = $shareCount;

//             // Format comment count
//             $commentCount = $b->comment;
//             if ($commentCount >= 1000000) {
//                 $commentCount = round($commentCount / 1000000, 1) . 'M';
//             } elseif ($commentCount >= 1000) {
//                 $commentCount = round($commentCount / 1000, 1) . 'k';
//             }
//             $b['comment'] = $commentCount;

//             // Format like count
//             $likeCount = $b->like;
//             if ($likeCount >= 1000000) {
//                 $likeCount = round($likeCount / 1000000, 1) . 'M';
//             } elseif ($likeCount >= 1000) {
//                 $likeCount = round($likeCount / 1000, 1) . 'k';
//             }
//             $b['like'] = $likeCount;

//             $created_at = Carbon::parse($b->created_at);
//             $b['time_elapsed'] = $created_at->diffForHumans();

//             $b['media'] = json_decode($b->media);

//             $beepUser = User::find($b->user_id);
//             if ($beepUser) {
//                 if ($b->anonymous == 'Yes') {
//                     $beepUser->firstname = $b->reference_code;
//                     $beepUser->profile_image = 'https://kacinew.s3.amazonaws.com/admin-profile/1691395550.svg';
//                 }

//                 $b['user'] = $beepUser;
//                 $like = BeepLike::where('user_id', $id)->where('beep_id', $b->id)->first();
//                 $b['like_status'] = $like ? $like->status : false;

//                 $beeplike = BeepLike::where('beep_id', '=', $b->id)->get();
//                 foreach ($beeplike as $l) {
//                     $l['likers'] = User::find($l->user_id);
//                 }
//                 $b['beep_likers'] = $beeplike;

//                 $save = BeepSave::where('user_id', $id)->where('beep_id', $b->id)->first();
//                 $b['save_status'] = $save ? $save->status : "false";

//                 $reportItem = ReportItem::where('user_id', $b->user_id)
//                     ->where('item_id', '=', $b->id)
//                     ->where('type', '=', 'Beep')
//                     ->first();
//                 $b['report_status'] = $reportItem ? $reportItem->status : "false";

//                 $comment = BeepComment::where('beep_id', $b->id)->get();
//                 foreach ($comment as $c) {
//                     $reportItem = ReportItem::where('user_id', $c->user_id)
//                         ->where('item_id', '=', $c->id)
//                         ->where('type', '=', 'Comment')
//                         ->first();
//                     $c['report_status'] = $reportItem ? $reportItem->status : false;

//                     $created_at = Carbon::parse($c->created_at);
//                     $c['time_elapsed'] = $created_at->diffForHumans();

//                     $c['comment_reply'] = CommentReply::where('comment_id', '=', $c->id)
//                         ->where('beep_id', '=', $c->beep_id)
//                         ->get();

//                     $likeCount = $c->like;
//                     if ($likeCount >= 1000000) {
//                         $likeCount = round($likeCount / 1000000, 1) . 'M';
//                     } elseif ($likeCount >= 1000) {
//                         $likeCount = round($likeCount / 1000, 1) . 'k';
//                     }
//                     $c['like'] = $likeCount;

//                     $c['comment_likes'] = CommentLike::where('comment_id', '=', $c->id)->get();
//                 }
//                 $b['comments'] = $comment;

//                 $data[] = $b;

//                 // Insert sponsored beeps every 3 beeps
//                 $sponsoredBeepCounter++;
//                 if ($sponsoredBeepCounter % 3 == 0 && $index < $beeps->count() - 1) {
//                     if (!empty($availableSponsoredBeeps)) {
//                         $sponsoredBeep = collect($availableSponsoredBeeps)->random();
//                         if (Carbon::parse($sponsoredBeep['expire_date'])->isFuture()) {
//                             $sponsoredBeep['expire_date'] = 'sponsored';
//                             $sponsoredBeep['media'] = json_decode($sponsoredBeep['media']);
//                             $data[] = $sponsoredBeep;
//                         }
//                         $key = array_search($sponsoredBeep, $availableSponsoredBeeps);
//                         if ($key !== false) {
//                             unset($availableSponsoredBeeps[$key]);
//                         }
//                     }
//                 }
//             }
//         }

//         $climateBeeps = ShareClimateBeep::where('status', '=', 'true')->get();
//         foreach ($climateBeeps as $c) {
//             $climate = Climate::where('id', '=', $c->climate_id)
//                 ->where('resident_country', '=', $user->country)
//                 ->first();
//             if ($climate) {
//                 $climate->likers = ClimateBeeplike::where('climate_id', '=', $climate->id)
//                     ->where('status', '=', 'true')
//                     ->get();
//                 $climate->comments = ClimateBeepComment::where('climate_id', '=', $climate->id)->get();
//                 $like = ClimateBeeplike::where('user_id', $id)
//                     ->where('climate_id', $climate->id)
//                     ->first();
//                 $climate->like_status = $like ? $like->status : false;

//                 $save = ClimateSaveBeep::where('user_id', $id)
//                     ->where('climate_id', $climate->id)
//                     ->first();
//                 $climate->save_status = $save ? $save->status : "false";

//                 $data[] = $climate;
//             }
//         }

//         $success['data'] = $data;
//         $success['status'] = 200;
//         $success['message'] = 'Data found successfully';
//       $success['pagination'] = [
//             'total' => $beeps->total(),
//             'per_page' => $beeps->perPage(),
//             'current_page' => $beeps->currentPage(),
//             'last_page' => $beeps->lastPage(),
//             'from' => $beeps->firstItem(),
//             'to' => $beeps->lastItem(),
//             'path' => $beeps->path()
//         ];

//         return response()->json(['success' => $success]);
//     }
// }


public function show_beep_filter(Request $request, $id)
{
    $user = User::find($id);

    if ($request->filter == "All") {
        $beepQuery = Beep::where('status', '=', 'Active');
    } elseif ($request->filter == "My Country") {
        $beepQuery = Beep::where('country', $user->country)
            ->where('status', '=', 'Active');
    } elseif ($request->filter == "My location") {
        $beepQuery = Beep::where('location', $user->location)
            ->where('status', '=', 'Active');
    } else {
        $beepQuery = Beep::where('country', $user->country)
            ->where('location', $user->location)
            ->where('status', '=', 'Active');
    }

    $beeps = $beepQuery->orderBy('created_at', 'desc')->get();

    // Shuffle the normal beeps
    $shuffledBeeps = $beeps->shuffle();

    // Fetch sponsored beeps
    $availableSponsoredBeeps = SponsoredBeep::where('location', '=', $user->location)->where('country', '=', $user->country)->where('status', '=', 'Active')->where('device_type', '=', $user->device_name)->get()->toArray();

    $data = [];
    $sponsoredBeepCounter = 0;

    foreach ($shuffledBeeps as $index => $b) {
        // Format counts and other properties
        $b['edit_status'] = $b->edit_status == 1 ? 'Edited' : $b->edit_status;
        $b['share'] = $this->formatCount($b->share);
        $b['comment'] = $this->formatCount($b->comment);
        $b['like'] = $this->formatCount($b->like);
        $b['time_elapsed'] = Carbon::parse($b->created_at)->diffForHumans();
        $b['media'] = json_decode($b->media);

        $beepUser = User::find($b->user_id);
        if ($beepUser) {
            if ($b->anonymous == 'Yes') {
                $beepUser->firstname = $b->reference_code;
                $beepUser->profile_image = 'https://kacinew.s3.amazonaws.com/admin-profile/1691395550.svg';
            }
            $b['user'] = $beepUser;
            $b['like_status'] = BeepLike::where('user_id', $id)->where('beep_id', $b->id)->first()->status ?? false;
            $b['save_status'] = BeepSave::where('user_id', $id)->where('beep_id', $b->id)->first()->status ?? "false";
            $b['report_status'] = ReportItem::where('user_id', $b->user_id)->where('item_id', $b->id)->where('type', 'Beep')->first()->status ?? "false";
            
            
              $comment = BeepComment::where('beep_id', $b->id)->get();
              
                foreach ($comment as $c) {
                    
                   $c['like'] =  $this->formatCount($c->like);
                    
                    $reportItem = ReportItem::where('user_id', $user->id)->where('item_id', '=', $c->id)->where('type', '=', 'Comment')->first();
                    $c['report_status'] = $reportItem ? $reportItem->status : false;
                    $created_at = Carbon::parse($c->created_at);
                    $c['time_elapsed'] = $created_at->diffForHumans();
                    $c['comment_reply'] = CommentReply::where('comment_id', '=', $c->id)->where('beep_id', '=', $c->beep_id)->get();
                    $c['comment_likes'] = CommentLike::where('comment_id', '=', $c->id)->get();
                }
                $b['comments'] = $comment;
            
        } else {
            // Handle the case where the beep was created by the admin without a user ID
            $b['user'] = [
                'firstname' => 'Admin',
                'profile_image' => 'https://kacinew.s3.amazonaws.com/admin-profile/1691395550.svg'
            ];
            $b['like_status'] = false;
            $b['save_status'] = "false";
            $b['report_status'] = "false";
            
              $comment = BeepComment::where('beep_id', $b->id)->get();
              
                foreach ($comment as $c) {
                    $reportItem = ReportItem::where('user_id', $user->id)->where('item_id', '=', $c->id)->where('type', '=', 'Comment')->first();
                    $c['report_status'] = $reportItem ? $reportItem->status : false;

                    $created_at = Carbon::parse($c->created_at);
                    $c['time_elapsed'] = $created_at->diffForHumans();

                    $c['comment_reply'] = CommentReply::where('comment_id', '=', $c->id)->where('beep_id', '=', $c->beep_id)->get();
                    $c['like'] =  $this->formatCount($c->like);
                
                    $c['comment_likes'] = CommentLike::where('comment_id', '=', $c->id)->get();
                }
                $b['comments'] = $comment;
        }

        $data[] = $b;

        // Insert sponsored beeps after every 3 normal beeps
        $sponsoredBeepCounter++;
        if ($sponsoredBeepCounter % 3 == 0 && !empty($availableSponsoredBeeps)) {
            $sponsoredBeep = array_shift($availableSponsoredBeeps);
            if (Carbon::parse($sponsoredBeep['expire_date'])->isFuture()) {
                $sponsoredBeep['expire_date'] = 'sponsored';
                $sponsoredBeep['media'] = json_decode($sponsoredBeep['media']);
                $data[] = $sponsoredBeep;
            }
        }
    }

    // Process climate beeps
    $climateBeeps = ShareClimateBeep::where('status', '=', 'true')->get();
    foreach ($climateBeeps as $c) {
        
        $climate = Climate::where('id', '=', $c->climate_id)->where('resident_country', '=', $user->country)->first();
        if ($climate) {
            $climate->likers = ClimateBeeplike::where('climate_id', '=', $climate->id)->where('status', '=', 'true')->get();
            $climate->comments = ClimateBeepComment::where('climate_id', '=', $climate->id)->get();
            $climate->like_status = ClimateBeeplike::where('user_id', $id)->where('climate_id', $climate->id)->first()->status ?? false;
            $climate->save_status = ClimateSaveBeep::where('user_id', $id)->where('climate_id', $climate->id)->first()->status ?? "false";
            $data[] = $climate;
        }
    }

    $success['data'] = $data;
    $success['status'] = 200;
    $success['message'] = 'Data found successfully';

    return response()->json(['success' => $success]);
}

private function formatCount($count)
{
    if ($count >= 1000000) {
        return round($count / 1000000, 1) . 'M';
    } elseif ($count >= 1000) {
        return round($count / 1000, 1) . 'k';
    }
    return $count;
}


    public function delete_user_beep($id, $beep_id)
    {

        $beep = Beep::where('user_id', '=',  $id)->where('id', '=', $beep_id)->first();
        if ($beep) {

            $beep->status  =  'Inactive';
            $beep->save();

            $success['message'] =  'Beep Deleted Successfully';
            $success['data'] =  $beep;

            return response()->json(['success' => $success]);
        } else {

            $success['status'] = 400;
            $success['message'] =  'No beeps found';

            return response()->json(['error' => $success]);
        }
    }



    public function edit_beep(Request $request, $id)
    {
        $beep = Beep::find($id);

        if ($beep) {
            if ($request->title) {
                $beep->title = $request->title;
            }

            if ($request->description) {
                $beep->description = $request->description;
            }

            if ($request->location) {
                $beep->location = $request->location;
            }

            if ($request->country) {
                $beep->country =  $request->country;
            }

            if ($request->anonymous) {
                $beep->anonymous = $request->anonymous;
            }
            
            if($request->featured){
                $beep->featured = $request->featured;
            }


            if ($request->has('media')) {
                $mediaFiles = [];
                foreach ($request->file('media') as $mediaFile) {

                    $mediaObject = new \stdClass();

                    $extension = $mediaFile->getClientOriginalExtension();

                    if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {

                        $mediaObject->type = 'image';
                    } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'bin'])) {

                        $mediaObject->type = 'video';
                    } elseif (in_array($extension, ['mp3', 'ogg', 'wav'])) {

                        $mediaObject->type = 'audio';
                    } elseif (in_array($extension, ['pptx', 'ppt'])) {

                        $mediaObject->type = 'presentation';
                    } elseif (in_array($extension, ['docx', 'doc'])) {

                        $mediaObject->type = 'document';
                    } elseif (in_array($extension, ['pdf'])) {

                        $mediaObject->type = 'pdf';
                    } else {
                        $mediaObject->type = 'other';
                    }

                    $mediaName = rand(1000, 9999) . '.' . $extension;
                    $path = $mediaFile->storeAs('beep-media', $mediaName, ['disk' => 's3']);
                    $mediaObject->url = 'https://storage.kacihelp.com/beep-media' . $path;

                    $mediaFiles[] = $mediaObject;
                }
                

                $beep->media = json_encode($mediaFiles);
            }
            
            
            $beep->edit_status = 1;

            $beep->save();

            $success['status'] = 200;
            $success['message'] = 'Beep updated successfully';
            $success['data'] = $beep;

            return response()->json(['success' => $success]);
        } else {
            $success['status'] = 400;
            $success['message'] = 'Beep not found';

            return response()->json(['success' => $success]);
        }
    }



// shared beeps 




public function store_share_beep(Request $request, $id, $beep_id){
    
    
    $sharedBeep  = SharedBeep::create([
        'user_id' => $id,
        'beep_id' => $beep_id,
        'text' => $request->text,
        'status' => 'true'
        ]);
        
    $beep = Beep::find($beep_id);    
    $beep->share = $beep->share + 1;
    
    $beep->save();
            
    $success['status'] = 200;
    $success['message'] = 'Beep share successfully';
    $success['data'] =  $sharedBeep;
        
    return response()->json(['success' => $success]);
    
}






public function edit_share_beep(Request $request ,$id){
    
    $sharebeep  = SharedBeep::find($id);
    
    if($sharebeep){
        
        if($request->text){
            
            $sharebeep->text =  $request->text;
        }
        
        $sharebeep->save();
        
        
        $success['status'] = 200;
        $success['message'] = 'Updated successfully';
        $success['data'] = $sharebeep;
        
        
        return response()->json(['success' => $success]);
        
    }else{
        
        $success['status'] = 400;
        $success['message'] = 'Not found';
        
        return response()->json(['success' => $success]);
    }

}


public function delete_share_beep($id){
    
    $sharebeep = SharedBeep::find($id);
    
    $sharebeep->delete();
    
    $success['status'] = 200;
    $success['message'] = 'Share beep deleted successfully';
    $success['data'] = $sharebeep;
    
    return response()->json(['success' => $success]);
}





public function share_climate_beep($id, $climate_id){
    
    
    $climateBeep  = ShareClimateBeep::create([
        'user_id' => $id,
        'climate_id' => $climate_id,
        'status' => 'true'
        ]);
        
        $success['status'] = 200;
        $success['message'] = 'Climate share successfully';
        $success['data'] =  $climateBeep;
        
        return response()->json(['success' => $success]);
}



public function delete_climate_beep($id){
    
    $climateBeep = ShareClimateBeep::find($id);
    $climateBeep->delete();
    
    
    $success['status'] = 200;
    $success['message'] = 'climate beep deleted successfully';
    $success['data'] = $climateBeep;
    
    return response()->json(['success' => $success]);
    
    
}

    // reportitems

 public function store_report_item(Request $request, $id, $item_id)
    {

        $existingReport = ReportItem::where('item_id', $item_id)
            ->where('user_id', $id)
            ->where('type', '=', $request->type)
            ->first();


        if ($existingReport) {
            if ($existingReport->status == 'false') {
                $existingReport->status = 'true';
            } else {
                $existingReport->status = 'false';
            }
            $existingReport->save();

            $reportItem = $existingReport;
            
            
        } else {

         $type = $request->type === 'Beep'  ? 'Beep': ($request->type === 'Comment' ? 'Comment' : 'Profile');
            
            if($type == 'Beep'){
                
                $reportItem_country = Beep::find($item_id);
                
            }else if($type == 'Comment'){
                
                $comment = BeepComment::find($item_id);
                $reportItem_country = Beep::find($comment->beep_id);
        
            }else{
                
               $reportItem_country =  User::find($item_id);
            }

            $reportItem = ReportItem::create([
                'type' => $type,
                'item_id' => $item_id,
                'user_id' => $id,
                'status' => 'true',
                'country' => $reportItem_country->country
            ]);

            $user = User::find($id);

            if ($user) {
                $new_id = ($user->device_name === 'Android' ? 'AND' : 'IOS') . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                $user->new_id = $new_id;
                $user_ksn = 'KSN' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
            }

            $beepReferenceCode = null;
            
            if ($type == 'Beep') {
                $beep = Beep::where('id', $item_id)->first();
                if ($beep) {
                    $beepReferenceCode = $beep->reference_code;
                }
            }

            $subAdmins = Sub_Admin::all();
            if ($subAdmins->count() > 0) {
                
                if ($type == 'Beep') {
                    
                    $notificationMessage = "Beep ({$beepReferenceCode}) has been reported by {$user_ksn}";
                    
                } elseif ($type == 'Comment') {
                    
                    $notificationMessage = "Comment (CMT" . str_pad($item_id, 10, '0', STR_PAD_LEFT) . ") has been reported by {$user_ksn}";
                    
                } else {
                    $notificationMessage = "User ({$user_ksn}) has been reported by {$user_ksn}";
                }
                
                
                foreach ($subAdmins as $subAdmin) {
                    
                    Admin_Notification::create([
                        'user_id' => $user->id,
                        'u_id' => $user->new_id,
                        'notification' => $notificationMessage,
                        'name' => $user->firstname,
                        'status' => 'Unread',
                        'sub_admin_id' => $subAdmin->id
                    ]);
                }
            }

            $notification = Notification::create([
                'user_id' => $reportItem->user_id,
                'title' => $user->firstname . ' reported your' . $request->type,
                'status' => 'Unread',
                'type' => $request->type == 'Beep' ? 'Beep' : 'Comment',
                'item_id' => $item_id
            ]);

            $notifyUser = User::find($reportItem->user_id);

            $content = [
                'en' => $user->firstname . ' reported your' . $request->type,
            ];
            $fields = [
                'app_id' => env('a548e8e7-f1d6-44f5-8863-bb4d1edaf004'),
                'include_player_ids' => [$notifyUser->device_token],
                'contents' => $content,
            ];

            $fields = json_encode($fields);

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => "https://onesignal.com/api/v1/notifications",
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json; charset=utf-8',
                    'Authorization: Basic ' . env('a548e8e7-f1d6-44f5-8863-bb4d1edaf004')
                ],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $fields,
                CURLOPT_SSL_VERIFYPEER => false,
            ]);

            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);


            if ($request->type == 'Beep') {
                $reportItem = ReportItem::where('type', 'Beep')->first();
                if ($reportItem) {
                    $reportItem['report_type_id'] = $request->report_type_id;
                    $reportItem['description'] = $request->description;
                }
                $reportItem->save();
            }
            
            
            
             if ($request->type == 'Profile') {
                $reportItem = ReportItem::where('type', 'Profile')->first();
                if ($reportItem) {
                    $reportItem['report_type_id'] = $request->report_type_id;
                    $reportItem['description'] = $request->description;
                }
                $reportItem->save();
            }



            $adminemail = Admin_Email::find(1);

            if ($adminemail) {

                $email[] = $adminemail->email;

                foreach ($email as $key => $value) {
                    $emailAddress = str_replace(['[', ']', '\\', '\"'], '', $value);

                    $emailAddress = explode(',', $emailAddress);

                    foreach ($emailAddress as $email) {

                        $email = trim($email, "\"");
                        $dependentname = 'Admin';
                        $reportreason =  ReportType::find($reportItem->report_type_id);

                        Mail::to($email)->send(new BeepReportMail($notifyUser, $user, $reportItem, $reportreason));
                        // ,\"mmsodais@gmail.com\",\"adeoyetope@gmail.com\"]
                        $mail[] = $email;
                    }
                }
            }
        }

        $success['status'] = 200;
        $success['message'] = 'Item reported successfully';
        $success['data'] = $reportItem;

        return response()->json(['success' => $success]);
    }
    
    
    public function get_report_types()
    {
        $reportType  = ReportType::get();

        $success['status'] = 200;
        $success['message'] = 'All report types found successfully';
        $success['data'] =  $reportType;

        return response()->json(['success' => $success]);
    }

    public function get_search_beeps(Request $request, $id)
    {

        $request->validate([
            'text' => 'required'
        ]);

        $searchBeep = Beep::where('title', 'like', '%' . $request->text . '%')
            ->orWhere('description', 'like', '%' . $request->text . '%')
            ->get();

        foreach ($searchBeep as $b) {

            $b['user'] = User::find($b->user_id);
        }


        SearchHistory::create([
            'search_term' => $request->text,
            'user_id' => $id
        ]);

        if ($searchBeep->count() > 0) {
            $success['status'] = 200;
            $success['message'] = 'Data found successfully';
            $success['data'] = $searchBeep;

            return response()->json(['success' => $success]);
        } else {

            $success['status'] = 400;
            $success['message'] = 'No search result found for "' . $request->text . '=';

            return response()->json(['error' => $success]);
        }
    }



    public function get_recent_search($id)
    {

        $recentSearch  = SearchHistory::where('user_id', $id)->get();

        if ($recentSearch->count() > 0) {

            $success['status'] = 200;
            $success['message'] = 'Recent Searches found successfully';
            $success['data'] = $recentSearch;

            return response()->json(['success' => $success]);
        } else {

            $success['status'] = 400;
            $success['message'] = 'No recent searches';

            return response()->json(['error' => $success]);
        }
    }
    
    
    
    public function all_notification($id){
        
        
       $notification =  Notification::where('user_id', '=', $id)->orderBy('id', 'desc')->get();
       
       if($notification->count() > 0 ){
           
           foreach($notification as $n){
               
               if($n->type  == 'Consult'){
                   
                    $chat= Group_chat::where('module','=', $n->type)->first();
                    $chat->message = json_decode($chat->message);
                    $n->item =  $chat;
                   
               }else if($n->type  == 'Emergency'){
                   
                    $chat= Group_chat::where('module','=', $n->type)->first();
                    $chat->message = json_decode($chat->message);
                    $n->item =  $chat;
               }else if($n->type  == 'Travel'){
                     $chat= Group_chat::where('module','=', $n->type)->first();
                    $chat->message = json_decode($chat->message);
                    $n->item =  $chat;
               }else if($n->type  == 'Ambulance'){
                   
                    $chat= Group_chat::where('module','=', $n->type)->first();
                    $chat->message = json_decode($chat->message);
                    $n->item =  $chat;
               }else if($n->type  == 'Report'){
                   $chat= Group_chat::where('module','=', $n->type)->first();
                    $chat->message = json_decode($chat->message);
                    $n->item =  $chat;
               }else if($n->type  == 'Suggestion'){
                    $chat= Group_chat::where('module','=', $n->type)->first();
                    $chat->message = json_decode($chat->message);
                    $n->item =  $chat;
               }elseif($n->type  == 'Feedback'){
                    $chat= Group_chat::where('module','=', $n->type)->first();
                    $chat->message = json_decode($chat->message);
                    $n->item =  $chat;
               }elseif($n->type  == 'Beep'){
                   
                  $n->item =  Beep::find($n->item_id);
               }elseif($n->type == 'Comment'){
                   
                   $n->item = Comment::find($n->item_id);
               }
               
              $n->timeago =  $n->created_at->diffForHumans();
           }
           
       }
       
       $success['status']= 200;
       $success['message'] = 'All notifications found successfully';
       $success['data'] = $notification;
       
       return response()->json(['success' => $success], $this->successStatus);
    }
    
    
    public function read_notification(Request $request , $id){
        
        if($request->type == 'Admin'){
        
        $notification = Notification::find($id);
        
        if($notification){
            
            $notification->status = 'Read';
            $notification->save();
            
            $success['status'] = 200;
            $success['message'] = 'Notification read successfully';
            $success['data'] = $notification;
            
            return response()->json(['success' => $success], $this->successStatus);
            
        }else{
            
            $success['status'] = 400;
            $success['message'] = 'Not found';

            return response()->json(['error' => $success]);
        }
            
        }else{
            
            $notification =  Agency_Notification::find($id);
            
            if($notification){
                
                $notification->status = 'Read';
                $notification->save();
                
                $success['status']=200;
                $success['message'] = 'Notification Read successfully';
                $success['data'] =  $notification;
                
                return response()->json(['success' => $success]);
            }else{
                
                $error['status'] = 400;
                $error['message'] = 'Notification not found';
                
                return response()->json(['success' => $success]);
            }
        }
       
    }
}
