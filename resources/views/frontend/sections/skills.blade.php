<section id="skills" class="skills section">
    <div class="container section-title">
        <h2>My Skills</h2>
        <p>Technical expertise and proficiencies</p>
    </div>

    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-12">
                <div class="row g-4">
                    @forelse($skillCategories as $category => $categorySkills)
                        <div class="col-md-6" data-aos="flip-left" data-aos-delay="200">
                            <div class="skill-card">
                                <div class="skill-header">
                                    @if ($category === 'Programming')
                                        <i class="bi bi-code-slash"></i>
                                    @elseif ($category === 'Database')
                                        <i class="bi bi-database"></i>
                                    @elseif ($category === 'Technology')
                                        <i class="bi bi-gear"></i>
                                    @elseif ($category === 'Language')
                                        <i class="bi bi-translate"></i>                                    
                                    @endif
                                    <h3>{{ $category }}</h3>
                                </div>
                                <div class="skills-animation">

                                    @foreach($categorySkills as $skill)
                                        <div class="skill-item">
                                            <div class="skill-info">
                                                <span class="skill-name">
                                                    {{ $skill->name }}
                                                </span>
                                                <span class="skill-percentage">{{ $skill->percentage }}%</span>
                                            </div>
                                            <div class="skill-bar progress">
                                                <div class="progress-bar bg-blue" role="progressbar"
                                                    style="width: {{ $skill->percentage }}%"
                                                    aria-valuenow="{{ $skill->percentage }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted">No skills added yet.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</section>