@extends('parts.app')

@section('content')
    <div class="pagetitle">
        <h1>Faculty List</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Faculty List</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Faculty List</h5>
                        <a href="{{ route('admin.faculties.create') }}" class="btn btn-primary mb-3 addNew">Add <i class="bi bi-plus"></i></a>

                        <!-- Faculty Table -->
                        <table class="table table-bordered datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Faculty</th>
                                <th>ID Number</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($faculties as $index => $faculty)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $faculty->fullname }}</td>
                                    <td>{{ $faculty->id_number }}</td>
                                    <td>{{ $faculty->email }}</td>
                                    <td>{{ $faculty->EXT }}</td>
                                    <td>
                                        <!-- View Button to Trigger Modal -->
                                        <button type="button" class="btn btn-primary btn-view"
                                                data-id="{{ $faculty->faculty_id }}"
                                                data-fullname="{{ $faculty->fullname }}"
                                                data-id_number="{{ $faculty->id_number }}"
                                                data-email="{{ $faculty->email }}"
                                                data-phone="{{ $faculty->EXT }}"
                                                data-department="{{ $faculty->department }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.faculties.edit', $faculty->faculty_id) }}" class="btn btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.faculties.destroy', $faculty->faculty_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this faculty?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!-- End Faculty Table -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal for Faculty Details -->
    <div class="modal fade" id="facultyModal" tabindex="-1" aria-labelledby="facultyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="facultyModalLabel">Faculty Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <table class="table">
                        <tr><th>Responsible Name:</th><td id="facultyFullName"></td></tr>
                        <tr><th>ID Number:</th><td id="facultyIdNumber"></td></tr>
                        <tr><th>Email:</th><td id="facultyEmail"></td></tr>
                        <tr><th>Phone Number:</th><td id="facultyPhone"></td></tr>
                        <tr><th>Department:</th><td id="facultyDepartment"></td></tr>
                        <tr><th>Position:</th><td id="facultyPosition"></td></tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <!-- Edit Button in Modal -->
                    <a href="#" class="btn btn-warning" id="modalEditButton"><i class="bi bi-pencil"></i> Edit</a>
                    <!-- Close Button -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle click on View button
            document.querySelectorAll('.btn-view').forEach(button => {
                button.addEventListener('click', function() {
                    // Get faculty data from button attributes
                    const id = this.getAttribute('data-id');
                    const fullname = this.getAttribute('data-fullname');
                    const idNumber = this.getAttribute('data-id_number');
                    const email = this.getAttribute('data-email');
                    const phone = this.getAttribute('data-phone');
                    const department = this.getAttribute('data-department');

                    // Populate modal with faculty details
                    document.getElementById('facultyFullName').textContent = fullname;
                    document.getElementById('facultyIdNumber').textContent = idNumber;
                    document.getElementById('facultyEmail').textContent = email;
                    document.getElementById('facultyPhone').textContent = phone;
                    document.getElementById('facultyDepartment').textContent = department;

                    // Set edit button link in the modal
                    const editButton = document.getElementById('modalEditButton');
                    editButton.href = `/admin/faculties/${id}/edit`;

                    // Show the modal
                    new bootstrap.Modal(document.getElementById('facultyModal')).show();
                });
            });
        });
    </script>
@endpush
