@extends('parts.app')

@section('content')
    <div class="pagetitle">
        <h1>New Reservation</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.reservations.index') }}">Reservation List</a></li>
                <li class="breadcrumb-item active">New Reservation</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Create Reservation</h5>
                        <form method="POST" action="{{ route('admin.reservations.store') }}" class="row g-3">
                            @csrf

                            <div class="col-md-6">
                                <label for="room_id" class="form-label">Room</label>
                                <select id="room_id" name="room_id" class="form-select @error('room_id') is-invalid @enderror" required>
                                    <option value="" disabled>Select Room</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->room_id }}" {{ old('room_id') == $room->room_id ? 'selected' : '' }}>
                                            {{ $room->room_number }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date') }}" min="{{ now()->toDateString() }}" required>
                                @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                                @error('start_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                                @error('end_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea id="notes" name="notes" class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                                @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Add Reservation</button>
                                <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
