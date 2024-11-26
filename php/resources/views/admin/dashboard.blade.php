@extends('parts.app')

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <!-- Cards -->
            <div class="col-lg-12">
                <div class="row">
                    <!-- Faculty Card -->
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card faculty-card">
                            <div class="card-body">
                                <h5 class="card-title">Faculty <span>| Total</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person-badge text-primary"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $facultyCount }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Faculty Card -->
                    <!-- Room Card -->
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card room-card">
                            <div class="card-body">
                                <h5 class="card-title">Rooms <span>| Total</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-door-closed text-primary"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $roomCount }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Room Card -->

                    <!-- Event Card -->
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card event-card">
                            <div class="card-body">
                                <h5 class="card-title">Reservations <span>| Total</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar-event text-primary"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $resCount }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Event Card -->

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Reservation Count Overview (By Week)</h5>
                                <!-- Line Chart -->
                                <div id="reservationCountChart"></div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new ApexCharts(document.querySelector("#reservationCountChart"), {
                                            series: [{
                                                name: 'Reservations',
                                                data: [{{ $reservationStats->pluck('count')->implode(', ') }}],
                                            }],
                                            chart: {
                                                height: 350,
                                                type: 'line',
                                                toolbar: {
                                                    show: false
                                                },
                                            },
                                            xaxis: {
                                                categories: [@foreach($reservationStats as $stat) "{{ $stat['week'] }}", @endforeach],
                                                title: {
                                                    text: 'Week'
                                                }
                                            },
                                            yaxis: {
                                                title: {
                                                    text: 'Count'
                                                }
                                            },
                                            dataLabels: {
                                                enabled: false
                                            },
                                            stroke: {
                                                width: 2
                                            },
                                            tooltip: {
                                                y: {
                                                    formatter: function (val) {
                                                        return val + " reservations";
                                                    }
                                                }
                                            }
                                        }).render();
                                    });
                                </script>
                            </div>
                        </div>
                    </div><!-- End Reservation Count Chart by Week -->

                    <!-- Recent Reservations Table -->
                    <div class="col-12">
                        <div class="card recent-reservations overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Recent Reservations</h5>

                                <table class="table table-borderless">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Room</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Faculty</th>
                                        <th scope="col">Start Time</th>
                                        <th scope="col">End Time</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($latestReservations as $reservation)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><a href="#" class="text-primary">{{ optional($reservation->room)->room_number }}</a></td>
                                            <td>{{ $reservation->date }}</td>

                                            <td>{{ optional($reservation->faculty)->fullname }}</td>
                                            <td>{{ $reservation->start_time }}</td>
                                            <td>{{ $reservation->end_time }}</td>
                                            <td><span class="badge bg-{{ $reservation->status == 'Pending' ? 'warning' : ($reservation->status == 'Confirmed' ? 'success' : 'danger') }}">{{ $reservation->status }}</span></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- End Recent Reservations -->
                </div>
            </div>
        </div>
    </section>
@endsection
