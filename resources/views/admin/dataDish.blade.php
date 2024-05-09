@extends('layouts.admin')

@section('title', 'Data Page')

@section('content')

    <a href="/admin/downloadData" class="btn btn-success float-right my-3">Download</a>

    <div class="container">
        <table class="table">
            <thead class="table-dark">
            <tr>
                <td>Id</td>
                <td>Restaurant</td>
                <td>Meal</td>
                <td>Dish</td>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item['id'] }}</td>
                    <td>{{ $item['restaurant'] }}</td>
                    <td>{{ $item['meal'] }}</td>
                    <td>
                        <ul>
                            @foreach($item['dish'] as $dish)
                                <li>{{ $dish['name'] }} - {{ $dish['number'] }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
