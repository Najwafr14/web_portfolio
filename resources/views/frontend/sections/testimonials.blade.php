<section id="testimonials" class="testimonials section">
    <!-- Section Title -->
    <div class="container section-title">
        <h2>Testimonials</h2>
        <p>Feedback and impressions that reflect my work ethic, adaptability, and creative approach.</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
            <div class="col-12">
                <div class="critic-reviews" data-aos="fade-up" data-aos-delay="300">
                    <div class="row">
                        @forelse($criticReviews as $review)
                            <div class="col-md-4">
                                <div class="critic-review">
                                    <div class="review-quote">"</div>
                                    <div class="stars">
                                        @for($i = 0; $i < 5; $i++)
                                            @if($i < floor($review->rating ?? 5))
                                                <i class="bi bi-star-fill"></i>
                                            @elseif($i < $review->rating ?? 5)
                                                <i class="bi bi-star-half"></i>
                                            @else
                                                <i class="bi bi-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <p>{{ $review->review_text }}</p>
                                    <div class="critic-info">
                                        <div class="critic-name">{{ $review->critic_name ?? 'Publication' }}</div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted">No critic reviews yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="testimonials-container">
                    <div class="swiper testimonials-slider init-swiper" data-aos="fade-up" data-aos-delay="400">
                        <script type="application/json" class="swiper-config">
                  {
                    "loop": true,
                    "speed": 600,
                    "autoplay": {
                      "delay": 5000
                    },
                    "slidesPerView": 1,
                    "spaceBetween": 30,
                    "pagination": {
                      "el": ".swiper-pagination",
                      "type": "bullets",
                      "clickable": true
                    },
                    "breakpoints": {
                      "768": {
                        "slidesPerView": 2
                      },
                      "992": {
                        "slidesPerView": 3
                      }
                    }
                  }
                </script>

                        <div class="swiper-wrapper">
                            @forelse($personalReviews as $testimonial)
                                <div class="swiper-slide">
                                    <div class="testimonial-item">
                                        <div class="stars">
                                            @for($i = 0; $i < 5; $i++)
                                                @if($i < floor($testimonial->rating ?? 5))
                                                    <i class="bi bi-star-fill"></i>
                                                @elseif($i < $testimonial->rating ?? 5)
                                                    <i class="bi bi-star-half"></i>
                                                @else
                                                    <i class="bi bi-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <p>{{ $testimonial->review_text }}</p>
                                        <div class="testimonial-profile">
                                            <img src="{{ $testimonial->avatar ? asset('assets/img/person/' . $testimonial->avatar) : asset('assets/img/person/person-default.webp') }}" alt="{{ $testimonial->name }}" class="img-fluid rounded-circle" loading="lazy">
                                            <div>
                                                <h3>{{ $testimonial->name }}</h3>
                                                <h4>{{ $testimonial->position }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="swiper-slide">
                                    <div class="alert alert-info">No testimonials yet.</div>
                                </div>
                            @endforelse
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>