@extends('parts.app')

@section('content')
    <div class="pagetitle">
        <h1>Edit Faculty</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.faculties.index') }}">Faculty List</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Faculty</h5>

                        <form action="{{ route('admin.faculties.update', $faculty->faculty_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">


                                <!-- Full Name -->
                                <div class="mb-3 col-md-6">
                                    <label for="fullname" class="form-label">Full Name</label>
                                    <input type="text" class="form-control @error('fullname') is-invalid @enderror" name="fullname" value="{{ old('fullname', $faculty->fullname) }}">
                                    @error('fullname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phone Number -->
                                <div class="mb-3 col-md-6">
                                    <label for="EXT" class="form-label">EXT</label>
                                    <input type="text" class="form-control @error('EXT') is-invalid @enderror" name="EXT" value="{{ old('EXT', $faculty->EXT) }}">
                                    @error('EXT')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- ID Number -->
                                <div class="mb-3 col-md-6">
                                    <label for="id_number" class="form-label">ID Number</label>
                                    <input type="text" class="form-control @error('id_number') is-invalid @enderror" name="id_number" value="{{ old('id_number', $faculty->id_number) }}">
                                    @error('id_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $faculty->email) }}">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="mb-3 col-md-6">
                                    <label for="password" class="form-label">Password (Leave blank to keep current password)</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-3 col-md-6">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>

                                <!-- Department -->
                                <div class="mb-3 col-md-6">
                                    <label for="department" class="form-label">Department</label>
                                    <select class="form-select @error('department') is-invalid @enderror" name="department">
                                        <option value="" selected disabled>Select Department</option>
                                        @foreach (App\Models\Faculty::DEPARTMENTS as $department)
                                            <option value="{{ $department }}" {{ old('department', $faculty->department) == $department ? 'selected' : '' }}>{{ $department }}</option>
                                        @endforeach
                                    </select>
                                    @error('department')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Position -->
                                <div class="mb-3 col-md-6">
                                    <label for="position" class="form-label">Position</label>
                                    <select class="form-select @error('position') is-invalid @enderror" name="position">
                                        <option value="" selected disabled>Select Position</option>
                                        @foreach (App\Models\Faculty::POSITIONS as $position)
                                            <option value="{{ $position }}" {{ old('position', $faculty->position) == $position ? 'selected' : '' }}>{{ $position }}</option>
                                        @endforeach
                                    </select>
                                    @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
