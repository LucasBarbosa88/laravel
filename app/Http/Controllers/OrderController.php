<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepository;

use App\Http\Requests\OrderRequest;
use App\Repositories\ProductRepository;

use Illuminate\Http\Request;
use App\Http\Resources\Order as OrderResource;

class OrderController extends Controller
{
    public function index()
    {
        return view('orders.index');
    }

    public function create(ProductRepository $repository)
    {
        $products = $repository->all();
        return view('orders.create', compact('products'));
    }

    public function edit(OrderRepository $orderRepository, ProductRepository $repository,$id)
    {
        $order = $orderRepository->find($id);
        $products = $repository->all();
        return view('orders.edit', compact('products', 'order'));
    }

    public function show(OrderRepository $repository, ProductRepository $productRepository, $id)
    {
        $order = $repository->find($id);
        $products = $productRepository->all();
        return view('orders.show', compact('order', 'products'));
    }

    public function store(OrderRepository $repository, Request $request)
    {
        $data = $request->all();
        $replace = preg_replace("/[^0-9]/", '', $data['total_price']);
        $data['total_price'] = $replace;
        $repository->create($data);
        $message = _m('order.success.create');
        return $this->chooseReturn('success', $message, 'orders.index');
    }

    public function update(Request $request, OrderRepository $repository, $id)
    {
        $data = $request->all();
        $replace = preg_replace("/[^0-9]/", '', $data['total_price']);
        $data['total_price'] = $replace;
        $repository->update($id, $data);
        $message = _m('order.success.create');
        return $this->chooseReturn('success', $message, 'orders.index');
    }

    public function destroy(OrderRepository $orderRepository, $id)
    {
        try {
            $order = $orderRepository->find($id);
            $orderRepository->delete($id);
            return $this->chooseReturn('success', _m('order.success.destroy'));
        } catch (\Exception $e) {
            return $this->chooseReturn('error', _m('order.error.destroy'));
        }
    }

    public function getPagination($pagination)
    {
        return $pagination->repository(OrderRepository::class)
            ->resource(OrderResource::class);
    }
}