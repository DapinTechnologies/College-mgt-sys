
<?php $__env->startSection('title', 'M-Pesa Payment'); ?>
<?php $__env->startSection('content'); ?>

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h5>M-Pesa Payment</h5>
                    </div>

                    <div class="card-block">
                        <form method="post" action="<?php echo e(url('initiatepush')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="fee_id" value="<?php echo e($fee->id); ?>">

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Fee Category</label>
                                    <input type="text" class="form-control" value="<?php echo e($fee->category->title ?? ''); ?>" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Fee Amount (<?php echo e($setting->currency_symbol); ?>)</label>
                                    <input type="text" class="form-control" value="<?php echo e(number_format($fee->fee_amount, 2)); ?>" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Balance Due (<?php echo e($setting->currency_symbol); ?>)</label>
                                    <input type="text" class="form-control" value="<?php echo e(number_format($balance, 2)); ?>" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" name="phone_number" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Amount to Pay (<?php echo e($setting->currency_symbol); ?>)</label>
                                    <input type="number" class="form-control" name="payment_amount" required>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-money-check"></i> Pay with M-Pesa
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Bank Details Section -->
            <div class="col-sm-6">
                <?php if($bankDetails): ?>
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h5>Bank Payment Details</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Bank Name:</strong> <?php echo e($bankDetails->bank_name); ?></p>
                        <p><strong>Account Number:</strong> <?php echo e($bankDetails->bank_account); ?></p>
                        <p><strong>Branch:</strong> <?php echo e($bankDetails->bank_branch); ?></p>
                    </div>
                </div>
                <?php endif; ?>

                <?php if($paybill): ?>
                <div class="card">
                    <div class="card-header bg-secondary text-white text-center">
                        <h5>M-Pesa PayBill Details</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>PayBill Number:</strong> <?php echo e($paybill->paybill_number); ?></p>
                        <p><strong>Account Number:</strong> <?php echo e($paybill->paybill_account); ?></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('student.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\Dapin\Dapin\resources\views/student/fees/mpesa_payment.blade.php ENDPATH**/ ?>