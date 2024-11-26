@extends('parts.app')
@push('css')
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
                                    <!-- Room details -->
                                    <h6>Room Number: {{ $room->room_number }}</h6>
                                    <p><i class="bi bi-geo-alt"></i> Location: {{ $room->location }}</p>
                                    <p><i class="bi bi-card-text"></i> Room Type: {{ optional($room->type)->type_name }}</p>
                                    <p><i class="bi bi-people"></i> Capacity: {{ $room->capacity }}</p>
{{--                                    <p><i class="bi bi-calendar"></i> Availability Status: <span class="badge bg-{{ $room->availability_status == 'Available' ? 'success' : 'danger' }}">{{ $room->availability_status }}</span></p>--}}
                                    <p>{!! $room->equipment !!}</p>
                                    <a href="{{ route('faculty.rooms.book', ['id' => $room->room_id]) }}" class="btn w-50 btn-primary">Book Now</a>
                                </div>
                            </div>



                            <!-- Reviews Section -->
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

                            <!-- Add Feedback Form -->
                            @auth('faculty')
                                @if(request()->filled('write_feedback'))
                                <div class="mt-4">
                                    <h5 class="card-title">Add Your Review</h5>
                                    <form method="POST" action="{{ route('faculty.rooms.feedback.addNewFeedback', ['id' => $room->room_id]) }}">
                                        @csrf

                                        <div class="mb-3">
                                            <label for="rating" class="form-label">Rating</label>
                                            <div id="rating-stars" class="d-flex">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="bi bi-star" data-value="{{ $i }}" style="font-size: 24px; cursor: pointer; color: gray;"></i>
                                                @endfor
                                                <input type="hidden" name="rating" id="rating" value="" required>
                                                @error('rating')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="feedback_text" class="form-label">Feedback</label>
                                            <textarea name="feedback_text" id="feedback_text" class="form-control @error('feedback_text') is-invalid @enderror" rows="4" required></textarea>
                                            @error('feedback_text')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-primary">Submit Review</button>
                                    </form>
                                </div>
                                @endif
                            @endauth

{{--                            <a href="{{ route('faculty.dashboard') }}" class="btn btn-danger btn-sm">Back to Rooms</a>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('#rating-stars .bi-star');
            const ratingInput = document.getElementById('rating');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    ratingInput.value = value;
                    updateStars(value);
                });
            });

            function updateStars(value) {
                stars.forEach(star => {
                    if (star.getAttribute('data-value') <= value) {
                        star.style.color = 'gold';
                    } else {
                        star.style.color = 'gray';
                    }
                });
            }
        });
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
