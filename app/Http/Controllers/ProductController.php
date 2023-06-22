<?php

namespace App\Http\Controllers;

use App\Actions\Options\GetCategoryOptions;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Resources\Product\ProductListResource;
use App\Http\Resources\Product\SubmitProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __construct(ProductService $productService, GetCategoryOptions $getCategoryOptions)
    {
        $this->productService = $productService;
        $this->getCategoryOptions = $getCategoryOptions;
    }

    public function index()
    {
        return Inertia::render('admin/product/index', [
            "title" => 'POS | Product',
            "additional" => [
               "category_list" => $this->getCategoryOptions->handle()
            ]
        ]);
    }

    public function getData(Request $request){
        try {
            $data  = $this->productService->getData($request);
            $result = new ProductListResource($data);
            return $this->respond($result);
            
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function createData(CreateProductRequest $request){
        try {
            $data  = $this->productService->createData($request);

            $result = new SubmitProductResource($data, 'Product has been created');

            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function deleteData($id){
        try {
            $data  = $this->productService->deleteData($id);

            $result = new SubmitProductResource($data, 'Product has been deleted');

            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

}
