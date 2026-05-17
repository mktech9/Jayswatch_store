      @php
          $subtotal = $order->subtotal ?? 0;
          $tcsValue = $order->tcs ?? 0;
          $total = $order->total ?? 0;
          $grandtotal = $order->grand_total ?? 0;
          $remainamount = $grandtotal - $total;

          // Default tax
          $taxAmount = 0;

          if (!empty($tcsValue)) {
              if (strtolower($order->shipping_citizen_type) === 'indian') {
                  $taxAmount = $tcsValue; // 1%
              } else {
                  $taxAmount = $tcsValue; // 5%
              }
          }
      @endphp

      @php
          // Convert order_date to Carbon instance and add 3 days
          use Carbon\Carbon;

          $estimatedDelivery = Carbon::parse($order->order_date)->addDays(5)->format('l, F d, Y');
      @endphp
      <!DOCTYPE html>
      <html lang="en">


      <title>Order Confirmed | Jay\'s Watch Store</title>

      @include('frontend.partials.header_link')

      <body>



          @include('frontend.partials.header')
          <style>
              /* ===== Static Order Confirmation (scoped) ===== */
              .jw-confirm {
                  --ink: #111;
                  --muted: #6b7280;
                  --line: #e5e7eb;
                  --night: #0f1420;
                  --bg: #f8f9fb;
                  text-align: center;
              }

              .jw-confirm .wrap {
                  max-width: 1100px;
                  margin: 60px auto;
                  padding: 0 16px;
              }

              /* ===== H1 custom font & responsive ===== */
              .jw-confirm .title {
                  font-size: 40px;
                  font-weight: 400;
                  margin: 0 0 24px;
                  font-family: 'aguila-thin', sans-serif;
                  line-height: 1.2;
              }

              @media(max-width:768px) {
                  .jw-confirm .title {
                      font-size: 32px;
                  }

                  .jw-confirm .tile {
                      width: 100%;
                  }
              }

              @media(max-width:480px) {
                  .jw-confirm .title {
                      font-size: 26px;
                  }

                  .jw-confirm .tile {
                      width: 100% !important;
                  }
              }

              .jw-confirm .lead {
                  color: var(--muted);
                  margin: 0
              }

              .jw-confirm .banner {
                  border: 1px solid var(--line);
                  border-radius: 0px !important;
                  padding: 24px;
                  background: #fff;
                  margin-bottom: 24px
              }

              .jw-confirm .check {
                  width: 64px;
                  height: 64px;

                  background: #eaf7ed;
                  display: flex;
                  align-items: center;
                  justify-content: center;
                  margin: 0 auto 10px
              }

              .jw-confirm .check svg {
                  width: 30px;
                  height: 30px
              }

              .jw-confirm .badge {
                  font-size: 13px;
                  font-weight: 500;
                  padding: 6px 12px;
                  border-radius: 0px !important;
                  background: #eef2ff;
                  color: #3730a3;
                  display: inline-block;
                  margin-top: 10px
              }

              /* Tiles container */
              .jw-confirm .info-tiles {
                  display: flex;
                  justify-content: center;
                  gap: 12px;
                  flex-wrap: wrap;
                  margin-top: 18px
              }

              .jw-confirm .tile {
                  border: 1px solid var(--line);
                  border-radius: 0px !important;
                  padding: 14px;
                  display: flex;
                  align-items: center;
                  gap: 12px;
                  background: #fff;
                  min-width: 260px;
                  width: 49%;
                  text-align: left
              }

              .jw-confirm .tile .icon {
                  width: 34px;
                  height: 34px;
                  display: flex;
                  align-items: center;
                  justify-content: center;
                  border-radius: 8px;
                  background: #f3f4f6;
                  font-size: 18px
              }

              /* ===== One section: items + summary ===== */
              .jw-confirm .order-section {
                  border: 1px solid var(--line);
                  border-radius: 0px !important;
                  background: #fff;
                  overflow: hidden;
                  text-align: left;
              }

              .jw-confirm .order-grid {
                  display: grid;
                  grid-template-columns: 1fr;
                  gap: 0
              }

              @media(min-width:992px) {
                  .jw-confirm .order-grid {
                      grid-template-columns: 1fr 360px
                  }
              }

              .jw-confirm .items {
                  padding: 16px
              }

              .jw-confirm .item {
                  display: flex;
                  gap: 14px;
                  align-items: center;
                  padding: 14px 2px;
                  border-bottom: 1px solid var(--line) !important;
              }

              .jw-confirm .item:first-child {
                  border-top: 0
              }

              .jw-confirm .thumb {
                  width: 72px;
                  height: 72px;
                  border-radius: 0px !important;
                  object-fit: cover;
                  border: 1px solid var(--line);
                  background: #fff
              }

              .jw-confirm .meta .brand {
                  font-size: 12px;
                  color: var(--muted)
              }

              .jw-confirm .meta .name {
                  font-size: 16px;
                  margin-top: 2px
              }

              .jw-confirm .meta .qty {
                  font-size: 12px;
                  color: var(--muted);
                  margin-top: 4px
              }

              .jw-confirm .price {
                  margin-left: auto;
                  font-weight: 500
              }

              /* summary */
              .jw-confirm .summary {
                  border-left: 1px solid var(--line)
              }

              @media(max-width:991.98px) {
                  .jw-confirm .summary {
                      border-left: 0;
                      border-top: 1px solid var(--line)
                  }
              }

              .jw-confirm .summary-inner {
                  padding: 16px
              }

              .jw-confirm .summary h4 {
                  margin: 0 0 12px;
                  font-weight: 500
              }

              .jw-confirm .line {
                  display: flex;
                  justify-content: space-between;
                  margin: 8px 0;
                  color: var(--ink)
              }

              .jw-confirm .muted {
                  color: var(--muted)
              }

              .jw-confirm .div {
                  height: 1px;
                  background: var(--line);
                  margin: 12px 0
              }

              .jw-confirm .total {
                  font-size: 18px;
                  font-weight: 700;
                  display: block;
              }

              /* other sections */
              .jw-confirm .card {
                  border: 1px solid var(--line) !important;
                  border-radius: 0px !important;
                  background: #fff;
                  margin: 20px 0 24px !important;
                  text-align: left
              }

              .jw-confirm .card-body {
                  padding: 18px
              }

              .jw-confirm .next {
                  background: #e3e3e3;
                  color: #000;

                  padding: 18px;
                  text-align: left;
                  margin: 20px 0 24px
              }

              .jw-confirm .next h3 {
                  margin: 0 0 8px
              }

              .jw-confirm .next ul {
                  margin: 8px 0 0;
                  padding-left: 20px
              }

              .jw-confirm .next ul li {
                  list-style: circle !important
              }

              .jw-confirm .actions {
                  display: flex;
                  gap: 10px;
                  flex-wrap: wrap;
                  justify-content: center;
                  margin-top: 18px
              }

              .jw-confirm .btn {
                  display: inline-flex;
                  align-items: center;
                  justify-content: center;
                  gap: 8px;
                  padding: 12px 16px;

                  border: 1px solid var(--line);
                  background: #fff;
                  color: #111;
                  text-decoration: none;
                  font-weight: 500
              }

              .jw-confirm .btn:hover {
                  background: #000;
                  color: #fff !important
              }
          </style>

          <div class="jw-confirm">
              <div class="wrap">
                  <!-- Banner -->
                  <div class="banner">
                      <div class="check" aria-hidden="true">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                              <path
                                  d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20Zm-1.1-6.6 6-6a1 1 0 1 0-1.4-1.4l-5.3 5.29-2.1-2.09a1 1 0 1 0-1.4 1.41l2.8 2.79a1 1 0 0 0 1.4 0Z" />
                          </svg>
                      </div>
                      <h1 class="title">Order Confirmed!</h1>
                      <p class="lead">Thank you for your purchase from Jay's Watch Store.</p>
                      <div><span class="badge">Order Number: {{ $order_id }}</span></div>

                      <!-- Info Tiles -->
                      <div class="info-tiles">
                          <div class="tile">
                              <div class="bg-blue-100 p-3 rounded-lg" aria-hidden="true"
                                  style="background: #DBEAFE;"><svg
                                      xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                      viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                      stroke-linecap="round" stroke-linejoin="round"
                                      class="lucide lucide-mail w-6 h-6 text-blue-600" aria-hidden="true">
                                      <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                                      <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                  </svg></div>
                              <div>
                                  <div class="muted" style="font-weight:500;">Confirmation Email Sent</div>
                                  @if ($order)
                                      <div class="muted">We've sent a confirmation email to
                                          <strong>{{ $order->shipping_email }}</strong> with your order details.</div>
                                  @endif
                              </div>
                          </div>
                          <div class="tile">
                              <div class="bg-purple-100 p-3 rounded-lg" aria-hidden="true"
                                  style="background: #F3E8FF;"><svg
                                      xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                      viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                      stroke-linecap="round" stroke-linejoin="round"
                                      class="lucide lucide-package w-6 h-6 text-purple-600" aria-hidden="true">
                                      <path
                                          d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z">
                                      </path>
                                      <path d="M12 22V12"></path>
                                      <polyline points="3.29 7 12 12 20.71 7"></polyline>
                                      <path d="m7.5 4.27 9 5.15"></path>
                                  </svg></div>
                              <div>
                                  <div class="muted" style="font-weight:500;">Estimated Delivery</div>
                                  <div class="muted">{{ $estimatedDelivery }}</div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- ONE SECTION: Order Items + Order Summary -->
                  <section class="order-section" aria-label="Order details">
                      <div class="order-grid">
                          <!-- Left column: Items -->
                          <div class="items">
                              @foreach ($orderItems as $item)
                                  @php
                                    //   $brand_name = $item->brand_name ?? '';
                                    //   $pro_name = urldecode($item->product_name ?? '');
                                    //   $pro_name = preg_replace('/\s+/', '_', $pro_name);
                                    //   $pro_name = preg_replace('/[^\w\-\.\(\)&]/', '', $pro_name);

                                          $brand_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->brand_name ?? '');
                                      $pro_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->product_name ?? '');

                                  @endphp
                                  <div class="item">
                                      <a
                                          href="{{ url('product/' . \Illuminate\Support\Str::slug($item->brand_name) . '/' . \Illuminate\Support\Str::slug($item->product_name)) }}">
                                          <img class="thumb"
                                              src="{{ $actual_url . '/admin_assets/brand/' . $brand_name . '/' . $pro_name . '/image/' . $item->product_image }}"
                                              alt="{{ $item->brand_name }} {{ $item->product_name }}" width="72"
                                              height="72" loading="eager" decoding="async">
                                      </a>
                                      <div class="meta">
                                          <div class="brand">{{ $item->brand_name ?? 'Unknown Brand' }}</div>
                                          <div class="name">{{ $item->product_name }}</div>
                                          <div class="qty">Quantity: 1</div>
                                      </div>
                                      <div class="price">₹{{ indian_number_format($item->price, 2) }}</div>
                                  </div>
                              @endforeach
                          </div>

                          <!-- Right column: Summary -->


                          <aside class="summary">
                              <div class="summary-inner">
                                  <h4>Order Summary</h4>

                                  <div class="line">
                                      <span class="muted">Subtotal</span>
                                      <span>₹{{ indian_number_format($subtotal, 2) }}</span>
                                  </div>

                                  <div class="line">
                                      <span class="muted">TCS</span>
                                      <span>₹{{ indian_number_format($taxAmount, 2) }}</span>
                                  </div>

                                  <div class="line">
                                      <span class="muted">Shipping</span>
                                      <span>FREE</span>
                                  </div>

                                  <div class="div"></div>

                                  <div class="line total">
                                      @if ($order->payment_method == 'prebook')
                                          <span>Total Amount</span>
                                          <span>₹{{ indian_number_format($grandtotal, 2) }}</span>
                                          <br>
                                          <span>Total Paid: </span>
                                          <span>₹{{ indian_number_format($total, 2) }}</span>
                                          <br>
                                          <span>Remaining Amount: </span>
                                          <span>₹{{ indian_number_format($remainamount, 2) }}</span>
                                      @else
                                          <span>Total</span>
                                          <span>₹{{ indian_number_format($grandtotal, 2) }}</span>
                                      @endif

                                  </div>
                              </div>
                          </aside>
                      </div>
                  </section>

                  <!-- Shipping Address -->
                  <div class="card">
                      <div class="card-body">
                          <div class="muted" style="font-size:13px;margin-bottom:8px">Shipping Address</div>
                          <div>
                              <div><strong>{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}</strong>
                              </div>

                              @if (!empty($order->shipping_address))
                                  <div>{{ $order->shipping_address }}</div>
                              @endif

                              @php
                                  $cityLine = trim(
                                      $order->shipping_city .
                                          ', ' .
                                          $order->shipping_state .
                                          ' ' .
                                          $order->shipping_zip,
                                  );
                              @endphp
                              @if (!empty($cityLine))
                                  <div>{{ $cityLine }}</div>
                              @endif

                              @if (!empty($order->shipping_country))
                                  <div>{{ $order->shipping_country }}</div>
                              @endif

                              @if (!empty($order->shipping_phone))
                                  <div class="muted">Phone: {{ $order->shipping_phone }}</div>
                              @endif

                              @if (!empty($order->shipping_email))
                                  <div class="muted">Email: {{ $order->shipping_email }}</div>
                              @endif
                          </div>
                      </div>
                  </div>
                  @if ($order->payment_method == 'prebook')
                      <div id="prebook-terms" class="mt-2">
                          <div
                              style="
        border:2px solid #212529;

        padding:20px;

    ">
                              <h5 style="color:#212529; font-weight:700; margin-bottom:15px;">
                                  Terms & Conditions for Advance Booking
                              </h5>

                              <div style="font-size:14px; line-height:1.6; color:#212529;text-align: left;">

                                  <p style="margin-bottom:8px;">
                                      <span style="color:#212529; font-weight:bold;">•</span>
                                      The selected watch will be kept on hold for <strong>48 hours</strong> from the
                                      time of advance payment.
                                  </p>

                                  <p style="margin-bottom:8px;">
                                      <span style="color:#212529; font-weight:bold;">•</span>
                                      To complete the remaining payment or for any queries, please contact us at
                                      <strong>tech@jayswatchstore.com</strong> or call us at<strong>+91
                                          8591187684</strong>.
                                  </p>

                                  <p style="margin-bottom:0;">
                                      <span style="color:#212529; font-weight:bold;">•</span>
                                      If there is no response from the customer or the remaining payment is not
                                      completed within
                                      <strong>48 hours</strong>, the advance amount will be refunded and the watch will
                                      be released back for sale.
                                  </p>

                              </div>
                          </div>
                      </div>
                  @endif

                  <!-- What Happens Next -->
                  <div class="next">
                      <h3>What Happens Next?</h3>
                      <ul>
                          <li><strong>Authentication Verification:</strong> Our experts will perform final
                              authentication checks on your watch.</li>
                          <li><strong>Secure Packaging:</strong> Your watch will be carefully packaged with certificates
                              and documentation.</li>
                          <li><strong>Insured Shipping:</strong> Tracked and fully insured delivery to your address.
                          </li>
                      </ul>
                  </div>



                  <!-- Actions -->
                  <div class="actions">
                      <a class="btn" href="{{ route('product') }}">Continue Shopping</a>
                      <a class="btn btn-primary" target="_blank"
                          href="{{ route('invoice.print', ['order_id' => $order->order_id]) }}">
                          Download Invoice
                      </a>

                      @if (!empty($order->tracking_num))
                          <a class="btn btn-primary d-none" href="#" data-bs-toggle="modal"
                              data-bs-target="#trackModal">
                              Track Order
                          </a>

                          <!-- Modal -->
                          <div class="modal fade" id="trackModal" tabindex="-1" aria-labelledby="trackModalLabel"
                              aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                  <div class="modal-content rounded-3 shadow-lg">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="trackModalLabel">Track Your Shipment</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal"
                                              aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body text-center">
                                          <p class="mb-2">Your tracking number:</p>
                                          <h4 class="fw-bold" id="trackingNumber">{{ $order->tracking_num }}</h4>

                                          <div class="mt-3 d-flex justify-content-center gap-2">
                                              <button class="btn btn-outline-secondary" id="copyBtn">
                                                  Copy
                                              </button>
                                              <a href="https://book.bombax.in/Booking/Track" target="_blank"
                                                  class="btn btn-success">
                                                  Go to Website
                                              </a>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      @endif


                  </div>

                  <!-- Help -->
                  <div class="card" style="margin-top:24px;margin-bottom:40px">
                      <div class="card-body" style="text-align:center">
                          <div class="muted">Need help with your order?</div>
                          <div>Contact us at <a href="mailto:tech@jayswatchstore.com">tech@jayswatchstore.com</a> or
                              call +918269786786</div>
                      </div>
                  </div>
              </div>
          </div>

          @include('frontend.partials.footer')

          @include('frontend.partials.footer_link')


          <script>
              document.addEventListener('DOMContentLoaded', () => {
                  const copyBtn = document.getElementById('copyBtn');
                  const trackingNum = document.getElementById('trackingNumber');

                  if (copyBtn && trackingNum) {
                      copyBtn.addEventListener('click', () => {
                          navigator.clipboard.writeText(trackingNum.textContent.trim());
                          iziToast.success({
                              message: 'Tracking number copied!',
                              position: 'topRight'
                          });
                      });
                  }
              });
          </script>


          <script>
              document.addEventListener('DOMContentLoaded', () => {
                  sessionStorage.removeItem('cart');
                  updateCartUI();
              });
          </script>


      </body>

      </html>
