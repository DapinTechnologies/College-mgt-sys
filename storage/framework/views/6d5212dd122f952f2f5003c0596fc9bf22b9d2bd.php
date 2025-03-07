<!-- Show modal content -->
<div id="showModal-<?php echo e($row->id); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel"><?php echo e(__('modal_view')); ?> <?php echo e($title); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <!-- Details View Start -->
                <h4><mark class="text-primary"><?php echo e(__('field_title')); ?>:</mark> <?php echo e($row->title); ?></h4>
                <hr/>
                <div class="">
                    <div class="row">
                        <div class="col-md-6">
                            <p><mark class="text-primary"><?php echo e(__('field_faculty')); ?>:</mark> <?php echo e($row->faculty); ?></p><hr/>
                            <p><mark class="text-primary"><?php echo e(__('field_total')); ?> <?php echo e(__('field_semester')); ?>:</mark> <?php echo e($row->semesters); ?></p><hr/>
                            <p><mark class="text-primary"><?php echo e(__('field_total_credit_hour')); ?>:</mark> <?php echo e($row->credits); ?></p><hr/>
                        </div>
                        <div class="col-md-6">
                            <p><mark class="text-primary"><?php echo e(__('field_total')); ?> <?php echo e(__('field_subject')); ?>:</mark> <?php echo e($row->courses); ?></p><hr/>
                            <p><mark class="text-primary"><?php echo e(__('field_duration')); ?>:</mark> <?php echo e($row->duration); ?></p><hr/>
                            <p><mark class="text-primary"><?php echo e(__('field_total')); ?> <?php echo e(__('field_fee')); ?>:</mark> <?php echo e(round($row->fee, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></p><hr/>

                            <p><mark class="text-primary"><?php echo e(__('field_status')); ?>:</mark>
                                <?php if( $row->status == 1 ): ?>
                                <span class="badge badge-pill badge-success"><?php echo e(__('status_active')); ?></span>
                                <?php else: ?>
                                <span class="badge badge-pill badge-danger"><?php echo e(__('status_inactive')); ?></span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <p><mark class="text-primary"><?php echo e(__('field_description')); ?>:</mark> <?php echo $row->description; ?></p><hr/>
                        </div>
                    </div>
                </div>
                <!-- Details View End -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> <?php echo e(__('btn_close')); ?></button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\User\Desktop\business\latest Dapin\backup\Dapin\stk -trial\Dapin\Dapin\resources\views/admin/web/course/show.blade.php ENDPATH**/ ?>