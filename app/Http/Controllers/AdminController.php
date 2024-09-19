<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Info_Bank;
use App\Models\Help_Book;
use App\Models\Country;
use App\Models\User;
use App\Models\Admin_Email;
use App\Models\Location;
use App\Models\Ambulance_Service;
use App\Models\Agencies;
use App\Models\Ambulance;
use App\Models\Travel;
use App\Models\Sos;
use App\Models\Report;
use App\Models\Suggestion;
use App\Models\Message;
use App\Models\Role;
use App\Models\Role_Privilage;
use App\Models\Sub_Admin;
use App\Models\Alert;
use App\Models\Setting;
use App\Models\Feedback;
use App\Models\General_Countries;
use App\Models\Relation;
use App\Models\Dependant;
use App\Models\Activity;
use App\Models\Medication;
use App\Models\Climate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResponseMail;
use App\Mail\AdminForgotMail;
use App\Mail\AdminPasswordMail;
use App\Models\Faq;
use App\Models\Used_Code;
use App\Models\Response;
use App\Models\Admin_Notification;
use App\Models\Popup;
use App\Models\Consult;
use App\Models\User_Location;
use App\Models\Kaci_Code;
use App\Models\Group_Chat;
use Carbon\Carbon;
use App\Models\Beep;
use App\Models\BeepLike;
use App\Models\BeepComment;
use App\Models\Auto_Reply;
use App\Models\ReportItem;
use App\Models\SponsoredBeep;
use App\Models\ReportType;
use App\Models\Sub_Account;
use App\Models\Notification;
use App\Models\Agency_Notification;
use App\Models\Ambulance_subaccount;


class AdminController extends Controller
{
    public $successStatus = 200;

    public function store_banner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'country' => 'required',
            'device' => 'required',


        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $image = time() . '.' . $request->file('image')->extension();
        $path = $request->file('image')->storeAs('banner', $image, ['disk' => 's3']);
        $url = Storage::disk('s3')->url('banner/' . $image);
        $input['image'] = "https://kaci-storage.s3.amazonaws.com/" . $path;
        if ($request->web_link) {
            $input['web_link'] = $request->web_link;
        }
        $banner = Banner::create($input);
        $success['data'] = $banner;
        $success['status'] = 200;
        $success['message'] = "New Banner created";


