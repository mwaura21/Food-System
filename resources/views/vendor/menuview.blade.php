@extends('layouts.newadmin')

@section('content')

    <!--this will be the overlay that comes in small screens--> 
        <body>
            <div class="container-fluid">
            @include('include.vendornav')
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-lg-12 margin-tb">
                            <div class="float-left">
                                <h2>{{ $category->name }}</h2>
                            </div>
                            <div class="float-right">
                                <a class="btn btn-success" href="{{ route('menu.index') }}"> Back</a>
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
                        <form action="{{ route('menu.deleteAll') }}" method="POST">    
                        
                        @csrf
                        @method('DELETE')
                            
                            <div class="row">
                                <div class="col-lg-12 margin-tb">
                                    <div class="float-left">
                                        <input type="hidden" value="{{ $category->id }}" name="category">
                                        <input class="btn btn-danger" type="submit" name="submit" value="Delete All Selected"/>
                                    </div>
                                    <div class="float-right">
                                        <a class="btn btn-success" href="{{ route('menu.create',$category->id) }}"> Create New Item</a>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                            <!--Table-->
                            <table class="table">
                                <tr>
                                    <th class="text-center" colspan="8"><input type="checkbox" id="checkAll"> Select All</th>
                                </tr>
                                <tr>
                                    <th> </th>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Picture</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                                @foreach ($menus as $menu)
                                <tr>
                                    <th> 
                                        <input name='id[]' type="checkbox" id="checkItem" value="{{ $menu->picture }}">
                                    </th>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $menu->name }}</td>
                                    <td>{{ $menu->description }}</td>
                                    <td>{{ $menu->categories->name }}</td>
                                    <td>
                                        @if($menu->picture == NULL)

                                        @else
                                        <img src="{{ asset('storage/images/'.$menu->picture) }}">
                                        @endif
                                    </td>
                                    <td>Ksh.{{ $menu->price }}</td>
                                    <td>
                                            <a class="btn btn-success" href="{{ route('menu.edit',$menu->id) }}">Edit</a>
                                    </td>
                                </tr>
                                </form>
                            @endforeach
                            </table>
                        </div>

                    <nav>
                        Showing {{ $menus->firstItem() }} to {{ $menus->lastItem() }} of total {{$menus->total()}} entries
                    </nav>
                    
                    <ul class="pagination justify-content-center">
                        {!! $menus->links() !!}
                    </ul>

                </div>

            
            </div>
        </body>
        <script>
        $('#checkAll').click(function(event) {   
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;                        
            });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;                       
                });
            }
    }); 
            </script>
@endsection
