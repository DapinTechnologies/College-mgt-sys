<?php $__env->startSection('title', __('navbar_home')); ?>

<?php $__env->startSection('social_meta_tags'); ?>
    <?php if(isset($setting)): ?>
    <meta property="og:type" content="website">
    <meta property='og:site_name' content="<?php echo e($setting->title); ?>"/>
    <meta property='og:title' content="<?php echo e($setting->title); ?>"/>
    <meta property='og:description' content="<?php echo str_limit(strip_tags($setting->meta_description), 160, ' ...'); ?>"/>
    <meta property='og:url' content="<?php echo e(route('home')); ?>"/>
    <meta property='og:image' content="<?php echo e(asset('/uploads/setting/'.$setting->logo_path)); ?>"/>


    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="<?php echo '@'.str_replace(' ', '', $setting->title); ?>" />
    <meta name="twitter:creator" content="@HiTechParks" />
    <meta name="twitter:url" content="<?php echo e(route('home')); ?>" />
    <meta name="twitter:title" content="<?php echo e($setting->title); ?>" />
    <meta name="twitter:description" content="<?php echo str_limit(strip_tags($setting->meta_description), 160, ' ...'); ?>" />
    <meta name="twitter:image" content="<?php echo e(asset('/uploads/setting/'.$setting->logo_path)); ?>" />
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<style>

.director-image {
    width: 350px;
    height: 350px;
    object-fit: cover; /* Ensures the image fills the box without distortion */
    border-radius: 10px; /* Optional: Rounded corners */
    display: block; /* Ensure it behaves properly in flex/grid layouts */
}

        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 28px;
        }

        /* Grid Layout for Courses */
        .courses-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            padding: 20px;
        }

        /* Course Card */
        .course-card {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            transition: transform 0.3s ease-in-out;
            border-left: 5px solid #dacc5f;
        }

        .course-card:hover {
            transform: translateY(-5px);
            background: #f1f1f1;
        }

        /* Course Content */
        .course-title {
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 8px;
        }

        .course-info {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
        }

        .fee {
            font-size: 16px;
            font-weight: bold;
            color: #28a745;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .courses-container {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .courses-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 500px) {
            .courses-container {
                grid-template-columns: repeat(1, 1fr);
            }
        }

        .courses-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.course-card {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
}

.course-card:hover {
    transform: translateY(-5px);
}

.course-title {
    font-size: 18px;
    font-weight: bold;
    color: #007bff;
    margin-bottom: 10px;
}

.course-info {
    font-size: 14px;
    color: #333;
}

.fee {
    font-size: 16px;
    font-weight: bold;
    color: #28a745;
    margin-top: 10px;
}




  /* General Styles */
  body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        /* Grid Layout */
        .news-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 15px;
            padding: 20px;
        }

        /* News Card */
        .news-card {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            transition: transform 0.3s ease-in-out;
            border-left: 5px solid #007bff;
        }

        .news-card:hover {
            transform: translateY(-5px);
            background: #f1f1f1;
        }

        /* News Content */
        .news-title {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 8px;
        }

        .news-description {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
        }

        .news-date {
            font-size: 12px;
            color: #777;
            text-align: right;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .news-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .news-container {
                grid-template-columns: repeat(1, 1fr);
            }
        }

    </style>

