<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">

@include('partials.header_link')

<body>
    @include('partials.switcher')

    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')

        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between">
            <h4 class="fw-medium mb-0">Ecommerce Customer Information</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('ecom.customer.index') }}" class="text-white-50">Ecommerce Customer</a>
                </li>
                <li class="breadcrumb-item active">
                    {{ $contact->first_name . ' ' . $contact->last_name ?? $contact->full_name }}
                </li>
            </ol>
        </div>

        <div class="main-content app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-xl-3 col-lg-4 col-md-5 mb-4">
                                        <div class="card text-center h-100 border">
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    @if (!empty($contact->profile_pic))
                                                        <img src="{{ $actual_url . '/front/uploads/customer_profile/' . $contact->profile_pic }}"
                                                            class="avatar avatar-xxl rounded-circle" alt="Profile">
                                                    @else
                                                        <span
                                                            class="avatar avatar-xxl rounded-circle bg-primary-transparent text-primary fs-24">
                                                            {{ strtoupper(substr($contact->full_name ?? $contact->first_name, 0, 1)) }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <h5 class="mb-1">
                                                    {{ $contact->full_name ?? $contact->first_name . ' ' . $contact->last_name }}
                                                </h5>
                                                <p class="text-muted mb-2">
                                                    Ecommerce Account
                                                </p>

                                                <hr>

                                                <div class="text-start">
                                                    <p><b>Email:</b> {{ $contact->email ?? '-' }}</p>
                                                    <p><b>Username:</b> {{ $contact->user_name ?? '-' }}</p>
                                                    <p><b>Mobile:</b> {{ $contact->phone ?? '-' }}</p>
                                                    <p>
                                                        <b>Status:</b>
                                                        @if ($contact->status == 1)
                                                            <span class="badge bg-success">Active</span>
                                                        @elseif($contact->status == 2)
                                                            <span class="badge bg-warning">Inactive</span>
                                                        @else
                                                            <span class="badge bg-danger">Deleted</span>
                                                        @endif
                                                    </p>
                                                </div>

                                                <div class="d-grid mt-3">
                                                    <a href="{{ route('ecom.customer.index') }}"
                                                        class="btn btn-light btn-wave">
                                                        <i class="bx bx-arrow-back"></i> Back to List
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-9 col-lg-8 col-md-7">
                                        <div class="card h-100 border">
                                            <div class="card-header border-bottom">
                                                <ul class="nav nav-tabs card-header-tabs">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-bs-toggle="tab"
                                                            href="#basicInfo">
                                                            <i class="bx bx-user me-1"></i> Basic Information
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-bs-toggle="tab" href="#financialInfo">
                                                            <i class="bx bx-wallet me-1"></i> Financial & ID
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-bs-toggle="tab" href="#salesHistory">
                                                            <i class="bx bx-cart me-1"></i> Sales History
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="card-body tab-content">

                                                <div class="tab-pane fade show active" id="basicInfo">
                                                    <h6 class="fw-semibold mb-3">General Details</h6>
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <span class="text-muted d-block mb-1">Account Type</span>
                                                            <span class="fw-medium">Ecommerce Account</span>
                                                        </div>



                                                        <div class="col-md-4">
                                                            <span class="text-muted d-block mb-1">Primary Mobile</span>
                                                            <span class="fw-medium">{{ $contact->phone ?? '-' }}</span>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <span class="text-muted d-block mb-1">Email Address</span>
                                                            <span class="fw-medium">{{ $contact->email ?? '-' }}</span>
                                                        </div>


                                                        <div class="col-12">
                                                            <span class="text-muted d-block mb-2">Customer
                                                                Addresses</span>

                                                            @if ($user_address->count() > 0)

                                                                <div class="row g-3">
                                                                    @foreach ($user_address as $address)
                                                                        <div class="col-md-6">
                                                                            <div class="border rounded p-3 h-100">

                                                                                {{-- Address Type + Primary Badge --}}
                                                                                <div class="mb-2">
                                                                                    <span class="fw-semibold">
                                                                                        {{ ucfirst($address->address_type ?? 'Address') }}
                                                                                    </span>

                                                                                    @if ($address->is_primary == 1)
                                                                                        <span
                                                                                            class="badge bg-success ms-2">Primary</span>
                                                                                    @endif
                                                                                </div>

                                                                                {{-- Address Details --}}
                                                                                <div class="fw-medium">
                                                                                    {{ $address->u_address1 ?? '' }},
                                                                                    {{ $address->u_address2 ?? '' }}<br>

                                                                                    {{ $address->u_city ?? '' }},
                                                                                    {{ $address->u_state ?? '' }},
                                                                                    {{ $address->u_country ?? '' }} -
                                                                                    {{ $address->u_pincode ?? '' }}
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <span class="fw-medium">No Address Found</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="financialInfo">
                                                    <h6 class="fw-semibold mb-3">Identity & Info</h6>
                                                    <div class="row g-3 mb-4">


                                                        <div class="col-md-4">
                                                            <span class="text-muted d-block mb-1">Citizen Type</span>
                                                            <span
                                                                class="fw-medium">{{ $contact->citizen_type ?? '-' }}</span>
                                                        </div>

                                                        @if (strtolower($contact->citizen_type) == 'indian')
                                                            <div class="col-md-4">
                                                                <span class="text-muted d-block mb-1">PAN Number</span>
                                                                <span
                                                                    class="fw-medium">{{ $contact->pan_no ?? '-' }}</span>
                                                            </div>
                                                        @endif

                                                    </div>

                                                    <hr class="border-dashed">


                                                </div>

                                                <div class="tab-pane fade" id="salesHistory">
                                                    <h6 class="fw-semibold mb-3">Order Hsitory</h6>
                                                    <div class="table-responsive">
                                                        <table id="salesTable"
                                                            class="table table-bordered text-nowrap w-100">
                                                            <thead>
                                                                <tr>
                                                                    <th>Order ID</th>
                                                                    <th>Invoice No</th>
                                                                    <th>Date</th>
                                                                    <th>Bill Status</th>

                                                                    <th>TCS Amount</th>
                                                                    <th>Paid Amount</th>
                                                                    <th>Remaining</th>
                                                                    <th>Final Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($sales as $sale)
                                                                    <tr>
                                                                        <td>
                                                                            <span
                                                                                class="fw-bold text-primary">{{ $sale->order_id }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="fw-bold text-primary">{{ $sale->invoice_num }}</span>
                                                                        </td>
                                                                        <td>{{ date('d-m-Y', strtotime($sale->order_date)) }}
                                                                        </td>
                                                                        <td>

                                                                            {{-- Cancelled --}}
                                                                            @if ($sale->status == 0 && $sale->order_status == 'aborted')
                                                                                <span
                                                                                    class="badge bg-danger-transparent text-danger">
                                                                                    Cancelled
                                                                                </span>

                                                                                {{-- Pending --}}
                                                                            @elseif($sale->status == 0 || is_null($sale->status) || $sale->status == '')
                                                                                <span
                                                                                    class="badge bg-warning-transparent text-warning">
                                                                                    Pending
                                                                                </span>

                                                                                {{-- Prebook --}}
                                                                            @elseif($sale->status != 0 && $sale->order_status != 'aborted' && $sale->payment_method == 'prebook')
                                                                                <span
                                                                                    class="badge bg-info-transparent text-info">
                                                                                    Prebook
                                                                                </span>

                                                                                {{-- Full Payment --}}
                                                                            @elseif($sale->status != 0 && $sale->order_status != 'aborted' && $sale->payment_method != 'prebook')
                                                                                <span
                                                                                    class="badge bg-success-transparent text-success">
                                                                                    Full Payment
                                                                                </span>

                                                                                {{-- Fallback --}}
                                                                            @else
                                                                                <span class="badge bg-light text-dark">
                                                                                    -
                                                                                </span>
                                                                            @endif

                                                                        </td>

                                                                        <td>{{ number_format($sale->tcs ?? 0, 2) }}
                                                                        </td>

                                                                        <td class="text-success">
                                                                            {{ number_format($sale->total ?? 0, 2) }}
                                                                        </td>
                                                                        <td class="text-danger">
                                                                            {{ number_format(($sale->grand_total ?? 0) - ($sale->total ?? 0), 2) }}
                                                                        </td>
                                                                        <td class="fw-bold">
                                                                            {{ number_format($sale->grand_total ?? 0, 2) }}
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="9"
                                                                            class="text-center text-muted">No
                                                                            sales records found for this customer.</td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <script>
                                                    $(document).ready(function() {
                                                        if ($('#salesTable').length > 0) {
                                                            $('#salesTable').DataTable({
                                                                "order": [
                                                                    [1, "desc"]
                                                                ],
                                                                "pageLength": 10,
                                                                "scrollX": true, // Added for responsiveness with many columns
                                                                "language": {
                                                                    "emptyTable": "No sales found"
                                                                },
                                                                "dom": '<"d-flex justify-content-between align-items-center mb-3"lf>rtip'
                                                            });
                                                        }
                                                    });
                                                </script>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('partials.footer')
    </div>

    @include('partials.footer_link')
    <script>
        $(document).ready(function() {
            if ($('#salesTable').length > 0) {
                $('#salesTable').DataTable({
                    "order": [
                        [1, "desc"]
                    ], // Sort by date
                    "pageLength": 10,
                    "language": {
                        "emptyTable": "No sales found"
                    },
                    "dom": '<"d-flex justify-content-between align-items-center mb-3"lf>rtip'
                });
            }
        });
    </script>
</body>

</html>
