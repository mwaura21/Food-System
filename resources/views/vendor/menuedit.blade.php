@extends('layouts.newadmin')

@section('content')

<body>
    
    <!--this will be the overlay that comes in small screens--> 
    <div class="container-fluid">
    @include('include.vendornav')
        @if (Route::current()->getName() == 'menu.edit')
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-12 margin-tb"> 
                    <div class="float-left">
                        <h2>Edit Item</h2>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-success" href="{{ route('category.viewAll',$menu->category) }}"> Back</a>
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
        
            <form action="{{ route('menu.update',$menu->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" value="{{ $menu->picture }}" name="old_picture">
                <input type="hidden" value="{{ $menu->category }}" name="category">
                <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12">
                        <img src="{{ asset('storage/images/'.$menu->picture) }}" class="rounded float-left display-image">
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name</strong>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name', $menu->name) }}" autofocus>
                        </div>

                        @error('name')
                            <div class="text-danger mb-3">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Description</strong>
                            <textarea style="resize: none;" rows="5" cols="5" name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Description" >{{ old('description', $menu->description) }}</textarea>
                        </div>
                        @error('description')
                            <span class="text-danger mb-3">{{ $message }}</span>
                        @enderror
                    </div>

                    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Picture</strong>
                            <input type="file" name="picture" class="form-control @error('picture') is-invalid @enderror" autofocus>
                        </div>  
                        
                        @error('picture')
                            <div class="text-danger mb-3">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Price</strong>
                            <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="Price" value="{{ old('price', $menu->price) }}" autofocus>
                        </div>

                        @error('price')
                            <div class="text-danger mb-3">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
        
            </form>
        </div>
        @elseif (Route::current()->getName() == 'category.edit')
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="float-left">
                        <h2>Edit Category</h2>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-success" href="{{ route('menu.index') }}"> Back</a>
                    </div>
                </div>
            </div>
        
            <form action="{{ route('category.update',$category->id) }}" method="POST">
                @csrf
                @method('PUT')
        
                <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name</strong>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('nme', $category->name) }}" autofocus>
                        </div>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
        
            </form>
        </div>
        @endif
    </div>
</body>
@endsection