        return response()->json(['success' => $success], $this->successStatus);
    }

    public function edit_banner(Request $request, $id)
    {
        $banner = Banner::find($id);
        // $validator = Validator::make($request->all(), [
        //     'image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()]);

        // }
        $input = $request->all();
        if ($request->hasFile('image')) {
            $image = time() . '.' . $request->file('image')->extension();
            $path = $request->file('image')->storeAs('banner', $image, ['disk' => 's3']);
            $url = Storage::disk('s3')->url('banner/' . $image);
            $banner->image = "https://kaci-storage.s3.amazonaws.com/" . $path;
        } elseif ($request->filled('image')) {
            $banner->image = $request->image;
        }
        if ($request->title) {
            $banner->title = $request->title;
        }
        if ($request->web_link) {
            $banner->web_link = $request->web_link;
        }
        if ($request->country) {
            $banner->country = $request->country;
        }
        if ($request->device) {
            $banner->device = $request->device;
        }
        $banner->save();

        $success['data'] = $banner;
        $success['status'] = 200;
        $success['message'] = "Banner Edit Successfully";


        return response()->json(['success' => $success], $this->successStatus);
    }
    public function delete_banner($id)
    {
        $banner = Banner::find($id);
        if ($banner) {
            $banner->delete();
            $success['data'] = $banner;
            $success['status'] = 200;
            $success['message'] = "banner " . $banner->id . " successfully";


            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = "banner not found";


            return response()->json(['error' => $success]);
        }
    }


    public function store_info_bank(Request $request)
    {
        $validatedData = $request->validate([
            'toll' => 'required',
            'country' => 'required',
            'special_call_center.*.name' => 'required',
            'special_call_center.*.number' => 'required',
            'special_call_center.*.logo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        foreach ($validatedData['special_call_center'] as $index => $center) {
            $image = rand(00000, 5648421) . '.' . $center['logo']->extension();
            $path = $center['logo']->storeAs('info_back', $image, ['disk' => 's3']);
            $url = Storage::disk('s3')->url('info_back/' . $image);
            $validatedData['special_call_center'][$index]['logo'] = "https://kaci-storage.s3.amazonaws.com/" . $path;
        }
        $infoBank = new Info_Bank();
        $infoBank->toll = $validatedData['toll'];
        $infoBank->country = $validatedData['country'];
        $infoBank->special_call_center = json_encode($validatedData['special_call_center']);
        $infoBank->save();
        $code = Country::where('country', '=', $validatedData['country'])->first();

        $infoBank['flag_code'] = $code->flag_code;
        $success['data'] = $infoBank;
        $success['status'] = 200;


        return response()->json(['success' => $success], $this->successStatus);
        // Optionally, you can perform additional operations or redirect the user



        // Optionally, you can perform additional operations or redirect the user


    }
    public function delete_info_bank($id)
    {
        $info_bank = Info_Bank::find($id);
        $info_bank->delete();
        $success['data'] = $info_bank;
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }


    public function edit_info_bank(Request $request, $id)
    {

        $validatedData = $request->validate([
            'toll' => 'required',
            'country' => 'required',
            'special_call_center.*.name' => 'required',
            'special_call_center.*.number' => 'required',

        ]);

        $infoBank = Info_Bank::find($id);
        if (!$infoBank) {
            return response()->json(['error' => 'Info Bank not found'], 404);
        }

        $infoBank->toll = $validatedData['toll'];
        $infoBank->country = $validatedData['country'];
        if (isset($request['special_call_center'])) {
            $modifiedData = $request->all(); // Create a copy of the request data

            foreach ($modifiedData['special_call_center'] as $index => $center) {
                if (isset($center['logo'])) {
                    // Check if 'logo' is an image or text
                    if (is_string($center['logo'])) {
                        // Handle text data
                        $modifiedData['special_call_center'][$index]['logo'] = $center['logo'];
                    } elseif (isset($center['logo'])) {
                        // Handle image data
                        $image = rand(00000, 5648421) . '.' . $center['logo']->extension();
                        $path = $center['logo']->storeAs('info_back', $image, ['disk' => 's3']);
                        $url = Storage::disk('s3')->url('info_back/' . $image);

                        $modifiedData['special_call_center'][$index]['logo'] = "https://kaci-storage.s3.amazonaws.com/" . $path;
                        $success['hello'] = 'hello'; 
                    }
                }
            }

            // If you need to update the request data with the modified data, you can do this:
            $request->merge(['special_call_center' => $modifiedData['special_call_center']]);

            $infoBank->special_call_center = json_encode($modifiedData['special_call_center']);
        } else {
            $in = 'out';
        }

        $infoBank->save();

        $success['data'] = $infoBank;
        $success['status'] = 200;

        return response()->json(['success' => $success], $this->successStatus);
    }


    public function store_help_book(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'logo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'country' => 'required',
            'description' => 'required',
            'address' => 'required',
            'contact_number' => 'required',
            'website' => 'required',
            'email' => 'required',
            'images.*' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }


        $input = $request->all();




        $image = rand(0000, 9999) . '.' . $request->file('logo')->extension();

        $path = $request->file('logo')->storeAs('help_book_logo', $image, ['disk' => 's3']);
        $url = Storage::disk('s3')->url('help_book_logo/' . $image);
        $input['logo'] = "https://kaci-storage.s3.amazonaws.com/" . $path;

        // $uploadedImages = [];
        // foreach ($request->file('images') as $image) {
        //     $uploadedImage = rand(1000,9999). '.' . $image->extension();
        //     $path = $image->storeAs('help_book_images', $uploadedImage, ['disk' => 's3']);
        //     $url = Storage::disk('s3')->url('help_book_images/' . $uploadedImage);
        //     $uploadedImages[] = "https://storage.kacihelp.com/".$path;
        // }
        // $input['images'] = json_encode($uploadedImages);



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
                $path = $file->storeAs('help_book_images', $uploadedImage, ['disk' => 's3']);
                $uploadedFile->url = "https://kaci-storage.s3.amazonaws.com/" . $path;
                // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
                $uploadedFiles[] = $uploadedFile;
            }

            $input['images'] = json_encode($uploadedFiles);
        }




        $input['website_email'] = $request->website;
        $help = Help_Book::create($input);
        $help['website'] = $request->website;
        $success['data'] = $help;
        $success['status'] = 200;
        $success['message'] = 'created Successfully';

        return response()->json(['success' => $success], $this->successStatus);
    }

    public function delete_help_book($id)
    {
        $help = Help_Book::find($id);
        if ($help) {
            $help->delete();
            $success['status'] = 200;
            $success['message'] = 'deleted Successfully';

            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';

            return response()->json(['error' => $success]);
        }
    }


    public function edit_help_book(Request $request, $id)
    {
        $help = Help_Book::find($id);

        if ($help) {
            if ($request->title) {
                $help->title = $request->title;
            }
            if ($request->description) {
                $help->description = $request->description;
            }
            if ($request->status) {
                $help->status = $request->status;
            }
            if ($request->email) {
                $help->email = $request->email;
            }
            if ($request->country) {
                $help->country = $request->country;
            }
            if ($request->address) {
                $help->address = $request->address;
            }
            if ($request->contact_number) {
                $help->contact_number = $request->contact_number;
            }
            if ($request->website) {
                $help->website_email = $request->website;
            }

            if ($request->hasFile('logo')) {
                $image = time() . '.' . $request->file('logo')->extension();
                $path = $request->file('logo')->storeAs('help_book_logo', $image, ['disk' => 's3']);
                $url = Storage::disk('s3')->url('help_book_logo/' . $image);
                $help->logo = "https://kaci-storage.s3.amazonaws.com/" . $path;
            } elseif ($request->filled('logo')) {
                $help->logo = $request->logo;
            }
            if ($request->hasFile('images')) {
                // Array to store the uploaded files' details
                $uploadedFiles = [];

                // Loop through each uploaded file
                foreach ($request->file('images') as $file) {
                    $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

                    // Get the file extension
                    $extension = $file->extension();

                    // Determine the type of the file based on its extension
                    if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                        $uploadedFile->type = 'image';
                    } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
                        $uploadedFile->type = 'video';
                    } elseif (in_array($extension, ['mp3'])) {
                        $uploadedFile->type = 'audio';
                    } else {
                        // You can handle other file types if needed
                        $uploadedFile->type = 'unknown';
                    }

                    // Generate a unique filename for the uploaded image
                    $uploadedImage = rand(1000, 9999) . '.' . $file->extension();

                    // Store the uploaded image on the S3 disk
                    $path = $file->storeAs('help_book_images', $uploadedImage, ['disk' => 's3']);

                    // Set the URL of the uploaded image
                    $uploadedFile->url = "https://kaci-storage.s3.amazonaws.com/" . $path;

                    // Add the uploaded file details to the array
                    $uploadedFiles[] = $uploadedFile;
                }

                // Convert the array of uploaded files into JSON and store it in the 'images' property
                $help->images = $uploadedFiles;
            } elseif ($request->filled('images')) {
                // If no new images were uploaded but 'images' field is present in the request,
                // directly assign the value to the 'images' property
                $help->images = $request->images;
            }

            $help->save();
            $help['website'] = $request->website;

            $success['data'] = $help;
            $success['status'] = 200;
            $success['message'] = 'Updated Successfully';

            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';

            return response()->json(['error' => $success]);
        }
    }



    public function store_country(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country' => 'required|unique:country,country',
            'country_code' => 'required',
            'flag_code' => 'required',
            'emergency_number' => 'required',
            'local_number' => 'required',
            'gcare_email' => 'required',
            'admin_email' => 'required',
            'featured' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['country_name'] = $input['country'];
        $country = Country::create($input);
        $success['data'] = $country;
        $success['status'] = 200;
        $success['message'] = 'Country created Successfully';

        return response()->json(['success' => $success], $this->successStatus);
    }



    public function delete_country($id)
    {
        $country = Country::find($id);
        if ($country) {
            $country->delete();
            $success['data'] = $country;
            $success['status'] = 200;
            $success['message'] = 'Country found Successfully';

            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'Country Not found Successfully';

            return response()->json(['error' => $success]);
        }
    }


    public function edit_country(Request $request, $id)
    {
        $country = Country::find($id);
        if ($country) {
            if ($request->country) {
                $country->country = $request->country;
                $country->country_name = $request->country;
            }
            if ($request->flag_code) {
                $country->flag_code = $request->flag_code;
            }
            if ($request->country_code) {
                $country->country_code = $request->country_code;
            }
            if ($request->emergency_number) {
                $country->emergency_number = $request->emergency_number;
            }
            if ($request->status) {
                $country->status = $request->status;
            }
            if ($request->local_number) {
                $country->local_number = $request->local_number;
            }
            if ($request->gcare_email) {
                $country->gcare_email = $request->gcare_email;
            }
            if ($request->admin_email) {
                $country->admin_email = $request->admin_email;
            }
            if ($request->featured) {
                $country->featured = $request->featured;
            }

            $country->save();
            
            $success['data'] = $country;
            $success['status'] = 200;
            $success['message'] = 'Country updated Successfully';

            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'Country not found';

            return response()->json(['error' => $success]);
        }
    }



    public function store_location(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country' => 'required',

            'location' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $country = Location::create($input);
        $success['data'] = $country;
        $success['status'] = 200;
        $success['message'] = 'Location created Successfully';

        return response()->json(['success' => $success], $this->successStatus);
    }

    public function delete_location($id)
    {
        $country = Location::find($id);
        if ($country) {
            $country->delete();
            $success['data'] = $country;
            $success['status'] = 200;
            $success['message'] = 'Location found Successfully';

            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'location Not found Successfully';

            return response()->json(['error' => $success]);
        }
    }


    public function edit_location(Request $request, $id)
    {
        $country = Location::find($id);
        if ($country) {
            if ($request->country) {
                $country->country = $request->country;
            }
            if ($request->status) {
                $country->status = $request->status;
            }
            if ($request->location) {
                $country->location = $request->location;
            }
            $country->save();
            $success['data'] = $country;
            $success['status'] = 200;
            $success['message'] = 'Location updated Successfully';

            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'Location not found';

            return response()->json(['error' => $success]);
        }
    }



    public function store_ambulance_service(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:ambulance_service,title',
            'logo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'country' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
            'head_email1' => 'required',
            'head_email2' => 'required',
            'head_contact_number1' => 'required',
            'head_contact_number2' => 'required',
            'featured' => 'required',
            'location.*.location' => 'required',
            'location.*.email' => 'required',
            'location.*.phone' => 'required',




        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        };

        $input = $request->all();
        $image = time() . '.' . $request->file('logo')->extension();
        $path = $request->file('logo')->storeAs('ambulance_service_logo', $image, ['disk' => 's3']);
        $url = Storage::disk('s3')->url('ambulance_service_logo/' . $image);
        $input['logo'] = "https://kaci-storage.s3.amazonaws.com/" . $path;
        $infoBank = new  Ambulance_Service();
        $infoBank->title = $input['title'];
        $infoBank->logo = $input['logo'];

        $infoBank->location = json_encode($input['location']);
        $infoBank->head_email1 = $input['head_email1'];
        $infoBank->head_email2 = $input['head_email2'];
        $infoBank->head_contact_number1 = $input['head_contact_number1'];
        $infoBank->head_contact_number2 = $input['head_contact_number2'];
        $infoBank->country = $input['country'];
        $infoBank->contact_number = $input['contact_number'];
        $infoBank->address = $input['address'];
        $infoBank->featured = $input['featured'];
        $infoBank->save();
        $success['data'] = $infoBank;
        $success['status'] = 200;
        $success['message'] = 'created Successfully';

        return response()->json(['success' => $success], $this->successStatus);
    }




    public function delete_ambulance_service($id)
    {
        $service = Ambulance_Service::find($id);
        if ($service) {
            $service->delete();
            $success['status'] = 200;
            $success['message'] = 'deleted Successfully';

            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'Not Found';

            return response()->json(['error' => $success]);
        }
    }

    public function edit_ambulance_service(Request $request, $id)
    {
        $service = Ambulance_Service::find($id);
        if ($service) {
            if ($request->title) {
                $service->title = $request->title;
            }
            if ($request->country) {
                $service->country = $request->country;
            }

            if ($request->status) {
                $service->status = $request->status;
            }
            if ($request->contact_number) {
                $service->contact_number = $request->contact_number;
            }
            if ($request->address) {
                $service->address = $request->address;
            }
            if ($request->head_email1) {
                $service->head_email1 = $request->head_email1;
            }
            if ($request->head_email2) {
                $service->head_email2 = $request->head_email2;
            }
            if ($request->head_contact_number1) {
                $service->head_contact_number1 = $request->head_contact_number1;
            }
            if ($request->head_contact_number2) {
                $service->head_contact_number2 = $request->head_contact_number2;
            }
            if ($request->location) {
                $service->location = $request->location;
            }

            if ($request->featured) {
                $service->featured = $request->featured;
            }

            if ($request->hasFile('logo')) {
                $image = time() . '.' . $request->file('logo')->extension();
                $path = $request->file('logo')->storeAs('ambulance_service_logo', $image, ['disk' => 's3']);
                $url = Storage::disk('s3')->url('ambulance_service_logo/' . $image);
                $service->logo = "https://kaci-storage.s3.amazonaws.com/" . $path;
            } elseif ($request->filled('logo')) {
                $service->logo = $request->logo;
            }

            $service->save();

            $success['data'] = $service;
            $success['status'] = 200;
            $success['message'] = 'updated Successfully';

            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'Not Found';

            return response()->json(['error' => $success]);
        }
        
        
    }
    
    
    // public function get_subacc_ambulanceservice (Request $request , $id)
    // {
        
    //     $account  = Ambulance_subaccount::find($id);
        
    //     $ambulance  = Ambulance_Service::where('country', '=', $account->country)->get();
        
    //       if($ambulance){
              
    //           $success['status'] = 200;
    //           $success['message'] = 'Found successfully';
    //           $success['data'] =  $ambulance;
               
    //           return response()->json(['success' => $success]);
    //       }else{
              
              
    //           $error['status'] = 400;
    //           $error['message'] = 'Not found';
              
    //           return response()->json(['error' => $error]);
    //       }
    // }
    
    // // public function create_ambulance_subaccounts(Request $request , $id){
        
    // //     $request->validate([
    // //         'name' => 'required',
    // //         'email' => 'required',
    // //         'password' => 'required',
    // //         'phone_number' => 'required',
    // //         'country' => 'required',
    // //         'profile_image' => 'required'
    // //         ]);
            
        
    // //     $input  = $request->all();
    
    // //     $input['ambulance_id'] =  $id;
        
    // //   if ($request->hasfile('profile_image')) {
           
    // //             $image = rand(00000000000, 35321231251231) . '.' . $request->file('profile_image')->extension();
    // //             $path = $request->file('profile_image')->storeAs('profile', $image, ['disk' => 's3']);
    // //             $url = Storage::disk('s3')->url('profile/' . $image);
    // //             $input['profile_image'] = "https://storage.kacihelp.com/" . $path;
                
    // //         }
    // //     $accounts  = Ambulance_subaccount::create($input);
        
    // //     $success['status'] = 200;
    // //     $success['message'] = 'Sub account created successfully';
    // //     $success['data'] =  $accounts;
        
    // //     return response()->json(['success' => $success]);
    // // }
    
    
    
    
    // // public function edit_ambulance_serivce_accounts(Request $request , $id){
        
    // //     $ambulance = Ambulance_subaccount::find($id);
    // //     if($ambulance){
            
    // //         if($request->name){
    // //             $ambulance->name  =  $request->name;
    // //         }
    // //         if($request->email){
    // //             $ambulance->email =  $request->email;
    // //         }
    // //         if($request->password){
    // //             $ambulance->password =  $request->password;
    // //         }
    // //         if($request->phone_number){
    // //             $ambulance->phone_number = $request->phone_number;
    // //         }
            
    // //         if($request->country){
    // //             $ambulance->country =  $request->country;
    // //         }
            
    // //         if($request->status){
    // //             $ambulance->status = $request->status;
    // //         }
            
    // //         if ($request->hasfile('profile_image')) {
    // //         $image = rand(00000000000, 35321231251231) . '.' . $request->file('profile_image')->extension();
    // //         $path = $request->file('profile_image')->storeAs('profile', $image, ['disk' => 's3']);
    // //         $ambulance->profile_image = "https://storage.kacihelp.com/" . $path;
    // //         }
            
    // //         if($request->previlages){
    // //             $ambulance->previlages = $request->previlages;
    // //         }
            
    // //         $ambulance->save();
            
    // //         $success['status'] = 200;
    // //         $success['message'] = 'Updated successfully';
    // //         $success['data'] = $ambulance;
            
    // //         return response()->json(['success' => $success]);
            
    // //     }else{
            
            
    // //         $error['status'] = 400;
    // //         $error['message'] = 'not found';
            
    // //         return response()->json(['error' => $error]);
    // //     }
    // // }

    // // public function delete_ambulance_service_accounts($id){
        
    // //     $account = Ambulance_subaccount::find($id);
        
    // //     $account->delete();
        
    // //     $success['status'] = 200;
    // //     $success['message'] = 'Delete successfully';
    // //     $success['data'] =  $account;
        
    // //     return response()->json(['success' => $success]);
    // // }
    
    
    // // public function get_ambulance_subaccount($id){
        
    // //     $account = Ambulance_subaccount::find($id);
        
    // //     if($account){
            
    // //         $success['status'] = 200;
    // //         $success['message'] = 'Account found successfully';
    // //         $success['data'] =  $account;
            
    // //         return response()->json(['success' => $success]);
    // //     }else{
            
    // //         $error['status'] = 200;
    // //         $error['message'] = 'not found';
            
    // //         return response()->json(['error' => $error]);
    // //     }
    // // }
    
    
    // // public function get_ambulance_accounts($id){
        
    // //     $accounts  = Ambulance_subaccount::where('ambulance_id', '=', $id)->get();
        
    // //     if($accounts->count() > 0){
            
    // //         $success['status'] = 200;
    // //         $success['message'] = 'Accounts found successfully';
    // //         $success['data'] =  $accounts;
            
    // //         return response()->json(['success' => $success]);
    // //     }else{
            
    // //         $error['status'] = 400;
    // //         $error['message'] = 'Not found';
            
    // //         return response()->json(['error' => $error]);
    // //     }
    // // }
    
    
    
    


    public function store_agencies(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:agencies,title',
            'logo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'country' => 'required',
            'password' => 'required',
            'email' => 'required',
            'website' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
            'head_email1' => 'required',
            'head_email2' => 'required',
            'head_contact_number1' => 'required',
            'head_contact_number2' => 'required',
            'featured' => 'required',
            'location.*.location' => 'required',
            'location.*.email' => 'required',
            'location.*.phone' => 'required',
            'modules' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        };

        $input = $request->all();
        $image = time() . '.' . $request->file('logo')->extension();
        $path = $request->file('logo')->storeAs('agencies_logo', $image, ['disk' => 's3']);
        $url = Storage::disk('s3')->url('agencies_logo/' . $image);
        $input['logo'] = "https://kaci-storage.s3.amazonaws.com/" . $path;
        $infoBank = new  Agencies();
        $infoBank->title = $input['title'];
        $infoBank->logo = $input['logo'];
        $infoBank->website = $input['website'];
        $infoBank->location = json_encode($input['location']);
        $infoBank->head_email1 = $input['head_email1'];
        $infoBank->head_email2 = $input['head_email2'];
        $infoBank->head_contact_number1 = $input['head_contact_number1'];
        $infoBank->head_contact_number2 = $input['head_contact_number2'];
        $infoBank->country = $input['country'];
        $infoBank->contact_number = $input['contact_number'];
        $infoBank->address = $input['address'];
        $infoBank->featured = $input['featured'];
        $infoBank->password = $input['password'];
        $infoBank->email = $input['email'];
        $infoBank->modules = $input['modules'];
        $infoBank->status = $input['status'];
        $infoBank->save();
        $success['data'] = $infoBank;
        $success['status'] = 200;
        $success['message'] = 'created Successfully';

        return response()->json(['success' => $success], $this->successStatus);
    }



    public function delete_agencies($id)
    {
        $service = Agencies::find($id);
        
        if ($service) {
            $service->delete();
            $success['status'] = 200;
            $success['message'] = 'deleted Successfully';

            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'Not Found';

            return response()->json(['error' => $success]);
        }
    }



    public function edit_agencies(Request $request, $id)
    {
        $service = Agencies::find($id);
        if ($service) {
            if ($request->title) {
                $service->title = $request->title;
            }
            if ($request->country) {
                $service->country = $request->country;
            }
            if ($request->website) {
                $service->website = $request->website;
            }
            if ($request->contact_number) {
                $service->contact_number = $request->contact_number;
            }
            if ($request->address) {
                $service->address = $request->address;
            }
            if ($request->password) {
                $service->password = $request->password;
            }
            if ($request->email) {
                $service->email = $request->email;
            }
            if ($request->status) {
                $service->status = $request->status;
            }
            if ($request->head_email1) {
                $service->head_email1 = $request->head_email1;
            }
            if ($request->modules) {
                $service->modules = $request->modules;
            }
            if ($request->status) {
                $service->status = $request->status;
            }
            if ($request->head_email2) {
                $service->head_email2 = $request->head_email2;
            }
            if ($request->head_contact_number1) {
                $service->head_contact_number1 = $request->head_contact_number1;
            }
            if ($request->head_contact_number2) {
                $service->head_contact_number2 = $request->head_contact_number2;
            }
            if ($request->location) {
                $service->location = $request->location;
            }
            if ($request->featured) {
                $service->featured = $request->featured;
            }
            if ($request->hasFile('logo')) {
                $image = time() . '.' . $request->file('logo')->extension();
                $path = $request->file('logo')->storeAs('agencies_logo', $image, ['disk' => 's3']);
                $url = Storage::disk('s3')->url('agencies_logo/' . $image);
                $service->logo = "https://kaci-storage.s3.amazonaws.com/" . $path;
            } elseif ($request->filled('logo')) {
                $service->logo = $request->logo;
            }

            $service->save();
            $success['data'] = $service;
            $success['status'] = 200;
            $success['message'] = 'updated Successfully';

            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'Not Found';

            return response()->json(['error' => $success]);
        }
    }

    public function delete_feedback($id)
    {
        $feedback = Feedback::find($id);
        if ($feedback) {
            $feedback->delete();
            $success['status'] = 200;
            $success['message'] = 'deleted successfully';
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 404;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }



    public function edit_feedback(Request $request, $id)
    {
        $feedback = Feedback::find($id);

        // if ($request->hasFile('image')) {
        //     $uploadedImages = [];
        //     foreach ($request->file('image') as $image) {
        //         $uploadedImage =rand(1000,9999). '.' . $image->extension();
        //         $path = $image->storeAs('feedback_images', $uploadedImage, ['disk' => 's3']);
        //         $url = Storage::disk('s3')->url('feedback_images/' . $uploadedImage);
        //         $uploadedImages[] = "https://storage.kacihelp.com/".$path;
        //     }
        //     $feedback->image = json_encode($uploadedImages);
        // } elseif ($request->filled('image')) {
        //     $feedback->image = $request->image;
        // }

        if ($request->ksn) {
            $feedback->ksn = $request->ksn;
        }
        if ($request->name) {
            $feedback->name = $request->name;
        }
        if ($request->phone_number) {
            $feedback->phone_number = $request->phone_number;
        }
        if ($request->country) {
            $feedback->country = $request->country;
        }
        if ($request->status) {
            $feedback->status = $request->status;
            if ($request->status === 'Resolved') {
                $u = User::find($feedback->user_id);
                $u->notify_count = $u->notify_count + 1;
                $u->save();
                $playerId = [$u->device_token];
                $subject = 'The status of Feedback ' . $feedback->reference_code . ' is now RESOLVED';

                if ($u->language === 'English') {
                    // No translation needed, use the original sentence in English.
                    $translated_sentence = $subject;
                } elseif ($u->language === 'Yoruba') {
                    // Translate to Yoruba
                    $translated_sentence = 'Awọn iwọsọna ti Feedback ' . $feedback->reference_code . ' ni yoo ti wa nile lọ.';
                } elseif ($u->language === 'Igbo') {
                    // Translate to Igbo
                    $translated_sentence = 'Akwụkwọ nke Feedback ' . $feedback->reference_code . ' bụ ugbu a.';
                } elseif ($u->language === 'French') {
                    // Translate to French
                    $translated_sentence = 'L\'état de l\'Feedback ' . $feedback->reference_code . ' est désormais RÉSOLU.';
                } elseif ($u->language === 'Hausa') {
                    // Translate to Hausa
                    $translated_sentence = 'Nau\'in matsayin Feedback ' . $feedback->reference_code . ' yana harsashi.';
                } elseif ($u->language === 'Arabic') {
                    // Translate to Arabic
                    $translated_sentence = 'حالة الإسعاف ' . $feedback->reference_code . ' الآن مُحَلَّة.';
                } elseif ($u->language === 'Chinese') {
                    // Translate to Chinese
                    $translated_sentence = '救护车状态 ' . $feedback->reference_code . ' 现已解决。';
                } elseif ($u->language === 'Spanish') {
                    // Translate to Spanish
                    $translated_sentence = 'El estado de la Feedback ' . $feedback->reference_code . ' ahora está RESUELTO.';
                } elseif ($u->language === 'Portuguese') {
                    // Translate to Portuguese
                    $translated_sentence = 'O estado da Feedback ' . $feedback->reference_code . ' agora está RESOLVIDO.';
                } elseif ($u->language === 'Fula') {
                    // Translate to Fula
                    $translated_sentence = 'Nadata na Feedback ' . $feedback->reference_code . ' yana RESOLVED yanzu.';
                } else {
                    // Default to English if the language preference is not recognized.
                    $translated_sentence = $subject;
                }


                $content = array(
                    "en" => $translated_sentence,
                );
                $fields = array(
                    'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                    'ios_badgeType' => "Increase",
                    'ios_badgeCount' =>  $u->notify_count,
                    'include_player_ids' =>   $playerId,
                    'data' => array("foo" => "NewMassage"),
                    'contents' => $content
                );

                $fields = json_encode($fields);


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json; charset=utf-8',
                    'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($ch);
                curl_close($ch);
            }
        }
        if ($request->admin) {
            $feedback->admin = $request->admin;
        }
        if ($request->response) {
            $feedback->response = $request->response;
        }
        if ($request->created_at) {
            $feedback->created_at = $request->created_at;
        }
        if ($request->device) {
            $feedback->device = $request->device;
        }
        if ($request->reference_code) {
            $feedback->reference_code = $request->reference_code;
        }


        $feedback->save();
        $users = User::find($feedback->user_id);
        if ($users) {
            $feedback['firstname'] = $users->firstname;
            $feedback['lastname'] = $users->lastname;
            $feedback['email'] = $users->email;
            $feedback['ksn'] = $users->ksn;
            $feedback['phone_number'] = $users->phone_number;
            $feedback['profile_image'] = $users->profile_image;
        }
        $success['data'] = $feedback;
        $success['status'] = 200;
        $success['message'] = 'updated successfully';
        return response()->json(['success' => $success], $this->successStatus);
    }


    public function show_feedback($id)
    {
        $feedback = Feedback::find($id);
    
        if ($feedback) {
            
            $feedback->image = json_decode($feedback->images);
            
            $verifyBadge = Used_code::where('user_id', '=', $feedback->user_id)->where('expiry_date', '>', now())->first();
            if($verifyBadge){
                $feedback->verify_badge = true;
            }else{
                $feedback->verify_badge = false;
            }
            
            $feedback->guardians = Dependant::where('user_id', '=', $feedback->user_id)->get();
            
            
            $messages = Group_chat::where('module', '=', 'Feedback')->where('module_id', '=', $id)->first();
            if($messages){
                
                $chat = json_decode($messages->message);
                $chat->messages =  json_decode($chat->message);
            }
            
          $success['status'] =200;
          $success['message'] ='Data found successfully';
          $success['data'] = $feedback;
          
          return response()->json(['success' => $success],$this->successStatus);
           
           
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }


    public function feedback()
    {
        $feedback = Feedback::all();
        $data = [];
        foreach ($feedback as $a) {
            $user = User::find($a->user_id);
            if ($user) {
                
                   $verifyBadge = Used_code::where('user_id', $user->id)
                                             ->where('expiry_date', '>', now())
                                             ->first();
                    $a['verify_badge'] = $verifyBadge ? true : false;
                    
                    
                $a['email'] = $user->email;
                $a['firstname'] = $user->firstname;
                $a['lastname'] = $user->lastname;
                $a['profile_image'] = $user->profile_image;
                $a['phone_number'] = $user->phone_number;
                $a['email'] = $user->email;
                $a['ksn'] = $user->ksn;
                $country = General_Countries::where('country_name', '=', $user->country)->first();
                if ($country) {
                    $a['flag_code'] = $country->flag_code;
                    $a['country_code'] = $country->country_code;
                }
                $response = Response::where('type_id', '=', $a->id)->where('user_id', '=', $a->user_id)->where('type', '=', 'feedback')->get();
                if ($response->count() > 0) {
                    $responses = [];
                    foreach ($response as $res) {
                        $admin = Sub_Admin::where('name', '=', $res->admin_name)->first();
                        if ($admin) {
                            $res['admin_email'] = $admin->email;
                        }
                        $responses[] = $res;
                    }

                    $a['responses'] = $responses;
                }
            }
            $data[] = $a;
        }
        $success['data'] = $data;

        $success['status'] = 200;
        $success['message'] = 'found successfully';
        return response()->json(['success' => $success], $this->successStatus);
    }
    
    
    
    
    // public function show_agency_feedback(Request $request ,$id){
        
        
    //     $agency  = Sub_Account::find($id);
    //     $perpage = $request->per_page;
    //     $feedback  =Feedback::where('country', '=', $agency->country)->paginate($perpage);
        
    //     foreach($feedback as $f){
            
    //         $f['guardians'] = Dependant::where('user_id', '=', $f->user_id)->get();
            
    //         $verifyBadge = Used_code::where('user_id', '=' , $f->user_id)->where('expiry_date', '>', now())->first();
            
    //         if($verifyBadge){
                
    //             $f['verify_badge'] =  true;
    //         }else{
    //             $f['verify_badge'] =  false;
    //         }
    //     }
    
    //     $success['status'] = 200;
    //     $success['message'] =  'Data found successfully';
    //     $success['data'] =  $feedback;
        
        
    //     return response()->json(['success' => $success]);
        
    // }



public function show_agency_feedback($id){
        
        
$subaccount = Sub_Account::find($id);
 
    $decoded_ids = json_decode($subaccount->agency_id, true);

    $agencies = Agencies::whereIn('id', $decoded_ids)->get()->toArray();
    $agency_titles = array_column($agencies, 'title');

    $consults = [];
    
    if ($subaccount->country && !$subaccount->location) {

        $consults = Feedback::where('country', $subaccount->country)->get();
                           
                           
         foreach ($consults as $c) {
             
                    $c['last_message'] = null;                
                    $chats = Group_Chat::where('module_id', $c->id)->get();
                    foreach ($chats as $chat) {
                        $messages = json_decode($chat->message, true);
                        $c['last_message'] = $messages ? end($messages) : null;
                    }
            
                    $verifyBadge = Used_code::where('user_id', $c->user_id)
                                             ->where('expiry_date', '>', now())
                                             ->first();
                    $c['verify_badge'] = $verifyBadge ? true : false;
                    $c['guardians'] = Dependant::where('user_id', $c->user_id)->get();
                    $c['images'] = json_decode($c->images, true);
            
                    $user = User::find($c->user_id);
                    if ($user && $c->anonymous === 'Yes') {
                        $user->firstname = null;
                        $user->lastname = null;
                        $user->email = null;
                        $user->phone_number = null;
                        $user->ksn = null;
                        $c->ksn = null;
                    }
                    $c['user'] = $user;
             }
             
             
             
             $success['status'] = 200;
             $success['message'] = 'Country wise requests found successfully';
             $success['data'] = $consults;
             
             return response()->json(['success' => $success]);
                               
                           
    } else if ($subaccount->country) {
       
        //  $consults = Feedback::where('location',$subaccount->location)->get();
         $consults = Feedback::where('country',$subaccount->country)->get();
                           
             foreach ($consults as $c) {
                    $chats = Group_Chat::where('module_id', $c->id)->get();
                    foreach ($chats as $chat) {
                        $messages = json_decode($chat->message, true);
                        $c['last_message'] = $messages ? end($messages) : null;
                    }
            
                    $verifyBadge = Used_code::where('user_id', $c->user_id)
                                             ->where('expiry_date', '>', now())
                                             ->first();
                    $c['verify_badge'] = $verifyBadge ? true : false;
                    $c['guardians'] = Dependant::where('user_id', $c->user_id)->get();
                    $c['images'] = json_decode($c->images, true);
            
                    $user = User::find($c->user_id);
                    if ($user && $c->anonymous === 'Yes') {
                        $user->firstname = null;
                        $user->lastname = null;
                        $user->email = null;
                        $user->phone_number = null;
                        $user->ksn = null;
                        $c->ksn = null;
                    }
                    $c['user'] = $user;
             }
             
             
             
             $success['status'] = 200;
             $success['message'] = 'Country and location wise requests found successfully';
             $success['data'] = $consults;
             
             return response()->json(['success' => $success]);
                           
    }
        
    }


    public function delete_ambulance($id)
    {
        $ambulance = Ambulance::find($id);
        if ($ambulance) {
            $ambulance->delete();
            $success['data'] = $ambulance;
            $success['status'] = 200;
            $success['message'] = 'delete successfully';
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }


    public function show_ambulance($id)
    {
        $ambulance = Ambulance::find($id);
        if ($ambulance) {
            
            $ambulance->images =  json_decode($ambulance->images);
            
            $verifyBadge  = Used_code::where('user_id', '=', $ambulance->user_id)->where('expiry_date', '>', now())->first();
            if($verifyBadge){
                $ambulance->verify_badge = true;
            }else{
                $ambulance->verify_badge = false;
            }
            
             $guardians = Dependant::where('user_id', $ambulance->user_id)->get();
             if($guardians){
                 $ambulance->guardians = $guardians;
             }else{
                 $ambulance->guardians = null;
             }
             
             
            $messages =  Group_chat::where('module', '=', 'Ambulance')->where('module_id', '=', $id)->first();
            if($messages){
                
                $chat  = json_decode($messages->message);
                
                if($chat){
                    $ambulance->messages =  json_decode($chat->message);
                }else{
                    $ambulance->messages = null;
                }
            }
            
            $success['data'] = $ambulance;
            $success['status'] = 200;
            $success['message'] = 'found successfully';
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }


    public function ambulance()
    {
        $ambulance = Ambulance::all();
        $data = [];
        foreach ($ambulance as $a) {
            $verifyBadge = Used_code::where('user_id', $a->user_id)
                                         ->where('expiry_date', '>', now())
                                         ->first();
            $a['verify_badge'] = $verifyBadge ? true : false;
            $user = User::find($a->user_id);
            if ($user) {
                $a['firstname'] = $user->firstname;
                $a['lastname'] = $user->lastname;
                $a['profile_image'] = $user->profile_image;
                $a['phone_number'] = $user->phone_number;
                $a['email'] = $user->email;
                $a['ksn'] = $user->ksn;
                $country = General_Countries::where('country_name', '=', $user->country)->first();
                if ($country) {
                    $a['flag_code'] = $country->flag_code;
                    $a['country_code'] = $country->country_code;
                }
                $response = Response::where('type_id', '=', $a->id)->where('user_id', '=', $a->user_id)->where('type', '=', 'ambulance')->get();
                if ($response->count() > 0) {
                    $responses = [];
                    foreach ($response as $res) {
                        $admin = Sub_Admin::where('name', '=', $res->admin_name)->first();
                        if ($admin) {
                            $res['admin_email'] = $admin->email;
                        }
                        $responses[] = $res;
                    }

                    $a['responses'] = $responses;
                }
                $medication = Medication::where('user_id', '=', $user->id)->get();
                $a['medication'] = $medication;
            }
            $data[] = $a;
        }
        $success['data'] = $data;
        $success['status'] = 200;
        $success['message'] = 'found successfully';
        return response()->json(['success' => $success], $this->successStatus);
    }


    public function edit_ambulance(Request $request, $id)
    {
        $feedback = Ambulance::find($id);

        //         if ($request->hasFile('images')) {
        //               $uploadedFiles = [];

        //     foreach ($request->file('images') as $file) {
        //         $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

        //         $extension = $file->extension(); // Get the file extension

        //         // Determine the type of the file based on its extension
        //         if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
        //             $uploadedFile->type = 'image';
        //         } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
        //             $uploadedFile->type = 'video';
        //         } elseif (in_array($extension, ['mp3'])) {
        //             $uploadedFile->type = 'audio';
        //         }  else {
        //             // You can handle other file types if needed
        //             $uploadedFile->type = 'unknown';
        //         }
        //    $uploadedImage =rand(1000,9999). '.' . $file->extension();
        //     $path = $file->storeAs('ambulance_images', $uploadedImage, ['disk' => 's3']);
        //    $uploadedFile->url= $path;
        //         // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
        //         $uploadedFiles[] = $uploadedFile;
        //     }

        //    $feedback->images = json_encode($uploadedFiles);
        // } elseif ($request->filled('images')) {
        //             $feedback->images = $request->images;
        //         }

        if ($request->text) {
            $feedback->text = $request->text;
        }
        if ($request->name) {
            $feedback->name = $request->name;
        }
        if ($request->phone_number) {
            $feedback->phone_number = $request->phone_number;
        }
        if ($request->country) {
            $feedback->country = $request->country;
        }
        if ($request->status) {
            $feedback->status = $request->status;
            if ($request->status === 'Resolved') {
                $u = User::find($feedback->user_id);
                $u->notify_count = $u->notify_count + 1;
                $u->save();
                $playerId = [$u->device_token];
                $subject = 'The status of Ambulance ' . $feedback->reference_code . ' is now RESOLVED';

                if ($u->language === 'English') {
                    // No translation needed, use the original sentence in English.
                    $translated_sentence = $subject;
                } elseif ($u->language === 'Yoruba') {
                    // Translate to Yoruba
                    $translated_sentence = 'Awọn iwọsọna ti Ambulance ' . $feedback->reference_code . ' ni yoo ti wa nile lọ.';
                } elseif ($u->language === 'Igbo') {
                    // Translate to Igbo
                    $translated_sentence = 'Akwụkwọ nke Ambulance ' . $feedback->reference_code . ' bụ ugbu a.';
                } elseif ($u->language === 'French') {
                    // Translate to French
                    $translated_sentence = 'L\'état de l\'Ambulance ' . $feedback->reference_code . ' est désormais RÉSOLU.';
                } elseif ($u->language === 'Hausa') {
                    // Translate to Hausa
                    $translated_sentence = 'Nau\'in matsayin Ambulance ' . $feedback->reference_code . ' yana harsashi.';
                } elseif ($u->language === 'Arabic') {
                    // Translate to Arabic
                    $translated_sentence = 'حالة الإسعاف ' . $feedback->reference_code . ' الآن مُحَلَّة.';
                } elseif ($u->language === 'Chinese') {
                    // Translate to Chinese
                    $translated_sentence = '救护车状态 ' . $feedback->reference_code . ' 现已解决。';
                } elseif ($u->language === 'Spanish') {
                    // Translate to Spanish
                    $translated_sentence = 'El estado de la Ambulancia ' . $feedback->reference_code . ' ahora está RESUELTO.';
                } elseif ($u->language === 'Portuguese') {
                    // Translate to Portuguese
                    $translated_sentence = 'O estado da Ambulância ' . $feedback->reference_code . ' agora está RESOLVIDO.';
                } elseif ($u->language === 'Fula') {
                    // Translate to Fula
                    $translated_sentence = 'Nadata na Ambulans ' . $feedback->reference_code . ' yana RESOLVED yanzu.';
                } else {
                    // Default to English if the language preference is not recognized.
                    $translated_sentence = $subject;
                }


                $content = array(
                    "en" => $translated_sentence,
                );
                $fields = array(
                    'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                    'ios_badgeType' => "Increase",
                    'ios_badgeCount' =>  $u->notify_count,
                    'include_player_ids' =>   $playerId,
                    'data' => array("foo" => "NewMassage"),
                    'contents' => $content
                );

                $fields = json_encode($fields);


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json; charset=utf-8',
                    'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($ch);
                curl_close($ch);
            }
        }
        if ($request->admin) {
            $feedback->admin = $request->admin;
        }
        if ($request->response) {
            $feedback->response = $request->response;
        }
        if ($request->created_at) {
            $feedback->created_at = $request->created_at;
        }
        if ($request->device) {
            $feedback->device = $request->device;
        }
        if ($request->reference_code) {
            $feedback->reference_code = $request->reference_code;
        }
        if ($request->location) {
            $feedback->location = $request->location;
        }
        if ($request->address) {
            $feedback->address = $request->address;
        }
        if ($request->ambulance_service) {
            $feedback->ambulance_service = $request->ambulance_service;
        }
        if ($request->people_involved) {
            $feedback->people_involved = $request->people_involved;
        }
        if ($request->incidence_nature) {
            $feedback->incidence_nature = $request->incidence_nature;
        }
        if ($request->previous_hospital) {
            $feedback->previous_hospital = $request->previous_hospital;
        }
        if ($request->medication) {
            $feedback->medication = $request->medication;
        }
        if ($request->map) {
            $feedback->map = json_encode($request->map);
        }
        $feedback->save();
        $users = User::find($feedback->user_id);
        if ($users) {
            $feedback['firstname'] = $users->firstname;
            $feedback['lastname'] = $users->lastname;
            $feedback['phone_number'] = $users->phone_number;
            $feedback['email'] = $users->email;
            $feedback['ksn'] = $users->ksn;
            $feedback['profile_image'] = $users->profile_image;
        }
        $success['data'] =  $feedback;
        $success['status'] = 200;
        $success['message'] = 'updated successfully';
        return response()->json(['success' => $success], $this->successStatus);
    }

    // public function subaccount_ambulance_requests(Request $request ,$id){
        

    //     if($request->country){
            
    //         $ambulanceService = Ambulance_Service::find($id);
    
    //         $perpage =  $request->per_page;
       
    //         $ambulance  = Ambulance::where('ambulance_service', '=', $ambulanceService->title)->where('country', '=', $ambulanceService->country )->paginate($perpage);

            
    //         foreach($ambulance as $a){
                
                
                
    //                           $chat  = Group_Chat::where('module_id', $a->id)->get();
    //             $a['last_message'] = null;
        
    //           foreach($chat as $message){
                   
    //           $message  = json_decode($message->message);
    //             $lastmessage = end($message);
                 
    //                     if($lastmessage){
                            
    //                         $a['last_message'] = $lastmessage;
    //                     }
    //           }
                

                
    //             $a['guardians'] = Dependant::where('user_id', '=', $a->user_id)->get();
                
                
    //             $verifyBadge  = Used_Code::where('user_id', '=', $a->user_id)->where('expiry_date', '>', now())->first();
    //             if($verifyBadge){
                    
    //                 $a['verify_badge'] = true;
    //             }else{
                    
    //                 $a['verify_badge'] = false;
    //             }
    //         }
            
    //     }else{
            
    //         $perpage =  $request->per_page;
            
    //         $ambulanceService = Ambulance_Service::find($id);
       
    //         $ambulance  = Ambulance::where('ambulance_service', '=', $ambulanceService->title)->paginate($perpage);
            
    //         foreach($ambulance as $a){
                
                
                
    //                           $chat  = Group_Chat::where('module_id', $a->id)->get();
    //             $a['last_message'] = null;
        
    //           foreach($chat as $message){
                   
    //           $message  = json_decode($message->message);
    //             $lastmessage = end($message);
                 
    //                     if($lastmessage){
                            
    //                         $a['last_message'] = $lastmessage;
    //                     }
    //           }
                

                
    //             $a['guardians'] = Dependant::where('user_id', '=', $a->user_id)->get();
                
                
    //             $verifyBadge  = Used_Code::where('user_id', '=', $a->user_id)->where('expiry_date', '>', now())->first();
    //             if($verifyBadge){
                    
    //                 $a['verify_badge'] = true;
    //             }else{
                    
    //                 $a['verify_badge'] = false;
    //             }
                
                
                
    //         }
            
            
    //     }
        


    //     $success['status'] = 200;
    //     $success['message'] = 'Data found successfully';
    //     $success['data'] =  $ambulance;
        
    //     return response()->json(['success' => $success]);

    // }



public function subaccount_ambulance_requests($id){
        
$subaccount = Sub_Account::find($id);
 
    $decoded_ids = json_decode($subaccount->ambulance_service_id, true)?? [];

    $agencies = Ambulance_Service::whereIn('id', $decoded_ids)->get()->toArray();
    $agency_titles = array_column($agencies, 'title');

    $consults = [];
    
    if ($subaccount->country && !$subaccount->location) {

        $consults = Ambulance::whereIn('ambulance_service', $agency_titles)
                           ->where('country', $subaccount->country)
                           ->get();
                           
                           
         foreach ($consults as $c) {
             
                    $c['last_message'] = null;                
                    $chats = Group_Chat::where('module_id', $c->id)->get();
                    foreach ($chats as $chat) {
                        $messages = json_decode($chat->message, true);
                        $c['last_message'] = $messages ? end($messages) : null;
                    }
            
                    $verifyBadge = Used_code::where('user_id', $c->user_id)
                                             ->where('expiry_date', '>', now())
                                             ->first();
                    $c['verify_badge'] = $verifyBadge ? true : false;
                    $c['guardians'] = Dependant::where('user_id', $c->user_id)->get();
                    $c['images'] = json_decode($c->images, true);
            
                    $user = User::find($c->user_id);
                    if ($user && $c->anonymous === 'Yes') {
                        $user->firstname = null;
                        $user->lastname = null;
                        $user->email = null;
                        $user->phone_number = null;
                        $user->ksn = null;
                        $c->ksn = null;
                    }
                    $c['user'] = $user;
             }
             
             
             
             $success['status'] = 200;
             $success['message'] = 'Country wise requests found successfully';
             $success['data'] = $consults;
             
             return response()->json(['success' => $success]);
                               
                           
    } else if ($subaccount->country && $subaccount->location) {
       
         $consults = Ambulance::whereIn('ambulance_service', $agency_titles)
                           ->where('country',$subaccount->country)
                           ->where('location',$subaccount->location)
                           ->get();
                           
             foreach ($consults as $c) {
                    $chats = Group_Chat::where('module_id', $c->id)->get();
                    foreach ($chats as $chat) {
                        $messages = json_decode($chat->message, true);
                        $c['last_message'] = $messages ? end($messages) : null;
                    }
            
                    $verifyBadge = Used_code::where('user_id', $c->user_id)
                                             ->where('expiry_date', '>', now())
                                             ->first();
                    $c['verify_badge'] = $verifyBadge ? true : false;
                    $c['guardians'] = Dependant::where('user_id', $c->user_id)->get();
                    $c['images'] = json_decode($c->images, true);
            
                    $user = User::find($c->user_id);
                    if ($user && $c->anonymous === 'Yes') {
                        $user->firstname = null;
                        $user->lastname = null;
                        $user->email = null;
                        $user->phone_number = null;
                        $user->ksn = null;
                        $c->ksn = null;
                    }
                    $c['user'] = $user;
             }
             
             
             
             $success['status'] = 200;
             $success['message'] = 'Country and location wise requests found successfully';
             $success['data'] = $consults;
             
             return response()->json(['success' => $success]);
                           
    }
        

    }

    public function delete_travelsafe($id)
    {
        $ambulance = Travel::find($id);
        if ($ambulance) {
            $ambulance->delete();
            $success['data'] = $ambulance;
            $success['status'] = 200;
            $success['message'] = 'delete successfully';
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }


    public function edit_travelsafe(Request $request, $id)
    {

        $feedback = Travel::find($id);

        if ($feedback !== null) {

            // Check if new images were uploaded
            // if ($request->hasFile('images')) {
            //     // Array to store the uploaded files' details
            //     $uploadedFiles = [];

            //     // Loop through each uploaded file
            //     foreach ($request->file('images') as $file) {
            //         $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

            //         // Get the file extension
            //         $extension = $file->extension();

            //         // Determine the type of the file based on its extension
            //         if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
            //             $uploadedFile->type = 'image';
            //         } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
            //             $uploadedFile->type = 'video';
            //         } elseif (in_array($extension, ['mp3'])) {
            //             $uploadedFile->type = 'audio';
            //         } else {
            //             // You can handle other file types if needed
            //             $uploadedFile->type = 'unknown';
            //         }

            //         // Generate a unique filename for the uploaded image
            //         $uploadedImage = rand(1000, 9999) . '.' . $file->extension();

            //         // Store the uploaded image on the S3 disk
            //         $path = $file->storeAs('travel_images', $uploadedImage, ['disk' => 's3']);

            //         // Set the URL of the uploaded image
            //         $uploadedFile->url = $path;

            //         // Add the uploaded file details to the array
            //         $uploadedFiles[] = $uploadedFile;
            //     }

            //     // Convert the array of uploaded files into JSON and store it in the 'images' property
            //     $feedback->images = json_encode($uploadedFiles);
            // } elseif ($request->filled('images')) {
            //     // If no new images were uploaded but 'images' field is present in the request,
            //     // directly assign the value to the 'images' property
            //     $feedback->images = $request->images;
            // }

            if ($request->name) {
                $feedback->name = $request->name;
            }
            if ($request->phone_number) {
                $feedback->phone_number = $request->phone_number;
            }
            if ($request->country) {
                $feedback->country = $request->country;
            }
            if ($request->status) {
                $feedback->status = $request->status;
                if ($request->status === 'Resolved') {
                    $u = User::find($feedback->user_id);
                    $u->notify_count = $u->notify_count + 1;
                    $u->save();
                    $playerId = [$u->device_token];
                    $subject = 'The status of TravelSafe ' . $feedback->reference_code . ' is now RESOLVED';

                    if ($u->language === 'English') {
                        // No translation needed, use the original sentence in English.
                        $translated_sentence = $subject;
                    } elseif ($u->language === 'Yoruba') {
                        // Translate to Yoruba
                        $translated_sentence = 'Awọn iwọsọna ti TravelSafe ' . $feedback->reference_code . ' ni yoo ti wa nile lọ.';
                    } elseif ($u->language === 'Igbo') {
                        // Translate to Igbo
                        $translated_sentence = 'Akwụkwọ nke TravelSafe ' . $feedback->reference_code . ' bụ ugbu a.';
                    } elseif ($u->language === 'French') {
                        // Translate to French
                        $translated_sentence = 'L\'état de TravelSafe ' . $feedback->reference_code . ' est désormais RÉSOLU.';
                    } elseif ($u->language === 'Hausa') {
                        // Translate to Hausa
                        $translated_sentence = 'Nauin muryar layin ikirarin TravelSafe ' . $feedback->reference_code . ' yana harsashi.';
                    } elseif ($u->language === 'Arabic') {
                        // Translate to Arabic
                        $translated_sentence = 'حالة TravelSafe ' . $feedback->reference_code . ' الآن مُحَلَّة.';
                    } elseif ($u->language === 'Chinese') {
                        // Translate to Chinese
                        $translated_sentence = 'TravelSafe情况 ' . $feedback->reference_code . ' 现已解决。';
                    } elseif ($u->language === 'Spanish') {
                        // Translate to Spanish
                        $translated_sentence = 'El estado de TravelSafe ' . $feedback->reference_code . ' ahora está RESUELTO.';
                    } elseif ($u->language === 'Portuguese') {
                        // Translate to Portuguese
                        $translated_sentence = 'O estado de TravelSafe ' . $feedback->reference_code . ' agora está RESOLVIDO.';
                    } elseif ($u->language === 'Fula') {
                        // Translate to Fula
                        $translated_sentence = 'Nadata na Tambayoyin TravelSafe ' . $feedback->reference_code . ' yana RESOLVED yanzu.';
                    } else {
                        // Default to English if the language preference is not recognized.
                        $translated_sentence = $subject;
                    }

                    $content = array(
                        "en" => $translated_sentence,
                    );
                    $fields = array(
                        'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                        'ios_badgeType' => "Increase",
                        'ios_badgeCount' =>  $u->notify_count,
                        'include_player_ids' =>   $playerId,
                        'data' => array("foo" => "NewMassage"),
                        'contents' => $content
                    );

                    $fields = json_encode($fields);


                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json; charset=utf-8',
                        'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
                    ));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    $response = curl_exec($ch);
                    curl_close($ch);
                }
            }
            if ($request->admin) {
                $feedback->admin = $request->admin;
            }
            if ($request->response) {
                $feedback->response = $request->response;
            }
            if ($request->created_at) {
                $feedback->created_at = $request->created_at;
            }
            if ($request->device) {
                $feedback->device = $request->device;
            }
            if ($request->reference_code) {
                $feedback->reference_code = $request->reference_code;
            }
            if ($request->boarding) {
                $feedback->boarding = $request->boarding;
            }
            if ($request->destination) {
                $feedback->destination = $request->destination;
            }
            if ($request->vehicle_type) {
                $feedback->vehicle_type = $request->vehicle_type;
            }
            if ($request->vehicle_detail) {
                $feedback->vehicle_detail = $request->vehicle_detail;
            }
            if ($request->additional_info) {
                $feedback->additional_info = $request->additional_info;
            }
            if ($request->trip_duration) {
                $feedback->trip_duration = $request->trip_duration;
            }
            if ($request->coordinate) {
                $feedback->coordinate = json_encode($request->coordinate);
            }
            if ($request->map) {
                $feedback->map = $request->map;
            }


            $feedback->save();
            $users = User::find($feedback->user_id);
            if ($users) {
                $feedback['firstname'] = $users->firstname;
                $feedback['lastname'] = $users->lastname;
                $feedback['email'] = $users->email;
                $feedback['ksn'] = $users->ksn;
                $feedback['phone_number'] = $users->phone_number;
                $feedback['profile_image'] = $users->profile_image;
            }
            $feedback['link'] = 'https://kacihelp.com/travelsafe/' . $feedback->reference_code;
            $success['data'] =  $feedback;
            $success['status'] = 200;
            $success['message'] = 'updated successfully';
            return response()->json(['success' => $success], $this->successStatus);
        }
    }
    public function show_travelsafe($id)
    {
        $travel = Travel::find($id);
        
        if ($travel) {
            $travel->images = json_decode($travel->images);
            
            $verifyBadge = Used_code::where('user_id', '=', $travel->user_id)->where('expiry_date', '>', now())->first();
            if($verifyBadge){
                
                $travel->verify_badge = true;
            }else{
                $travel->verify_badge = false;
            }
            $travel->guardians  = Dependant::where('user_id', '=', $travel->user_id)->get();
            
            $messages  = Group_chat::where('module', '=', 'Travel')->where('module_id', '=', $id)->first();
            if($messages){
                
                $chat = json_decode($messages->message);
                $travel->messages = json_decode($chat->message);
                
            }else{
                $travel->messages = null;
            }
            
            $feedback['link'] = 'https://kacihelp.com/travelsafe/' . $travel->reference_code;
            $success['data'] = $travel;
            $success['status'] = 200;
            $success['message'] = 'found successfully';
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }


    public function travelsafe()
    {
        $ambulance = Travel::all();
        $data = [];
        foreach ($ambulance as $a) {
            $a['link'] = 'https://kacihelp.com/travelsafe/' . $a->reference_code;

            $user = User::find($a->user_id);
            if ($user) {
                
                   $verifyBadge = Used_code::where('user_id', $user->id)
                                             ->where('expiry_date', '>', now())
                                             ->first();
                    $a['verify_badge'] = $verifyBadge ? true : false;
                $a['firstname'] = $user->firstname;
                $a['lastname'] = $user->lastname;
                $a['profile_image'] = $user->profile_image;
                $a['phone_number'] = $user->phone_number;
                $a['email'] = $user->email;
                $a['ksn'] = $user->ksn;
                $country = General_Countries::where('country_name', '=', $user->country)->first();
                if ($country) {
                    $a['flag_code'] = $country->flag_code;
                    $a['country_code'] = $country->country_code;
                }
                $response = Response::where('type_id', '=', $a->id)->where('user_id', '=', $a->user_id)->where('type', '=', 'travel')->get();
                if ($response->count() > 0) {
                    $responses = [];
                    foreach ($response as $res) {
                        $admin = Sub_Admin::where('name', '=', $res->admin_name)->first();
                        if ($admin) {
                            $res['admin_email'] = $admin->email;
                        }
                        $responses[] = $res;
                    }

                    $a['responses'] = $responses;
                }
            }
            $data[] = $a;
        }

        $success['data'] =  $data;
        $success['status'] = 200;
        $success['message'] = 'found successfully';
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function show_user_travelsafe($user_id)
    {
        $travel = Travel::where('user_id', '=', $user_id)->get();
        if ($travel) {
            $success['data'] = $travel;
            $success['status'] = 200;
            $success['message'] = 'found successfully';
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }
    
    
//   public function show_travel_agency(Request $request ,$id){
     
//      $agency = Sub_Account::find($id);
//     $perpage = $request->per_page;
//         $travel = Travel::where('country', '=', $agency->country)->paginate($perpage);
        
//         foreach($travel as $t){
            
            
            
//               $chat  = Group_Chat::where('module_id', $t->id)->get();
//                 $t['last_message'] = null;
        
//               foreach($chat as $message){
                   
//               $message  = json_decode($message->message);
//                 $lastmessage = end($message);
                 
//                         if($lastmessage){
                            
//                             $t['last_message'] = $lastmessage;
//                         }
//               }
                

//             $user  = User::find($t->user_id);
//             $t['guardians'] = Dependant::where('user_id', '=', $t->user_id)->get();
            
//             $verifyBadge = Used_code::where('user_id', '=', $t->user_id)->where('expiry_date', '>', now())->first();
            
//             if($verifyBadge){
//                 $t['verify_status'] = true;
//             }else{
//                 $t['verify_status'] = false;
//             }
//         }


//     $success['status']=200;
//     $success['message']='Data found successfully';
//     $success['data']=$travel;
    
//     return response()->json(['success' => $success]);

//   }

    
  public function show_travel_agency($id){
     
    $subaccount = Sub_Account::find($id);
 
    $decoded_ids = json_decode($subaccount->agency_id, true);

    $agencies = Agencies::whereIn('id', $decoded_ids)->get()->toArray();

    $agency_titles = array_column($agencies, 'title');

    $consults = [];
    
    if ($subaccount->country && !$subaccount->location) {

        $consults = Travel::where('country', $subaccount->country)->get();
                           
                           
         foreach ($consults as $c) {
             
                    $c['last_message'] = null;                
                    $chats = Group_Chat::where('module_id', $c->id)->get();
                    foreach ($chats as $chat) {
                        $messages = json_decode($chat->message, true);
                        $c['last_message'] = $messages ? end($messages) : null;
                    }
            
                    $verifyBadge = Used_code::where('user_id', $c->user_id)
                                             ->where('expiry_date', '>', now())
                                             ->first();
                    $c['verify_badge'] = $verifyBadge ? true : false;
                    $c['guardians'] = Dependant::where('user_id', $c->user_id)->get();
                    $c['images'] = json_decode($c->images, true);
            
                    $user = User::find($c->user_id);
                    if ($user && $c->anonymous === 'Yes') {
                        $user->firstname = null;
                        $user->lastname = null;
                        $user->email = null;
                        $user->phone_number = null;
                        $user->ksn = null;
                        $c->ksn = null;
                    }
                    $c['user'] = $user;
             }
             
             $success['status'] = 200;
             $success['message'] = 'Country wise requests found successfully';
             $success['data'] = $consults;
             
             return response()->json(['success' => $success]);
                               
                           
    } else if ($subaccount->country && $subaccount->location) {
       
         $consults = Travel::where('country',$subaccount->country)->get();
                           
             foreach ($consults as $c) {
                    $chats = Group_Chat::where('module_id', $c->id)->get();
                    foreach ($chats as $chat) {
                        $messages = json_decode($chat->message, true);
                        $c['last_message'] = $messages ? end($messages) : null;
                    }
            
                    $verifyBadge = Used_code::where('user_id', $c->user_id)
                                             ->where('expiry_date', '>', now())
                                             ->first();
                    $c['verify_badge'] = $verifyBadge ? true : false;
                    $c['guardians'] = Dependant::where('user_id', $c->user_id)->get();
                    $c['images'] = json_decode($c->images, true);
            
                    $user = User::find($c->user_id);
                    if ($user && $c->anonymous === 'Yes') {
                        $user->firstname = null;
                        $user->lastname = null;
                        $user->email = null;
                        $user->phone_number = null;
                        $user->ksn = null;
                        $c->ksn = null;
                    }
                    $c['user'] = $user;
             }
             
             
             
             $success['status'] = 200;
             $success['message'] = 'Country and location wise requests found successfully';
             $success['data'] = $consults;
             
             return response()->json(['success' => $success]);
                           
    }

  }


    public function delete_sos($id)
    {
        $ambulance = Sos::find($id);
        if ($ambulance) {
            $ambulance->delete();
            $success['data'] = $ambulance;
            $success['status'] = 200;
            $success['message'] = 'delete successfully';
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }


    public function show_sos($id)
    {
        $ambulance = Sos::find($id);
        
        if ($ambulance) {
            
            $ambulance->images = json_decode($ambulance->images);
            
            $verifyBadge  = Used_code::where('user_id', '=', $ambulance->user_id)->where('expiry_date', '>', now())->first();
            
            
            if($verifyBadge){
                $ambulance->verify_badge  = true;
            }else{
                $ambulance->verify_badge =  false;
            }
            
            $ambulance->guardians = Dependant::where('user_id', '=', $ambulance->user_id)->get();
            
            $messages  = Group_chat::where('module', '=', 'Emergency')->where('module_id', '=', $id)->first();
            if($messages){
                
                $chat  = json_decode($messages->message);
                $ambulance->messages = json_decode($chat->message);
            }else{
                $ambulance->messages =  null;
            }
            $ambulance['link'] = 'https://kacihelp.com/emergency/' . $ambulance->reference_code;
            $success['data'] = $ambulance;
            $success['status'] = 200;
            $success['message'] = 'found successfully';
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }




    public function show_user_sos($user_id)
    {
        $travel = Sos::where('user_id', '=', $user_id)->get();
        if ($travel) {
            $success['data'] = $travel;
            $success['status'] = 200;
            $success['message'] = 'found successfully';
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }
    
    
    
    // public function showAgencySos(Request $request ,$id){
        
        
    //     if($request->country){
            
    //     $agency = Agencies::find($id);
    //     $perpage = $request->per_page;
    //     $emergency  = Sos::where('target_agency', '=', $agency->title)->where('country', '=', $request->country)->paginate($perpage);
        
    //     foreach($emergency as $e ){
            
            
            
    //           $chat  = Group_Chat::where('module_id', $e->id)->get();
    //             $e['last_message'] = null;
        
    //           foreach($chat as $message){
                   
    //           $message  = json_decode($message->message);
    //             $lastmessage = end($message);
                 
    //                     if($lastmessage){
                            
    //                         $e['last_message'] = $lastmessage;
    //                     }
    //           }
                
            
            
    //         $e['guardians'] = Dependant::where('user_id', '=', $e->user_id)->get();
            
            
    //         $verifyBadge  = Used_code::where('user_id', '=', $e->user_id)->where('expiry_date' ,'>', now())->first();
            
    //         if($verifyBadge){
                
    //             $e['verify_badge'] =  true;
    //         }else{
                
    //             $e['verify_badge'] =  false;
    //         }
            
    //     }
        
    //     }else{
            
    //         $agency = Agencies::find($id);
    //         $perpage =  $request->per_page;
    //         $emergency = Sos::where('target_agency', '=', $agency->title)->paginate($perpage);
            
    //         foreach($emergency as $e){
                
                
                
    //               $chat  = Group_Chat::where('module_id', $e->id)->get();
    //             $e['last_message'] = null;
        
    //           foreach($chat as $message){
                   
    //           $message  = json_decode($message->message);
    //             $lastmessage = end($message);
                 
    //                     if($lastmessage){
                            
    //                         $e['last_message'] = $lastmessage;
    //                     }
    //           }
                
                
                
    //             $e['guardians'] = Dependant::where('user_id', '=', $e->user_id )->get();
                
                
    //         $verify_badge =Used_code::where('user_id', '='. $e->user_id)->where('expiry_date', '=', now())->first();
    //         if($verify_badge){
                
    //             $e['verify_badge'] =  true;
    //         }else{
                
    //             $e['verify_badge'] =  false;
    //         }
            
    //         }
    //     }
        
      
    //     $success['status'] = 200;
    //     $success['message'] = 'Data Found successfully';
    //     $success['data'] =  $emergency;
        
    //     return response()->json(['success' => $success]); 
   
    // }
    
    

        public function showAgencySos($id){
        
                    
                $subaccount = Sub_Account::find($id);
             
                $decoded_ids = json_decode($subaccount->agency_id, true);
            
                $agencies = Agencies::whereIn('id', $decoded_ids)->get()->toArray();
                $agency_titles = array_column($agencies, 'title');
            
                $consults = [];
                
                if ($subaccount->country && !$subaccount->location) {
            
                    $consults = Sos::whereIn('target_agency', $agency_titles)
                                       ->where('country', $subaccount->country)
                                       ->get();
                                       
                                       
                     foreach ($consults as $c) {
                         
                                $c['last_message'] = null;                
                                $chats = Group_Chat::where('module_id', $c->id)->get();
                                foreach ($chats as $chat) {
                                    $messages = json_decode($chat->message, true);
                                    $c['last_message'] = $messages ? end($messages) : null;
                                }
                        
                                $verifyBadge = Used_code::where('user_id', $c->user_id)
                                                         ->where('expiry_date', '>', now())
                                                         ->first();
                                $c['verify_badge'] = $verifyBadge ? true : false;
                                $c['guardians'] = Dependant::where('user_id', $c->user_id)->get();
                                $c['images'] = json_decode($c->images, true);
                        
                                $user = User::find($c->user_id);
                                if ($user && $c->anonymous === 'Yes') {
                                    $user->firstname = null;
                                    $user->lastname = null;
                                    $user->email = null;
                                    $user->phone_number = null;
                                    $user->ksn = null;
                                    $c->ksn = null;
                                }
                                $c['user'] = $user;
                         }
                         
                         
                         
                         $success['status'] = 200;
                         $success['message'] = 'Country wise requests found successfully';
                         $success['data'] = $consults;
                         
                         return response()->json(['success' => $success]);
                                           
                                       
                } else if ($subaccount->country && $subaccount->location) {
                   
                     $consults = Sos::whereIn('target_agency', $agency_titles)
                                       ->where('country',$subaccount->country)
                                       ->where('location',$subaccount->location)
                                       ->get();
                                       
                         foreach ($consults as $c) {
                                $chats = Group_Chat::where('module_id', $c->id)->get();
                                foreach ($chats as $chat) {
                                    $messages = json_decode($chat->message, true);
                                    $c['last_message'] = $messages ? end($messages) : null;
                                }
                        
                                $verifyBadge = Used_code::where('user_id', $c->user_id)
                                                         ->where('expiry_date', '>', now())
                                                         ->first();
                                $c['verify_badge'] = $verifyBadge ? true : false;
                                $c['guardians'] = Dependant::where('user_id', $c->user_id)->get();
                                $c['images'] = json_decode($c->images, true);
                        
                                $user = User::find($c->user_id);
                                if ($user && $c->anonymous === 'Yes') {
                                    $user->firstname = null;
                                    $user->lastname = null;
                                    $user->email = null;
                                    $user->phone_number = null;
                                    $user->ksn = null;
                                    $c->ksn = null;
                                }
                                $c['user'] = $user;
                         }
                         
                         
                         
                         $success['status'] = 200;
                         $success['message'] = 'Country and location wise requests found successfully';
                         $success['data'] = $consults;
                         
                         return response()->json(['success' => $success]);
                           
    }
   
    }
    
    

    public function edit_consult(Request $request, $id)
    {
        $feedback = Consult::find($id);

        if ($request->hasFile('images')) {
            $uploadedFiles = [];

            foreach ($request->file('images') as $file) {
                $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

                $extension = $file->extension(); // Get the file extension

                // Determine the type of the file based on its extension
                if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                    $uploadedFile->type = 'image';
                } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
                    $uploadedFile->type = 'video';
                } elseif (in_array($extension, ['mp3'])) {
                    $uploadedFile->type = 'audio';
                } else {
                    // You can handle other file types if needed
                    $uploadedFile->type = 'unknown';
                }
                $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
                $path = $file->storeAs('consult_images', $uploadedImage, ['disk' => 's3']);
                $uploadedFile->url = 'https://kaci-storage.s3.amazonaws.com/'. $path;
                // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
                $uploadedFiles[] = $uploadedFile;
            }

            $feedback->images = $uploadedFiles;
        } elseif ($request->filled('images')) {
            $feedback->images = $request->images;
        }
        if ($request->name) {
            $feedback->name = $request->name;
        }
        if ($request->phone_number) {
            $feedback->phone_number = $request->phone_number;
        }
        if ($request->country) {
            $feedback->country = $request->country;
        }
        if ($request->status) {
            $feedback->status = $request->status;
            if ($request->status === 'Resolved') {
                $u = User::find($feedback->user_id);
                $u->notify_count = $u->notify_count + 1;
                $u->save();
                
                $playerId = [$u->device_token];
                $subject = 'The status of Consult ' . $feedback->reference_code . ' is now RESOLVED';

                if ($u->language === 'English') {
                    // No translation needed, use the original sentence in English.
                    $translated_sentence = $subject;
                } elseif ($u->language === 'Yoruba') {
                    // Translate to Yoruba
                    $translated_sentence = 'Ipo ti Ijumọsọrọ ' . $feedback->reference_code . ' ni yoo ti wa nile lọ.';
                } elseif ($u->language === 'Igbo') {
                    // Translate to Igbo
                    $translated_sentence = 'Ọkwa nke Consult ' . $feedback->reference_code . ' bụ ugbu a.';
                } elseif ($u->language === 'French') {
                    // Translate to French
                    $translated_sentence = 'Le statut de Consulter' . $feedback->reference_code . ' est désormais RÉSOLU.';
                } elseif ($u->language === 'Hausa') {
                    // Translate to Hausa
                    $translated_sentence = 'Matsayin Consult' . $feedback->reference_code . ' yana harsashi.';
                } elseif ($u->language === 'Arabic') {
                    // Translate to Arabic
                    $translated_sentence = 'حالة الاستشارة' . $feedback->reference_code . ' الآن مُحَلَّة.';
                } elseif ($u->language === 'Chinese') {
                    // Translate to Chinese
                    $translated_sentence = '咨询状态' . $feedback->reference_code . ' 现已解决。';
                } elseif ($u->language === 'Spanish') {
                    // Translate to Spanish
                    $translated_sentence = 'El estado de Consulta ' . $feedback->reference_code . ' ahora está RESUELTO.';
                } elseif ($u->language === 'Portuguese') {
                    // Translate to Portuguese
                    $translated_sentence = 'O status da Consulta ' . $feedback->reference_code . ' agora está RESOLVIDO.';
                } elseif ($u->language === 'Fula') {
                    // Translate to Fula
                    $translated_sentence = 'Nadata na Bayanin ' . $feedback->reference_code . ' yana RESOLVED yanzu.';
                } else {
                    // Default to English if the language preference is not recognized.
                    $translated_sentence = $subject;
                }

                // Now $translated_sentence contains the translated sentence based on the user's language preference.


                $content = array(
                    "en" => $translated_sentence,
                );
                $fields = array(
                    'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                    'ios_badgeType' => "Increase",
                    'ios_badgeCount' =>  $u->notify_count,
                    'include_player_ids' =>   $playerId,
                    'data' => array("foo" => "NewMassage"),
                    'contents' => $content
                );

                $fields = json_encode($fields);


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json; charset=utf-8',
                    'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($ch);
                curl_close($ch);
            }
        }
        if ($request->admin) {
            $feedback->admin = $request->admin;
        }
        if ($request->response) {
            $feedback->response = $request->response;
        }
        if ($request->created_at) {
            $feedback->created_at = $request->created_at;
        }
        if ($request->device) {
            $feedback->device = $request->device;
        }
        if ($request->reference_code) {
            $feedback->reference_code = $request->reference_code;
        }
        if ($request->location) {
            $feedback->location = $request->location;
        }

        if ($request->subject) {
            $feedback->subject = $request->subject;
        }
        if ($request->description) {
            $feedback->description = $request->description;
        }
        if ($request->target_agency) {
            $feedback->target_agency = $request->target_agency;
        }
        if ($request->anonymous) {
            $feedback->anonymous = $request->anonymous;
        }

        $feedback->save();
        $users = User::find($feedback->user_id);
        if ($users) {
            $feedback['firstname'] = $users->firstname;
            $feedback['lastname'] = $users->lastname;
            $feedback['email'] = $users->email;
            $feedback['ksn'] = $users->ksn;
            $feedback['phone_number'] = $users->phone_number;
            $feedback['profile_image'] = $users->profile_image;
        }
        $success['data'] =  $feedback;
        $success['status'] = 200;
        $success['message'] = 'updated successfully';
        return response()->json(['success' => $success], $this->successStatus);
    }



    public function show_report($id)
    {
        $report = Report::find($id);
        if ($report) {
            
            $verifyBadge  = Used_code::where('user_id', '=', $report->user_id)->where('expiry_date', '>', now())->first();
            if($verifyBadge){
                $report->verify_badge = true;
            }else{
                $report->verify_badge = false;
            }
            $report->guardians = Dependant::where('user_id', '=', $report->user_id)->get();
            
            $messages  = Group_chat::where('module', '=', 'Report')->where('module_id', '=', $id)->first();
            if($messages){
                
                $chat  = json_decode($messages->message);
                $report->messages = json_decode($chat->message);
            }else{
                $report->messages = null;
            }
            
            $user  = User::find($report->user_id);

            if($report->anonymous === 'Yes'){
                $user->firstname  =  null;
                $user->lastname =  null;
                $user->email = null;
                $user->ksn =  null;
                $report->ksn = null;
                $report->user = $user;
            }else{
                $report->user = $user;
            }

            $report['images'] =  json_decode($report->images);
            $success['data'] = $report;
            $success['status'] = 200;
            $success['message'] = 'found successfully';
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }
    
    
    
    // public function show_report_agency(Request $request , $id){
        
    //     if($request->country){
            
    //         $agency = Agencies::find($id);
    //         $perpage =  $request->per_page;
    //         $report = Report::where('target_agency', '=', $agency->title)->where('country', '=', $request->country)->paginate($perpage);
            
    //         foreach($report as $r){
                

    //             $chat  = Group_Chat::where('module_id', $r->id)->get();
    //             $r['last_message'] = null;
        
    //           foreach($chat as $message){
                   
    //           $message  = json_decode($message->message);
    //             $lastmessage = end($message);
                 
    //                     if($lastmessage){
                            
    //                         $r['last_message'] = $lastmessage;
    //                     }
    //           }
                
    //           $r['guardians']= Dependant::where('user_id', '=', $r->user_id)->get();
               
    //           $verifyBadge = Used_code::where('user_id', '=', $r->user_id)->where('expiry_date', '>', now())->first();
               
    //           if($verifyBadge){
    //               $r['verify_badge'] =  true;
    //           }else{
    //               $r['verify_badge'] = false;
    //           }
               
    //           $user  =  User::find($r->user_id);
            
    //         if($r->anonymous == 'Yes'){
                
    //             $user->fullname = null;
    //             $user->lastname = null;
    //             $user->ksn = null;
    //             $user->email = null;
    //             $r->ksn = null;
    //         }
            
    //         $r['user'] =  $user;
        
    //         }
            
    //     }else{
        
    //         $agency =  Agencies::find($id);
    //         $perpage = $request->per_page;
    //         $report = Report::where('target_agency', '=', $agency->title)->paginate($perpage);
            
    //         foreach($report as $r){
                
                
                
    //              $chat  = Group_Chat::where('module_id', $r->id)->get();
    //             $r['last_message'] = null;
        
    //           foreach($chat as $message){
                   
    //           $message  = json_decode($message->message);
    //             $lastmessage = end($message);
                 
    //                     if($lastmessage){
                            
    //                         $r['last_message'] = $lastmessage;
    //                     }
    //           }
                
                
    //             $r['guardians'] = Dependant::where('user_id', '=', $r->user_id)->get();
                
                
    //             $verifyBadge = Used_code::where('user_id', '=', $r->user_id)->where('expiry_date' , '>', now())->first();
                
    //             if($verifyBadge){
                    
    //                 $r['verify_badge'] = true;
    //             }else{
    //                 $r['verify_badge'] =  false;
    //             }
                
                
    //             $user = User::find($r->user_id);
    //             if($r->anonymous == 'Yes'){
               
    //                 $user->firstname = null;
    //                 $user->lastname = null;
    //                 $user->ksn =  null;
    //                 $user->email = null;
    //                 $r->ksn = null;
    //             }
                
    //             $r['user'] = $user;
             
    //         }
    //     }
    //     $success['status'] = 200;
    //     $success['message'] = 'Data found successfully';
    //     $success['data'] =  $report;
        
    //     return response()->json(['success' => $success]);
    // }


    public function show_report_agency($id){
        
     $subaccount = Sub_Account::find($id);
 
    $decoded_ids = json_decode($subaccount->agency_id, true);

    $agencies = Agencies::whereIn('id', $decoded_ids)->get()->toArray();
    $agency_titles = array_column($agencies, 'title');

    $consults = [];
    
    if ($subaccount->country && !$subaccount->location) {

        $consults = Report::whereIn('target_agency', $agency_titles)
                           ->where('country', $subaccount->country)
                           ->get();
                           
                           
         foreach ($consults as $c) {
             
                    $c['last_message'] = null;                
                    $chats = Group_Chat::where('module_id', $c->id)->get();
                    foreach ($chats as $chat) {
                        $messages = json_decode($chat->message, true);
                        $c['last_message'] = $messages ? end($messages) : null;
                    }
            
                    $verifyBadge = Used_code::where('user_id', $c->user_id)
                                             ->where('expiry_date', '>', now())
                                             ->first();
                    $c['verify_badge'] = $verifyBadge ? true : false;
                    $c['guardians'] = Dependant::where('user_id', $c->user_id)->get();
                    $c['images'] = json_decode($c->images, true);
            
                    $user = User::find($c->user_id);
                    if ($user && $c->anonymous === 'Yes') {
                        $user->firstname = null;
                        $user->lastname = null;
                        $user->email = null;
                        $user->phone_number = null;
                        $user->ksn = null;
                        $c->ksn = null;
                    }
                    $c['user'] = $user;
             }
             
             
             
             $success['status'] = 200;
             $success['message'] = 'Country wise requests found successfully';
             $success['data'] = $consults;
             
             return response()->json(['success' => $success]);
                               
                           
    } else if ($subaccount->country && $subaccount->location) {
       
         $consults = Report::whereIn('target_agency', $agency_titles)
                           ->where('country',$subaccount->country)
                           ->where('location',$subaccount->location)
                           ->get();
                           
             foreach ($consults as $c) {
                    $chats = Group_Chat::where('module_id', $c->id)->get();
                    foreach ($chats as $chat) {
                        $messages = json_decode($chat->message, true);
                        $c['last_message'] = $messages ? end($messages) : null;
                    }
            
                    $verifyBadge = Used_code::where('user_id', $c->user_id)
                                             ->where('expiry_date', '>', now())
                                             ->first();
                    $c['verify_badge'] = $verifyBadge ? true : false;
                    $c['guardians'] = Dependant::where('user_id', $c->user_id)->get();
                    $c['images'] = json_decode($c->images, true);
            
                    $user = User::find($c->user_id);
                    if ($user && $c->anonymous === 'Yes') {
                        $user->firstname = null;
                        $user->lastname = null;
                        $user->email = null;
                        $user->phone_number = null;
                        $user->ksn = null;
                        $c->ksn = null;
                    }
                    $c['user'] = $user;
             }
             
             
             
             $success['status'] = 200;
             $success['message'] = 'Country and location wise requests found successfully';
             $success['data'] = $consults;
             
             return response()->json(['success' => $success]);
                           
    }
    }







    public function show_suggestion($id)
    {
        $suggestion = Suggestion::find($id);
        if ($suggestion) {
            
            $suggestion->images = json_decode($suggestion->images);
            
            $verifyBadge = Used_Code::where('user_id', '=', $suggestion->user_id)->where('expiry_date', '>', now())->first();
            if($verifyBadge){
                $suggestion->verify_badge =  true;
            }else{
                $suggestion->verify_badge  = false;
            }
            
            $suggestion->guardians = Dependant::where('user_id', '=', $suggestion->user_id)->get();
            
            
            $messages = Group_chat::where('module', '=', 'Suggestion')->where('module_id', '=', $id)->first();
            if($messages){
                $chat  = json_decode($messages->message);
                $suggestion->messages = json_decode($chat->message);
            }else{
                
                $suggestion->messages = null;
            }
            $success['data'] = $suggestion;
            $success['status'] = 200;
            $success['message'] = 'found successfully';
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }
    
    
    // public function show_agency_suggestion(Request $request , $id){
        
    //     if($request->country){
            
    //           $agency  = Agencies::find($id);
    //           $per_page =  $request->per_page;
        
    //         $suggestion  = Suggestion::where('target_agency', '=', $agency->title)->where('country', '=', $request->country)->paginate($per_page);
        
    //         foreach($suggestion as $s){
                
                
    //               $chat  = Group_Chat::where('module_id', $s->id)->get();
               
    //           foreach($chat as $message){
                   
    //           $message  = json_decode($message->message);
    //             $lastmessage = end($message);
    //             if($lastmessage){
                    
    //                 $c['last_message'] = $lastmessage;
    //             }else{
    //                 $c['last_message'] = null;
    //             }
         
                   
    //           }
                
    //                 $s['guardians'] = Dependant::where('user_id', '=', $s->user_id)->get();
                
    //                 $verifyBadge = Used_code::where('user_id', '=', $s->user_id)->where('expiry_date', '>', now())->first();
                    
    //                 if($verifyBadge){
                        
    //                     $c['verify_badge'] = true;
    //                 }else{
                        
    //                     $c['verify_badge'] = false;
    //                 }
    //         }
        
    //     }else{
    //         $agency = Agencies::find($id);
    //         $perpage =  $request->per_page;
    //         $suggestion = Suggestion::where('target_agency', '=', $agency->title)->paginate($perpage);
            
    //         foreach($suggestion as $s){
                
                
    //               $chat  = Group_Chat::where('module_id', $d->id)->get();
               
    //           foreach($chat as $message){
                   
    //           $message  = json_decode($message->message);
    //             $lastmessage = end($message);
    //             if($lastmessage){
                    
    //                 $c['last_message'] = $lastmessage;
    //             }else{
    //                 $c['last_message'] = null;
    //             }
         
                   
    //           }
                
      
    //             $s['guardians'] = Dependant::where('user_id', $s->user_id)->get();
                
    //             $verifyBadge = Used_code::where('user_id', '=', $s->user_id)->where('expiry_date', '>', now())->first();
                
                
    //             if($verifyBadge){
                    
    //                 $s['verify_badge'] = true;
    //             }else{
    //                 $s['verify_badge'] = false;
    //             }
    //         }
    //     }
        
    //     $success['status'] = 200;
    //     $success['message'] = 'Data found successfully';
    //     $success['data'] = $suggestion;
        
    //     return response()->json(['success' => $success]);
        
    // }





    public function show_agency_suggestion($id){
        
      $subaccount = Sub_Account::find($id);
 
    $decoded_ids = json_decode($subaccount->agency_id, true);

    $agencies = Agencies::whereIn('id', $decoded_ids)->get()->toArray();
    $agency_titles = array_column($agencies, 'title');

    $consults = [];
    
    if ($subaccount->country && !$subaccount->location) {

        $consults = Suggestion::whereIn('target_agency', $agency_titles)
                           ->where('country', $subaccount->country)
                           ->get();
                           
                           
         foreach ($consults as $c) {
             
                    $c['last_message'] = null;                
                    $chats = Group_Chat::where('module_id', $c->id)->get();
                    foreach ($chats as $chat) {
                        $messages = json_decode($chat->message, true);
                        $c['last_message'] = $messages ? end($messages) : null;
                    }
            
                    $verifyBadge = Used_code::where('user_id', $c->user_id)
                                             ->where('expiry_date', '>', now())
                                             ->first();
                    $c['verify_badge'] = $verifyBadge ? true : false;
                    $c['guardians'] = Dependant::where('user_id', $c->user_id)->get();
                    $c['images'] = json_decode($c->images, true);
            
                    $user = User::find($c->user_id);
                    if ($user && $c->anonymous === 'Yes') {
                        $user->firstname = null;
                        $user->lastname = null;
                        $user->email = null;
                        $user->phone_number = null;
                        $user->ksn = null;
                        $c->ksn = null;
                    }
                    $c['user'] = $user;
             }
             
             
             
             $success['status'] = 200;
             $success['message'] = 'Country wise requests found successfully';
             $success['data'] = $consults;
             
             return response()->json(['success' => $success]);
                               
                           
    } else if ($subaccount->country && $subaccount->location) {
       
         $consults = Suggestion::whereIn('target_agency', $agency_titles)
                           ->where('country',$subaccount->country)
                           ->where('location',$subaccount->location)
                           ->get();
                           
             foreach ($consults as $c) {
                    $chats = Group_Chat::where('module_id', $c->id)->get();
                    foreach ($chats as $chat) {
                        $messages = json_decode($chat->message, true);
                        $c['last_message'] = $messages ? end($messages) : null;
                    }
            
                    $verifyBadge = Used_code::where('user_id', $c->user_id)
                                             ->where('expiry_date', '>', now())
                                             ->first();
                    $c['verify_badge'] = $verifyBadge ? true : false;
                    $c['guardians'] = Dependant::where('user_id', $c->user_id)->get();
                    $c['images'] = json_decode($c->images, true);
            
                    $user = User::find($c->user_id);
                    if ($user && $c->anonymous === 'Yes') {
                        $user->firstname = null;
                        $user->lastname = null;
                        $user->email = null;
                        $user->phone_number = null;
                        $user->ksn = null;
                        $c->ksn = null;
                    }
                    $c['user'] = $user;
             }
             
             
             
             $success['status'] = 200;
             $success['message'] = 'Country and location wise requests found successfully';
             $success['data'] = $consults;
             
             return response()->json(['success' => $success]);
                           
    }
        
    }


    public function show_user_report($user_id)
    {
        $travel = Report::where('user_id', '=', $user_id)->get();
        if ($travel) {


            foreach ($travel as $t) {

                $t['images'] =  json_decode($t->images);
            }


            $success['data'] = $travel;
            $success['status'] = 200;
            $success['message'] = 'found successfully';
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }



    public function consult()
    {
        
        $ambulance = Consult::all();
        
        $data = [];
        
        foreach ($ambulance as $a) {
            
            $user = User::find($a->user_id);
            
            
            if ($user) {
                
                $verifyBadge = Used_code::where('user_id', $user->id)->where('expiry_date', '>', now())->first();
                
                if($verifyBadge){
                    
                    $a['verify_badge'] = true;
                }else{
                       $a['verify_badge'] = false;
                }
                
                $a['firstname'] = $user->firstname;
                $a['lastname'] = $user->lastname;
                $a['phone_number'] = $user->phone_number;
                $a['email'] = $user->email;
                $a['ksn'] = $user->ksn;
                $a['profile_image'] = $user->profile_image;
                
                $country = General_Countries::where('country_name', '=', $user->country)->first();
                
                if ($country) {
                    $a['flag_code'] = $country->flag_code;
                    $a['country_code'] = $country->country_code;
                }
                
                
                $response = Response::where('type_id', '=', $a->id)->where('user_id', '=', $a->user_id)->where('type', '=', 'consult')->get();
                
                if ($response->count() > 0) {
                    $responses = [];
                    
                    
                    foreach ($response as $res) {
                        $admin = Sub_Admin::where('name', '=', $res->admin_name)->first();
                        if ($admin) {
                            $res['admin_email'] = $admin->email;
                        }
                        $responses[] = $res;
                    }

                    $a['responses'] = $responses;
                    
                    
                    
                
                }
            }
            $data[] = $a;
        }
        $success['data'] = $data;
        $success['status'] = 200;
        $success['message'] = 'found successfully';
        return response()->json(['success' => $success], $this->successStatus);
    }

        public function show_consult($id)
    {
        $consult = Consult::find($id);
        
        if ($consult) {
            
            $consult->images =  json_decode($consult->images);
            $verifyBadge  = Used_code::where('user_id', '=', $consult->user_id)->where('expiry_date', '>', now())->first();
            if($verifyBadge){
                
                $consult->verify_badge = true;
            }else{
                $consult->verify_badge = false;
            }
            $consult->guardians = Dependant::where('user_id', '=', $consult->user_id)->get();
            
            $messages  = Group_chat::where('module', '=', 'Consult')->where('module_id', '=', $id)->first();
            $chat  = json_decode($messages);
            if($chat){
                
                $consult->messages = json_decode($chat->message);
            }else{
                $consult->messages = null;
            }
            
            $user = User::find($consult->user_id);
            
            if($consult->anonymous === 'Yes'){
            
                $user->firstname  = null;
                $user->lastname =  null;
                $user->email = null;
                $user->phone_number  = null;
                $user->ksn =  null;
                $consult->ksn = null;
                $consult->user = $user;
            
            }else{
                
                $consult->user = $user;
            }
            
            
            $success['data'] = $consult;
            $success['status'] = 200;
            $success['message'] = 'found successfully';
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }
    
    
    public function show_user_consult($user_id)
    {
        $travel = Consult::where('user_id', '=', $user_id)->get();
        if ($travel) {
            $success['data'] = $travel;
            $success['status'] = 200;
            $success['message'] = 'found successfully';
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }
    
    
    
    public function delete_consult($id)
    {
        $ambulance = Consult::find($id);
        if ($ambulance) {
            $ambulance->delete();
            $success['data'] = $ambulance;
            $success['status'] = 200;
            $success['message'] = 'delete successfully';
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }
    
    
    
    public function consult_status(Request $request , $id){
        
        $consult  = Consult::find($id);
        
        if($consult){
    
            if($request->status == 'Resolved'){
            $consult->status = 'Resolved';
            }elseif($request->status == 'Approved'){
                $consult->status = 'Approved';
            }else if($request->status == 'Deleted'){
                $consult->status = 'Deleted';
            }
            
            $consult->save();
            
            $success['status'] = 200;
            $success['message'] = 'Updated successfully';
            $success['data'] = $consult;
            
            return response()->json(['success' => $success]);

        }else{
            
            $success['status'] = 400;
            $success['message'] = 'updated successfully';
            
            
            return response()->json(['success' => $success]);
            
            
        }
        
    }
    
    
    // public function showAgencyConsult(Request $request, $id){
    
    //     if($request->country){
    //         $agency = Agencies::find($id);

    //         $perpage =  $request->per_page;

    //         $consult = Consult::where('target_agency', '=', $agency->title)->where('country', '=', $request->country)->get();
        
    //         foreach($consult as $c){
                
    //           $chat  = Group_Chat::where('module_id', $c->id)->get();
               
    //           foreach($chat as $message){
                   
    //           $message  = json_decode($message->message);
    //             $lastmessage = end($message);
    //             if($lastmessage){
                    
    //                 $c['last_message'] = $lastmessage;
    //             }else{
    //                 $c['last_message'] = null;
    //             }
         
                   
    //           }
               
    
               
                
                
    //             $verifyBadge  = Used_code::where('user_id', '=', $c->user_id)
    //             ->where('expiry_date', '>', now())
    //             ->first();
                
    //             if($verifyBadge){
    //                 $c['verify_badge'] =  true;
    //             }else{
    //                 $c['verify_badge'] =  false;
    //             }
            
    //         $c['guardians'] = Dependant::where('user_id', '=', $c->user_id)->get();
    //         $c['images'] = json_decode($c->images);
            
    //         $user=  User::find($c->user_id);
            
    //         if($c->anonymous == 'Yes'){
                
    //             $user->firstname  = null;
    //             $user->lastname  = null;
    //             $user->email = null;
    //             $user->phone_number = null;
    //             $user->ksn = null;
    //             $c->ksn = null;
    //         }
    //             $c['user'] = $user;
            
            
    //         }
        
    //     }else{
            
    //          $perpage =  $request->per_page;
    //         $agency = Agencies::find($id);
    //         $consult = Consult::where('target_agency', $agency->title)->get();
            
    //         foreach($consult as $c){
                
                
                
    //               $chat  = Group_Chat::where('module_id', $c->id)->get();
               
    //           foreach($chat as $message){
                   
    //           $message  = json_decode($message->message);
    //             $lastmessage = end($message);
    //             if($lastmessage){
                    
    //                 $c['last_message'] = $lastmessage;
    //             }else{
    //                 $c['last_message'] = null;
    //             }
         
                   
    //           }
                
    //             $verifyBadge  = Used_code::where('user_id', '=', $c->user_id)
    //             ->where('expiry_date', '>', now())
    //             ->first();
                
    //             if($verifyBadge){
    //                 $c['verify_badge'] =  true;
    //             }else{
    //                 $c['verify_badge'] =  false;
    //             }
    //             $c['guardians'] = Dependant::where('user_id', '=', $c->user_id)->get();
    //             $c['images'] = json_decode($c->images);
                
                
    //             $user  = User::find($c->user_id);
                
    //             if($c->anonymous == 'Yes'){
    //                 $user->firstname = null;
    //                 $user->lastname = null;
    //                 $user->ksn = null;
    //                 $user->email = null;
    //                 $c->ksn = null;
    //             }
    //             $c['user'] = $user;
            
    //         }
    //     }
    
    // $success['status'] = 200;
    // $success['message'] = 'Agency consulationn found successfully ';
    // $success['data'] =  $consult;
    
    // return response()->json(['success' => $success]);
    // }


public function showAgencyConsult($id)
{
    $subaccount = Sub_Account::find($id);
 
    $decoded_ids = json_decode($subaccount->agency_id, true);

    $agencies = Agencies::whereIn('id', $decoded_ids)->get()->toArray();
    $agency_titles = array_column($agencies, 'title');

    $consults = [];
    
    if ($subaccount->country && !$subaccount->location) {

        $consults = Consult::whereIn('target_agency', $agency_titles)
                           ->where('country', $subaccount->country)
                           ->get();
                           
                           
         foreach ($consults as $c) {
             
                    $c['last_message'] = null;                
                    $chats = Group_Chat::where('module_id', $c->id)->get();
                    foreach ($chats as $chat) {
                        $messages = json_decode($chat->message, true);
                        $c['last_message'] = $messages ? end($messages) : null;
                    }
            
                    $verifyBadge = Used_code::where('user_id', $c->user_id)
                                             ->where('expiry_date', '>', now())
                                             ->first();
                    $c['verify_badge'] = $verifyBadge ? true : false;
                    $c['guardians'] = Dependant::where('user_id', $c->user_id)->get();
                    $c['images'] = json_decode($c->images, true);
            
                    $user = User::find($c->user_id);
                    if ($user && $c->anonymous === 'Yes') {
                        $user->firstname = null;
                        $user->lastname = null;
                        $user->email = null;
                        $user->phone_number = null;
                        $user->ksn = null;
                        $c->ksn = null;
                    }
                    $c['user'] = $user;
             }
             
             
             
             $success['status'] = 200;
             $success['message'] = 'Country wise requests found successfully';
             $success['data'] = $consults;
             
             return response()->json(['success' => $success]);
                               
                           
    } else if ($subaccount->country && $subaccount->location) {
       
         $consults = Consult::whereIn('target_agency', $agency_titles)
                           ->where('country',$subaccount->country)
                           ->where('location',$subaccount->location)
                           ->get();
                           
             foreach ($consults as $c) {
                    $chats = Group_Chat::where('module_id', $c->id)->get();
                    foreach ($chats as $chat) {
                        $messages = json_decode($chat->message, true);
                        $c['last_message'] = $messages ? end($messages) : null;
                    }
            
                    $verifyBadge = Used_code::where('user_id', $c->user_id)
                                             ->where('expiry_date', '>', now())
                                             ->first();
                    $c['verify_badge'] = $verifyBadge ? true : false;
                    $c['guardians'] = Dependant::where('user_id', $c->user_id)->get();
                    $c['images'] = json_decode($c->images, true);
            
                    $user = User::find($c->user_id);
                    if ($user && $c->anonymous === 'Yes') {
                        $user->firstname = null;
                        $user->lastname = null;
                        $user->email = null;
                        $user->phone_number = null;
                        $user->ksn = null;
                        $c->ksn = null;
                    }
                    $c['user'] = $user;
             }
             
             
             
             $success['status'] = 200;
             $success['message'] = 'Country and location wise requests found successfully';
             $success['data'] = $consults;
             
             return response()->json(['success' => $success]);
                           
    }

}


    public function show_user_suggestion($user_id)
    {
        $travel = Suggestion::where('user_id', '=', $user_id)->get();
        if ($travel) {
            $success['data'] = $travel;
            $success['status'] = 200;
            $success['message'] = 'found successfully';
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }



    public function edit_sos(Request $request, $id)
    {
        $feedback = Sos::find($id);

        //   if ($request->hasFile('images')) {
        //     // Array to store the uploaded files' details
        //     $uploadedFiles = [];

        //     // Loop through each uploaded file
        //     foreach ($request->file('images') as $file) {
        //         $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

        //         // Get the file extension
        //         $extension = $file->extension();

        //         // Determine the type of the file based on its extension
        //         if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
        //             $uploadedFile->type = 'image';
        //         } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
        //             $uploadedFile->type = 'video';
        //         } elseif (in_array($extension, ['mp3'])) {
        //             $uploadedFile->type = 'audio';
        //         } else {
        //             // You can handle other file types if needed
        //             $uploadedFile->type = 'unknown';
        //         }

        //         // Generate a unique filename for the uploaded image
        //         $uploadedImage = rand(1000, 9999) . '.' . $file->extension();

        //         // Store the uploaded image on the S3 disk
        //         $path = $file->storeAs('sos_images', $uploadedImage, ['disk' => 's3']);

        //         // Set the URL of the uploaded image
        //         $uploadedFile->url = $path;

        //         // Add the uploaded file details to the array
        //         $uploadedFiles[] = $uploadedFile;
        //     }

        //     // Convert the array of uploaded files into JSON and store it in the 'images' property
        //     $feedback->images = json_encode($uploadedFiles);
        // } elseif ($request->filled('images')) {
        //     // If no new images were uploaded but 'images' field is present in the request,
        //     // directly assign the value to the 'images' property
        //     $feedback->images = $request->images;
        // }

        if ($request->coordinate) {

            $feedback->coordinate = json_encode($request->coordinate);
        }

        if ($request->map) {
            $feedback->map = $request->map;
        }

        if ($request->name) {
            $feedback->name = $request->name;
        }
        if ($request->phone_number) {
            $feedback->phone_number = $request->phone_number;
        }
        if ($request->country) {
            $feedback->country = $request->country;
        }
        if ($request->status) {
            $feedback->status = $request->status;

            if ($request->status === 'Resolved') {
                $u = User::find($feedback->user_id);
                $u->notify_count = $u->notify_count + 1;
                $u->save();
                $playerId = [$u->device_token];
                $subject = 'The status of Emergency ' . $feedback->reference_code . ' is now RESOLVED';

                if ($u->language === 'English') {
                    // No translation needed, use the original sentence in English.
                    $translated_sentence = $subject;
                } elseif ($u->language === 'Yoruba') {
                    // Translate to Yoruba
                    $translated_sentence = 'Awọn iwọsọna ti Emerojensi ' . $feedback->reference_code . ' ni yoo ti wa nile lọ.';
                } elseif ($u->language === 'Igbo') {
                    // Translate to Igbo
                    $translated_sentence = 'Akwụkwọ nke Nkpọlolite ' . $feedback->reference_code . ' bụ ugbu a.';
                } elseif ($u->language === 'French') {
                    // Translate to French
                    $translated_sentence = 'L\'état d\'urgence ' . $feedback->reference_code . ' est désormais RÉSOLU.';
                } elseif ($u->language === 'Hausa') {
                    $translated_sentence = 'Nau in muryar layin ikirarin ' . $feedback->reference_code . ' yana harsashi.';
                } elseif ($u->language === 'Arabic') {
                    // Translate to Arabic
                    $translated_sentence = 'حالة الطوارئ ' . $feedback->reference_code . ' الآن مُحَلَّة.';
                } elseif ($u->language === 'Chinese') {
                    // Translate to Chinese
                    $translated_sentence = '紧急情况 ' . $feedback->reference_code . ' 现已解决。';
                } elseif ($u->language === 'Spanish') {
                    // Translate to Spanish
                    $translated_sentence = 'El estado de emergencia ' . $feedback->reference_code . ' ahora está RESUELTO.';
                } elseif ($u->language === 'Portuguese') {
                    // Translate to Portuguese
                    $translated_sentence = 'O estado de emergência ' . $feedback->reference_code . ' agora está RESOLVIDO.';
                } elseif ($u->language === 'Fula') {
                    // Translate to Fula
                    $translated_sentence = 'Nadata na Tambayoyin ' . $feedback->reference_code . ' yana RESOLVED yanzu.';
                } else {
                    // Default to English if the language preference is not recognized.
                    $translated_sentence = $subject;
                }

                $notificationTitle = 'Kaci';
                $content = array(
                    "en" => $translated_sentence,
                );

                $fields = array(
                    'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                    'ios_badgeType' => "Increase",
                    'ios_badgeCount' =>  $u->notify_count,
                    'include_player_ids' =>   $playerId,
                    'data' => array("foo" => "NewMassage", "type" => 'Sos Resolved'),
                    'contents' => $content,
                    'headings' => array(
                        "en" => $notificationTitle
                    )
                );

                $fields = json_encode($fields);


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json; charset=utf-8',
                    'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($ch);
                curl_close($ch);
            }
        }
        if ($request->admin) {
            $feedback->admin = $request->admin;
        }
        if ($request->response) {
            $feedback->response = $request->response;
        }
        if ($request->created_at) {
            $feedback->created_at = $request->created_at;
        }
        if ($request->device) {
            $feedback->device = $request->device;
        }
        if ($request->reference_code) {
            $feedback->reference_code = $request->reference_code;
        }
        if ($request->location) {
            $feedback->location = $request->location;
        }
        if ($request->address) {
            $feedback->address = $request->address;
        }
        if ($request->comments) {
            $feedback->comments = $request->comments;
        }
        
        if ($request->target_agency) {
            $feedback->target_agency = $request->target_agency;
        }



        $feedback->save();
        $users = User::find($feedback->user_id);
        if ($users) {
            $feedback['firstname'] = $users->firstname;
            $feedback['lastname'] = $users->lastname;
            $feedback['email'] = $users->email;
            $feedback['ksn'] = $users->ksn;
            $feedback['phone_number'] = $users->phone_number;
            $feedback['profile_image'] = $users->profile_image;
        }
        $feedback['link'] = 'https://kacihelp.com/emergency/' . $feedback->reference_code;
        $success['data'] = $feedback;
        $success['status'] = 200;
        $success['message'] = 'updated successfully';
        return response()->json(['success' => $success], $this->successStatus);
    }


    public function sos()
    {
        $ambulance = Sos::all();
        $data = [];
        foreach ($ambulance as $a) {
            $user = User::find($a->user_id);
            if ($user) {
                
                
                   $verifyBadge = Used_code::where('user_id', $user->id)
                                             ->where('expiry_date', '>', now())
                                             ->first();
                    $a['verify_badge'] = $verifyBadge ? true : false;
                $a['firstname'] = $user->firstname;
                $a['lastname'] = $user->lastname;
                $a['phone_number'] = $user->phone_number;
                $a['email'] = $user->email;
                $a['ksn'] = $user->ksn;
                $a['link'] = 'https://kacihelp.com/emergency/' . $a->reference_code;
                $a['profile_image'] = $user->profile_image;
                $country = General_Countries::where('country_name', '=', $user->country)->first();
                if ($country) {
                    $a['flag_code'] = $country->flag_code;
                    $a['country_code'] = $country->country_code;
                }
                $response = Response::where('type_id', '=', $a->id)->where('user_id', '=', $a->user_id)->where('type', '=', 'emergency')->get();
                if ($response->count() > 0) {
                    $responses = [];
                    foreach ($response as $res) {
                        $admin = Sub_Admin::where('name', '=', $res->admin_name)->first();
                        if ($admin) {
                            $res['admin_email'] = $admin->email;
                        }
                        $responses[] = $res;
                    }

                    $a['responses'] = $responses;
                }
                $dependant = Dependant::where('user_id', '=', $a->user_id)->get();
                if ($dependant->count() > 0) {
                    $a['dependant'] = $dependant;
                } else {
                }
            }

            $data[] = $a;
        }
        $success['data'] = $data;
        $success['status'] = 200;
        $success['message'] = 'found successfully';
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function delete_report($id)
    {
        $ambulance = Report::find($id);
        if ($ambulance) {
            $ambulance->delete();
            $success['data'] = $ambulance;
            $success['status'] = 200;
            $success['message'] = 'delete successfully';
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }





    public function delete_suggestion($id)
    {
        $ambulance = Suggestion::find($id);
        if ($ambulance) {
            $ambulance->delete();
            $success['data'] = $ambulance;
            $success['status'] = 200;
            $success['message'] = 'delete successfully';
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }



    public function report()
    {
        $ambulance = Report::all();
        $data = [];
        foreach ($ambulance as $a) {


            $user = User::find($a->user_id);
            if ($user) {
                
                   $verifyBadge = Used_code::where('user_id', $user->id)
                                             ->where('expiry_date', '>', now())
                                             ->first();
                    $a['verify_badge'] = $verifyBadge ? true : false;
                    
                    
                $a['firstname'] = $user->firstname;
                $a['lastname'] = $user->lastname;
                $a['phone_number'] = $user->phone_number;
                $a['email'] = $user->email;
                $a['ksn'] = $user->ksn;
                $a['profile_image'] = $user->profile_image;
                $a['images'] = json_decode($a->images);
                $country = General_Countries::where('country_name', '=', $user->country)->first();
                if ($country) {
                    $a['flag_code'] = $country->flag_code;
                    $a['country_code'] = $country->country_code;
                }

                $response = Response::where('type_id', '=', $a->id)->where('user_id', '=', $a->user_id)->where('type', '=', 'report')->get();
                if ($response->count() > 0) {
                    $responses = [];
                    foreach ($response as $res) {
                        $admin = Sub_Admin::where('name', '=', $res->admin_name)->first();
                        if ($admin) {
                            $res['admin_email'] = $admin->email;
                        }
                        $responses[] = $res;
                    }

                    $a['responses'] = $responses;
                }
            }
            $data[] = $a;
        }
        $success['data'] = $data;
        $success['status'] = 200;
        $success['message'] = 'found successfully';
        return response()->json(['success' => $success], $this->successStatus);
    }








    public function suggestion()
    {
        $ambulance = Suggestion::all();
        $data = [];
        foreach ($ambulance as $a) {
            $user = User::find($a->user_id);
            if ($user) {
                
                
                   $verifyBadge = Used_code::where('user_id', $user->id)
                                             ->where('expiry_date', '>', now())
                                             ->first();
                    $a['verify_badge'] = $verifyBadge ? true : false;
                $a['firstname'] = $user->firstname;
                $a['phone_number'] = $user->phone_number;
                $a['email'] = $user->email;
                $a['ksn'] = $user->ksn;
                $a['lastname'] = $user->lastname;
                $a['profile_image'] = $user->profile_image;
                $country = General_Countries::where('country_name', '=', $user->country)->first();
                if ($country) {
                    $a['flag_code'] = $country->flag_code;
                    $a['country_code'] = $country->country_code;
                }
                $response = Response::where('type_id', '=', $a->id)->where('user_id', '=', $a->user_id)->where('type', '=', 'suggestion')->get();
                if ($response->count() > 0) {
                    $responses = [];
                    foreach ($response as $res) {
                        $admin = Sub_Admin::where('name', '=', $res->admin_name)->first();
                        if ($admin) {
                            $res['admin_email'] = $admin->email;
                        }
                        $responses[] = $res;
                    }

                    $a['responses'] = $responses;
                }
            }
            $data[] = $a;
        }
        $success['data'] = $data;

        $success['status'] = 200;
        $success['message'] = 'found successfully';
        return response()->json(['success' => $success], $this->successStatus);
    }




    public function edit_report(Request $request, $id)
    {
        $feedback = Report::find($id);

        //         if ($request->hasFile('images')) {
        //            $uploadedFiles = [];

        //     foreach ($request->file('images') as $file) {
        //         $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

        //         $extension = $file->extension(); // Get the file extension

        //         // Determine the type of the file based on its extension
        //         if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
        //             $uploadedFile->type = 'image';
        //         } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
        //             $uploadedFile->type = 'video';
        //         } elseif (in_array($extension, ['mp3'])) {
        //             $uploadedFile->type = 'audio';
        //         }  else {
        //             // You can handle other file types if needed
        //             $uploadedFile->type = 'unknown';
        //         }
        //    $uploadedImage =rand(1000,9999). '.' . $file->extension();
        //     $path = $file->storeAs('report_images', $uploadedImage, ['disk' => 's3']);
        //    $uploadedFile->url= $path;
        //         // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
        //         $uploadedFiles[] = $uploadedFile;
        //     }

        //    $feedback->images= json_encode($uploadedFiles);
        // }elseif ($request->filled('images')) {
        //             $feedback->images = $request->images;
        //         }
        if ($request->name) {
            $feedback->name = $request->name;
        }
        if ($request->phone_number) {
            $feedback->phone_number = $request->phone_number;
        }
        if ($request->country) {
            $feedback->country = $request->country;
        }
        if ($request->status) {
            $feedback->status = $request->status;
            if ($request->status === 'Resolved') {
                $u = User::find($feedback->user_id);
                $u->notify_count = $u->notify_count + 1;
                $u->save();
                $playerId = [$u->device_token];
                $subject = 'The status of Report ' . $feedback->reference_code . ' is now RESOLVED';

                if ($u->language === 'English') {
                    // No translation needed, use the original sentence in English.
                    $translated_sentence = $subject;
                } elseif ($u->language === 'Yoruba') {
                    // Translate to Yoruba
                    $translated_sentence = 'Awọn iwọsọna ti Iwọlẹ ' . $feedback->reference_code . ' ni yoo ti wa nile lọ.';
                } elseif ($u->language === 'Igbo') {
                    // Translate to Igbo
                    $translated_sentence = 'Akwụkwọ nke Ihe Mkpa ' . $feedback->reference_code . ' bụ ugbu a.';
                } elseif ($u->language === 'French') {
                    // Translate to French
                    $translated_sentence = 'L\'état du Rapport ' . $feedback->reference_code . ' est désormais RÉSOLU.';
                } elseif ($u->language === 'Hausa') {
                    // Translate to Hausa
                    $translated_sentence = 'Nau\'in matsayin Laporan ' . $feedback->reference_code . ' yana harsashi.';
                } elseif ($u->language === 'Arabic') {
                    // Translate to Arabic
                    $translated_sentence = 'حالة التقرير ' . $feedback->reference_code . ' الآن مُحَلَّة.';
                } elseif ($u->language === 'Chinese') {
                    // Translate to Chinese
                    $translated_sentence = '报告状态 ' . $feedback->reference_code . ' 现已解决。';
                } elseif ($u->language === 'Spanish') {
                    // Translate to Spanish
                    $translated_sentence = 'El estado del Informe ' . $feedback->reference_code . ' ahora está RESUELTO.';
                } elseif ($u->language === 'Portuguese') {
                    // Translate to Portuguese
                    $translated_sentence = 'O estado do Relatório ' . $feedback->reference_code . ' agora está RESOLVIDO.';
                } elseif ($u->language === 'Fula') {
                    // Translate to Fula
                    $translated_sentence = 'Nadata na Bayanin ' . $feedback->reference_code . ' yana RESOLVED yanzu.';
                } else {
                    // Default to English if the language preference is not recognized.
                    $translated_sentence = $subject;
                }

                // Now $translated_sentence contains the translated sentence based on the user's language preference.


                $content = array(
                    "en" => $translated_sentence,
                );
                $fields = array(
                    'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                    'ios_badgeType' => "Increase",
                    'ios_badgeCount' =>  $u->notify_count,
                    'include_player_ids' =>   $playerId,
                    'data' => array("foo" => "NewMassage"),
                    'contents' => $content
                );

                $fields = json_encode($fields);


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json; charset=utf-8',
                    'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($ch);
                curl_close($ch);
            }
        }
        if ($request->admin) {
            $feedback->admin = $request->admin;
        }
        if ($request->response) {
            $feedback->response = $request->response;
        }
        if ($request->created_at) {
            $feedback->created_at = $request->created_at;
        }
        if ($request->device) {
            $feedback->device = $request->device;
        }
        if ($request->reference_code) {
            $feedback->reference_code = $request->reference_code;
        }
        if ($request->location) {
            $feedback->location = $request->location;
        }
        if ($request->address) {
            $feedback->address = $request->address;
        }
        if ($request->date) {
            $feedback->date = $request->date;
        }
        if ($request->time) {
            $feedback->time = $request->time;
        }
        if ($request->subject) {
            $feedback->subject = $request->subject;
        }
        if ($request->details) {
            $feedback->details = $request->details;
        }
        if ($request->target_agency) {
            $feedback->target_agency = $request->target_agency;
        }
        if ($request->anonymous) {
            $feedback->anonymous = $request->anonymous;
        }
        if ($request->map) {
            $feedback->map = json_encode($request->map);
        }

        $feedback->save();
        $users = User::find($feedback->user_id);
        if ($users) {
            $feedback['firstname'] = $users->firstname;
            $feedback['lastname'] = $users->lastname;
            $feedback['email'] = $users->email;
            $feedback['ksn'] = $users->ksn;
            $feedback['phone_number'] = $users->phone_number;
            $feedback['profile_image'] = $users->profile_image;
        }
        $success['data'] =  $feedback;
        $success['status'] = 200;
        $success['message'] = 'updated successfully';
        return response()->json(['success' => $success], $this->successStatus);
    }








    public function edit_suggestion(Request $request, $id)
    {
        $feedback = Suggestion::find($id);

        //         if ($request->hasFile('images')) {
        //             $uploadedFiles = [];

        //     foreach ($request->file('images') as $file) {
        //         $uploadedFile = new \stdClass(); // Use \stdClass directly without the namespace

        //         $extension = $file->extension(); // Get the file extension

        //         // Determine the type of the file based on its extension
        //         if (in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
        //             $uploadedFile->type = 'image';
        //         } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
        //             $uploadedFile->type = 'video';
        //         } elseif (in_array($extension, ['mp3'])) {
        //             $uploadedFile->type = 'audio';
        //         } else {
        //             // You can handle other file types if needed
        //             $uploadedFile->type = 'unknown';
        //         }
        //    $uploadedImage =rand(1000,9999). '.' . $file->extension();
        //     $path = $file->storeAs('suggestion_images', $uploadedImage, ['disk' => 's3']);
        //    $uploadedFile->url= $path;
        //         // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
        //          $feedback->images = $uploadedFile;
        //     }

        //     $input['images'] = json_encode($uploadedFiles);
        // }elseif ($request->filled('images')) {
        //             $feedback->images = $request->images;
        //         }
        if ($request->name) {
            $feedback->name = $request->name;
        }
        if ($request->phone_number) {
            $feedback->phone_number = $request->phone_number;
        }
        if ($request->country) {
            $feedback->country = $request->country;
        }
        if ($request->status) {
            $feedback->status = $request->status;
            if ($request->status === 'Resolved') {
                $u = User::find($feedback->user_id);
                $u->notify_count = $u->notify_count + 1;
                $u->save();
                $playerId = [$u->device_token];
                $subject = 'The status of Suggestion ' . $feedback->reference_code . ' is now RESOLVED';

                if ($u->language === 'English') {
                    // No translation needed, use the original sentence in English.
                    $translated_sentence = $subject;
                } elseif ($u->language === 'Yoruba') {
                    // Translate to Yoruba
                    $translated_sentence = 'Awọn iwọsọna ti Akọle ' . $feedback->reference_code . ' ni yoo ti wa nile lọ.';
                } elseif ($u->language === 'Igbo') {
                    // Translate to Igbo
                    $translated_sentence = 'Akwụkwọ nke Akọle ' . $feedback->reference_code . ' bụ ugbu a.';
                } elseif ($u->language === 'French') {
                    // Translate to French
                    $translated_sentence = 'L\'état de la Suggestion ' . $feedback->reference_code . ' est désormais RÉSOLU.';
                } elseif ($u->language === 'Hausa') {
                    // Translate to Hausa
                    $translated_sentence = 'Nau\'in matsayin Suggestion ' . $feedback->reference_code . ' yana harsashi.';
                } elseif ($u->language === 'Arabic') {
                    // Translate to Arabic
                    $translated_sentence = 'حالة الاقتراح ' . $feedback->reference_code . ' الآن مُحَلَّة.';
                } elseif ($u->language === 'Chinese') {
                    // Translate to Chinese
                    $translated_sentence = '建议状态 ' . $feedback->reference_code . ' 现已解决。';
                } elseif ($u->language === 'Spanish') {
                    // Translate to Spanish
                    $translated_sentence = 'El estado de la Sugerencia ' . $feedback->reference_code . ' ahora está RESUELTO.';
                } elseif ($u->language === 'Portuguese') {
                    // Translate to Portuguese
                    $translated_sentence = 'O estado da Sugestão ' . $feedback->reference_code . ' agora está RESOLVIDO.';
                } elseif ($u->language === 'Fula') {
                    // Translate to Fula
                    $translated_sentence = 'Nadata na Tafiyarwa ' . $feedback->reference_code . ' yana RESOLVED yanzu.';
                } else {
                    // Default to English if the language preference is not recognized.
                    $translated_sentence = $subject;
                }

                $content = array(
                    "en" => $translated_sentence,
                );
                $fields = array(
                    'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                    'ios_badgeType' => "Increase",
                    'ios_badgeCount' =>  $u->notify_count,
                    'include_player_ids' =>   $playerId,
                    'data' => array("foo" => "NewMassage"),
                    'contents' => $content
                );

                $fields = json_encode($fields);


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json; charset=utf-8',
                    'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($ch);
                curl_close($ch);
            }
        }
        if ($request->admin) {
            $feedback->admin = $request->admin;
        }
        if ($request->response) {
            $feedback->response = $request->response;
        }
        if ($request->created_at) {
            $feedback->created_at = $request->created_at;
        }
        if ($request->device) {
            $feedback->device = $request->device;
        }
        if ($request->reference_code) {
            $feedback->reference_code = $request->reference_code;
        }
        if ($request->location) {
            $feedback->location = $request->location;
        }
        if ($request->problem_statement) {
            $feedback->problem_statement = $request->problem_statement;
        }
        if ($request->situation_suggestion) {
            $feedback->situation_suggestion = $request->situation_suggestion;
        }
        if ($request->desired_outcome) {
            $feedback->desired_outcome = $request->desired_outcome;
        }
        if ($request->target_agency) {
            $feedback->target_agency = $request->target_agency;
        }



        $feedback->save();
        $users = User::find($feedback->user_id);
        if ($users) {
            $feedback['firstname'] = $users->firstname;
            $feedback['lastname'] = $users->lastname;
            $feedback['email'] = $users->email;
            $feedback['phone_number'] = $users->phone_number;
            $feedback['ksn'] = $users->ksn;
            $feedback['profile_image'] = $users->profile_image;
        }
        $success['data'] =  $feedback;
        $success['status'] = 200;
        $success['message'] = 'updated successfully';
        return response()->json(['success' => $success], $this->successStatus);
    }




    public function alert_status(Request $request, $id)
    {
        $alert = Alert::find($id);
        if ($alert->status === 'Active') {
            $alert->status = 'InActive';
        } else {
            $alert->status = 'Active';
        }
        $alert->save();
        $success['data'] =   $alert;
        $success['status'] = 200;
        $success['message'] = 'updated successfully';
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function message_status(Request $request, $id)
    {
        $alert = Message::find($id);
        if ($alert->status === 'Active') {
            $alert->status = 'InActive';
        } else {
            $alert->status = 'Active';
        }
        $alert->save();
        $success['data'] =   $alert;
        $success['status'] = 200;
        $success['message'] = 'updated successfully';
        return response()->json(['success' => $success], $this->successStatus);
    }


    public function store_alert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'resident_country' => 'required',
            'push_notification' => 'required',


        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();


        $alert = Alert::create($input);
        $user = User::all();


        foreach ($user as $u) {
            $u->notify_count = $u->notify_count + 1;
            $u->save();
            if ($u->resident_country === $request->resident_country) {
                if ($u->notify_status === 'Active') {

                    if ($input['push_notification'] === 'Android') {
                        if ($u->device_name === 'Android') {
                            $playerId = [$u->device_token];
                            $subject = 'New Alert: ' . $input['description'];
                            $notificationTitle = 'Kaci';
                            $content = array(
                                "en" => $subject,
                            );

                            $fields = array(
                                'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                                'include_player_ids' => $playerId,
                                'ios_badgeType' => "Increase",
                                'ios_badgeCount' =>  $u->notify_count,
                                'contents' => $content,
                                'headings' => array(
                                    "en" => $notificationTitle
                                )
                            );

                            $fields = json_encode($fields);


                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json; charset=utf-8',
                                'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
                            ));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                            $response = curl_exec($ch);
                            curl_close($ch);
                        }
                    } else if ($input['push_notification'] === 'IOS' || $input['push_notification'] === 'iOS') {

                        if ($u->device_name === 'IOS') {
                            $u->notify_count = $u->notify_count + 1;
                            $u->save();
                            $playerId = [$u->device_token];
                            $subject = 'New Alert: ' . $input['description'];
                            $notificationTitle = 'Kaci';
                            $content = array(
                                "en" => $subject,
                            );

                            $fields = array(
                                'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                                'include_player_ids' => $playerId,
                                'ios_badgeType' => "Increase",
                                'ios_badgeCount' =>  $u->notify_count,
                                'contents' => $content,
                                'headings' => array(
                                    "en" => $notificationTitle
                                )
                            );

                            $fields = json_encode($fields);


                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json; charset=utf-8',
                                'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
                            ));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                            $response = curl_exec($ch);
                            curl_close($ch);
                        }
                    } else {
                        $u->notify_count = $u->notify_count + 1;
                        $u->save();
                        $playerId = [$u->device_token];
                        $subject = 'New Alert: ' . $input['description'];
                        $notificationTitle = 'Kaci';
                        $content = array(
                            "en" => $subject,
                        );

                        $fields = array(
                            'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                            'include_player_ids' => $playerId,
                            'ios_badgeType' => "Increase",
                            'ios_badgeCount' =>  $u->notify_count,
                            'contents' => $content,
                            'headings' => array(
                                "en" => $notificationTitle
                            )
                        );

                        $fields = json_encode($fields);


                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json; charset=utf-8',
                            'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
                        ));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_HEADER, false);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                        $response = curl_exec($ch);
                        curl_close($ch);
                    }
                } else {
                }
            }
        }
        $success['data'] = $alert;
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function delete_alert($id)
    {
        $alert = Alert::find($id);
        if ($alert) {
            $alert->delete();
            $success['data'] = $alert;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }

    public function alerts()
    {
        $alert = Alert::all();
        $success['data'] = $alert;
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }
    public function device_alerts(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'resident_country' => 'required',
        ]);
        $alerts = Alert::where('push_notification', '=', $request->type)
            ->where('resident_country', '=', $request->resident_country)->where('status', '=', 'Active')
            ->orderBy('created_at', 'desc')
            ->get();

        $alert = Alert::where('push_notification', '=', 'All')
            ->where('resident_country', '=', $request->resident_country)->where('status', '=', 'Active')
            ->orderBy('created_at', 'desc')
            ->get();

        // Combine the two collections and sort by created_at in descending order
        $messageCollection = $alert->concat($alerts)->sortByDesc('created_at');

        // Convert the collection to a traditional array
        $message = $messageCollection->toArray();
        $responseArray = array_values($message);

        // Now, $responseArray is a traditional JSON array

        $success =  ['data' => $responseArray];
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }


    public function alert_id($id)
    {
        $alert = Alert::find($id);
        if ($alert) {
            $success['data'] = $alert;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }
    
    
    public function edit_alert(Request $request, $id){
        
        
        $alert  = Alert::find($id);
        
        if($alert){
            
            if($request->description){
                $alert->description = $request->description;
            }
            
            if($request->title){
                $alert->title = $request->title;
            }
            
            if($request->resident_country){
                $alert->resident_country =  $request->resident_country;
            }
            
            if($request->status){
                $alert->status =  $request->status;
            }
            
            
            if($request->push_notification){
                $alert->push_notification = $request->push_notification;
            }
            
            $alert->save();
            
            $success['status'] = 200;
            $success['message'] = 'Updated successfully';
            $success['data'] =  $alert;
            
            return response()->json(['success' => $success]);
            
        
            
        }else{
            
            
            $success['status'] = 400;
            $success['message'] =  'Alert not found';
            
            return response()->json(['error' => $success]);
        }
        
    }




    public function store_message(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'resident_country' => 'required',
            'push_notification' => 'required',
            'title' => 'required',


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
                $path = $file->storeAs('message_images', $uploadedImage, ['disk' => 's3']);
                $uploadedFile->url = "https://kaci-storage.s3.amazonaws.com/" . $path;
                // $uploadedFile->url = $file->storeAs('sos_images', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
                $uploadedFiles[] = $uploadedFile;
            }

            $input['images'] = json_encode($uploadedFiles);
        }


        $alert = Message::create($input);
        $user = User::all();

        foreach ($user as $u) {
            if ($u->resident_country === $request->resident_country) {
                if ($u->notify_status === 'Active') {

                    if ($input['push_notification'] === 'Android') {
                        if ($u->device_name === 'Android') {
                            $u->notify_count = $u->notify_count + 1;
                            $u->save();
                            $playerId = [$u->device_token];
                            $subject = 'New Message: ' . $input['description'];
                            $notificationTitle = 'Kaci';
                            $content = array(
                                "en" => $subject,
                            );

                            $fields = array(
                                'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                                'include_player_ids' => $playerId,
                                'ios_badgeType' => "Increase",
                                'ios_badgeCount' =>  $u->notify_count,
                                'data' => array("foo" => "NewMassage", "type" => 'message'),
                                'contents' => $content,
                                'headings' => array(
                                    "en" => $notificationTitle
                                )
                            );

                            $fields = json_encode($fields);


                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json; charset=utf-8',
                                'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
                            ));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                            $response = curl_exec($ch);
                            curl_close($ch);
                        }
                    } else if ($input['push_notification'] === 'IOS' || $input['push_notification'] === 'iOS') {

                        if ($u->device_name === 'IOS') {
                            $u->notify_count = $u->notify_count + 1;
                            $u->save();
                            $playerId = [$u->device_token];
                            $subject = 'New Message: ' . $input['description'];
                            $notificationTitle = 'Kaci';
                            $content = array(
                                "en" => $subject,
                            );

                            $fields = array(
                                'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                                'include_player_ids' => $playerId,
                                'ios_badgeType' => "Increase",
                                'ios_badgeCount' =>  $u->notify_count,
                                'data' => array("foo" => "NewMassage", "type" => 'message'),
                                'contents' => $content,
                                'headings' => array(
                                    "en" => $notificationTitle
                                )
                            );

                            $fields = json_encode($fields);


                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json; charset=utf-8',
                                'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
                            ));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                            $response = curl_exec($ch);
                            curl_close($ch);
                        }
                    } else {
                        $u->notify_count = $u->notify_count + 1;
                        $u->save();
                        $playerId = [$u->device_token];
                        $subject = 'New Message: ' . $input['description'];
                        $notificationTitle = 'Kaci';
                        $content = array(
                            "en" => $subject,
                        );

                        $fields = array(
                            'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                            'include_player_ids' => $playerId,
                            'ios_badgeType' => "Increase",
                            'ios_badgeCount' =>  $u->notify_count,
                            'data' => array("foo" => "NewMassage", "type" => 'message'),
                            'contents' => $content,
                            'headings' => array(
                                "en" => $notificationTitle
                            )
                        );

                        $fields = json_encode($fields);


                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json; charset=utf-8',
                            'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
                        ));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_HEADER, false);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                        $response = curl_exec($ch);
                        curl_close($ch);
                    }
                } else {
                }
            }
        }

        $success['data'] = $alert;
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function delete_message($id)
    {
        $alert = Message::find($id);
        if ($alert) {
            $alert->delete();
            $success['data'] = $alert;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }

    public function messages()
    {
        $alert = Message::all();
        $success['data'] = $alert;
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function device_message(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'resident_country' => 'required'
        ]);

        $alert = Message::where('push_notification', '=', $request->type)->where('resident_country', '=', $request->resident_country)->where('status', '=', 'Active')->orderBy('created_at', 'desc')
            ->get();
        $alerts = Message::where('push_notification', '=', 'All')->where('resident_country', '=', $request->resident_country)->where('status', '=', 'Active')->orderBy('created_at', 'desc')
            ->get();
        $messageCollection = $alert->concat($alerts)->sortByDesc('created_at');
        $data = [];
        foreach ($messageCollection as $a) {
            $a['images'] = json_decode($a->images);
            $data[] = $a;
        }
        // Convert the collection to a traditional array
        $message = $data;
        $responseArray = array_values($message);

        // Now, $responseArray is a traditional JSON array

        $success =  ['data' => $responseArray];


        $success['data'] = $data;
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function message_id($id)
    {
        $alert = Message::find($id);
        if ($alert) {
            $success['data'] = $alert;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = 'not found';
            return response()->json(['error' => $success]);
        }
    }
    
    
    
    
    public function edit_messages(Request $request , $id){
        
        $message = Message::find($id);
        
        if($message){
            
            
            if($request->description){
                $message->description = $request->description;
            }
            
            if($request->resident_country){
                $message->resident_country = $request->resident_country;
            }
            
            if($request->push_notification){
                $message->push_notification  =  $request->push_notification;
            }
            
            if($request->status){
                $message->status = $request->status;
            }
            
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
                $path = $file->storeAs('message_images', $uploadedImage, ['disk' => 's3']);
                $uploadedFile->url = "https://kaci-storage.s3.amazonaws.com/" . $path;
                $uploadedFiles[] = $uploadedFile;
            }

            $message->images= json_encode($uploadedFiles);
            }
        
            $success['status'] = 200;
            $success['message'] =  'Updated successfully';
            $success['data'] =  $message;
            
            return response()->json(['success' => $success]);
            
        }else{
            
            $success['status'] = 400;
            $success['message'] = 'Message id not found ';
            
            return response()->json(['success' => $success]);
        }
    }


    public function create_role(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|unique:role,name',
            'privilage.*' => 'required', // Assuming privilage is an array
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $roleData = $request->input('role');
        $role = Role::create(['name' => $roleData]);

        $privileges = $request->input('privilage');
        $input = $request->all();
        $privilege = Role_Privilage::create(['role' => $input['role'], 'privilage' => json_encode($privileges)]);
        $success['data'] = $privilege;
        $success['status'] = 200;
        $success['message'] = "New role with privileges created";

        return response()->json(['success' => $success], $this->successStatus);
    }


    public function create_admin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:sub_admin,email',
            'phone_number' => 'required|unique:sub_admin,phone_number',
            'password' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $input = $request->all();
        $role = Role_Privilage::where('role', '=', $input['role'])->first();
        if ($role) {

            $input['privilage'] = $role->privilage;
        } else {
            $success['status'] = 400;
            $success['message'] = "Role not found";


            return response()->json(['error' => $success]);
        }
        $admin = Sub_Admin::create($input);
        $success['data'] = $admin;
        $success['status'] = 200;
        $success['message'] = "New sub admin created";

        return response()->json(['success' => $success], $this->successStatus);
    }




    public function admin_edit(Request $request, $id)
    {
        $user = Sub_Admin::find($id);
        if ($user) {
            $validator = Validator::make($request->all(), [
                'email' => 'unique:admin',
                'phone_number' => 'unique:admin',

            ]);

            $input = $request->all();


            // dd($input['old_password'],$user->password);

            if ($request->password) {
                $user->password = $request->password;
            } else {
            }

            if ($request->name) {
                $user->name = $request->name;
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
            if ($request->role) {
                $user->role = $request->role;
                $role = Role_Privilage::where('role', '=', $request->role)->first();
                $user->privilage = $role->privilage;
            } else {
            }
            $user->save();
            $success['data'] = $user;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['message'] = 'no found';
            $success['status'] = 400;
            return response()->json(['success' => $success], $this->successStatus);
        }
    }






    public function role_privilage_delete($id)
    {
        $role_privilage = Role_Privilage::find($id);
        if ($role_privilage) {
            $role = Role::where('name', '=', $role_privilage->role)->first();

            if ($role) {
                $role->delete();
            } else {
                $success['status'] = 400;
                $success['message'] = "ROle not found";


                return response()->json(['error' => $success]);
            }
            $role_privilage->delete();
            $success['data'] = $role_privilage;
            $success['status'] = 200;
            $success['message'] = "Role and privilage " . $role_privilage->id . " delete successfully";
        } else {
            $success['status'] = 400;
            $success['message'] = "Role and privilage not found";


            return response()->json(['error' => $success]);
        }
    }







    public function role_privilage_edit(Request $request, $id)
    {
        $role_privilage = Role_Privilage::find($id);

        if ($role_privilage) {
            if ($request->role) {
                $admin = Sub_Admin::where('role', '=', $role_privilage->role)->get();
                if ($admin) {
                    foreach ($admin as $a) {
                        $a->role = $request->role;
                        $a->save();
                    }
                } else {
                }
                $role = Role::where('name', '=', $role_privilage->role)->first();
                if ($role) {
                    $role->name = $request->role;
                    $role->save();
                } else {
                    echo 'not found';
                }

                $role_privilage->role = $request->role;
            } else {
            }
            if ($request->privilage) {
                $admin = Sub_Admin::where('role', '=', $role_privilage->role)->get();
                if ($admin) {
                    foreach ($admin as $a) {
                        $a->privilage = $request->privilage;
                        $a->save();
                    }
                } else {
                }

                $role_privilage->privilage = $request->privilage;
            } else {
            }
            $role_privilage->save();
            $success['data'] = $role_privilage;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = "Role and privilage not found";


            return response()->json(['error' => $success]);
        }
    }







    public function admin_profile_edit(Request $request, $id)
    {
        $user = Sub_Admin::find($id);
        $validator = Validator::make($request->all(), [
            'profile_image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'email' => 'unique:sub_admin',
            'phone_number' => 'unique:sub_admin',

        ]);
        $input = $request->all();
        if ($request->hasfile('profile_image')) {

            //             // $path = $input['profile_image']->storeAs('img', $profile_image, 'public');
            //     $store = Storage::put('profile_images', $profile_image);
            //             $path = Storage::disk('s3')->put('profile_images', $profile_image);
            //   $user->profile_image = "https://storage.kacihelp.com/".$path;

            //This is to get the extension of the image file just uploaded
            $image = time() . '.' . $request->file('profile_image')->extension();
            $path = $request->file('profile_image')->storeAs('admin-profile', $image, ['disk' => 's3']);
            $url = Storage::disk('s3')->url('admin-profile/' . $image);
            $user->profile_image = "https://kaci-storage.s3.amazonaws.com/" . $path;
        } elseif ($request->filled('profile_image')) {
            $user->profile_image = $request->profile_image;
        }

        // dd($input['old_password'],$user->password);

        if ($request->password) {
            $user->password   = $request->password;
        } else {
        }

        if ($request->name) {
            $user->name = $request->name;
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
        if ($request->about) {
            $user->about = $request->about;
        } else {
        }
        $user->save();
        $success['data'] = $user;
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }





    public function admin_id($id)
    {
        $user = Sub_Admin::find($id);
        if ($user === null) {
            $success['status'] = 400;
            $success['message'] = "Admin not Found";
            return response()->json(['error' => $success], $this->successStatus);
        } else {
            $success['data'] = $user;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        }
    }





    public function admin()
    {
        $user = Sub_Admin::all();
        $success['data'] = $user;
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }






    public function admin_delete($id)
    {
        $category = Sub_Admin::find($id);
        if ($category) {
            $category->delete();
            $success['data'] = $category;
            $success['status'] = 200;
            $success['message'] = "Admin " . $category->id . " delete successfully";


            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = "Admin not found";


            return response()->json(['error' => $success]);
        }
    }





    public function role()
    {
        $privilage = Role::all();
        $success['data'] = $privilage;
        $success['status'] = 200;
        $success['message'] = "All role found Successfully";
        return response()->json(['success' => $success], $this->successStatus);
    }





    public function role_privilage()
    {
        $privilage = Role_Privilage::all();
        $success['data'] = $privilage;
        $success['status'] = 200;
        $success['message'] = "All role found Successfully";
        return response()->json(['success' => $success], $this->successStatus);
    }





    public function role_privilage_id($id)
    {
        $privilage = Role_Privilage::find($id);
        if ($privilage) {
            $success['data'] = $privilage;
            $success['status'] = 200;
            $success['message'] = "role and privilage found Successfully";
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['message'] = "Role and privilage not found";


            return response()->json(['error' => $success]);
        }
    }






    public function edit_about(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'language' => 'required',
        ]);
        $setting = Setting::where('language', '=', $request->language)->where('type', '=', $request->type)->first();
        if ($setting) {
            if ($request->description) {
                $setting->description = $request->description;
                $setting->save();
                $success['data'] = $setting;
                $success['status'] = 200;
                $success['message'] = "Setting update Successfully";
                return response()->json(['success' => $success], $this->successStatus);
            }
        } else {
            $success['status'] = 400;
            $success['message'] = "not found";
            return response()->json(['error' => $success]);
        }
    }






    public function show_about(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'language' => 'required',
        ]);
        $setting = Setting::where('language', '=', $request->language)->where('type', '=', $request->type)->first();
        if ($setting) {
            $success['data'] = $setting;
            $success['status'] = 200;
            $success['message'] = "Setting found Successfully";
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $setting = Setting::where('language', '=', 'English')->where('type', '=', $request->type)->first();
            $success['data'] = $setting;
            $success['status'] = 200;
            $success['message'] = "Setting found Successfully";
            return response()->json(['success' => $success], $this->successStatus);
        }
    }





    public function store_general_countries(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_name' => 'required|unique:general_countries',
            'country_code' => 'required|unique:general_countries',
            'flag_code' => 'required',
            'featured' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $country = General_Countries::create($input);
        $success['data'] = $country;
        $success['status'] = 200;
        $success['message'] = 'Country Added Successfully';

        return response()->json(['success' => $success], $this->successStatus);
    }





    public function edit_general_countries(Request $request, $id)
    {
        $country = General_Countries::find($id);


        if ($request->country_name) {
            $country->country_name = $request->country_name;
        }
        if ($request->country_code) {
            $country->country_code = $request->country_code;
        }
        if ($request->status) {
            $country->status = $request->status;
        }
        if ($request->flag_code) {
            $country->flag_code = $request->flag_code;
        }
        if ($request->featured) {
            $country->featured = $request->featured;
        }
        $country->save();

        $success['data'] = $country;
        $success['status'] = 200;
        $success['message'] = 'Country edit Successfully';

        return response()->json(['success' => $success], $this->successStatus);
    }




    public function delete_general_countries($id)
    {
        $country = General_Countries::find($id);
        if ($country) {
            $country->delete();
            $success['status'] = 200;
            $success['message'] = 'Country Deleted Successfully';

            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $error['status'] = 400;
            $error['message'] = 'Country not Found';
            return response()->json(['error' => $error]);
        }
    }




    public function general_country()
    {
        $country = General_Countries::where('status', '=', 'Active')->get();
        $success['data'] = $country;
        $success['status'] = 200;
        $success['message'] = 'All Countries';

        return response()->json(['success' => $success], $this->successStatus);
    }



    public function countriesbyid($id)
    {
        $country = General_Countries::find($id);
        if ($country) {
            $success['id'] = $id;
            $success['data'] = $country;
            $success['status'] = 200;
            $success['message'] = 'Country Found';

            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $error['status'] = 400;
            $error['message'] = 'Country not Found';
            return response()->json(['error' => $error]);
        }
    }





    public function country_featured()
    {
        $featured = General_Countries::where('featured', '=', "YES")->where('status', '=', 'Active')->get();
        $nonfeatured = General_Countries::where('featured', '=', "NO")->get();

        $success['data'] = $featured->concat($nonfeatured);
        $success['status'] = 200;
        $success['message'] = "country successfully";
        return response()->json(['success' => $success], $this->successStatus);
    }




    public function show_admin_email()
    {
        $admin = Admin_Email::all();
        if ($admin->count() > 0) {
            $success['data'] = $admin;
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = "Admin not found";

            return response()->json(['error' => $success]);
        }
    }




    public function admin_email_edit(Request $request, $id)
    {
        $adminEmail = Admin_Email::findOrFail($id);

        // Get the name and email values from the request payload
        $name = $request->input('name');
        $email = $request->input('email');

        // Convert the name and email arrays to JSON strings
        $nameJson = json_encode($name);
        $emailJson = json_encode($email);

        // Update the name and email properties of the admin_email record
        $adminEmail->name = $nameJson;
        $adminEmail->email = $emailJson;

        $adminEmail->save();

        return response()->json(['message' => 'Admin email updated successfully'], 200);
    }



    public function create_relation_type(Request $request)
    {
        $request->validate([
            'relation_type' => 'required',
            'language' => 'required',
        ]);

        $relation = Relation::create([
            'relation_type' => $request->relation_type,
            'language' => $request->language,
        ]);
        $success['data'] = $relation;
        $success['status'] = 200;
        $success['message'] = 'relation created successfully';

        return response()->json(['success' => $success], $this->successStatus);
    }


    public function edit_relation_type(Request $request, $id)
    {
        $relation = Relation::find($id);
        $relation->relation_type = $request->relation_type;
        $relation->language = $request->language;
        $relation->save();
        $success['data'] = $relation;
        $success['status'] = 200;
        $success['message'] = 'relation edit successfully';

        return response()->json(['success' => $success], $this->successStatus);
    }


    public function delete_relation_type($id)
    {
        $relation = Relation::find($id);
        $relation->delete();
        $success['data'] = $relation;
        $success['status'] = 200;
        $success['message'] = 'relation deleted successfully';

        return response()->json(['success' => $success], $this->successStatus);
    }




    public function show_relation_type($id)
    {
        $relation = Relation::find($id);
        $success['data'] = $relation;
        $success['status'] = 200;
        $success['message'] = 'relation found successfully';

        return response()->json(['success' => $success], $this->successStatus);
    }




    public function relation_type()
    {
        $relation = Relation::all();
        $success['data'] = $relation;
        $success['status'] = 200;
        $success['message'] = 'relation found successfully';

        return response()->json(['success' => $success], $this->successStatus);
    }









    public function send_notify(Request $request, $id)
    {
        $request->validate([
            'message' => 'required',
        ]);
        $make = User::find($id);
        if ($make->notify_status === "Active") {
            $make->notify_count = $make->notify_count + 1;
            $make->save();
            $playerId = [$make->device_token];


            $subject = $request->message;
            $notificationTitle = 'Kaci';

            $content = array(
                "en" => $subject
            );

            $fields = array(
                'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                'include_player_ids' => $playerId,
                'ios_badgeType' => "Increase",
                'ios_badgeCount' =>  $make->notify_count,
                'contents' => $content,
                'headings' => array(
                    "en" => $notificationTitle
                )
            );

            $fields = json_encode($fields);


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8',
                'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

            $response = curl_exec($ch);
            curl_close($ch);
            $success['data'] = $response;
            $success['message'] = 'Notificaton send and store successfully';
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['data'] = 'Notificaton off by user';
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        }
    }
    
    
    public function send_notify_location(Request $request){
        
        $request->validate([
            'location' => 'required',
            'message' => 'required'
            ]);
            
        $users = User::where('location', '=', $request->location)->get();
        foreach($users as $u){
            
        if ($u->notify_status === "Active") {
            
            $u->notify_count = $u->notify_count + 1;
            $u->save();
            $playerId = [$u->device_token];

            $subject = $request->message;
            $notificationTitle = 'Kaci';

            $content = array(
                "en" => $subject
            );
            $fields = array(
                'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                'include_player_ids' => $playerId,
                'ios_badgeType' => "Increase",
                'ios_badgeCount' =>  $u->notify_count,
                'contents' => $content,
                'headings' => array(
                    "en" => $notificationTitle
                )
            );

            $fields = json_encode($fields);


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8',
                'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

            $response = curl_exec($ch);
            curl_close($ch);
            $success['data'] = $response;
            $success['message'] = 'Notificaton send and store successfully';
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        }
            
        }
            
    }





    public function send_bulk_notify(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'device_token.*' => 'required',
        ]);


        $deviceTokens = json_decode($request->device_token);

        $playerIds = [];

        foreach ($deviceTokens as $deviceToken) {
            $make = User::where('device_token', $deviceToken)->first();
            if ($make) {
                if ($make->status === 'Active') {
                    $make->notify_count = $make->notify_count + 1;
                    $make->save();
                    $playerIds[] = $deviceToken;
                    $userId = $make->user_id;
                    $name = $make->name;
                    $notificationTitle = 'Kaci';
                    $subject = $request->message;
                    $content = [
                        'en' => $subject,
                    ];

                    $fields = [
                        'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                        'include_player_ids' => $playerIds,

                        'ios_badgeType' => "Increase",
                        'ios_badgeCount' =>  $make->notify_count,

                        'contents' => $content,
                        'headings' => array(
                            "en" => $notificationTitle
                        )
                    ];

                    $fields = json_encode($fields);


                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/notifications');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json; charset=utf-8',
                        'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz',
                    ]);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    $response = curl_exec($ch);
                    curl_close($ch);
                    \Log::info('sent');
                }
            }
            // Use the user_id and name as needed



            // Rest of the code for sending the notification

        }

        $success['status'] = 200;

        $success['message'] = "Notificaton send Successfully";
        return response()->json(['success' => $success], $this->successStatus);
    }




    public function user_details($id)
    {
        $user = User::find($id);
        if ($user) {
            
            $user['total_reports'] = ReportItem::where('user_id', '=', $user->id)->count();
            $user['total_comments'] = BeepComment::where('user_id', '=', $user->id)->count();
            $user['total_beeps'] = Beep::where('user_id', '=', $user->id)->count();
            $user['total_consultation'] =Consult::where('user_id', '=', $user->id)->count();
            $user['Total_Travelsafe'] = Travel::where('user_id', '=', $user->id)->count();
            $user['Total_Ambulance'] = Ambulance::where('user_id', '=', $user->id)->count();
            $user['Total_Emergency'] = Sos::where('user_id', '=', $user->id)->count();
            $user['Total_IReport'] = Report::where('user_id', '=', $user->id)->count();
            $user['Total_Suggestion'] = Suggestion::where('user_id', '=', $user->id)->count();
            $user['Total_Feedback'] = Feedback::where('user_id', '=', $user->id)->count();
            $user['Dependant'] = Dependant::where('user_id', '=', $user->id)->get();
            $user['Medication'] = Medication::where('user_id', '=', $user->id)->get();
            $Kaci_Code = Used_Code::where('user_id', '=', $user->id)->get();
            $data = [];
            if ($Kaci_Code->count() > 0) {

                foreach ($Kaci_Code as $u) {
                    $amount = Kaci_Code::find($u->code_id);
                    $u['amount'] = $amount->amount??null;
                    $data[] = $u;
                }
            }
            $user['Kaci_Code'] = $data;
            if ($user->device_name === 'Android') {
                $new_id = 'AND' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                $user['new_id'] = $new_id;
                
            } elseif ($user->device_name === 'IOS') {
                $new_id = 'IOS' . str_pad($user->id, 7, '0', STR_PAD_LEFT);
                $user['new_id'] = $new_id;
            }
            $user['location_history'] = User_Location::where('user_id', '=', $user->id)->get();
            $user['Total_Climate'] = Climate::where('user_id', '=', $user->id)->count();
            $kg = Climate::where('user_id', '=', $user->id)->get();
            $total_emission = 0;
            foreach ($kg as $k) {
                $total_emission += $k->total;
            }
            $user['Total_Emission'] = $total_emission;
            
            $user['user_reports'] = ReportItem::where('user_id', '=', $id)->get();
            $success['data'] = $user;

            $success['status'] = 200;

            $success['message'] = "all user detail found";
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;

            $success['message'] = "Not found";
            return response()->json(['error' => $success]);
        }
    }



    public function response(Request $request, $id)
    {
        $request->validate([
            'response' => 'required',
            'type' => 'required',
            'admin_name' => 'required'
        ]);



        if ($request->hasfile('image')) {

            //             // $path = $input['profile_image']->storeAs('img', $profile_image, 'public');
            //     $store = Storage::put('profile_images', $profile_image);
            //             $path = Storage::disk('s3')->put('profile_images', $profile_image);
            //   $user->profile_image = $path;

            //This is to get the extension of the image file just uploaded
            $image = rand(00000, 5245421) . '.' . $request->file('image')->extension();
            $path = $request->file('image')->storeAs('response', $image, ['disk' => 's3']);
            $url = Storage::disk('s3')->url('response/' . $image);
            $response_Image = "https://kaci-storage.s3.amazonaws.com/" . $path;
        } else {
            $response_Image = null;
        }
        $response = $request->response;
        if ($request->type === 'ambulance') {
            $ambulance = Ambulance::find($id);

            $user = User::find($ambulance->user_id);

            $response = $request->response;
            if ($user) {
                $user->notify_count = $user->notify_count + 1;
                $user->save();
                //         if
                //         ($ambulance->response === null){
                //              $response=$request->response;
                //         $title='Ambulance Reply';
                //         Mail::to($user->email)->send(new ResponseMail($user, $response,$title, $response_Image));
                //         $ambulance->response =['response'=>$request->response,'image'=> $response_Image, 'response_date'=>Carbon::now()->toDateTimeString()];
                //         $ambulance->admin=$request->admin_name;
                //             $ambulance->save();
                //   $success['data']=$ambulance;
                // $success['status'] = 200;
                // $success['message']='Response Successfully send';

                // return response()->json(['success' => $success], $this->successStatus);
                //         }else
                //         {
                $responsedata = Response::create([
                    'user_id' => $user->id,
                    'type_id' => $ambulance->id,
                    'type' => $request->type,
                    'response' => $request->response,
                    'image' => $response_Image,
                    'admin_name' => $request->admin_name,
                    'status' => 'unseen'
                ]);
                $title = 'Reply to Ambulance Request' . ' ' . $ambulance->reference_code;
                Mail::to($user->email)->send(new ResponseMail($user, $response, $title, $response_Image));
                $ambulance->response = ['response' => $request->response, 'image' => $response_Image, 'response_date' => Carbon::now()->toDateTimeString()];

                $playerId = [$user->device_token];
                $subject = 'Ambulance: ' . $request->response;
                $notificationTitle = 'Kaci';
                $content = array(
                    "en" => $subject,
                );
                $fields = array(
                    'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                    'ios_badgeType' => "Increase",
                    'ios_badgeCount' =>  $user->notify_count,
                    'include_player_ids' =>   $playerId,
                    'data' => array("foo" => "NewMessage"),
                    'contents' => $content,
                    'headings' => array(
                        "en" => $notificationTitle
                    )
                );

                $fields = json_encode($fields);


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json; charset=utf-8',
                    'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($ch);
                curl_close($ch);
                $activity = Activity::where('type_id', '=', $ambulance->id)->where('type', '=', $request->type)->where('user_id', '=', $user->id)->first();
                if ($activity) {
                    $activity->updated_at = Carbon::now();
                    $activity->save();
                }
                $success['data'] = $ambulance;
                $success['image'] = $response_Image;
                $success['status'] = 200;
                $success['message'] = 'Response Successfully send';

                return response()->json(['success' => $success], $this->successStatus);
                // }

            }
        } else if ($request->type === 'emergency') {
            $ambulance = Sos::find($id);

            $user = User::find($ambulance->user_id);
            if ($user) {
                $user->notify_count = $user->notify_count + 1;
                $user->save();
                //      if($ambulance->response === null){
                //              $response=$request->response;
                //       $title='Emergency Reply';
                //         Mail::to($user->email)->send(new ResponseMail($user, $response,$title, $response_Image));
                //         $ambulance->response =['response'=>$request->response,'image'=> $response_Image, 'response_date'=>Carbon::now()->toDateTimeString()];
                //         $ambulance->admin=$request->admin_name;
                //             $ambulance->save();
                //   $success['data']=$ambulance;
                // $success['status'] = 200;
                // $success['message']='Response Successfully send';

                // return response()->json(['success' => $success], $this->successStatus);
                //         }else
                //         {
                $responsedata = Response::create([
                    'user_id' => $user->id,
                    'type_id' => $ambulance->id,
                    'type' => $request->type,
                    'response' => $request->response,
                    'image' => $response_Image,
                    'admin_name' => $request->admin_name,
                    'status' => 'unseen'
                ]);
                $title = 'Reply to Emergency SOS' . ' ' . $ambulance->reference_code;
                Mail::to($user->email)->send(new ResponseMail($user, $response, $title, $response_Image));
                $ambulance->response = ['response' => $request->response, 'image' => $response_Image, 'response_date' => Carbon::now()->toDateTimeString()];
                $playerId = [$user->device_token];
                $subject = 'Emergency: ' . $request->response;

                $content = array(
                    "en" => $subject,
                );
                $notificationTitle = 'Kaci';
                $fields = array(
                    'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                    'ios_badgeType' => "Increase",
                    'ios_badgeCount' =>  $user->notify_count,
                    'include_player_ids' =>   $playerId,
                    'data' => array("foo" => "NewMassage"),
                    'contents' => $content,
                    'headings' => array(
                        "en" => $notificationTitle
                    )
                );

                $fields = json_encode($fields);


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json; charset=utf-8',
                    'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($ch);
                curl_close($ch);
                $activity = Activity::where('type_id', '=', $ambulance->id)->where('type', '=', $request->type)->where('user_id', '=', $user->id)->first();
                if ($activity) {
                    $activity->updated_at = Carbon::now();
                    $activity->save();
                }
                $success['data'] = $ambulance;
                $success['status'] = 200;
                $success['message'] = 'Response Successfully send';

                return response()->json(['success' => $success], $this->successStatus);
                // }


                //         $response=$request->response;
                //         $title='Emergency Reply';
                //         Mail::to($user->email)->send(new ResponseMail($user, $response,$title, $response_Image));
                //          $ambulance->response =['response'=>$request->response,'image'=> $response_Image,'response_date'=>Carbon::now()->toDateTimeString()];
                //           $ambulance->admin=$request->admin_name;
                //             $ambulance->save();
                //   $success['data']=$ambulance;
                // $success['status'] = 200;
                // $success['message']='Response Successfully send';

                // return response()->json(['success' => $success], $this->successStatus);
            }
        } else if ($request->type === 'feedback') {
            $ambulance = Feedback::find($id);

            $user = User::find($ambulance->user_id);
            if ($user) {
                $user->notify_count = $user->notify_count + 1;
                $user->save();
                //          if($ambulance->response === null){
                //              $response=$request->response;
                //       $title='Feedback Reply';
                //         Mail::to($user->email)->send(new ResponseMail($user, $response,$title, $response_Image));
                //         $ambulance->response =['response'=>$request->response,'image'=> $response_Image, 'response_date'=>Carbon::now()->toDateTimeString()];
                //         $ambulance->admin=$request->admin_name;
                //             $ambulance->save();
                //   $success['data']=$ambulance;
                // $success['status'] = 200;
                // $success['message']='Response Successfully send';

                // return response()->json(['success' => $success], $this->successStatus);
                //         }else{
                $responsedata = Response::create([
                    'user_id' => $user->id,
                    'type_id' => $ambulance->id,
                    'type' => $request->type,
                    'response' => $request->response,
                    'image' => $response_Image,
                    'admin_name' => $request->admin_name,
                    'status' => 'unseen'
                ]);
                $title = 'Reply to Feedback Request' . ' ' . $ambulance->reference_code;
                Mail::to($user->email)->send(new ResponseMail($user, $response, $title, $response_Image));
                $ambulance->response = ['response' => $request->response, 'image' => $response_Image, 'response_date' => Carbon::now()->toDateTimeString()];
                $playerId = [$user->device_token];
                $subject = 'Feedback: ' . $request->response;
                $notificationTitle = 'Kaci';
                $content = array(
                    "en" => $subject,
                );
                $fields = array(
                    'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                    'ios_badgeType' => "Increase",
                    'ios_badgeCount' =>  $user->notify_count,
                    'include_player_ids' =>   $playerId,
                    'data' => array("foo" => "NewMassage"),
                    'contents' => $content,
                    'headings' => array(
                        "en" => $notificationTitle
                    )
                );

                $fields = json_encode($fields);


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json; charset=utf-8',
                    'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($ch);
                curl_close($ch);
                $activity = Activity::where('type_id', '=', $ambulance->id)->where('type', '=', $request->type)->where('user_id', '=', $user->id)->first();
                if ($activity) {
                    $activity->updated_at = Carbon::now();
                    $activity->save();
                }
                $success['data'] = $ambulance;
                $success['status'] = 200;
                $success['message'] = 'Response Successfully send';

                return response()->json(['success' => $success], $this->successStatus);
                // }


                //         $response=$request->response;
                //         $title='Feedback Reply';
                //         Mail::to($user->email)->send(new ResponseMail($user, $response,$title, $response_Image));
                //          $ambulance->response =['response'=>$request->response,'image'=> $response_Image,'response_date'=>Carbon::now()->toDateTimeString()];
                //           $ambulance->admin=$request->admin_name;
                //             $ambulance->save();
                //               $success['data']=$ambulance;
                // $success['status'] = 200;
                // $success['message']='Response Successfully send';

                // return response()->json(['success' => $success], $this->successStatus);

            }
        } else if ($request->type === 'report') {
            $ambulance = Report::find($id);

            $user = User::find($ambulance->user_id);
            if ($user) {
                $user->notify_count = $user->notify_count + 1;
                $user->save();
                //             if($ambulance->response === null){
                //              $response=$request->response;
                //         $title='IReport Reply';
                //         Mail::to($user->email)->send(new ResponseMail($user, $response,$title, $response_Image));
                //         $ambulance->response =['response'=>$request->response,'image'=> $response_Image, 'response_date'=>Carbon::now()->toDateTimeString()];
                //         $ambulance->admin=$request->admin_name;
                //             $ambulance->save();
                //   $success['data']=$ambulance;
                // $success['status'] = 200;
                // $success['message']='Response Successfully send';

                // return response()->json(['success' => $success], $this->successStatus);
                //         }else{
                $responsedata = Response::create([
                    'user_id' => $user->id,
                    'type_id' => $ambulance->id,
                    'type' => $request->type,
                    'response' => $request->response,
                    'image' => $response_Image,
                    'admin_name' => $request->admin_name,
                    'status' => 'unseen'
                ]);
                $title = 'Reply to Agency iReport ' . ' ' . $ambulance->reference_code;
                Mail::to($user->email)->send(new ResponseMail($user, $response, $title, $response_Image));
                $ambulance->response = ['response' => $request->response, 'image' => $response_Image, 'response_date' => Carbon::now()->toDateTimeString()];
                $playerId = [$user->device_token];
                $subject = 'iReport: ' . $request->response;
                $notificationTitle = 'Kaci';
                $content = array(
                    "en" => $subject,
                );
                $fields = array(
                    'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                    'ios_badgeType' => "Increase",
                    'ios_badgeCount' =>  $user->notify_count,
                    'include_player_ids' =>   $playerId,
                    'data' => array("foo" => "NewMassage"),
                    'contents' => $content,
                    'headings' => array(
                        "en" => $notificationTitle
                    )
                );

                $fields = json_encode($fields);


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json; charset=utf-8',
                    'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($ch);
                curl_close($ch);
                $activity = Activity::where('type_id', '=', $ambulance->id)->where('type', '=', $request->type)->where('user_id', '=', $user->id)->first();
                if ($activity) {
                    $activity->updated_at = Carbon::now();
                    $activity->save();
                }
                $success['data'] = $ambulance;
                $success['status'] = 200;
                $success['message'] = 'Response Successfully send';

                return response()->json(['success' => $success], $this->successStatus);
                // }



                //         $response=$request->response;
                //         $title='IReport Reply';
                //         Mail::to($user->email)->send(new ResponseMail($user, $response,$title, $response_Image));
                //          $ambulance->response =['response'=>$request->response,'image'=> $response_Image,'response_date'=>Carbon::now()->toDateTimeString()];
                //           $ambulance->admin=$request->admin_name;
                //             $ambulance->save();
                //               $success['data']=$ambulance;
                // $success['status'] = 200;
                // $success['message']='Response Successfully send';

                // return response()->json(['success' => $success], $this->successStatus);

            }
        } else if ($request->type === 'travel') {
            $ambulance = Travel::find($id);

            $user = User::find($ambulance->user_id);
            if ($user) {
                $user->notify_count = $user->notify_count + 1;
                $user->save();
                //             if($ambulance->response === null){
                //              $response=$request->response;
                //       $title='Travelsafe Reply';
                //         Mail::to($user->email)->send(new ResponseMail($user, $response,$title, $response_Image));
                //         $ambulance->response =['response'=>$request->response,'image'=> $response_Image, 'response_date'=>Carbon::now()->toDateTimeString()];
                //         $ambulance->admin=$request->admin_name;
                //             $ambulance->save();
                //   $success['data']=$ambulance;
                // $success['status'] = 200;
                // $success['message']='Response Successfully send';

                // return response()->json(['success' => $success], $this->successStatus);
                //         }else{
                $responsedata = Response::create([
                    'user_id' => $user->id,
                    'type_id' => $ambulance->id,
                    'type' => $request->type,
                    'response' => $request->response,
                    'image' => $response_Image,
                    'admin_name' => $request->admin_name,
                    'status' => 'unseen'
                ]);
                $title = 'Reply to TravelSafe SOS' . ' ' . $ambulance->reference_code;
                Mail::to($user->email)->send(new ResponseMail($user, $response, $title, $response_Image));
                $ambulance->response = ['response' => $request->response, 'image' => $response_Image, 'response_date' => Carbon::now()->toDateTimeString()];
                $playerId = [$user->device_token];
                $subject = 'TravelSafe: ' . $request->response;
                $notificationTitle = 'Kaci';
                $content = array(
                    "en" => $subject,
                );
                $fields = array(
                    'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                    'ios_badgeType' => "Increase",
                    'ios_badgeCount' =>  $user->notify_count,
                    'include_player_ids' =>   $playerId,
                    'data' => array("foo" => "NewMassage"),
                    'contents' => $content,
                    'headings' => array(
                        "en" => $notificationTitle
                    )
                );

                $fields = json_encode($fields);


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json; charset=utf-8',
                    'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($ch);
                curl_close($ch);
                $activity = Activity::where('type_id', '=', $ambulance->id)->where('type', '=', $request->type)->where('user_id', '=', $user->id)->first();
                if ($activity) {
                    $activity->updated_at = Carbon::now();
                    $activity->save();
                }
                $success['data'] = $ambulance;
                $success['status'] = 200;
                $success['message'] = 'Response Successfully send';

                return response()->json(['success' => $success], $this->successStatus);
                // }
                //         $response=$request->response;
                //         $title='Travelsafe Reply';
                //         Mail::to($user->email)->send(new ResponseMail($user, $response,$title, $response_Image));

                //              $ambulance->response =['response'=>$request->response,'image'=> $response_Image,'response_date'=>Carbon::now()->toDateTimeString()];
                //               $ambulance->admin=$request->admin_name;
                //             $ambulance->save();
                //               $success['data']=$ambulance;
                // $success['status'] = 200;
                // $success['message']='Response Successfully send';

                // return response()->json(['success' => $success], $this->successStatus);


            }
        } else if ($request->type === 'suggestion') {
            $ambulance = Suggestion::find($id);

            $user = User::find($ambulance->user_id);
            if ($user) {
                $user->notify_count = $user->notify_count + 1;
                $user->save();
                //             if($ambulance->response === null){
                //              $response=$request->response;
                //       $title='Suggestion Reply';
                //         Mail::to($user->email)->send(new ResponseMail($user, $response,$title, $response_Image));
                //         $ambulance->response =['response'=>$request->response,'image'=> $response_Image, 'response_date'=>Carbon::now()->toDateTimeString()];
                //         $ambulance->admin=$request->admin_name;
                //             $ambulance->save();
                //   $success['data']=$ambulance;
                // $success['status'] = 200;
                // $success['message']='Response Successfully send';

                // return response()->json(['success' => $success], $this->successStatus);
                //         }else{
                $responsedata = Response::create([
                    'user_id' => $user->id,
                    'type_id' => $ambulance->id,
                    'type' => $request->type,
                    'response' => $request->response,
                    'image' => $response_Image,
                    'admin_name' => $request->admin_name,
                    'status' => 'unseen'
                ]);
                $title = 'Reply to Agency Suggestion ' . ' ' . $ambulance->reference_code;
                Mail::to($user->email)->send(new ResponseMail($user, $response, $title, $response_Image));
                $ambulance->response = ['response' => $request->response, 'image' => $response_Image, 'response_date' => Carbon::now()->toDateTimeString()];
                $playerId = [$user->device_token];
                $subject = 'Suggestion: ' . $request->response;
                $notificationTitle = 'Kaci';
                $content = array(
                    "en" => $subject,
                );
                $fields = array(
                    'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",
                    'ios_badgeType' => "Increase",
                    'ios_badgeCount' =>  $user->notify_count,
                    'include_player_ids' =>   $playerId,
                    'data' => array("foo" => "NewMassage"),
                    'contents' => $content,
                    'headings' => array(
                        "en" => $notificationTitle
                    )
                );

                $fields = json_encode($fields);


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json; charset=utf-8',
                    'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($ch);
                curl_close($ch);
                $activity = Activity::where('type_id', '=', $ambulance->id)->where('type', '=', $request->type)->where('user_id', '=', $user->id)->first();

                if ($activity) {
                    $activity->updated_at = Carbon::now();
                    $activity->save();
                }

                $success['data'] = $ambulance;
                $success['status'] = 200;
                $success['message'] = 'Response Successfully send';

                return response()->json(['success' => $success], $this->successStatus);
                // }

                //         $response=$request->response;
                //         $title='Suggestion Reply';
                //         Mail::to($user->email)->send(new ResponseMail($user, $response,$title, $response_Image));
                //         $ambulance->response =['response'=>$request->response,'image'=> $response_Image,'response_date'=>Carbon::now()->toDateTimeString()];
                //           $ambulance->admin=$request->admin_name;
                //             $ambulance->save();
                //             $success['data']=$ambulance;
                // $success['status'] = 200;
                // $success['message']='Response Successfully send';

                // return response()->json(['success' => $success], $this->successStatus);
            }
        }
    }
    public function dashboard()
    {
        $data = [];
        $data['Total_Users'] = User::all()->count();
        $data['Verified_Users'] = User::where('ksn', '!=', null)->count();
        $data['General_Countries'] = General_Countries::all()->count();
        $data['Resident_Countries'] = Country::all()->count();
        $data['Agencies'] = Agencies::all()->count();
        $data['Ambulances'] = Ambulance::all()->count();
        $data['Climate_Counts'] = Climate::all()->count();
        $kg = Climate::all();
        $tota_kg = 0;
        foreach ($kg as $k) {
            $tota_kg += $k->total;
        }
        $data['Total_Emissions(KG)'] = $tota_kg;
        $data['Emergencies'] = Sos::all()->count();

        $data['TravelSafe'] = Travel::all()->count();

        $data['Suggestions'] = Suggestion::all()->count();
        $data['Feedbacks'] = Feedback::all()->count();
        $data['iReports'] = Report::all()->count();

        $data['Kaci_Code'] = Kaci_Code::all()->count();
        $data['Beeps'] = Beep::all()->count();
        $data['Consultations'] = Consult::all()->count();
        $data['Comments'] = BeepComment::all()->count();
        $data['Reports'] = ReportItem::all()->count();


        $success['data'] = $data;
        $success['status'] = 200;
        $success['message'] = 'All details';

        return response()->json(['success' => $success], $this->successStatus);
    }


    public function date_wise_dashboard(Request $request)
    {

        if ($request->type === 'Today') {

            $today = date('Y-m-d');


            $data = [];

            $data['Users'] = User::whereDate('created_at', '=', $today)->count();
            $data['Emergencies'] = Sos::whereDate('created_at', '=', $today)->count();
            $data['Suggestions'] = Suggestion::whereDate('created_at', '=', $today)->count();
            $data['iReports'] = Report::whereDate('created_at', '=', $today)->count();
            $data['Consultations'] = Consult::whereDate('created_at', '=', $today)->count();
            $data['Ambulances'] = Ambulance::whereDate('created_at', '=', $today)->count();
            $data['TravelSafe'] = Travel::whereDate('created_at', '=', $today)->count();
            $data['Feedbacks'] = Feedback::whereDate('created_at', '=', $today)->count();
            $data['Beeps'] = Beep::whereDate('created_at', '=', $today)->count();
            $data['Comments'] = BeepComment::whereDate('created_at', '=', $today)->count();
            $data['Climate_Counts'] = Climate::whereDate('created_at', '=', $today)->count();
            $data['Reports'] = ReportItem::whereDate('created_at', '=', $today)->count();
        } else if ($request->type == 'Week') {

            $startOfWeek = now()->startOfWeek();
            $endOfWeek = now()->endOfWeek();


            $data['Users'] = User::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
            $data['Emergencies'] = Sos::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
            $data['Suggestions'] = Suggestion::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
            $data['iReports'] = Report::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
            $data['Consultations'] = Consult::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
            $data['Ambulances'] = Ambulance::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
            $data['TravelSafe'] = Travel::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
            $data['Feedbacks'] = Feedback::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
            $data['Beeps'] = Beep::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
            $data['Comments'] = BeepComment::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
            $data['Climate_Counts'] = Climate::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
            $data['Reports'] = ReportItem::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        } else {

            $startOfMonth = now()->startOfMonth();
            $endOfMonth = now()->endOfMonth();

            $data['Users'] = User::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $data['Emergencies'] = Sos::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $data['Suggestions'] = Suggestion::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $data['iReports'] = Report::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $data['Consultations'] = Consult::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $data['Ambulances'] = Ambulance::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $data['TravelSafe'] = Travel::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $data['Feedbacks'] = Feedback::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $data['Beeps'] = Beep::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $data['Comments'] = BeepComment::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $data['Climate_Counts'] = Climate::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $data['Reports'] = ReportItem::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        }



        $success['data'] = $data;
        $success['status'] = 200;
        $success['message'] = 'All details';

        return response()->json(['success' => $success], $this->successStatus);
    }








    public function show_admin_notification($id)
    {
        $notification = Admin_Notification::where('status', '=', 'Unread')->where('sub_admin_id', '=', $id)->get();
        $success['data'] = $notification;
        $success['status'] = 200;
        $success['message'] = 'All Notifications';

        return response()->json(['success' => $success], $this->successStatus);
    }


    public function show_Admin_count($id)
    {
        $notification = Admin_Notification::where('status', '=', 'Unread')->where('sub_admin_id', '=', $id)->count();
        $success['data'] = $notification;
        $success['status'] = 200;
        $success['message'] = 'All Notifications';

        return response()->json(['success' => $success], $this->successStatus);
    }


    public function read_admin_notification($id)
    {
        $notification = Admin_Notification::find($id);
        if ($notification) {
            $notification->status = 'Read';
            $notification->save();
            $success['status'] = 200;
            $success['message'] = 'All Notifications';

            return response()->json(['success' => $success], $this->successStatus);
        }
    }
    public function read_all($id)
    {
        $notification = Admin_Notification::where('status', '=', 'Unread')->where('sub_admin_id', '=', $id)->get();
        foreach ($notification as $n) {
            $n->status = "Read";
            $n->save();
        }
        $success['status'] = 200;
        $success['message'] = 'All Notifications';

        return response()->json(['success' => $success], $this->successStatus);
    }


    public function popup_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'platform' => 'required',
            'title' => 'required',
            'tag' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
            'country' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $input = $request->all();
        if ($request->app_page) {
            $input['app_page'] = $request->app_page;
        }

        $image = time() . '.' . $request->file('image')->extension();
        $path = $request->file('image')->storeAs('popup', $image, ['disk' => 's3']);
        $url = Storage::disk('s3')->url('popup/' . $image);
        $input['image'] = "https://kaci-storage.s3.amazonaws.com/" . $path;
        $popup1 = Popup::create($input);

        $success['popup'] = $popup1;
        $success['status'] = 200;
        $success['message'] = "New Pop-up created";


        return response()->json(['success' => $success], $this->successStatus);
    }
    public function popup_edit(Request $request, $id)
    {
        $popup = Popup::find($id);
        // $validator = Validator::make($request->all(), [
        //     'image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()]);

        // }
        $input = $request->all();
        if ($request->hasFile('image')) {
            $image = time() . '.' . $request->file('image')->extension();
            $path = $request->file('image')->storeAs('popup', $image, ['disk' => 's3']);
            $url = Storage::disk('s3')->url('popup/' . $image);
            $popup->image = "https://kaci-storage.s3.amazonaws.com/" . $path;
        } elseif ($request->filled('image')) {
            $popup->image = $request->image;
        }
        if ($request->title) {
            $popup->title = $request->title;
        }
        if ($request->platform) {
            $popup->platform = $request->platform;
        }
        if ($request->status) {
            $popup->status = $request->status;
        }
        if ($request->tag) {
            $popup->tag = $request->tag;
        }
        if ($request->app_page) {
            $popup->app_page = $request->app_page;
        }
        if ($request->country) {
            $popup->country = $request->country;
        }

        $popup->save();

        $success['popup'] = $popup;
        $success['status'] = 200;
        $success['message'] = "Pop-up Edit Successfully";


        return response()->json(['success' => $success], $this->successStatus);
    }
    public function popup_delete($id)
    {
        $popup = Popup::find($id);
        if ($popup) {
            $popup->delete();
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





    public function dashboard_country(Request $request)
    {
        $request->validate(['country' => 'required']);

        $data = [];
        $data['Total_Users'] = User::where('country', '=', $request->country)->count();
        $data['Verified_Users'] = User::where('ksn', '!=', null)->where('country', '=', $request->country)->count();

        $data['General_Countries'] = General_Countries::all()->count();
        $data['Resident_Countries'] = Country::all()->count();
        $data['Agencies'] = Agencies::where('country', '=', $request->country)->count();
        $data['Ambulances'] = Ambulance::where('country', '=', $request->country)->count();
        $data['Climate_Counts'] = Climate::where('resident_country', '=', $request->country)->count();
        $kg = Climate::where('resident_country', '=', $request->country)->get();
        $tota_kg = 0;
        foreach ($kg as $k) {
            $tota_kg += $k->total;
        }
        $data['Total_Emissions(KG)'] = $tota_kg;
        $data['Emergencies'] = Sos::where('country', '=', $request->country)->count();

        $data['TravelSafe'] = Travel::where('country', '=', $request->country)->count();

        $data['Suggestions'] = Suggestion::where('country', '=', $request->country)->count();
        $data['Feedbacks'] = Feedback::where('country', '=', $request->country)->count();
        $data['iReports'] = Report::where('country', '=', $request->country)->count();
        $data['Kaci_Code'] = Kaci_Code::all()->count();
        
    
        $data['Beeps'] = Beep::where('country', '=', $request->country)->count();
        $data['Consultations'] = Consult::where('country', '=', $request->country)->count();
        
        $countryBeeps = Beep::where('country', '=', $request->country)->get();
        $allCountrywise = 0;
        foreach($countryBeeps as $b){
            $allCountrywise += $b->comment;
        
        
        }
        $data['Comments'] = $allCountrywise;
        $data['Reports'] = ReportItem::where('country', '=', $request->country)->where('status', '=', true)->count();



            
        // $reports = ReportItem::where('status', '=', true)->get();
        // foreach($reports as $r){
        //   if($r->type == 'Beep'){
        //       $bee = Beep::where('id', $r->item_id)->where('country', '=', $request->country)->get();
              
        //       $data['Reports'] = $bee->count();
              
        //   }else if($r->type ==  'Comment'){
        //             $countryBeeps = Beep::where('country', '=', $request->country)->get();
                    
        //             $allCountrywise = 0;
        //       foreach($countryBeeps as $b){
        //             $allCountrywise += $b->comment;
        //         $data['comments_reports'] = $allCountrywise;
        
        
        // }
        //   }
        // }
        
        
        $success['data'] = $data;
        $success['status'] = 200;
        $success['message'] = 'All details';

        return response()->json(['success' => $success], $this->successStatus);
    }
    public function create_faq(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'answer' => 'required',
            'language' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $input = $request->all();
        $faq = Faq::create($input);
        $success['data'] = $faq;
        $success['status'] = 200;
        $success['message'] = "New FAQ created";


        return response()->json(['success' => $success], $this->successStatus);
    }
    
    
    public function edit_faq(Request $request, $id)
    {
        $faq = Faq::find($id);
        if ($faq) {
            if ($request->question) {
                $faq->question = $request->question;
            }
            if ($request->answer) {
                $faq->answer = $request->answer;
            }
            if ($request->language) {
                $faq->language = $request->language;
            }
            $faq->save();
            $success['data'] = $faq;
            $success['status'] = 200;
            $success['message'] = "Faq Edited ";


            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = "Faq not found";


            return response()->json(['error' => $success]);
        }
    }
    public function delete_faq($id)
    {
        $faq = Faq::find($id);
        if ($faq) {
            $faq->delete();
            $success['data'] = $faq;
            $success['status'] = 200;
            $success['message'] = "faq " . $faq->id . " delete successfully";


            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = "faq not found";


            return response()->json(['error' => $success]);
        }
    }

    public function admin_login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $admin = Sub_Admin::where('email', '=', $request->email)->where('password', '=', $request->password)->first();
        if ($admin) {
            $success['data'] = $admin;
            $success['status'] = 200;
            $success['message'] = "Login Successfull";


            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = "Credential Invalid";


            return response()->json(['error' => $success]);
        }
    }


    public function admin_forgot(Request $request)
    {
        $request->validate(['email' => 'required']);
        $sub = Sub_Admin::where('email', '=', $request->email)->first();
        if ($sub) {
            $token = rand(0000, 9999);
            Mail::to($sub->email)->send(new AdminForgotMail($sub, $token));
            $success['OTP'] = $token;
            $success['data'] = $sub;
            $success['message'] = "Reset Password OTP send to your email";
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = "Email not Exist";


            return response()->json(['error' => $success]);
        }
    }
    public function admin_reset_password(Request $request, $id)
    {
        $request->validate(['password' => 'required|confirmed']);
        $sub = Sub_Admin::find($id);
        if ($sub) {
            $sub->password = $request->password;
            $sub->save();
            Mail::to($sub->email)->send(new AdminPasswordMail($sub));
            $success['data'] = $sub;
            $success['message'] = "Password Changed";
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = "Admin not Exist";


            return response()->json(['error' => $success]);
        }
    }

    public function edit_user_details(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            if ($request->firstname) {
                $user->firstname = $request->firstname;
            }
            if ($request->lastname) {
                $user->lastname = $request->lastname;
            }
            if ($request->email) {
                $user->email = $request->email;
            }
            if ($request->phone_number) {
                $user->phone_number = $request->phone_number;
            }
            if ($request->resident_country) {
                $user->resident_country = $request->resident_country;
            }

            if ($request->ksn) {
                $user->ksn = $request->ksn;
            }
            if ($request->country) {
                $user->country = $request->country;
            }
            $user->save();

            if ($request->dependent) {
                $data = $request->dependent;

                foreach ($data as $d) {

                    $dependent = Dependant::where('id', '=', $d['id'])->first();
                    if ($dependent) {

                        if ($d['name']) {
                            $dependent->name = $d['name'];
                        }

                        if ($d['email']) {
                            $dependent->email = $d['email'];
                        }
                        if ($d['phone_number']) {
                            $dependent->phone_number = $d['phone_number'];
                        }

                        if ($d['country']) {
                            $dependent->country = $d['country'];
                        }
                        if ($d['relation_type']) {
                            $dependent->relation_type = $d['relation_type'];
                        }



                        $dependent->save();
                    }
                }
                //      $dependent=Dependant::where('user_id','=',$user->id)->get();
                // if($dependent->count()>0){
                //     foreach($dependent as $d){
                //         if($request->d_name){
                //              $d->name=$request->d_name;
                //         }
                //       if($request->d_email){
                //             $d->email=$request->d_email;
                //       }
                //       if($request->d_phone_number){
                //             $d->phone_number=$request->d_phone_number;
                //       }
                //       if($request->country){
                //              $d->country=$request->country;
                //       }
                //       if($request->relation_type){
                //           $d->relation_type=$request->relation_type;
                //       }

                //         $d->save();
                //     }
                // }
            }

            if ($request->medication) {
                $data = $request->medication;

                foreach ($data as $d) {
                    $dependent = Medication::where('id', '=', $d['id'])->first();
                    if ($dependent) {
                        if ($d['name']) {
                            $dependent->name = $d['name'];
                        }
                        if ($d['description']) {
                            $dependent->description = $d['description'];
                        }
                        if ($d['dosage']) {
                            $dependent->dosage = $d['dosage'];
                        }




                        $dependent->save();
                    }
                }
            }
            if ($request->kaci_code) {
                $data = $request->kaci_code;

                foreach ($data as $d) {
                    $dependent = Used_Code::where('id', '=', $d['id'])->first();
                    if ($dependent) {
                        if ($d['code']) {
                            $dependent->code = $d['code'];
                        }
                        if ($d['expiry_date']) {
                            $dependent->expiry_date = $d['expiry_date'];
                        }
                        if ($d['created_at']) {
                            $dependent->created_at = $d['created_at'];
                        }
                        if ($d['amount']) {
                            $dependent->amount = $d['amount'];
                        }




                        $dependent->save();
                    }
                }
            }

            if ($request->location_history) {
                $data = $request->location_history;

                foreach ($data as $d) {
                    $dependent = User_Location::where('id', '=', $d['id'])->first();
                    if ($dependent) {
                        if ($d['coordinate']) {
                            $dependent->coordinate = $d['coordinate'];
                        }
                        if ($d['created_at']) {
                            $dependent->created_at = $d['created_at'];
                        }

                        $dependent->save();
                    }
                }
            }
            // $medication=Medication::where('user_id','=',$user->id)->get();
            // if($medication->count()>0){
            //     foreach($medication as $m){

            //         $m->save();
            //     }
            // }

            $success['data'] = $user;
            $success['message'] = "User Details Edited";
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = "User not Exist";


            return response()->json(['error' => $success]);
        }
    }

    public function history_location($id)
    {
        $location = User_Location::find($id);
        if ($location) {
            $location->delete();
            $success['data'] = $location;
            $success['message'] = "User Details Edited";
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = "Location not Exist";


            return response()->json(['error' => $success]);
        }
    }
    public function kaci_code_user_delete($id, $user_id)
    {
        $kaci_code = Used_Code::where('user_id', '=', $user_id)->where('code_id', '=', $id)->get();
        if ($kaci_code->count() > 0) {
            foreach ($kaci_code as $k) {
                $k->delete();
            }
            $success['message'] = "User Code Deleted";
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = "Code not Exist";


            return response()->json(['error' => $success]);
        }
    }

    public function auto_reply_get(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'language' => 'required',
        ]);
        $auto_reply = Auto_Reply::where('type', '=', $request->type)->where('language', '=', $request->language)->first();
        if ($auto_reply) {
            $success['data'] = $auto_reply;
            $success['message'] = "Found Successfully";
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $auto_reply = Auto_Reply::where('type', '=', 'travelsafe')->where('language', '=', 'English')->first();
            $success['data'] = $auto_reply;
            $success['message'] = "Not Found Successfully";
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        }
    }

    public function auto_reply_edit(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'language' => 'required',
            'description' => 'required',
        ]);
        $auto_reply = Auto_Reply::where('type', '=', $request->type)->where('language', '=', $request->language)->first();
        if ($auto_reply) {
            $auto_reply->description = $request->description;
            $auto_reply->save();
            $success['data'] = $auto_reply;
            $success['message'] = "Found Successfully";
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $auto_reply = Auto_Reply::where('type', '=', 'travelsafe')->where('language', '=', 'English')->first();
            $success['data'] = $auto_reply;
            $success['message'] = "Not Found Successfully";
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        }
    }
    public function auto_reply_status(Request $request)
    {
        $request->validate([
            'type' => 'required',
        ]);
        $auto_reply = Auto_Reply::where('type', '=', $request->type)->get();
        $data = [];
        if ($auto_reply->count() > 0) {
            foreach ($auto_reply as $a) {
                if ($a->status === 'Activated') {
                    $a->status = 'Deactivated';
                    $a->save();
                    $data[] = $a;
                } elseif ($a->status === 'Deactivated') {
                    $a->status = 'Activated';
                    $a->save();
                    $data[] = $a;
                }
            }
            $success['data'] = $data;
            $success['message'] = "Found Successfully";
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message'] = "Not Exist";


            return response()->json(['error' => $success]);
        }
    }


    public function bulk_response(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'response' => 'required',
            'ids.*' => 'required',
            'type' => 'required',
            'admin_name' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }


        if ($request->hasfile('image')) {

            //             // $path = $input['profile_image']->storeAs('img', $profile_image, 'public');
            //     $store = Storage::put('profile_images', $profile_image);
            //             $path = Storage::disk('s3')->put('profile_images', $profile_image);
            //   $user->profile_image = "https://storage.kacihelp.com/".$path;

            //This is to get the extension of the image file just uploaded
            $image = rand(00000, 5245421) . '.' . $request->file('image')->extension();
            $path = $request->file('image')->storeAs('response', $image, ['disk' => 's3']);
            $url = Storage::disk('s3')->url('response/' . $image);
            $response_Image = "https://kaci-storage.s3.amazonaws.com/" . $path;
        } else {
            $response_Image = null;
        }
        $input = $request->all();
        $ids = $input['ids'];
        $response = $input['response'];
        $title = $input['type'] . ' ' . 'Response';
        $data = [];
        foreach ($ids as $i) {

            $user = User::find($i['user_id']);
            if ($user) {
                $activity = Activity::where('type_id', '=', $i['id'])->where('type', '=', $input['type'])->where('user_id', '=', $user->id)->first();
                if ($activity) {
                    $activity->updated_at = Carbon::now();
                    $activity->save();
                }
                $save_reply = Response::create(
                    [
                        'user_id' => $user->id,
                        'type_id' => $i['id'],
                        'type' => $input['type'],
                        'image' => $response_Image,
                        'response' => $response,
                        'admin_name' => $input['admin_name'],
                        'status' => 'unseen'
                    ]
                );
                $i['save_reply'] = $save_reply;

                $playerId = [$user->device_token];
                $subject = $input['type'] . ': ' . $response;
                $notificationTitle = 'Kaci';
                $content = array(
                    "en" => $subject,
                );
                $fields = array(
                    'app_id' => "a548e8e7-f1d6-44f5-8863-bb4d1edaf004",

                    'include_player_ids' =>   $playerId,
                    'data' => array("foo" => "NewMassage"),
                    'contents' => $content,
                    'headings' => array(
                        "en" => $notificationTitle
                    )
                );

                $fields = json_encode($fields);


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json; charset=utf-8',
                    'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($ch);
                curl_close($ch);
            }

            $data[] = $i;
        }

        $success['data'] = $data;
        $success['message'] = "Reply sent Successfully";
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function edit_response(Request $request, $id)
    {
        $response = Response::find($id);
        if ($response) {
            if ($request->response) {
                $response->response = $request->response;
            }
            if ($request->admin_name) {
                $response->admin_name = $request->admin_name;
            }
            $response->save();
            $success['data'] =  $response;
            $success['message'] = "Response Edit Successfully";
            $success['status'] = 200;
            return response()->json(['success' => $success], $this->successStatus);
        }
    }


    public function ambulance_agency_location(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'resident_country' => 'required',
            'location' => 'required',
        ]);


        if ($request->type === 'ambulance') {
            $ambulance = Ambulance_Service::where('country', '=', $request->resident_country)->where('status', '=', 'Active')->get();
            $data = [];
            if ($ambulance->count() > 0) {
                foreach ($ambulance as $a) {
                    $location = json_decode($a->location);
                    foreach ($location as $l) {
                        if ($l->location === $request->location) {
                            $data[] = $a;
                        }
                    }
                }
                $success['data'] = $data;
                $success['message'] = "Service found Successfully";
                $success['status'] = 200;
                return response()->json(['success' => $success], $this->successStatus);
            }
        } else if ($request->type === 'agency') {
            $ambulance = Agencies::where('country', '=', $request->resident_country)->where('modules', 'LIKE', '%' . $request->modules . '%')->where('status', '=', 'Active')->get();
            $data = [];

            if ($ambulance->count() > 0) {

                foreach ($ambulance as $a) {
                    $location = json_decode($a->location);
                    foreach ($location as $l) {
                        if ($l->location === $request->location) {
                            $data[] = $a;
                        }
                    }
                }
                $success['data'] = $data;
                $success['message'] = "Service found Successfully";
                $success['status'] = 200;
                return response()->json(['success' => $success], $this->successStatus);
            }
        }
    }


