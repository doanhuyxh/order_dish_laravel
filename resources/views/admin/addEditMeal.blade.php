@extends('layouts.admin')

@section('title', 'Meal Page')

@section('content')

    <form>
        <input hidden value="{{ $meal->id }}" id="id_meal">
        <div class="form-group">
            <label for="meal">Meal name</label>
            <input type="email" value="{{ $meal->name }}" class="form-control" id="meal"  placeholder="meal name">
        </div>
        <button type="button" class="btn btn-primary float-right" onclick="Save()">Submit</button>
    </form>

    <script>
        function Save(){
            let id = $("#id_meal").val()
            let name = $("#meal").val()

            fetch("/admin/meal/save",{
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
                        window.location.href="/admin/meal"
                    });
                })

        }
    </script>

@endsection
