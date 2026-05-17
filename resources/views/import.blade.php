<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">
@include('partials.header_link')

<body>
    @include('partials.switcher')
    <div class="page">
        @include('partials.header')
        @include('partials.sidebar')



        <div class="main-content app-content">
            <div class="container-fluid">
              <div class="row">
    <div class="col-xl-6">
        <div class="card custom-card">
            <div class="card-header">
                <h5 class="mb-0">Import Products Excel</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('product.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Upload Excel</label>
                        <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls" required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Upload & Import
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
            </div>
        </div>
        @include('partials.footer')
    </div>
    @include('partials.footer_link')


</body>

</html>
