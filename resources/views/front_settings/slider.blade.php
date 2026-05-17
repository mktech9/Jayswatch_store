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
            <h4 class="fw-medium mb-0">Slider Settings</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Front Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Home Sliders</li>
            </ol>
        </div>

        <div class="main-content app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#listTab"
                                            role="tab">Sliders List</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="formTabBtn" data-bs-toggle="tab" href="#formTab"
                                            role="tab">Add Slider</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content">
                                <div class="tab-pane fade show active p-3" id="listTab" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-nowrap w-100" id="sliderTable">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Desktop View</th>
                                                    <th>Mobile View</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane fade p-4" id="formTab" role="tabpanel">
                                    <form id="sliderForm" class="needs-validation" novalidate>
                                        @csrf
                                        <input type="hidden" name="slider_id" id="slider_id">

                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <label class="form-label fw-semibold">Desktop Image <span
                                                        class="text-danger">*</span></label>
                                                <input type="file" id="desktop_image" name="desktop_image"
                                                    class="filepond">
                                                <div id="desktop_preview" class="mt-2"></div>
                                                {{-- <small class="text-muted">Recommended: 1920x800 px</small> --}}
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <label class="form-label fw-semibold">Mobile Image <span
                                                        class="text-danger">*</span></label>
                                                <input type="file" id="mobile_image" name="mobile_image"
                                                    class="filepond">
                                                <div id="mobile_preview" class="mt-2"></div>
                                                {{-- <small class="text-muted">Recommended: 600x800 px</small> --}}
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary" id="saveBtn">Save
                                                Slider</button>
                                            <button type="button" class="btn btn-light ms-2"
                                                onclick="resetSliderForm()">Cancel</button>
                                        </div>
                                    </form>
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
        let sliderTable;
        let desktopPond, mobilePond;

        $(document).ready(function () {
            // FilePond Initialization
            FilePond.registerPlugin(FilePondPluginImagePreview);
            const pondConfig = { storeAsFile: true, credits: false };

            desktopPond = FilePond.create(document.querySelector('#desktop_image'), pondConfig);
            mobilePond = FilePond.create(document.querySelector('#mobile_image'), pondConfig);

            // DataTable Initialization
            sliderTable = $('#sliderTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('slider.list') }}",
                columns: [
                    { data: 'sr_no' },
                    { data: 'desktop' },
                    { data: 'mobile' },
                    { data: 'action' }
                ]
            });

            $('a[href="#listTab"]').on('shown.bs.tab', function () {
                $('#formTabBtn').text('Add Slider');
            });

            $('#formTabBtn').on('click', function () {
                if ($(this).text() === 'Add Slider') {
                    resetSliderForm();
                }
            });

            // Form Submit with iziToast Validation
            $('#sliderForm').on('submit', function (e) {
                e.preventDefault();

                const isEdit = $('#slider_id').val() !== "";
                const desktopFiles = desktopPond.getFiles();
                const mobileFiles = mobilePond.getFiles();

                // Validation: If it's a new slider, both images are required.
                // If it's an edit, we only validate if the previews are empty (meaning images were removed/missing)
                if (!isEdit) {
                    if (desktopFiles.length === 0) {
                        iziToast.error({ title: 'Validation Error', message: 'Please upload a Desktop Image', position: 'topRight' });
                        return false;
                    }
                    if (mobileFiles.length === 0) {
                        iziToast.error({ title: 'Validation Error', message: 'Please upload a Mobile Image', position: 'topRight' });
                        return false;
                    }
                }

                const $btn = $('#saveBtn');
                $btn.prop('disabled', true).text('Processing...');

                let fd = new FormData(this);
                if (desktopFiles.length) fd.set('desktop_image', desktopFiles[0].file);
                if (mobileFiles.length) fd.set('mobile_image', mobileFiles[0].file);

                $.ajax({
                    url: "{{ route('slider.store') }}",
                    type: "POST",
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        iziToast.success({ title: 'Success', message: res.message, position: 'topRight' });
                        resetSliderForm(); // Fully clear form after successful save
                        sliderTable.ajax.reload();

                        let listTabEl = document.querySelector('a[href="#listTab"]');
                        let listTabInstance = bootstrap.Tab.getOrCreateInstance(listTabEl);
                        listTabInstance.show();
                    },
                    error: (err) => {
                        iziToast.error({ title: 'Error', message: 'Operation failed. Please try again.', position: 'topRight' });
                    },
                    complete: () => $btn.prop('disabled', false).text('Save Slider')
                });
            });

            // Edit Handler
            $(document).on('click', '.editSlider', function () {
                const id = $(this).data('id');
                const assetUrl = "{{ $actual_url . '/admin_assets/sliders/' }}";

                let url = "{{ route('slider.edit', ':id') }}";
                url = url.replace(':id', id);

                $.get(url, function (res) {
                    if (res.status === 200) {
                        $('#slider_id').val(res.data.slider_id);
                        $('#formTabBtn').text('Edit Slider');

                        desktopPond.removeFiles();
                        mobilePond.removeFiles();

                        $('#desktop_preview').html(`<img src="${assetUrl}${res.data.desktop_image}" class="img-thumbnail" width="150">`);
                        $('#mobile_preview').html(`<img src="${assetUrl}${res.data.mobile_image}" class="img-thumbnail" width="80">`);

                        let tabEl = document.querySelector('#formTabBtn');
                        let tabInstance = bootstrap.Tab.getOrCreateInstance(tabEl);
                        tabInstance.show();
                    }
                });
            });

            // Delete Handler
            $(document).on('click', '.deleteSlider', function () {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    html: `You are about to remove this slider.<br>This action cannot be undone.`,
                    icon: 'warning',
                    iconColor: '#d33',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('slider.delete') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            success: function (res) {
                                if (res.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: res.message,
                                        timer: 1500,
                                        showConfirmButton: false
                                    });

                                    sliderTable.ajax.reload(null, false);
                                }
                            },
                            error: function () {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to delete slider'
                                });
                            }
                        });
                    }
                });
            });
        });

        function resetSliderForm() {
            $('#slider_id').val('');
            $('#sliderForm')[0].reset();
            $('#formTabBtn').text('Add Slider');
            desktopPond.removeFiles();
            mobilePond.removeFiles();
            $('#desktop_preview, #mobile_preview').html('');
        }
    </script>
</body>

</html>
