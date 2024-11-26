<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Facilease</title>
    @include('parts.header')
</head>
<body>
<main>
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">


                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-center py-4">
                                    <a href="#" class="logo d-flex align-items-center w-auto">
                                        <img src="{{ asset('logo.png') }}" alt="">
                                        {{--                                <span class="d-none d-lg-block">Facilease</span>--}}
                                    </a>
                                </div>
                                <div class=" pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Forgot Password?</h5>
                                </div>

                                <form class="row g-3" method="POST" action="#">
                                    @csrf
                                    <div class="col-12">
                                        <label for="id_number" class="form-label">ID</label>
                                        <input type="text" name="id_number" class="form-control @error('id_number') is-invalid @enderror" id="id_number" value="{{ old('id_number') }}" required>
                                        @error('id_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Reset Password</button>
                                    </div>
                                    <div class="col-12">
                                        <p class="small mb-0">Forgot Password? <a href="{{url('/')}}">Back To Login</a></p>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </section>

    </div>
</main><!-- End #main -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

@include('parts.footer')
</body>
</html>