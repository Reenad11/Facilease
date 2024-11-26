@extends('parts.app')

@section('content')
    <div class="pagetitle">
        <h1>Notifications</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Notifications</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Notifications</h5>

                        <!-- Notification Table -->
                        <table class="table table-bordered datatable text-center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Notification From</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($notifications as $index => $notification)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ optional($notification->faculty)->fullname ?? 'System' }}</td>
                                    <td>{{ $notification->date_time }}</td>
                                    <td>
                                        @if($notification->status == 'unread')
                                            <span class="badge bg-warning">Unread</span>
                                        @else
                                            <span class="badge bg-success">Read</span>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Button to Open Modal -->
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#notificationModal{{ $notification->notification_id }}">
                                            <i class="bi bi-eye"></i> View
                                        </button>

                                        <!-- Delete Form -->
                                        <form id="deleteForm{{ $notification->notification_id }}" action="{{ route('admin.notifications.destroy', $notification->notification_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button onclick="confirmDelete(event, 'deleteForm{{ $notification->notification_id }}')" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal for Notification Message -->
                                <div class="modal fade" id="notificationModal{{ $notification->notification_id }}" tabindex="-1" aria-labelledby="notificationModalLabel{{ $notification->notification_id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="notificationModalLabel{{ $notification->notification_id }}">Notification Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                {{ $notification->message }}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Modal -->
                            @endforeach
                            </tbody>
                        </table>
                        <!-- End Notification Table -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<script>
    function confirmDelete(event, formId) {
        event.preventDefault();
        if (confirm('Are you sure you want to delete this notification?')) {
            document.getElementById(formId).submit();
        }
    }
</script>
