<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient"
    data-menu-styles="dark">

@include('partials.header_link')
<style>
    /* Modern Blog Modal Styles */

    /* Banner Image */
    .banner-container {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    #blogBanner {
        width: 100%;
        max-height: 350px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .banner-container:hover #blogBanner {
        transform: scale(1.05);
    }

    .banner-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
        height: 100px;
    }

    /* Blog Description */
    .blog-description {
        font-size: 1.2rem;
        color: #4a5568;
        line-height: 1.6;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border-left: 4px solid #667eea;
    }

    /* Content Title */
    .content-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2d3748;
        margin: 2rem 0 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px dashed #cbd5e0;
    }

    /* Blog Sections */
    .section-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 2rem;
        background: #ffffff;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        border: 1px solid rgba(102, 126, 234, 0.1);
    }


    .section-header {
        padding: 1.5rem 1.5rem 0;
    }

    .section-heading {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1f36;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }

    .section-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 10px;
        font-size: 1.2rem;
        font-weight: 600;
        margin-right: 1rem;
    }

    /* Main Image */
    .main-image-container {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        margin: 1rem 1.5rem;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .main-image-container img {
        width: 100%;
        max-height: 280px;
        object-fit: cover;
        transition: all 0.5s ease;
    }

    .main-image-container:hover img {
        transform: scale(1.1);
    }

    .image-caption {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1rem;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        color: white;
        font-style: italic;
        text-align: center;
    }

    /* Content */
    .section-content {
        padding: 0 1.5rem;
        color: #4a5568;
        line-height: 1.7;
        font-size: 1.1rem;
    }

    /* Gallery */
    .gallery-section {
        padding: 0 1.5rem 1.5rem;
    }

    .gallery-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }

    .gallery-title i {
        margin-right: 0.5rem;
        color: #667eea;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
    }

    .gallery-item {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        aspect-ratio: 1;
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.3s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.1);
    }

    .gallery-item-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(102, 126, 234, 0.3);
        opacity: 0;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .gallery-item:hover .gallery-item-overlay {
        opacity: 1;
    }

    .gallery-item-overlay i {
        color: white;
        font-size: 2rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    /* Modal Footer */
    .blog-modal .modal-footer {
        border: none;
        padding: 1.5rem 2rem 2rem;
        background: transparent;
    }

    .btn-outline-primary {

        border-radius: 12px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }



    /* Loading Animation */
    .loading-spinner {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 3rem;
    }

    .spinner {
        width: 50px;
        height: 50px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<body>
    @include('partials.switcher')

    <!-- ✅ PAGE START -->
    <div class="page">

        @include('partials.header')
        @include('partials.sidebar')

        <!-- ✅ PAGE HEADER -->
        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between">
            <h4 class="fw-medium mb-0">Blog</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);" class="text-white-50">Blog</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Blog</li>
            </ol>
        </div>

        <!-- ✅ MAIN CONTENT -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">

                        <div class="card custom-card">

                            <!-- ✅ CARD HEADER -->
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#listTab">
                                            Blog List
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="formTabBtn" data-bs-toggle="tab" href="#formTab">
                                            Add Blog
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- ✅ TAB CONTENT -->
                            <div class="tab-content">

                                <!-- ✅ LIST TAB -->
                                <div class="tab-pane fade show active p-3" id="listTab">
                                    <table class="table table-bordered w-100" id="blogTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Brand</th>
                                                <th>Banner</th>
                                                <th>Created</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                <!-- ✅ FORM TAB -->
                                <div class="tab-pane fade p-4" id="formTab">
                                    <form id="blogForm" enctype="multipart/form-data" novalidate>
                                        @csrf

                                        <input type="hidden" name="blog_id" id="blog_id">

                                        <!-- BLOG BASIC DETAILS -->
                                        <div class="row g-3 mb-4">

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Blog Title <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="title" class="form-control"
                                                    placeholder="Enter Blog Title" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">
                                                    Select Brand <span class="text-danger">*</span>
                                                </label>

                                                <select name="brand_value" id="brand_value" class="form-control"
                                                    required>
                                                    <option value="">Select Brand</option>

                                                    @foreach ($brand_data as $brand)
                                                        <option value="{{ $brand->brand_name }}">
                                                            {{ $brand->brand_name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">
                                                    Banner Image <span class="text-danger">*</span>
                                                </label>
                                                <div id="bannerPreview" class="mb-2"></div>

                                                <input type="file" name="banner" class="form-control"
                                                    accept="image/*" required>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label fw-bold d-block">Editor's Pick</label>

                                                <div class="form-check form-switch mt-2">
                                                    <input class="form-check-input" type="checkbox" id="editors_pick"
                                                        name="editors_pick" value="1" style="cursor: pointer">
                                                    <label class="form-check-label" for="editors_pick">
                                                        Show in Editor's Pick
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Featured Show Toggle -->
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold d-block">Featured Show</label>

                                                <div class="form-check form-switch mt-2">
                                                    <input class="form-check-input" type="checkbox" id="featured_show"
                                                        name="featured_show" value="1" style="cursor: pointer">
                                                    <label class="form-check-label" for="featured_show">
                                                        Show in Featured Section
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label fw-bold">Short Description <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="description" id="description" class="form-control"></textarea>
                                            </div>

                                        </div>

                                        <hr>

                                        <!-- BLOG MAIN CONTENT TITLE -->
                                        <div class="row mb-4">

                                            <div class="col-md-12">
                                                <label class="form-label fw-bold">Content Title <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="content_title" class="form-control">
                                            </div>

                                        </div>

                                        <hr>

                                        <!-- DYNAMIC CONTENT SECTIONS -->
                                        <div id="blogSections">

                                            <div class="content-section border rounded p-4 mb-4">

                                                <div class="d-flex justify-content-between mb-3">
                                                    <h5 class="fw-bold">Content Section</h5>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm remove-section">Remove</button>
                                                </div>

                                                <div class="row g-3">

                                                    <div class="col-md-6">
                                                        <label class="form-label">Heading</label>
                                                        <input type="text" name="heading[]" class="form-control">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Image</label>
                                                        <input type="file" name="image[]" accept="image/*"
                                                            class="form-control">
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="form-label">Caption</label>
                                                        <input type="text" name="caption[]" class="form-control">
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="form-label">Content</label>
                                                        <textarea name="content[]" id="content_editor_1" class="form-control content-editor"></textarea>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="form-label">Bottom Image</label>
                                                        <input type="file" name="bottom_image[0][]"
                                                            accept="image/*" class="form-control" multiple>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- ADD SECTION BUTTON -->
                                        <div class="mb-4 d-flex justify-content-center">
                                            <button type="button" class="btn btn-dark" id="addSection">
                                                <i class="bx bx-plus"></i> Add Another Section
                                            </button>
                                        </div>

                                        <!-- SAVE BUTTON -->
                                        <div class="d-flex justify-content-end mt-4">
                                            <button type="submit" class="btn btn-primary px-5">

                                                <i class="bx bx-save me-1"></i> Save Blog

                                            </button>
                                        </div>

                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="modal fade blog-modal" id="viewBlogModal" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-newspaper me-2"></i>Blog Details
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Loading State -->
                        <div class="loading-spinner" id="loadingSpinner" style="display: none;">
                            <div class="spinner"></div>
                        </div>

                        <!-- Content Container -->
                        <div id="blogContent">
                            <h1 class="blog-title" id="blogTitle"></h1>

                            <div class="banner-container">
                                <img id="blogBanner" class="img-fluid" src="" alt="Blog Banner">
                                <div class="banner-overlay"></div>
                            </div>

                            <div class="blog-description" id="blogDescription"></div>

                            <h2 class="content-title" id="contentTitle">
                                <i class="fas fa-layer-group me-2"></i>Content Sections
                            </h2>

                            <div id="blogSectionsView"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @include('partials.footer')

    </div>



    @include('partials.footer_link')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>


    <script>
        CKEDITOR.config.versionCheck = false;

        $(document).ready(function() {
            $('#brand_value').select2({
                placeholder: "Select Brand",
                allowClear: true
            });

            CKEDITOR.replace('description');
            initEditors();

        });

        function initEditors() {

            $('.content-editor').each(function() {

                if (!$(this).attr('id')) {
                    $(this).attr('id', 'editor_' + Math.random().toString(36).substr(2, 9))
                }

                if (!CKEDITOR.instances[$(this).attr('id')]) {
                    CKEDITOR.replace($(this).attr('id'))
                }

            });

        }
    </script>

    <script>
        $(document).on('click', '#addSection', function() {

            let id = 'editor_' + Math.random().toString(36).substr(2, 9)

            let section = `
<div class="content-section border rounded p-4 mb-4">

<div class="d-flex justify-content-between mb-3">
<h5 class="fw-bold">Content Section</h5>
<button type="button" class="btn btn-danger btn-sm remove-section">Remove</button>
</div>

<div class="row g-3">

<div class="col-md-6">
<label class="form-label">Heading</label>
<input type="text" name="heading[]" class="form-control">
</div>

<div class="col-md-6">
<label class="form-label">Image</label>
<input type="file" name="image[]"  accept="image/*" class="form-control">
</div>

<div class="col-md-12">
<label class="form-label">Caption</label>
<input type="text" name="caption[]"  class="form-control">
</div>

<div class="col-md-12">
<label class="form-label">Content</label>
<textarea name="content[]" id="${id}" class="form-control content-editor"></textarea>
</div>

<div class="col-md-12">
<label class="form-label">Bottom Image</label>
<input type="file" name="bottom_image[${$('.content-section').length}][]" accept="image/*" class="form-control" multiple>
</div>

</div>

</div>
`;

            $('#blogSections').append(section)

            CKEDITOR.replace(id)

        })
        $(document).on('click', '.remove-section', function() {

            let editor = $(this).closest('.content-section').find('.content-editor').attr('id')

            if (CKEDITOR.instances[editor]) {
                CKEDITOR.instances[editor].destroy(true)
            }

            $(this).closest('.content-section').remove()

        })

        $(document).on('change', 'input[type="file"]', function() {

            let file = this.files[0]

            if (file) {

                let size = file.size / 1024 / 1024

                if (size > 2) {

                    iziToast.error({
                        title: 'Image too large',
                        message: 'Maximum file size allowed is 1MB',
                        position: 'topRight'
                    })

                    $(this).val('')

                }

            }

        })


        $('#blogForm').on('submit', function(e) {

            e.preventDefault();

            // 🔹 Sync CKEditor data to textarea
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            let btn = $(this).find('button[type="submit"]')
            let formData = new FormData(this)

            btn.prop('disabled', true)
            btn.html('<span class="spinner-border spinner-border-sm"></span> Saving...')

            $('.invalid-feedback').remove()
            $('.is-invalid').removeClass('is-invalid')
            let url = "{{ route('blog.store') }}";

            if ($('#blog_id').val()) {
                url = "{{ route('blog.update') }}";
            }

            $.ajax({

                url: url,
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,

                success: function(res) {

                          // Switch to Blog List tab
                    $('a[href="#listTab"]').tab('show')

                    // Reload DataTable
                    blogTable.ajax.reload();

                    btn.prop('disabled', false)
                    btn.html('<i class="bx bx-save me-1"></i> Save Blog')

                    iziToast.success({
                        title: 'Success',
                        message: res.message,
                        position: 'topRight'
                    })

                    // Reset form
                    $('#blogForm')[0].reset()
                    $('#blog_id').val('')
                    $('#bannerPreview').html('')

                    for (instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].setData('');
                    }



                },

                error: function(xhr) {

                    btn.prop('disabled', false)
                    btn.html('<i class="bx bx-save me-1"></i> Save Blog')

                    if (xhr.status === 422) {

                        let errors = xhr.responseJSON.errors

                        $.each(errors, function(key, value) {

                            let field = $('[name="' + key + '"]')

                            field.addClass('is-invalid')

                            field.after('<div class="invalid-feedback">' + value[0] + '</div>')

                        })

                    } else {

                        iziToast.error({
                            title: 'Error',
                            message: 'Something went wrong',
                            position: 'topRight'
                        })

                    }

                }

            })

        })

        let blogTable = $('#blogTable').DataTable({

            processing: true,
            ajax: "{{ route('blog.list') }}",

            columns: [{
                    data: 'id'
                },
                {
                    data: 'title'
                },
                {
                    data: 'brand'
                },
                {
                    data: 'banner'
                },
                {
                    data: 'created'
                },
                {
                    data: 'action'
                }
            ]

        })

        $(document).on('click', '.viewBlog', function() {
            const actual_url = "{{ $actual_url }}";
            let id = $(this).data('id');
            let url = "{{ route('blog.view', ':id') }}";
            url = url.replace(':id', id);

            // Show loading spinner
            $('#loadingSpinner').show();
            $('#blogContent').hide();

            $.get(url, function(res) {
                // Hide loading spinner
                $('#loadingSpinner').hide();

                // Populate data
                $('#blogTitle').text(res.blog.title);
                $('#blogDescription').html(res.blog.description);
                $('#contentTitle').text(res.blog.content_title);

                if (res.blog.banner) {
                    $('#blogBanner').attr('src', actual_url + '/front/blog/banner/' + res.blog.banner);
                }

                let html = '';

                res.sections.forEach(function(section, index) {
                    let bottomImages = '';

                    if (section.bottom_img) {
                        let images = section.bottom_img.split(',');

                        images.forEach(function(img) {
                            bottomImages += `
                    <div class="gallery-item">
                        <img src="${actual_url}/front/blog/content/${img}"
                             alt="Gallery Image ${index + 1}"
                             onclick="openImageModal('${actual_url}/front/blog/content/${img}')">
                        <div class="gallery-item-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                    `;
                        });
                    }

                    html += `
            <div class="section-card">
                <div class="section-header">
                    <h3 class="section-heading">
                        <span class="section-number">${index + 1}</span>
                        ${section.heading || 'Untitled Section'}
                    </h3>
                </div>

                ${section.main_img ? `
                                        <div class="main-image-container">
                                            <img src="${actual_url}/front/blog/content/${section.main_img}"
                                                 alt="Section Image ${index + 1}">
                                            ${section.caption ? `
                    <div class="image-caption">
                        <i class="fas fa-quote-left me-2"></i>${section.caption}
                    </div>` : ''}
                                        </div>` : section.caption ? `
                                        <div class="px-4 mt-3">
                                            <p class="text-muted fst-italic">
                                                <i class="fas fa-quote-left me-2"></i>${section.caption}
                                            </p>
                                        </div>` : ''}

                ${section.content ? `
                                        <div class="section-content">
                                            ${section.content}
                                        </div>` : ''}

                ${bottomImages ? `
                                        <div class="gallery-section">
                                            <h4 class="gallery-title">
                                                <i class="fas fa-images"></i>
                                                Gallery
                                            </h4>
                                            <div class="gallery-grid">
                                                ${bottomImages}
                                            </div>
                                        </div>` : ''}
            </div>
            `;
                });

                $('#blogSectionsView').html(html);
                $('#blogContent').fadeIn(500);
                $('#viewBlogModal').modal('show');
            }).fail(function() {
                $('#loadingSpinner').hide();
                alert('Failed to load blog details. Please try again.');
            });
        });

        // Function to open image in modal (optional enhancement)
        function openImageModal(imageUrl) {
            // You can implement a lightbox or image modal here
            // For now, it will open in a new tab
            window.open(imageUrl, '_blank');
        }

        $(document).on('click', '.editBlog', function() {

            const actual_url = "{{ $actual_url }}";

            let id = $(this).data('id');

            let url = "{{ route('blog.edit', ':id') }}";
            url = url.replace(':id', id);

            $.get(url, function(res) {

                $('#formTabBtn').tab('show');

                $('#blogForm')[0].reset();
                $('#blogSections').html('');

                $('#blog_id').val(res.blog.blog_id);
                $('input[name="title"]').val(res.blog.title);
                $('input[name="content_title"]').val(res.blog.content_title);
                $('#brand_value').val(res.blog.brand).trigger('change');
                $('#editors_pick').prop('checked', res.blog.editors_pick == 1);
                $('#featured_show').prop('checked', res.blog.features_blog == 1);

                CKEDITOR.instances.description.setData(res.blog.description);

                /* ---------------------------
                BANNER PREVIEW
                --------------------------- */

                let bannerHtml = '';

                if (res.blog.banner) {

                    bannerHtml = `
            <div class="existing-banner mb-2">

                <img src="${actual_url}/front/blog/banner/${res.blog.banner}" width="200" class="border rounded">

                <button type="button"
                class="btn btn-sm btn-outline-danger removeBannerImg ms-2"
                data-img="${res.blog.banner}">
                <i class="bx bx-trash"></i>
                </button>

                <input type="hidden" name="existing_banner" value="${res.blog.banner}">

            </div>
            `;

                }

                $('#bannerPreview').html(bannerHtml);

                /* ---------------------------
                SECTIONS LOOP
                --------------------------- */

                res.sections.forEach(function(section, index) {

                    let editorId = 'editor_' + Math.random().toString(36).substr(2, 9);

                    /* MAIN IMAGE */

                    let mainImgHtml = '';

                    if (section.main_img) {

                        mainImgHtml = `
                <div class="existing-main-img mb-2">

                    <img src="${actual_url}/front/blog/content/${section.main_img}" width="120" class="border rounded">

                    <button type="button"
                    class="btn btn-sm btn-outline-danger removeMainImg ms-2"
                    data-img="${section.main_img}">
                    <i class="bx bx-trash"></i>
                    </button>

                    <input type="hidden" name="existing_main_img[${index}]" value="${section.main_img}">

                </div>
                `;

                    }

                    /* BOTTOM IMAGES */

                    let bottomImgs = '';

                    if (section.bottom_img) {

                        let images = section.bottom_img.split(',');

                        images.forEach(function(img) {

                            bottomImgs += `
                    <div class="existing-bottom-img d-inline-block me-2 mb-2">

                        <img src="${actual_url}/front/blog/content/${img}" width="100" class="border rounded">

                        <button type="button"
                        class="btn btn-sm btn-outline-danger removeBottomImg"
                        data-img="${img}">
                        <i class="bx bx-trash"></i>
                        </button>

                        <input type="hidden" name="existing_bottom_img[${index}][]" value="${img}">

                    </div>
                    `;

                        });

                    }

                    /* SECTION HTML */

                    let html = `
            <div class="content-section border rounded p-4 mb-4">

            <input type="hidden" name="mb_id[]" value="${section.mb_id}">

            <div class="d-flex justify-content-between mb-3">
            <h5 class="fw-bold">Content Section</h5>
            <button type="button" class="btn btn-danger btn-sm remove-section">Remove</button>
            </div>

            <div class="row g-3">

            <div class="col-md-6">
            <label class="form-label">Heading</label>
            <input type="text" name="heading[]" value="${section.heading}" class="form-control">
            </div>

            <div class="col-md-6">

            <label class="form-label">Image</label>

            ${mainImgHtml}

            <input type="file" name="image[]" class="form-control">

            </div>

            <div class="col-md-12">
            <label class="form-label">Caption</label>
            <input type="text" name="caption[]" value="${section.caption ?? ''}" class="form-control">
            </div>

            <div class="col-md-12">
            <label class="form-label">Content</label>
            <textarea name="content[]" id="${editorId}" class="form-control content-editor"></textarea>
            </div>

            <div class="col-md-12">

            <label class="form-label">Bottom Images</label>

            <div class="existing-bottom-container mb-2">
            ${bottomImgs}
            </div>

            <input type="file"
            name="bottom_image[${index}][]"
            class="form-control"
            multiple>

            </div>

            </div>
            </div>
            `;

                    $('#blogSections').append(html);

                    CKEDITOR.replace(editorId);

                    setTimeout(function() {

                        CKEDITOR.instances[editorId].setData(section.content ?? '');

                    }, 200);

                });

            });

        });
        $(document).on('click', '.removeMainImg', function() {

            let img = $(this).data('img');

            $('<input>').attr({
                type: 'hidden',
                name: 'delete_main_img[]',
                value: img
            }).appendTo('#blogForm');

            $(this).closest('.existing-main-img').remove();

        });

        $(document).on('click', '.removeBottomImg', function() {

            let img = $(this).data('img');

            // mark image for deletion
            $('<input>').attr({
                type: 'hidden',
                name: 'delete_bottom_img[]',
                value: img
            }).appendTo('#blogForm');

            // remove preview + hidden input
            $(this).closest('.existing-bottom-img').remove();

        });

        $(document).on('click', '.removeBannerImg', function() {

            let img = $(this).data('img');

            $('<input>').attr({
                type: 'hidden',
                name: 'delete_banner',
                value: img
            }).appendTo('#blogForm');

            $(this).closest('.existing-banner').remove();

        });


        //delete blog
        $(document).on('click', '.deleteBlog', function() {

            let id = $(this).data('id');

            iziToast.show({
                theme: 'dark',
                icon: 'bx bx-trash',
                title: 'Delete Blog?',
                message: 'This action cannot be undone.',
                position: 'center',
                timeout: false,
                close: false,
                overlay: true,
                displayMode: 'once',

                buttons: [

                    ['<button>Yes, Delete</button>', function(instance, toast) {

                        let url = "{{ route('blog.delete', ':id') }}";
                        url = url.replace(':id', id);

                        $.ajax({

                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },

                            success: function(res) {

                                iziToast.success({
                                    title: 'Deleted',
                                    message: res.message,
                                    position: 'topRight'
                                });

                                         // Switch to Blog List tab
                    $('a[href="#listTab"]').tab('show')

                    // Reload DataTable
                    blogTable.ajax.reload();
                            }

                        });

                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast);

                    }, true],

                    ['<button>Cancel</button>', function(instance, toast) {

                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast);

                    }]

                ]
            });

        });

        $('a[href="#listTab"]').on('shown.bs.tab', function() {

            // Reset form
            $('#blogForm')[0].reset();

            // Clear blog id
            $('#blog_id').val('');

            // Reset Select2 brand dropdown
            $('#brand_value').val('').trigger('change');

            // Reset toggles
            $('#editors_pick').prop('checked', false);
            $('#features_show').prop('checked', false);

            // Clear banner preview
            $('#bannerPreview').html('');

            // Remove all sections
            $('#blogSections').html('');

            // Destroy all CKEditors
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].destroy(true);
            }

            // Recreate default section
            let defaultSection = `
<div class="content-section border rounded p-4 mb-4">

<div class="d-flex justify-content-between mb-3">
<h5 class="fw-bold">Content Section</h5>
<button type="button" class="btn btn-danger btn-sm remove-section">Remove</button>
</div>

<div class="row g-3">

<div class="col-md-6">
<label class="form-label">Heading</label>
<input type="text" name="heading[]" class="form-control">
</div>

<div class="col-md-6">
<label class="form-label">Image</label>
<input type="file" name="image[]" accept="image/*" class="form-control">
</div>

<div class="col-md-12">
<label class="form-label">Caption</label>
<input type="text" name="caption[]" class="form-control">
</div>

<div class="col-md-12">
<label class="form-label">Content</label>
<textarea name="content[]" id="content_editor_1" class="form-control content-editor"></textarea>
</div>

<div class="col-md-12">
<label class="form-label">Bottom Image</label>
<input type="file" name="bottom_image[0][]" accept="image/*" class="form-control" multiple>
</div>

</div>
</div>
`;

            $('#blogSections').append(defaultSection);

            // Reinitialize editors
            CKEDITOR.replace('description');
            CKEDITOR.replace('content_editor_1');

        });
    </script>


</body>

</html>
