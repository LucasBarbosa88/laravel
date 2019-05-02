<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepository;

use App\Http\Requests\OrderRequest;

use Illuminate\Http\Request;
use App\Http\Resources\Order as OrderResource;

class OrderController extends Controller
{
    public function index()
    {
        return view('orders.index');
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        return $this->save("order", "create", $this->getCallableSave($request));
    }

    public function update(Request $request, $id)
    {
        return $this->save("order", "edit", $this->getCallableSave($request, $id), $id);
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
//            $productsJson = json_decode($listRequst);
//            $this->throwIf(
//                json_last_error() !== JSON_ERROR_NONE,
//                "Não foi possível salvar o pedido, entre em contato com o suporte: " . json_last_error_msg()
//            );
            $this->throwIf(! $request->get("payway") && $request->get("payway") !== "0", "Tipo de Pagamento não informado");
//            $this->insertItems($productsJson);
            $this->insertOrUpdate($id, [
                "canceled"          => false,
                "print_client"      => $request->get("print_client", false),
                "client_name"       => $request->get("client_name", null),
                "client_type"       => $request->get("client_type", null),
                "client_cpf"        => $request->get("client_cpf", null),
                "client_cnpj"       => $request->get("client_cnpj", null),
                "payway"            => $request->get("payway"),
                "total_price"       => moneyToFloat($request->get("total_price", "R$ 0.00")),
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