<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
        ul.productos{
            display: flex;
            flex-wrap: wrap;

            justify-content: space-around
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
                        @if ((auth()->check()))
                            <li class="nav-item">
                                <a class="btn btn-success btn-lg" href="/add" >Añadir producto</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="btn btn-success btn-lg" href="/login">Acceso Empleados</a>
                            </li>
                        @endif
                    @endauth
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
                            <h6 class="card-text" name="precioProducto">{{$product->price}}</h6>
                            @auth
                                @if ((auth()->check()))
                                    <a href="{{ route('modificarproducto', ["productoid" => $product->id]) }}" class="addButton">Modificar producto</a>
                                    <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#borrar{{ $product->id }}">Borrar producto</button>
                                @else
                                    <a href="#" class="addButton"
                                       onclick="addItem({{$product->id}})">Añadir al carrito</a>
                                @endif
                            @endauth
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
                    <input type="number" id="weight" name="weight">
                    <input type="hidden" id="id" name="id" value="">
                </form>


            </div>
            <!--Este es el div con la factura/ticket-->
            <div>
                <h1>FACTURA:</h1>
                <div style="border:2px dashed; min-height: 500px" class="productos">
                    <ul>
                        @foreach($cart as $item)
                            <li><h6>{{$item['name']}} Peso:   {{$item['weight']}} Kg   Precio final: {{$item['totalprice']}} € </h6></li>
                        @endforeach
                    </ul>

                </div>
                <div id="total">
                    <p></p>
                </div>
                <a href="{{route("invoice.index")}}" class="btn btn-success btn-lg">Confirmar compra</a>
            </div>
        </aside>
    </main>
</div>
</body>


<script>


    function addItem(id) {

       document.getElementById("id").value = id;
       /*
       var weight = document.getElementById("weight");
       var totalPrice= weight.value*precio;

               var tiket = JSON.parse(localStorage.getItem("tiket"));
                var weight = document.getElementById("weight");


                if (tiket[nombre] !== undefined) {
                    tiket[nombre][weight] += weight.value
                } else {
                    tiket[nombre] = {weight: weight.value,finalPrice:""}
                }

               var li = document.createElement("LI");
               li.innerHTML = nombre + " -  Peso:  " + weight.value + " Kg "+ " -    Precio final:  "+ totalPrice+" €" ;
               weight.value="";
               document.getElementById("productos").appendChild(li);
               finalprice += totalPrice;
               document.getElementById("total").textContent="Total :   "+ finalprice + "  €";
        */
        document.getElementById("calculateForm").submit()

    }
</script>
</html>
