<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
 <head>
 	<!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    @if(isset($setting))
    <!-- App Title -->
    <title>@yield('title') | {{ $setting->meta_title ?? '' }}</title>

    <meta name="description" content="{!! str_limit(strip_tags($setting->meta_description), 160, ' ...') !!}">
    <meta name="keywords" content="{!! strip_tags($setting->meta_keywords) !!}">

    <!-- App favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/uploads/setting/'.$setting->favicon_path) }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('/uploads/setting/'.$setting->favicon_path) }}" type="image/x-icon">
    @endif


    @if(empty($setting))
    <!-- App Title -->
    <title>@yield('title')</title>
    @endif


    <!-- Social Meta Tags -->
    <link rel="canonical" href="{{ route('home') }}">
    
    @yield('social_meta_tags')


 	<!-- Stylesheets -->
 	<link rel="stylesheet" href="{{ asset('web/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('web/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/dripicons.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/meanmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/responsive.css') }}">


    @php 
    $version = App\Models\Language::version(); 
    @endphp
    @if($version->direction == 1)
    <!-- RTL css -->
    <link rel="stylesheet" href="{{ asset('web/css/rtl.css') }}">
    @endif




    <style>
.second-menu .row {
    display: flex;
    align-items: center; /* Align items vertically */
    justify-content: space-between; /* Space out the logo, menu, and button */
}

.main-menu {
    display: flex;
    justify-content: flex-start; /* Align menu to the left */
}

.main-menu ul {
    display: flex;
    align-items: center; /* Ensure items are vertically aligned */
    margin: 0;
    padding: 0;
    list-style: none;
    gap: 10px; /* Space between menu items */
}

.main-menu ul li {
    margin: 0; /* No additional margin needed */
}

.main-menu ul li a {
    display: inline-block;
    white-space: nowrap; /* Prevent text wrapping */
    font-size: 14px; /* Smaller font size */
    padding: 4px 8px; /* Adjust padding for smaller size */
    text-decoration: none; /* Optional: remove underline */
    color: #000; /* Adjust text color as needed */
}

.second-header-btn .btn {
    padding: 6px 12px; /* Adjust button size */
    font-size: 12px; /* Smaller font size for the button */
    margin-left: 10px; /* Space between menu and button */
}
/* Adjust alignment of the Admission button container */
.col-xl-3.col-lg-3.text-right {
    display: flex;
    justify-content: flex-end; /* Align items to the far right */
    align-items: center; /* Ensure vertical alignment */
}

/* Style the Admission button */
.second-header-btn .btn {
    padding: 10px 20px; /* Adjust padding for the button */
    font-size: 14px; /* Slightly larger font for better visibility */
    background-color: #007bff; /* Button background color */
    color: white; /* Button text color */
    border-radius: 4px; /* Optional: rounded corners */
    text-align: center; /* Center-align text */
}
.main-menu ul {
    display: flex;
    align-items: center;
    gap: 20px; /* Increase spacing between menu items */
    margin: 0;
    padding: 0;
    list-style: none;
}

.second-header-btn .btn {
    padding: 8px 16px; /* Adjust button size */
    font-size: 14px; /* Maintain button font size */
    margin-left: 20px; /* Add spacing between the menu and button */
}

.second-menu .row {
    flex-wrap: nowrap; /* Prevent wrapping of header items */
    align-items: center; /* Ensure vertical alignment */
    justify-content: space-between; /* Distribute space evenly */
}

@media (max-width: 991px) {
    .second-menu .row {
        flex-wrap: wrap; /* Allow wrapping on smaller screens */
    }

    .main-menu, .second-header-btn {
        margin-bottom: 10px; /* Add spacing for better visibility */
    }
}
/* ==============================
   Uniform Header Background (Full Width)
================================= */

.header-top {
    background-color:#225691; /* Set this to your preferred color */
    color: white;
    padding: 10px 0;
    width: 100%; /* Ensure it spans full width */
}

/* Ensure full-width container */
.header-top .container {
    max-width: 100%;
}

/* Make sure the row aligns all items properly */
.header-top .row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: nowrap;
}

/* ==============================
   Social Media Icons (Left)
================================= */
.header-social {
    display: flex;
    align-items: center;
}

.header-social a {
    color: white;
    margin-right: 15px;
    font-size: 16px;
}

.header-social a:hover {
    color: #ffcc00; /* Hover effect */
}

/* ==============================
   Contact Info (Phone & Email on Right)
================================= */
.header-cta ul {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    list-style: none;
    margin: 0;
    padding: 0;
}

