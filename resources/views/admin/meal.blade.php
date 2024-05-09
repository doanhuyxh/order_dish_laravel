@extends('layouts.admin')

@section('title', 'Meal Page')

@section('content')

    <div class="container">
        <button class="btn btn-success" onclick="AddEdit(0)">Add</button>
    </div>

    <div class="container">

        <table class="table" id="table_res">
            <thead>
            <tr>
                <td>Id</td>
                <td>Name</td>
                <td></td>
                <td></td>
            </tr>
            </thead>
        </table>

    </div>

    <script>
        $(document).ready(function () {
            $('#table_res').DataTable({
                paging: true,
                select: true,
                "order": [[0, "desc"]],
                dom: 'Bfrtip',

                buttons: [
                    'pageLength',
                ],

                serverSide: true,

                "processing": true,
                "filter": true,
                "orderMulti": false,
                "stateSave": true,

                ajax: {
                    url: '/admin/meal/getData',
                    "type": "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    "datatype": "json"
                },
                columns: [
                    {"data": "id", "name": "id"},
                    {"data": "name", "name": "name"},
                    {
                        data: null, render: function (data, type, row) {
                            return "<a href='javascript:void(0)' class='btn btn-primary' onclick=AddEdit('" + row.id + "');>Edit</a>";
                        }

                    },
                    {
                        data: null, render: function (data, type, row) {
                            return "<a href='javascript:void(0)' class='btn btn-danger' onclick=Delete('" + row.id + "');>Delete</a>";
                        }

                    },

                ],
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }]

            });
        })

        function AddEdit(id) {
            window.location.href = "/admin/meal/add_edit/"+id;
        }

        function Delete(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("/admin/meal/delete/"+id)
                        .then(res=>{
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                            }).then(res=>{
                                window.location.reload()
                            });
                        })
                }
            });
        }

    </script>
@endsection
