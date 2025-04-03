<?php $__env->startSection('title', 'Fees Payment'); ?>
<?php $__env->startSection('content'); ?>

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">My Fees</h5>
                 
                        <h5 class="mb-0"> <a href="<?php echo e(route('student.my.mpesa.statement')); ?>" class="btn btn-primary btn-sm" target="_blank">
                            View Statement
                        </a>    </h5>
                       
                
                        
                    </div>
                    
                    <div class="card-block">
                        <?php if(isset($rows)): ?>
                        <div class="table-responsive">
                            <table id="basic-table" class="display table table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Session</th>
                                        <th>Semester</th>
                                        <th>Fees Type</th>
                                        <th>Total Fee</th>
                                        <th>Paid</th>
                                        <th>Balance</th>
                                        <th>Due Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($row->studentEnroll->session->title ?? ''); ?></td>
                                        <td><?php echo e($row->studentEnroll->semester->title ?? ''); ?></td>
                                        <td><?php echo e($row->category->title ?? ''); ?></td>
                                        <td><?php echo e(number_format($row->fee_amount, 2)); ?> <?php echo e($setting->currency_symbol); ?></td>
                                        <td><?php echo e(number_format($row->paid_amount, 2)); ?> <?php echo e($setting->currency_symbol); ?></td>
                                        <td><?php echo e(number_format(max(0, $row->fee_amount - $row->paid_amount), 2)); ?> <?php echo e($setting->currency_symbol); ?></td>
                                        <td><?php echo e($row->due_date ? date('Y-m-d', strtotime($row->due_date)) : '-'); ?></td>
                                        <td>
                                            

                                            <td>
                                                <a href="<?php echo e(route('studentprocess', ['id' => $row->id, 'payment_amount' => max(0, $row->fee_amount - $row->paid_amount)])); ?>" class="btn btn-success">
                                                    <i class="fas fa-money-bill"></i> Pay
                                                </a>
                                            </td> 
                                            
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#basic-table').DataTable();
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('student.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\Dapin\Dapin\resources\views/student/fees/index.blade.php ENDPATH**/ ?>