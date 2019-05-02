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
        $product->image = asset('images/'. $product->image);

        return view('products.show', compact('product'));
    }

    public function store(ProductRequest $request, ProductRepository $productRepository)
    {
        $imageName = $request->file('image');
        $imageName = time() .'' . request()->image->getClientOriginalName();
        request()->image->move(public_path('/images'), $imageName);

        $data = $request->only('price', 'description', 'name');
        $data['image'] = $imageName;
        //cria a model order
        // $productsJson = $request->get("produtos_json", "[]");
        // $products = json_decode($productsJson);
        // foreach ($products as $prod) {
        //     $item = new OrderItem();
        //     $item->price = $prod[2];
        //     $item->quantity = $prod[3];
        //     $item->product_id = $prod[0];
        //     $item->order_id = $order->id;
        //     $item->save();
        // }
        //FIM ORDER
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
        unlink('images/' . $product->image);

        $imageName = $request->file('image');
        $imageName = time() .'' . request()->image->getClientOriginalName();
        request()->image->move(public_path('/images'), $imageName);

        $data = $request->all();
        $data['image'] = $imageName;
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
            unlink('images/' . $product->image);
            dd($productRepository->delete($id));
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