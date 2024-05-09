@extends('layouts.admin')

@section('title', 'Dish Page')

@section('content')

    <form>
        <input hidden value="{{ $dish->id }}" id="id_dish">
        <div class="form-group">
            <label for="dish">Dish name</label>
            <input type="email" value="{{ $dish->name }}" class="form-control" id="dish"  placeholder="dish name">
        </div>
        <button type="button" class="btn btn-primary float-right" onclick="Save()">Submit</button>
    </form>

    <script>
        function Save(){
            let id = $("#id_dish").val()
            let name = $("#dish").val()

            fetch("/admin/dish/save",{
                method:"POST",
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: id,
                    name: name,
                    "_token": "{{ csrf_token() }}"
                })
            })
                .then(res=>{
                    Swal.fire({
                        title: "Success!",
                        icon: "success"
                    }).then(res=>{
                        window.location.href="/admin/dish"
                    });
                })

        }
    </script>

@endsection
