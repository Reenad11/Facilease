@extends('parts.app')

@section('content')
    <div class="pagetitle">
        <h1>Edit Room</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.rooms.index') }}">Rooms List</a></li>
                <li class="breadcrumb-item active">Edit Room</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Room</h5>
                        @include('admin.rooms.form', ['room' => $room])
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
