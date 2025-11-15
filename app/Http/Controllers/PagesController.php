<?php

namespace App\Http\Controllers;

use App\Http\Traits\ImageUploadTrait;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Faq;
use App\Models\HomePageSetting;
use App\Models\InPersonPageSetting;
use App\Models\OnlinePageSetting;
use App\Models\OnlinePageSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    //
    use ImageUploadTrait;
    public function __construct()
    {
        $this->middleware('is_admin')->except(['blogs','blog_detail']);
    }
    public function homePageSetting(Request $request)
    {
        $home_page = HomePageSetting::first();
        return view('admin.cms.pages.home', compact('home_page'));
    }

    public function saveOrUpdateHomePageSetting(Request $request)
    {
//        dd($request->all());
        // Validation rules
        $rules = [
            'slider_small_heading' => 'required|string|max:255',
            'slider_large_heading' => 'required|string|max:255',
            'slider_short_description' => 'required|string',
            'slider_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'page_heading_small' => 'required|string|max:255',
            'page_heading_large' => 'required|string|max:255',
            'page_heading_short_description' => 'required|string',
            'section_1_heading' => 'required|string|max:255',
            'section_1_text' => 'nullable|string',
            'section_1_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'section_1_youtube_url' => 'nullable|string|url|max:255',
            'section_2_heading' => 'required|string|max:255',
            'section_2_text' => 'nullable|string',
            'section_2_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'section_2_left_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'section_2_youtube_url' => 'nullable|string|url|max:255',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if record already exists, you can use an ID or unique column to find the record
        $formData = HomePageSetting::first(); // Modify this if you have a unique identifier

        // If the record exists, update it
        if ($formData) {
            $formData->update($this->getDataArrayForHomePage($request));
        } else {
            // Create a new record
            $formData = HomePageSetting::create($this->getDataArrayForHomePage($request));
        }

        // Handle image uploads
        if ($request->hasFile('slider_image')) {
            $formData->slider_image = $this->upload_image($request->file('slider_image'));
        }
        if ($request->hasFile('section_1_image')) {
            $formData->section_1_image = $this->upload_image($request->file('section_1_image'));
        }
        if ($request->hasFile('section_2_image')) {
            $formData->section_2_image = $this->upload_image($request->file('section_2_image'));
        }
        if ($request->hasFile('section_2_left_image')) {
            $formData->section_2_left_image = $this->upload_image($request->file('section_2_left_image'));
        }

        // Save the record with image paths
        $formData->save();

        return redirect()->back()->with('message', 'The Setting has been save/updated.');
    }

// Function to get validated data as array
    protected function getDataArrayForHomePage(Request $request)
    {
        return [
            'slider_small_heading' => $request->slider_small_heading,
            'slider_large_heading' => $request->slider_large_heading,
            'slider_short_description' => $request->slider_short_description,
            'page_heading_small' => $request->page_heading_small,
            'page_heading_large' => $request->page_heading_large,
            'page_heading_short_description' => $request->page_heading_short_description,
            'section_1_heading' => $request->section_1_heading,
            'section_1_text' => $request->section_1_text,
            'section_1_youtube_url' => $request->section_1_youtube_url,
            'section_2_heading' => $request->section_2_heading,
            'section_2_text' => $request->section_2_text,
            'section_2_youtube_url' => $request->section_2_youtube_url,
        ];
    }

    public function inPersonPageSetting(Request $request)
    {
        $in_person = InPersonPageSetting::first();
        return view('admin.cms.pages.in_person', compact('in_person'));
    }

    public function saveOrUpdate(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'slider_small_heading' => 'required|string|max:255',
            'slider_large_heading' => 'required|string|max:255',
            'slider_short_description' => 'required|string',
            'slider_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'form_right_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'form_image_youtube_url' => 'nullable|url',
            'benefits_small_heading' => 'required|string|max:255',
            'benefits_large_heading' => 'required|string|max:255',
            'benefits_short_description' => 'required|string',
            'benefits_1_heading' => 'nullable|string|max:255',
            'benefits_1_large_heading' => 'nullable|string|max:255',
            'benefits_1_short_description' => 'nullable|string',
            'benefits_1_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'benefits_2_heading' => 'nullable|string|max:255',
            'benefits_2_large_heading' => 'nullable|string|max:255',
            'benefits_2_short_description' => 'nullable|string',
            'benefits_2_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'benefits_3_heading' => 'nullable|string|max:255',
            'benefits_3_large_heading' => 'nullable|string|max:255',
            'benefits_3_short_description' => 'nullable|string',
            'benefits_3_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find or create the model instance
        $sliderAndBenefits = InPersonPageSetting::first() ?? new InPersonPageSetting();

        // Update or set attributes
        $sliderAndBenefits->slider_small_heading = $validatedData['slider_small_heading'];
        $sliderAndBenefits->slider_large_heading = $validatedData['slider_large_heading'];
        $sliderAndBenefits->slider_short_description = $validatedData['slider_short_description'];
        $sliderAndBenefits->form_image_youtube_url = $validatedData['form_image_youtube_url'] ?? null;
        $sliderAndBenefits->benefits_small_heading = $validatedData['benefits_small_heading'];
        $sliderAndBenefits->benefits_large_heading = $validatedData['benefits_large_heading'];
        $sliderAndBenefits->benefits_short_description = $validatedData['benefits_short_description'];
        $sliderAndBenefits->benefits_1_heading = $validatedData['benefits_1_heading'] ?? null;
        $sliderAndBenefits->benefits_1_large_heading = $validatedData['benefits_1_large_heading'] ?? null;
        $sliderAndBenefits->benefits_1_short_description = $validatedData['benefits_1_short_description'] ?? null;
        $sliderAndBenefits->benefits_2_heading = $validatedData['benefits_2_heading'] ?? null;
        $sliderAndBenefits->benefits_2_large_heading = $validatedData['benefits_2_large_heading'] ?? null;
        $sliderAndBenefits->benefits_2_short_description = $validatedData['benefits_2_short_description'] ?? null;
        $sliderAndBenefits->benefits_3_heading = $validatedData['benefits_3_heading'] ?? null;
        $sliderAndBenefits->benefits_3_large_heading = $validatedData['benefits_3_large_heading'] ?? null;
        $sliderAndBenefits->benefits_3_short_description = $validatedData['benefits_3_short_description'] ?? null;

        // Handle image uploads if files are present
        if ($request->hasFile('slider_image')) {
            $sliderAndBenefits->slider_image = $this->upload_image($request->file('slider_image'));
        }

        if ($request->hasFile('form_right_image')) {
            $sliderAndBenefits->form_right_image = $this->upload_image($request->file('form_right_image'));
        }

        if ($request->hasFile('benefits_1_image')) {
            $sliderAndBenefits->benefits_1_image = $this->upload_image($request->file('benefits_1_image'));
        }

        if ($request->hasFile('benefits_2_image')) {
            $sliderAndBenefits->benefits_2_image = $this->upload_image($request->file('benefits_2_image'));
        }

        if ($request->hasFile('benefits_3_image')) {
            $sliderAndBenefits->benefits_3_image = $this->upload_image($request->file('benefits_3_image'));
        }

        // Save the model
        $sliderAndBenefits->save();

        // Return a response or redirect as needed
        return redirect()->back()->with('message', 'The Setting has been save/updated.');
    }

    public function onlinePageSetting(Request $request)
    {
        $online = OnlinePageSetting::first();
        $sliders = OnlinePageSlider::all();
        return view('admin.cms.pages.online', compact('online', 'sliders'));
    }

    public function saveOrUpdateOnlinePageSetting(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'top_section_small_heading' => 'required|string|max:255',
                'top_section_large_heading' => 'required|string|max:255',
                'left_card_heading' => 'required|string|max:255',
                'left_card_description' => 'required|string',
                'left_card_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'right_card_heading' => 'required|string|max:255',
                'right_card_description' => 'required|string',
                'right_card_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'middle_section_small_heading' => 'required|string|max:255',
                'middle_section_large_heading' => 'required|string|max:255',
                'middle_section_description' => 'required|string',
                'middle_section_left_big_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'middle_section_left_small_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'middle_section_left_youtube_url' => 'nullable|url',
                'middle_section_right_big_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'middle_section_right_small_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'middle_section_right_youtube_url' => 'nullable|url',
            ]);


            // Fetch the existing record or create a new one
            $sliderAndBenefits = OnlinePageSetting::first() ?? new OnlinePageSetting();

            // Update or set attributes
            $sliderAndBenefits->top_section_small_heading = $validatedData['top_section_small_heading'];
            $sliderAndBenefits->top_section_large_heading = $validatedData['top_section_large_heading'];

            // Handle image uploads
            if (isset($validatedData['slider_image'])) {
                $sliderAndBenefits->slider_image = $this->upload_image($validatedData['slider_image']);
            }

            $sliderAndBenefits->left_card_heading = $validatedData['left_card_heading'];
            $sliderAndBenefits->left_card_description = $validatedData['left_card_description'];

            // Handle left card image
            if (isset($validatedData['left_card_image'])) {
                $sliderAndBenefits->left_card_image = $this->upload_image($validatedData['left_card_image']);
            }

            $sliderAndBenefits->right_card_heading = $validatedData['right_card_heading'];
            $sliderAndBenefits->right_card_description = $validatedData['right_card_description'];

            // Handle right card image
            if (isset($validatedData['right_card_image'])) {
                $sliderAndBenefits->right_card_image = $this->upload_image($validatedData['right_card_image']);
            }

            $sliderAndBenefits->middle_section_small_heading = $validatedData['middle_section_small_heading'];
            $sliderAndBenefits->middle_section_large_heading = $validatedData['middle_section_large_heading'];
            $sliderAndBenefits->middle_section_description = $validatedData['middle_section_description'];

            // Handle middle section images
            if (isset($validatedData['middle_section_left_big_image'])) {
                $sliderAndBenefits->middle_section_left_big_image = $this->upload_image($validatedData['middle_section_left_big_image']);
            }
            if (isset($validatedData['middle_section_left_small_image'])) {
                $sliderAndBenefits->middle_section_left_small_image = $this->upload_image($validatedData['middle_section_left_small_image']);
            }
            if (isset($validatedData['middle_section_right_big_image'])) {
                $sliderAndBenefits->middle_section_right_big_image = $this->upload_image($validatedData['middle_section_right_big_image']);
            }
            if (isset($validatedData['middle_section_right_small_image'])) {
                $sliderAndBenefits->middle_section_right_small_image = $this->upload_image($validatedData['middle_section_right_small_image']);
            }

            // Set YouTube URLs
            $sliderAndBenefits->middle_section_left_youtube_url = $validatedData['middle_section_left_youtube_url'];
            $sliderAndBenefits->middle_section_right_youtube_url = $validatedData['middle_section_right_youtube_url'];

            // Save the model
            $sliderAndBenefits->save();
            return redirect()->back()->with('message', 'The Setting has been save/updated.');
        } catch (\Exception $exception) {

        }
    }

    public function onlinePageSliderSetting(Request $request)
    {
        $slider = OnlinePageSlider::find($request->id);
        return view('admin.cms.pages.slider.create', compact('slider'));
    }

    public function saveOrUpdateOnlinePageSliderSetting(Request $request)
    {
        $id = $request->id;
        $is_image_required = $id ? "nullable" : "required";
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => "$is_image_required|image|mimes:jpeg,png,jpg,gif|max:2048",
        ]);
        if ($id) {
            $save = OnlinePageSlider::findOrFail($id);
        } else {
            $save = new OnlinePageSlider();
        }
        $save->title = $request->title;
        $save->description = $request->description;
        if ($request->hasFile('image')) {
            $save->image = $this->upload_image($request->file('image'));
        }
        $save->save();
        return redirect()->back()->with('message', 'Slider saved successfully.');
    }

    public function delete_online_page_slider(Request $request)
    {
        OnlinePageSlider::where('id', $request->id)->delete();
        return redirect()->back()->with('message', 'Slider deleted successfully.');
    }

    public function blogs_page_setting(Request $request)
    {
        $blogs = Blog::all();
        return view('admin.cms.pages.blogs.manage', compact('blogs'));
    }

    public function create_blog(Request $request)
    {
        $blog = Blog::find($request->id);
        $categories = Category::all();
        return view('admin.cms.pages.blogs.create', compact('blog','categories'));
    }

    public function save_blog(Request $request)
    {
        $id = $request->id;
        $is_image_required = $id ? "nullable" : "required";
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'full_description' => "required",
            'image' => "$is_image_required|image|mimes:jpeg,png,jpg,gif|max:2048",
            'category_id' => 'required|integer',
        ]);
        if ($id) {
            $save = Blog::findOrFail($id);
        } else {
            $save = new Blog();
        }
        $save->title = $request->title;
        $save->description = $request->description;
        $save->category_id = $request->category_id;
        $save->full_description = $request->full_description;
        if ($request->hasFile('image')) {
            $save->image = $this->upload_image($request->file('image'));
        }
        $save->save();
        return redirect()->back()->with('message', 'Blog saved successfully.');
    }

    public function delete_blog(Request $request)
    {
        Blog::where('id', $request->id)->delete();
        return redirect()->back()->with('message', 'Blog deleted successfully.');
    }

    public function blogs()
    {
        $blogs = Blog::paginate(5);
        return view('front.blog', compact('blogs'));
    }

    public function blog_detail(Request $request)
    {
        $blog = Blog::findOrFail(decrypt($request->id));
        return view('front.blog_detail', compact('blog'));
    }

    public function faqs(Request $request)
    {
        $faqs = Faq::orderby('created_at','DESC')->paginate(5);
        return view('admin.cms.pages.faq.manage', compact('faqs'))->with('title', 'Faqs Setting');
    }

    public function save_faq(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'faq_title' => 'required',
            'faq_description' => 'required'
        ]);

        $save = new Faq();
        $save->faq_title = $request->faq_title;
        $save->faq_description = $request->faq_description;
        $save->save();

        return redirect()->back()->with('message', 'Faq saved successfully.');
    }

    public function update_faq(Request $request)
    {
        $faq = Faq::where('id', $request->id)->first();
        $faq->faq_title = $request->faq_title;
        $faq->faq_description = $request->faq_description;
        $faq->save();

        return redirect()->back()->with('message', 'Blog updated successfully.');
    }

    public function delete_faq(Request $request)
    {
        $id = decrypt($request->id);
        Faq::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Blog deleted successfully.');
    }

    public function edit_faq(Request $request)
    {
        $id = decrypt($request->id);
        $faq = Faq::where('id', $id)->first();
        return view('admin.cms.pages.faq.edit', compact('faq'))->with('title', 'Edit FAQ');
    }

}