.header-cta ul li {
    margin-left: 20px; /* Space between phone and email */
}

.header-cta .call-box {
    display: flex;
    align-items: center;
}

.header-cta .call-box .icon img {
    filter: brightness(0) invert(1); /* Make icons white */
}

.header-cta .call-box .text a {
    color: white;
    font-weight: bold;
}

/* ==============================
   Responsive Fixes (Mobile)
================================= */
@media (max-width: 991px) {
    .header-top .row {
        flex-direction: column;
        text-align: center;
    }

    .header-social {
        justify-content: center;
        margin-bottom: 10px;
    }

    .header-cta ul {
        justify-content: center;
        flex-direction: column;
    }

    .header-cta ul li {
        margin: 5px 0;
    }
}

/* Ensure entire header has the same background */
.header-top.second-header {
    background-color:#225691 !important; /* Change to match the footer */
    color: #ffffff !important;
}

/* Ensure social media section inherits the same background */
.header-top.second-header .header-social {
    background-color: #225691!important; /* Matches the header */
    padding: 5px 0; /* Adjust spacing if needed */
}

/* Ensure icons and links have correct colors */
.header-top.second-header .header-social a {
    color: rgb(245, 247, 242) !important; /* Adjust icon color */
}

.header-top.second-header .header-social a:hover {
    color: #fc7e2a !important; /* Hover effect */
}


</style>
<style>
    .custom-container {
        max-width: 800px; /* Adjust as needed */
        margin: 0 auto;
        padding-left: 15px;
        padding-right: 15px;
    }
    .header-link {
    color: #007bff; /* Change link color as desired */
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s;
}

.header-link:hover {
    color: #0056b3;
    text-decoration:underline
}


/* Ensure the login container is a flex container */
.login {
    display: flex;
    gap: 10px; /* Adjust the gap between items as needed */
    align-items: center;
}

/* Add a separator after each link except the last one */
.login .second-header-link:not(:last-child)::after {
    content: "|";
    margin-left: 10px;
    margin-right: 10px;
    color: #000; /* Customize color as needed */
}

/* Optionally, adjust font size for small-link */
.small-link {
    font-size: 0.85em;
}

