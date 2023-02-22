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
<a href="{{route("home")}}" class="btn btn-success btn-lg">Volver a comprar</a>
</body>
</html>
