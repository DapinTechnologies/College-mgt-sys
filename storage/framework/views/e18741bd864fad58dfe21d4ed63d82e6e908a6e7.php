<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('page_css'); ?>
<style>
    #pieChart{
        max-width: 100% !important;
        max-height: 500px !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ bitcoin-wallet section ] start-->
            <div class="col-sm-6 col-md-6 col-xl-3">
                <div class="card bg-c-blue bitcoin-wallet">
                    <div class="card-block">
                        <h5 class="text-white mb-2"><?php echo e(__('status_pending')); ?> <?php echo e(trans_choice('module_application', 2)); ?></h5>
                        <h2 class="text-white mb-2 f-w-300"><?php echo e($pending_applications->count()); ?></h2>
                        <i class="fa-solid fa-scroll f-70 text-white"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-xl-3">
                <div class="card bg-c-blue bitcoin-wallet">
                    <div class="card-block">
                        <h5 class="text-white mb-2"> <?php echo e(__('status_active')); ?> <?php echo e(trans_choice('module_student', 2)); ?></h5>
                        <h2 class="text-white mb-2 f-w-300"><?php echo e($active_students->count()); ?></h2>
                        <i class="fas fa-user-graduate f-70 text-white"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-xl-3">
                <div class="card bg-c-blue bitcoin-wallet">
                    <div class="card-block">
                        <h5 class="text-white mb-2"><?php echo e(__('status_active')); ?> <?php echo e(trans_choice('module_staff', 2)); ?></h5>
                        <h2 class="text-white mb-2 f-w-300"><?php echo e($active_staffs->count()); ?></h2>
                        <i class="fas fa-user-tag f-70 text-white"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-xl-3">
                <div class="card bg-c-blue bitcoin-wallet">
                    <div class="card-block">
                        <h5 class="text-white mb-2"><?php echo e(__('field_total')); ?> <?php echo e(trans_choice('module_book', 2)); ?></h5>
                        <h2 class="text-white mb-2 f-w-300"><?php echo e($library_books->count()); ?></h2>
                        <i class="fas fa-book f-70 text-white"></i>
                    </div>
                </div>
            </div>
            <!-- [ bitcoin-wallet section ] end-->
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-xl-3">
                <div class="card theme-bg bitcoin-wallet">
                    <div class="card-block">
                        <h5 class="text-white mb-2"><?php echo e(__('field_daily')); ?> <?php echo e(trans_choice('module_visitor_log', 2)); ?></h5>
                        <h2 class="text-white mb-2 f-w-300"><?php echo e($daily_visitors->count()); ?></h2>
                        <i class="fas fa-eye f-70 text-white"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-xl-3">
                <div class="card theme-bg bitcoin-wallet">
                    <div class="card-block">
                        <h5 class="text-white mb-2"><?php echo e(__('field_daily')); ?> <?php echo e(trans_choice('module_phone_log', 2)); ?></h5>
                        <h2 class="text-white mb-2 f-w-300"><?php echo e($daily_phone_logs->count()); ?></h2>
                        <i class="fas fa-phone-volume f-70 text-white"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-xl-3">
                <div class="card theme-bg bitcoin-wallet">
                    <div class="card-block">
                        <h5 class="text-white mb-2"><?php echo e(__('field_daily')); ?> <?php echo e(trans_choice('module_enquiry', 2)); ?></h5>
                        <h2 class="text-white mb-2 f-w-300"><?php echo e($daily_enqueries->count()); ?></h2>
                        <i class="fas fa-question f-70 text-white"></i>
                    </div>
                </div>
            </div>


            
           <div class="col-sm-6 col-md-6 col-xl-3">
    <div class="card theme-bg bitcoin-wallet">
        <div class="card-block">
            <h5 class="text-white mb-2"><?php echo e(__('SMS Credit')); ?></h5>
            <h2 class="text-white mb-2 f-w-300">
                <span id="sms-balance" class="badge badge-secondary">Loading...</span>
            </h2>
            <i class="fas fa-exchange-alt f-70 text-white"></i>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $.ajax({
            url: "<?php echo e(route('fetch.sms.balance')); ?>",
            type: "GET",
            success: function (data) {
                let balance = data.balance;
                let balanceElement = $("#sms-balance");

                if (balance === 'Balance not found' || balance === 'Failed to authenticate API key.' || 
                    balance === 'No SMS configuration found' || balance === 'No Credit' || balance === '0') {
                    balanceElement.text(balance).removeClass("badge-success").addClass("badge-danger");
                } else {
                    balanceElement.text(balance).removeClass("badge-danger").addClass("badge-success");
                }
            },
            error: function () {
                $("#sms-balance").text("Failed to load balance").removeClass("badge-success").addClass("badge-danger");
            }
        });
    });
