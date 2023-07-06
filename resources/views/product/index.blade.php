@extends('Layouts.app')
@section('layout')
    <link rel="stylesheet" href="{{ asset('index.css') }}">
@endsection
@section('content')
<main>
    
    <h1>Products list</h1>
    @if ($message = Session::get('success'))
        <div>
            <ul>
                <li>{{ $message }}</li>
            </ul>
        </div>
    @endif
    <a href="{{ route('products.create') }}">Add More Product</a>
    <form action="{{ route('products.index') }}" method="get" accept-charset="UTF-8" role="search">
        <input type="text" placeholder="Search here..." name="search" value="{{ request('search') }}">
        <button>Search</button>
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Email</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if (count($product) > 0)
                @foreach ($product as $key => $value)
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->name }}</td>
                        <td><img style="width: 60px" src="{{ asset('/image/' .$value->image) }}" alt="This is a picture"></td>
                        <td>{{ $value->email }}</td>
                        
                        <td>{{ $value->address }}</td>
                        <td>
                            <button><a href="{{ route('products.edit',$value->id) }}" class="custom-link">Change</a> </button>                           
                            <form action="{{ route('products.destroy', $value->id) }}" method="post" onclick="deleteConfirm(event)">
                            @method('delete')
                            @csrf
                            <button class="custom-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <p>Product does not exist</p>
            @endif
            
        </tbody>
    </table>
    <div>
       {{ $product->links('layout.pagination')}}
    </div>
</main>
    <script>
        window.deleteConfirm = function (event){
            event.preventDefault();
            var form = event.target.form;
            var result = confirm('Are you sure ?')
            if(result) {
                form.submit();
            }
        }
    </script>
@endsection