@extends('parts.app')

@section('content')
    <div class="pagetitle">
        <h1>View Room Details</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.rooms.index') }}">Rooms List</a></li>
                <li class="breadcrumb-item active">Room Details</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Room Details</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <strong>Room Number:</strong>
                                <p>{{ $room->room_number }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Location:</strong>
                                <p>{{ $room->location }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Capacity:</strong>
                                <p>{{ $room->capacity }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Equipment:</strong>
                                <p>{!! $room->equipment !!}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Availability Status:</strong>
                                <p>{{ $room->availability_status }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Room Type:</strong>
                                <p>{{ optional($room->type)->type_name }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>      Need Admin Approval?</strong>
                                    @if($room->need_admin_approve)
                                        <i class="bi bi-check-circle text-success"></i>
                                    @else
                                        <i class="bi bi-x-circle text-danger"></i>
                                    @endif
                            </div>

                            <div class="col-md-6">
                                <strong>Images:</strong>
                                @if($room->images->isNotEmpty())
                                    <div class="mt-2">
                                        @foreach($room->images as $image)
                                            <img src="{{ asset($image->image_url) }}" alt="Room Image" class="img-thumbnail" style="max-width: 150px; margin-right: 10px;">
                                        @endforeach
                                    </div>
                                @else
                                    <p>No images available</p>
                                @endif
                            </div>


                        </div>
                        <div class="mt-4">
                            <h5 class="card-title">Reviews</h5>
                            @if($room->feedbacks->isEmpty())
                                <p>No reviews yet.</p>
                            @else
                                @foreach($room->feedbacks()->latest('feedback_id')->get() as $feedback)
                                    <div class="card mb-3">
                                        <div class="card-body d-flex p-3">
                                            <img src="{{ asset('assets/img/profile.png') }}" style="width: 50px; height: 50px; object-fit: cover;" class="rounded-circle me-3" alt="User">
                                            <div class="flex-grow-1">
                                                <p>
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $feedback->rating)
                                                            <i class="bi bi-star-fill text-warning"></i>
                                                        @else
                                                            <i class="bi bi-star-fill text-dark"></i>
                                                        @endif
                                                    @endfor
                                                </p>
                                                <h6 class="card-subtitle mb-2 text-muted">
                                                    <strong class="text-muted">BY : {{ optional($feedback->faculty)->fullname ?? 'Anonymous' }}</strong>
                                                    @auth('faculty')
                                                        @if ($feedback->faculty_id == auth('faculty')->user()->faculty_id)
                                                            <form id="fromFeedback{{$feedback->feedback_id}}" action="{{ route('faculty.rooms.feedback.delete', $feedback->feedback_id) }}" method="POST" class="d-inline float-end">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button onclick="confirmDelete(event, 'fromFeedback{{$feedback->feedback_id}}')" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></button>
                                                            </form>
                                                        @endif
                                                    @endauth
                                                </h6>
                                                <p class="card-text">{{ $feedback->feedback_text }}</p>
                                                <p class="card-text"><small class="text-muted">{{ date('Y-m-d H:i A', strtotime($feedback->date_time)) }}</small></p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('admin.rooms.edit', $room->room_id) }}" class="btn btn-warning">Edit</a>
                            <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
