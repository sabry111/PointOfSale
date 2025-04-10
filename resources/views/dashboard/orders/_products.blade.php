<div class="box-body ">
    <div id="print-area">
        <table class="table table-bordered ">
            <thead>
                <tr>
                    <th>{{  ucwords(__('site.product name')) }}</th>
                    <th>{{  ucwords(__('site.quantity')) }}</th>
                    <th>{{  ucwords(__('site.price')) }}</th>

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
        <h3>{{  ucwords(__('site.total price')) }} : <span>{{ number_format($order->total_price, 2) }}</span></h3>
    </div>
    <br>
    <button class="btn btn-primary btn-block print-btn">{{  ucwords(__('site.print order')) }} <i class='fa fa-print'></i></button>
</div>
<!-- /.card-body -->
