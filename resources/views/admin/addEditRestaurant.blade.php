@extends('layouts.admin')

@section('title', 'Restaurant Page')

@section('content')

    <form>
        <input hidden value="{{ $restaurant->id }}" id="id_ress">
        <div class="form-group">
            <label for="restaurant">Restaurant name</label>
            <input type="email" value="{{ $restaurant->name }}" class="form-control" id="restaurant"  placeholder="restaurant name">
        </div>
        <button type="button" class="btn btn-primary float-right" onclick="Save()">Submit</button>
    </form>

    <script>
        function Save(){
            let id = $("#id_ress").val()
            let name = $("#restaurant").val()

            fetch("/admin/restaurant/save",{
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
                        window.location.href="/admin/restaurant"
                    });
                })

        }
    </script>

@endsection
