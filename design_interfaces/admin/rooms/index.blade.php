@extends('parts.app')

@section('content')
    <div class="pagetitle">
        <h1>Rooms List</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Rooms List</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Rooms List</h5>
                        <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary mb-3 addNew">Add <i class="bi bi-plus"></i></a>

                        <!-- Table -->
                        <table class="table table-bordered datatable text-center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Room Image</th>
                                <th>Room Number</th>
                                <th>Type</th>
                                <th>Capacity</th>
                                <th>Status</th>
                                <th>Admin Approval?</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($rooms as $index => $room)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($room->images->isNotEmpty())
                                            <img src="{{ asset($room->images->first()->image_url) }}" class="img-thumbnail" height="100px" width="100px">
                                        @else
                                            <img src="{{ $room->def_image }}" class="img-thumbnail" height="100px" width="100px">
                                        @endif
                                    </td>
                                    <td>{{ $room->room_number }}</td>
                                    <td>{{ optional($room->type)->type_name ?? 'N/A' }}</td>
                                    <td>{{ $room->capacity }}</td>
                                    <td>
                                        @if($room->availability_status == 'Available')
                                            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Available</span>
{{--                                        @elseif($room->availability_status == 'Reserved')--}}
{{--                                            <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Reserved</span>--}}
                                        @else
                                            <span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Not Available</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($room->need_admin_approve)
                                            <i class="bi bi-check-circle text-success"></i>
                                        @else
                                            <i class="bi bi-x-circle text-danger"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.rooms.show', $room->room_id) }}" class="btn btn-primary btn-sm">  <i class="bi bi-eye"></i></a>
                                        <a href="{{ route('admin.rooms.edit', $room->room_id) }}" class="btn btn-secondary btn-sm">  <i class="bi bi-pencil"></i></a>
                                        <form id="deleteForm{{$room->room_id}}" action="{{ route('admin.rooms.destroy', $room->room_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button onclick="confirmDelete(event,'deleteForm{{$room->room_id}}')" class="btn btn-danger btn-sm">  <i class="bi bi-trash"></i></button>
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
