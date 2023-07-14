<?php

namespace App\Http\Controllers;

use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function createcategory()
    {
        return view('category.createcategory');
    }

    public function storecategory(Request $request)
    {

        $request->validate([
            'name' => 'required',
        ]);


        $category = new Category();
        $category->name = $request->input('name');
        $category->status = $request->has('status') ? 1 : 0;

        if (!$request->has('status')) {
            $category->status = 0;
        }

        $category->save();
        return redirect()->back()->with('success', 'Category created successfully.');
    }
    public function indexcategory()
    {
        return view('category.indexcategory');
    }
    public function viewList()
    {
        $category = Category::all();
        return response()->json($category);
    }
    function editcategory($id)
    {
        $category = Category::find($id);
        return view('/category.editcategory', compact('catergory'));
    }


    public function deleteCategory(Request $request)
    {
        $id = $request->input('id');
        $category = Category::find($id);

        if ($category) {
            $category->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Category not found']);
    }
}
