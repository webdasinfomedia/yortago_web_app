<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BodyPart;
use Illuminate\Http\Request;

class BodypartController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('is_admin');
    }
    public function bodyparts()
    {
        $bodyparts = BodyPart::all();
        return view('admin.bodyparts.manage',get_defined_vars())->with('title', 'Manage Bodypart');
    }

    public function create_bodypart()
    {
        return view('admin.bodyparts.create')->with('title', 'Create Bodypart');
    }

    public function edit_bodypart(Request $request)
    {
        $bodypart = BodyPart::findOrFail($request->id);
        return view('admin.bodyparts.edit',get_defined_vars())->with('title', 'Edit Bodypart');
    }

    public function delete_bodypart(Request $request)
    {
        $bodypart = BodyPart::findOrFail($request->id);
        $bodypart->delete();
        return redirect()->back()->with('message', 'Bodypart deleted successfully')->with('active_tab', 'bodyparts');
    }

    public function save_bodypart(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:body_parts'
        ]);
        $check = BodyPart::where('name', $request->name)->first();
        if ($check) {
            return redirect()->back()->with('message', 'Bodypart name already exists!');
        }
        $bodypart = new BodyPart();
        $bodypart->name = $request->name;
        $bodypart->save();

        return redirect()->back()->with('message', 'Bodypart created successfully!')->with('active_tab', 'bodyparts');
    }

    public function update_bodypart(Request $request)
    {
        //validate and shoudl not allow to update if name already exists
        $request->validate([
            'name' => 'required|unique:body_parts,name,' . $request->id
        ]);
        $bodypart = BodyPart::findOrFail($request->id);
        $bodypart->name = $request->name;
        $bodypart->save();

        return redirect()->back()->with('message', 'Bodypart updated successfully!')->with('active_tab', 'bodyparts');
    }

}
