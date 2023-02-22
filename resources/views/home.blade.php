<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BASCULA</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        article {
            width: 1000px;
            float: left;
            margin-right: 0px;
            margin-left: 50px;
        }

        div.card {
            margin-top: 10px;
        }

        aside {
            float: right;
            margin-left: -40px;
            margin-right: 50px;
        }

        ul.productos {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around
        }

        input.weight {
            height: 100px;
            width: 50%;
            font-size: 30px;
            text-align: center;
        }

        ul.factura {
            list-style-type: none;
        }
    </style>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    <img
                        src="https://upload.wikimedia.org/wikipedia/commons/9/90/Logo_Mercadona_%28color-300-alpha%29.png"
                        width="400px">
                    <h1>BÁSCULA</h1>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto" style="padding-left: 500px">
                    <!-- Authentication Links -->
                    @auth
                        <li class="nav-item">
                            <a class="btn btn-success btn-lg" href="/add">Añadir producto</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-info btn-lg" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>

                    @endauth
                    @guest
                        <li class="nav-item">
                            <a class="btn btn-success btn-lg" href="/login">Acceso Empleados</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">

        <article>
            <h1>PRODUCTOS A PESAR: SELECCIONA EL PRODUCTO QUE DESEES PESAR</h1>
            <div style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-around">
                @foreach($products as $product)

                    <div class="card" style="width: 13rem;">
                        <div class="card-body">
                            <img class="card-img-top" src="{{$product->image}}" alt="Card image cap">
                            <h5 class="card-title" name="idProducto">{{$product->id}}</h5>
                            <h5 class="card-title" name="nombreProducto">{{$product->name}}</h5>
                            <h6 class="card-text" name="precioProducto">{{$product->price}} €/kg</h6>
                            @auth
                                <a href="{{ route('product.edit',['product'=>$product]) }}" class="btn btn-warning" >
                                    Editar producto
                                </a>
                                <form action="{{ route("product.destroy", ["product" => $product->id]) }}" method="post">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-danger">Borrar producto</button>
                                </form>
                            @endauth
                            @guest
                            <a href="#" class="btn btn-primary"
                               onclick="addItem({{$product->id}})" >Añadir al carrito</a>
                            @endguest
                        </div>
                    </div>
                @endforeach
            </div>
        </article>
        <aside>
            <!--Este es el div superior para introducir el peso, y el boton para añadir a la factura-->
            <div>
                <h1>INTRODUCE EL PESO</h1>
                <form id="calculateForm" action="{{route("cart.add")}}" method="post">
                    @csrf
                    <input type="number" id="weight" name="weight" class="weight">
                    <input type="hidden" id="id" name="id">
                </form>


            </div>
            <!--Este es el div con la factura/ticket-->
            <div>
                <h1>FACTURA:</h1>
                <div style="border:2px dashed; min-height: 500px" class="productos">
                    <ul class="factura">
                        @foreach($cart as $item)

                            <li>

                                <h6 style="float: left">{{$item['name']}} | Peso: {{$item['weight']}} Kg | Precio
                                    final: {{$item['totalprice']}} € </h6>
                                <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="float: right; height: 15px; background-color: white; border-color: white; border-style: solid; color: red">
                                        X
                                    </button>
                                </form>


                            </li>
                        @endforeach
                    </ul>

                </div>
                <div id="total">
                    @if(isset($totalPrice))
                        <h2>Total : {{ $totalPrice }} €</h2>
                    @endif
                </div>
                <a id="confirmarCompra" href="{{route("ticket.index")}}" class="btn btn-success btn-lg">Confirmar compra</a>
            </div>
        </aside>
    </main>
</div>
</body>

<script>


    function addItem(id) {
        document.getElementById("id").value = id;
        document.getElementById("confirmarCompra").addEventListener("click", function(event) {
            if (!window.confirm("¿Estás seguro de que quieres confirmar la compra?")) {
                event.preventDefault();
            }
        });
        document.getElementById("calculateForm").submit();

    }
</script>
</html>
