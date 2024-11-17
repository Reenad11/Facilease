@extends('parts.app')

@section('content')
    <div class="pagetitle">
        <h1>Reservation Utilization Report</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Reservation Utilization</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Room Utilization</h5>

                        <button class="btn btn-secondary mb-3 mt-2" onclick="window.print()">Print Report <i
                                class="bi bi-printer"></i></button>


                            <!-- Filter Section -->
                            <div class="col-md-12">
                                <form style="border: 1px solid #ffd6d6;padding: 20px;margin: 10px" method="GET"
                                      action="{{ route('admin.reports.reservationUtilization') }}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="start_date" class="form-label">Start Date</label>
                                            <input type="date" name="start_date" id="start_date" class="form-control"
                                                   value="{{ request('start_date') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="end_date" class="form-label">End Date</label>
                                            <input type="date" name="end_date" id="end_date" class="form-control"
                                                   value="{{ request('end_date') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="room_id" class="form-label">Room</label>
                                            <select name="room_id" id="room_id" class="form-select">
                                                <option value="">All Rooms</option>
                                                @foreach($rooms as $room)
                                                    <option
                                                        value="{{ $room->room_id }}" {{ request('room_id') == $room->room_id ? 'selected' : '' }}>{{ $room->room_number }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end mt-4">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        <div class="row p-4">
                            <div class="col-md-8">
                                <table class="table table-bordered datatable">
                                    <thead>
                                    <tr>
                                        <th>Room Number</th>
                                        <th>Total Reserved Hours</th>
                                        <th>Utilization Percentage</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($roomUtilization as $room)
                                        <tr>
                                            <td>{{ $room['room_number'] }}</td>
                                            <td>{{ $room['total_reserved_hours'] }}</td>
                                            <td>{{ $room['utilization_percentage'] }} %</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- Chart.js Pie Chart -->
                            <div class="col-md-4">
                                <canvas id="reservationChart"></canvas>

                            </div>


                            <!-- Most Booked Rooms Table -->
                         <div class="col-md-6">
                             <h5 class="card-title mt-5">Most Booked Rooms</h5>
                             <table class="table table-bordered">
                                 <thead>
                                 <tr>
                                     <th>Room Number</th>
{{--                                     <th>Booking Count</th>--}}
                                 </tr>
                                 </thead>
                                 <tbody>
                                 @foreach($mostBookedRooms as $roomNumber => $count)
                                     <tr>
{{--                                         <td>Room {{ $roomNumber }}</td>--}}
                                         <td>{{ $count }}</td>
                                     </tr>
                                 @endforeach
                                 </tbody>
                             </table>
                         </div>

                            <!-- Five Star Rooms by Room Type Table -->
                        <div class="col-md-6">
                            <h5 class="card-title mt-5">Five Star Rooms by Room Type</h5>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Room Type</th>
                                    <th>Room Numbers</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($fiveStarRooms as $roomTypeId => $rooms)
                                    @php
$type = \App\Models\RoomType::find($roomTypeId); @endphp
                                    <tr>
                                        <td>{{$type->type_name}}</td>
                                        <td>
                                            {{ implode(', ', $rooms->pluck('room_number')->toArray()) }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const ctx = document.getElementById('reservationChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [{
                        data: @json($chartData['series']),
                        backgroundColor: ['#4caf50', '#ffeb3b', '#f44336'],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
@endpush
