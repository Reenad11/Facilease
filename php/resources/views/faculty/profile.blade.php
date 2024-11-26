@extends('parts.app')

@section('content')
    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('faculty.dashboard') }}">Home</a></li>
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
                        <h2>{{ $faculty->fullname }}</h2>
                        <h3>Faculty</h3>
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
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-reservations">My Reservations</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-feedbacks">My Feedbacks</button>
                            </li>
                        </ul>

                        <div class="tab-content pt-2">
                            <!-- Profile Overview Tab -->
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">Profile Details</h5>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Full Name</div>
                                    <div class="col-lg-9 col-md-8">{{ $faculty->fullname }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Ext  </div>
                                    <div class="col-lg-9 col-md-8">{{ $faculty->EXT }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{ $faculty->email }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Department</div>
                                    <div class="col-lg-9 col-md-8">{{ $faculty->department }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Position</div>
                                    <div class="col-lg-9 col-md-8">{{ $faculty->position }}</div>
                                </div>
                            </div>

                            <!-- Edit Profile Tab -->
                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <form method="POST" action="{{ route('faculty.updateProfile') }}">
                                    @csrf
                                    @method('PUT')



                                    <div class="col-12 mb-3">
                                        <label for="fullname" class="form-label">Full Name</label>
                                        <input type="text" name="fullname" class="form-control @error('fullname') is-invalid @enderror" id="fullname" value="{{ old('fullname', $faculty->fullname) }}" required>
                                        @error('fullname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="department" class="form-label">Department</label>
                                        <select name="department" class="form-select @error('department') is-invalid @enderror" id="department" required>
                                            <option value="" disabled>Select Department</option>
                                            @foreach(App\Models\Faculty::DEPARTMENTS as $department)
                                                <option value="{{ $department }}" {{ old('department', $faculty->department) == $department ? 'selected' : '' }}>{{ $department }}</option>
                                            @endforeach
                                        </select>
                                        @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="position" class="form-label">Position</label>
                                        <select name="position" class="form-select @error('position') is-invalid @enderror" id="position" required>
                                            <option value="" disabled>Select Position</option>
                                            @foreach(App\Models\Faculty::POSITIONS as $position)
                                                <option value="{{ $position }}" {{ old('position', $faculty->position) == $position ? 'selected' : '' }}>{{ $position }}</option>
                                            @endforeach
                                        </select>
                                        @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="EXT" class="form-label">Ext</label>
                                        <input type="text" name="EXT" class="form-control @error('EXT') is-invalid @enderror" id="EXT" value="{{ old('EXT', $faculty->EXT) }}" required>
                                        <div class="form-text">EXT must start with 05 and followed by 8 digits.</div>
                                        @error('EXT')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email', $faculty->email) }}" required>
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->
                            </div>

                            <!-- Change Password Tab -->
                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <form method="POST" action="{{ route('faculty.updatePassword') }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="row mb-3">
                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" id="currentPassword" required>
                                            @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" id="newPassword" required>
                                            @error('new_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="new_password_confirmation" type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" id="renewPassword" required>
                                            @error('new_password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </form><!-- End Change Password Form -->
                            </div>

                            <!-- My Reservations Tab -->
                            <div class="tab-pane fade pt-3" id="profile-reservations">
                                <h5 class="card-title">My Reservations</h5>
                                @if($faculty->reservations->isEmpty())
                                    <p>No reservations yet.</p>
                                @else
                                    <table class="table table-bordered datatable">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Room Number</th>
                                            <th>Date</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Status</th>
                                            <th>Feedback</th>

                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($faculty->reservations as $index=>$reservation)
                                            <tr>
                                                <td>{{$index + 1}}</td>
                                                <td><a href="{{ route('faculty.rooms.show', $reservation->room_id) }}" target="_blank">{{ optional($reservation->room)->room_number }}</a></td>
                                                <td>{{ $reservation->date }}</td>
                                                <td>{{ date('H:i A',strtotime($reservation->start_time)) }}</td>
                                                <td>{{ date('H:i A',strtotime($reservation->end_time)) }}</td>
                                                <td>
                                                        <span class="badge bg-{{ $reservation->status == 'Pending' ? 'warning' : ($reservation->status == 'Confirmed' ? 'success' : 'danger') }}">
                                                            {{ $reservation->status }}
                                                        </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('faculty.rooms.show', $reservation->room_id) }}?write_feedback=1" class="btn btn-primary">Write Feedback  </a>

                                                </td>
                                                <td>
                                                    @if($reservation->status == 'Pending')
                                                        <form id="cancelForm{{$reservation->reservation_id}}" action="{{ route('faculty.rooms.cancel', $reservation->reservation_id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            <button onclick="confirmAction(event, 'cancelForm{{$reservation->reservation_id}}', 'Cancel')" class="btn btn-danger btn-sm">Cancel</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>


                            <!-- My Feedbacks Tab -->
                            <div class="tab-pane fade pt-3" id="profile-feedbacks">
                                <h5 class="card-title">My Feedbacks</h5>
                                <table class="table table-bordered datatable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Room Number</th>
                                        <th>Rating</th>
                                        <th>Feedback</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($faculty->feedbacks as $index=>$feedback)
                                        <tr>
                                            <td>{{$index + 1}}</td>

                                            <td><a href="{{ route('faculty.rooms.show', $reservation->room_id) }}" target="_blank">{{ optional($feedback->room)->room_number }}</a></td>
                                            <td>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $feedback->rating)
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                    @else
                                                        <i class="bi bi-star-fill text-dark"></i>
                                                    @endif
                                                @endfor
                                            </td>
                                            <td>{{ $feedback->feedback_text }}</td>
                                            <td>{{ date('Y-m-d H:i A', strtotime($feedback->date_time)) }}</td>

                                            <td>
                                                <form id="feedForm{{$feedback->feedback_id}}" action="{{ route('faculty.rooms.feedback.delete', $feedback->feedback_id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="confirmAction(event, 'feedForm{{$feedback->feedback_id}}', 'Cancel')" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- End Bordered Tabs -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
