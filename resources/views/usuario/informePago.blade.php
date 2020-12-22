@extends("layouts.usuario.base")

@section("content")
    <main class="py-4">
        <div class="container">
            <div class="box">
                @if ($status == 0 )
                    <p>La compra del juego {{ $juego->name }} no ha podido llevarse a cabo.</p>
                    <p>Por favor contacte con algún miembro del staff o con la <a href="{{ route('usuario.desarrolladora.show', $juego->desarrolladora->id) }}" target="blank">desarrolladora</a> a cargo del juego.</p>

                    <p>Gracias.</p>
                @endif
                @if($status == 1)
                @foreach ($mensaje as $item)
                <h3>El pago ha sido procesado correctamente, estos son los datos.</h3>
                <div class="container">
                    <ul style="list-style:none;">
                        <li> Descripción del producto: {{ $item->description }} .</li>
                        <li> Precio: {{ $item->amount->total }} € </li>
                        <li> A nombre de: {{ $item->item_list->shipping_address->recipient_name }}</li>
                        <li> Dirección: {{ $item->item_list->shipping_address->line1 . ' '.$item->item_list->shipping_address->city .' '. $item->item_list->shipping_address->postal_code  }}</li>
                    </ul>            
                </div>    
                @endforeach
                <p>Lleva un total de: {{$precio}} en esta campaña.</p>
                <p>Recibirá un correo electrónico con más información a {{ Auth::user()->email }} </p>
                <p> Gracias. </p>
                @endif               
            </div>
        </div>
    </main>
@endsection