</script>

            
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['fees-student-report', 'payroll-report'])): ?>
        <div class="row">
            <div class="col-12 col-md-12 col-xl-12">
                <div class="card">
                    <div class="card-block">
                        <canvas id="lineChart" height="100px"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="row">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['fees-student-report'])): ?>
            <div class="col-12 col-md-6 col-xl-6 mt-5">
                <div class="card">
                    <div class="card-block">
                        <canvas id="pieChart" height="220px"></canvas>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['payroll-report'])): ?>
            <div class="col-12 col-md-6 col-xl-6 mt-5">
                <div class="card">
                    <div class="card-block">
                        <canvas id="line-chartcanvas" height="250px"></canvas>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="clear-fix mt-5"></div>
        <div class="row">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['student-view'])): ?>
            <div class="col-xl-4 col-md-6">
                <div class="card">
                    <div class="card-block">
                        <canvas id="student"></canvas>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['fees-student-report'])): ?>
            <div class="col-xl-4 col-md-6">
                <div class="card">
                    <div class="card-block">
                        <canvas id="feesType"></canvas>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['item-view'])): ?>
            <div class="col-xl-4 col-md-6">
                <div class="card">
                    <div class="card-block">
                        <canvas id="inventory"></canvas>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['visitor-view', 'phone-log-view', 'enquiry-view', 'complaine-view', 'postal-exchange-view', 'meeting-view'])): ?>
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-block">
                        <canvas id="front-desk-line"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>
<!-- chart Js -->
<script src="<?php echo e(asset('dashboard/plugins/chart-chartjs/js/chart.min.js')); ?>"></script>


<script type="text/javascript">
      "use strict";
      var labels =  <?php echo $months ?>;
      var fees =  <?php echo $fees ?>;
      var salaries =  <?php echo $salaries ?>;
      var incomes =  <?php echo $incomes ?>;
      var expenses =  <?php echo $expenses ?>;

      const data = {

        labels: labels,

        datasets: [
            {

            label: '<?php echo e(trans_choice('module_student_fees', 2)); ?>',

            backgroundColor: '#04a9f5',

            borderColor: '#04a9f5',

            data: fees,

            },
            {
            label: '<?php echo e(__('field_salary')); ?> <?php echo e(__('status_paid')); ?>',

            backgroundColor: '#f4c22b',

            borderColor: '#f4c22b',

            data: salaries,
            },
            {
            label: '<?php echo e(trans_choice('module_income', 2)); ?>',

            backgroundColor: '#1de9b6',

            borderColor: '#1de9b6',

            data: incomes,
            },
            {
            label: '<?php echo e(trans_choice('module_expense', 2)); ?>',

            backgroundColor: '#f44236',

            borderColor: '#f44236',

            data: expenses,
            }
            
        ]

      };
      const config = {

        type: 'line',

        data: data,

        options: {}

      };
      const lineChart = new Chart(

        document.getElementById('lineChart'),

        config

      );
</script>


