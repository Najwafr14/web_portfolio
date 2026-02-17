@extends('layouts.app')

@section('title', 'Portfolio - Najwa Fauziah Rahmania')

@section('content')

    <!-- Hero Section -->
    @include('frontend.sections.hero')

    <!-- About Section -->
    @include('frontend.sections.about')

    <!-- Skills Section -->
    @include('frontend.sections.skills')

    <!-- Resume Section -->
    @include('frontend.sections.resume')

    <!-- Portfolio Section -->
    @include('frontend.sections.portofolio')

    <!-- Testimonials Section -->
    @include('frontend.sections.testimonials')

    <!-- Faq Section -->
    @include('frontend.sections.faq')

    <!-- Contact Section -->
    @include('frontend.sections.contact')

@endsection