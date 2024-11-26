@extends('parts.app')

@section('content')
    <div class="pagetitle">
        <h1>Edit Room Type</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.roomTypes.index') }}">Room Types</a></li>
                <li class="breadcrumb-item active">Edit Room Type</li>
            </ol>
        </nav>
    </div>

    @include('admin.roomTypes.form', ['roomType' => $roomType])
@endsection
