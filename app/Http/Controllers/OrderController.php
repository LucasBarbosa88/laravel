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
        $replace = preg_replace('/[^a-z0-9]/i', '', $data['total_price']);
        $data['total_price'] = $replace;
        $repository->update($data, $id);
        $message = _m('order.success.create');
        return $this->chooseReturn('success', $message, 'orders.index');
    }

    /**
     * @param Request $request
     * @param null $id
     * @return \Closure
     */
    protected function getCallableSave(Request $request, $id = null)
    {
        return function () use ($request, $id) {
            $listRequest = $request->get("products_list", "[]");
            $this->throwIf(! $request->get("payway") && $request->get("payway") !== "0", "Tipo de Pagamento não informado");
            $this->insertOrUpdate($id, [
                "canceled"          => false,
                "print_client"      => $request->get("print_client", false),
                "client_name"       => $request->get("client_name", null),
                "client_type"       => $request->get("client_type", null),
                "client_cpf"        => $request->get("client_cpf", null),
                "client_cnpj"       => $request->get("client_cnpj", null),
                "payway"            => $request->get("payway"),
                "total_price"       => moneyToFloat($request->get("total_price", "0.00")),
                "products_list"     => $listRequest,
            ]);
        };
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