@extends('parts.app')

@section('content')
    <div class="pagetitle">
        <h1>Feedbacks List</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Feedbacks List</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Feedbacks List</h5>

                        <!-- Table -->
                        <table class="table table-bordered datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Room Number</th>
                                <th>Faculty</th>
                                <th>Rating</th>
                                <th>Added At</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($feeds as $index => $feed)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <a href="{{ route('admin.rooms.show', optional($feed->room)->room_id) }}">
                                            {{ optional($feed->room)->room_number }}
                                        </a>

                                    </td>
                                    <td>{{ optional($feed->faculty)->fullname }}</td>
                                    <td>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star {{ $i <= $feed->rating ? 'text-warning' : '' }}"></i>
                                        @endfor
                                    </td>
                                    <td>{{ $feed->date_time }}</td>
                                    <td>
                                        <!-- View Button to Trigger Modal -->
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#feedbackModal{{ $feed->feedback_id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <!-- Delete Button -->
                                        <form id="deleteForm{{$feed->feedback_id}}" action="{{ route('admin.feedbacks.destroy', $feed->feedback_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button onclick="confirmDelete(event,'deleteForm{{$feed->feedback_id}}')" class="btn btn-danger btn-sm">  <i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>

                                <!-- Modal for Viewing Feedback Details -->
                                <div class="modal fade" id="feedbackModal{{ $feed->feedback_id }}" tabindex="-1" aria-labelledby="feedbackModalLabel{{ $feed->feedback_id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="feedbackModalLabel{{ $feed->feedback_id }}">Feedback Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Room Number:</strong> {{ optional($feed->room)->room_number }}</p>
                                                <p><strong>Faculty:</strong> {{ optional($feed->faculty)->fullname }}</p>
                                                <p><strong>Comment:</strong> {{ $feed->feedback_text }}</p>
                                                <p><strong>Rating:</strong>
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="bi bi-star {{ $i <= $feed->rating ? 'text-warning' : '' }}"></i>
                                                    @endfor
                                                </p>
                                                <p><strong>Added At:</strong> {{ $feed->date_time }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </tbody>
                        </table>
                        <!-- End Table -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