<?php $__env->startSection('content'); ?>

    <!-- main-area -->
    <main>
        <!-- slider-area -->
        <section id="home" class="slider-area fix p-relative">
           
            <div class="slider-active" style="background: #141b22;">

                <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="single-slider slider-bg" style="background-image: url(<?php echo e(asset('uploads/slider/'.$slider->attach)); ?>); background-size: cover;">
                    <div class="overlay"></div>
                    <div class="container">
                       <div class="row">
                            <div class="col-lg-7 col-md-7">
                                <div class="slider-content s-slider-content mt-130">
                                    <h2 data-animation="fadeInUp" data-delay=".4s"><?php echo e($slider->title); ?></h2>
                                    <p data-animation="fadeInUp" data-delay=".6s"><?php echo strip_tags($slider->sub_title, '<b><u><i><br>'); ?></p>
                                    
                                    <?php if(isset($slider->button_link)): ?>
                                    <div class="slider-btn mt-30">     
                                        <a href="<?php echo e($slider->button_link); ?>" target="_blank" class="btn ss-btn mr-15" data-animation="fadeInLeft" data-delay=".4s"><?php echo e($slider->button_text); ?> <i class="fal fa-long-arrow-right"></i></a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 p-relative">
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </section>
        <!-- slider-area-end -->


        <?php if(count($features) > 0): ?>
        <!-- service-area -->
        <section class="service-details-two p-relative">
            <div class="container">
                <div class="row">
                  
                    <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="services-box07 <?php if($key == 1): ?> active <?php endif; ?>">
                            <div class="sr-contner">
                                <div class="icon">
                                    <img src="<?php echo e(asset('web/img/icon/sve-icon4.png')); ?>" alt="icon">
                                </div>
                                <div class="text">
                                    <h5><?php echo e($feature->title); ?></h5>
                                    <p><?php echo $feature->description; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 
                </div>
            </div>
        </section>
        <!-- service-area-end -->
        <?php endif; ?>
        


        
      


        <?php if(isset($about)): ?>
        <!-- about-area -->
        <section class="about-area about-p pt-120 pb-120 p-relative fix" style="background: #eff7ff;">
            <div class="animations-02"><img src="<?php echo e(asset('web/img/bg/an-img-02.png')); ?>" alt="About"></div>
            <div class="container">
                <div class="row justify-content-center align-items-center">

                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="s-about-img p-relative wow fadeInLeft animated" data-animation="fadeInLeft" data-delay=".4s">
                            <img src="<?php echo e(asset('uploads/about-us/'.$about->attach)); ?>" alt="img">
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="about-content s-about-content pl-15 wow fadeInRight animated" data-animation="fadeInRight" data-delay=".4s">
                            <div class="about-title second-title pb-25">  
                                <h5><i class="fal fa-graduation-cap"></i> <?php echo e($about->label); ?></h5>
                                <h2><?php echo e($about->title); ?></h2>
                            </div>

                            <?php echo strip_tags($about->description, '<a><b><i><u><strong>'); ?>


                            <div class="about-content2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="green2">
                                            <?php if(isset($about->mission_title)): ?>
                                            <li>
                                                <div class="abcontent">
                                                    <div class="text">
                                                        <h3><?php echo e($about->mission_title); ?></h3>
                                                        <p><?php echo strip_tags($about->mission_desc, '<a><b><i><u><strong>'); ?></p>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php endif; ?>
                                            <?php if(isset($about->vision_title)): ?>
                                            <li>
                                                <div class="abcontent">
                                                    <div class="text">
                                                        <h3><?php echo e($about->vision_title); ?></h3>
                                                        <p><?php echo strip_tags($about->vision_desc, '<a><b><i><u><strong>'); ?></p>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 
                </div>
            </div>
        </section>
        <!-- about-area-end -->
        <?php endif; ?>





    <!-- Director's Message Section -->
