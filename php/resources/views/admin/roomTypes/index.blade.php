@extends('parts.app')

@section('content')
    <div class="pagetitle">
        <h1>Room Types</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Room Types</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Room Types List</h5>
                        <a href="{{ route('admin.roomTypes.create') }}" class="btn btn-primary mb-3 addNew">Add <i class="bi bi-plus"></i></a>

                        <!-- Table -->
                        <table class="table table-bordered datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Type Name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($roomTypes as $index => $roomType)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $roomType->type_name }}</td>
                                    <td>
                                        <a href="{{ route('admin.roomTypes.edit', $roomType->room_type_id) }}" class="btn btn-warning btn-sm">  <i class="bi bi-pencil"></i></a>
                                        <form id="deleteForm{{$roomType->room_type_id}}" action="{{ route('admin.roomTypes.destroy', $roomType->room_type_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button onclick="confirmDelete(event,'deleteForm{{$roomType->room_type_id}}')" class="btn btn-danger btn-sm">  <i class="bi bi-trash"></i></button>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!-- End Table -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
