<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request=request();
        $categories=Category::leftjoin('categories as parents','parents.id','=','categories.parent_id')
        ->select([
            'categories.*',
            'parents.name as parent_name'
        ])
        ->filter($request->query())->paginate(2);
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(Category::rules());
        $request->merge([
            'slug' => Str::slug($request->post('name')),
        ]);

        $data = $request->except('image');

        $data['image'] = $this->uploadImage($request);

        $category = Category::create($data);

        return Redirect::route('dashboard.categories.index')->with('success', 'Category Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $parents = Category::where('id', '<>', $category->id)
            ->where(function ($query) use ($category) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', '<>', $category->id);
            })
            ->get();
        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {

        $old_image = $category->image;
        $request->merge([
            'slug' => Str::slug($request->post('name')),
        ]);

        $data = $request->except('image');

        $new_image= $this->uploadImage($request);
        if($new_image){
            $data['image']=$new_image;
        }
        $category->update($data);

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image); //default is local disk
        }
        return Redirect::route('dashboard.categories.index')->with('success', 'Category Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete(); //هي ما بتحذف الابوجيكت هى بتحذف الداتا من الداتا من الداتا بيز بس الابوجيكت بيظل موجود وجواه بيناته على عكس ديستروي
        // if ($category->image) {
        //     Storage::disk('public')->delete($category->image); //default is local disk
        // }
        return Redirect::route('dashboard.categories.index')->with('success', 'Category Deleted!');
    }


    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }
        $file = $request->file('image');    //UplodedFile Object
        $path = $file->store('uploads', [   //دى بتاخد الملف من مكانه المؤقت الي الفولدر الي انت بتديهولها
            'disk' => 'public',             //default is local disk
        ]);
        return $path;
    }

    public function trash()
    {
        $categories=Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash',compact('categories'));
    }
    
    public function restore(Request $request,$id)
    {
        $category=Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('dashboard.categories_trash')->with('success','Category Restored!');
    }

    public function forcedelete($id)
    {
        $category=Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        if($category->image)
        {
              Storage::disk('public')->delete($category->image);
        }
        return redirect()->route('dashboard.categories_trash')->with('success','Category Deleted Forever!');
    }
}
