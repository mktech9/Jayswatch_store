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
            <h4 class="fw-medium mb-0">Contact Information</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('contact.master.index') }}" class="text-white-50">Contact Master</a>
                </li>
                <li class="breadcrumb-item active">
                    {{ $contact->is_business == 1 ? $contact->business_name : $contact->first_name . ' ' . $contact->last_name }}
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
                                                    <span
                                                        class="avatar avatar-xxl rounded-circle bg-primary-transparent text-primary fs-24">
                                                        {{ strtoupper(substr($contact->is_business == 1 ? $contact->business_name : $contact->first_name, 0, 1)) }}
                                                    </span>
                                                </div>

                                                <h5 class="mb-1">
                                                    {{ $contact->is_business == 1 ? $contact->business_name : $contact->first_name . ' ' . $contact->last_name }}
                                                </h5>
                                                <p class="text-muted mb-2">
                                                    {{ $contact->is_business == 1 ? 'Business Account' : 'Individual Account' }}
                                                </p>

                                                <hr>

                                                <div class="text-start">
                                                    <p><b>Contact ID:</b> {{ $contact->contact_id ?? '-' }}</p>
                                                    <p><b>Email:</b> {{ $contact->email ?? '-' }}</p>
                                                    <p><b>Mobile:</b> {{ $contact->mobile ?? '-' }}</p>
                                                    <p>
                                                        <b>Status:</b>
                                                        @if($contact->status == 0)
                                                            <span class="badge bg-success">Active</span>
                                                        @elseif($contact->status == 2)
                                                            <span class="badge bg-warning">Inactive</span>
                                                        @else
                                                            <span class="badge bg-danger">Deleted</span>
                                                        @endif
                                                    </p>
                                                </div>

                                                <div class="d-grid mt-3">
                                                    <a href="{{ route('contact.master.index') }}"
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
                                                            <span
                                                                class="fw-medium">{{ $contact->is_business == 1 ? 'Business' : 'Individual' }}</span>
                                                        </div>

                                                        @if($contact->is_business == 0)
                                                            <div class="col-md-4">
                                                                <span class="text-muted d-block mb-1">Prefix</span>
                                                                <span class="fw-medium">{{ $contact->prefix ?? '-' }}</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <span class="text-muted d-block mb-1">Date of Birth</span>
                                                                <span
                                                                    class="fw-medium">{{ $contact->date_of_birth ? date('d-m-Y', strtotime($contact->date_of_birth)) : '-' }}</span>
                                                            </div>
                                                        @endif

                                                        <div class="col-md-4">
                                                            <span class="text-muted d-block mb-1">Primary Mobile</span>
                                                            <span class="fw-medium">{{ $contact->mobile ?? '-' }}</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <span class="text-muted d-block mb-1">Alternate
                                                                Contact</span>
                                                            <span
                                                                class="fw-medium">{{ $contact->alternate_contact_number ?? '-' }}</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <span class="text-muted d-block mb-1">Landline</span>
                                                            <span
                                                                class="fw-medium">{{ $contact->landline ?? '-' }}</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <span class="text-muted d-block mb-1">Email Address</span>
                                                            <span class="fw-medium">{{ $contact->email ?? '-' }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="financialInfo">
                                                    <h6 class="fw-semibold mb-3">Identity & Tax Info</h6>
                                                    <div class="row g-3 mb-4">
                                                        <div class="col-md-4">
                                                            <span class="text-muted d-block mb-1">GST Number</span>
                                                            <span
                                                                class="fw-medium">{{ $contact->gst_number ?? '-' }}</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <span class="text-muted d-block mb-1">Tax Number</span>
                                                            <span
                                                                class="fw-medium">{{ $contact->tax_number ?? '-' }}</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <span class="text-muted d-block mb-1">ID Proof Type</span>
                                                            <span
                                                                class="fw-medium">{{ $contact->id_proof_type ?? '-' }}</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <span class="text-muted d-block mb-1">ID Number</span>
                                                            <span
                                                                class="fw-medium">{{ $contact->id_number ?? '-' }}</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <span class="text-muted d-block mb-1">ID Document</span>
                                                            @if(!empty($contact->id_file_path))
                                                                <a href="{{ asset('assets/admin_assets/contact_documents/' . $contact->id_file_path) }}"
                                                                    target="_blank" class="btn btn-sm btn-primary-light">
                                                                    <i class="bx bx-download"></i> View File
                                                                </a>
                                                            @else
                                                                <span>-</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <hr class="border-dashed">

                                                    <h6 class="fw-semibold mb-3">Billing Details</h6>
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <span class="text-muted d-block mb-1">Opening Balance</span>
                                                            <span
                                                                class="fw-medium text-success">{{ number_format($contact->opening_balance ?? 0, 2) }}</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <span class="text-muted d-block mb-1">Credit Limit</span>
                                                            <span
                                                                class="fw-medium">{{ $contact->credit_limit ? number_format($contact->credit_limit, 2) : '-' }}</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <span class="text-muted d-block mb-1">Payment Terms</span>
                                                            <span class="fw-medium">
                                                                {{ $contact->pay_term ?? '-' }}
                                                                {{ $contact->pay_term_period ?? '' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="salesHistory">
                                                    <h6 class="fw-semibold mb-3">Complete Sales Records</h6>
                                                    <div class="table-responsive">
                                                        <table id="salesTable"
                                                            class="table table-bordered text-nowrap w-100">
                                                            <thead>
                                                                <tr>
                                                                    <th>Invoice No</th>
                                                                    <th>Date</th>
                                                                    <th>Bill Status</th>
                                                                    <th>Discount</th>
                                                                    <th>GST Amount</th>
                                                                    <th>TCS (%)</th>
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
                                                                                class="fw-bold text-primary">{{ $sale->invoice_no }}</span>
                                                                        </td>
                                                                        <td>{{ date('d-m-Y', strtotime($sale->sale_date)) }}
                                                                        </td>
                                                                        <td>
                                                                            @if($sale->bill_status == 'Paid')
                                                                                <span
                                                                                    class="badge bg-success-transparent text-success">Paid</span>
                                                                            @elseif($sale->bill_status == 'Draft')
                                                                                <span
                                                                                    class="badge bg-light text-dark">Draft</span>
                                                                            @elseif($sale->bill_status == 'Return')
                                                                                <span
                                                                                    class="badge bg-danger-transparent text-danger">Return</span>
                                                                            @else
                                                                                <span
                                                                                    class="badge bg-warning-transparent text-warning">{{ $sale->bill_status ?? 'Pending' }}</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ number_format($sale->discount ?? 0, 2) }}
                                                                        </td>
                                                                        <td>{{ number_format($sale->gst_amount ?? 0, 2) }}
                                                                        </td>
                                                                        <td>{{ number_format($sale->tcs_percentage ?? 0, 2) }}%
                                                                        </td>
                                                                        <td class="text-success">
                                                                            {{ number_format($sale->payment_split_amount ?? 0, 2) }}
                                                                        </td>
                                                                        <td class="text-danger">
                                                                            {{ number_format($sale->remaining_amount ?? 0, 2) }}
                                                                        </td>
                                                                        <td class="fw-bold">
                                                                            {{ number_format($sale->finalTotal ?? 0, 2) }}
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="9" class="text-center text-muted">No
                                                                            sales records found for this customer.</td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <script>
                                                    $(document).ready(function () {
                                                        if ($('#salesTable').length > 0) {
                                                            $('#salesTable').DataTable({
                                                                "order": [[1, "desc"]],
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
        $(document).ready(function () {
            if ($('#salesTable').length > 0) {
                $('#salesTable').DataTable({
                    "order": [[1, "desc"]], // Sort by date
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