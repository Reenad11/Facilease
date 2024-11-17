@extends('parts.app')

@section('content')
    <div class="pagetitle">
        <h1>Reservation List</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Reservation List</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Reservation List</h5>
                        <a href="{{ route('admin.reservations.create') }}" class="btn btn-primary mb-3 addNew">Add <i class="bi bi-plus"></i></a>

                        <!-- Filter Form -->
                        <div class="card mb-3 shadow-sm">
                            <div class="card-body">
                                <form method="GET" action="{{ route('admin.reservations.index') }}">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="faculty_id" class="form-label">Select Faculty</label>
                                            <select name="faculty_id" id="faculty_id" class="form-select">
                                                <option value="">Select Faculty</option>
                                                @foreach($faculties as $faculty)
                                                    <option value="{{ $faculty->faculty_id }}" {{ request('faculty_id') == $faculty->faculty_id ? 'selected' : '' }}>
                                                        {{ $faculty->fullname }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="room_id" class="form-label">Select Room</label>
                                            <select name="room_id" id="room_id" class="form-select">
                                                <option value="">Select Room</option>
                                                @foreach($rooms as $room)
                                                    <option value="{{ $room->room_id }}" {{ request('room_id') == $room->room_id ? 'selected' : '' }}>
                                                        {{ $room->room_number }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select name="status" id="status" class="form-select">
                                                <option value="">Select Status</option>
                                                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="Confirmed" {{ request('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="start_date" class="form-label">Start Date</label>
                                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="end_date" class="form-label">End Date</label>
                                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                                        </div>

                                        <div class="col-md-2 mt-4">
                                            <button type="submit" class="btn btn-primary w-100 mr-3">Filter</button>
                                        </div>
                                        <div class="col-md-2 mt-4">
                                            <a href="{{ route('admin.reservations.index') }}" class="btn btn-danger w-100">reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Reservations Table -->
                        <table class="table table-bordered datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Room</th>
                                <th>Reserved BY</th>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($reservations as $index => $reservation)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><a href="{{ route('admin.rooms.show', $reservation->room_id) }}">{{ optional($reservation->room)->room_number }}</a></td>
                                    <td>{{ optional($reservation->faculty)->fullname ?? auth()->user()->fullname }}</td>
                                    <td>{{ $reservation->date }}</td>
                                    <td>{{ $reservation->start_time }}</td>
                                    <td>{{ $reservation->end_time }}</td>
                                    <td>
                                        <span class="badge bg-{{ $reservation->status == 'Pending' ? 'warning' : ($reservation->status == 'Confirmed' ? 'success' : 'danger') }}">
                                            {{ $reservation->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <form id="deleteForm{{$reservation->reservation_id}}" action="{{ route('admin.reservations.destroy', $reservation->reservation_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                        </form>
                                        <button onclick="confirmDelete(event, 'deleteForm{{$reservation->reservation_id}}')" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
{{--                                        status	enum('', 'Confirmed', 'Cancelled')--}}
                                        @if($reservation->status == 'Pending')
                                            <form id="updateStatus{{$reservation->reservation_id}}" action="{{ route('admin.reservations.updateStatus', $reservation->reservation_id).'?status=Confirmed' }}" method="POST" style="display:inline;">
                                                @csrf
                                            </form>
                                            <form id="updateStatusCancelled{{$reservation->reservation_id}}" action="{{ route('admin.reservations.updateStatus', $reservation->reservation_id).'?status=Cancelled' }}" method="POST" style="display:inline;">
                                                @csrf
                                            </form>
                                            <button onclick="confirmAction(event, 'updateStatus{{$reservation->reservation_id}}', 'Confirm')" class="btn btn-success btn-sm">Confirm</button>
                                            <button onclick="confirmAction(event, 'updateStatusCancelled{{$reservation->reservation_id}}', 'Cancel')" class="btn btn-danger btn-sm">Cancelled</button>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