<!-- Director's Message Section -->
<section class="about-area about-p pt-120 pb-120 p-relative fix" style="background: #eff7ff;">
    <div class="animations-02">
        <img src="<?php echo e(asset('web/img/bg/an-img-02.png')); ?>" alt="Background">
    </div>
    <div class="container">
        <div class="row justify-content-center align-items-center">

            <?php $director = \App\Models\Director::first(); ?>

            <?php if($director): ?>
                <!-- Director's Image -->
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="s-about-img p-relative wow fadeInLeft animated" data-animation="fadeInLeft" data-delay=".4s">
                        <img src="<?php echo e(asset('storage/'.$director->image)); ?>" alt="Director Image" class="director-image">

                    </div>
                </div>

                <!-- Director's Message -->
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="about-content s-about-content pl-15 wow fadeInRight animated">
                        <h5><i class="fal fa-user-tie"></i> Message from the Director</h5>
                        <h2><?php echo e($director->title); ?></h2>
                        <p><?php echo e($director->message); ?></p>
                        <h3><?php echo e($director->name); ?></h3>
                        <p><i>Director</i></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>





        <?php if(isset($callToAction)): ?>
        <!-- cta-area -->
        <section class="cta-area cta-bg pt-50 pb-50" style="background-color: #125875;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="section-title cta-title wow fadeInLeft animated" data-animation="fadeInDown animated" data-delay=".2s">
                            <h2><?php echo e($callToAction->title); ?></h2>
                            <p><?php echo e($callToAction->sub_title); ?></p>
                        </div>
                                         
                    </div>
                    <div class="col-lg-4 text-right"> 
                        <div class="cta-btn s-cta-btn wow fadeInRight animated mt-30" data-animation="fadeInDown animated" data-delay=".2s">
                            <?php if(isset($callToAction->button_link)): ?>
                            <a href="<?php echo e($callToAction->button_link); ?>" target="_blank" class="btn ss-btn smoth-scroll"><?php echo e($callToAction->button_text); ?> <i class="fal fa-long-arrow-right"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                
                </div>
            </div>
        </section>
        <!-- cta-area-end -->
        <?php endif; ?>





<!-- Course Area -->
<div class="container">
    <h2 class="text-center">Available Courses</h2>

    <?php
        use App\Models\Course;
        $courses = Course::where('status', 1)->orderBy('faculty')->get();
    ?>

    <div class="courses-container">
        <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="course-card">
                <div class="course-title"><?php echo e($course->title); ?></div>
                <div class="course-info">
                    <strong>Faculty:</strong> <?php echo e($course->faculty); ?><br>
                    <strong>Duration:</strong> <?php echo e($course->duration); ?>

                </div>
                <div class="fee">Fee: KSH <?php echo e(number_format($course->fee, 2)); ?></div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-center text-muted">No courses available at the moment.</p>
        <?php endif; ?>
    </div>
</div>



    



<!-- News Section -->
<div class="container">
    <h2 class="text-center">Latest News</h2>

    <?php
        use App\Models\News;
        $newsItems = News::where('status', 1)->orderBy('date', 'desc')->get();
    ?>

    <div class="news-container">
        <?php $__empty_1 = true; $__currentLoopData = $newsItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="news-card">
                <div class="news-title"><?php echo e($news->title); ?></div>
                <div class="news-description">
                    <?php echo e(Str::limit(strip_tags($news->description), 120, '...')); ?>

                </div>
                <div class="news-date">Published: <?php echo e(\Carbon\Carbon::parse($news->date)->format('M d, Y')); ?></div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-center text-muted">No news articles available at the moment.</p>
        <?php endif; ?>
    </div>
</div>






























        <?php if(count($testimonials) > 0): ?>
        <!-- testimonial-area -->
        <section class="testimonial-area pt-120 pb-115 p-relative fix">
            <div class="container">
                <div class="row">
                    
                    <div class="col-lg-12">
                        <div class="testimonial-active wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">

                            <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="single-testimonial text-center">
                                <div class="qt-img">
                                    <img src="<?php echo e(asset('web/img/testimonial/qt-icon.png')); ?>" alt="img">
                                </div>
                                <p><?php echo $testimonial->description; ?></p>
                                <div class="testi-author">
                                    <img src="<?php echo e(asset('uploads/testimonial/'.$testimonial->attach)); ?>" alt="img">
                                </div>
                                <div class="ta-info">
                                    <h6><?php echo e($testimonial->name); ?></h6>
                                    <span><?php echo e($testimonial->designation ?? ''); ?></span>
                                </div>                                    
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- testimonial-area-end -->
        <?php endif; ?>
     
    </main>
    <!-- main-area-end -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\stk -trial\Dapin\Dapin\resources\views/web/index.blade.php ENDPATH**/ ?>