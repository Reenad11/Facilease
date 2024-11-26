@extends('parts.app')

@section('content')
    <div class="pagetitle">
        <h1>Add Room Type</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.roomTypes.index') }}">Room Types</a></li>
                <li class="breadcrumb-item active">Add Room Type</li>
            </ol>
        </nav>
    </div>

    @include('admin.roomTypes.form', ['roomType' => null])
@endsection
