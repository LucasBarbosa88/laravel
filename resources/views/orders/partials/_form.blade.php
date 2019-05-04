@csrf
<div class="form-group row">
    <label for="created_at" class="col-sm-1 col-form-label text-md-right">Data: </label>
    <div class="col-md-2">
        <input type="text" name="created_at" disabled class="form-control" id="created_at" value="{{old('created_at') ?? $order->created_at ?? ''}}">
    </div>
    <label for="updated_at" class="col-sm-3 col-form-label text-md-right">Ultima Atualização: </label>
    <div class="col-md-2">
        <input id="updated_at" disabled type="text" class="form-control" name="updated_at" value="{{ old('updated_at') ?? $order->updated_at ?? '' }}">
    </div>
    
</div>
<div class="form-group row">
    <label for="client_name" class="col-sm-1 col-form-label text-md-right">Cliente: </label>
    <div class="col-md-7">
        <input id="client_name" type="text" class="form-control{{ has_error('client_name', 'has-danger') }}" name="client_name" value="{{ old('client_name') ?? $order->client_name ?? '' }}">
        @errorblock('client_name')
    </div>
</div>
<hr />
<div class="form-group row">
    <label for="barcode" class="col-sm-3 col-form-label text-md-right">Código de Barras:</label>
    <div class="col-md-3">
        <input type="number" autofocus name="barcode" id="barcode" class="form-control">
    </div>
    <label for="product_id" class="col-sm-1 col-form-label text-md-right">Produto:</label>
    <div class="col-md-3">
        <select name="product_id" id="product_id" class="form-control">
            @foreach($products as $prod)
                <option value="{{$prod->id}}">{{$prod->description}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="product_price" class="col-sm-3 col-form-label text-md-right">Valor:</label>
    <div class="col-md-2">
        <input type="text" name="product_price" id="product_price" class="form-control">
    </div>
    <label for="product_count" class="col-sm-2 col-form-label text-md-right">Quantidade:</label>
    <div class="col-md-2">
        <input type="number" name="product_count" value="1" id="product_count" class="form-control integer">
    </div>
    <button type="button" class="btn-dark btn btn-small" id="btnAddProd" {{@$action !== "show" ? "" : "disabled"}}>Adicionar</button>
</div>
<div class="form-group row">
    <input type="text" name="products_list" id="products_list" style="display: none" value="{{ old('products_list') ?? $order->products_list ?? '' }}"/>
    <div class="col-sm-10 offset-1">
        <table class="table table-sm table-condensed table-stripped" id="order-list">
            <thead>
            <tr>
                <th>Cód Produto</th>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Valor Unitário</th>
                <th>Valor Total</th>
                <th class="table-row-actions">Ações</th>
            </tr>
            </thead>
            <tbody>
            {{--@if(isset($order) && $order)--}}
            {{--@foreach(json_decode($products) as $item)--}}
            {{--<tr>--}}
            {{--<td>{{$item->product_id}}</td>--}}
            {{--<td>{{$item->product_name}}</td>--}}
            {{--<td>{{$item->count}}</td>--}}
            {{--<td>{{$item->price}}</td>--}}
            {{--<td>{{$item->total_price}}</td>--}}
            {{--<td class="table-row-actions">--}}
            {{--<button type="button" class="btn btn-danger btn-sm btnRemove">Remover</button>--}}
            {{--</td>--}}
            {{--</tr>--}}
            {{--@endforeach--}}
            {{--@endif--}}
            </tbody>
        </table>
    </div>
</div>
<hr />
<div class="form-group row">
    <label for="total_price" class="col-sm-1 col-form-label text-md-right">Total:</label>
    <div class="col-md-2">
        <input id="total_price" type="text" class="form-control {{ has_error('total_price', 'has-danger')  }}" name="total_price" value="{{ old('total_price') ?? $order->total_price ??  '' }}">
        @errorblock('total_price')
    </div>
</div>
<script type="text/javascript" src="{{ url('js/order.js') }}"></script>
<script type="text/javascript">
    let tempProducts = '{!! $products  !!}';
    if (tempProducts.length === 0) {
        tempProducts = {};
    } else {
        try {
            tempProducts = JSON.parse(tempProducts);
        } catch (e) {
            tempProducts = {};
            reportLog(e);
        }
    }
    const productsList = tempProducts;
</script>
