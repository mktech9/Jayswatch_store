
       <footer class="text-dark  ">
           <div class="container">
               <div class="row footer-row">
                   <div class="col-lg-2 col-md-3 mt-3">
                       <ul class="footer-ul">
                           <li class="mb-4"><a href="{{ route('home') }}" class="text-dark">HOME</a></li>
                           <li class="mb-4"><a href="{{ route('product') }}" class="text-dark">ALL WATCHES</a></li>
                           <li class="mb-4"><a href="{{ route('arrivals') }}" class="text-dark">NEW ARRIVALS</a></li>

                           <li class="mb-4"><a href="{{ route('blog') }}" class="text-dark">BLOG</a></li>
                           <li class="mb-4"><a href="{{ route('about') }}" class="text-dark">ABOUT US</a></li>
                           <li class="mb-4"><a href="{{ route('store') }}" class="text-dark">OUR STORE</a></li>


                       </ul>
                   </div>



                   <div class="col-lg-7 col-md-6 mt-3">
                       <ul class="footer-ul">
                           <li class="mb-3">
                               <strong class="addresstitle">
                                   <a href="{{ route('lower_parel_mumbai') }}" class="text-dark">PHOENIX PALLADIUM,
                                       MUMBAI</a>
                               </strong><br>
                               G-7, Ground Floor, Phoenix Palladium, 462, Senapati Bapat Marg, Lower Parel, Mumbai,
                               Maharashtra 400013
                           </li>
                           <li class="mb-3">
                               <strong class="addresstitle">
                                   <a href="{{ route('bandra_west_mumbai') }}" class="text-dark">BANDRA WEST,
                                       MUMBAI</a>
                               </strong><br>
                               Muzaffar Manor, Plot No. 116/117, near Waterfield Road, Bandra West Mumbai, Maharashtra
                               400050
                           </li>
                           <li class="mb-3">
                               <strong class="addresstitle">
                                   <a href="{{ route('ahmedabad_gujarat') }}" class="text-dark">PALLADIUM,
                                       AHMEDABAD</a>
                               </strong><br>
                               F-29, First Floor, Palladium Ahmedabad, near, Sarkhej - Gandhinagar Hwy, Thaltej,
                               Ahmedabad,
                               Gujarat 380054
                           </li>
                           <li class="mb-3">
                               <strong class="addresstitle">
                                   <a href="{{ route('bangalore_karnataka') }}" class="text-dark">PHOENIX MALL OF ASIA,
                                       BENGALURU</a>
                               </strong><br>
                               F-34 Phoenix Mall of Asia, Yelahanka Taluk, Bellary Road, Bengaluru, Karnataka 560092
                           </li>
                       </ul>
                   </div>


                   <div class="col-lg-3 col-md-3 mt-3">
                       <ul class="footer-ul">
                           <li class="mb-4"><a href="https://www.facebook.com/jayswatchstore" class="text-dark me-2"
                                   target="_blank">FACEBOOK</a></li>
                           <li class="mb-4"><a href="https://www.linkedin.com/company/jays-watch-store/"
                                   class="text-dark me-2" target="_blank">LINKEDIN</a></li>
                           <li class="mb-4"><a href="https://www.instagram.com/jayswatchstore/?hl=en"
                                   class="text-dark" target="_blank">INSTAGRAM</a></li>
                           <li class="mb-4">
                               <p class="mb-0">© <span id="currentYear"></span> JAY'S WATCH STORE</p>

                               <script>
                                   document.getElementById('currentYear').textContent = new Date().getFullYear();
                               </script>

                           </li>
                           <li class="mb-4"><a href="{{ route('terms_and_condtion') }}" class="text-dark">T&C
                                   APPLY</a> |
                               <a href="{{ route('privacy_policy') }}" class="text-dark">PRIVACY POLICY</a> | <br><a
                                   href="{{ route('terms_of_use') }}" class="text-dark">TERMS OF USE</a>
                           </li>
                       </ul>
                   </div>
               </div>
           </div>
       </footer>
<a href="https://wa.me/919999999999" class="floating-whatsapp" target="_blank">
    <img src="{{ $actual_url . '/admin_assets/whatsapp.svg' }}" alt="WhatsApp">
</a>