// public function live_chat(Request $request, $id)
// {
//     $request->validate([
//         "module" => "required",
//         "module_id" => "required",
//         "reference_code" => "required",
//         "sender_type" => "required",
//     ]);

//     if ($request->sender_type == 'User') {
//         $user = User::find($id);
//         $input['user_id'] = $user->id;
//         $input['sender_type'] = $request->sender_type;
//         $input['user_name'] = $user->firstname . ' ' . $user->lastname;
//         $input['user_profile'] = $user->profile_image;
//     } else if ($request->sender_type == 'Admin') {
//         $user = Sub_Admin::find($id);
//         $input['user_id'] = $user->id;
//         $input['sender_type'] = $request->sender_type;
//         $input['user_name'] = $user->name;
//         $input['user_profile'] = $user->profile_image;
//     } else if ($request->sender_type == 'Agency') {
//         $user = Agencies::find($id);
//         $input['user_id'] = $user->id;
//         $input['sender_type'] = $request->sender_type;
//         $input['user_name'] = $user->title;
//         $input['user_profile'] = $user->logo;
//     }


//     $input['text'] = $request->text ?? null;
//     $input['message_type'] = $request->text ? 'text' : null;
//     $input['audio'] = null;
//     $input['media'] = null;
//     $input['time'] = Carbon::now();
//     $input['id'] = uniqid();

