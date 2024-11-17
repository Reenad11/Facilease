@extends('parts.app')

@section('content')
    <div class="pagetitle">
        <h1>Faculty Activity Report</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Faculty Activity</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Faculty Activity</h5>
                        <button class="btn btn-secondary mb-3 mt-2" onclick="window.print()">Print Report <i class="bi bi-printer"></i></button>

                        <table class="table table-bordered datatable">
                            <thead>
                            <tr>
                                <th>Faculty Name</th>
                                <th>Reservations Made</th>
                                <th>Feedback Given</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($faculties as $faculty)
                                <tr>
                                    <td>{{ $faculty->fullname }}</td>
                                    <td>{{ $faculty->reservations_count }}</td>
                                    <td>{{ $faculty->feedbacks_count }}</td>
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
