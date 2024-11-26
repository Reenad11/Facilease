<form method="POST" action="{{ $room ? route('admin.rooms.update', $room->room_id) : route('admin.rooms.store') }}" enctype="multipart/form-data" class="row g-3">
    @csrf
    @if($room)
        @method('PUT')
    @endif

    <div class="col-md-6">
        <label for="room_type_id" class="form-label">Room Type</label>
        <select id="room_type_id" name="room_type_id" class="form-select @error('room_type_id') is-invalid @enderror" required>
            <option value="" disabled>Select Room Type</option>
            @foreach ($roomTypes as $roomType)
                <option value="{{ $roomType->room_type_id }}" {{ old('room_type_id', $room->room_type_id ?? '') == $roomType->room_type_id ? 'selected' : '' }}>
                    {{ $roomType->type_name }}
                </option>
            @endforeach
        </select>
        @error('room_type_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="room_number" class="form-label">Room Number</label>
        <input type="text" class="form-control @error('room_number') is-invalid @enderror" id="room_number" name="room_number" value="{{ old('room_number', $room->room_number ?? '') }}" required>
        @error('room_number')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="location" class="form-label">Location</label>
        <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $room->location ?? '') }}" required>
        @error('location')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="capacity" class="form-label">Capacity</label>
        <input type="number" class="form-control @error('capacity') is-invalid @enderror" id="capacity" name="capacity" value="{{ old('capacity', $room->capacity ?? '') }}" required>
        @error('capacity')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="availability_status" class="form-label">Availability Status</label>
        <select id="availability_status" class="form-select @error('availability_status') is-invalid @enderror" name="availability_status" required>
            <option value="" disabled>Select Status</option>
            <option value="Available" {{ old('availability_status', $room->availability_status ?? '') == 'Available' ? 'selected' : '' }}>Available</option>
            <option value="Reserved" {{ old('availability_status', $room->availability_status ?? '') == 'Reserved' ? 'selected' : '' }}>Reserved</option>
            <option value="Blocked" {{ old('availability_status', $room->availability_status ?? '') == 'Blocked' ? 'selected' : '' }}>Blocked</option>
        </select>
        @error('availability_status')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="images" class="form-label">Room Images</label>
        <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images[]" multiple>
        @error('images')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

        @if($room && $room->images)
            <div class="mt-2">
                @foreach($room->images as $image)
                    <img src="{{ asset($image->image_url) }}" alt="Room Image" class="img-thumbnail" style="max-width: 150px;">
                @endforeach
            </div>
        @endif
    </div>


    <div class="col-md-12">
        <label for="equipment" class="form-label">Equipment</label>
        <textarea id="equipment" name="equipment" class="form-control @error('equipment') is-invalid @enderror">{{ old('equipment', $room->equipment ?? '') }}</textarea>
        @error('equipment')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="col-md-6">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="need_admin_approve" name="need_admin_approve"
                {{ old('need_admin_approve', $room->need_admin_approve ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="need_admin_approve">Need Admin Approval?</label>
        </div>
        @error('need_admin_approve')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary">{{ $room ? 'Update Room' : 'Add Room' }}</button>
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
