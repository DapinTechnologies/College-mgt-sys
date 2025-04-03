
<?php $__env->startSection('title', 'My M-Pesa Statement'); ?>

<?php $__env->startSection('content'); ?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">M-Pesa Transactions for <strong><?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?></strong></h5>
            </div>

            <div class="card-block">
                <?php if($transactions->count()): ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fee Category</th>
                            <th>Amount</th>
                            <th>Receipt</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($index + 1); ?></td>
                            <td><?php echo e($tx->fee->category->title ?? 'N/A'); ?></td>
                            <td><?php echo e(number_format($tx->Amount, 2)); ?></td>
                            <td><?php echo e($tx->MpesaReceiptNumber ?? 'Not Paid'); ?></td>
                            <td>
                                <span class="badge badge-<?php echo e($tx->status === 'Paid' ? 'success' : 'warning'); ?>">
                                    <?php echo e($tx->status); ?>

                                </span>
                            </td>
                            <td><?php echo e(\Carbon\Carbon::parse($tx->created_at)->format('d M Y')); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($tx->created_at)->format('h:i A')); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <p>No M-Pesa transactions found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('student.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\Dapin\Dapin\resources\views/student/fees/my_statement.blade.php ENDPATH**/ ?>