<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{


    public function __construct()
    {
        $this->middleware('is_admin');
    }


    public function index(Request $request)
    {

        $lists=Slider::orderBy('id','desc')->get();


        return view('admin.cms.slider.list',get_defined_vars());
    }

    public function create(Request $request)
    {


        return view('admin.cms.slider.add');
    }

    public function save(Request $request)
    {

        $request->validate([
            'heading'=>'required',
            'sub_heading'=>'required',

        ]);

        $filename=null;
        if($request->hasfile('image')) {
            $image = $request->file('image');
            $filename = 'uploads/testimonial/' . time() . '.' . $image->getClientOriginalExtension();
            $movedFile = $image->move('uploads/testimonial/', $filename);
        }

        Slider::create([
            'heading'=>$request->heading,
            'sub_heading' => $request->sub_heading,
            'url' => $request->url,
            'image'=>$filename,
        ]);



        return redirect()->back()->with('message','Slider has been added');
    }



    public function update(Request $request)
    {

        $request->validate([
            'heading'=>'required',
            'sub_heading'=>'required',

        ]);

        $filename=null;
        if($request->hasfile('image')) {

            $image = $request->file('image');
            $filename = 'uploads/testimonial/' . time() . '.' . $image->getClientOriginalExtension();
            $movedFile = $image->move('uploads/testimonial/', $filename);

            Slider::find($request['id'])->update([
                'heading'=>$request->heading,
                'sub_heading' => $request->sub_heading,
                'url' => $request->url,
                'image'=>$filename,

            ]);
        }
        else{
            Slider::find($request['id'])->update([
                'heading'=>$request->heading,
                'sub_heading' => $request->sub_heading,
                'url' => $request->url,

            ]);
        }





        return redirect()->back()->with('message','Slider has been Updated');
    }


    public function edit($id)
    {

        $list=Slider::find($id);


        return view('admin.cms.slider.edit',get_defined_vars());
    }

    public function delete($id)
    {
        Slider::where('id',$id)->delete();
        return redirect()->back()->with('message','Slider has been deleted');
    }

}
