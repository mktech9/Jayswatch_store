<!DOCTYPE html>
<html lang="en">



    <title>Contact Jay's Watch Store | We're Here to Help You</title>
    <meta name="description" content="Get in touch with Jay's Watch Store for inquiries or support. Visit our stores or contact us.">
    <meta property="og:title" content="Contact Jay's Watch Store | We're Here to Help You">
    <meta property="og:description" content="Get in touch with Jay's Watch Store for inquiries or support. Visit our stores or contact us.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="page">

@include('frontend.partials.header_link')

<body>



    @include('frontend.partials.header')

<style>
    /*--- media-query--- */

    @media (max-width: 576px) {
        .form-container {
            padding: 20px;
            margin: 20px;
        }

        .form-container h1 {
            font-size: 1.25rem;
        }
    }

    /* -----contact-us-form----- */
    .contact-section {
        background-color: white;
    }

    .form-container {
        max-width: 703px;
        color: #452c1e;
        margin: 50px auto;
        padding: 30px;
    }

    .contact-textarea {
        border: none !important;
        border-radius: 0 !important;
        background-color: #f5f5f5 !important;

    }

    .form-container .form-contact {
        font-size: 24px;
        text-align: center;
    }

    .form-container h1 {
        text-align: center;
        font-size: 45px;
        font-weight: bold;
    }

    .form-container p {
        text-align: center;
        margin-bottom: 20px;
        font-size: 20px;
            font-family: 'aguila-thin';
    }

    .contact-in {
        background-color: transparent !important;
        border-radius: 0 !important;
        border: none !important;
        border-bottom: 1px solid black !important;
            padding-left: 3px !important;
    }

    .check-main {
        font-size: 12px;

    }

    .check-box[type=checkbox] {
        border-radius: 1.25em !important;
    }

    .check-box[type=checkbox]:checked {
        background-color: black;
        border: none !important;
    }

    .check-txt {
        color: black !important;
        font-weight: bold;
    }

    .contact-button {
        background-color: black !important;
        color: white !important;
    }

    .form-select:focus {
        box-shadow: none !important;
    }

    input,
    select {
        padding: .375rem 0 !important;
    }

    input,
    textarea:focus {
        box-shadow: none !important;
    }
    .ttttsss{
        font-family: 'aguila-thin';
        text-transform: uppercase;
        text-align: center;
        font-size: 32px;
    }
    .ttttsss11{
    font-family: 'aguila-thin';
    font-weight: normal;
    font-size: 25px;
    text-align: center;
        padding-bottom: 1rem;
    }
    .contact-section{
      margin: 70px auto;
    }
    .goback{
        margin-right: 1rem;
        background-color: transparent !important;
        color: #000 !important;
        border: 0;
        padding-right: 0 !important;
    padding-left: 0 !important;
    }
    .goback:hover{
        margin-right: 1rem;
        background-color: transparent !important;
        color: #000 !important;
        border: 0;
    }

    .goback:active{
        margin-right: 1rem;
        background-color: transparent !important;
        color: #000 !important;
        border: 0;
    }

   .form-select option{
       padding-left:1rem;
   }
   option:hover {
  background-color: red;
}
</style>

<section class="desktop">
  <div class="contact-bg">
      <img src="{{ $actual_url . '/front/img/contact/ContactUs.webp' }}"/>
  </div>
</section>
<section class="mobile">
  <div class="contact-bg">
      <img src="{{ $actual_url . '/front/img/contact/contact-mobile.webp' }}"/>
  </div>
</section>


