<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - {{ $blog->title }}</title>

    <link rel="stylesheet" href="{{ $actual_url . '/front/blog/single.css' }}">
    <link rel="stylesheet" href="{{ $actual_url . '/front/blog/style.css' }}">

    {{-- FancyBox 5 CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5/dist/fancybox/fancybox.css" />
</head>
@include('frontend.partials.header_link')

<body>
    @include('frontend.partials.header')
    <div class="page-wrapper">

        <!-- Main Content -->
        <main class="wrap">
            <section class="content-area content-full-width">
                <article class="article-full">
                    <!-- Article Banner -->
                    <div class="singlePost-banner">
                        <div class="container">

                            <h1 class="postBanner-heading">
                                {{ $blog->title }}
                            </h1>

                            <div class="dateShare">
                                <span class="date">
                                    {{ \Carbon\Carbon::parse($blog->created_at)->format('d M, Y') }}
                                </span>



                                <span class="share">
                                    <img src="{{ $actual_url . '/front/blog/share-icon.svg' }}" width="14"
                                        style="width: 14px !important">
                                </span>
                            </div>

                            <!-- Banner -->
                            <div class="post-heroBanner">
                                <picture>
                                    <img src="{{ $actual_url . '/front/blog/banner/' . $blog->banner }}"
                                        alt="{{ $blog->title }}">
                                </picture>
                            </div>

                        </div>
                    </div>

                    <!-- Post Content -->
                    <div class="postContWrap">
                        <div class="postWrapInner">
                            <!-- Sidebar -->
                            <div class="sideBarpfull">
                                <div class="sideBarWrap">

                                    @if ($multiBlogs && $multiBlogs->count() > 1)
                                        <!-- Trending Articles -->
                                        <div class="recommendPost sidePost">
                                            <h2 class="sideHeading">
                                                <img src="https://www.secondmovement.com/the-journal/wp-content/themes/sm/img/i-rec.svg"
                                                    alt="Articles"> Trending Articles
                                            </h2>

                                            <ul class="recommendList">

                                                @foreach ($trending_blogs as $trend)
                                                    <li class="articleRow">

                                                        <div class="articleImagesingle">
                                                            <a
                                                                href="{{ url('blog/details/' . Str::slug($trend->title)) }}">
                                                                <picture>
                                                                    <img src="{{ $actual_url . '/front/blog/banner/' . $trend->banner }}"
                                                                        width="180" alt="{{ $trend->title }}">
                                                                </picture>
                                                            </a>
                                                        </div>

                                                        <div class="postCapt articleInfo">

                                                            <p>
                                                                <a
                                                                    href="{{ url('blog/details/' . Str::slug($trend->title)) }}">
                                                                    {{ $trend->title }}
                                                                </a>
                                                            </p>

                                                            <div class="dateShare">

                                                                <span class="date">
                                                                    {{ \Carbon\Carbon::parse($trend->created_at)->format('d M, Y') }}
                                                                </span>

                                                                <span class="chat">
                                                                    <img src="{{ $actual_url }}/front/blog/chat.svg"
                                                                        width="12">
                                                                    {{ $trend->view_count ?? 0 }}
                                                                </span>

                                                            </div>

                                                        </div>

                                                    </li>
                                                @endforeach

                                            </ul>
                                        </div>


                                    @endif

                                    <!-- Side Banner -->
                                    <div class="postSideBanner">
                                        <a href="#" class="custom-logo-link">
                                            <img width="1176" height="2259"
                                                src="https://www.secondmovement.com/the-journal/wp-content/uploads/2022/12/SM-3X-Banner-updated.jpg"
                                                class="custom-logo" alt="The Journal">
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Main Article Content -->
                            <div class="singlePostData cmnPostData">
                                {!! $blog->description !!}

                                @if ($blog->is_multiple == 1)
                                    <h2>{{ $blog->content_title }}</h2>
                                @endif

                                @foreach ($multiBlogs as $key => $multi)
                                    <h3>{{ $key + 1 }}. {{ $multi->heading }}</h3>

                                    {{-- Main image with FancyBox --}}
                                    <div class="figure-slider cmnEle">

                                        <a href="{{ $actual_url . '/front/blog/content/' . $multi->main_img }}"
                                            data-fancybox="gallery-{{ $key }}"
                                            data-caption="{{ $multi->caption }}">
                                            <picture>
                                                <img src="{{ $actual_url . '/front/blog/content/' . $multi->main_img }}"
                                                    alt="{{ $multi->heading }}">
                                            </picture>
                                        </a>

                                        <div class="figCapt">
                                            {{ $multi->caption }}
                                        </div>

                                    </div>

                                    {!! $multi->content !!}

                                    {{-- Bottom Image Gallery with FancyBox --}}
                                    @if ($multi->bottom_img)
                                        <div class="cmnEle">
                                            <div class="singleImgWrap">

                                                @foreach (explode(',', $multi->bottom_img) as $imgIndex => $img)
                                                    <div class="singleImg">
                                                        <a href="{{ $actual_url . '/front/blog/content/' . trim($img) }}"
                                                            data-fancybox="gallery-{{ $key }}"
                                                            data-caption="{{ $multi->heading }} - Image {{ $imgIndex + 1 }}">
                                                            <picture>
                                                                <img src="{{ $actual_url . '/front/blog/content/' . trim($img) }}"
                                                                    alt="{{ $multi->heading }} - Image {{ $imgIndex + 1 }}">
                                                            </picture>
                                                        </a>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                        </div>
                    </div>
                </article>
            </section>
        </main>

    </div>

    @include('frontend.partials.footer')
    @include('frontend.partials.footer_link')

    {{-- FancyBox 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5/dist/fancybox/fancybox.umd.js"></script>
    <style>
        /* Full-screen dark overlay matching the screenshot */
        .fancybox__container {
            --fancybox-bg: rgba(20, 20, 20, 0.96);
        }

        /* Make the image fill the viewport as much as possible */
        .fancybox__slide {
            padding: 40px 80px;
        }

        .fancybox__content {
            max-width: 100%;
            max-height: 100%;
            background: transparent;
            padding: 0;
        }

        .fancybox__content img {
            width: 100%;
            height: auto;
            max-height: 90vh;
            object-fit: contain;
            display: block;
        }

        /* Arrow navigation - large and visible */
        .fancybox__nav {
            --f-button-width: 50px;
            --f-button-height: 50px;
            --f-button-color: #fff;
            --f-button-bg: rgba(255, 255, 255, 0.1);
            --f-button-hover-bg: rgba(255, 255, 255, 0.2);
            --f-button-border-radius: 50%;
        }

        .fancybox__nav .f-button {
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Toolbar: counter top-left, icons top-right */
        .fancybox__toolbar {
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), transparent);
            padding: 10px 16px;
        }

        /* Caption styling */
        .fancybox__caption {
            color: rgba(255, 255, 255, 0.85);
            font-size: 14px;
            text-align: center;
            padding: 10px 20px 16px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.5), transparent);
        }
    </style>
    <script>
        Fancybox.bind("[data-fancybox]", {
            // Dark full-screen overlay
            backdropClick: "close",

            // Toolbar: counter on left, close on right
            Toolbar: {
                display: {
                    left: ["infobar"],
                    middle: [],
                    right: ["slideshow", "fullscreen", "close"],
                },
            },

            // Show left/right navigation arrows
            Navigation: true,

            // Image zoom on scroll
            Images: {
                zoom: true,
                Panzoom: {
                    maxScale: 3,
                },
            },

            // No thumbnail strip (matches screenshot)
            Thumbs: false,

            // Smooth slide transition
            animated: true,
            showClass: "f-fadeIn",
            hideClass: "f-fadeOut",

            // Caption from data-caption attribute
            caption: function(fancybox, slide) {
                return slide.triggerEl?.dataset.caption || "";
            },
        });
    </script>
</body>

</html>
