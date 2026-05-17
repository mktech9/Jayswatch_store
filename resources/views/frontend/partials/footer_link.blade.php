  <script src="{{ $actual_url . '/front/js/jquery-3.7.1.min.js' }}"></script>
  <script src="{{ $actual_url . '/front/js/bootstrap.bundle.min.js' }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Select2 -->
  <script src="{{ $actual_url . '/admin_assets/js/select2.min.js' }}"></script>
  <script>
      function refreshCartPageAfterRemove(productId) {

          // If cart page is not loaded, do nothing
          if (!document.querySelector('#cart-section')) {
              return;
          }

          // Remove the item DOM card
          document.querySelectorAll('#cart-section .productid').forEach(el => {
              if (parseInt(el.textContent) === productId) {
                  el.closest('.card-jw').remove();
              }
          });

          // Recalculate subtotal
          let subtotal = 0;
          document.querySelectorAll('#cart-section .price').forEach(p => {
              let price = parseFloat(p.innerText.replace(/[₹,]/g, '').trim());
              subtotal += price;
          });

          // Update summary values
          if (document.getElementById('subtotal-value')) {
              document.getElementById('subtotal-value').innerText =
                  '₹' + subtotal.toLocaleString('en-IN', {
                      minimumFractionDigits: 2
                  });
          }

          if (document.getElementById('total-value')) {
              document.getElementById('total-value').innerText =
                  '₹' + subtotal.toLocaleString('en-IN', {
                      minimumFractionDigits: 2
                  });
          }

          // If cart becomes empty


          if (subtotal === 0) {
              document.querySelector('#cart-section').innerHTML = `
            <div class="text-center mt-3">
                <p>Your cart is empty.</p>
                <a class="continue d-inline-flex align-items-center mt-2" href="/product">
                    <i class="fa fa-chevron-left me-2"></i> Continue Shopping
                </a>
            </div>
        `;

              const summaryBox = document.querySelector('.summary');
              if (summaryBox) {
                  summaryBox.style.display = "none";
              }
          }
      }


      function refreshCheckoutPageAfterRemove(productId) {
          const checkoutSection = document.querySelector('#checkout-section');

          // If checkout not active, ignore
          if (!checkoutSection || checkoutSection.style.display === "none") return;

          // ----------------------------------------------------------
          // 1️⃣ Remove item from LEFT checkout product list
          // ----------------------------------------------------------
          checkoutSection.querySelectorAll('.productid').forEach(el => {
              if (parseInt(el.innerText) === productId) {
                  let card = el.closest('.card-jw');
                  if (card) card.remove();


              }
          });

          // ----------------------------------------------------------
          // 2️⃣ Remove from RIGHT SUMMARY block
          // ----------------------------------------------------------
          document.querySelectorAll('.order-items .productid').forEach(el => {
              if (parseInt(el.innerText) === productId) {
                  el.closest('.d-flex').remove();
              }
          });

          // ----------------------------------------------------------
          // 3️⃣ Remove from JS products ARRAY (important for TCS)
          // ----------------------------------------------------------
          if (window.products) {
              window.products = window.products.filter(p => parseInt(p.id) !== productId);
          }

          // ----------------------------------------------------------
          // 4️⃣ Recalculate Subtotal & Total
          // ----------------------------------------------------------
          let subtotal = 0;
          document.querySelectorAll('#cart-section .price').forEach(p => {
              let price = parseFloat(p.innerText.replace(/[₹,]/g, ""));
              subtotal += price;
          });

          document.getElementById('subtotal-value').innerText =
              `₹${subtotal.toLocaleString('en-IN', { minimumFractionDigits:2 })}`;

          document.getElementById('total-value').innerText =
              `₹${subtotal.toLocaleString('en-IN', { minimumFractionDigits:2 })}`;

          // ----------------------------------------------------------
          // 5️⃣ Re-trigger TCS calculation
          // ----------------------------------------------------------
          if (typeof updateTCS === 'function') {
              updateTCS();
          }

          // ----------------------------------------------------------
          // 6️⃣ If No products left → show empty page
          // ----------------------------------------------------------
          if (subtotal === 0) {
              checkoutSection.innerHTML = `
            <h3 class="text-center mt-3">Your cart is empty.</h3>
            <a href="/product" class="continue mt-3">
                <i class="fa fa-chevron-left"></i> Continue Shopping
            </a>
        `;
              document.querySelector('.summary').innerHTML = `
            <h4>Order Summary</h4>
            <p class="text-center mt-3">Your cart is empty.</p>
        `;
          }
      }


      function refreshOrderSummary() {
          const summaryContainer = document.querySelector(".order-items");
          summaryContainer.innerHTML = ""; // Clear old items

          document.querySelectorAll("#cart-section .card-jw").forEach(card => {
              let id = card.querySelector(".productid").innerText.trim();
              let brand = card.querySelector(".brand").innerText.trim();
              let name = card.querySelector(".name").innerText.trim();
              let img = card.querySelector("img.thumb").src;

              summaryContainer.innerHTML += `
            <div class="d-flex align-items-start gap-2">
                <img src="${img}" class="img-thumbnail" style="width: 60px; min-width: 60px; object-fit: cover;">
                <div>
                    <div class="productid d-none">${id}</div>
                    <div class="fw-bold">${brand}</div>
                    <div class="text-muted">${name}</div>
                </div>
            </div>
        `;
          });
      }

      function refreshTotalsSimple() {
          let subtotal = 0;

          // Read prices from visible cart-section (not summary)
          document.querySelectorAll("#cart-section .price").forEach(el => {
              let priceText = el.childNodes[0].nodeValue.trim();
              let price = parseFloat(priceText.replace(/[₹,]/g, ""));
              subtotal += price;
          });

          document.getElementById("subtotal-value").innerText =
              "₹" + subtotal.toLocaleString('en-IN', {
                  minimumFractionDigits: 2
              });

          document.getElementById("total-value").innerText =
              "₹" + subtotal.toLocaleString('en-IN', {
                  minimumFractionDigits: 2
              });
      }
  </script>
  <script>
      // ----------------------------
      // Update the cart UI badge
      // ----------------------------
      function updateCartUI() {
          let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
          document.querySelectorAll('.cart-badge').forEach(badge => {
              badge.textContent = cart.length;
          });
      }



      // Initial UI update on page load
      updateCartUI();

      // ----------------------------
      // Add to Cart button click
      // ----------------------------
      document.addEventListener('DOMContentLoaded', function() {
          let cart = JSON.parse(sessionStorage.getItem('cart')) || [];

          // ðŸŸ¢ Step 1: Update buttons on page load if already added
          document.querySelectorAll('.cart-btn').forEach(cartBtn => {
              let id = parseInt(cartBtn.dataset.id);
              let buyBtn = document.querySelector(`.buy-btn[data-id='${id}']`);

              if (cart.includes(id)) {
                  cartBtn.innerHTML = `<i class="fa fa-check me-2 text-success"></i> Added to Cart`;
                  cartBtn.disabled = true;
                  if (buyBtn) buyBtn.style.display = 'none'; // hide Buy Now button
              }
          });

          document.addEventListener('cartUpdated', function() { // ← MOVE THIS OUT
              if (typeof refreshCartPanel === 'function') {
                  refreshCartPanel();
              }
          });

          document.querySelectorAll('.cart-btn').forEach(cartBtn => {
              cartBtn.addEventListener('click', function() {
                  let id = parseInt(this.dataset.id);
                  let productName = this.dataset.productname;
                  let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
                  let buyBtn = document.querySelector(`.buy-btn[data-id='${id}']`);
                  const userId = "{{ session('user_id') ?? '' }}"; // get session user_id



                  // If already in cart
                  if (cart.includes(id)) {
                      this.innerHTML =
                          `<i class="fa fa-check me-2 text-success"></i> Added to Cart`;
                      this.disabled = true;
                      if (buyBtn) buyBtn.style.display = 'none';
                      return;
                  }

                  // Add item to sessionStorage cart
                  cart.push(id);
                  sessionStorage.setItem('cart', JSON.stringify(cart));


                  updateCartUI();


                  // Change Add to Cart button
                  this.innerHTML = `<i class="fa fa-check me-2 text-success"></i> Added to Cart`;
                  this.disabled = true;

                  // Hide Buy Now button
                  if (buyBtn) buyBtn.style.display = 'none';

                  // 🔒 If user is logged in, also add to DB
                  if (userId) {
                      fetch("{{ route('cart.add.db') }}", {
                              method: "POST",
                              headers: {
                                  "Content-Type": "application/json",
                                  "X-CSRF-TOKEN": document.querySelector(
                                      'meta[name="csrf-token"]').getAttribute("content")
                              },
                              body: JSON.stringify({
                                  product_id: id,
                                  user_id: userId
                              })
                          })
                          .then(response => response.json())
                          .then(data => {
                              if (data.status === 'success') {
                                  console.log(`✅ ${productName} added to DB cart.`);
                                  document.dispatchEvent(new Event('cartUpdated'));

                              }
                          })
                          .catch(err => console.error("DB insert error:", err));
                  }
              });
          });

      });








      document.addEventListener('click', function(e) {

          if (e.target.closest('.buy-btn')) {

              let btn = e.target.closest('.buy-btn');

              let id = parseInt(btn.dataset.id);
              let productName = btn.dataset.productname;

              // Save Buy Now product
              sessionStorage.setItem('buyNowId', id);

              // Trigger checkout
              const checkoutBtn = document.getElementById('modal-checkout-btn');

              if (checkoutBtn) {
                  checkoutBtn.click();
              } else {
                  window.location.href = "{{ route('custlogin-page') }}";
              }
          }

      });



      document.addEventListener('DOMContentLoaded', () => {
          document.querySelectorAll('.prebook-btn').forEach(btn => {
              btn.addEventListener('click', function() {
                  let id = parseInt(this.dataset.id);

                  // Keep session cart unchanged
                  let cart = JSON.parse(sessionStorage.getItem('cart')) || [];

                  // Save Buy Now product
                  sessionStorage.setItem('buyNowId', id);

                  // Mark as Prebook
                  sessionStorage.setItem('isPrebook', '1');

                  // Trigger checkout
                  const checkoutBtn = document.getElementById('modal-checkout-btn');
                  if (checkoutBtn) {
                      checkoutBtn.click();
                  } else {
                      window.location.href = "{{ route('custlogin-page') }}";
                  }
              });
          });
      });



      // ----------------------------
      // Cart icon click -> send data to backend
      // ----------------------------
      document.querySelectorAll('.cart-count').forEach(cartBtn => {
          cartBtn.addEventListener('click', function() {
              let cart = JSON.parse(sessionStorage.getItem('cart')) || [];

              $.ajax({
                  url: "{{ route('cart.show') }}",
                  type: "POST",
                  data: {
                      _token: "{{ csrf_token() }}",
                      products: cart
                  },
                  success: function() {
                      window.location.href = "{{ route('cart-page') }}";
                  },
                  error: function(xhr, status, error) {
                      console.error("Error:", error);
                  }
              });
          });
      });

      // ----------------------------
      // Stock out button click
      // ----------------------------
      document.querySelectorAll('.stock-out').forEach(button => {
          button.addEventListener('click', function() {
              const productName = this.dataset.productname || 'This product';

              iziToast.warning({
                  title: 'Out of Stock',
                  message: `${productName} is currently out of stock.`,
                  position: 'topRight',
                  backgroundColor: '#ffc107',
                  titleColor: '#000',
                  messageColor: '#000',
                  timeout: 4000,
              });
          });
      });
  </script>


  <script>
      document.querySelectorAll('.sidecartButton').forEach(btn => {
          btn.addEventListener('click', loadSideCart);
      });


      function loadSideCart() {

          const modalEl = document.getElementById('cartModal');
          const modalBody = modalEl.querySelector('.modal-body');
          const viewCartBtn = modalEl.querySelector('.cart-count');
          const checkoutBtn = modalEl.querySelector('.btn-success');
          const ACTUAL_URL = "{{ $actual_url }}";

          // Get modal instance
          const myModal = bootstrap.Modal.getOrCreateInstance(modalEl);

          // ✅ Show modal ONLY if not already visible
          if (!modalEl.classList.contains('show')) {
              myModal.show();
          }

          const cartData = sessionStorage.getItem('cart');

          // Empty cart
          if (!cartData || JSON.parse(cartData).length === 0) {
              modalBody.innerHTML = '<p class="text-center text-muted">Your cart is empty.</p>';
              viewCartBtn.style.display = 'none';
              checkoutBtn.style.display = 'none';
              return;
          }

          viewCartBtn.style.display = 'block';
          checkoutBtn.style.display = 'block';

          const productIds = JSON.parse(cartData);

          fetch("{{ route('get.cart.items') }}", {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json',
                      'X-CSRF-TOKEN': document
                          .querySelector('meta[name="csrf-token"]')
                          .getAttribute('content')
                  },
                  body: JSON.stringify({
                      cart: productIds
                  })
              })
              .then(res => res.json())
              .then(data => {
                  modalBody.innerHTML = '';

                  if (!data.length) {
                      modalBody.innerHTML = '<p class="text-center text-muted">Your cart is empty.</p>';
                      viewCartBtn.style.display = 'none';
                      checkoutBtn.style.display = 'none';
                      return;
                  }

                  let subtotal = 0;

                  data.forEach(item => {
                      subtotal += parseFloat(item.price);
                      let imagePath = item.pro_image ?
                          `${ACTUAL_URL}/admin_assets/brand/${item.brandfolder}/${item.productfolder}/image/${item.pro_image}` :
                          `${ACTUAL_URL}/front/noimage.jpg`;

                      modalBody.innerHTML += `
                <div class="d-flex align-items-center mb-3 card-jw">
                    <img src="${imagePath}" class="img-thumbnail" style="width:60px;">
                    <div class="ms-2 w-100">
                        <strong>${item.product_name}</strong><br>
                        <small>Brand: ${item.brand_name}</small><br>
                        <small>₹ ${Number(item.price).toLocaleString('en-IN')}</small>
                        <i class="fa fa-trash delete"
                           data-id="${item.pro_id}"
                           onclick="removeFromsideCart(this)"
                           style="cursor:pointer; float:right;"></i>
                    </div>
                </div>
                <hr>
            `;
                  });

                  modalBody.innerHTML += `
            <div class="fw-bold text-end me-2">
                Subtotal: ₹ ${subtotal.toLocaleString('en-IN')}
            </div>
        `;
              });
      }
  </script>


  <script>
      function removeFromsideCart(element) {
          let productId = parseInt(element.dataset.id);

          Swal.fire({
              title: 'Are you sure?',
              text: 'Do you want to remove this product from the cart?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes',
              cancelButtonText: 'No',
              reverseButtons: true
          }).then((result) => {
              if (result.isConfirmed) {
                  // --- Remove from browser sessionStorage ---
                  let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
                  cart = cart.filter(id => id !== productId);
                  sessionStorage.setItem('cart', JSON.stringify(cart));

                  // --- Update all cart badges ---
                  document.querySelectorAll('.cart-badge').forEach(badge => {
                      badge.textContent = cart.length;
                  });



                  // --- Remove from DB if user is logged in ---
                  fetch("{{ route('cart.remove') }}", {
                      method: "POST",
                      headers: {
                          "Content-Type": "application/json",
                          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                              'content')
                      },
                      body: JSON.stringify({
                          product_id: productId
                      })
                  }).catch(() => {
                      /* ignore guest or DB error silently */
                  });
                  // -------------------------------------------

                  Swal.fire({
                      title: 'Removed!',
                      text: 'Product removed from cart!',
                      icon: 'success',
                      timer: 2000,
                      showConfirmButton: false,
                      allowOutsideClick: false
                  });

                  // --- Refresh side cart modal content ---
                  if (typeof loadSideCart === 'function') {
                      loadSideCart();
                  }

                  refreshCartPageAfterRemove(productId);

                  refreshCheckoutPageAfterRemove(productId);

                  refreshOrderSummary();
                  refreshTotalsSimple();
                  rebuildProductsArray();
                  updateTCS();


              }
          });
      }


      function removeFromProfileCart(element) {
          let productId = parseInt(element.dataset.id);

          Swal.fire({
              title: 'Remove item?',
              text: 'This product will be removed from your cart.',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, remove it',
              cancelButtonText: 'Cancel',
              reverseButtons: true
          }).then((result) => {
              if (!result.isConfirmed) return;

              let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
              cart = cart.filter(id => parseInt(id) !== productId);
              sessionStorage.setItem('cart', JSON.stringify(cart));

              document.querySelectorAll('.cart-badge').forEach(badge => {
                  badge.textContent = cart.length;
              });

              fetch("{{ route('cart.remove') }}", {
                  method: "POST",
                  headers: {
                      "Content-Type": "application/json",
                      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                          .getAttribute('content')
                  },
                  body: JSON.stringify({
                      product_id: productId
                  })
              }).finally(() => {

                  // tell page to open cart after reload
                  sessionStorage.setItem('openCartPanel', '1');

                  // reload page
                  window.location.reload();
              });
          });
      }

      document.addEventListener('DOMContentLoaded', function() {
          if (sessionStorage.getItem('openCartPanel') === '1') {
              sessionStorage.removeItem('openCartPanel');

              const cartTabBtn = document.querySelector('[data-target="panel-cart"]');
              if (cartTabBtn) {
                  cartTabBtn.click();
              }
          }
      });
      document.getElementById('cartModal').addEventListener('hidden.bs.modal', function() {

          // Remove all backdrops (Bootstrap leaves extra when modal reloads)
          setTimeout(() => {
              document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
          }, 50);

          // Remove modal lock
          document.body.classList.remove('modal-open');

          // Force body scrolling enabled
          document.body.style.overflow = "auto";

          // Reset margin that Bootstrap adds when removing scrollbar
          document.body.style.paddingRight = "";
      });;


      document.getElementById('modal-checkout-btn').addEventListener('click', function() {
          let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
          let buyNowId = sessionStorage.getItem('buyNowId'); // Check if Buy Now was clicked

          // If Buy Now was used, only send that single product ID
          let productsToSend = buyNowId ? [parseInt(buyNowId)] : cart;

          $.ajax({
              url: "{{ route('sidecart.show') }}",
              type: "POST",
              data: {
                  _token: "{{ csrf_token() }}",
                  products: productsToSend
              },
              success: function() {
                  // Remove buyNowId after redirect (prevent reuse)
                  sessionStorage.removeItem('buyNowId');
                  window.location.href = "{{ route('cart-page') }}?auto_checkout=1";
              },
              error: function(xhr, status, error) {
                  console.error("Error:", error);
              }
          });
      });
  </script>


  <script>
      $(document).ready(function() {
          $("#searchInputMain").on("keyup", function() {
              let query = $(this).val().trim();
              const ACTUAL_URL = "{{ $actual_url }}";

              if (query.length > 0) { // Start search from first letter
                  $.ajax({
                      url: "{{ route('search') }}", // Blade renders the correct URL
                      type: "GET",
                      data: {
                          query: query
                      },
                      success: function(data) {
                          let resultsHtml = "<ul class='list-group'>";
                          if (data.length > 0) {
                              data.forEach(product => {
                                  let imagePath =
                                      `${ACTUAL_URL}/admin_assets/brand/` +
                                      `${product.brandfolder}/` +
                                      `${product.productfolder}/image/` +
                                      `${product.pro_image}`;


                                  resultsHtml += `
                                <li class='list-group-item d-flex align-items-center'>
                                    <div class="w-30">
                                        <img src='${imagePath}' alt='${product.pro_name}' class='rounded-circle' width='40' height='40'
                                             ">
                                    </div>
                                    <div class="w-70 ps-2">
                                        <a href='${product.url}' class='text-decoration-none text-dark fw-bold'>${product.pro_name}<br>
                                            <small class="text-muted">${product.brand_name || ''}</small>
                                        </a>
                                    </div>
                                </li>`;
                              });
                          } else {
                              resultsHtml +=
                                  "<li class='list-group-item text-muted'>No results found</li>";
                          }
                          resultsHtml += "</ul>";
                          $("#searchResults").html(resultsHtml);
                      }
                  });
              } else {
                  $("#searchResults").html(""); // Clear results if input is empty
              }
          });
      });
  </script>


  @if (session('success') === 'You have been logged out successfully.')
      <script>
          // ✅ Clear sessionStorage cart when user logs out
          sessionStorage.removeItem('cart');
          console.log('Cart cleared on logout');

          // ✅ Force hard reload of the current page
          window.location.reload(true);
      </script>
  @endif

  <script>
      document.addEventListener("DOMContentLoaded", function() {

          let localWishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

          fetch("{{ route('get.wishlist') }}")
              .then(res => res.json())
              .then(data => {

                  let dbWishlist = data.status === 'success' ? data.wishlist : [];

                  let finalWishlist = Array.from(new Set([
                      ...localWishlist.map(String),
                      ...dbWishlist.map(String)
                  ]));

                  // ✅ Save merged wishlist in localStorage
                  localStorage.setItem("wishlist", JSON.stringify(finalWishlist));

                  document.querySelectorAll(".wishlist-icon").forEach(icon => {
                      let id = icon.getAttribute("data-id");

                      // ✅ Make icon active on page load
                      if (finalWishlist.includes(id)) {
                          icon.classList.add("active");
                      }

                      icon.addEventListener("click", function(e) {
                          e.preventDefault();
                          e.stopPropagation();

                          let index = finalWishlist.indexOf(id);

                          if (index === -1) {
                              // ❤️ ADD
                              finalWishlist.push(id);
                              icon.classList.add("active");

                              fetch("{{ route('add.wishlist') }}", {
                                      method: "POST",
                                      headers: {
                                          "Content-Type": "application/json",
                                          "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                      },
                                      body: JSON.stringify({
                                          product_id: id
                                      })
                                  })
                                  .then(response => response.json())
                                  .then(data => {
                                      iziToast.success({
                                          title: 'Success',
                                          message: 'Product added to your wishlist ❤️',
                                          position: 'topRight',
                                          timeout: 2500,
                                          backgroundColor: '#212529',
                                          titleColor: '#ffffff',
                                          messageColor: '#ffffff',
                                          icon: 'fa fa-check-circle',
                                          iconColor: '#ffffff',
                                          progressBarColor: '#ffffff'
                                      });
                                  });

                          } else {
                              // ❌ REMOVE
                              finalWishlist.splice(index, 1);
                              icon.classList.remove("active");

                              fetch("{{ route('remove.wishlist') }}", {
                                      method: "POST",
                                      headers: {
                                          "Content-Type": "application/json",
                                          "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                      },
                                      body: JSON.stringify({
                                          product_id: id
                                      })
                                  })
                                  .then(response => response.json())
                                  .then(data => {
                                      iziToast.info({
                                          title: 'Removed',
                                          message: 'Product removed from wishlist',
                                          position: 'topRight',
                                          timeout: 2500,
                                          backgroundColor: '#212529',
                                          titleColor: '#ffffff',
                                          messageColor: '#ffffff',
                                          icon: 'fa fa-trash',
                                          iconColor: '#ffffff',
                                          progressBarColor: '#ffffff'
                                      });
                                  });
                          }

                          // ✅ Update localStorage after every click
                          localStorage.setItem("wishlist", JSON.stringify(finalWishlist));
                      });
                  });

              });

      });
  </script>
