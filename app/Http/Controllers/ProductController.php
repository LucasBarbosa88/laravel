<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;

use App\Http\Requests\ProductRequest;

use Illuminate\Http\Request;
use App\Http\Resources\Product as ProductResource;

class ProductController extends Controller
{

    public function index()
    {
        return view('products.index');
    }

    public function create()
    {
        return view('products.create');
    }

    public function edit(ProductRepository $productRepository, $id)
    {
        $product = $productRepository->find($id);
        return view('products.edit', compact('product'));
    }

    public function show(ProductRepository $productRepository, $id)
    {
        $product = $productRepository->find($id);
        return view('products.show', compact('product'));
    }

    public function store(ProductRequest $request, ProductRepository $productRepository)
    {
        $data = $request->only('price', 'description', 'name', 'sku');        
        $replace = preg_replace('/[^a-z0-9]/i', '', $data['price']);
        $data['price'] = $replace;
        $data['sku'] = ' ';
        $productRepository->create($data);

        $message = _m('product.success.create');
        return $this->chooseReturn('success', $message, 'products.index');
    }

    public function update(ProductRequest $request, ProductRepository $productRepository, $id)
    {
        $product = $productRepository->find($id);

        $data = $request->all();
        $request->value = $request->value;
        $replace = preg_replace('/[^a-z0-9]/i', '', $request);
        $request->value = $replace;

        $productRepository->update($id, $data);

        $message = _m('product.success.update');
        return $this->chooseReturn('success', $message, 'products.index');
    }

    public function destroy(ProductRepository $productRepository, $id)
    {
        try {
            $product = $productRepository->find($id);
            $productRepository->delete($id);
            return $this->chooseReturn('success', _m('product.success.destroy'));
        } catch (\Exception $e) {
            return $this->chooseReturn('error', _m('product.error.destroy'));
        }
    }

    public function getPagination($pagination)
    {
        return $pagination->repository(ProductRepository::class)
            ->resource(ProductResource::class);
    }
}