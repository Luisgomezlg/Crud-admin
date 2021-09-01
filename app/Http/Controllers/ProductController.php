<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $photo, $description, $quantity;
    public function index()
    {
        //
        $products = Product::paginate(5);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('products.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        
        $request->validate([
            'photo' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            
        ]);
        $imagen = $request->file('photo')->store('images','public');
        
        
        Product::create([
           'photo' => $imagen,
           'description' => $request->description,
           'quantity' => $request->quantity,
    
        ]);
        return redirect()->route('products.index');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //

        return view("products.editar", compact('product'));
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
        //
        $request->validate([
            'description' => 'required',
            'quantity' => 'required',
            
        ]);
        $prod = $request->all();

        if ($photo = $request->file('photo')) {
            $rutaGuardarImg = 'photos/';
            $imagenProducto = date('YmdHis') . "." . $photo->getClientOriginalExtension();
            $photo->move($rutaGuardarImg, $imagenProducto);
            $prod['photo'] = "$imagenProducto";
        }else{
            unset($prod['photo']);
        }
        $product->update($prod);
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();
        return redirect()->route('products.index');
    }
}
