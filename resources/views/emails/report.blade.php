<!doctype html>
<html lang="en">

<head>
  <title>Travel Safe</title>
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
  <table width="100%" border="0" cellspacing="0" cellpadding="20" background="https://kacinew.s3.amazonaws.com/message_images/Group+9752.png" style='background-size:cover;background-repeat:no-repeat;'>
    <center>
  <header>
       <img src="https://kacinew.s3.amazonaws.com/kaci_logo/Logo.png" height=40px width=140px>
      </header>
      </center>

<br>


<br>
 <div class="container">
      <br>
      <br>
      <center>
  <div stylr='margin-top:40px;'>
     <img src="https://kacinew.s3.amazonaws.com/kaci_logo/Group+-31.png" height=120px width=150px>
</div>
</center>




<center>
 <div class="container" style="justify-content:center;padding:20px;text-align:start;">
<div class="message">
    
    <p style='color:black;text-align:start;font-size:15px;'>Dear <strong>{{$dependentname}},</strong></p>
</div>
<div class='para'>
    <p style='color:black;text-align:start;'><strong>You have a new submission.</strong></p>

 <h5 style='color:black;text-align:center;font-size:20px;'><strong>Details</strong></h5>

@if($ambulance->anonymous === 'No')
<p style='color:black;text-align:start;'><strong>User</strong>
<br>Name: {{$user->firstname}} {{$user->lastname}}<br>KSN: {{$user->ksn}}<br>Email: {{$user->email}}<br>Phone: {{$user->phone_number}}</p>

@elseif($ambulance->anonymous === 'Yes')

@endif
<p style='color:black;text-align:start;'><strong>Reference Code</strong>: {{$ambulance->reference_code}}</p>
<p style='color:black;text-align:start;'><strong>Target Agency</strong>: {{$ambulance->target_agency}}</p>
<p style='color:black;text-align:start;'><strong>Occurrence Location</strong>: {{$ambulance->location}}</p>
<p style='color:black;text-align:start;'><strong>Address</strong>: {{$ambulance->address}}</p>
<p style='color:black;text-align:start;'><strong>Report Subject</strong>: {{$ambulance->subject}}</p>
<p style='color:black;text-align:start;'><strong>Report Details</strong>: {{$ambulance->details}}</p>
<p style='color:black;text-align:start;'><strong>Date</strong>: {{$ambulance->created_at}}</p>
<p style='color:black;text-align:start;'><strong>Map</strong>: {{$ambulance->map_link}}</p>

  @if($image != null)
  <p style='color:black;text-align:start;'><strong>Media Files:</strong</p>
                        <tr>   
                            <td style='text-align:center;'>
                                <div class="flex" style="display:inline-flex;text-align: center;margin-top:-20px;">
    <ul style="display:inline-flex;padding-right:5px">
        
                       @foreach ($image as $imageArray)
              
                  
                          <li style='list-style:none;'>
                       @if($imageArray->type==='image')
                        <img src="{{$imageArray->url }}" height=90px width=90px>
     @elseif($imageArray->type === 'video')
      <div style="background-color:#f53939;padding:auto;width:90px;height:90px;">
                    <a href="{{$imageArray->url }}" target="_blank">
                        <img src="https://kacinew.s3.amazonaws.com/kaci_logo/icons8-video-50.png" height="60px" width="60px" style='margin-top:15px;' alt="Video">
                        <!-- Add a play button overlay or other graphic -->
                    </a>
                  </div>
                @elseif($imageArray->type === 'audio')
                     <div style="background-color:#f53939;padding:auto;width:90px;height:90px;">
                    <a href="{{ $imageArray->url }}" target="_blank" >
                        <img src="https://kacinew.s3.amazonaws.com/kaci_logo/icons8-audio-50.png" height="60px" width="60px" style='margin-top:15px;' alt="Audio">
                        <!-- Add an audio play button overlay or other graphic -->
                    </a>
                    </div>
                       @elseif($imageArray->type === 'pdf')
                  <div style="background-color:#f53939;padding:auto;width:90px;height:90px;">
                    <a href="{{ $imageArray->url }}" target="_blank" >
                        <img src="https://kacinew.s3.amazonaws.com/kaci_logo/icons8-pdf-50.png" height="60px" width="60px" style='margin-top:15px;' alt="PDF">
                        <!-- Add an audio play button overlay or other graphic -->
                    </a>
                      </div>
                      @elseif($imageArray->type === 'docx')
                  <div style="background-color:#f53939;padding:auto;width:90px;height:90px;">
                    <a href="{{ $imageArray->url }}" target="_blank" >
                        <img src="https://kacinew.s3.amazonaws.com/kaci_logo/icons8-doc-50.png" height="60px" width="60px" style='margin-top:15px;' alt="DOCX">
                        <!-- Add an audio play button overlay or other graphic -->
                    </a>
                      </div>
                      @elseif($imageArray->type === 'ppt')
                     <div style="background-color:#f53939;padding:auto;width:90px;height:90px;">
                    <a href="{{ $imageArray->url }}" target="_blank" >
                        <img src="https://kacinew.s3.amazonaws.com/kaci_logo/icons8-ppt-50.png" height="60px" width="60px" style='margin-top:15px;' alt="PPT">
                        <!-- Add an audio play button overlay or other graphic -->
                    </a>
                      </div>
                      @elseif($imageArray->type === 'unknowm')
                 <div style="background-color:#f53939;padding:auto;width:90px;height:90px;">
                    <a href="{{ $imageArray->url }}" target="_blank" >
                        <img src="https://kacinew.s3.amazonaws.com/kaci_logo/icons8-file-50.png" height="60px" width="60px" style='margin-top:15px;' alt="Unknown">
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
   <p style=margin-left:30px><strong style='color:black;text-align:start;'>The Watchful Assistant!</strong></p>
       @else
        <p><strong style='color:black;text-align:start;'>The Watchful Assistant!</strong></p>
    @endif

