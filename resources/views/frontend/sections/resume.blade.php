<section id="resume" class="resume section">

    <!-- Section Title -->
    <div class="container section-title">
        <h2>Resume</h2>
        <p>An overview of my academic background and professional experiences that shape how I work today.</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
            <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
                <div class="experience-section">
                    <div class="section-header">
                        <h2><i class="bi bi-briefcase"></i> Professional Journey</h2>
                        <p class="section-subtitle">I have worked in both technical and non-technical environments,
                            gaining experience in collaboration, communication, and structured workflows. These
                            experiences help me adapt quickly and work effectively in diverse teams.</p>
                    </div>

                    <div class="experience-cards">
                        @forelse($experiences as $exp)
                            <div class="experience-card" data-aos="zoom-in" data-aos-delay="300">
                                <div class="card-header">
                                    <div class="role-info">
                                        <h3>{{ $exp->position }}</h3>
                                        <h4>{{ $exp->company }}</h4>
                                    </div>
                                    <span class="duration">{{ $exp->start_date->format('Y') }} -
                                        {{ $exp->end_date ? $exp->end_date->format('Y') : 'Present' }}</span>
                                </div>
                                <div class="card-body">
                                    <p>{{ $exp->description }}</p>
                                    @if($exp->achievements)
                                        <ul class="achievements">
                                            @foreach($exp->achievements as $achievement)
                                                @if(trim($achievement))
                                                    <li>{{ trim($achievement) }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">No experience entries yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="education-section">
                    <div class="section-header">
                        <h2><i class="bi bi-mortarboard"></i> Academic Excellence</h2>
                        <p class="section-subtitle">Currently pursuing a Bachelor’s degree in Computer Science, with a
                            focus on web development and applied technologies such as Natural Language Processing.</p>
                    </div>

                    <div class="education-timeline">
                        <div class="timeline-track"></div>

                        @forelse($educations as $edu)
                            <div class="education-item" data-aos="slide-up" data-aos-delay="300">
                                <div class="timeline-marker"></div>
                                <div class="education-content">
                                    <div class="degree-header">
                                        <h3>{{ $edu->degree }}</h3>
                                        <span
                                            class="year">{{ $edu->start_year }}{{ $edu->end_year ? ' - ' . $edu->end_year : '' }}</span>
                                    </div>
                                    <h4 class="institution">{{ $edu->institution }}</h4>
                                    @if($edu->description)
                                        <p>{{ $edu->description }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info">No education entries yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>