<section>
  <div class="container">
      <h3 class="all-title text-center">CONTACT US</h3>
      <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6 contact-address">
              <div class="faqs my-2">
                  <details open name="faq" onclick="updateImage('phoenix-palladium')">
                      <summary>Phoenix Palladium, Mumbai</summary>
                      <p class="content">
                          G-7. Ground Floor, Phoenix Palladium, 462, Senapati Bapat Marg. Lower Parel. Mumbai,
                          Maharashtra 400013.<br>
                          <a href="https://maps.app.goo.gl/4jGqJ9xGFYjXtUct6" target="_blank"><b>Open in Google Maps</b></a>
                          <br><br>
                          Contact:<a href="tel:+918269786786">&nbsp;+918269786786</a>
                          <br>
                          E-mail: <a href="mailto:info@jayswatchstore.com">&nbsp;info@jayswatchstore.com</a>
                          <br><br>
                          Store Timings:
                          <br>
                          Monday - Sunday | 10:30 AM - 09:30 PM
                      </p>

                  </details>
                  <details name="faq" onclick="updateImage('bandra-west')">
                      <summary>Bandra West, Mumbai</summary>
                      <p class="content">
                          Muzaffar Manor, Plot No. 116/117, near Waterfield Road, Bandra West Mumbai, Maharashtra
                          400050<br>
                          <a href="https://maps.app.goo.gl/v4Pov88FoikwnzvX6" target="_blank"><b>Open in Google Maps</b></a>
                          <br><br>
                          Contact:<a href="tel:+919321387684">&nbsp;+919321387684</a>
                          <br>
                          E-mail: <a href="mailto:infobandra@jayswatchstore.com">&nbsp;infobandra@jayswatchstore.com</a>
                          <br><br>
                          Store Timings:
                          <br>
                          Monday - Sunday | 11:00 AM - 07:00 PM
                      </p>

                  </details>
                  <details name="faq" onclick="updateImage('palladium-ahmedabad')">
                      <summary>Palladium, Ahmedabad </summary>
                      <p class="content">
                          F-29, First Floor, Palladium Ahmedabad, near, Sarkhej - Gandhinagar Hwy, Thaltej,
                          Ahmedabad,Gujarat 380054<br>
                           <a href="https://maps.app.goo.gl/rWdXAVsifcRHVgD2A" target="_blank"><b>Open in Google Maps</b></a>
                          <br><br>
                           Contact:<a href="tel:+917990590199">&nbsp;+917990590199</a>

                          <br>
                          E-mail: <a href="mailto:infoahmedabad@jayswatchstore.com">&nbsp;infoahmedabad@jayswatchstore.com</a>
                          <br><br>
                          Store Timings:
                          <br>
                          Monday - Sunday | 10:30 AM - 09:30 PM
                      </p>

                  </details>
                  <details name="faq" onclick="updateImage('bangaluru')">
                      <summary>Phoenix Mall Of Asia, Bengaluru </summary>
                      <p class="content">
                          F-34 Phoenix Mall of Asia, Yelahanka Taluk, Bellary Road, Bengaluru, Karnataka 560092<br>
                          <a href="https://maps.app.goo.gl/oVpJJiAwBKHXFV8w8" target="_blank"><b>Open in Google Maps</b></a>
                          <br><br>
                          Contact:<a href="tel:+918618186597">&nbsp;+918618186597</a>
                          <br>
                          E-mail: <a href="mailto:infobengaluru@jayswatchstore.com">&nbsp;infobengaluru@jayswatchstore.com</a>

                          <br><br>
                          Store Timings:
                          <br>
                          Monday - Sunday | 10:30 AM - 09:30 PM
                      </p>
                  </details>
              </div>
          </div>

          <!--<div class="col-lg-6 col-md-6 col-sm map">-->
          <!--    <iframe id="mapFrame"-->
          <!--        src="{{ $actual_url . '/front/img/contact/DMumbai.jpg' }}"-->
          <!--        width="600" height="450" style="border:0;" class="contact-map1 w-100" allowfullscreen=""-->
          <!--        loading="lazy" referrerpolicy="no-referrer-when-downgrade">-->
          <!--    </iframe>-->
          <!--</div>-->

          <div class="col-lg-6 col-md-6 col-sm map">
              <!-- <iframe id="mapFrame" src="https://placehold.co/800?text=Hello+World&font=roboto" width="600"
                  height="450" style="border:0;" class="contact-map1 w-100" allowfullscreen="" loading="lazy"
                  referrerpolicy="no-referrer-when-downgrade">
              </iframe> -->
              <div class="contact-map1">
                  <img id="mapFrame" src="{{ $actual_url . '/front/img/contact/DMumbai.jpg' }}" alt="Map Location">
              </div>
          </div>


      </div>
  </div>
</section>



<!-------------contact-Form-------------------  -->