//     if ($request->reply_text) {
        
//         $replyMessage = Group_Chat::where('module', $request->module)
//             ->where('module_id', $request->module_id)
//             ->where('reference_code', $request->reference_code)
//             ->first();

//         if ($replyMessage) {
//             $messages = json_decode($replyMessage->message);

//             foreach ($messages as &$message) {
//                 $decodedMessage = $message;

//                 if ($decodedMessage->id === $request->reply_message_id) {

//                     if (!isset($decodedMessage->reply)) {
                        
//                           $messageType = 'text';
//                 if ($request->media) {
//                     $messageType = 'media';
//                 } elseif ($request->audio) {
//                     $messageType = 'audio';
//                 }
                        
//                         $decodedMessage->reply = [
//                             'reply_text' => $request->reply_text,
//                             'message_type' =>  $messageType,
//                             'time' => Carbon::now(),
//                             'user_id' => $user->id,
//                             'sender_type' => $request->sender_type,
//                             'user_name' => $user->firstname . ' ' . $user->lastname,
//                             'user_profile' => $user->profile_image,
//                             'media' => $request->media ? $request->media:null,
//                             'audio' => $request->audio ? $request->audio : null
//                         ];
//                     }
//                     break;
//                 }
//             }

//             $replyMessage->message = json_encode($messages);
//             $replyMessage->save();
            
            
//             $success['status'] = 200;
//             $success['message'] = 'reply stored successfully';
            
