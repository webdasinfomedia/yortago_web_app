<?php

namespace App\Http\Controllers;

use App\Http\Traits\ImageUploadTrait;
use App\Models\Blog;
use App\Models\Category;
use App\Models\EducationHub;
use Illuminate\Http\Request;

class EducationHubController extends Controller
{
    //
    use ImageUploadTrait;

    public function education_hub_page_setting(Request $request)
    {
        $blogs = EducationHub::all();
        return view('admin.cms.pages.education.manage', compact('blogs'));
    }

    public function create_education_hub(Request $request)
    {
        $blog = EducationHub::find($request->id);
        $categories = Category::all();
        return view('admin.cms.pages.education.create', compact('blog','categories'));
    }

    public function save_education_hub(Request $request)
    {

            $id = $request->id;
            $is_image_required = $request->link ? "nullable" : "required";
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'video' => "$is_image_required|file|mimes:jpg,jpeg,png",
                'link' => 'nullable',
                'category_id' => 'required|integer',
            ]);
            if ($id) {
                $save = EducationHub::findOrFail($id);
            } else {
                $save = new EducationHub();
            }
            $save->title = $request->title;
            $save->description = $request->description;
            $save->category_id = $request->category_id;
            $save->link = $request->link;
            if ($request->hasFile('video')) {
                $save->image = $this->upload_image($request->file('video'));
            }
            $save->save();
            return redirect('/admin/cms/education_hub_page_setting')->with('message', 'Education hub saved successfully.');
    }

    public function delete_education_hub(Request $request)
    {
        EducationHub::where('id', $request->id)->delete();
        return redirect()->back()->with('message', 'Education hub deleted successfully.');
    }

}
