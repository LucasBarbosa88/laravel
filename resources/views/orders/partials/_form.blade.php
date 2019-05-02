@csrf

<div class="form-group">
  <label for="clientName">Nome do cliente</label>
  <input type="name" name="name" class="form-control {{ has_error('name', 'has-danger') }}" id="productName" placeholder="Nome do cliente" value="{{old('name') ?? $order->client_name ?? ''}}">
  @errorblock('name')
</div>

<div class="form-group">
  <label for="productDescription">Descrição</label>
  <input type="name" name="description" class="form-control {{ has_error('description', 'has-danger') }}" id="productDescription" placeholder="Descrição do produto" value="{{old('description') ?? $product->description ?? ''}}">
  @errorblock('description')
</div>

<div class="form-group">
  <label for="productPrice">Preço</label>
  <input type="name" name="price" class="form-control {{ has_error('price', 'has-danger') }}" id="productPrice" placeholder="Preço do produto" value="{{old('price') ?? $product->price ?? ''}}">
  @errorblock('price')
</div>

<div class="form-group">
  <label for="image">Imagem do produto</label>
  <input type="file" name="image" accept=".jpg, .png, .jpeg"  class="form-control {{ has_error('image', 'has-danger') }}" id="image" value="{{old('value') ?? $product->image ?? ''}}">
  @errorblock('image')
</div>

