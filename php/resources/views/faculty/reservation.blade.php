@extends('parts.app')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <!-- Swiper CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />

    <!-- Fancybox CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox/dist/jquery.fancybox.min.css" />
@endpush
@section('content')
    <section class="section room-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Room Details</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Main Image Slider -->
                                    <div style="overflow:hidden;" class="swiper-container main-slider">
                                        <div class="swiper-wrapper">
                                            @foreach($room->images as $image)
                                                <div class="swiper-slide">
                                                    <a href="{{ asset($image->image_url) }}" data-fancybox="gallery" data-caption="Room Image">
                                                        <img src="{{ asset($image->image_url) }}" class="img-fluid" alt="Room Image" />
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                        {{--                                        <!-- Navigation buttons for main slider -->--}}
                                        {{--                                        <div class="swiper-button-next"></div>--}}
                                        {{--                                        <div class="swiper-button-prev"></div>--}}
                                    </div>

                                    <!-- Thumbnail Slider -->
                                    <div class="swiper-container thumb-slider mt-3">
                                        <div class="swiper-wrapper">
                                            @foreach($room->images as $image)
                                                <div class="swiper-slide">
                                                    <img src="{{ asset($image->image_url) }}" class="img-fluid img-thumbnail" alt="Thumbnail Image" style="cursor: pointer;" />
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6>Room Number: {{ $room->room_number }}</h6>
                                    <p><i class="bi bi-geo-alt"></i> Location: {{ $room->location }}</p>
                                    <p><i class="bi bi-card-text"></i> Room Type: {{ optional($room->type)->type_name }}</p>
                                    <p><i class="bi bi-people"></i> Capacity: {{ $room->capacity }}</p>
{{--                                    <p><i class="bi bi-calendar"></i> Availability Status: <span class="badge bg-{{ $room->availability_status == 'Available' ? 'success' : 'danger' }}">{{ $room->availability_status }}</span></p>--}}
                                    @if($room->need_admin_approve)
                                        <div class="alert alert-warning" role="alert">
                                            <i class="bi bi-exclamation-triangle-fill"></i>
                                            This room requires admin approval before the booking can be confirmed.
                                        </div>
                                    @endif

                                </div>
                            </div>

                            <!-- Booking Calendar -->
                            <div class="mt-4">
                                <h5 class="card-title">Available Dates</h5>
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal for Booking -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Book This Room</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bookingForm" method="POST" action="{{ route('faculty.rooms.confirmReservation', ['id' => $room->room_id]) }}">
                        @csrf
                        <input type="hidden" value="{{old('selected_date')}}" name="selected_date" id="selected_date">
                        <div class="mb-3">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="time" name="start_time" id="start_time" value="{{old('start_time')}}" class="form-control @error('start_time') is-invalid @enderror" required>
                            @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="time" name="end_time" id="end_time" value="{{old('end_time')}}" class="form-control @error('end_time') is-invalid @enderror" required>
                            @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Submit Booking</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                validRange: {
                    start: new Date().toISOString().split('T')[0] // Disable past dates
                },
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($events),
                dateClick: function(info) {
                    document.getElementById('selected_date').value = info.dateStr;
                    var modal = new bootstrap.Modal(document.getElementById('bookingModal'));
                    modal.show();
                }
            });

            calendar.render();
        });
        @if($errors->any())
        var modal = new bootstrap.Modal(document.getElementById('bookingModal'));
        modal.show();
        @endif
    </script>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox/dist/jquery.fancybox.min.js"></script>

    <script>
        // Initialize the thumbnail Swiper slider first
        const thumbSlider = new Swiper('.thumb-slider', {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            on: {
                click: function (swiper) {
                    mainSlider.slideTo(swiper.clickedIndex);
                }
            }
        });

        // Initialize the main Swiper slider and link it to the thumbSlider
        const mainSlider = new Swiper('.main-slider', {
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: thumbSlider // Link the thumbnail slider here
            }
        });

        // Initialize Fancybox for zoom functionality
        $('[data-fancybox="gallery"]').fancybox({
            buttons: [
                "zoom",
                "slideShow",
                "thumbs",
                "close"
            ],
            loop: true,
            protect: true,
        });
    </script>
@endpush
