<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function categories()
    {
        $categories = Category::all();
        return view('admin.categories.manage', get_defined_vars())->with('title', 'Manage Category');
    }

    public function create_category()
    {
        return view('admin.categories.create')->with('title', 'Create Category');
    }

    public function edit_category(Request $request)
    {
        $category = Category::findOrFail($request->id);
        return view('admin.categories.edit', get_defined_vars())->with('title', 'Edit Category');
    }

    public function delete_category(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->delete();
        return redirect()->back()->with('message', 'Category deleted successfully')->with('active_tab', 'categories-list');
    }

    public function save_category(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories'
        ]);
        $check = Category::where('name', $request->name)->first();
        if ($check) {
            return redirect()->back()->with('message', 'Category name already exists!');
        }
        $category = new Category();
        $category->name = $request->name;
        $category->save();
  
        return redirect()->back()->with('message', 'Category created successfully!')->with('active_tab', 'categories-list');
    }

    public function update_category(Request $request)
    {
        //validate and shoudl not allow to update if name already exists
        $request->validate([
            'name' => 'required|unique:categories,name,' . $request->id
        ]);
        $category = Category::findOrFail($request->id);
        $category->name = $request->name;
        $category->save();
        return redirect()->back()->with('message', 'Category updated successfully')->with('active_tab', 'categories-list');
    }

}
