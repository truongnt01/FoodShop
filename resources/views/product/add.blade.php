@extends('layout.app')
@section('content')

<div class="form-container">
    <h1>Add New Product</h1>
    <a href="{{ route('products.index') }}">Back</a>

    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        Name : <input type="text" name="name">
        <br><br>
        Address : <input type="text" name="address">
        <br><br>
        Email : <input type="text" name="email">
        <br><br>
        Image :
        <img src="" alt="" id="show-file" style="width: 100px">
        <input type="file" accept="image/*" name="image" onchange="showFile(event)">
        <br><br>
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
