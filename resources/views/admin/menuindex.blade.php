@extends('layouts.newadmin')

@section('content')

    <!--this will be the overlay that comes in small screens--> 
        <body>
            <div class="container-fluid">
            @include('include.adminnav')
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-lg-12 margin-tb">
                            <div class="float-left">
                                <h2>Vendors</h2>
                            </div>
                        </div>
                    </div> 
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
                        <div class="table-responsive">
                            <!--Table-->
                            <table class="table">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Logo</th>
                                    <th>Action</th>
                                </tr>
                                @foreach ($vendors as $vendor)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $vendor->name }}</td>
                                    <td><img src="{{ asset('storage/images/'.$vendor->logo) }}"></td>
                                    <td>
                                            <a class="btn btn-success" href="{{ route('smenu.vendor',$vendor->id) }}">View Menu</a>
                                    </td>
                                </tr>
                            @endforeach
                            </table>
                        </div>

                    <nav>
                        Showing {{ $vendors->firstItem() }} to {{ $vendors->lastItem() }} of total {{$vendors->total()}} entries
                    </nav>
                    
                    <ul class="pagination justify-content-center">
                        {!! $vendors->links() !!}
                    </ul>

                </div>
            </div>
        </body>
        <script>
        $('#checkAll').click(function(event) 
        {   
            if(this.checked)
            {
                // Iterate each checkbox
                $(':checkbox').each(function()
                {
                    this.checked = true;                        
                });
            } else 
            {
                $(':checkbox').each(function() 
                {
                    this.checked = false;                       
                });
            }
        }); 
        </script>
@endsection
