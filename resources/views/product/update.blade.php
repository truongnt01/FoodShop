@extends('layout.app')
@section('content')
<div class="form-container">
    <h1>Update Product</h1>
    <a href="{{ route('products.index') }}">Back</a>

    <form action="{{ route('products.update',$product->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        Name : <input type="text" name="name" value="{{ $product->name }}">
        <br><br>
        Address : <input type="text" name="address" value="{{ $product->address }}">
        <br><br>
        Email : <input type="text" name="email" value="{{ $product->email }}">
        <br><br>
        Image :
        <img src="{{ asset('/image/'.$product->image) }}" alt="" id="show-file" style="width: 100px">
        <input type="hidden" name="hidden_product_image" value="{{ $product->image }}">
        <input type="file" accept="image/*" name="image" onchange="showFile(event)">
        <br><br>
        
        <input type="hidden" name="hidden_id" value="{{ $product->id }}">
        <button>Save</button>
    </form>

    <script>
        function showFile(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function () {
                var dataURL = reader.result;
                var output = document.getElementById('show-file');
                output.src = dataURL;
            }
            reader.readAsDataURL(input.files[0]);
        }
    </script>
</div>
@endsection
