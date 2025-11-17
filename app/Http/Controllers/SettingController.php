<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('is_admin');
    }
    public function about()
    {

        return view('admin.cms.about');

    }

    public function aboutSave(Request $request)
    {
        $request->validate([
            'about_title'=>'required',
            'about_description'=>'required',
            'about_url'=>'required',


        ]);
        $setting = $request->except('_token');
        foreach ($setting as $key => $value) {
            if (empty($value))
                continue;
            $set = Setting::where('key', $key)->first() ?: new Setting();
            $set->key = $key;
            $set->value = $value;
            $set->save();

            if ($request->hasFile($key)) {
                $existing = Setting::where('key', '=', $key)->first();
                if ($existing) {
                    $ex_path = "uploads/cms/".$existing->setting;
                    if (File::exists($ex_path)) {
                        File::delete($ex_path);
                    }
                    $image = $request->file($key);
                    $name = $image->getClientOriginalName();
                    $name = str_replace(" ", "-", $name);
                    $image->move('uploads/cms/', $name);
                    Setting::where('key', '=', $key)->update([
                        'value' => "uploads/cms/".$name
                    ]);
                }
            }
        }
        return redirect()->back()->with('message', 'The About has been save/updated.');
    }

    public function siteSEO()
    {
        return view('admin.cms.seo');
    }
    
    public function siteConfig()
    {

        return view('admin.cms.setting');
    }

    public function settingSave(Request $request)
    {

        $setting = $request->except('_token');
        foreach ($setting as $key => $value) {
            if (empty($value))
                continue;
            $set = Setting::where('key', $key)->first() ?: new Setting();
            $set->key = $key;
            $set->value = $value;
            $set->save();

            if ($request->hasFile($key)) {
                $existing = Setting::where('key', '=', $key)->first();
                if ($existing) {
                    $ex_path = "uploads/cms/".$existing->setting;
                    if (File::exists($ex_path)) {
                        File::delete($ex_path);
                    }
                    $image = $request->file($key);
                    $name = $image->getClientOriginalName();
                    $image->move('uploads/cms/', $name);
                    Setting::where('key', '=', $key)->update([
                        'value' => "uploads/cms/".$name
                    ]);
                }
            }
        }
        return redirect()->back()->with('message', 'The Site Config has been save/updated.');
    }

    // Privacy

    public function privacyPolicy()
    {

        return view('admin.cms.privacy');

    }

    public function privacyPolicySave(Request $request)
    {
        $request->validate([
            'privacy_title'=>'required',
            'privacy_description'=>'required',



        ]);
        $setting = $request->except('_token');
        foreach ($setting as $key => $value) {
            if (empty($value))
                continue;
            $set = Setting::where('key', $key)->first() ?: new Setting();
            $set->key = $key;
            $set->value = $value;
            $set->save();

            if ($request->hasFile($key)) {
                $existing = Setting::where('key', '=', $key)->first();
                if ($existing) {
                    $ex_path = "uploads/cms/".$existing->setting;
                    if (File::exists($ex_path)) {
                        File::delete($ex_path);
                    }
                    $image = $request->file($key);
                    $name = $image->getClientOriginalName();
                    $image->move('uploads/cms/', $name);
                    Setting::where('key', '=', $key)->update([
                        'value' => "uploads/cms/".$name
                    ]);
                }
            }
        }
        return redirect()->back()->with('message', 'The Privacy Policy has been save/updated.');
    }

    public function termCondition()
    {

        return view('admin.cms.term');

    }

    public function termConditionSave(Request $request)
    {
        $request->validate([
            'term_title'=>'required',
            'term_description'=>'required',



        ]);
        $setting = $request->except('_token');
        foreach ($setting as $key => $value) {
            if (empty($value))
                continue;
            $set = Setting::where('key', $key)->first() ?: new Setting();
            $set->key = $key;
            $set->value = $value;
            $set->save();

            if ($request->hasFile($key)) {
                $existing = Setting::where('key', '=', $key)->first();
                if ($existing) {
                    $ex_path = "uploads/cms/".$existing->setting;
                    if (File::exists($ex_path)) {
                        File::delete($ex_path);
                    }
                    $image = $request->file($key);
                    $name = $image->getClientOriginalName();
                    $image->move('uploads/cms/', $name);
                    Setting::where('key', '=', $key)->update([
                        'value' => "uploads/cms/".$name
                    ]);
                }
            }
        }
        return redirect()->back()->with('message', 'Terms and conditions  has been save/updated.');
    }



}
