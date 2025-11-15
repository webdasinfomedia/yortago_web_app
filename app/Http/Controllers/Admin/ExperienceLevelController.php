<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExperienceLevel;
use Illuminate\Http\Request;

class ExperienceLevelController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function index(Request $request)
    {

        $lists=ExperienceLevel::orderBy('id','desc')->get();
        return view('admin.cms.experiencelevel.list',get_defined_vars());
    }


    public function save(Request $request)
    {
        $request->validate([
            'heading'=>'required',
            'sub_heading'=>'required',


        ]);



        ExperienceLevel::create([
           'sub_heading'=>$request['sub_heading'],
           'heading'=>$request['heading'],
        ]);



        return redirect()->back()->with('message','ExperienceLevel has been added');
    }

    public function update(Request $request)
    {

        $request->validate([
            'heading'=>'required',
            'sub_heading'=>'required',
        ]);

        ExperienceLevel::find($request['id'])->update([
            'sub_heading'=>$request['sub_heading'],
            'heading'=>$request['heading'],
         ]);





        return redirect()->back()->with('message','ExperienceLevel has been Updated');
    }

    public function delete($id)
    {
        ExperienceLevel::where('id',$id)->delete();
        return redirect()->back()->with('message','ExperienceLevel has been deleted');
    }

}
