<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Faculty Registration</title>
    @include('parts.header')
</head>
<body>
<main>
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="d-flex justify-content-center py-4">
                            <a href="#" class="logo d-flex align-items-center w-auto">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="">
                                <span class="d-none d-lg-block">Facilease</span>
                            </a>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Faculty Registration</h5>
                                </div>

                                <form class="row g-3" method="POST" action="{{ route('register.faculty.post') }}">
                                    @csrf


                                    <div class="col-12">
                                        <label for="fullname" class="form-label">Full Name</label>
                                        <input type="text" name="fullname" class="form-control @error('fullname') is-invalid @enderror" id="fullname" value="{{ old('fullname') }}" required>
                                        @error('fullname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="department" class="form-label">Department</label>
                                        <select name="department" class="form-select @error('department') is-invalid @enderror" id="department" required>
                                            <option value="" disabled selected>Select Department</option>
                                            @foreach(App\Models\Faculty::DEPARTMENTS as $department)
                                                <option value="{{ $department }}">{{ $department }}</option>
                                            @endforeach
                                        </select>
                                        @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-12">
                                        <label for="EXT" class="form-label">Phone Number</label>
                                        <input type="text" name="EXT" class="form-control @error('EXT') is-invalid @enderror" id="EXT" value="{{ old('EXT') }}" required>
                                        <div class="form-text">Phone number must start with 05 and followed by 8 digits.</div>

                                        @error('EXT')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required>
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required>
                                        <div class="form-text">Password must be at least 8 characters long and contain both letters and numbers.</div>

                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Register</button>
                                    </div>
                                    <div class="col-12">
                                        <p class="small mb-0">Already have an account? <a href="{{ route('auth.login') }}">Login</a></p>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

@include('parts.footer')
</body>
</html>
