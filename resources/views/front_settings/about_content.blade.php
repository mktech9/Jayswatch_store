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
            <h4 class="fw-medium mb-0">About Content</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Front Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit About Content</li>
            </ol>
        </div>

        <div class="main-content app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card custom-card">

                            <div class="card-body p-4">
                                <form id="aboutContentForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="ac_id" value="{{ $content->ac_id ?? '' }}">

                                    <!-- Main Heading -->
                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <label class="form-label fw-semibold">First Heading <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="about_heading" id="about_heading" class="form-control">{{ $content->about_heading ?? '' }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Body Content -->
                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <label class="form-label fw-semibold">Body Paragraph Content <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="about_content" id="about_content" rows="6" class="form-control">{{ $content->about_content ?? '' }}</textarea>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- SECTION 1 -->
                                    <h5 class="fw-bold text-primary mb-3">Card 1</h5>

                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Card 1 Image</label>
                                            <input type="file" name="section1_image" class="filepond">

                                            @if ($content && $content->section1_image)
                                                <div class="mt-2">
                                                    <img src="{{ $actual_url . '/admin_assets/about_content/' . $content->section1_image }}"
                                                        class="img-thumbnail" style="height:90px;">
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-md-8">
                                            <label class="form-label fw-semibold">Card 1 Heading</label>
                                            <textarea name="section1_heading" id="section1_heading" class="form-control">{{ $content->section1_heading ?? '' }}</textarea>

                                            <label class="form-label fw-semibold mt-3">Card 1 Content</label>
                                            <textarea name="section1_content" id="section1_content" rows="5" class="form-control">{{ $content->section1_content ?? '' }}</textarea>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- SECTION 2 -->
                                    <h5 class="fw-bold text-primary mb-3">Card 2</h5>

                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Card 2 Image</label>
                                            <input type="file" name="section2_image" class="filepond">

                                            @if ($content && $content->section2_image)
                                                <div class="mt-2">
                                                    <img src="{{ $actual_url . '/admin_assets/about_content/' . $content->section2_image }}"
                                                        class="img-thumbnail" style="height:90px;">
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-md-8">
                                            <label class="form-label fw-semibold">Card 2 Heading</label>
                                            <textarea name="section2_heading" id="section2_heading" class="form-control">{{ $content->section2_heading ?? '' }}</textarea>

                                            <label class="form-label fw-semibold mt-3">Card 2 Content</label>
                                            <textarea name="section2_content" id="section2_content" rows="5" class="form-control">{{ $content->section2_content ?? '' }}</textarea>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- SECTION 3 -->
                                    <h5 class="fw-bold text-primary mb-3">Card 3</h5>

                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Card 3 Image</label>
                                            <input type="file" name="section3_image" class="filepond">

                                            @if ($content && $content->section3_image)
                                                <div class="mt-2">
                                                    <img src="{{ $actual_url . '/admin_assets/about_content/' . $content->section3_image }}"
                                                        class="img-thumbnail" style="height:90px;">
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-md-8">
                                            <label class="form-label fw-semibold">Card 3 Heading</label>
                                            <textarea name="section3_heading" id="section3_heading" class="form-control">{{ $content->section3_heading ?? '' }}</textarea>

                                            <label class="form-label fw-semibold mt-3">Card 3 Content</label>
                                            <textarea name="section3_content" id="section3_content" rows="5" class="form-control">{{ $content->section3_content ?? '' }}</textarea>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- SEO -->
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="border rounded p-3 bg-light">
                                                <h5 class="fw-bold text-primary mb-3">SEO Section</h5>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-semibold">Meta Title</label>
                                                        <input type="text" name="meta_title" class="form-control"
                                                            value="{{ $content->meta_title ?? '' }}">
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-semibold">Meta Description</label>
                                                        <textarea name="meta_description" class="form-control">{{ $content->meta_description ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- BUTTON -->
                                    <div class="text-end mt-4">
                                        <button type="submit" class="btn btn-primary px-4" id="updateBtn">
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






    <script>
        $(document).ready(function() {

            CKEDITOR.config.versionCheck = false;

            // Heading Toolbar Only
            const headingToolbar = [{
                    name: 'styles',
                    items: ['Format']
                },
                {
                    name: 'colors',
                    items: ['TextColor', 'BGColor']
                }
            ];

            const allowedFormats = 'p;h1;h2;h3';

            // Full Content Toolbar
            const contentToolbar = [{
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList']
                },
                {
                    name: 'styles',
                    items: ['Format']
                },
                {
                    name: 'colors',
                    items: ['TextColor', 'BGColor']
                },
                {
                    name: 'links',
                    items: ['Link', 'Unlink']
                }
            ];

            // ==========================
            // Heading Fields
            // ==========================
            const headingFields = [
                'about_heading',
                'section1_heading',
                'section2_heading',
                'section3_heading'
            ];

            headingFields.forEach(function(id) {
                CKEDITOR.replace(id, {
                    height: 120,
                    toolbar: headingToolbar,
                    format_tags: allowedFormats,
                    removeButtons: 'Bold,Italic,Underline,Strike,Subscript,Superscript,NumberedList,BulletedList,Link,Unlink,Image,Table,Source'
                });
            });

            // ==========================
            // Content Fields
            // ==========================
            const contentFields = [
                'about_content',
                'section1_content',
                'section2_content',
                'section3_content'
            ];

            contentFields.forEach(function(id) {
                CKEDITOR.replace(id, {
                    height: 300,
                    removeButtons: '', // nothing removed
                    allowedContent: true // allow all HTML
                });
            });

            // ==========================
            // FilePond
            // ==========================
            FilePond.registerPlugin(FilePondPluginImagePreview);

            const ponds = {};

            document.querySelectorAll('.filepond').forEach(el => {
                ponds[el.name] = FilePond.create(el, {
                    storeAsFile: true,
                    credits: false
                });
            });

            // ==========================
            // Submit Form
            // ==========================
            $('#aboutContentForm').on('submit', function(e) {

                e.preventDefault();

                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }

                let formData = new FormData(this);

                Object.keys(ponds).forEach(name => {
                    const files = ponds[name].getFiles();

                    if (files.length > 0) {
                        formData.set(name, files[0].file);
                    }
                });

                $('#updateBtn').prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span>
            Updating...
        `);

                $.ajax({
                    url: "{{ route('about_content.update') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(res) {

                        iziToast.success({
                            title: 'Success',
                            message: res.message,
                            position: 'topRight'
                        });

                        setTimeout(() => {
                            location.reload();
                        }, 1200);
                    },

                    error: function() {

                        iziToast.error({
                            title: 'Error',
                            message: 'Update Failed',
                            position: 'topRight'
                        });

                        $('#updateBtn').prop('disabled', false).html(`
                    <i class="bx bx-save me-1"></i> Update
                `);
                    }
                });

            });

        });
    </script>
</body>

</html>
