<!doctype html>
<html lang="en">

<head>
  <title>Emergency</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <style>
    body {
  background-image: url("https://kacinew.s3.amazonaws.com/message_images/Group+9752.png");
  background-size:cover;
  background-repeat:no-repeat;
  height:70%;
}

</style>

</head>

<body>
  <table width="100%" border="0" cellspacing="0" style='background-color: white;'>
      <tr>
          <td width='37%'>  <div style='list-style:none;text-align:start;'><img src="https://kacinew.s3.amazonaws.com/kaci_logo/Logo.png" height=30px width=90px></div> </td>
         
          <td width='65%'><div style='list-style:none;font-size:25px;color:black;'><strong style='text-align:center;'>Emergency</strong></div></td>
        
      </tr>
        </table>
        <div width="100%" border="0" cellspacing="0" style='background-color: #3f0d12;background-image: linear-gradient(315deg, #e41c38 0%, #E81828 74%);'>
            <center>
           <table>
            <tr style='text-align:center;'>
                <td><h2 style='text-align:center;font-size:30px;font-weight:bolder;color:white;margin-top:20px '>Help is Needed!</h2></td>
            </tr>
           </table>
           </center>
           <center>
           <table width="60%"  style='background-color: #8d0714;border-radius:20px;padding:10px;'>
            <tr>
                <td width='20%' style='text-align:center;font-size:12px;color:white'>Country:  <strong>{{$ambulance->country}}</strong></td>
                 <td width='20%' style='color:white;text-align:center;'>|</td>
                 <td width='20%' style='text-align:center;font-size:12px;color:white'>Status:   <strong>Pending</strong></td>
                
            </tr>
            </table>
            </center>
             <center>
           <table width="80%" style='margin-top:20px;'>
            <tr>
                <td width='40%' style='text-align:center;font-size:12px;color:white'>Reference Code:  <strong>{{$ambulance->reference_code}}</strong></td>
                
                 <td width='40%' style='text-align:center;font-size:12px;color:white'><strong>{{$ambulance->created_at}}</strong></td>
                
            </tr>
            </table>
            
            </center>
             <center>
        
              <table width="80%" style='background-color: white;'>
                   <tr>
                      <td>
                          <center>
                          <div style='text-align:center;background-color: red;padding:5px;margin-top:20px;width:130px;border-radius:20px'>
                          <div style='margin-botton:0;color:white;'>User Details</div>
                          </div>
                          </center>
                      </td>
                  </tr>
                  <tr>
                      <td style='text-align:center;margin-top:10px;'>
                          <center>
                          <div style='border-radius:100px;background-color:white;border:1px solid black;width:90px;margin-top:10px;'>
                              <img src='{{$user->profile_image}}' width=40px height=70px>
                          </div>
                          </center>
                          
                      </td>
                  </tr>
                   <tr>
                      <td style='text-align:center;'>
                          <center>
                        <h5 style='font-weight:light;margin-top:10px;margin-bottom:0;color:gray;'>Name</h5>
                           <div style='font-weight:bolder;color:black;'>{{$user->firstname}} {{$user->lastname}}</div>
                          </center>
                          
                      </td>
                  </tr>
                  
                   <tr>
                      <td style='text-align:center;'>
                          <center>
                        <h5 style='font-weight:light;margin-top:10px;margin-bottom:0;color:gray;'>KSN</h5>
                           <div style='font-weight:bolder;color:black;'>{{$user->ksn}}</div>
                          </center>
                          
                      </td>
                  </tr>
                    <tr>
                      <td style='text-align:center;'>
                          <center>
                        <h5 style='font-weight:light;margin-top:10px;margin-bottom:0;color:gray;'>Email</h5>
                           <div style='font-weight:bolder;color:black;'>{{$user->email}}</div>
                          </center>
                          
                      </td>
                  </tr>
                    <tr>
                      <td style='text-align:center;'>
                          <center>
                        <h5 style='font-weight:light;margin-top:10px;margin-bottom:0;color:gray;'>Phone Number</h5>
                           <div style='font-weight:bolder;color:black;'>{{$user->phone_number}}</div>
                          </center>
                          
                      </td>
                  </tr>
                   <tr>
                      <td width='100%'>
                          <center>
                          <div style='border:1px solid #e3dddd;margin-top:20px;width:80%'></div></center></td>
                   </tr>
                      <tr>
                      <td>
                          <center>
                          <div style='text-align:center;background-color: red;padding:5px;margin-top:20px;width:130px;border-radius:20px'>
                          <div style='margin-botton:0;color:white;'>Dependent Details</div>
                          </div>
                          </center>
                      </td>
                  </tr>
                   @foreach($dependant as $d)
                     <tr>
                      <td style='text-align:center;'>
                          <center>
                        <h5 style='font-weight:light;margin-top:10px;margin-bottom:0;color:red;'>Dependent # {{$loop->iteration}}</h5>
                        
                          </center>
                          
                      </td>
                  </tr>
                   <tr>
                      <td style='text-align:center;'>
                          <center>
                        <h5 style='font-weight:light;margin-top:10px;margin-bottom:0;color:gray;'>Name</h5>
                           <div style='font-weight:bolder;color:black;'>{{$d->name}}</div>
                          </center>
                          
                      </td>
                  </tr>
                   <tr>
                      <td style='text-align:center;'>
                          <center>
                        <h5 style='font-weight:light;margin-top:10px;margin-bottom:0;color:gray;'>Email</h5>
                           <div style='font-weight:bolder;color:black;'>{{$d->email}}</div>
                          </center>
                          
                      </td>
                  </tr>
                                     <tr>
                      <td style='text-align:center;'>
                          <center>
                        <h5 style='font-weight:light;margin-top:10px;margin-bottom:0;color:gray;'>Phone Number</h5>
                           <div style='font-weight:bolder;color:black;'>{{$d->phone_number}}</div>
                          </center>
                          
                      </td>
                  </tr>
                  
                                     <tr>
                      <td style='text-align:center;'>
                          <center>
                        <h5 style='font-weight:light;margin-top:10px;margin-bottom:0;color:gray;'>Relation Type</h5>
                           <div style='font-weight:bolder;color:black;'>{{$d->relation_type}}</div>
                          </center>
                          
                      </td>
                  </tr>
                  @endforeach
                    <tr>
                      <td width='100%'>
                          <center>
                          <div style='border:1px solid #e3dddd;margin-top:20px;width:80%'></div></center></td>
                   </tr>
                     <tr>
                      <td>
                          <center>
                          <div style='text-align:center;background-color: red;padding:5px;margin-top:20px;width:130px;border-radius:20px'>
                          <div style='margin-botton:0;color:white;'>Emergency Details</div>
                          </div>
                          </center>
                      </td>
                  </tr>
                   <tr>
                      <td style='text-align:center;'>
                          <center>
                        <h5 style='font-weight:light;margin-top:10px;margin-bottom:0;color:gray;'>Target Agency</h5>
                           <div style='font-weight:bolder;color:black;'>{{$ambulance->target_agency}}</div>
                          </center>
                          
                      </td>
                  </tr>
                   <tr>
                      <td style='text-align:center;'>
                          <center>
                        <h5 style='font-weight:light;margin-top:10px;margin-bottom:0;color:gray;'>Current Location</h5>
                           <div style='font-weight:bolder;color:black;'>{{$ambulance->location}}</div>
                          </center>
                          
                      </td>
                  </tr>
                    <tr>
                      <td style='text-align:center;'>
                          <center>
                        <h5 style='font-weight:light;margin-top:10px;margin-bottom:0;color:gray;'>Current Address</h5>
                           <div style='font-weight:bolder;color:black;'>{{$ambulance->address}}</div>
                          </center>
                          
                      </td>
                  </tr>
                    <tr>
                      <td style='text-align:center;'>
                          <center>
                        <h5 style='font-weight:light;margin-top:10px;margin-bottom:0;color:gray;'>Coordinates</h5>
                          <div style='font-weight:bolder;color:black;'>{{$latitude}}-{{$longitude}}</div>
                          </center>
                          
                      </td>
                  </tr>
                     <tr>
                      <td style='text-align:center;'>
                          <center>
                        <h5 style='font-weight:light;margin-top:10px;margin-bottom:0;color:gray;'>Map</h5>
                          <div style='font-weight:bolder;color:black;'>{{$ambulance->map}}</div>
                          </center>
                          
                      </td>
                  </tr>
                   <tr>
                      <td style='text-align:center;'>
                          <center>
                        <h5 style='font-weight:light;margin-top:10px;margin-bottom:0;color:gray;'>Comments</h5>
                          <div style='font-weight:bolder;color:black;'>{{$ambulance->comments}}</div>
                          </center>
                          
                      </td>
                  </tr>
                     <tr>
                      <td style='text-align:center;'>
                          <center>
                        <h5 style='font-weight:light;margin-top:10px;margin-bottom:0;color:gray;'>Media Files</h5>
                        
                          </center>
                          
                      </td>
                  </tr>
                        @if($image != null)
                        <tr>   
                            <td style='text-align:center;'>
                                <div class="flex" style="display:inline-flex;text-align: center;margin-top:-20px;">
    <ul style="display:inline-flex;">
        
                       @foreach ($image as $imageArray)
              
                  
                          <li style='list-style:none;'>
                       @if($imageArray->type==='image')
                        <img src="{{$imageArray->url }}" height=90px width=90px>
     @elseif($imageArray->type === 'video')
      <div style="background-color:#f53939;padding:auto;width:90px;height:90px;">
                    <a href="{{$imageArray->url }}" target="_blank">
                        <img src="https://kacinew.s3.amazonaws.com/kaci_logo/75-757675_video-file-icon-video-file-icon-png-transparent.png" height="60px" width="60px" style='margin-top:15px;' alt="Video">
                        <!-- Add a play button overlay or other graphic -->
                    </a>
                  </div>
                @elseif($imageArray->type === 'audio')
                     <div style="background-color:#f53939;padding:auto;width:90px;height:90px;">
                    <a href="{{ $imageArray->url }}" target="_blank" >
                        <img src="https://kacinew.s3.amazonaws.com/kaci_logo/466-4666660_file-audio-o-comments-sound-file-icon.png" height="60px" width="60px" style='margin-top:15px;' alt="Audio">
                        <!-- Add an audio play button overlay or other graphic -->
                    </a>
                    </div>
                       @elseif($imageArray->type === 'pdf')
                  <div style="background-color:#f53939;padding:auto;width:90px;height:90px;">
                    <a href="{{ $imageArray->url }}" target="_blank" >
                        <img src="https://kacinew.s3.amazonaws.com/kaci_logo/pdf-file-document-red-icon-11636944175aoqhvmhezi.png" height="60px" width="60px" style='margin-top:15px;' alt="PDF">
                        <!-- Add an audio play button overlay or other graphic -->
                    </a>
                      </div>
                      @elseif($imageArray->type === 'docx')
                  <div style="background-color:#f53939;padding:auto;width:90px;height:90px;">
                    <a href="{{ $imageArray->url }}" target="_blank" >
                        <img src="https://kacinew.s3.amazonaws.com/kaci_logo/download+(4).png" height="60px" width="60px" style='margin-top:15px;' alt="DOCX">
                        <!-- Add an audio play button overlay or other graphic -->
                    </a>
                      </div>
                      @elseif($imageArray->type === 'ppt')
                     <div style="background-color:#f53939;padding:auto;width:90px;height:90px;">
                    <a href="{{ $imageArray->url }}" target="_blank" >
                        <img src="https://kacinew.s3.amazonaws.com/kaci_logo/pptx_icon_(2019).svg.png" height="60px" width="60px" style='margin-top:15px;' alt="PPT">
                        <!-- Add an audio play button overlay or other graphic -->
                    </a>
                      </div>
                      @elseif($imageArray->type === 'unknowm')
                 <div style="background-color:#f53939;padding:auto;width:90px;height:90px;">
                    <a href="{{ $imageArray->url }}" target="_blank" >
                        <img src="https://kacinew.s3.amazonaws.com/kaci_logo/download.jpg" height="60px" width="60px" style='margin-top:15px;' alt="Unknown">
                        <!-- Add an audio play button overlay or other graphic -->
                    </a>
                     </div>
                @endif
                  </li>
                          
                    
              
    @endforeach
    </ul>
    </div>
    </td>
      </tr>
    @endif
              </table>
     
     </center>
      </div>
    
     

 <!-- <header>-->
 <!--<center>-->
 <!--     <div class="flex" style="text-align: center;padding:10px 0 10px 0">-->
 <!--           <div style='list-style:none;text-align:start;'><img src="https://kacinew.s3.amazonaws.com/kaci_logo/Logo.png" height=50px width=120px></div> -->
 <!--  <center>-->
 <!--       <div style='list-style:none;text-align:center;font-size:25px;margin-bottom:65px;'><strong style='text-align:center;'>Emergency</strong></div> -->
 <!--     </center>-->
  
 <!--   </div>-->
 <!--   </center>-->
 <!--   </header>-->
     
