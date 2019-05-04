@csrf

<div class="form-group">
  <label for="productName">Nome</label>
  <input type="name" name="name" class="form-control {{ has_error('name', 'has-danger') }}" id="productName" placeholder="Nome do produto" value="{{old('name') ?? $product->name ?? ''}}">
  @errorblock('name')
</div>

<div class="form-group">
  <label for="productDescription">Descrição</label>
  <input type="name" name="description" class="form-control {{ has_error('description', 'has-danger') }}" id="productDescription" placeholder="Descrição do produto" value="{{old('description') ?? $product->description ?? ''}}">
  @errorblock('description')
</div>

<div class="form-group">
  <label for="productPrice">Preço</label>
  <input type="name" name="price" class="form-control money {{ has_error('price', 'has-danger') }}" id="productPrice" placeholder="Preço do produto" value="{{old('price') ?? $product->price ?? ''}}">
  @errorblock('price')
</div>

