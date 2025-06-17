<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return Inertia::render('Productos/Index', ['products' => $products]);
    }

    public function create()
    {
        return Inertia::render('Productos/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'size' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:50',
            'points' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('imagenes_Misuji'), $imageName);
            $data['image_url'] = 'imagenes_Misuji/' . $imageName;
        }

        Product::create($data);
        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente');
    }

    public function edit(Product $product)
    {
        return Inertia::render('Productos/Edit', ['product' => $product]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'size' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:50',
            'points' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('imagenes_Misuji'), $imageName);
            $data['image_url'] = 'imagenes_Misuji/' . $imageName;
        }

        $product->update($data);
        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente');
    }
} 