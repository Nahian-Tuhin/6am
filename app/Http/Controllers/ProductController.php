<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $products = Product::filter()->paginate(10);
        } else {
            $products = auth()->user()->product()->filter()->paginate(10);
        }

        return view('product.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'title' => 'required|max:240',
            'slug' => 'required|unique:products,slug|max:250',
            'price' => 'required|max:255',
            'text' => 'required|max:65535',
            // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $imageName = $request->slug.'.'.$img->getClientOriginalExtension();
            $img->move(Storage::disk('public')->path('/uploads/product/'), $imageName);
        }


        // }
        //   $path = $request->file('file')->store('files');

        Product::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'price' => $request->price,
            'text' => $request->text,
            'image' => $imageName ?? 'default.png',
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $this->authorize('view', $product);
        return view('product.show', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        return view('product.edit', [
            'product' => $product
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);
        // dd($request->all());
        $request->validate([
            'title' => 'required|max:240',
            'slug' => 'required|max:250|unique:products,slug,'.$product->id,
            'price' => 'required|max:255',
            'text' => 'required|max:65535',
            // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        if ($request->hasFile('image')) {
            $old_pic_location = 'public/uploads/product/'.$product->image;
            $old_pic_name = $product->image;
            if ($old_pic_name != 'default.png' && Storage::disk('public')->exists($old_pic_location)) {
                Storage::disk('public')->delete($old_pic_location);
            }

            $img = $request->file('image');
            $imageName = $request->slug.'.'.$img->getClientOriginalExtension();
            $img->move(Storage::disk('public')->path('/uploads/product/'), $imageName);
        }


        $product->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'price' => $request->price,
            'text' => $request->text,
            'status' => $request->status,
            'image' => $imageName ?? $product->image,

        ]);
        return response()->json([
            'message' => 'Product updated successfully',
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $path = 'uploads/product/'.$product->image;
        $old_pic_name = $product->image;
        if ($old_pic_name != 'default.png' && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
        $destroy = $product->delete();
        return $destroy;
    }
}
