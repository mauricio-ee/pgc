<x-mail::message>
# ¡Felicidades por tu compra ecológica, {{ $order->user->name }}!

Hemos recibido tu orden con éxito y los productores ya están preparando tus productos. 

A continuación tienes el resumen de tu pedido **#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}**:

<x-mail::table>
| Producto | Cantidad | Precio Unitario | Subtotal |
|:---------|:--------:|:----------------|---------:|
@foreach($order->items as $item)
| {{ $item->product->name }} | {{ $item->quantity }} | {{ cop($item->price) }} | {{ cop($item->price * $item->quantity) }} |
@endforeach
| **Total** | | | **{{ cop($order->total_amount) }}** |
</x-mail::table>

**Dirección de Envío:**  
{{ $order->shipping_address }}

<x-mail::button :url="route('orders.index')">
Ver mis pedidos
</x-mail::button>

Gracias por contribuir a un mundo más verde. 🍃<br>
El equipo de {{ config('app.name') }}
</x-mail::message>

