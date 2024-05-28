<style>
    #product-masuk {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #product-masuk td,
    #product-masuk th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #product-masuk tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #product-masuk tr:hover {
        background-color: #ddd;
    }

    #product-masuk th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }
</style>

<table id="product-masuk" width="100%">
    <thead>
        <tr>
            <td>ID</td>
            <td>Date</td>
            <td>Total</td>
            <td>Kasir</td>
            <td>Payment Method</td>
        </tr>
    </thead>
    @foreach ($historyAll as $p)
        <tbody>
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->transaction_date }}</td>
                <td>{{ $p->total_price }}</td>
                <td>{{ $p->kasir->name }}</td>
                <td>{{ $p->payment_method }}</td>
            </tr>
        </tbody>
    @endforeach

</table>