</style>

    




 </head>

 <body>

 	<!-- header -->
    <header class="header-area header-three">  
       

        <div class="header-top second-header d-none d-md-block">
            <div class="container custom-container">
                <div class="row align-items-center">
                    <!-- Social media column -->
                    <div class="col-lg-4 col-md-4 d-none d-lg-block">
                        @if(isset($topbarSetting) && $topbarSetting->social_status == 1)
                        <div class="header-social">
                            <span>
                                @if(isset($socialSetting->facebook))
                                <a href="{{ $socialSetting->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                @endif
                                @if(isset($socialSetting->instagram))
                                <a href="{{ $socialSetting->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a>
                                @endif
                                @if(isset($socialSetting->twitter))
                                <a href="{{ $socialSetting->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a>
                                @endif
                                @if(isset($socialSetting->linkedin))
                                <a href="{{ $socialSetting->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                @endif
                                @if(isset($socialSetting->pinterest))
                                <a href="{{ $socialSetting->pinterest }}" target="_blank"><i class="fab fa-pinterest"></i></a>
                                @endif
                                @if(isset($socialSetting->youtube))
                                <a href="{{ $socialSetting->youtube }}" target="_blank"><i class="fab fa-youtube"></i></a>
                                @endif
                            </span>
                        </div>
                        @endif
                    </div>
        
                    <!-- Admission & E-Learning links and contact details -->
                    <div class="col-lg-8 col-md-8 d-none d-lg-block">
                        <div class="header-cta">
                            <ul style="list-style: none; padding: 0; margin: 0;">
                                <li>
                                    @php 
                                        $application = App\Models\ApplicationSetting::status(); 
                                    @endphp
                                    @isset($application)
                                    <div class="login">
                                        <div class="second-header-link">
                                            <a href="{{ route('application.index') }}" target="_blank" class="header-link">
                                                {{ __('navbar_admission') }}
                                            </a>
                                        </div>
                                        <div class="second-header-link">
                                            <a href="" target="_blank" class="header-link small-link">
                                                {{ __(' E-learning Portal') }}
                                            </a>
                                        </div>
                                    </div>
                                    @endisset
                                </li>
                                @isset($topbarSetting->phone)
                                <li>
                                    <div class="call-box">
                                        <div class="icon">
                                            <img src="{{ asset('web/img/icon/phone-call.png') }}" alt="img">
                                        </div>
                                        <div class="text">
                                            <strong>
                                                <a href="tel:{{ str_replace(' ', '', $topbarSetting->phone ?? '') }}">
                                                    {{ $topbarSetting->phone ?? '' }}
                                                </a>
                                            </strong>
                                        </div>
                                    </div>
                                </li>
                                @endisset
                                @isset($topbarSetting->email)
                                <li>
                                    <div class="call-box">
                                        <div class="icon">
                                            <img src="{{ asset('web/img/icon/mailing.png') }}" alt="img">
                                        </div>
                                        <div class="text">
                                            <strong>
                                                <a href="mailto:{{ $topbarSetting->email ?? '' }}">
                                                    {{ $topbarSetting->email ?? '' }}
                                                </a>
                                            </strong>
                                        </div>
                                    </div>
                                </li>
                                @endisset
                            </ul>
                        </div>
                    </div>
                    


                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </div>
        
        

        <div id="header-sticky" class="menu-area">
            <div class="container">
                <div class="second-menu">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-3">
                            @if(isset($setting))
                            <div class="logo">
                                <a href="{{ route('home') }}"><img src="{{ asset('/uploads/setting/'.$setting->logo_path) }}" alt="logo"></a>
                            </div>
                            @endif
                        </div>

                        <div class="col-xl-8 col-lg-8">
                            <div class="main-menu text-right text-xl-right">
                                <nav id="mobile-menu">
                                    <ul>
                                        <li class="{{ Request::path() == '/' ? 'current' : '' }}"><a href="{{ route('home') }}">{{ __('navbar_home') }}</a></li>
                                        <li class="{{ Request::is('course*') ? 'current' : '' }}"><a href="{{ route('course') }}">{{ __('navbar_course') }}</a></li>
                                        <li class="{{ Request::is('event*') ? 'current' : '' }}"><a href="{{ route('event') }}">{{ __('navbar_event') }}</a></li>
                                        <li class="{{ Request::is('faq*') ? 'current' : '' }}"><a href="{{ route('faq') }}">{{ __('navbar_faqs') }}</a></li>
                                        <li class="{{ Request::is('gallery*') ? 'current' : '' }}"><a href="{{ route('gallery') }}">{{ __('navbar_gallery') }}</a></li>
                                        <li class="{{ Request::is('news*') ? 'current' : '' }}"><a href="{{ route('news') }}">{{ __('navbar_news') }}</a></li>
                                 
                                        

                                        <li class="{{ Request::is('materials*') ? 'current' : '' }}">
                                            <a href="{{ route('materialhome') }}">{{ __('Digital Library') }}</a>
                                        </li>
                                        
                                        <li class="{{ Request::is('about*') ? 'current' : '' }}">
                                            <a href="{{route('aboutus')}}">{{ __('About Us') }}</a>
                                        </li>
                                        
                                        {{-- <li class="{{ Request::is('elearning*') ? 'current' : '' }}">
                                            <a href="#">{{ __('E-learning Portal') }}</a>
                                        </li> --}}
                                    </ul>
                                </nav>
                            </div>
                        </div>

                      
                        
                        <div class="col-12">
                            <div class="mobile-menu"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header-end -->

 	
    <!-- Content Start -->
    @yield('content')
    <!-- Content End -->


 	<!-- footer -->
    <footer class="footer-bg footer-p pt-90" style="background-color: #125875;">
        <div class="footer-top pb-70">
            <div class="container">
                <div class="row justify-content-between">
                    
                    <div class="col-xl-4 col-lg-4 col-sm-12">
                        <div class="footer-widget mb-30">
                            <div class="f-widget-title">
                                <h2>{{ __('footer_socials') }}</h2>
                            </div>
                            <div class="footer-social">                                    
                                @if(isset($socialSetting->facebook))
                                <a href="{{ $socialSetting->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                @endif
                                @if(isset($socialSetting->instagram))
                                <a href="{{ $socialSetting->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a>
                                @endif
                                @if(isset($socialSetting->twitter))
                                <a href="{{ $socialSetting->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a>
                                @endif
                                @if(isset($socialSetting->linkedin))
                                <a href="{{ $socialSetting->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                @endif
                                @if(isset($socialSetting->pinterest))
                                <a href="{{ $socialSetting->pinterest }}" target="_blank"><i class="fab fa-pinterest"></i></a>
                                @endif
                                @if(isset($socialSetting->youtube))
                                <a href="{{ $socialSetting->youtube }}" target="_blank"><i class="fab fa-youtube"></i></a>
                                @endif
                            </div>    
                        </div>
                    </div>
                    

                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <div class="footer-widget mb-30">
                            <div class="f-widget-title">
                                <h2>{{ __('footer_links') }}</h2>
                            </div>
                            <div class="footer-link">
                                <ul>
                                    @if (Route::has('student.login'))
                                    <li><a href="{{ route('student.login') }}" target="_blank">{{ __('field_student') }} {{ __('field_login') }}</a></li>
                                    @endif
                                    @if (Route::has('login'))
                                    <li><a href="{{ route('login') }}" target="_blank">{{ __('field_staff') }} {{ __('field_login') }}</a></li>
                                    @endif

                                    @php 
                                    $application = App\Models\ApplicationSetting::status(); 
                                    @endphp
                                    @isset($application)
                                    <li><a href="{{ route('application.index') }}" target="_blank">{{ __('navbar_admission') }}</a></li>
                                    @endisset

                                    @foreach($footer_pages as $footer_page)
                                    <li><a href="{{ route('page.single', ['slug' => $footer_page->slug]) }}">{{ $footer_page->title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                  
                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <div class="footer-widget mb-30">
                            <div class="f-widget-title">
                                <h2>{{ __('footer_contact') }}</h2>
                            </div>
                            <div class="f-contact">
                                <ul>
                                    @isset($topbarSetting->phone)
                                    <li>
                                        <i class="icon fal fa-phone"></i>
                                        <span><a href="tel:{{ str_replace(' ', '', $topbarSetting->phone ?? '') }}">{{ $topbarSetting->phone ?? '' }}</a></span>
                                    </li>
                                    @endisset
                                    @isset($topbarSetting->email)
                                    <li>
                                        <i class="icon fal fa-envelope"></i>
                                        <span><a href="mailto:{{ $topbarSetting->email ?? '' }}">{{ $topbarSetting->email ?? '' }}</a></span>
                                    </li>
                                    @endisset
                                    @isset($topbarSetting->address)
                                    <li>
                                        <i class="icon fal fa-map-marker-check"></i>
                                        <span>{{ $topbarSetting->address ?? '' }}</span>
                                    </li>
                                    @endisset
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>


        <div class="copyright-wrap">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="dropdown">
                          <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $version->name }}
                          </a>

                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @foreach($user_languages as $user_language)
                            <li><a class="dropdown-item" href="{{ route('version', $user_language->code) }}">{{ $user_language->name }}</a></li>
                            @endforeach
                          </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12 text-center">          
                        
                    </div>
                    <div class="col-lg-4 col-md-4 col-12 text-center text-md-right">
                        @isset($setting->copyright_text)
                        &copy; {!! strip_tags($setting->copyright_text, '<a><b><i><u><strong>') !!}
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer-end -->

