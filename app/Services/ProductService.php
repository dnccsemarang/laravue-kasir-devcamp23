<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getData($request)
    {
        $search = $request->search;
        $filter_category = $request->filter_category;

        $query = Product::query();

        // Filtering data
        $query->when(request('search', false), function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        });
        $query->when(request('filter_category', false), function ($q) use ($filter_category) {
            $q->where('category_id', $filter_category);
        });

        return $query->paginate(10);
    }

    public function createData($request)
    {

        // Upload the image first
        $file = 'storage/'.$request->file('image')->store('assets/products', 'public');

        // Create the product after that
        $inputs = $request->only([
            'name',
            'description',
            'price',
            'stock',
            'category_id'
        ]);


        $inputs['image'] = $file;
        $product = Product::create($inputs);


        return $product;
    }

    public function deleteData($id){
        $product = Product::findOrFail($id);
        $product->delete();

        return $product;
    }
}
