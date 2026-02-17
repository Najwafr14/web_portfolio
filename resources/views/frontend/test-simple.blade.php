<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { padding: 40px 0; }
        .section { margin-bottom: 80px; }
        .skill-card { background: #f8f9fa; padding: 20px; margin-bottom: 20px; border-radius: 8px; }
        .progress { height: 25px; margin-top: 10px; }
        .portfolio-card { border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; }
        .portfolio-card img { width: 100%; height: 200px; object-fit: cover; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="container">

    <!-- SKILLS SECTION -->
    <div class="section">
        <h1 class="mb-4">💻 Skills ({{ $skills->count() }} total)</h1>
        
        @foreach($skillCategories as $category => $categorySkills)
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="bg-primary text-white p-3">📌 {{ $category }}</h3>
                
                @foreach($categorySkills as $skill)
                <div class="skill-card">
                    <div class="d-flex justify-content-between mb-2">
                        <strong>
                            @if($skill->icon)
                            <i class="{{ $skill->icon }}"></i>
                            @endif
                            {{ $skill->name }}
                        </strong>
                        <span class="badge bg-success">{{ $skill->percentage }}%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success" 
                             style="width: {{ $skill->percentage }}%">
                            {{ $skill->percentage }}%
                        </div>
                    </div>
                    @if($skill->description)
                    <small class="text-muted">{{ $skill->description }}</small>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    <hr>

    <!-- PORTFOLIO SECTION -->
    <div class="section">
        <h1 class="mb-4">🎨 Portfolios ({{ $portfolios->count() }} projects)</h1>
        
        <div class="row">
            @foreach($portfolios as $portfolio)
            <div class="col-md-4 mb-4">
                <div class="portfolio-card">
                    @if($portfolio->image)
                    <img src="{{ asset('assets/img/portfolio/' . $portfolio->image) }}" 
                         alt="{{ $portfolio->title }}"
                         onerror="this.src='https://via.placeholder.com/400x300?text=No+Image'">
                    @else
                    <img src="https://via.placeholder.com/400x300?text=No+Image" alt="No image">
                    @endif
                    
                    <span class="badge bg-info mb-2">{{ $portfolio->category }}</span>
                    
                    @if($portfolio->is_featured)
                    <span class="badge bg-warning mb-2"><i class="bi bi-star-fill"></i> Featured</span>
                    @endif
                    
                    <h5>{{ $portfolio->title }}</h5>
                    <p class="text-muted small">{{ Str::limit($portfolio->description, 100) }}</p>
                    
                    @if($portfolio->tags && is_array($portfolio->tags))
                    <div class="mb-2">
                        @foreach($portfolio->tags as $tag)
                        <span class="badge bg-secondary">{{ $tag }}</span>
                        @endforeach
                    </div>
                    @endif
                    
                    @if($portfolio->project_url)
                    <a href="{{ $portfolio->project_url }}" class="btn btn-sm btn-primary" target="_blank">
                        <i class="bi bi-box-arrow-up-right"></i> View Project
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <hr>

    <!-- EXPERIENCES SECTION -->
    <div class="section">
        <h1 class="mb-4">💼 Work Experience ({{ $experiences->count() }} jobs)</h1>
        
        @foreach($experiences as $exp)
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">{{ $exp->position }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $exp->company }}</h6>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-primary">
                            {{ $exp->start_date->format('M Y') }} - 
                            {{ $exp->is_current ? 'Present' : $exp->end_date->format('M Y') }}
                        </span>
                    </div>
                </div>
                
                @if($exp->description)
                <p class="mt-2">{{ $exp->description }}</p>
                @endif
                
                @if($exp->achievements && is_array($exp->achievements) && count($exp->achievements) > 0)
                <strong>Achievements:</strong>
                <ul>
                    @foreach($exp->achievements as $achievement)
                    <li>{{ $achievement }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <hr>

    <!-- EDUCATIONS SECTION -->
    <div class="section">
        <h1 class="mb-4">🎓 Education ({{ $educations->count() }} degrees)</h1>
        
        @foreach($educations as $edu)
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">{{ $edu->degree }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $edu->institution }}</h6>
                    </div>
                    <span class="badge bg-info">
                        {{ $edu->start_year }} - {{ $edu->end_year ?? 'Present' }}
                    </span>
                </div>
                @if($edu->description)
                <p class="mt-2">{{ $edu->description }}</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <hr>

    <!-- TESTIMONIALS SECTION -->
    <div class="section">
        <h1 class="mb-4">💬 Testimonials ({{ $testimonials->count() }} reviews)</h1>
        
        @if($criticReviews->count() > 0)
        <h3 class="mt-4">Media Reviews ({{ $criticReviews->count() }})</h3>
        <div class="row">
            @foreach($criticReviews as $review)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                <i class="bi bi-star-fill text-warning"></i>
                                @else
                                <i class="bi bi-star text-muted"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="card-text">{{ $review->review_text }}</p>
                        <p class="text-muted mb-0"><strong>{{ $review->critic_name }}</strong></p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        
        @if($personalReviews->count() > 0)
        <h3 class="mt-4">Client Reviews ({{ $personalReviews->count() }})</h3>
        <div class="row">
            @foreach($personalReviews as $test)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        @if($test->avatar)
                        <img src="{{ asset('assets/img/person/' . $test->avatar) }}" 
                             class="rounded-circle mb-3"
                             style="width: 80px; height: 80px; object-fit: cover;"
                             onerror="this.src='https://via.placeholder.com/80'">
                        @else
                        <div class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 80px; height: 80px; font-size: 32px;">
                            {{ substr($test->name, 0, 1) }}
                        </div>
                        @endif
                        
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $test->rating)
                                <i class="bi bi-star-fill text-warning"></i>
                                @else
                                <i class="bi bi-star text-muted"></i>
                                @endif
                            @endfor
                        </div>
                        
                        <p class="card-text">{{ $test->review_text }}</p>
                        
                        <h6 class="mb-0">{{ $test->name }}</h6>
                        @if($test->position || $test->company)
                        <p class="text-muted small mb-0">
                            {{ $test->position }}{{ $test->position && $test->company ? ' at ' : '' }}{{ $test->company }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <hr>

    <!-- SOCIAL LINKS SECTION -->
    <div class="section">
        <h1 class="mb-4">🔗 Social Links ({{ $socialLinks->count() }} links)</h1>
        
        <div class="d-flex gap-3">
            @foreach($socialLinks as $link)
            <a href="{{ $link->url }}" 
               target="_blank" 
               class="btn btn-outline-primary btn-lg">
                <i class="{{ $link->icon }} fa-2x"></i>
                <br><small>{{ $link->platform }}</small>
            </a>
            @endforeach
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>