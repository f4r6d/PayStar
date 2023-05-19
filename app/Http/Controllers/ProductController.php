<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Cart\Contracts\CartInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('home', 'show', 'showGuest');
        $this->authorizeResource(Product::class, 'product');
    }

    public function home()
    {
        return view('welcome', ['products' => Product::orderBy('created_at', 'desc')->paginate(4)]);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('products.index', ['products' => Product::orderBy('created_at', 'desc')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'image',

        ]);

        if ($request->image) {
            $image = $request->image->store('public/products/image');
        } else {
            $image = null;
        }

        $title = ucwords(strtolower($request->name));

        Product::create([
            'name' => $title,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $image,
        ]);

        return to_route('products.index')->with([
            'msg' => 'added to product list',
            'title' => $title,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {

        return view('products.show', ['product' => $product]);
    }

    public function showGuest(Product $product)
    {

        return view('products.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.form', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'image',

        ]);

        if ($request->image) {
            $image = $request->image->store('public/products/image');
        } else {
            $image = $product->image;
        }

        $title = ucwords(strtolower($request->name));

        $product->update([
            'name' => $title,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $image,
        ]);

        return to_route('products.index')->with([
            'msg' => 'updated',
            'title' => $title,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with([
            'msg' => $product->name . ' deleted',
            'title' => 'Warning',
        ]);
    }
}
