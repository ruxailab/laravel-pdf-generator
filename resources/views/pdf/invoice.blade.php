<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        /* Define styles for the invoice */
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <h1>Invoice</h1>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>$item['name']</td>
                <td>$item['quantity']</td>
                <td>$item['price']</td>
                <td>$item['quantity'] * $item['price']</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align: right;">Total:</td>
                <td>$total</td>
            </tr>
        </tbody>
    </table>
</body>
</html>