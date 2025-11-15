<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Age;
use Illuminate\Http\Request;

class AgeController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function index(Request $request)
    {

        $lists=Age::orderBy('id','desc')->get();
        return view('admin.cms.age.list',get_defined_vars());
    }


    public function save(Request $request)
    {
        $request->validate([
            'age_range'=>'required',


        ]);



        Age::create([
           'age_range'=>$request['age_range']
        ]);



        return redirect()->back()->with('message','Focus has been added');
    }

    public function update(Request $request)
    {

        $request->validate([
            'age_range'=>'required',

        ]);

        Age::find($request['id'])->update([
            'age_range'=>$request['age_range']

        ]);





        return redirect()->back()->with('message','Focus has been Updated');
    }

    public function delete($id)
    {
        Age::where('id',$id)->delete();
        return redirect()->back()->with('message','Focus has been deleted');
    }

}