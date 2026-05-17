<!DOCTYPE html>
<html lang="en-US">

<head>


    <title>Recent Article - The Journal</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="{{ $actual_url . '/front/blog/index.css' }}">








    <!-- End Google Tag Manager  -->
    @include('frontend.partials.header_link')
</head>

<body>
    @include('frontend.partials.header')
    <!-- Google Tag Manager (noscript) -->





    <section class="trendingListWrap cmnSection view-all-article-page">

        <div class="flx-jusfy headingWrap container">

            <h2 class="sec-ttl">
                All Articles
                <span class="articleHading">({{ $allblogs->total() }} Articles)</span>
            </h2>

            <div class="sortList">
                <span>Sort By :</span>
                <div class="sortDD">
                    <select name="sorting" id="sorting_posts">
                        <option value="DESC" {{ request('sorting') == 'DESC' ? 'selected' : '' }}>Descending
                        </option>
                        <option value="ASC" {{ request('sorting') == 'ASC' ? 'selected' : '' }}>Ascending
                        </option>
                    </select>
                </div>
            </div>

        </div>


        <div class="container flx-jusfy trendingListing">

            @forelse ($allblogs as $blog)
                <div class="trendWrap">

                    <a href="{{ url('blog/details/' . Str::slug($blog->title)) }}">
                        <picture>
                            <img src="{{ $actual_url . '/front/blog/banner/' . $blog->banner }}"
                                alt="{{ $blog->title }}">
                        </picture>
                    </a>

                    <div class="trendCont">
                        <h3>
                            <a href="{{ url('blog/details/' . Str::slug($blog->title)) }}">
                                {{ $blog->title }}
                            </a>
                        </h3>

                        <p class="captionTxt">
                            {{ \Illuminate\Support\Str::limit(
                                trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($blog->description), ENT_QUOTES, 'UTF-8'))),
                                350,
                            ) }}
                        </p>
                        <div class="dateShare">
                            <span class="date">
                                <img class="ic-heading" src="{{ $actual_url . '/front/blog/calendar.svg' }}"
                                    width="10" style="width: 10px !important" />
                                {{ \Carbon\Carbon::parse($blog->created_at)->format('F d, Y') }}
                            </span>

                            <span class="readTime chat">
                                <img src="{{ $actual_url . '/front/blog/readTime.svg' }}" width="10"
                                    style="width: 10px !important" />
                                5 Min Read
                            </span>
                        </div>
                    </div>

                </div>

            @empty
                <div class="no-articles" style="width:100%; text-align:center; padding:40px;">
                    <h3>No Article Added</h3>
                </div>
            @endforelse

    </section>









    </div>
    @include('frontend.partials.footer')
    @include('frontend.partials.footer_link')
    <script>
        document.getElementById('sorting_posts').addEventListener('change', function() {

            let sort = this.value;

            let url = new URL(window.location.href);

            url.searchParams.set('sorting', sort);

            window.location.href = url.toString();

        });
    </script>
    <script>
        (function() {
            function c() {
                var b = a.contentDocument || a.contentWindow.document;
                if (b) {
                    var d = b.createElement('script');
                    d.innerHTML =
                        "window.__CF$cv$params={r:'9d8413599e988afd',t:'MTc3MjgyODU3OA=='};var a=document.createElement('script');a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";
                    b.getElementsByTagName('head')[0].appendChild(d)
                }
            }
            if (document.body) {
                var a = document.createElement('iframe');
                a.height = 1;
                a.width = 1;
                a.style.position = 'absolute';
                a.style.top = 0;
                a.style.left = 0;
                a.style.border = 'none';
                a.style.visibility = 'hidden';
                document.body.appendChild(a);
                if ('loading' !== document.readyState) c();
                else if (window.addEventListener) document.addEventListener('DOMContentLoaded', c);
                else {
                    var e = document.onreadystatechange || function() {};
                    document.onreadystatechange = function(b) {
                        e(b);
                        'loading' !== document.readyState && (document.onreadystatechange = e, c())
                    }
                }
            }
        })();
    </script>


</body>

</html>