<!--         <center>-->
<!--             <h2 style='color:black;font-weight:bolder;'>Help is Needed!</h2>-->
<!--         </center>-->
         
       
<!--<br>-->

<!-- <div class="container">-->
<!--      <br>-->
<!--      <br>-->
<!--      <center>-->
<!--  <div stylr='margin-top:40px;'>-->
<!--    <img src="https://kacinew.s3.amazonaws.com/kaci_logo/kacidark.png" height=120px width=200px>-->
<!--</div>-->
<!--</center>-->
<!--<br>-->


<!--<br>-->
<!--<center>-->
<!-- <div class="container" style="background-color: white;justify-content:center;padding:20px;width:80%;text-align:start;">-->
<!--<div class="message">-->
    
<!--    <p style='color:black;text-align:start;font-size:15px;'>Hi <strong>$user->firstname,</strong></p>-->
<!--</div>-->
<!--<div class='para'>-->
<!--    <p style='color:black;text-align:start;'>Thankyou for submitting your feedback and bug report, we have received it and we will definitely work on it</p>-->

<!--<p style='color:black;text-align:start;'>We will not be able to reply when solved , but if we specified direction, we will contact you</p>-->
<!--<p style='color:black;text-align:start;'>Thankyou for being a part of our community</p>-->

<!--<strong style='color:black;text-align:start;'>The Watchfull Assistant!</strong>-->
<!--</div>-->
<!--</div>-->
<!--</div>-->

   <footer>
  <div class="footers" style="text-align: center;background-color: black; color: white;padding:10px 0 10px 0 ;height:192px;">
  
       <center>
  <div>
       <img src="https://kacinew.s3.amazonaws.com/kaci_logo/Kaci+Logo+Send+copy.png" height=50px width=150px>
      </div>
  
  <center>
       <div class="flex" style="display:inline-flex;text-align: center;margin-right:80px;margin-top:-20px;">
    <ul style="display:inline-flex;">
        <li style='list-style:none;padding-left:40px;'><a href='https://www.facebook.com/kiristahq'><img src='https://kirista.s3.amazonaws.com/logo/Facebook.png' height=20px width=20px></a></li>
        <li  style='list-style:none;padding-left:40px;'><a href='https://www.instagram.com/kiristahq'><img src='https://kirista.s3.amazonaws.com/logo/Instagram.png' height=18px width=18px></a></li>
        <li  style='list-style:none;padding-left:40px;'><a href='https://www.twitter.com/kiristahq'>
            <!--<img src='https://kirista.s3.amazonaws.com/logo/Twitter.png' height=20px width=20px>-->
              <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="text-xl" height="20" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M3 3.9934C3 3.44476 3.44495 3 3.9934 3H20.0066C20.5552 3 21 3.44495 21 3.9934V20.0066C21 20.5552 20.5551 21 20.0066 21H3.9934C3.44476 21 3 20.5551 3 20.0066V3.9934ZM10.6219 8.41459C10.5562 8.37078 10.479 8.34741 10.4 8.34741C10.1791 8.34741 10 8.52649 10 8.74741V15.2526C10 15.3316 10.0234 15.4088 10.0672 15.4745C10.1897 15.6583 10.4381 15.708 10.6219 15.5854L15.5008 12.3328C15.5447 12.3035 15.5824 12.2658 15.6117 12.2219C15.7343 12.0381 15.6846 11.7897 15.5008 11.6672L10.6219 8.41459Z"></path></svg>
            </a>
        </li>
           <li  style='list-style:none;padding-left:40px;'><a href='https://www.twitter.com/kiristahq'><img src='https://kacinew.s3.amazonaws.com/kaci_logo/linkedin.png' height=17px width=20px></a></li>
    </ul>
    </div>
  </center>
      </center>
    <center>
<div class="flex" style="display:inline-flex;text-align: center;margin-right:80px;margin-top:-20px;">
    <ul style="display:inline-flex;">
         <li style='list-style:none;padding-left:30px;font-size:10px;'><a href='#' style='color:white;'>Help</a></li> 
          <li  style='list-style:none;padding-left:20px;font-size:10px;'>|</li> 
        <li  style='list-style:none;padding-left:30px;font-size:10px;'><a href='#' style='color:white;'>Download Kaci</a></li> 
         <li  style='list-style:none;padding-left:20px;font-size:10px;'>|</li> 
        <li  style='list-style:none;padding-left:30px;font-size:10px;'><a href='#' style='color:white;'>Chat Kaci</a></li>
    </ul>
    </div>
   
  </center>
   <center>
<div class="flex" style="display:inline-flex;text-align: center;margin-top:-20px;">
    <ul style="display:inline-flex;">
         <li style='list-style:none;font-size:10px;padding-right:20px'>Made in Ninja</li> 
          <li  style='list-style:none;font-size:10px;'>|</li> 
        <li  style='list-style:none;padding-left:20px;font-size:10px;'>Powered By FactCheck Initiative</li> 
       
    </ul>
    </div>
   
  </center>
  </div>

</footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>