<script type="text/javascript">
    "use strict";
    var student_fee =  <?php echo $student_fee ?>;
    var discounts =  <?php echo $discounts ?>;
    var fines =  <?php echo $fines ?>;
    var fee_paid =  <?php echo $fee_paid ?>;

    const ctx = document.getElementById('pieChart').getContext('2d');
    const pieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['<?php echo e(__('field_student')); ?> <?php echo e(__('field_fee')); ?>', '<?php echo e(__('field_discount')); ?>', '<?php echo e(__('field_fine_amount')); ?>', '<?php echo e(__('field_paid_amount')); ?>'],
            datasets: [{
                label: '# of Fees',
                data: [
                student_fee , discounts, fines, fee_paid],
                backgroundColor: [
                    'rgba(29, 233, 182, 0.2)',
                    'rgba(244, 66, 54, 0.2)',
                    'rgba(244, 194, 43, 0.2)',
                    'rgba(4, 169, 245, 0.2)'
                ],
                borderColor: [
                    'rgba(29, 233, 182, 1)',
                    'rgba(244, 66, 54, 1)',
                    'rgba(244, 194, 43, 1)',
                    'rgba(4, 169, 245, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<script type="text/javascript">
"use strict";
$(function(){
    var labels =  <?php echo $months ?>;
    var net_salary = <?php echo $net_salary ?>;
    var total_allowance = <?php echo $total_allowance ?>;
    var total_deduction = <?php echo $total_deduction ?>;
    var total_tax = <?php echo $total_tax ?>;
    //get the line chart canvas
    var ctx = $("#line-chartcanvas");

    //line chart data
    var data = {
    labels: labels,
    datasets: [
        {
        label: "<?php echo e(__('field_salary')); ?> <?php echo e(__('status_paid')); ?>",
        data: net_salary,
        backgroundColor: "#04a9f5",
        borderColor: "#038fcf",
        fill: false,
        lineTension: 0,
        radius: 5
        },
        {
        label: "<?php echo e(__('field_total_allowance')); ?>",
        data: total_allowance,
        backgroundColor: "#1de9b6",
        borderColor: "#14cc9e",
        fill: false,
        lineTension: 0,
        radius: 5
        },
        {
        label: "<?php echo e(__('field_total_deduction')); ?>",
        data: total_deduction,
        backgroundColor: "#f44236",
        borderColor: "#f22012",
        fill: false,
        lineTension: 0,
        radius: 5
        },
        {
        label: "<?php echo e(__('field_tax')); ?>",
        data: total_tax,
        backgroundColor: "#f4c22b",
        borderColor: "#ecb50c",
        fill: false,
        lineTension: 0,
        radius: 5
        }
    ]
    };

    //options
    var options = {
    responsive: true,
    title: {
        display: false,
        position: "top",
        text: "Line Graph",
        fontSize: 16,
        fontColor: "#888"
    },
    legend: {
        display: true,
        position: "top",
        labels: {
        fontColor: "#888",
        fontSize: 14
        }
    }
    };

    //create Chart class object
    var chart = new Chart(ctx, {
    type: "line",
    data: data,
    options: options
    });
});
</script>

<script type="text/javascript">
    'use strict';
    $(document).ready(function() {

        // [ pie-chart ] start
        var bar = document.getElementById("student").getContext('2d');
        var student = {
            labels: [
                <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                '<?php echo e($program->shortcode); ?>', 
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ],
            datasets: [{
                data: [
                <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo e($program->students->where('status', '1')->count()); ?>, 
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                ],
                backgroundColor: [
                    "#1de9b6",
                    "#899FD4",
                    "#04a9f5",
                    "#2f4858",
                    "#386c5f",
                    "#a2b455",
                    "#daeb89",
                    "#7a91fb",
                    "#b0ec8f",
                    "#fa7239"
                ]
            }]
        };
        var myPieChart = new Chart(bar, {
            type: 'doughnut',
            data: student,
            responsive: true,
            options: {
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: '<?php echo e(trans_choice('module_student', 2)); ?>'
                    }
                }
            }
        });
        // [ pie-chart ] end

        // [ pie-chart ] start
        var bar = document.getElementById("feesType").getContext('2d');
        var feesType = {
            labels: [
                <?php $__currentLoopData = $fees_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fees_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                '<?php echo e($fees_type->title); ?>', 
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ],
            datasets: [{
                data: [
                <?php $__currentLoopData = $fees_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fees_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo e($fees_type->fees->where('status', '1')->sum('paid_amount')); ?>, 
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                ],
                backgroundColor: [
                    "#1de9b6",
                    "#899FD4",
                    "#04a9f5",
                    "#2f4858",
                    "#386c5f",
                    "#a2b455",
                    "#daeb89",
                    "#7a91fb",
                    "#b0ec8f",
                    "#fa7239"
                ]
            }]
        };
        var myPieChart = new Chart(bar, {
            type: 'doughnut',
            data: feesType,
            responsive: true,
            options: {
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: '<?php echo e(trans_choice('module_fees_collection', 2)); ?>'
                    }
                }
            }
        });
        // [ pie-chart ] end

        // [ pie-chart ] start
        var bar = document.getElementById("inventory").getContext('2d');
        var inventory = {
            labels: [
                <?php $__currentLoopData = $item_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                '<?php echo e($item_type->title); ?>', 
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ],
            datasets: [{
                data: [
                <?php $__currentLoopData = $item_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo e($item_type->items->where('status', '1')->count()); ?>, 
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                ],
                backgroundColor: [
                    "#1de9b6",
                    "#899FD4",
                    "#04a9f5",
                    "#2f4858",
                    "#386c5f",
                    "#a2b455",
                    "#daeb89",
                    "#7a91fb",
                    "#b0ec8f",
                    "#fa7239"
                ]
            }]
        };
        var myPieChart = new Chart(bar, {
            type: 'doughnut',
            data: inventory,
            responsive: true,
            options: {
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: '<?php echo e(trans_choice('module_inventory', 2)); ?>'
                    }
                }
            }
        });
        // [ pie-chart ] end

        // [ bar-chart ] start
        var labels =  <?php echo $months ?>;
        var monthly_visitors =  <?php echo $monthly_visitors ?>;
        var monthly_phone_logs =  <?php echo $monthly_phone_logs ?>;
        var monthly_enqueries =  <?php echo $monthly_enqueries ?>;
        var monthly_complains =  <?php echo $monthly_complains ?>;
        var monthly_postals =  <?php echo $monthly_postals ?>;
        var monthly_schedules =  <?php echo $monthly_schedules ?>;

        var bar = document.getElementById("front-desk-line").getContext('2d');
        var calcul = {
            labels: labels,
            datasets: [
                {
                    label: '<?php echo e(trans_choice('module_visitor_log', 2)); ?>',
                    backgroundColor: '#04a9f5',
                    borderColor: '#04a9f5',
                    data: monthly_visitors,
                },
                {
                    label: '<?php echo e(trans_choice('module_phone_log', 2)); ?>',
                    backgroundColor: '#1de9b6',
                    borderColor: '#1de9b6',
                    data: monthly_phone_logs,
                },
                {
                    label: '<?php echo e(trans_choice('module_enquiry', 2)); ?>',
                    backgroundColor: '#3ebfea',
                    borderColor: '#3ebfea',
                    data: monthly_enqueries,
                },
                {
                    label: '<?php echo e(trans_choice('module_complain', 2)); ?>',
                    backgroundColor: '#f4c22b',
                    borderColor: '#f4c22b',
                    data: monthly_complains,
                },
                {
                    label: '<?php echo e(trans_choice('module_postal_exchange', 2)); ?>',
                    backgroundColor: '#f44236',
                    borderColor: '#f44236',
                    data: monthly_postals,
                },
                {
                    label: '<?php echo e(trans_choice('module_meeting', 2)); ?>',
                    backgroundColor: '#37474f',
                    borderColor: '#37474f',
                    data: monthly_schedules,
                }
            ]
        };
        var myBarChart = new Chart(bar, {
            type: 'bar',
            data: calcul,
            options: {
                scales: {
                    y: {
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                barValueSpacing: 100
            }
        });
        // [ bar-chart ] end
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\Dapin\Dapin\resources\views/admin/index.blade.php ENDPATH**/ ?>