//             return response()->json(['success' => $success]);
//         } 
//     }


//     $check_chats = Group_Chat::where('module', $request->module)
//         ->where('module_id', $request->module_id)
//         ->where('reference_code', $request->reference_code)
//         ->first();

//     if ($check_chats) {

//         $messages = json_decode($check_chats->message, true);
//         $messages[] = $input;
//         $check_chats->message = json_encode($messages);
//         $check_chats->save();

//         $success['data'] = $check_chats;
//         $success['message'] = 'Chats Added Successfully';
//         $success['status'] = 200;
//         return response()->json(['success' => $success], $this->successStatus);
        
//     } else {

//         $create_chats = Group_Chat::create([
//             'module' => $request->module,
//             'module_id' => $request->module_id,
//             'reference_code' => $request->reference_code,
//             'target_agency' => $request->target_agency,
//             'message' => json_encode([$input]), 
//         ]);

//         $success['data'] = $create_chats;
//         $success['message'] = 'Chat Created Successfully';
//         $success['status'] = 200;
//         return response()->json(['success' => $success], $this->successStatus);
//     }
// }




public function live_chat(Request $request, $id)
{
    $request->validate([
        "module" => "required",
        "module_id" => "required",
        "reference_code" => "required",
        "sender_type" => "required",
    ]);

    $user = null;
    $input = [
        'text' => $request->text ?? null,
        'audio' => null,
        'media' => null,
        'time' => Carbon::now(),
        'reply_to' => $request->reply_message_id ?? null,
        'read_by' => [],
    ];

    // Determine user details based on sender type
    switch ($request->sender_type) {
        case 'User':
            $user = User::find($id);
            $input['user_id'] = $user->id;
            $input['sender_type'] = $request->sender_type;
            $input['user_name'] = $user->firstname . ' ' . $user->lastname;
            $input['user_email'] = $user->email;
            $input['user_profile'] = $user->profile_image;
            break;
        case 'Admin':
            $user = Sub_Admin::find($id);
            $input['user_id'] = $user->id;
            $input['sender_type'] = $request->sender_type;
            $input['user_name'] = $user->name;
            $input['user_email'] = $user->email;
            $input['user_profile'] = $user->profile_image;
            break;
        case 'Agency':
        
            
            // if($request->target_agency){
                $sub_account = Sub_Account::find($id);

                $input['user_id'] = $sub_account->id;
                $input['sender_type'] = $request->sender_type;
                $input['user_name'] = $sub_account->name;
                $input['user_email'] = $sub_account->email;
                $input['user_profile'] = $sub_account->profile_image;
            // } else {
            
            // $user = Agencies::where('title', '=', $request->target_agency)->first();
            // $input['user_id'] = $user->id;
            // $input['sender_type'] = $request->sender_type;
            // $input['user_name'] = $user->title;
            // $input['user_email'] = $user->head_email1 ?? null;
            // $input['user_profile'] = $user->logo;
            // }
            break;
        default:
            return response()->json(['error' => 'Invalid sender type'], 400);
    }

    // Handle media files
    if ($request->hasFile('media')) {
        $uploadedFiles = [];
        foreach ($request->file('media') as $file) {
            $uploadedFile = new \stdClass();
            $extension = $file->extension();
            $originalName = $file->getClientOriginalName();
            $voice_message = $request->voice_message ?? false;

            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'])) {
                $uploadedFile->type = 'image';
            } elseif (in_array($extension,  ['mp4', 'ogg', 'avi', 'mov', 'mkv'])) {
                $uploadedFile->type = 'video';
            } elseif (in_array($extension,  ['mp3', 'wav', 'ogg', 'flac', 'aac', 'm4a', 'webm'])) {
                $uploadedFile->type = 'audio';
                if ($voice_message) {
                    $uploadedFile->voice_message = true;
                }
            } elseif (in_array($extension,  ['ppt', 'pptx'])) {
                $uploadedFile->type = 'ppt';
            } elseif (in_array($extension,  ['doc', 'docx'])) {
                $uploadedFile->type = 'docx';
            } elseif (in_array($extension, ['pdf'])) {
                $uploadedFile->type = 'pdf';
            } else {
                $uploadedFile->type = 'unknown';
            }

            $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
            $path = $file->storeAs('chat-media', $uploadedImage, ['disk' => 's3']);
            $uploadedFile->url = "https://kaci-storage.s3.amazonaws.com/" . $path;
            $uploadedFile->name = $originalName;
            $uploadedFiles[] = $uploadedFile;
        }
        $input['media'] = $uploadedFiles;
        $input['message_type'] = 'media';
    } else {
        $input['message_type'] = $request->text ? 'text' : 'unknown';
    }

    // Retrieve or initialize chat
    $check_chats = Group_Chat::where('module', $request->module)
        ->where('module_id', $request->module_id)
        ->where('reference_code', $request->reference_code)
        ->first();

    if ($check_chats) {
        $messages = json_decode($check_chats->message, true);

        // Assign new ID
        $input['id'] = end($messages)['id'] + 1;

        // If replying, find the reply target message
        if ($input['reply_to']) {
            $reply_message = $this->findMessageById($messages, $input['reply_to']);
            if (is_array($reply_message)) {
     
                $input['reply_to'] = [
                    'id' => $reply_message['id'],
                    'text' => $reply_message['text'],
                    'user_id' => $reply_message['user_id'],
                    'sender_type' => $reply_message['sender_type'],
                    'user_name' => $reply_message['user_name'],
                    'user_email' => $reply_message['user_email'],
                    'user_profile' => $reply_message['user_profile'],
                    'time' => $reply_message['time'],
                    'media' => $reply_message['media']
                ];
            } else {
                // Invalid reply_message_id
                $input['reply_to'] = null;
            }
        }

        // Add the new message
        $messages[] = $input;
        $check_chats->message = json_encode($messages);
        $check_chats->save();
    } else {
        // No existing chat, create a new one
         $input['id'] = 1;
        Group_Chat::create([
            'module' => $request->module,
            'module_id' => $request->module_id,
            'reference_code' => $request->reference_code,
            'target_agency' => $request->target_agency,
            'message' => json_encode([$input]),
        ]);
    }

    // Send notifications
    $activity = Activity::where('type', '=', $request->module)
        ->where('type_id', '=', $request->module_id)
        ->first();

    if ($activity) {
        $user = User::find($activity->user_id);

        Notification::create([
            'user_id' => $user->id,
            'title' => 'New message',
            'status' => 'Unread',
            'type' => 'Chat',
            'item_id' => $request->module_id
        ]);

        $content = ['en' => 'New Message'];
        $fields = [
            'app_id' => 'a548e8e7-f1d6-44f5-8863-bb4d1edaf004',
            'include_player_ids' => [$user->device_token],
            'contents' => $content,
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => "https://onesignal.com/api/v1/notifications",
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json; charset=utf-8',
                'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($fields),
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        curl_exec($ch);
        curl_close($ch);
    }

    return response()->json([
        'success' => [
            'message' => $check_chats ? 'Chats Updated Successfully' : 'Chat Created Successfully',
            'status' => 200,
            'data' => $input
        ]
    ], 200);
}



