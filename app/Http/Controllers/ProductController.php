<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //
    public function index(Request $request)
    {
        $keywords = $request->get('search');
        $page = 10;

        if (!empty($keywords)) {
            $products = Product::where('name', 'LIKE', "%$keywords%")->orWhere('email', 'LIKE', "%$keywords%")->orWhere('address', 'LIKE', "%$keywords%")->latest()->paginate($page)->withQueryString();
        } else {
            $products = Product::latest()->paginate($page);
        }

        return view('product.index', ['product' => $products]);
    }

    public function create()
    {
        return view('product.add');
    }

    public function store(Request $request)
    {
        $product = new Product();

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'image' => 'required|image|mimes:png,jpg|max:1080'
        ]);

        $file_name = time() . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('image'), $file_name);
        $product->name = $request->name;
        $product->address = $request->address;
        $product->email = $request->email;
        $product->image = $file_name;

        $product->save();
        return redirect()->route('products.index')->with('success', 'products added successfully');
    }

    public function edit($id){
        $product = Product::findOrFail($id);
        return view('product.update',['product'=>$product]);
    }

    public function update(Request $request, Product $product){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            
        ]);

        $file_name = $request->hidden_product_image;

        if($request->image != ''){
            $file_name = time(). '.' .request()->image->getClientOriginalExtension();
            request()->image->move(public_path('image'),$file_name);
        }

        $product = Product::find($request->hidden_id);
        $product->address = $request->address;
        $product->email = $request->email;
        $product->name = $request->name;
        $product->image = $file_name;
        $product->save();

        return redirect()->route('products.index')->with('success','Product Updated successfully');
    }


    public function destroy($id)
    {
        
            # code...
            $product = Product::find($id);
            $image_path = public_path() . "/image/";
            $image = $image_path . $product->image;
            if (file_exists($image)) {
                @unlink($image);
            }
            $product->delete();
            return redirect()->route('products.index')->with('success', 'delete successfully');
        
    }
}
