<form method="POST" action="{{ $roomType ? route('admin.roomTypes.update', $roomType->room_type_id) : route('admin.roomTypes.store') }}" class="row g-3">
    @csrf
    @if($roomType)
        @method('PUT')
    @endif

    <div class="col-md-12">
        <label for="type_name" class="form-label">Room Type Name</label>
        <input type="text" class="form-control @error('type_name') is-invalid @enderror" id="type_name" name="type_name" value="{{ old('type_name', $roomType->type_name ?? '') }}" required>
        @error('type_name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary">{{ $roomType ? 'Update' : 'Add' }} Room Type</button>
        <a href="{{ route('admin.roomTypes.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
