@extends('parts.app')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush
@section('content')
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Rooms</h5>

                        <!-- Filter Legend Box -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h6 class="card-title">Filters</h6>
                                <form method="GET" action="{{ route('faculty.dashboard') }}" class="row g-3">
                                    <div class="col-md-3">
                                        <label for="room_type" class="form-label">Room Type</label>
                                        <select id="room_type" name="room_type" class="form-select select2">
                                            <option value="">All</option>
                                            @foreach(App\Models\RoomType::all() as $type)
                                                <option value="{{ $type->room_type_id }}" {{ request('room_type') == $type->room_type_id ? 'selected' : '' }}>
                                                    {{ $type->type_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="capacity" class="form-label">Capacity</label>
                                        <input type="number" id="capacity" name="capacity" class="form-control" value="{{ request('capacity') }}" min="1">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="date" class="form-label">Date</label>
                                        <input  min="{{ now()->toDateString() }}" type="date" id="date" name="date" class="form-control" value="{{ request('date') }}">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="equipmentFilter" class="form-label">Equipment</label>
                                        <select id="equipmentFilter" name="equipment[]" class="form-select select2" multiple>
                                            <option value="Projector" {{ in_array('Projector', request('equipment', [])) ? 'selected' : '' }}>Projector</option>
                                            <option value="Microphone" {{ in_array('Microphone', request('equipment', [])) ? 'selected' : '' }}>Microphone</option>
                                            <option value="VIP chairs" {{ in_array('VIP chairs', request('equipment', [])) ? 'selected' : '' }}>VIP chairs</option>
                                            <option value="Chairs with side tables" {{ in_array('Chairs with side tables', request('equipment', [])) ? 'selected' : '' }}>Chairs with side tables</option>
                                            <option value="Stage with curtain" {{ in_array('Stage with curtain', request('equipment', [])) ? 'selected' : '' }}>Stage with curtain</option>
                                        </select>
                                    </div>

                                    <div class="col-1">
                                        <button type="submit" class="btn btn-primary mt-4">Search</button>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <!-- Rooms List -->
                        <div class="row">
                            @foreach($rooms as $room)
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card bbox position-relative">
                                        <!-- Badge for Availability Status -->
                                        <span class="badge bg-{{ $room->availability_status == 'Available' ? 'success' : 'danger' }} position-absolute top-0 start-0 m-2">{{ $room->availability_status }}</span>                                        <!-- Badge for Room Type -->
                                        @if($room->images->isNotEmpty())
                                            <img src="{{ asset($room->images->first()->image_url) }}"  class="card-img-top" alt="Room Image">
                                        @else
                                            <img src="{{ $room->def_image }}"  class="card-img-top" alt="Room Image">
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $room->room_number }}</h5>
                                            <p class="card-text"><i class="bi bi-geo-alt"></i> Location: {{ $room->location }}</p>
                                            <p class="card-text"><i class="bi bi-card-text"></i> Room Type: {{ optional($room->type)->type_name }}</p>
                                            <p class="card-text"><i class="bi bi-people"></i> Capacity: {{ $room->capacity }}</p>
                                            <a href="{{ route('faculty.rooms.show', $room->room_id) }}" class="btn btn-primary">Show Details</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%' // Makes Select2 fields occupy full width
            });
        });
    </script>

@endpush