<style>

.footer-social {
    display: flex;
    justify-content: center; /* Center horizontally */
    align-items: center; /* Center vertically */
    gap: 10px; /* Space between icons */
    margin-top: 10px;
}

.footer-social a {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 40px; /* Set circle size */
    height: 40px; /* Set circle size */
    border-radius: 50%; /* Make it a circle */
    background-color: #fc7e2a  /* Default background color */
    color: white; /* Icon color */
    font-size: 18px; /* Icon size */
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.footer-social a:hover {
    background-color: #007bff; /* Change color on hover */
}

</style>


    
 	<!-- Script JS -->
 	<script src="{{ asset('web/js/vendor/modernizr-3.5.0.min.js') }}"></script>
    <script src="{{ asset('web/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('web/js/popper.min.js') }}"></script>
    <script src="{{ asset('web/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('web/js/slick.min.js') }}"></script>
    <script src="{{ asset('web/js/paroller.js') }}"></script>
    <script src="{{ asset('web/js/wow.min.js') }}"></script>
    <script src="{{ asset('web/js/js_isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('web/js/imagesloaded.min.js') }}"></script>
    <script src="{{ asset('web/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('web/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('web/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('web/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('web/js/jquery.meanmenu.min.js') }}"></script>
    <script src="{{ asset('web/js/parallax-scroll.js') }}"></script>
    <script src="{{ asset('web/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('web/js/element-in-view.js') }}"></script>
    <script src="{{ asset('web/js/main.js') }}"></script>

 </body>
</html>