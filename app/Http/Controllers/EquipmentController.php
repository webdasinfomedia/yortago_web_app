<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function index(Request $request)
    {

        $lists=Equipment::orderBy('id','desc')->get();
        return view('admin.cms.equipment.list',get_defined_vars());
    }


    public function save(Request $request)
    {
        $request->validate([
            'name'=>'required',


        ]);



        Equipment::create([
           'name'=>$request['name']
        ]);



        return redirect()->back()->with('message','Equipment has been added');
    }

    public function update(Request $request)
    {

        $request->validate([
            'name'=>'required',

        ]);

        Equipment::find($request['id'])->update([
            'name'=>$request['name']

        ]);





        return redirect()->back()->with('message','Equipment has been Updated');
    }

    public function delete($id)
    {
        Equipment::where('id',$id)->delete();
        return redirect()->back()->with('message','Equipment has been deleted');
    }

}
