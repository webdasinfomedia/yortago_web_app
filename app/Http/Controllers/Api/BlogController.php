<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Http\Resources\CategoryWiseEducationResource;
use App\Http\Resources\EducationResource;
use App\Http\Traits\ResponseTrait;
use App\Models\Blog;
use App\Models\Category;
use App\Models\EducationHub;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    use ResponseTrait;

    public function all_blogs(Request $request)
    {
        $blogs = Blog::orderBy('id', 'desc');
        if ($request->category_id) {
            $blogs = $blogs->where('category_id', $request->category_id);
        }
        $blogs = $blogs->paginate(5);
        return $this->returnApiResponse(200, 'All blogs fetched successfully', array('blogs' => BlogResource::collection($blogs->values()), 'next_page_url' => $blogs->nextPageUrl()));

    }

    public function education(Request $request)
    {
        if ($request->category_id) {
            $blogs = EducationHub::where('category_id', $request->category_id)->orderBy('id', 'desc');
            $blogs = $blogs->paginate(5);
            return $this->returnApiResponse(200, 'All blogs fetched successfully', array('education' => EducationResource::collection($blogs->values()), 'next_page_url' => $blogs->nextPageUrl()));

        } else {
            $category = Category::has('education_hub')->paginate(5);
            return $this->returnApiResponse(200, 'All blogs fetched successfully', array('education' => CategoryWiseEducationResource::collection($category->values()), 'next_page_url' => $category->nextPageUrl()));
        }
    }
}
