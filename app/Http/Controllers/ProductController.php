<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $products = Product::all();
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Log::info(var_dump($request));
        $product = new Product();
        
          $product->title = $request->get('title');
          $product->description = $request->get('description');
          $product->price = $request->get('price');
          $product->image = '';
          
        
          if ($request->hasFile('image')){
            $product->image    = $request->file('image')->store('product_image');
        }
        
        
    
          $product->save();
    
          return response()->json('successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function findByTitle($title){
        $products = Product::where('title', 'like' , '%' .$title .'%')->get();
        return response()->json($products);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        $product->update([
            'title'          => $request->title,
            'description'         => $request->description,
            'price'         => $request->price,
           
        ]);

        if ($request->hasFile('image'))
        {
            
            Storage::delete($product->image);
            $image_link = $request->file('image')->store('product_image');
            $product->update([ 'image' =>  $image_link]);
        }

      return response()->json('successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        $product->delete();

      return response()->json('successfully deleted');
    }
}