</div>
</div>
</div>
  </table>
  <footer>
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
    <tr>
      <td style="background-color: black; color: white; padding: 10px 0;">
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td align="center">
              <img src="https://kacinew.s3.amazonaws.com/kaci_logo/Kaci+Logo+Send+copy.png" height="50" width="150" alt="Logo">
            </td>
          </tr>
          <tr>
            <td align="center" style="padding-top: 10px;">
              <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                <tr>
                  <td style="margin-right: 20px;">
                    <a href="https://www.facebook.com/kacihelp" style="text-decoration: none;margin-right:10px;">
                      <div style="margin-left: 10px;">
                          <center>
                        <img src="https://kacinew.s3.amazonaws.com/help_book_images/icons8-facebook-circled-50.png" height="23" width="23" alt="Facebook">
                        </center>
                      </div>
                    </a>
                  </td>
                  <td style="margin-right: 10px;">
                    <a href="https://www.instagram.com/kacihelp" style="text-decoration: none;margin-right:10px;">
                      <div style="margin-left: 10px;">
                          <center>
                        <img src="https://kacinew.s3.amazonaws.com/help_book_images/icons8-instagram-circle-60.png" height="29" width="29" alt="Instagram">
                        </center>
                      </div>
                    </a>
                  </td>
                  <td style="margin-right: 10px;">
                    <a href="https://www.twitter.com/kacihelp" style="text-decoration: none;margin-right:10px;">
                      <div style="margin-left: 10px;">
                          <center>
                        <!--<img src="https://kacinew.s3.amazonaws.com/help_book_images/icons8-twitter-circled-60.png" height="27" width="27" alt="Twitter">-->
                          <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="text-xl" height="27" width="27" xmlns="http://www.w3.org/2000/svg"><path d="M3 3.9934C3 3.44476 3.44495 3 3.9934 3H20.0066C20.5552 3 21 3.44495 21 3.9934V20.0066C21 20.5552 20.5551 21 20.0066 21H3.9934C3.44476 21 3 20.5551 3 20.0066V3.9934ZM10.6219 8.41459C10.5562 8.37078 10.479 8.34741 10.4 8.34741C10.1791 8.34741 10 8.52649 10 8.74741V15.2526C10 15.3316 10.0234 15.4088 10.0672 15.4745C10.1897 15.6583 10.4381 15.708 10.6219 15.5854L15.5008 12.3328C15.5447 12.3035 15.5824 12.2658 15.6117 12.2219C15.7343 12.0381 15.6846 11.7897 15.5008 11.6672L10.6219 8.41459Z"></path></svg>
                        </center>
                      </div>
                    </a>
                  </td>
                  <td>
                    <a href="https://www.linkedin.com/company/kacihelp" style="text-decoration: none;margin-right:10px;">
                      <div style="margin-left: 10px;">
                          <center>
                        <img src="https://kacinew.s3.amazonaws.com/help_book_images/icons8-linkedin-circled-60.png" height="27" width="27" alt="LinkedIn">
                        </center>
                      </div>
                    </a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td align="center" style=" font-size: 10px;">
              <a href="#" style="color: white; text-decoration: none;margin-right:5px;">Help</a>
               <a style="color: white; text-decoration: none;margin-right:5px;">|</a> 
              <a href="https://www.kaci.help/donation/" style="color: white; text-decoration: none;margin-right:5px;">Donate</a>
              <a style="color: white; text-decoration: none;margin-right:5px;">|</a>  
              <a href="https://www.kaci.help/terms-of-use/" style="color: white; text-decoration: none;margin-right:5px;">Terms</a>
            </td>
          </tr>
          <tr>
            <td align="center" style="font-size: 10px; padding-top: 5px;">
              Made in Naija 💚  | <a href="www.fcihq.org" style="color: white; text-decoration: none;"> Powered By FactCheck Initiative</a>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
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
