<section id="portfolio" class="portfolio section">

    <!-- Section Title -->
    <div class="container section-title">
        <h2>Portfolio</h2>
        <p>A selection of web development and creative projects that showcase my ability to combine functionality with visual storytelling.</p>
    </div><!-- End Section Title -->

    <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

            <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="200">
                <li data-filter="*" class="filter-active">
                    <i class="bi bi-grid-3x3"></i> All Projects
                </li>
                @foreach($portfolioCategories as $category)
                    <li data-filter=".filter-{{ Str::slug($category) }}">
                        {{ $category }}
                    </li>
                @endforeach
            </ul>

            <div class="row g-4 isotope-container" data-aos="fade-up" data-aos-delay="300">
                @forelse($portfolios as $portfolio)
                    <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item isotope-item filter-{{ Str::slug($portfolio->category) }}">
                        <article class="portfolio-entry">
                            <figure class="entry-image">
                                <img src="{{ asset('assets/img/portfolio/' . ($portfolio->image ?? 'default.jpg')) }}" class="img-fluid" alt="{{ $portfolio->title }}" loading="lazy">
                                <div class="entry-overlay">
                                    <div class="overlay-content">
                                        <div class="entry-meta">{{ $portfolio->category }}</div>
                                        <h3 class="entry-title">{{ $portfolio->title }}</h3>
                                        <div class="entry-links">
                                            <a href="{{ asset('assets/img/portfolio/' . ($portfolio->image ?? 'default.jpg')) }}" class="glightbox"
                                                data-gallery="portfolio-gallery-{{ Str::slug($portfolio->category) }}"
                                                data-glightbox="title: {{ $portfolio->title }}; description: {{ Str::limit($portfolio->description, 100) }}">
                                                <i class="bi bi-arrows-angle-expand"></i>
                                            </a>
                                            @if($portfolio->project_url)
                                                <a href="{{ $portfolio->project_url }}" target="_blank" title="View Project">
                                                    <i class="bi bi-arrow-right"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </figure>
                        </article>
                    </div><!-- End Portfolio Item -->
                @empty
                    <div class="col-12">
                        <p class="text-muted text-center">No portfolio items available yet.</p>
                    </div>
                @endforelse
            </div><!-- End Portfolio Container -->

        </div>

    </div>

</section>