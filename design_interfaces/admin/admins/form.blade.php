<form class="row" method="POST" action="{{ $admin ? route('admin.admins.update', $admin->admin_id) : route('admin.admins.store') }}">
    @csrf
    @if($admin)
        @method('PUT')
    @endif

    <div class="col-md-6 mb-3">
        <label for="fullname" class="form-label">Full Name</label>
        <input type="text" class="form-control @error('fullname') is-invalid @enderror" id="fullname" name="fullname" value="{{ old('fullname', $admin->fullname ?? '') }}" required>
        @error('fullname')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $admin->phone ?? '') }}" required>
        <div class="form-text">Phone number must start with 05 and followed by 8 digits.</div>

        @error('phone')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $admin->email ?? '') }}" required>
        @error('email')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" {{ $admin ? '' : 'required' }}>
        <div class="form-text">Password must be at least 8 characters long and contain both letters and numbers.</div>

        @error('password')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        @if($admin)
            <small class="form-text text-muted">Leave blank if you don't want to change the password.</small>
        @endif
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary">{{ $admin ? 'Update Admin' : 'Add Admin' }}</button>
        <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
