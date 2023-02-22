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

        aside {
            float: right;
            margin-left: -40px;
            margin-right: 50px;
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
                    <h1>BÁSCULA (VERSIÓN EMPLEADOS)</h1>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                            <li class="nav-item">
                                <a class="nav-link" href="/add">Añadir un producto nuevo</a>
                            </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">

        <article>
            <h1>PRODUCTOS A PESAR: SELECCIONA EL PRODUCTO QUE DESEES PESAR</h1>
            <div style="display: flex; flex-direction: row;">
                @foreach($productos as $producto)
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <img class="card-img-top" src="{{$producto->image}}" alt="Card image cap">
                            <h5 class="card-title" name="idProducto">{{$producto->id}}</h5>
                            <h5 class="card-title" name="nombreProducto">{{$producto->name}}</h5>
                            <h6 class="card-text" name="precioProducto">{{$producto->price}}</h6>
                            <a href="{{ route('modificarproducto', ["productoid" => $producto->id]) }}" class="addButton">Modificar producto</a>
                            <button type="submit" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#borrar{{ $producto->id }}">Borrar producto</button>
                            <a href="#" class="addButton" onclick="addItem('{{$producto->id}}','{{$producto->name}}','{{$producto->price}}')">Añadir al carrito</a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Ventana modal para borrar el producto-->
        <div class="modal fade" id="borrar{{ $producto->id }}" tabindex="-1">
        <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmación de borrado</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        ¿Desea borrar el producto <strong>{{ $producto->name }}</strong>?
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <!--AQUI HAY QUE VER ESTO DEL ROUTE GRUPOS.DESTROY PORQUE NO LO ENCUENTRO Y NO SE DE QUE VA EL TEMA-->
                        <form action="{{ route("grupos.destroy", ["producto" => $producto->id]) }}" method="post">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-primary">Borrar</button>
                        </form>
                </div>
                </div>
        </div>
        </div>
        </article>
        <aside>
            <!--Este es el div superior para introducir el peso, y el boton para añadir a la factura-->
            <div>
                <h1>INTRODUCE EL PESO</h1>
                <form id="calculateForm" action="{{route("calculate")}}" method="post">
                    @csrf
                    <input type="number" id="weight" name="weight">
                    <input type="hidden" id="id" name="id">
                </form>
            </div>
            <!--Este es el div con la factura/ticket-->
            <div>
                <h1>FACTURA:</h1>
                <div style="border:2px dashed;">
                    <ul id="productos">
                    </ul>
                </div>
            </div>
        </aside>
    </main>
</div>
</body>
@if (isset($productoSelect))
    <script>
        var tiket = JSON.parse(localStorage.getItem("tiket"));
        tiket["{{$productoSelect}}"]["finalPrice"] = "{{$finalPrice}}";
        localStorage.setItem(tiket);
    </script>
@endif

<script>

    window.addEventListener("load", function (event) {

        if (localStorage.getItem("tiket") !== undefined) {
            var tiket = [];
            localStorage.setItem('tiket', JSON.stringify(tiket));
        }

        var tiket = JSON.parse(localStorage.getItem("tiket"));
        if(tiket.length > 0){
        tiket.forEach(function (element, key) {
            var li = document.createElement("LI");
            li.innerHTML = key + " -  Peso:  " + element.weight + " Kg " + " -    Precio final:  " + element.finalPrice + " €";
            weight.value = "";
            document.getElementById("productos").appendChild(li);

        })
        }

    });

    function addItem(id, nombre, precio) {
        var tiket = JSON.parse(localStorage.getItem("tiket"));
        var weight = document.getElementById("weight");
        document.getElementById("id").value = id;
        //var totalPrice= weight.value*precio;

        if (tiket[nombre] !== undefined) {
            tiket[nombre][weight] += weight.value
        } else {
            tiket[nombre] = {weight: weight.value,finalPrice:""}
        }

        document.getElementById("calculateForm")/*.submit()*/

        li.innerHTML = nombre + " -  Peso:  " + weight.value + " Kg "+ " -    Precio final:  "+ totalPrice+" €" ;
        weight.value="";
        document.getElementById("productos").appendChild(li);
    }
</script>
</html>