<!--<section style="display:none;">-->
<!--  <div class="container">-->
<!--      <h3 class="text-center all-title">GET IN TOUCH.</h3>-->

      <!--<form class="contact-form row row-margin" >-->
      <!--    @csrf-->
      <!--    <div class="form-field col-lg-7 col-md-7 col-sm-7 mx-auto">-->
      <!--        <input id="userName" name="userName" class="input-text js-input" type="text" >-->
      <!--        <label class="label" for="name">Name</label>-->
      <!--        <br>-->
      <!--        <span class="error" id="userName_error" style="color:red;"></span>-->
      <!--    </div>-->
      <!--    <div class="form-field col-lg-7 col-md-7 col-sm-7 mx-auto">-->
      <!--        <input id="userEmail" name="userEmail" class="input-text js-input" type="email" >-->
      <!--        <label class="label" for="email">E-mail</label>-->
      <!--        <br>-->
      <!--        <span class="error" id="userEmail_error" style="color:red;"></span>-->
      <!--    </div>-->
      <!--    <div class="form-field col-lg-7 col-md-7 col-sm-7 mx-auto">-->
      <!--        <input id="userPhone" name="userPhone" class="input-text js-input" type="number" >-->
      <!--        <label class="label" for="number">Phone Number</label>-->
      <!--        <br>-->
      <!--        <span class="error" id="userPhone_error" style="color:red;"></span>-->
      <!--    </div>-->
          <!--<div class="form-field col-lg-7 col-md-7 col-sm-7 mx-auto">-->
          <!--    <input id="userMessage" name="userMessage" class="input-text js-input" type="text" >-->
          <!--    <label class="label" for="message">Message</label>-->
          <!--    <br>-->
          <!--    <span class="error" id="userMessage_error" style="color:red;"></span>-->
          <!--</div>-->
      <!--    <div class="form-field col-lg-7 col-md-7 col-sm-7 text-end mx-auto">-->
      <!--        <input class="submit-btn px-4 py-2 rounded-4 border-0 text-dark" type="button" id="contactbutton" onclick="contactform()" value="Send">-->
      <!--    </div>-->
      <!--</form>-->
