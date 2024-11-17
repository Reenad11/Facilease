@extends('parts.app')

@section('content')
    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-3">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <img src="{{ asset('assets/img/profile.png') }}" alt="Profile" class="rounded-circle">
                        <h2>{{ auth()->user()->fullname }}</h2>
                        <h3>Admin</h3>
                    </div>
                </div>
            </div>

            <div class="col-xl-9">
                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">

                            <!-- Profile Overview Tab -->
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">Profile Details</h5>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">ID</div>
                                    <div class="col-lg-9 col-md-8">{{ auth()->user()->id_number }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Full Name</div>
                                    <div class="col-lg-9 col-md-8">{{ auth()->user()->fullname }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Ext </div>
                                    <div class="col-lg-9 col-md-8">{{ auth()->user()->EXT }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{ auth()->user()->email }}</div>
                                </div>
                            </div>

                            <!-- Edit Profile Tab -->
                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <form method="POST" action="{{ route('admin.updateProfile') }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="fullname" type="text" class="form-control @error('fullname') is-invalid @enderror" id="fullName" value="{{ old('fullname', auth()->user()->fullname) }}">
                                            @error('fullname')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Ext </label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="EXT" type="text" class="form-control @error('EXT') is-invalid @enderror" id="Phone" value="{{ old('EXT', auth()->user()->EXT) }}">
                                            @error('EXT')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">ID Number</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="id_number" type="number" class="form-control @error('id_number') is-invalid @enderror" id="id_number" value="{{ old('id_number', auth()->user()->id_number) }}">
                                            @error('id_number')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="Email" value="{{ old('email', auth()->user()->email) }}">
                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->
                            </div>

                            <!-- Change Password Tab -->
                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <form method="POST" action="{{ route('admin.updatePassword') }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="row mb-3">
                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" id="currentPassword" required>
                                            @error('current_password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" id="newPassword" required>
                                            @error('new_password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="new_password_confirmation" type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" id="renewPassword" required>
                                            @error('new_password_confirmation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </form><!-- End Change Password Form -->
                            </div>

                        </div><!-- End Bordered Tabs -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
