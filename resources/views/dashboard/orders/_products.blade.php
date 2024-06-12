<div class="box-body ">
    <div id="print-area">
        <table class="table table-bordered ">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Desc</th>
                    <th>Photo</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>{{ number_format($product->pivot->quantity * $product->sale_price, 2) }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table><br>
        <h3>Total Price : <span>{{ number_format($order->total_price, 2) }}</span></h3>
    </div>
    <br>
    <button class="btn btn-primary btn-block print-btn"> Print Order <i class='fa fa-print'></i></button>
</div>
<!-- /.card-body -->
