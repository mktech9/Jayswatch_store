<!DOCTYPE html>
<html lang="en">

@include('frontend.partials.header_link')

<body>



    @include('frontend.partials.header')
    <style>
        /* ========== Transaction Cancelled Page ========== */
        .cancel-page {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 80vh;
            background: #fff;
            padding: 40px 16px;
            font-family: 'Roboto', sans-serif;
        }

        .cancel-box {
            background: #fff;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            text-align: center;
            padding: 40px 32px;
            max-width: 420px;
            width: 100%;
        }

        .cancel-box h1 {
            font-size: 28px;
            margin: 16px 0 10px;
            color: #000;
        }

        .cancel-box p {
            color: #555;
            line-height: 1.6;
            font-size: 15px;
        }

        .cancel-box .icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .cancel-box .icon i {
            color: #fff;
            font-size: 28px;
        }

        .cancel-box .buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 18px;
        }

        .cancel-box .buttons a {
            border: 1px solid #ccc;
            color: #333;
            text-decoration: none;
            font-weight: 600;
            padding: 10px 18px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .cancel-box .buttons a:hover {
            background: #f5f5f5;
        }

        .cancel-box .note {
            color: #777;
            font-size: 13px;
            margin-top: 20px;
        }
    </style>



    <div class="cancel-page">
        <div class="cancel-box">
            <div class="icon">
                <i class="fas fa-exclamation"></i>
            </div>
            <h1>Transaction Cancelled</h1>
            <p>It seems your transaction was cancelled or failed.<br>
                Don't worry, you can try again or return to the store.</p>

            <div class="buttons">
                <!--<a href="#">Go To Your Shopping Cart</a>-->
                <a href="{{ route('product') }}">Go To Home Page</a>
            </div>


            <p class="note">If amount was deducted, it will be automatically refunded within 2-3 business days.</p>
        </div>
    </div>


    <script>
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
    </script>
    @include('frontend.partials.footer')

    @include('frontend.partials.footer_link')
</body>

</html>
