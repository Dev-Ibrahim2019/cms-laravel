<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(12);
        return response()->view('cms.category.index', ["categories"=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('cms.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            'name'=>'required||string||min:3||max:20',
            'active'=>'required||boolean'
        ]);
        if (!$validator->fails()) {
            //TODO: CREATE NEW CATEGORY
            $category = new Category();
            $category->name = $request->name;
            $category->active = $request->active;
            $isSaved = $category->save();
            return response()->json([
                'message'=>$isSaved ? 'Saved Successfully' : 'Failed to save'
            ], $isSaved? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            // VALIDATION FAILED
            return response()->json([
                'message'=>$validator->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return response()->view('cms.category.edit', ['category'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator($request->all(), [
            'name'=>'required||string||min:3||max:20',
            'active'=>'required||boolean'
        ]);
        if (!$validator->fails()) {
            //TODO: CREATE NEW CATEGORY
            $category->name = $request->name;
            $category->active = $request->active;
            $isUpdated = $category->save();
            return response()->json([
                'message'=>$isUpdated ? 'Updated Successfully' : 'Failed to Update'
            ], $isUpdated? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            // VALIDATION FAILED
            return response()->json([
                'message'=>$validator->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $isDeleted = $category->delete();
        if ($isDeleted) {
            return response()->json([
                'title'=>'Success',
                'text'=>'Category Deleted successfully',
                'icon'=>'success'
            ], Response::HTTP_OK);
        }else {
            return response()->json([
                'title'=>'Failed',
                'text'=>'Failed to delete',
                'icon'=>'error'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
