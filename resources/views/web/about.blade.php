@extends('web.layouts.master')
@section('title', __('About Us'))
@section('content')

<!-- main-area -->
<main>
    <!-- breadcrumb-area -->
    <section class="breadcrumb-area d-flex p-relative align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="breadcrumb-wrap text-center">
                        <div class="breadcrumb-title">
                            <h2>{{ __('About Us') }}</h2>
                        </div>
                        <div class="breadcrumb-wrap2">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('home') }}">{{ __('navbar_home') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __('About Us') }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <!-- About Us Content -->
    <section class="about-us-content pt-80 pb-80">
        <div class="container">
            <div class="row">
                @if($about)
                <div class="col-12">
                    <h3 class="section-title">{{ $about->title }}</h3>
                    <p class="lead">{{ $about->short_desc }}</p>
                    <div class="description">
                        {{-- Render HTML from the description if needed --}}
                        {!! $about->description !!}
                    </div>
                    
                    {{-- Features Section --}}
                    @if($about->features)
                        <div class="features">
                            <h4 class="sub-section-title">Features</h4>
                            <div>{!! $about->features !!}</div>
                        </div>
                    @endif

                    {{-- Mission Section --}}
                    @if($about->mission_title)
                        <div class="mission">
                            <h4 class="sub-section-title">{{ $about->mission_title }}</h4>
                            <p>{!! $about->mission_desc !!}</p>
                        </div>
                    @endif

                    {{-- Vision Section --}}
                    @if($about->vision_title)
                        <div class="vision">
                            <h4 class="sub-section-title">{{ $about->vision_title }}</h4>
                            <p>{!! $about->vision_desc !!}</p>
                        </div>
                    @endif
                </div>
                @else
                <div class="col-12 text-center">
                    <p>{{ __('No information available.') }}</p>
                </div>
                @endif
            </div>
        </div>
    </section>
    <!-- About Us Content End -->
</main>
<!-- End main-area -->

@endsection