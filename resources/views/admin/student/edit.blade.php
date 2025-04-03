@extends('admin.layouts.master')
@section('title', $title)

@section('page_css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/wizard.css') }}">
@endsection

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('modal_edit') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>
                        <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    <div class="wizard-sec-bg">
                        <form id="wizard-advanced-form" class="needs-validation" novalidate action="{{ route($route.'.update', $row->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Basic Information -->
                            <h3>{{ __('tab_basic_info') }}</h3>
                            <content class="form-step">
                                <fieldset class="row scheduler-border">
                                    <legend>Personal Information</legend>
                                    
                                    <div class="col-md-6">
                                        <label for="first_name">{{ __('First Name') }} <span>*</span></label>
                                        <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name', $row->first_name) }}" required>
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="last_name">{{ __('Last Name') }} <span>*</span></label>
                                        <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name', $row->last_name) }}" required>
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="dob">{{ __('Date of Birth') }} <span>*</span></label>
                                        <input type="date" class="form-control" name="dob" id="dob" value="{{ old('dob', $row->dob) }}" required>
                                        @error('dob')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="phone">{{ __('Phone Number') }} <span>*</span></label>
                                        <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $row->phone) }}" required>
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="email">{{ __('Email Address') }} <span>*</span></label>
                                        <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $row->email) }}" required>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="national_id">{{ __('National ID/Parent ID') }} <span>*</span></label>
                                        <input type="text" class="form-control" name="national_id" id="national_id" value="{{ old('national_id', $row->national_id) }}" required>
                                        @error('national_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Gender Field -->
                                    <div class="col-md-6">
                                        <label for="gender">{{ __('Gender') }} <span>*</span></label>
                                        <select class="form-control" name="gender" id="gender" required>
                                            <option value="">{{ __('Select Gender') }}</option>
                                            <option value="1" {{ old('gender', $row->gender) == 1 ? 'selected' : '' }}>{{ __('Male') }}</option>
                                            <option value="2" {{ old('gender', $row->gender) == 2 ? 'selected' : '' }}>{{ __('Female') }}</option>
                                            <option value="3" {{ old('gender', $row->gender) == 3 ? 'selected' : '' }}>{{ __('Other') }}</option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="student_id">{{ __('Student ID') }} <span>*</span></label>
                                        <input type="text" class="form-control" name="student_id" id="student_id" value="{{ old('student_id', $row->student_id) }}" required>
                                        @error('student_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="date_of_admission">{{ __('Date of Admission') }} <span>*</span></label>
                                        <input type="date" class="form-control" name="admission_date" id="date_of_admission" value="{{ old('admission_date', $row->admission_date) }}" required>
                                        @error('admission_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                  
                                </fieldset>
                            </content>

                            <!-- Batch Information -->
                            <h3>{{ __('Batch Information') }}</h3>
                         
                            <content class="form-step">
                                <fieldset class="row scheduler-border">
                                    <legend>Education Details</legend>

                                    <!-- Mode of Study -->
                                    <div class="col-md-6">
                                        <label for="mode_of_study">{{ __('Mode of Study') }} <span>*</span></label>
                                        <select class="form-control" name="mode_of_study" id="mode_of_study" required>
                                            <option value="">{{ __('Select Mode of Study') }}</option>
                                            <option value="Physical" {{ old('mode_of_study', $row->mode_of_study) == 'Physical' ? 'selected' : '' }}>Physical</option>
                                            <option value="Online" {{ old('mode_of_study', $row->mode_of_study) == 'Online' ? 'selected' : '' }}>Online</option>
                                            <option value="Hybrid" {{ old('mode_of_study', $row->mode_of_study) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                        </select>
                                        @error('mode_of_study')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Program Field -->
                                    <div class="col-md-6">
                                        <label for="program">{{ __('Program') }} <span>*</span></label>
                                        <select class="form-control" name="program" id="program" required>
                                            <option value="">{{ __('Select Program') }}</option>
                                            @foreach($programs as $program)
                                                <option value="{{ $program->id }}" {{ old('program', $row->program_id) == $program->id ? 'selected' : '' }}>{{ $program->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('program')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Batch Field -->
                                    <div class="col-md-6">
                                        <label for="batch">{{ __('Batch') }} <span>*</span></label>
                                        <select class="form-control" name="batch" id="batch" required>
                                            <option value="">{{ __('Select Batch') }}</option>
                                            @if($batches->isEmpty())
                                                <option value="" disabled>No batches available</option>
                                            @else
                                                @foreach($batches as $batch)
                                                    <option value="{{ $batch->id }}" {{ old('batch', $row->batch_id) == $batch->id ? 'selected' : '' }}>
                                                        {{ $batch->title }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('batch')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </fieldset>
                            </content>


                            <!-- KCSE Results -->
                            <h3>{{ __('KCSE Results') }}</h3>
                            <content class="form-step">
                                <fieldset class="row scheduler-border">
                                    <legend>KCSE Results</legend>

                                    <div class="col-md-6">
                                        <label for="kcse_index_no">{{ __('KCSE Index Number') }} <span>*</span></label>
                                        <input type="text" class="form-control" name="kcse_index_no" id="kcse_index_no" value="{{ old('kcse_index_no', $row->kcse_index_no) }}" required>
                                        @error('kcse_index_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="kcse_year">{{ __('KCSE Year') }} <span>*</span></label>
                                        <input type="text" class="form-control" name="kcse_year" id="kcse_year" value="{{ old('kcse_year', $row->kcse_year) }}" required>
                                        @error('kcse_year')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="kcse_overall_grade">{{ __('Overall KCSE Grade') }} <span>*</span></label>
                                        <input type="text" class="form-control" name="kcse_grade" id="kcse_overall_grade" value="{{ old('kcse_grade', $row->kcse_grade) }}" required>
                                        @error('kcse_grade')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="kcse_certificate">{{ __('KCSE Certificate') }} <span>*</span></label>
                                        <input type="file" class="form-control" name="kcse_certificate" id="kcse_certificate">
                                        @if($kcse_certificate)
                                            <a href="{{ $kcse_certificate }}" class="btn btn-success mt-2" download>
                                                <i class="fas fa-download"></i> Download KCSE Certificate
                                            </a>
                                        @endif
                                        @error('kcse_certificate')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="kcse_result_slip">{{ __('KCSE Result Slip') }} <span>*</span></label>
                                        <input type="file" class="form-control" name="kcse_result_slip" id="kcse_result_slip">
                                        @if($kcse_result_slip)
                                            <a href="{{ $kcse_result_slip }}" class="btn btn-success mt-2" download>
                                                <i class="fas fa-download"></i> Download KCSE Result Slip
                                            </a>
                                        @endif
                                        @error('kcse_result_slip')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </fieldset>
                            </content>

                            <!-- Location Information -->
                            <h3>Location</h3>
                            <content class="form-step">
                                <fieldset class="row scheduler-border">
                                    <legend>Location Details</legend>

                                    <!-- County Dropdown -->
                                    <div class="col-md-6">
                                        <label for="county">{{ __('County') }} <span>*</span></label>
                                        <select class="form-control" name="county" id="county" required>
                                            <option value="">{{ __('Select County') }}</option>
                                            @foreach($counties as $county)
                                                <option value="{{ $county->CountyID }}" {{ old('county', $row->county_id) == $county->CountyID ? 'selected' : '' }}>{{ $county->CountyName }}</option>
                                            @endforeach
                                        </select>
                                        @error('county')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Sub-County Dropdown -->
                                    <div class="col-md-6">
                                        <label for="sub_county">{{ __('Sub-County') }} <span>*</span></label>
                                        <select class="form-control" name="sub_county" id="sub_county" required>
                                            <option value="">{{ __('Select Sub-County') }}</option>
                                            @foreach($subCounties as $subCounty)
                                                <option value="{{ $subCounty->SubCountyID }}" data-county-id="{{ $subCounty->CountyID }}" {{ old('sub_county', $row->sub_county_id) == $subCounty->SubCountyID ? 'selected' : '' }}>{{ $subCounty->SubCountyName }}</option>
                                            @endforeach
                                        </select>
                                        @error('sub_county')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="physical_address">{{ __('Physical Address') }}</label>
                                        <input type="text" class="form-control" name="physical_address" id="physical_address" value="{{ old('physical_address', $row->physical_address) }}">
                                        @error('physical_address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </fieldset>
                            </content>

                            <!-- Mode of Study -->
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_js')
    <!-- validate Js -->
    <script src="{{ asset('dashboard/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>

    <!-- Wizard Js -->
    <script src="{{ asset('dashboard/js/pages/jquery.steps.js') }}"></script>

    <script type="text/javascript">
        "use strict";
        var form = $("#wizard-advanced-form").show();

        form.steps({
            headerTag: "h3",
            bodyTag: "content",
            transitionEffect: "slideLeft",
            labels: 
            {
                finish: "{{ __('btn_finish') }}",
                next: "{{ __('btn_next') }}",
                previous: "{{ __('btn_previous') }}",
            },
            onFinished: function () {
                $("#wizard-advanced-form").submit();
            }
        });

        // Dynamic Sub-County Filtering Based on Selected County
        $(document).ready(function () {
            // Store all sub-county options in a variable
            var allSubCounties = $('#sub_county').html();

            $('#county').change(function () {
                var countyId = $(this).val();
                $('#sub_county').html('<option value="">{{ __('Select Sub-County') }}</option>');

                // Filter sub-counties based on the selected county
                $(allSubCounties).filter('option').each(function () {
                    if ($(this).data('county-id') == countyId) {
                        $('#sub_county').append($(this).clone());
                    }
                });

                // Debugging: Log the selected county ID and filtered sub-counties
                console.log('Selected County ID:', countyId);
                console.log('Filtered Sub-Counties:', $('#sub_county').html());
            });
        });
    </script>
@endsection