<!--        <div id="contactformMessgaeDiv" style="color: green;font-size: 18px;">-->
<!--            <div id="form-status"></div>-->
<!--        </div>-->
<!--  </div>-->
<!--</section>-->

    <!-------------contact-Form-------------------  -->

    <section class="col-lg-7 contact-section">
        <div class="container">
            <!-- Step 1 -->
            <div id="step1">
                <form  id="contact-form-data">
                    @csrf
                    <!--<p class="ttttsss11 form-contact mb-0">Send a message</p>-->
                    <h3 class="mb-1 ttttsss">GET IN TOUCH</h3>

                    <!--<p class="text-center mb-5">We’re here to make every moment count. <br>Have questions about our timepieces, need assistance, or want to explore the world of luxury watches? <br>Our team is here to help. </p>-->
                    <p class="text-center mb-5">Have questions or need assistance with our luxury timepieces? <br>We’re here to help. </p>
                    <div class="mb-3">
                        <textarea class="form-control contact-textarea p-5" name="userMessage" id="userMessage" rows="6"
                            placeholder="Enter your message"></textarea>
                            <br>
                            <span class="error" id="userMessage_error" style="color:red;"></span>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn  px-4 contact-button" onclick="goToNext()">Next&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></button>
                    </div>

            </div>
            <!-- Step 2 -->

            <div id="step2" style="display: none;">
                <button type="button" class="btn btn-secondary  px-4 goback" onclick="goBack()"><i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;&nbsp;Back</button>
                <!--<p class="ttttsss11 form-contact mb-0">Send a message</p>-->
                <h1 class="mb-5 ttttsss">contact information</h1>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <select class="form-select contact-in" id="title" name="title"  style="padding-right:2rem;">
                            <option value="" selected disabled>Title</option>
                            <option value="Mr">Mr</option>
                            <option value="Ms">Ms</option>
                        </select>
                         <br>
                        <span class="error" id="title_error" style="color:red;"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="firstName" class="form-label">First name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control contact-in" name="firstName" id="firstName" >
                        <br>
                        <span class="error" id="firstName_error" style="color:red;"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="lastName" class="form-label">Last name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control contact-in" name="lastName" id="lastName" >
                        <br>
                        <span class="error" id="lastName_error" style="color:red;"></span>
                    </div>
                    <div class="col-md-12 mt-4">
                        <label for="email" class="form-label">Email address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control contact-in" id="userEmail" name="userEmail">
                        <br>
                        <span class="error" id="userEmail_error" style="color:red;"></span>
                    </div>
                    <!--<div class="col-md-12 mt-4">-->
                    <!--    <label for="">and/or</label>-->
                    <!--</div>-->

                    <div class="col-md-2 mt-4">
                        <label for="phone" class="form-label">Code.. <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control contact-in" id="phone_code" name="phone_code" value="+91">
                        <br>
                        <span class="error" id="phone_code_error" style="color:red;"></span>
                    </div>
                    <div class="col-md-10 mt-4">
                        <label for="phone" class="form-label">Phone number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control contact-in" name="userPhone" id="userPhone">
                        <br>
                        <span class="error" id="userPhone_error" style="color:red;"></span>
                    </div>

                    <div class="col-md-12 mt-4">
                        <label for="country" class="form-label">Country of residence <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control contact-in" id="country" name="country" value="India">
                        <br>
                        <span class="error" id="country_error" style="color:red;"></span>
                    </div>
                    <div class="col-md-12 mt-4">
                        <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                        <input type="text" class="form-control contact-in" id="city" name="city" value="Mumbai">
                        <br>
                        <span class="error" id="city_error" style="color:red;"></span>
                    </div>

                    <div class="col-md-12 mt-4">
                        <label for="title" class="form-label">Nearest Store <span class="text-danger">*</span></label>
                        <select class="form-select contact-in" id="store_name" name="store_name" style="padding-right:2rem;">
                            <option value="" selected disabled>Select Your Nearest Store</option>
                            <option value="Phoenix Palladium, Mumbai">Phoenix Palladium, Mumbai</option>
                            <option value="Bandra West, Mumbai">Bandra West, Mumbai</option>
                            <option value="Palladium, Ahmedabad">Palladium, Ahmedabad</option>
                            <option value="Phoenix Mall Of Asia, Bengaluru">Phoenix Mall Of Asia, Bengaluru</option>
                        </select>
                        <br>
                        <span class="error" id="store_name_error" style="color:red;"></span>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <label for="">*Mandatory information</label>
                    <div class="form-check mt-3">
                        <input class="form-check-input check-box" type="checkbox" value="" id="terms" name="terms">
                        <!-- <input class="form-check-input check-box" type="checkbox" id="terms" required> -->
                        <label class="form-check-label check-main" for="terms">
                            I have read and accepted the <a href="#" class="check-txt">terms and conditions</a> and
                            <a href="#" class="check-txt">privacy
                                policy</a>.
                        </label>
                    </div>
                    <br>
                    <span class="error" id="terms_error" style="color:red;"></span>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <button type="button" class="btn contact-button px-4" id="contactbutton" onclick="contactform()">Send</button>
                </div>
            </div>


            <!-- Step 3 -->

            <div id="step3" style="display: none;">
                <!--<p class="ttttsss11 form-contact mb-0">Send a message</p>-->
                <h1 class="mb-3 ttttsss">Thank you for sharing your details!</h1>

                <p class="text-center"></p>

                <p class="text-center mb-5">Your message has been successfully sent to the Jay’s Watch Store Team<br> One of our sales advisors will be reviewing your request and responding as soon as possible.</p>
                <!--<p class="text-center mb-5">Thank you for your message. Our sales advisor will get in touch with you shortly.</p>-->
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-dark px-4" onclick="completeForm()">Done</button>
                </div>
            </div>
            </form>

        </div>



    </section>
