<body>
    <h4>Hola {{ $name }}</h4>
    <!-- Logo corporativo -->
    <img src="{{ asset('/images/logo.png') }}" height="100" />
    <p>Su compra ha sido aceptada. A continuación tiene los datos de la compra.</p>
    @foreach ($mensaje as $item)
        <ul style="list-style:none;">
            <li> Descripción del producto: {{ $item->description }} .</li>
            <li> Precio: {{ $item->amount->total }} € </li>
            <li> A nombre de: {{ $item->item_list->shipping_address->recipient_name }}</li>
            <li> Dirección: {{ $item->item_list->shipping_address->line1 . ' '.$item->item_list->shipping_address->city .' '. $item->item_list->shipping_address->postal_code  }}</li>
        </ul>
    @endforeach
    <br>
    <p>Lleva un total de: {{$precio}} en esta campaña.</p>
    <small>Le saluda cordialmente, Indie4all</small>
</body>
