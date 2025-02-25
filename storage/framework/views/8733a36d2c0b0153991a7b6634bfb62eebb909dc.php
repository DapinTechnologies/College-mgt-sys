
<?php $__env->startSection('title', __('About Us')); ?>
<?php $__env->startSection('content'); ?>

<!-- main-area -->
<main>
    <!-- breadcrumb-area -->
    <section class="breadcrumb-area d-flex p-relative align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="breadcrumb-wrap text-center">
                        <div class="breadcrumb-title">
                            <h2><?php echo e(__('About Us')); ?></h2>
                        </div>
                        <div class="breadcrumb-wrap2">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo e(route('home')); ?>"><?php echo e(__('navbar_home')); ?></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('About Us')); ?></li>
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
                <?php if($about): ?>
                <div class="col-12">
                    <h3 class="section-title"><?php echo e($about->title); ?></h3>
                    <p class="lead"><?php echo e($about->short_desc); ?></p>
                    <div class="description">
                        
                        <?php echo $about->description; ?>

                    </div>
                    
                    
                    <?php if($about->features): ?>
                        <div class="features">
                            <h4 class="sub-section-title">Features</h4>
                            <div><?php echo $about->features; ?></div>
                        </div>
                    <?php endif; ?>

                    
                    <?php if($about->mission_title): ?>
                        <div class="mission">
                            <h4 class="sub-section-title"><?php echo e($about->mission_title); ?></h4>
                            <p><?php echo $about->mission_desc; ?></p>
                        </div>
                    <?php endif; ?>

                    
                    <?php if($about->vision_title): ?>
                        <div class="vision">
                            <h4 class="sub-section-title"><?php echo e($about->vision_title); ?></h4>
                            <p><?php echo $about->vision_desc; ?></p>
                        </div>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <div class="col-12 text-center">
                    <p><?php echo e(__('No information available.')); ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- About Us Content End -->
</main>
<!-- End main-area -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\latest Dapin\backup\Dapin\stk -trial\Dapin\Dapin\resources\views/web/about.blade.php ENDPATH**/ ?>