private function findMessageById($messages, $id)
{
    foreach ($messages as $message) {
        if (isset($message['id']) && $message['id'] == $id) {
            return $message;
        }
    }
    return null;
}



public function get_chat_agency($id)
{
    $agency = Agencies::find($id);
    
    $group_chat = Group_Chat::where('target_agency', $agency->title)->get();
    
    foreach($group_chat as $g){
        
        $decoded_messages = [];
        $messages = json_decode($g->message);
        
        foreach ($messages as $message) {
            
       
        
     
            $decoded_messages[] = $message; 
        }
        
        $g->message = $decoded_messages;
    }
    
    if ($group_chat->count() > 0) {
        $success['data'] = $group_chat;
        $success['message'] = 'Chat found Successfully';
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    } else {
        $success['status'] = 400;
        $success['message'] = "Chat Not Exist";
        return response()->json(['error' => $success]);
    }
}



    public function get_all_chat()
    {
        
        
        $group_chat = Group_Chat::all();
        foreach($group_chat as $g){
    
        $decoded_messages = [];
        
        $messages = json_decode($g->message);

        
        foreach ($messages as $message) {
  
     
            $decoded_messages[] = $message; 
        }
        $g->message = $decoded_messages;
    }
        $success['data'] = $group_chat;
        $success['message'] = 'Chat found Successfully';
        $success['status'] = 200;
        return response()->json(['success' => $success], $this->successStatus);
    }


