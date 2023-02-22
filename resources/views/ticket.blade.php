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

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket</title>
    <style>
        .ticket {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            margin: 10px auto;
            min-height: 450px;
        }
        h1 {
            text-align: center;
            margin-top: 0;
        }
        table {
            width: 100%;
            margin-top: 15px;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="ticket">
    <h1>Ticket</h1>
    <table>
        <thead>
        <tr>
            <th>Producto</th>
            <th>Peso</th>
            <th>Precio</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($cart as $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                <td> {{ $item['weight'] }} kg</td>
                <td> {{ $item['totalprice'] }} €/kg</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <p>COD:06BDZ-{{ $id_cliente }}</p><p>Fecha de compra: {{  date("d-m-Y", strtotime(date_default_timezone_get())) }}</p>
        </tfoot>

    </table>
    <hr>
    <div class="total">
        Precio Total: {{ $total }} €
    </div>
</div>
<a href="{{route("home")}}" class="btn btn-success btn-xxl">Volver a comprar</a>
</body>
</html>
