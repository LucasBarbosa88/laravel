<td>@{{ item.name }}</td>
<td>@{{ item.description }}</td>
<td>@{{ item.price }} R$</td>
<td><img v-bind:src="item.image" widht="50px" height="50px" alt="imagem"></td>
<td>@{{ item.created_at }}</td>