public function delete_chat_message(Request $request, $id, $messageId)
{
    $chat = Group_Chat::find($id);
    if (!$chat) {
        return response()->json(['error' => 'Chat not found'], 404);
    }

    $messages = json_decode($chat->message, true); // Decode as an associative array

    // Flag to check if the message was found and deleted
    $messageFound = false;

    foreach ($messages as &$message) {
        if ($message['id'] == $messageId) {
            $messageFound = true;       
            $message['message_status'] = 'deleted';
            break;
        }
    }

    if (!$messageFound) {
        return response()->json(['error' => 'Message not found in the chat'], 404);
    }

    $chat->message = json_encode($messages); // Re-encode the updated array
    $chat->save();

    
    $success['status'] = 200;
    $success['message'] = 'Message deleted successfully';
    
    return response()->json(['success' => $success]);
}


public function edit_chat_message(Request $request, $id, $messageId)
{
    $chat = Group_Chat::find($id);
    if (!$chat) {
        return response()->json(['error' => 'Chat not found'], 404);
    }

    $messages = json_decode($chat->message, true); // Decode as associative array

    $messageFound = false;

    foreach ($messages as $key => $message) {
        if (isset($message['id']) && $message['id'] == $messageId) {
            if ($request->text) {
                $message['text'] = $request->input('text');
                $message['message_type'] = 'text';
            }

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
                    } else {
                        $uploadedFile->type = 'unknown';
                    }

                    $uploadedImage = rand(1000, 9999) . '.' . $extension;
                    $path = $file->storeAs('message_files', $uploadedImage, ['disk' => 's3']);
                    $uploadedFile->url = "https://kaci-storage.s3.amazonaws.com/" . $path;
                    $uploadedFiles[] = $uploadedFile;
                }

                $message['media'] = $uploadedFiles;
                $message['message_type'] = 'media';
            }

            if ($request->audio) {
                $uploadedAudio = new \stdClass();
                $extension = $request->audio->extension();
                $uploadedAudio->type = 'audio';
                $uploadedAudio->url = $request->audio->storeAs('message_audios', rand(1000, 9999) . '.' . $extension, ['disk' => 's3']);
                $message['audio'] = $uploadedAudio->url;
                $message['message_type'] = 'audio';
            }
            
            
            if ($request->read_by) {
                // Check if read_by is a string or already an array
                $readByArray = $request->input('read_by');

                if (is_string($readByArray)) {
                    $readByArray = json_decode($readByArray, true);
                }

                // Ensure read_by is an array
                if (!is_array($readByArray)) {
                    return response()->json(['error' => 'Invalid read_by data format'], 400);
                }

                // Initialize read_by if it doesn't exist
                if (!isset($message['read_by'])) {
                    $message['read_by'] = [];
                }

                // Merge new read_by data
                $message['read_by'] = array_merge($message['read_by'], $readByArray);
            }


            $messages[$key] = $message;
            $messageFound = true;
            break;
        }
    }

    if (!$messageFound) {
        return response()->json(['error' => 'Message not found in the chat'], 404);
    }

    $chat->message = json_encode($messages);
    $chat->save();

    return response()->json(['message' => 'Message edited successfully'], 200);
}


    public function get_single_beep($id){
        
        $beep = Beep::find($id);
        
    
    
      $beep['user']=   User::find($beep->user_id);
      
      $beep['comment'] = BeepComment::where('user_id', '=', $beep->user_id)->get();
      $beep['report'] = ReportItem::where('user_id', '=', $beep->user_id)->where('type', '=', 'Beep')->get();
      
      
      $success['status'] = 200;
      $success['message'] = 'Beep found successfully';
      $success['data'] =  $beep;
      
      return response()->json(['success' => $success], $this->successStatus);
    }

    public function delete_beep($id)
    {

        $beep = Beep::find($id);

        if (!$beep) {
            return response()->json(['error' => 'Beep not found'], 404);
        }


        $beep->delete();

        BeepComment::where('beep_id', $id)->delete();


        BeepLike::where('beep_id', $id)->delete();


        $success['message'] = 'Beep permanently deleted';
        $success['status'] = 200;
        $success['data'] = $beep;

        return response()->json(['success' => $success]);
    }



    public function edit_beep(Request $request, $id)
    {

        $beep = Beep::find($id);

        if ($beep) {

            if ($request->title) {
                $beep->title  = $request->title;
            }

            if ($request->description) {
                $beep->description =  $request->description;
            }
            if ($request->status) {
                $beep->status =  $request->status;
            }

            if ($request->status) {
                $beep->status = $request->status;
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
                    $mediaObject->url = 'https://kaci-storage.s3.amazonaws.com/' . $path;

                    $mediaFiles[] = $mediaObject;
                }

                $beep->media = json_encode($mediaFiles);
            }
            
            $beep->edit_status = 1;


            $beep->save();

            $success['status'] = 200;
            $success['message'] =  'Beep updated successfully';
            $success['data'] = $beep;

            return response()->json(['success' => $success]);
        } else {


            $success['status'] = 400;
            $success['message'] = 'Beep not found';

            return response()->json(['success' => $success]);
        }
    }



 


 public function agency_datewise_dashboard(Request $request, $id)
{
    $subaccount = Sub_Account::find($id);

   
    $decoded_ids = json_decode($subaccount->agency_id, true) ?? [];
    $agencies = Agencies::whereIn('id', $decoded_ids)->get();
    
    $agency_titles = $agencies->pluck('title')->toArray();
    $privileges = json_decode($subaccount->privileges);
    
    
    $decoded_id = json_decode($subaccount->ambulance_service_id, true) ?? [];

    $ambulance_services = Ambulance_Service::whereIn('id', $decoded_id)->get()->toArray();
    $ambulance_title = array_column($ambulance_services, 'title');

    $data = [];
    if ($request->type == 'Today') {
        
        $Date = date('Y-m-d');
        
            if ($privileges->consultation_management ?? false) {
                $data['consultations'] = Consult::whereDate('created_at',$Date )
                                                ->whereIn('target_agency', $agency_titles)
                                               ->count();
            }
        
            if ($privileges->emergency_management ?? false) {
                $data['emergency'] = Sos::whereDate('created_at', $Date)
                                        ->whereIn('target_agency', $agency_titles)
                                        ->count();
            }
        
            if ($privileges->suggestion_management ?? false) {
                $data['suggestion'] = Suggestion::whereDate('created_at', $Date)
                                                 ->whereIn('target_agency', $agency_titles)
                                                 ->count();
            }
        
            if ($privileges->ireport_management ?? false) {
                $data['iReports'] = Report::whereDate('created_at', $Date)
                                          ->whereIn('target_agency', $agency_titles)
                                          ->count();
            }
        
            if ($privileges->ambulance_management ?? false) {
                $data['ambulance'] = Ambulance::whereDate('created_at', $Date)
                                                      ->whereIn('ambulance_service', $ambulance_title)
                                                      ->count();
            }
        
            if ($privileges->travelsafe_management ?? false) {
                $data['travelSafe'] = Travel::whereDate('created_at', $Date)->count();
            }
        
            if ($privileges->feedback_management ?? false) {
                $data['feedBacks'] = Feedback::whereDate('created_at', $Date)->count();
            }
        
    } elseif ($request->type == 'Weekly') {
        $startDate = now()->startOfWeek();
        $endDate = now()->endOfWeek();
        
        
    if ($privileges->consultation_management ?? false) {
        $data['consultations'] = Consult::whereBetween('created_at', [$startDate, $endDate])
                                        ->whereIn('target_agency', $agency_titles)
                                        ->count();
    }

    if ($privileges->emergency_management ?? false) {
        $data['emergency'] = Sos::whereBetween('created_at', [$startDate, $endDate])
                                ->whereIn('target_agency', $agency_titles)
                                ->count();
    }

    if ($privileges->suggestion_management ?? false) {
        $data['suggestion'] = Suggestion::whereBetween('created_at', [$startDate, $endDate])
                                         ->whereIn('target_agency', $agency_titles)
                                         ->count();
    }

    if ($privileges->ireport_management ?? false) {
        $data['iReports'] = Report::whereBetween('created_at', [$startDate, $endDate])
                                  ->whereIn('target_agency', $agency_titles)
                                  ->count();
    }

    if ($privileges->ambulance_management ?? false) {
        $data['ambulance'] = Ambulance::whereBetween('created_at', [$startDate, $endDate])
                                              ->whereIn('ambulance_service', $ambulance_title)
                                              ->count();
    }

    if ($privileges->travelsafe_management ?? false) {
        $data['travelSafe'] = Travel::whereBetween('created_at', [$startDate, $endDate])->count();
    }

    if ($privileges->feedback_management ?? false) {
        $data['feedBacks'] = Feedback::whereBetween('created_at', [$startDate, $endDate])->count();
    }
        
        
    } else { // Default to Monthly
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();
        
        
        
    if ($privileges->consultation_management ?? false) {
        $data['consultations'] = Consult::whereBetween('created_at', [$startDate, $endDate])
                                        ->whereIn('target_agency', $agency_titles)
                                        ->count();
    }

    if ($privileges->emergency_management ?? false) {
        $data['emergency'] = Sos::whereBetween('created_at', [$startDate, $endDate])
                                ->whereIn('target_agency', $agency_titles)
                                ->count();
    }

    if ($privileges->suggestion_management ?? false) {
        $data['suggestion'] = Suggestion::whereBetween('created_at', [$startDate, $endDate])
                                         ->whereIn('target_agency', $agency_titles)
                                         ->count();
    }

    if ($privileges->ireport_management ?? false) {
        $data['iReports'] = Report::whereBetween('created_at', [$startDate, $endDate])
                                  ->whereIn('target_agency', $agency_titles)
                                  ->count();
    }

    if ($privileges->ambulance_management ?? false) {
        $data['ambulance'] = Ambulance::whereBetween('created_at', [$startDate, $endDate])
                                              ->whereIn('ambulance_service', $ambulance_title)
                                              ->count();
    }

    if ($privileges->travelsafe_management ?? false) {
        $data['travelSafe'] = Travel::whereBetween('created_at', [$startDate, $endDate])->count();
    }

    if ($privileges->feedback_management ?? false) {
        $data['feedBacks'] = Feedback::whereBetween('created_at', [$startDate, $endDate])->count();
    }
    }



    $success['status'] = 200;
    $success['message'] = 'Data found successfully';
    $success['data'] = $data;

    return response()->json(['success' => $success]);
}



    public function store_sponsored_beeps(Request $request)
    {


        $request->validate([
            'profile_name' => 'required',
            'profile_image' => 'required',
            'title' => 'required',
            'description' => 'required',
            'link_name' => 'required',
            'link' => 'required',
            'location' => 'required',
            'country' => 'required',
            'expire_date' => 'required',
            'device_type' => 'required'
        ]);


        $input  = $request->all();

        if ($request->media) {

            $uploadFiles = [];

            foreach ($request->file('media') as $file) {

                $uploadFile = new \stdClass();

                $extention  = $file->extension();

                if (in_array($extention, ['png', 'jpg', 'jpeg', 'gif'])) {
                    $uploadFile->type = 'image';
                } elseif (in_array($extention, ['mp4', 'avi', 'mov', 'bin'])) {
                    $uploadFile->type = 'video';
                } elseif (in_array($extention, ['mp3', 'ogg'])) {
                    $uploadFile->type = 'audio';
                } elseif (in_array($extention,  ['pptx', 'ppt'])) {
                    $uploadFile->type = 'ppt';
                } elseif (in_array($extention, ['docx', 'doc'])) {
                    $uploadFile->type = 'docx';
                } elseif (in_array($extention, ['pdf'])) {
                    $uploadFile->type = 'pdf';
                } else {
                    $uploadFile->type = 'other';
                }

                $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
                $path = $file->storeAs('beep-media', $uploadedImage, ['disk' => 's3']);
                $uploadFile->url = "https://kaci-storage.s3.amazonaws.com/" . $path;
                $uploadFiles[] = $uploadFile;
            }

            $input['media'] = json_encode($uploadFiles);
        }
        $image = $request->file('profile_image');
        
        if ($image) {
            $imageName = rand(1000, 9999) . '.' . $image->extension();
            $path = $image->storeAs('beep-media', $imageName, ['disk' => 's3']);
            $input['profile_image'] = "https://kaci-storage.s3.amazonaws.com/" . $path;
        }

        $beep = SponsoredBeep::create($input);

        $success['status'] = 200;
        $success['message'] = 'Sponsored beep created successfully';
        $success['data'] = $beep;


        return response()->json(['success' => $success]);
    }





    public function edit_sponsored_beeps(Request $request, $id)
    {

        $beep = SponsoredBeep::find($id);


        if ($beep) {

            if ($request->profile_name) {

                $beep->profile_name = $request->profile_name;
            }

            if ($request->title) {
                $beep->title = $request->title;
            }
            if ($request->description) {
                $beep->description = $request->description;
            }
            if ($request->link_name) {
                $beep->link_name = $request->link_name;
            }
            if ($request->link) {
                $beep->link = $request->link;
            }

            if ($request->country) {
                $beep->country = $request->country;
            }
            if ($request->location) {
                $beep->location = $request->location;
            }

            if ($request->expire_date) {
                $beep->expire_date = $request->expire_date;
            }
            
            if($request->device_type){
                $beep->device_type = $request->device_type;
            }

            if ($request->media) {

                $uploadFiles = [];

                foreach ($request->file('media') as $file) {

                    $uploadFile = new \stdClass();

                    $extention  = $file->extension();

                    if (in_array($extention, ['png', 'jpg', 'jpeg', 'gif'])) {
                        $uploadFile->type = 'image';
                    } elseif (in_array($extention, ['mp4', 'avi', 'mov', 'bin'])) {
                        $uploadFile->type = 'video';
                    } elseif (in_array($extention, ['mp3', 'ogg'])) {
                        $uploadFile->type = 'audio';
                    } elseif (in_array($extention,  ['pptx', 'ppt'])) {
                        $uploadFile->type = 'ppt';
                    } elseif (in_array($extention, ['docx', 'doc'])) {
                        $uploadFile->type = 'docx';
                    } elseif (in_array($extention, ['pdf'])) {
                        $uploadFile->type = 'pdf';
                    } else {
                        $uploadFile->type = 'other';
                    }

                    $uploadedImage = rand(1000, 9999) . '.' . $file->extension();
                    $path = $file->storeAs('beep-media', $uploadedImage, ['disk' => 's3']);
                    $uploadFile->url = "https://storage.kacihelp.com/" . $path;
                    $uploadFiles[] = $uploadFile;
                }

                $beep->media = json_encode($uploadFiles);
            }

            if ($request->file('profile_image')) {
                $imageName = rand(1000, 9999) . '.' . $request->file('profile_image')->extension();
                $path = $imageName->storeAs('beep-media', $imageName, ['disk' => 's3']);
                $beep->profile_image = "https://kaci-storage.s3.amazonaws.com/" . $path;
            }

            $beep->save();

            $success['status'] = 200;
            $success['message'] = 'Beep updated successfully';
            $success['data'] = $beep;

            return response()->json(['success' => $success], $this->successStatus);
        }
    }



    public function delete_sponsored_beep($id)
    {

        $beep = SponsoredBeep::find($id);
        $beep->delete();

        $success['status'] = 200;
        $success['message'] = 'Sponsored beep deleted successfully';
        $success['data'] =  $beep;

        return response()->json(['success' => $success], $this->successStatus);
    }




    public function get_report(Request $request)
    {
        $type = $request->type;

        if ($type) {
            $report = ReportItem::where('type', $type)->get();
            foreach ($report as $r) {

                if ($r->type == 'Beep') {
                    $r['item'] = Beep::find($r->item_id);
                    $user  = User::find($r->user_id);
                    
                    $r['reporter_ksn'] = $user->ksn;
                    $r['reporter_name'] = $user->firstname. $user->lastname;
                    $r['reporter_email'] = $user->email;
                    
                    $verifyBadge = $r->user_id ? Used_code::where('user_id', $r->user_id)
                        ->where('expiry_date', '>', now())
                        ->first() : null;
                    $r['verify_badge'] = $verifyBadge ? true : false;
                    
                    
                    $r['report_reason'] = ReportType::find($r->report_type_id);
                } else {
                    $r['item'] = BeepComment::find($r->item_id);
                    $r['user'] = User::find($r->user_id);
                }
            }
            
            
        } else {
            $report = ReportItem::all();
            foreach ($report as $r) {
                if ($r->type == 'Beep') {

                    $r['item'] = Beep::find($r->item_id);
                   $user  = User::find($r->user_id);
                    
                    $r['reporter_ksn'] = $user->ksn;
                    $r['reporter_name'] = $user->firstname. $user->lastname;
                    $r['reporter_email'] = $user->email;
                    $r['report_reason'] = ReportType::find($r->report_type_id);
                    
                    $verifyBadge = $r->user_id ? Used_code::where('user_id', $r->user_id)
                        ->where('expiry_date', '>', now())
                        ->first() : null;
                    $r['verify_badge'] = $verifyBadge ? true : false;
                    
                } else {

                    $r['item'] = BeepComment::find($r->item_id);
                    $r['user'] = User::find($r->user_id);
                }
            }
        }

        if ($report->isEmpty()) {
            return response()->json(['error' => 'No data found.'], 404);
        }

        $success['status'] = 200;
        $success['message'] = 'Data found successfully';
        $success['data'] = $report;

        return response()->json(['success' => $success], 200);
    }


    public function Report_status(Request $request, $id)
    {

        $report = ReportItem::find($id);

        if ($report) {
            if ($report->report_status == 'Pending') {
                $report->report_status = 'Resolved';
            } else {
                $report->report_status = 'Pending';
            }

            $report->save();


            $success['status'] = 200;
            $success['message'] = 'Report ' . $report->report_status . ' successfully';
            $success['data'] = $report;

            return response()->json(['success' => $success], $this->successStatus);
        } else {
            $success['status'] = 400;
            $success['message']  = 'data not found';


            return response()->json(['successs' => $success]);
        }
    }
    
    
    
    
    
