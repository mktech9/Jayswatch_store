<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\BlogModel;
use App\Models\FaqModel;
use App\Models\BrandModel;
use App\Models\MultiBlogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{




    public function index()
    {
        $page_title = 'Blog-Jayswatch';
        $brand_data = BrandModel::where('status', 0)->get();

        return view('blogging.index', compact('page_title', 'brand_data'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'banner' => 'required|image',
            'description' => 'required',
            'content_title' => 'required',
        ]);

        $bannerName = null;

        if ($request->hasFile('banner')) {

            $bannerName = ImageHelper::convertToWebp(
                $request->file('banner'),
                public_path('assets/front/blog/banner')
            );
        }

        $isMultiple = 0;

        if ($request->heading && count(array_filter($request->heading)) > 0) {
            $isMultiple = 1;
        }

        $blog = BlogModel::create([
            'title' => $request->title,
            'banner' => $bannerName,
            'description' => $request->description,
            'content_title' => $request->content_title,
            'is_multiple' => $isMultiple,
            'editors_pick'   => $request->has('editors_pick') ? 1 : 0,
            'features_blog'  => $request->has('featured_show') ? 1 : 0,
            'brand'         => $request->brand_value,
            'status' => 0,
            'created_by' => 1,
            'created_at' => now(),
        ]);

        if ($isMultiple) {

            foreach ($request->heading as $key => $heading) {

                if (! $heading) {
                    continue;
                }

                $mainImage = null;
                $bottomImages = [];

                /* MAIN IMAGE */

                if (isset($request->image[$key])) {

                    $mainImage = ImageHelper::convertToWebp(
                        $request->image[$key],
                        public_path('assets/front/blog/content')
                    );
                }

                /* BOTTOM IMAGES */

                if ($request->hasFile("bottom_image.$key")) {

                    foreach ($request->file("bottom_image.$key") as $img) {

                        $bottomImages[] = ImageHelper::convertToWebp(
                            $img,
                            public_path('assets/front/blog/content')
                        );
                    }
                }

                MultiBlogModel::create([
                    'blog_id' => $blog->blog_id,
                    'heading' => $heading,
                    'main_img' => $mainImage,
                    'caption' => $request->caption[$key] ?? null,
                    'content' => $request->content[$key] ?? null,
                    'bottom_img' => implode(',', $bottomImages),
                    'status' => 0,
                    'created_by' => 1,
                    'created_at' => now(),
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Blog created successfully',
        ]);
    }

    public function list()
    {
        $blogs = BlogModel::orderBy('blog_id', 'desc')->get();

        $data = [];

        foreach ($blogs as $key => $blog) {

            $viewBtn = '<button class="btn btn-sm btn-info viewBlog" data-id="' . $blog->blog_id . '">
                        <i class="bx bx-show"></i>
                    </button>';

            $editBtn = '<button class="btn btn-sm btn-primary editBlog" data-id="' . $blog->blog_id . '">
                        <i class="bx bx-edit"></i>
                    </button>';

            $deleteBtn = '<button class="btn btn-sm btn-danger deleteBlog" data-id="' . $blog->blog_id . '">
                <i class="bx bx-trash"></i>
              </button>';
            $badges = '';

            if ($blog->editors_pick == 1) {
                $badges .= '<br><span class="badge bg-success me-1">Editor\'s Pick</span>';
            }

            if ($blog->features_blog == 1) {
                $badges .= '<span class="badge bg-warning text-dark">Featured</span>';
            }

            $data[] = [
                'id' => $key + 1,
                'title' => $blog->title . $badges,
                'brand' => $blog->brand ?? 'N/A',
                'banner' => '<img src="' . config('app.actual_url') . '/front/blog/banner/' . $blog->banner . '" width="60">',
                'created' => date('d M Y', strtotime($blog->created_at)),
                'action' => $viewBtn . ' ' . $editBtn . ' ' . $deleteBtn,
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }

    public function view($id)
    {
        $blog = BlogModel::find($id);

        $multi = MultiBlogModel::where('blog_id', $id)->get();

        return response()->json([
            'blog' => $blog,
            'sections' => $multi,
        ]);
    }

    public function edit($id)
    {
        $blog = BlogModel::find($id);

        $sections = MultiBlogModel::where('blog_id', $id)->get();

        return response()->json([
            'blog' => $blog,
            'sections' => $sections,
        ]);
    }

    public function update(Request $request)
    {

        $blog = BlogModel::find($request->blog_id);

        if (! $blog) {
            return response()->json([
                'success' => false,
                'message' => 'Blog not found',
            ]);
        }

        /* --------------------------
           DELETE BANNER
        -------------------------- */

        if ($request->delete_banner) {

            @unlink(public_path('assets/front/blog/banner/' . $request->delete_banner));
            $blog->banner = null;
        }

        /* --------------------------
           UPLOAD NEW BANNER
        -------------------------- */

        if ($request->hasFile('banner')) {

            if ($blog->banner) {
                @unlink(public_path('assets/front/blog/banner/' . $blog->banner));
            }

            $bannerName = ImageHelper::convertToWebp(
                $request->file('banner'),
                public_path('assets/front/blog/banner')
            );

            $blog->banner = $bannerName;
        }

        /* --------------------------
           UPDATE BLOG
        -------------------------- */

        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->content_title = $request->content_title;
        $blog->editors_pick = $request->editors_pick ? 1 : 0;
        $blog->features_blog = $request->featured_show ? 1 : 0;
        $blog->brand = $request->brand_value;
        $blog->updated_by = 1;
        $blog->updated_at = now();
        $blog->save();

        /* --------------------------
           DELETE REMOVED IMAGES
        -------------------------- */

        if ($request->delete_main_img) {

            foreach ($request->delete_main_img as $img) {

                @unlink(public_path('assets/front/blog/content/' . $img));
            }
        }

        if ($request->delete_bottom_img) {

            foreach ($request->delete_bottom_img as $img) {

                @unlink(public_path('assets/front/blog/content/' . $img));
            }
        }

        /* --------------------------
           PROCESS SECTIONS
        -------------------------- */

        $updatedSectionIds = [];

        if ($request->heading) {

            foreach ($request->heading as $key => $heading) {

                if (! $heading) {
                    continue;
                }

                $mbId = $request->mb_id[$key] ?? null;

                /* --------------------------
                   MAIN IMAGE
                -------------------------- */

                $mainImage = $request->existing_main_img[$key] ?? null;

                if (isset($request->image[$key]) && $request->image[$key]) {

                    $mainImage = ImageHelper::convertToWebp(
                        $request->image[$key],
                        public_path('assets/front/blog/content')
                    );
                }

                /* --------------------------
                   BOTTOM IMAGES
                -------------------------- */

                $bottomImages = [];

                if (! empty($request->existing_bottom_img[$key])) {

                    foreach ($request->existing_bottom_img[$key] as $img) {
                        $bottomImages[] = $img;
                    }
                }

                if (! empty($request->bottom_image[$key])) {

                    foreach ($request->bottom_image[$key] as $img) {

                        $bottomImages[] = ImageHelper::convertToWebp(
                            $img,
                            public_path('assets/front/blog/content')
                        );
                    }
                }

                /* --------------------------
                   UPDATE EXISTING SECTION
                -------------------------- */

                if ($mbId) {

                    $section = MultiBlogModel::find($mbId);

                    if ($section) {

                        $section->update([

                            'heading' => $heading,
                            'main_img' => $mainImage,
                            'caption' => $request->caption[$key] ?? null,
                            'content' => $request->content[$key] ?? null,
                            'bottom_img' => implode(',', $bottomImages),
                            'updated_by' => 1,
                            'updated_at' => now(),

                        ]);

                        $updatedSectionIds[] = $section->mb_id;
                    }
                }

                /* --------------------------
                   CREATE NEW SECTION
                -------------------------- */ else {

                    $newSection = MultiBlogModel::create([

                        'blog_id' => $blog->blog_id,
                        'heading' => $heading,
                        'main_img' => $mainImage,
                        'caption' => $request->caption[$key] ?? null,
                        'content' => $request->content[$key] ?? null,
                        'bottom_img' => implode(',', $bottomImages),
                        'status' => 0,
                        'updated_by' => 1,
                        'updated_at' => now(),

                    ]);

                    $updatedSectionIds[] = $newSection->mb_id;
                }
            }
        }

        MultiBlogModel::where('blog_id', $blog->blog_id)
            ->whereNotIn('mb_id', $updatedSectionIds)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Blog updated successfully',
        ]);
    }

    public function delete($id)
    {

        $blog = BlogModel::find($id);

        if (! $blog) {
            return response()->json([
                'success' => false,
                'message' => 'Blog not found',
            ]);
        }

        /* DELETE BANNER */

        if ($blog->banner) {
            @unlink(public_path('assets/front/blog/banner/' . $blog->banner));
        }

        /* GET SECTIONS */

        $sections = MultiBlogModel::where('blog_id', $id)->get();

        foreach ($sections as $section) {

            /* DELETE MAIN IMAGE */

            if ($section->main_img) {
                @unlink(public_path('assets/front/blog/content/' . $section->main_img));
            }

            /* DELETE BOTTOM IMAGES */

            if ($section->bottom_img) {

                $images = explode(',', $section->bottom_img);

                foreach ($images as $img) {
                    @unlink(public_path('assets/front/blog/content/' . $img));
                }
            }
        }

        /* DELETE SECTIONS */

        MultiBlogModel::where('blog_id', $id)->delete();

        /* DELETE BLOG */

        $blog->delete();

        return response()->json([
            'success' => true,
            'message' => 'Blog deleted successfully',
        ]);
    }


    //FAQ Methods
    public function faq_index()
    {
        $page_title = 'FAQ - Jayswatch';

        return view('blogging.faq', compact('page_title'));
    }

    public function faq_list()
    {
        $faqs = FaqModel::orderBy('faq_id', 'desc')->get();

        $data = [];

        foreach ($faqs as $key => $faq) {

            $viewBtn = '<button class="btn btn-sm btn-info viewFaq" data-id="' . $faq->faq_id . '">
                        <i class="bx bx-show"></i>
                    </button>';

            $editBtn = '<button class="btn btn-sm btn-primary editFaq" data-id="' . $faq->faq_id . '">
                        <i class="bx bx-edit"></i>
                    </button>';

            $deleteBtn = '<button class="btn btn-sm btn-danger deleteFaq" data-id="' . $faq->faq_id . '">
                        <i class="bx bx-trash"></i>
                    </button>';

            $status = $faq->status == 1
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';

            $data[] = [
                'id' => $key + 1,
                'question' => $faq->question .
                    '<br><span class="badge bg-secondary mt-1">' . ucfirst($faq->type) . '</span>',
                'answer' => Str::limit($faq->answer, 80),
                // 'status' => $status,
                'created' => date('d M Y', strtotime($faq->created_at)),
                'action' => $viewBtn . ' ' . $editBtn . ' ' . $deleteBtn,
            ];
        }

        return response()->json([
            'data' => $data
        ]);
    }

    // STORE MULTIPLE FAQ
    public function faq_store(Request $request)
    {
        $questions = $request->question;
        $answers   = $request->answer;
        $statuses  = $request->status ?? [];
        $type      = $request->type;

        foreach ($questions as $index => $question) {

            FaqModel::create([
                'type'       => $type,
                'question'   => $question,
                'answer'     => $answers[$index] ?? '',
                'status'     => $statuses[$index] ?? 0,
                'created_by' => current_user_id(),
                'created_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'FAQs added successfully'
        ]);
    }


    // SHOW
    public function faq_view($id)
    {

        $faq = FaqModel::where('faq_id', $id)->first();

        return response()->json([
            'success' => true,
            'data' => $faq
        ]);
    }

    public function faq_edit($id)
    {
        $faq = FaqModel::where('faq_id', $id)->first();

        return response()->json([
            'success' => true,
            'data' => $faq
        ]);
    }


    // UPDATE
    public function faq_update(Request $request)
    {
        $faq = FaqModel::where('faq_id', $request->faq_id)->first();

        $faq->update([
            'type'       => $request->type,
            'question'   => $request->question[0],
            'answer'     => $request->answer[0],
            'updated_by' => current_user_id(),
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'FAQ updated successfully'
        ]);
    }

    // DELETE
    public function faq_delete($id)
    {

        FaqModel::where('faq_id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'FAQ deleted successfully'
        ]);
    }
}
