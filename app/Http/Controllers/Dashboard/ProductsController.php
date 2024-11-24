<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request = request();
        $products = Product::with(['category', 'store'])->filter($request->query())->paginate();
        return view('dashboard.products.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product=new Product();
        return view('dashboard.products.create',get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user=Auth::user();
        $store_id=$user->store->id;
        $request->merge([
            'slug' => Str::slug($request->post('name')),
        ]);
        $data = $request->except('image','tags');

        $data['image'] = $this->uploadImage($request);
        $data['store_id']=$store_id;
        $product = Product::create($data);

        $tags = json_decode($request->tags);

        $tag_ids = [];

        $saved_tags = Tag::all();
        foreach ($tags as $item) {
            $slug = Str::slug($item->value);
            $tag = $saved_tags->where('slug', $slug)->first();
            if (!$tag) {
                $tag = Tag::create([
                    'name' => $item->value,
                    'slug' => $slug,
                ]);
            }
            $tag_ids[] = $tag->id;
        }

        $product->tags()->sync($tag_ids);

        return Redirect::route('dashboard.products.index')->with('success', 'Product Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $tags = implode(',', $product->tags()->pluck('name')->toArray());
        return view('dashboard.products.edit', compact('product', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //$this->authorize('update', $product);

        $product->update($request->except('tags'));

        //$tags=explode(',',$request->tags);
        $tags = json_decode($request->tags);

        $tag_ids = [];

        $saved_tags = Tag::all();
        foreach ($tags as $item) {
            $slug = Str::slug($item->value);
            $tag = $saved_tags->where('slug', $slug)->first();
            if (!$tag) {
                $tag = Tag::create([
                    'name' => $item->value,
                    'slug' => $slug,
                ]);
            }
            $tag_ids[] = $tag->id;
        }

        $product->tags()->sync($tag_ids);

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }
        $file = $request->file('image');    //UplodedFile Object
        $path = $file->store('products', [   //دى بتاخد الملف من مكانه المؤقت الي الفولدر الي انت بتديهولها
            'disk' => 'public',             //default is local disk
        ]);
        return $path;
    }
}