<script>
    // const step1 = document.getElementById('step1');
    // const step2 = document.getElementById('step2');
    // const step3 = document.getElementById('step3');

    // function goToNext() {
    //     step1.style.display = 'none';
    //     step2.style.display = 'block';
    // }

    // function goBack() {
    //     step2.style.display = 'none';
    //     step1.style.display = 'block';
    // }

    // function completeForm() {
    //     step3.style.display = 'none';
    // }

    // -----------------contact-us-form--------------

    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const step3 = document.getElementById('step3');

    // function goToNext() {
    //     step1.style.display = 'none';
    //     step2.style.display = 'block';
    // }

    function goBack() {
        step2.style.display = 'none';
        step1.style.display = 'block';
    }
    function lastPage(event) {
        event.preventDefault();
        step2.style.display = 'none';
        step3.style.display = 'block';
    }


    // function completeForm() {
    //     step3.style.display = 'none';
    // }
    function completeForm() {
        window.location.reload()
        // step3.style.display = 'none';
        // step1.style.display = 'block';
    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>

    function goToNext(){
        var error = false;
        var userMessage = $('#userMessage').val();

        if (userMessage.length == 0) {
            var error = true;
            $('#userMessage_error').fadeIn(500);
            $('#userMessage_error').html('Message is required');
        } else {
            $('#userMessage_error').fadeOut(500);
        }


        if (!error) {
            step1.style.display = 'none';
            step2.style.display = 'block';
        }

    }
     function contactform() {
            //event.preventDefault();

            var error = false;
            var title = $('#title').val();
            var firstName = $('#firstName').val();
            var lastName = $('#lastName').val();
            var email = $('#userEmail').val();
            var phone_code = $('#phone_code').val();
            var phonenum = $('#userPhone').val();

            var country = $('#country').val();
            var city = $('#city').val();
            var store_name = $('#store_name').val();
            //var terms = $('#terms').val();

            // alert(phonenum);


            if (title==null) {
                var error = true;
                $('#title_error').fadeIn(500);
                $('#title_error').html('Title is required');
            } else {
                $('#title_error').fadeOut(500);
            }


            if (firstName.length == 0) {
                var error = true;
                $('#firstName_error').fadeIn(500);
                $('#firstName_error').html('First Name is required');
            } else {
                $('#firstName_error').fadeOut(500);
            }

            if (lastName.length == 0) {
                var error = true;
                $('#lastName_error').fadeIn(500);
                $('#lastName_error').html('Last Name is required');
            } else {
                $('#lastName_error').fadeOut(500);
            }

            if (phone_code.length == 0) {
                var error = true;
                $('#phone_code_error').fadeIn(500);
                $('#phone_code_error').html('Phone Code Name is required');
            } else {
                $('#phone_code_error').fadeOut(500);
            }

            // if (phonenum=="") {
            //     var error = true;
            //     $('#userPhone_error').fadeIn(500);
            //     $('#userPhone_error').html('Mobile number is required');
            // } else

            if(isNaN(phonenum)){
                var error = true;
                $('#userPhone_error').fadeIn(500);
                $('#userPhone_error').html('Mobile number must be  digit');

            }else if (phonenum.length != 10) {
                var error = true;
                $('#userPhone_error').fadeIn(500);
                $('#userPhone_error').html('Mobile number must be in 10 digit');
            } else {
                $('#userPhone_error').fadeOut(500);
            }

            if (email.length == 0 || email.indexOf('@') == '-1') {
                var error = true;
                $('#userEmail_error').fadeIn(500);
                $('#userEmail_error').html('Email address is required in email format');
            } else {
                $('#userEmail_error').fadeOut(500);
            }

            if (country.length == 0) {
                var error = true;
                $('#country_error').fadeIn(500);
                $('#country_error').html('Country of residence is required');
            } else {
                $('#country_error').fadeOut(500);
            }

            if (city.length == 0) {
                var error = true;
                $('#city_error').fadeIn(500);
                $('#city_error').html('City is required');
            } else {
                $('#city_error').fadeOut(500);
            }

            if (store_name==null) {
                var error = true;
                $('#store_name_error').fadeIn(500);
                $('#store_name_error').html('Store Name is required');
            } else {
                $('#store_name_error').fadeOut(500);
            }

            if($("#terms").prop('checked') == false){
                var error = true;
                $('#terms_error').fadeIn(500);
                $('#terms_error').html('Accept Terms and conditions and privacy policy.');
            }else {
                $('#terms_error').fadeOut(500);
            }

            // if (terms=="") {
            //     var error = true;
            //     $('#terms_error').fadeIn(500);
            //     $('#terms_error').html('Accept Terms and conditions and privacy policy.');
            // } else {
            //     $('#terms_error').fadeOut(500);
            // }


            if (!error) {


                var formData = new FormData($('#contact-form-data')[0]);
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{route('addContact_us')}}",
                    type: "POST",
                    data: formData,
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        setTimeout(function () {
                            $("#contactbutton").hide();
                        }, 1000);
                    },
                    success: function (result) {
                        console.log(result);
                        if (result) {
                            // $('#contactformMessgaeDiv').show();
                            // $('#form-status').text(
                            //     'Thank You for Your Message. Our representative will call you shortly.');
                            // setTimeout(function () {
                            //     $('#contactformMessgaeDiv').hide();
                            //     $("#form-status").hide();
                            // }, 4000);

                            setTimeout(function () {
                                step2.style.display = 'none';
                                step3.style.display = 'block';
                            }, 4000);


                        } else {

                        }
                    }
                });
            }

        }
    </script>
    @include('frontend.partials.footer')

    @include('frontend.partials.footer_link')


</body>

</html>