// public function realtime_dashboard(Request $request){
//     $data  = [];
    
//     // Initialize counts
//     $pendingAmbulance = 0;
//     $pendingSos = 0;
//     $pendingTravel = 0;
//     $inReviewAmbulance = 0;
//     $inReviewSos = 0;
//     $inReviewTravel = 0;
//     $resolvedAmbulance = 0;
//     $resolvedSos = 0;
//     $resolvedTravel = 0;
    
    
//     $data['Total_Users'] = User::where('country', '=', $request->country)->count();
//     $data['Verified_Users'] = User::where('ksn', '!=', null)->where('country', '=', $request->country)->count();
//     $data['UnVerified_Users'] = User::where('ksn', '=', null)->where('country', '=', $request->country)->count();
    
    

//     $pendingAmbulance = Ambulance::where('country', '=', $request->country)->where('status', '=', 'Pending')->count();
//     $pendingSos = Sos::where('country', '=', $request->country)->where('status', '=', 'Pending')->count();  
//     $pendingTravel = Travel::where('country', '=', $request->country)->where('status', '=', 'Pending')->count();
    

//     $inReviewAmbulance = Ambulance::where('country','=' , $request->country)->where('status', '=', 'In-Review')->count();
//     $inReviewSos = Sos::where('country', '=', $request->country)->where('status', '=', 'In-Review')->count();
//     $inReviewTravel = Travel::where('country', '=', $request->country)->where('status', '=', 'In-Review')->count();
    

//     $resolvedAmbulance = Ambulance::where('country', '=', $request->country)->where('status', '=', 'Resolved')->count();
//     $resolvedSos = Sos::where('country', '=', $request->country)->where('status', '=', 'Resolved')->count();
//     $resolvedTravel = Travel::where('country', '=', $request->country)->where('status', '=', 'Resolved')->count();
    
//     $totalPending = $pendingAmbulance + $pendingSos + $pendingTravel;
//     $totalInReview = $inReviewAmbulance + $inReviewSos + $inReviewTravel;
//     $totalResolved = $resolvedAmbulance + $resolvedSos + $resolvedTravel;
    
    
// if($totalInReview){
    
//     $data['last_updated'] = Carbon::now()->toDateTimeString();
// }
// if($totalResolved){
//     $data['last_updated'] = Carbon::now()->toDateTimeString();
// }

    

//     $data['resolved'] = $totalResolved;
//     $data['pending_request'] = $totalPending;
//     $data['In-review'] = $totalInReview;

    
//     $success['status'] = 200;
//     $success['message'] = 'Data found successfully';
//     $success['data'] = $data;
    
//     return response()->json(['success' => $success]);
// }


   


    public function realtime_dashboard(Request $request){
        $data  = [];
        
    
        $pendingAmbulance = 0;
        $pendingSos = 0;
        $pendingTravel = 0;
        $inReviewAmbulance = 0;
        $inReviewSos = 0;
        $inReviewTravel = 0;
        $resolvedAmbulance = 0;
        $resolvedSos = 0;
        $resolvedTravel = 0;
        $total_requests = 0;
        
    
        $changesOccurred = false;
        
        if($request->country){
        
            if (Ambulance::where('country', '=', $request->country)->latest('updated_at')->exists() ||
                Sos::where('country', '=', $request->country)->latest('updated_at')->exists() ||
                Travel::where('country', '=', $request->country)->latest('updated_at')->exists()||User::where('country', '=', $request->country)->latest('updated_at')) {
                $changesOccurred = true;
            }
            
        
            $data['Total_Users'] = User::where('country', '=', $request->country)->count();
            $data['Verified_Users'] = User::where('ksn', '!=', null)->where('country', '=', $request->country)->count();
            $data['UnVerified_Users'] = User::where('ksn', '=', null)->where('country', '=', $request->country)->count();
            
        
            $pendingAmbulance = Ambulance::where('country', '=', $request->country)->where('status', '=', 'Pending')->count();
            $pendingSos = Sos::where('country', '=', $request->country)->where('status', '=', 'Pending')->count();  
            $pendingTravel = Travel::where('country', '=', $request->country)->where('status', '=', 'Pending')->count();
            $pendingFeedack =  Feedback::where('country', '=', $request->country)->where('status', '=', 'Pending')->count();
            $pendingSuggestion  = Suggestion::where('country', '=', $request->country)->where('status', '=', 'Pending')->count();
            $pendingReport = Report::where('country', '=', $request->country)->where('status', '=', 'Pending')->count();
            $pendingConsult = Consult::where('country', '=', $request->country)->where('status', '=', 'Pending')->count();
            
            $inReviewAmbulance = Ambulance::where('country','=' , $request->country)->where('status', '=', 'In-Review')->count();
            $inReviewSos = Sos::where('country', '=', $request->country)->where('status', '=', 'In-Review')->count();
            $inReviewTravel = Travel::where('country', '=', $request->country)->where('status', '=', 'In-Review')->count();
            $inReviewFeedback = Feedback::where('country', '=', $request->country)->where('status', '=', 'In-Review')->count();
            $inReviewSuggestion =  Suggestion::where('country', '=', $request->country)->where('status', '=', 'In-Review')->count();
            $inReviewReport = Report::where('country', '=', $request->country)->where('status', '=', 'In-Review')->count();
            $inReviewConsult =  Report::where('country', '=', $request->country)->where('status', '=', 'In-Review')->count();
            
            
            $resolvedAmbulance = Ambulance::where('country', '=', $request->country)->where('status', '=', 'Resolved')->count();
            $resolvedSos = Sos::where('country', '=', $request->country)->where('status', '=', 'Resolved')->count();
            $resolvedTravel = Travel::where('country', '=', $request->country)->where('status', '=', 'Resolved')->count();
            $resolvedFeedback = Feedback::where('country', '=', $request->country)->where('status', '=', 'Resolved')->count();
            $resolvedSuggestion = Suggestion::where('country', '=', $request->country)->where('status', '=', 'Resolved')->count();
            $resolvedReport = Report::where('country', '=', $request->country)->where('status', '=', 'Resolved')->count();
            $resolvedConsult = Consult::where('country', '=', $request->country)->where('status', '=', 'Resolved')->count(); 
            
            $totalPending = $pendingAmbulance + $pendingSos + $pendingTravel + $pendingFeedack + $pendingSuggestion + $pendingReport + $pendingConsult;
            $totalInReview = $inReviewAmbulance + $inReviewSos + $inReviewTravel + $inReviewFeedback + $inReviewSuggestion + $inReviewReport + $inReviewConsult;
            $totalResolved = $resolvedAmbulance + $resolvedSos + $resolvedTravel + $resolvedFeedback + $resolvedSuggestion + $resolvedReport+$resolvedConsult;
            
        
            $data['resolved'] = $totalResolved;
            $data['pending_request'] = $totalPending;
            $data['In-review'] = $totalInReview;
            $data['total'] =  $totalPending + $totalInReview + $totalResolved;
            
            $data['last_updated'] = null;
            
            if ($changesOccurred) {
                    $data['last_updated'] = now();
                
                
            }
        
            $success['status'] = 200;
            $success['message'] = 'Data found successfully';
            $success['data'] = $data;
            
            return response()->json(['success' => $success]);
            
            
        }else{
            
              if (Ambulance::latest('updated_at')->exists() ||
                Sos::latest('updated_at')->exists() ||
                Travel::latest('updated_at')->exists()|| User::latest('updated_at')) {
                $changesOccurred = true;
            }
            
        
            $data['Total_Users'] = User::count();
            $data['Verified_Users'] = User::where('ksn', '!=', null)->count();
            $data['UnVerified_Users'] = User::where('ksn', '=', null)->count();
            
        
            $pendingAmbulance = Ambulance::where('status', '=', 'Pending')->count();
            $pendingSos = Sos::where('status', '=', 'Pending')->count();
            $pendingTravel = Travel::where('status', '=', 'Pending')->count();
            $pendingFeedBack = Feedback::where('status', '=', 'Pending')->count();
            
            $pendingSuggestion = Suggestion::where('status', '=', 'Pending')->count();
            $pendingReport = Report::where('status', '=', 'Pending')->count();
            $pendingConsult =  Consult::where('status', '=', 'Pending')->count();
            
            
            $inReviewAmbulance = Ambulance::where('status', '=', 'In-Review')->count();
            $inReviewSos = Sos::where('status', '=', 'In-Review')->count();
            $inReviewTravel = Travel::where('status', '=', 'In-Review')->count();
            $inReviewFeedback = FeedBack::where('status', '=', 'In-Review')->count();
            $inRevewSuggestion = Suggestion::where('status', '=', 'In-Review')->count();
            $inReviewReport = Report::where('status', '=', 'In-Review')->count();
            $inReviewConsult = Consult::where('status', '=', 'In-Review')->count();
            
            
            $resolvedAmbulance = Ambulance::where('status', '=', 'Resolved')->count();
            $resolvedSos = Sos::where('status', '=', 'Resolved')->count();
            $resolvedTravel = Travel::where('status', '=', 'Resolved')->count();
            $resolvedFeedback = Feedback::where('status', '=', 'Resolved')->count();
            $resolvedSuggestion  = Suggestion::where('status', '=', 'Resolved')->count();
            $resolvedReport = Report::where('status', '=', 'Resolved')->count();
            $resolvedConsult = Consult::where('status', '=', 'Resolved')->count();
            
            $totalPending = $pendingAmbulance + $pendingSos + $pendingTravel + $pendingFeedBack + $pendingSuggestion + $pendingReport + $pendingConsult;
            $totalInReview = $inReviewAmbulance + $inReviewSos + $inReviewTravel + $inReviewFeedback + $inRevewSuggestion + $inReviewReport + $inReviewConsult;
            $totalResolved = $resolvedAmbulance + $resolvedSos + $resolvedTravel + $resolvedFeedback + $resolvedSuggestion + $resolvedReport + $resolvedConsult;
            
            
            $data['resolved'] = $totalResolved;
            $data['pending_request'] = $totalPending;
            $data['In-review'] = $totalInReview;
            $data['total'] =  $totalPending + $totalInReview + $totalResolved;
        
            $data['last_updated'] = null;
            
            if ($changesOccurred) {
                    $data['last_updated'] = now();
                
                
            }
        
            $success['status'] = 200;
            $success['message'] = 'Data found successfully';
            $success['data'] = $data;
            
            return response()->json(['success' => $success]);
        }
    }

    public function store_subaccount(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone_number' => 'required',
            'profile_image' => 'required',
            'country' =>'required',
            // 'location' => 'nullable|required',
            'privileges'=> 'required'
        ]);

        $input  = $request->all();

       if ($request->hasfile('profile_image')) {
            $image = rand(00000000000, 35321231251231) . '.' . $request->file('profile_image')->extension();
            $path = $request->file('profile_image')->storeAs('profile', $image, ['disk' => 's3']);
            $input['profile_image'] = "https://kaci-storage.s3.amazonaws.com/" . $path;
        }
        
        
        $input['agency_id'] = json_encode($request->agency_id);
        $input['ambulance_id'] = json_encode($request->ambulance_id);

        $data = Sub_Account::create($input);

        $success['status'] = 200;
        $success['message'] = 'Account created successfully';
        $success['data'] = $data;

        return  response()->json(['success' => $success], $this->successStatus);
    }


    public function edit_subaccount(Request $request, $id)
    {
        $agency = Sub_Account::find($id);

        if ($agency) {

            if ($request->name) {
                $agency->name = $request->name;
            }

            if ($request->email) {
                $agency->email = $request->email;
            }

            if ($request->phone_number) {
                $agency->phone_number = $request->phone_number;
            }

            if ($request->password) {

                $agency->password = $request->password;
            }

            if($request->country){
                $agency->country =  $request->country;
            }

            if ($request->status) {

                $agency->status = $request->status;
            }
            
            if($request->agency_id){
                $agency->agency_id = $request->agency_id;
            } else {
                $agency->agency_id = null;
            }
           
            
            if($request->country){
                $agency->country = $request->country;
            }
            
            if($request->ambulance_service_id){
                $agency->ambulance_service_id = $request->ambulance_service_id;
            } else {
                $agency->ambulance_service_id = null;
            }
            
            
            if($request->location){
                $agency->location = $request->location;
            }
            
            
            if($request->privileges){
                $agency->privileges = $request->privileges;
            }
            

             if ($request->hasfile('profile_image')) {
                $image = rand(00000000000, 35321231251231) . '.' . $request->file('profile_image')->extension();
                $path = $request->file('profile_image')->storeAs('profile', $image, ['disk' => 's3']);
                $input['profile_image'] = "https://kaci-storage.s3.amazonaws.com/" . $path;
            }

            $agency->save();
            $success['status'] = 200;
            $success['message'] = 'Account updated successfully';
            $success['data'] = $agency;

            return response()->json(['success' => $success], $this->successStatus);
        } else {

            $error['status'] = 400;
            $error['message'] = 'Account not found';

            return response()->json(['error' => $error]);
        }

    }

    public function delete_subaccount($id){

        $agency = Sub_Account::find($id);

        $agency->delete();


        $success['status'] = 200;
        $success['message'] = 'Account deleted successfully';
        $success['data'] = $agency;

        return response()->json(['success' => $success], $this->successStatus);
    }

    public function get_subaccount($id){
        
        $account = Sub_Account::find($id);
        
        if($account){
            
            $success['status'] = 200;
            $success['message'] = 'Data found successfully';
            $success['data'] =  $account;
            
            return response()->json(['success' => $success], $this->successStatus);
        }else{
            
            $error['status'] = 400;
            $error['message'] = 'Not found';
            
            return response()->json(['error' => $error]);
        }
        
    }
    
    
    public function get_all_subaccount(Request $request){
        
        $perpage  = $request->per_page;
        $accounts;
        
        if ($perpage == "all") {
            $accounts = Sub_Account::all();
        } else {
            $accounts = Sub_Account::paginate($perpage);
        }
        
        $success['status'] = 200;
        $success['message'] = 'Accounts found successfully';
        $success['data'] =  $accounts;
        
        return response()->json(['success' => $success], $this->successStatus);
    }
    
    
    public function subacc_forgotpassword(Request $request ){
        
        $request->validate([
            'email' => 'required'
            ]);
            
            $agency =  Sub_Account::where('email', '=', $request->email)->first();
        
            if($agency === null){
            
                $success['status'] = 400;
                $success['messagee'] = 'email not found';
                
                return response()->json(['success' => $success]);
            }else{
                
                $token = rand(1000, 9999);
                $success['id'] = $agency['id'];
                $success['OTP'] = $token;
                $success['status'] = 200;
                // Mail::to($user->email)->send(new ForgotPassword($user, $token,null, null));
                $success['message'] = "Reset Password OTP has been sent to your Email";
                return response()->json(['success' => $success]);
            }
        
    }
    
    
    public function subacc_resetpassword(Request $request , $id){
        
        $request->validate([
            'password' => 'required|confirmed'
            ]);
            
            
        $agency  = Sub_Account::find($id);

        $agency->password = $request->password;
        $agency->save();
        
        $success['status'] = 200;
        $success['message'] = 'password changed successfully';
        $success['data'] = $agency;
        
        return response()->json(['success' => $success], $this->successStatus);

        
    
    }
    
    public function login_subaccount(Request $request ){
        
        $request->validate([
            'email' => 'required',
            'password' => 'required'
            ]);
            
            $agency  = Sub_Account::where('email', '=', $request->email)->where('password', '=', $request->password)->first();
            
                if($agency){
                
                    $success['status'] =200;
                    $success['message'] = 'login successfully';
                    $success['data'] =  $agency;
                    
                    return response()->json(['success' => $success], $this->successStatus);
            
                }else{
                    
                    $error['status'] = 400;
                    $error['message'] = 'Not found';
                    
                    return response()->json(['error' => $error]);
                }
    }
    

    // public function agency_all_notification($id){
        
    //   $agency =  Agency_Notification::where('agency_id', '=', $id)->where('status', 'unread')->get();
       
    //   if($agency->count() > 0){
           
             
    //   $success['status'] = 200;
    //   $success['message'] = 'Notification found successfully';
    //   $success['data'] =  $agency;
       
    //   return response()->json(['success' => $success]);
    //   }else{
    //       $error['status'] = 400;
    //       $error['message'] = 'No Unread Notifications';
           
    //       return response()->json(['error' => $error]);
    //   }
       
     
       
    // }
    
public function agency_all_notification($id)
{
    $subaccount = Sub_Account::find($id);

    $privileges = json_decode($subaccount->privileges);

    $decoded_agency_ids = json_decode($subaccount->agency_id, true) ?? [];
    $decoded_ambulance_ids = json_decode($subaccount->ambulance_service_id, true) ?? [];


    $ambulance_services = Ambulance_Service::whereIn('id', $decoded_ambulance_ids)->get()->toArray();
    $ambulance_titles = array_column($ambulance_services, 'title');

    $agencies = Agencies::whereIn('id', $decoded_agency_ids)
                        ->orWhereIn('title', $ambulance_titles)
                        ->get()->toArray();
                        
                        
    $agency_ids = array_column($agencies, 'id');


    $notificationTypes = [];

    // Add notification types based on privileges
    if ($privileges->consultation_management) {
        $notificationTypes[] = 'consultation';
    }
    if ($privileges->ambulance_management) {
        $notificationTypes[] = 'ambulance';
    }
    if ($privileges->emergency_management) {
        $notificationTypes[] = 'emergency';
    }
    if ($privileges->ireport_management) {
        $notificationTypes[] = 'ireport';
    }
    if ($privileges->travelsafe_management) {
        $notificationTypes[] = 'travelsafe';
    }
    if ($privileges->suggestion_management) {
        $notificationTypes[] = 'suggestion';
    }
    if ($privileges->feedback_management) {
        $notificationTypes[] = 'feedback';
    }


    $agency_notifications = Agency_Notification::whereIn('agency_id', $agency_ids)
                                               ->where('status', 'unread')
                                               ->whereIn('type', $notificationTypes)
                                               ->get();

    if ($agency_notifications->count() > 0) {
        $success['status'] = 200;
        $success['message'] = 'Notifications found successfully';
        $success['data'] = $agency_notifications;

        return response()->json(['success' => $success]);
    } else {
        $error['status'] = 400;
        $error['message'] = 'No unread notifications';

        return response()->json(['error' => $error]);
    }
}


    public function agency_read_notification($id){
        
        
           $agency =  Agency_Notification::where('agency_id', '=', $id)->get();
           
           if($agency){
               
               $agency->status = 'Read';
               
               $agency->save();
               
               
               $success['status'] = 200;
               $success['message'] =  'notification read successfully';
               $success['data'] = $agency;
               
               return response()->json(['success' => $success]);
           }
        
    }
    
    
    
    public function read_all_agency_notifications($id){
        $agency = Agency_Notification::where('agency_id', '=', $id)->get();
        
        foreach($agency as $a){
            
            
            $a->status = 'read';
            
        }
        
        $success['status'] = 200;
        $success['message'] = 'All notifications read successfully';
        $success['data'] = $agency;
        
        return response()->json(['success' => $success]);
    }



    public function get_beep_comments($beep_id){
        
       $beepcomment =  BeepComment::where('beep_id', $beep_id)->get();
       
       if($beepcomment->count() > 0){
           
           $success['status'] = 200;
           $success['message'] = 'Beep comment found successfully';
           $success['data'] = $beepcomment;
           
           return response()->json(['success' => $success]);
       }else{
           $error['status'] = 400;
           $error['message'] =  'comment not found';
           
           
           return response()->json(['error' => $error]);
       }
       
      
    }
    
            
    public function get_beep_reports($beep_id){
        
        $beepreport  = ReportItem::where('item_id', $beep_id)->get();
        
        if($beepreport->count() > 0){
            
            $success['status'] = 200;
            $success['message'] = 'Reports found successfully';
            $success['data'] = $beepreport;
            
            return response()->json(['success' => $success]);
        }else{
            
            $error['status'] = 400;
            $error['message'] =  "No report item found";
            
            return response()->json(['error' => $error]);
        }
        
    }
    
            
            
    public function get_module_chat(Request $request , $id){
        
        $request->validate([
            'module' => 'required'
            ]);
            
            
            
        $groupchat  = Group_Chat::where('module_id', $id)->where('module', $request->module)->first();
        
        if($groupchat){
            
            $groupchat['message'] =  json_decode($groupchat->message);
            
            $success['status'] = 200;
            $success['message'] = 'Chats found successfully';
            $success['data'] = $groupchat;
            
            return response()->json(['success' => $success]);
            
        }else{
        
        $error['status'] = 400;
        $error['message'] = 'not found';
        
        return response()->json(['error' => $error]);
            
            
        }
            
    }
    
        
   public function agency_dashboard($id)
{
    $subaccount = Sub_Account::find($id);
    if (!$subaccount) {
        return response()->json(['error' => 'Sub-Account not found'], 404);
    }

    $decoded_ids = json_decode($subaccount->agency_id, true);
    if (!is_array($decoded_ids)) {
        $decoded_ids = [];
    }

    // Fetch agencies
    $agencies = Agencies::whereIn('id', $decoded_ids)->get()->toArray();
    $agency_titles = array_column($agencies, 'title');
    $agency_country = array_column($agencies, 'country');

    $privileges = json_decode($subaccount->privileges);

    // Decode ambulance_service_ids safely
    $decoded_id = json_decode($subaccount->ambulance_service_id, true);
    if (!is_array($decoded_id)) {
        $decoded_id = [];
        // Optional: Log or handle invalid JSON format for ambulance_service_id
    }

    // Fetch ambulance services
    $ambulance_services = Ambulance_Service::whereIn('id', $decoded_id)->get()->toArray();
    $ambulance_title = array_column($ambulance_services, 'title');

    // Initialize data array
    $data = [];

    // Handle Consultation Management
    if (isset($privileges->consultation_management->view) && $privileges->consultation_management->view === true) {
        $data['consultations'] = Consult::whereIn('target_agency', $agency_titles)->count();
        $data['totalConsultPending'] = Consult::whereIn('target_agency', $agency_titles)->where('status', 'Pending')->count();
        $data['totalConsultInreview'] = Consult::whereIn('target_agency', $agency_titles)->where('status', 'In-review')->count();
        $data['totalConsultResolved'] = Consult::whereIn('target_agency', $agency_titles)->where('status', 'Resolved')->count();
    }

    // Handle Suggestion Management
    if (isset($privileges->suggestion_management->view) && $privileges->suggestion_management->view === true) {
        $data['suggestion'] = Suggestion::whereIn('target_agency', $agency_titles)->count();
        $data['totalSuggestionPending'] = Suggestion::whereIn('target_agency', $agency_titles)->where('status', 'Pending')->count();
        $data['totalSuggestionInreview'] = Suggestion::whereIn('target_agency', $agency_titles)->where('status', 'In-review')->count();
        $data['totalSuggestionResolved'] = Suggestion::whereIn('target_agency', $agency_titles)->where('status', 'Resolved')->count();
    }

    // Handle Emergency Management
    if (isset($privileges->emergency_management->view) && $privileges->emergency_management->view === true) {
        $data['emergency'] = Sos::whereIn('target_agency', $agency_titles)->count();
        $data['totalEmergencyPending'] = Sos::whereIn('target_agency', $agency_titles)->where('status', 'Pending')->count();
        $data['totalEmergencyInreview'] = Sos::whereIn('target_agency', $agency_titles)->where('status', 'In-review')->count();
        $data['totalEmergencyResolved'] = Sos::whereIn('target_agency', $agency_titles)->where('status', 'Resolved')->count();
    }

    // Handle iReport Management
    if (isset($privileges->ireport_management->view) && $privileges->ireport_management->view === true) {
        $data['iReports'] = Report::whereIn('target_agency', $agency_titles)->count();
        $data['totalIreportPending'] = Report::whereIn('target_agency', $agency_titles)->where('status', 'Pending')->count();
        $data['totalIreportResolved'] = Report::whereIn('target_agency', $agency_titles)->where('status', 'Resolved')->count();
        $data['totalIreportInreview'] = Report::whereIn('target_agency', $agency_titles)->where('status', 'In-review')->count();
    }

    // Handle Ambulance Management
    if (isset($privileges->ambulance_management->view) && $privileges->ambulance_management->view === true) {
        $data['ambulance'] = Ambulance::whereIn('ambulance_service', $ambulance_title)->count();
        $data['totalAmbulancePending'] = Ambulance::whereIn('ambulance_service', $ambulance_title)->where('status', 'Pending')->count();
        $data['totalAmbulanceResolved'] = Ambulance::whereIn('ambulance_service', $ambulance_title)->where('status', 'Resolved')->count();
        $data['totalAmbulanceInreview'] = Ambulance::whereIn('ambulance_service', $ambulance_title)->where('status', 'In-review')->count();
    }

    // Handle TravelSafe Management
    if (isset($privileges->travelsafe_management->view) && $privileges->travelsafe_management->view === true) {
    

        $data['travelSafe'] = Travel::whereIn('country', $agency_country)->count();
        $data['totalTravelsafePending'] = Travel::whereIn('country', $agency_country)->where('status', 'Pending')->count();
        $data['totalTravelsafeResolved'] = Travel::whereIn('country', $agency_country)->where('status', 'Resolved')->count();
        $data['totalTravelsafeInreview'] = Travel::whereIn('country', $agency_country)->where('status', 'In-review')->count();
    }

    // Handle Feedback Management
    if (isset($privileges->feedback_management->view) && $privileges->feedback_management->view === true) {
     
        $data['feedBacks'] = Feedback::whereIn('country', $agency_country)->count();
        $data['totalFeedbackPending'] = Feedback::whereIn('country', $agency_country)->where('status', 'Pending')->count();
        $data['totalFeedbackResolved'] = Feedback::whereIn('country', $agency_country)->where('status', 'Resolved')->count();
        $data['totalFeedbackInreview'] = Feedback::whereIn('country', $agency_country)->where('status', 'In-review')->count();
    }

    // Calculate totals
    $data['totalPendingRequest'] = ($data['totalConsultPending'] ?? 0) +
                                   ($data['totalSuggestionPending'] ?? 0) +
                                   ($data['totalEmergencyPending'] ?? 0) +
                                   ($data['totalAmbulancePending'] ?? 0) +
                                   ($data['totalFeedbackPending'] ?? 0) +
                                   ($data['totalTravelsafePending'] ?? 0) +
                                   ($data['totalIreportPending'] ?? 0);

    $data['totalResolvedRequest'] = ($data['totalConsultResolved'] ?? 0) +
                                    ($data['totalSuggestionResolved'] ?? 0) +
                                    ($data['totalEmergencyResolved'] ?? 0) +
                                    ($data['totalAmbulanceResolved'] ?? 0) +
                                    ($data['totalFeedbackResolved'] ?? 0) +
                                    ($data['totalTravelsafeResolved'] ?? 0) +
                                    ($data['totalIreportResolved'] ?? 0);

    $data['totalInreviewRequest'] = ($data['totalConsultInreview'] ?? 0) +
                                    ($data['totalSuggestionInreview'] ?? 0) +
                                    ($data['totalEmergencyInreview'] ?? 0) +
                                    ($data['totalAmbulanceInreview'] ?? 0) +
                                    ($data['totalFeedbackInreview'] ?? 0) +
                                    ($data['totalTravelsafeInreview'] ?? 0) +
                                    ($data['totalIreportInreview'] ?? 0);

    $data['totalRequests'] = $data['totalPendingRequest'] + $data['totalResolvedRequest'] + $data['totalInreviewRequest'];

    $success['status'] = 200;
    $success['message'] = 'Data found successfully';
    $success['data'] = $data;

    return response()->json(['success' => $success]);
}

    
    



}
