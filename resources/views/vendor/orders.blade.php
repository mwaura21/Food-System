@extends('layouts.newadmin')
  
@section('content')
    <div class="container-fluid">
    @include('include.vendornav')
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
                        <h2>Orders</h2>
                    </div>
                </div>
            </div>  
            <div class="table-responsive">
                <!--Table-->
                <table class="table">
                @foreach($orders as $id => $order1)
                    
                    <tr>
                        <th colspan="7">Order ID: {{ $id }}</th>
                    <tr>
                    <tr>
                        <th>Photo</th>
                        <th>Item</th>
                        <th>Customer</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Payment</th>
                        <th>Address</th>
                        <th>Status</th>
                    </tr>
                    @php 
                        $total = 0 
                    @endphp
                    @foreach($order1 as $order)
                    @php 
                        $total += $order->one_total/$order->quantity * $order->quantity
                     @endphp
                     @php
                        $time= $order->created_at->format("l jS F Y G:i");
                    @endphp
                    <tr>
                        <td><img src="{{ asset('storage/images/'.$order['picture']) }}"></td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                        <td>Ksh.{{ $order->one_total/$order->quantity }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ $order->payment }}</td>
                        <td>{{ $order->address }}</td>
                        <td>
                        @if($order->status == "Not Ready")

                        <form action="{{ route('order.ready',$order) }}" method="POST">
                            @csrf
                                <input type="hidden" value="Ready" name="status" id="status">
                                <input type="hidden" value="{{ $order->email }}" name="email" id="email">

                                <button type="submit" class="btn btn-success" value="Ready">Ready</a>
                        </form>      

                        @else

                        {{ $order->status }}

                        @endif
                        </td>
                    </tr>


                    @endforeach
                    <tr>
                        <td><strong>{{ $time }}</strong></td>
                        <td colspan="7" class="text-right"><h3><strong>Total Ksh.{{ $total }}</strong></h3></td>
                    </tr>
                    @endforeach
                </table>
            </div>
                    <nav>
                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of total {{$orders->total()}} entries
                    </nav>

                    <ul class="pagination justify-content-center">
                        {{ $orders->links('pagination::bootstrap-4') }}
                    </ul>
        </div>
    </div>
@endsection

