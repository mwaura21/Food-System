@extends('layouts.newadmin')

@section('content')

    <!--this will be the overlay that comes in small screens--> 
        <body>
            <div class="container-fluid">
                @include('include.adminnav')
                <div class="container mt-5">
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
                        <form action="{{ route('scategory.deleteAll', $vendor) }}" method="POST">    
                            <input type="hidden" name="vendor" value="{{ $vendor }}">
                            @csrf
                            @method('DELETE')
                            <div class="row">
                                <div class="col-lg-12 margin-tb">
                                    <div class="float-left">
                                        <h2>Category</h2>
                                    </div>
                                    <div class="float-right">
                                        <a class="btn btn-success" href="{{ route('smenu.index') }}">Back</a>
                                    </div>
                                </div>
                            </div>    

                            <div class="row">
                                <div class="col-lg-12 margin-tb">
                                    <div class="float-left">
                                        <input class="btn btn-danger" type="submit" name="submit" value="Delete All Selected"/>
                                    </div>
                                    <div class="float-right">
                                        <a class="btn btn-success" href="{{ route('scategories.create', $vendor) }}"> Create New Category</a>
                                    </div>
                                </div>
                            </div>
                                <br>
                            <div class="table-responsive">
                                <!--Table-->
                                <table class="table">
                                    <tr>
                                        <th class="text-center"> <input type="checkbox" id="checkAll"> </th>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($categories as $category)
                                    <tr>
                                        <td class="text-center"><input name='id[]' type="checkbox" id="checkItem" value="{{ $category->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                                <a class="btn btn-success" href="{{ route('scategory.edit',$category->id) }}">Edit</a>
                                                <a class="btn btn-primary" href="{{ route('scategory.viewAll',$category->id) }}">See All</a>
                                        </td>
                                    </tr>
                        </form>
                                    @endforeach 
                                </table>
                            </div>    
                            <nav>
                                Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of total {{$categories->total()}} entries
                            </nav>

                            <ul class="pagination justify-content-center">
                                {!! $categories->appends(['menus' => $menus->currentPage()])->links() !!}
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