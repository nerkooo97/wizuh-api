<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use ApiChef\Obfuscate\Support\Facades\Obfuscate;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'city')->paginate();
        
        foreach ($products as $product) {
            $hashproductId = Obfuscate::encode($product->id);
            $product->id = $hashproductId;
        }

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    public function show(string $id)
    {
        // Dekodiraj ID pre pretraživanja
        $decodedId = Obfuscate::decode($id);
    
        // Pokušaj da nađeš proizvod ili baci izuzetak ako ne postoji
        $product = Product::findOrFail($decodedId);
    
        // Vraća originalni ID uz proizvod
        return response()->json([
            'id' => $id, // Ovdje šalješ originalni obfuskovani ID
            'product' => $product
        ]);
    }
    

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json($product);
    }

    public function destroy($id)
    {
        Product::destroy($id);
        return response()->json(null, 204);
    }
}
