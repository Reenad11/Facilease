@extends('parts.app')

@section('content')
    <div class="pagetitle">
        <h1>Admin List</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Admin List</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Admin List</h5>
                        <a href="{{ route('admin.admins.create') }}" class="btn btn-primary mb-3">Add Admin</a>

                        <table class="table table-bordered datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($admins as $index => $admin)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $admin->fullname }}</td>
                                    <td>{{ $admin->phone }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        <a href="{{ route('admin.admins.edit', $admin->admin_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        @if(auth('admin')->user()->admin_id != $admin->admin_id)
                                        <form id="deleteForm{{$admin->admin_id}}" action="{{ route('admin.admins.destroy', $admin->admin_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button onclick="confirmDelete(event,'deleteForm{{$admin->admin_id}}')" class="btn btn-danger btn-sm">Delete</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
