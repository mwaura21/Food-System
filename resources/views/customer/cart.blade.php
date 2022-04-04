@extends('layouts.newadmin')
  
@section('content')
<script type="text/javascript">

  function update(clicked_id) 
  {

    var x = clicked_id.toString();  
    var element = document.getElementById(`${x}`);
    var id = element.getAttribute('data-id');

    var quantity = document.getElementById(`${x}`).value;

        $.ajax({
            url: '{{ route('update.cart') }}',
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}', 
                id: id, 
                quantity: quantity
            },


            success: function (response) {
               window.location.reload();
            }
        });
    };

    function remove(clicked_id) 
  {

    var x = clicked_id.toString();    

    var element = document.getElementById(`${x}`);
    var id = element.getAttribute('data-id');
  
        if(confirm("Are you sure want to remove?")) {
            $.ajax({
                url: '{{ route('remove.from.cart') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: id
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    };
  
</script>
    <div class="container-fluid">
    @include('include.customernav')
                    @if (Session::has('message'))
                        <div class="alert alert-success" role="alert">
                            <a type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                            {{ Session::get('message') }}
                        </div>
                    @endif

                    @if (Session::has('error-message'))
                        <div class="alert alert-danger" role="alert">
                            <a type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                            {{ Session::get('error-message') }}
                        </div>
                    @endif
        <div class="container mt-5">  
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div>
                        <h2>Cart</h2>
                    </div>
                </div>
            </div>  
            <div class="table-responsive">
                <!--Table-->
                <table class="table">
                    <tr>
                        <th>Photo</th>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                @php $total = 0 @endphp
                @if(session('cart'))
                    @foreach(session('cart') as $id => $details)
                        @php $total += $details['price'] * $details['quantity'] @endphp
                    <tr>
                        <td><img src="{{ asset('storage/images/'.$details['picture']) }}"></td>
                        <td>{{ $details['name'] }}</td>
                        <td>Ksh.{{ $details['price'] }}</td>
                        <td data-th="Quantity">
                            <input type="number" value="{{ $details['quantity'] }}" onclick="update(this.id)" id="{{ $loop->iteration }}" data-id="{{ $id }}">
                        </td>

                        <td>Ksh.{{ $details['price'] * $details['quantity'] }}</td>
                        <td>
                            <button class="btn btn-danger" onclick="remove(this.id)" id="{{ $loop->iteration }}" data-id="{{ $id }}">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                @endif
                    <tr>
                        <td colspan="6" class="text-right"><h3><strong>Total Ksh.{{ $total }}</strong></h3></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-right">
                            <a href="{{ route('vendor') }}" class="btn btn-warning">Continue Shopping</a>
                            <a href="{{ route('checkout') }}" class="btn btn-success">Checkout<a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection

