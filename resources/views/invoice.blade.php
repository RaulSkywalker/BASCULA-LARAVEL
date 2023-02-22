<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket</title>
    <style>
        /* Estilos para el ticket */
        .ticket {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            margin: 10px auto;
        }
        h1 {
            text-align: center;
            margin-top: 0;
        }
        table {
            width: 100%;
            margin-top: 20px;
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
                <td>{{$item['name']}}</td>
                <td>{{$item['weight']}}</td>
                <td>{{$item['totalprice']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="total">
        Total: {{ $total }}
    </div>
</div>
</body>
</html>
