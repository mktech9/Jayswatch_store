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
            <h4 class="fw-medium mb-0">Homepage Content</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Front Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Home Content</li>
            </ol>
        </div>

        <div class="main-content app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card custom-card">

                            <div class="card-body p-4">
                                <form id="homeContentForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="hc_id" value="{{ $content->hc_id ?? '' }}">

                                    <div class="row mb-4">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label fw-semibold">Slider Below Heading <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="slider_heading" id="slider_heading" class="form-control">{{ $content->slider_heading ?? '' }}</textarea>
                                        </div>


                                        <div class="row mb-4">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label fw-semibold">Slider Below Content <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="slider_content" id="slider_content" class="form-control" rows="5"
                                                    placeholder="Enter descriptive content">{{ $content->slider_content ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-4">

                                            <!-- Watch List Heading -->
                                            <div class="col-md-12 mb-3">

                                                <label class="form-label fw-semibold">
                                                    Watch List Heading
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <textarea name="watch_list_heading" id="watch_list_heading" class="form-control">{{ $content->watch_list_heading ?? '' }}</textarea>

                                            </div>

                                            <!-- List Top Paragraph -->
                                            <div class="col-md-12 mb-3">

                                                <label class="form-label fw-semibold">
                                                    List Top Paragraph
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <textarea name="list_top_paragraph" id="list_top_paragraph" class="form-control" rows="5">{{ $content->list_top_paragraph ?? '' }}</textarea>

                                            </div>

                                            <!-- List Bottom Paragraph -->
                                            <div class="col-md-12 mb-3">

                                                <label class="form-label fw-semibold">
                                                    List Bottom Paragraph
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <textarea name="list_bottom_paragraph" id="list_bottom_paragraph" class="form-control" rows="5">{{ $content->list_bottom_paragraph ?? '' }}</textarea>

                                            </div>

                                        </div>
                                        <hr class="my-4">

                                        <div class="row mb-4">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Second Banner Image <span
                                                        class="text-danger">*</span></label>
                                                <input type="file" name="second_banner_image" class="filepond">
                                                @if ($content && $content->second_banner_image)
                                                    <div class="mt-2">
                                                        <img src="{{ $actual_url . '/admin_assets/home_content/' . $content->second_banner_image }}"
                                                            class="img-thumbnail"
                                                            style="height: 100px; object-fit: contain;">
                                                    </div>
                                                @endif
                                                <small class="text-muted">(1920x1080 Recommended)</small>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold">Second Top Signature Image <span
                                                        class="text-danger">*</span></label>
                                                <input type="file" name="second_top_signature_image"
                                                    class="filepond">
                                                @if ($content && $content->second_top_signature_image)
                                                    <div class="mt-2">
                                                        <img src="{{ $actual_url . '/admin_assets/home_content/' . $content->second_top_signature_image }}"
                                                            class="img-thumbnail"
                                                            style="height: 100px; object-fit: contain;">
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label fw-semibold">Second Banner Section Heading
                                                    <span class="text-danger">*</span></label>
                                                <textarea name="second_banner_heading" id="second_banner_heading" class="form-control">{{ $content->second_banner_heading ?? '' }}</textarea>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label fw-semibold">Second Banner Section Content
                                                    <span class="text-danger">*</span></label>
                                                <textarea name="second_banner_content" id="second_banner_content" class="form-control" rows="4">{{ $content->second_banner_content ?? '' }}</textarea>
                                            </div>
                                        </div>

                                        <hr class="my-4">

                                        <div class="row">
                                            @php
                                                $fields = [
                                                    'content_image' => 'Content Image',
                                                    'icon_image' => 'Icon Image',
                                                    'mobile_content_image' => 'Mobile Content Image',
                                                    'mobile_icon_image' => 'Mobile Icon Image',
                                                ];
                                            @endphp

                                            @foreach ($fields as $name => $label)
                                                <div class="col-md-6 mb-4">
                                                    <label class="form-label fw-semibold">{{ $label }} <span
                                                            class="text-danger">*</span></label>
                                                    <input type="file" name="{{ $name }}"
                                                        class="filepond">
                                                    @if ($content && $content->$name)
                                                        <div class="mt-2">
                                                            <img src="{{ $actual_url . '/admin_assets/home_content/' . $content->$name }}"
                                                                class="img-thumbnail"
                                                                style="height: 80px; object-fit: contain;">
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <div class="border rounded p-3 bg-light">
                                                    <h5 class="fw-bold text-primary mb-3">SEO Section</h5>

                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-semibold">Meta Title</label>
                                                            <input type="text" name="meta_title"
                                                                class="form-control"
                                                                value="{{ $content->meta_title ?? '' }}"
                                                                placeholder="Enter SEO Meta Title">
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-semibold">Meta
                                                                Description</label>
                                                            <textarea name="meta_description" class="form-control" placeholder="Enter Meta Description">{{ $content->meta_description ?? '' }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4 text-end">
                                            <button type="submit" class="btn btn-primary btn-wave px-2 py-2"
                                                id="updateBtn">
                                                <i class="bx bx-save me-1"></i> Update
                                            </button>
                                        </div>
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
    <script src="{{ $actual_url . '/admin_assets/ckeditor/ckeditor.js' }}"></script>


    {{-- <script>
        $(document).ready(function() {
            // FilePond Initialization for all fields with the .filepond class
            FilePond.registerPlugin(FilePondPluginImagePreview);

            const pondConfig = {
                storeAsFile: true,
                credits: false
            };

            // Initialize all FilePond instances
            const pondElements = document.querySelectorAll('.filepond');
            const ponds = {};

            pondElements.forEach(el => {
                ponds[el.name] = FilePond.create(el, pondConfig);
            });

            // Update the AJAX Submit logic to include FilePond files
            $('#homeContentForm').on('submit', function(e) {
                e.preventDefault();

                // Validation for text fields
                let isValid = true;
                $(this).find('input[type="text"], textarea').each(function() {
                    if (!$(this).val().trim()) {
                        isValid = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                Object.keys(ponds).forEach(name => {
                    const hasNewUpload = ponds[name].getFiles().length > 0;
                    const hasExistingImage = $(`input[name="${name}"]`).closest('.col-md-6').find(
                        'img').length > 0;

                    if (!hasNewUpload && !hasExistingImage) {
                        isValid = false;
                        $(`input[name="${name}"]`).closest('.filepond--wrapper').addClass(
                            'is-invalid-pond');
                    } else {
                        $(`input[name="${name}"]`).closest('.filepond--wrapper').removeClass(
                            'is-invalid-pond');
                    }
                });

                if (!isValid) {
                    iziToast.error({
                        title: 'Validation Error',
                        message: 'All text and image fields are required.',
                        position: 'topRight'
                    });
                    return false;
                }

                const $btn = $('#updateBtn');
                $btn.prop('disabled', true).text('Updating...');

                let formData = new FormData(this);

                // Append FilePond files to FormData
                Object.keys(ponds).forEach(name => {
                    const files = ponds[name].getFiles();
                    if (files.length > 0) {
                        formData.set(name, files[0].file);
                    }
                });

                $.ajax({
                    url: "{{ route('home_content.update') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.success) {
                            iziToast.success({
                                title: 'Success',
                                message: res.message,
                                position: 'topRight'
                            });
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        }
                    },
                    error: () => {
                        iziToast.error({
                            title: 'Error',
                            message: 'Update failed.',
                            position: 'topRight'
                        });
                        $btn.prop('disabled', false).text('Update Homepage Content');
                    }
                });
            });
        });
    </script> --}}



    <script>
        $(document).ready(function() {

            // ✅ Disable CKEditor version warning
            CKEDITOR.config.versionCheck = false;


            const simpleToolbar = [{
                    name: 'styles',
                    items: ['Format']
                },
                {
                    name: 'colors',
                    items: ['TextColor', 'BGColor']
                }
            ];

            const allowedFormats = 'p;h1;h2;h3';

            // Slider Below Heading
            CKEDITOR.replace('slider_heading', {
                height: 120,
                toolbar: simpleToolbar,
                format_tags: allowedFormats,
                removeButtons: 'Bold,Italic,Underline,Strike,Subscript,Superscript,NumberedList,BulletedList,Link,Unlink,Image,Table,Source'
            });

            // Watch List Heading
            CKEDITOR.replace('watch_list_heading', {
                height: 120,
                toolbar: simpleToolbar,
                format_tags: allowedFormats,
                removeButtons: 'Bold,Italic,Underline,Strike,Subscript,Superscript,NumberedList,BulletedList,Link,Unlink,Image,Table,Source'
            });

            // List Top Paragraph
            CKEDITOR.replace('list_top_paragraph', {
                height: 220
            });

            // List Bottom Paragraph
            CKEDITOR.replace('list_bottom_paragraph', {
                height: 220
            });

            // Second Banner Section Heading
            CKEDITOR.replace('second_banner_heading', {
                height: 120,
                toolbar: simpleToolbar,
                format_tags: allowedFormats,
                removeButtons: 'Bold,Italic,Underline,Strike,Subscript,Superscript,NumberedList,BulletedList,Link,Unlink,Image,Table,Source'
            });
            // ✅ CKEditor Apply
            CKEDITOR.replace('slider_content', {
                height: 220
            });

            CKEDITOR.replace('second_banner_content', {
                height: 220
            });

            // FilePond Initialization
            FilePond.registerPlugin(FilePondPluginImagePreview);

            const pondConfig = {
                storeAsFile: true,
                credits: false
            };

            const pondElements = document.querySelectorAll('.filepond');
            const ponds = {};

            pondElements.forEach(el => {
                ponds[el.name] = FilePond.create(el, pondConfig);
            });

            $('#homeContentForm').on('submit', function(e) {
                e.preventDefault();

                // ✅ Sync CKEditor textarea values
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }

                let isValid = true;

                // Validate text + textarea
                $(this).find('input[type="text"], textarea').each(function() {

                    if (!$(this).val().trim()) {
                        isValid = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }

                });

                // Validate images
                Object.keys(ponds).forEach(name => {

                    const hasNewUpload = ponds[name].getFiles().length > 0;

                    const hasExistingImage = $(`input[name="${name}"]`)
                        .closest('.col-md-6, .col-md-12')
                        .find('img').length > 0;

                    if (!hasNewUpload && !hasExistingImage) {

                        isValid = false;

                        $(`input[name="${name}"]`)
                            .closest('.filepond--wrapper')
                            .addClass('is-invalid-pond');

                    } else {

                        $(`input[name="${name}"]`)
                            .closest('.filepond--wrapper')
                            .removeClass('is-invalid-pond');
                    }
                });

                if (!isValid) {
                    iziToast.error({
                        title: 'Validation Error',
                        message: 'All text and image fields are required.',
                        position: 'topRight'
                    });
                    return false;
                }

                const $btn = $('#updateBtn');

                $btn.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span>
            Updating...
        `);

                let formData = new FormData(this);

                // Append FilePond Files
                Object.keys(ponds).forEach(name => {

                    const files = ponds[name].getFiles();

                    if (files.length > 0) {
                        formData.set(name, files[0].file);
                    }
                });

                $.ajax({
                    url: "{{ route('home_content.update') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(res) {

                        if (res.success) {

                            iziToast.success({
                                title: 'Success',
                                message: res.message,
                                position: 'topRight'
                            });

                            setTimeout(() => {
                                location.reload();
                            }, 1200);
                        }
                    },

                    error: function() {

                        iziToast.error({
                            title: 'Error',
                            message: 'Update failed.',
                            position: 'topRight'
                        });

                        $btn.prop('disabled', false).html(`
                    <i class="bx bx-save me-1"></i> Update
                `);
                    }
                });
            });

        });
    </script>
</body>

</html>
