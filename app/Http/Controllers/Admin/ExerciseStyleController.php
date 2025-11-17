<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExerciseStyle;
use Illuminate\Http\Request;

class ExerciseStyleController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function exercise_style()
    {
        $exercise_styles = ExerciseStyle::all();
        return view('admin.exercise_style.manage',get_defined_vars())->with('title', 'Manage Exercise Styles');
    }

    public function create_exercise_style()
    {
        return view('admin.exercise_style.create')->with('title', 'Create Exercise Style');
    }

    public function edit_exercise_style(Request $request)
    {
        $exercise_style = ExerciseStyle::findOrFail($request->id);
        return view('admin.exercise_style.edit',get_defined_vars())->with('title', 'Edit Exercise Style');
    }

    public function delete_exercise_style(Request $request)
    {
        $exercise_style = ExerciseStyle::findOrFail($request->id);
        $exercise_style->delete();
        return redirect()->back()->with('message', 'Exercise Style deleted successfully')->with('active_tab', 'exercise-styles');
    }

    public function save_exercise_style(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:exercise_styles'
        ]);
        $check = ExerciseStyle::where('name', $request->name)->first();
        if ($check) {
            return redirect()->back()->with('message', 'Exercise Style name already exists!');
        }
        $exercise_style = new ExerciseStyle();
        $exercise_style->name = $request->name;
        $exercise_style->save();
        return redirect()->back()->with('message', 'Exercise Style created successfully!')->with('active_tab', 'exercise-styles');
    }

    public function update_exercise_style(Request $request)
    {
        //validate and shoudl not allow to update if name already exists
        $request->validate([
            'name' => 'required|unique:exercise_styles,name,' . $request->id
        ]);
        $exercise_style = ExerciseStyle::findOrFail($request->id);
        $exercise_style->name = $request->name;
        $exercise_style->save();
        return redirect()->back()->with('message', 'Exercise Style updated successfully!')->with('active_tab', 'exercise-styles');
    }
}
