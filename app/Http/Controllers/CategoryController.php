<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();

        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json(array(
              'error' => 1,
              'vderror' => 1,
              'errors' => $validator->getMessageBag()->toArray(),
            ), 200);
          }

          $cust = new Category();
          $cust->name = $request->name;
          $cust->parent_id = $request->parent_id;
        if ($cust->save()) {
            return response()->json([
                'error' => 0,
                'msg' => 'Category created successfully.',
            ]);
        } else {
            return response()->json([
                'error' => 1,
                'msg' => 'Failed to add the Category. Please try again.',
            ]);
        }
    }
}
