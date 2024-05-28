<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = DB::table('products')
            ->when($request->input('product_name'), function ($query, $product_name) {
                return $query->where('product_name', 'like', '%' . $product_name . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.products.index', compact('products'));
    }

    public function create()
    {
        return view('pages.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|min:3|unique:products',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'expiry_date' => 'required',
        ]);

        $product = new \App\Models\Product;
        $product->product_name = $request->product_name;
        $product->price = (int) $request->price;
        $product->stock = (int) $request->stock;
        $product->expiry_date = $request->expiry_date;
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product successfully created');
    }

    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        return view('pages.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'min:3',
            'price' => 'integer',
            'stock' => 'integer',
            'expiry_date' => 'required',
        ]);

        $product = \App\Models\Product::findOrFail($id);

        // Update product attributes
        $product->product_name = $request->product_name;
        $product->price = (int) $request->price;
        $product->stock = (int) $request->stock;
        $product->expiry_date = $request->expiry_date;

        // Save the changes to the database
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product successfully updated');
    }

    public function destroy($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product successfully deleted');
    }
}
