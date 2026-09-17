<x-mail::message>
# ¡Felicidades por tu compra ecológica, {{ $order->user->name }}!

Hemos recibido tu orden con éxito y los productores ya están preparando tus productos. 

A continuación tienes el resumen de tu pedido **#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}**:

<x-mail::table>
| Producto | Cantidad | Precio Unitario | Subtotal |
|:---------|:--------:|:----------------|---------:|
@foreach($order->items as $item)
| {{ $item->product->name }} | {{ $item->quantity }} | ${{ number_format($item->price, 2) }} | ${{ number_format($item->price * $item->quantity, 2) }} |
@endforeach
| **Total** | | | **${{ number_format($order->total_amount, 2) }}** |
</x-mail::table>

**Dirección de Envío:**  
{{ $order->shipping_address }}

<x-mail::button :url="route('orders.index')">
Ver mis pedidos
</x-mail::button>

Gracias por contribuir a un mundo más verde. 🍃<br>
El equipo de {{ config('app.name') }}
</x-mail::message>

