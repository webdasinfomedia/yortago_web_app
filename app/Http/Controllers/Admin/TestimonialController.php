<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{

    public function __construct()
    {
        $this->middleware('is_admin');
    }


    /*******  List Testimonial  *******/


    public function index(Request $request)
    {

        $lists=Testimonial::orderBy('id','desc')->get();


        return view('admin.testimonials.list',get_defined_vars());
    }


     /*******  Create Testimonial  *******/



    public function create(Request $request)
    {


        return view('admin.testimonials.add');
    }

    public function save(Request $request)
    {

        $request->validate([
            'author_name'=>'required',
            'author_designation'=>'required',
            'description'=>'required',

        ]);

        $filename=null;
        if($request->hasfile('image')) {
            $image = $request->file('image');
            $filename = 'uploads/testimonial/' . time() . '.' . $image->getClientOriginalExtension();
            $movedFile = $image->move('uploads/testimonial/', $filename);
        }

        Testimonial::create([
            'author_name'=>$request->author_name,
            'author_designation' => $request->author_designation,
            'description' => $request->description,
            'image'=>$filename,
        ]);



        return redirect('/admin/testimonial')->with('message','Testimonial has been added');
    }



    public function update(Request $request)
    {

        $request->validate([
            'author_name'=>'required',
            'author_designation'=>'required',
            'description'=>'required',

        ]);

        $filename=null;
        if($request->hasfile('image')) {

            $image = $request->file('image');
            $filename = 'uploads/testimonial/' . time() . '.' . $image->getClientOriginalExtension();
            $movedFile = $image->move('uploads/testimonial/', $filename);

            Testimonial::find($request['id'])->update([
                'author_name'=>$request->author_name,
                'author_designation' => $request->author_designation,
                'description' => $request->description,
                'image'=>$filename,

            ]);
        }
        else{
            Testimonial::find($request['id'])->update([
                'author_name'=>$request->author_name,
                'author_designation' => $request->author_designation,
                'description' => $request->description,

            ]);
        }





        return redirect('/admin/testimonial')->with('message','Testimonial has been Updated');
    }


    public function edit($id)
    {

        $list=Testimonial::find($id);


        return view('admin.testimonials.edit',get_defined_vars());
    }

    public function delete($id)
    {
        Testimonial::where('id',$id)->delete();
        return redirect()->back()->with('message','Testimonial has been deleted');
    }
}
