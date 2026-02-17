@extends('layouts.admin')

@section('title', 'Dashboard CMS')
@section('page-title', 'Content Management System')

@section('content')

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-2 col-6">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h3>{{ $stats['skills_count'] }}</h3>
                <p class="mb-0">Skills</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h3>{{ $stats['portfolios_count'] }}</h3>
                <p class="mb-0">Portfolios</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h3>{{ $stats['experiences_count'] }}</h3>
                <p class="mb-0">Experiences</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h3>{{ $stats['educations_count'] }}</h3>
                <p class="mb-0">Educations</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h3>{{ $stats['testimonials_count'] }}</h3>
                <p class="mb-0">Testimonials</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <h3>{{ $stats['social_links_count'] }}</h3>
                <p class="mb-0">Social Links</p>
            </div>
        </div>
    </div>
</div>

<!-- Tab Content -->
<div class="card">
    <div class="card-body">
        
        <!-- Nav Tabs -->
        <ul class="nav nav-tabs" role="tablist" id="adminTabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#skillsTab" role="tab">
                    <i class="fas fa-code"></i> Skills
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#portfoliosTab" role="tab">
                    <i class="fas fa-briefcase"></i> Portfolios
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#experiencesTab" role="tab">
                    <i class="fas fa-building"></i> Experiences
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#educationsTab" role="tab">
                    <i class="fas fa-graduation-cap"></i> Educations
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#testimonialsTab" role="tab">
                    <i class="fas fa-comment"></i> Testimonials
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#socialLinksTab" role="tab">
                    <i class="fas fa-share-alt"></i> Social Links
                </a>
            </li>
        </ul>

        <!-- Tab Panes -->
        <div class="tab-content mt-3">
            
            <!-- Skills Tab -->
            <div class="tab-pane fade show active" id="skillsTab" role="tabpanel">
                @include('admin.sections.skills')
            </div>

            <!-- Portfolios Tab -->
            <div class="tab-pane fade" id="portfoliosTab" role="tabpanel">
                @include('admin.sections.portofolios')
            </div>

            <!-- Experiences Tab -->
            <div class="tab-pane fade" id="experiencesTab" role="tabpanel">
                @include('admin.sections.experiences')
            </div>

            <!-- Educations Tab -->
            <div class="tab-pane fade" id="educationsTab" role="tabpanel">
                @include('admin.sections.educations')
            </div>

            <!-- Testimonials Tab -->
            <div class="tab-pane fade" id="testimonialsTab" role="tabpanel">
                @include('admin.sections.testimonials')
            </div>

            <!-- Social Links Tab -->
            <div class="tab-pane fade" id="socialLinksTab" role="tabpanel">
                @include('admin.sections.social_links')
            </div>

        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.card {
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.nav-tabs .nav-link {
    color: #666;
}
.nav-tabs .nav-link.active {
    font-weight: bold;
}
</style>
@endpush