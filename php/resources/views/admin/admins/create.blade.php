@extends('parts.app')

@section('content')
    <div class="pagetitle">
        <h1>Add Admin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Add Admin</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Admin</h5>

                        @include('admin.admins.form', ['admin' => null])

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
