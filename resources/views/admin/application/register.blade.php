@extends('admin.layouts.master')

@section('title', 'Register Student')

@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Register Student</h5>
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{ route('students.update', $application->id) }}" enctype="multipart/form-data">
                            @csrf
                         
                            
                            <input type="hidden" name="application_id" value="{{ $application->id }}">
                            <input type="hidden" name="status" value="2"> <!-- Status update -->

                            <div class="row">
                                <div class="col-lg-6">
                                    <!-- Additional Fields Added Here -->
                                    <div class="form-group">
                                        <label>Registration No</label>
                                        <input type="text" class="form-control" name="registration_no" value="{{ $application->registration_no }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Admission Date</label>
                                        <input type="date" class="form-control" name="admission_date" 
                                               value="{{ $application->admission_date ? $application->admission_date : date('Y-m-d') }}" readonly>
                                    </div>
                                    
                                    <!-- Original Fields -->
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" name="first_name" value="{{ $application->first_name }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" name="last_name" value="{{ $application->last_name }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ $application->email }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" name="phone" value="{{ $application->phone }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Program</label>
                                        <select class="form-control" name="program_id" required>
                                            <option value="">{{ __('select') }}</option>
                                            @foreach($programs as $program)
                                                <option value="{{ $program->id }}" {{ $application->program_id == $program->id ? 'selected' : '' }}>{{ $program->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Batch</label>
                                        <select class="form-control" name="batch_id" required>
                                            <option value="">{{ __('select') }}</option>
                                            @foreach($batches as $batch)
                                                <option value="{{ $batch->id }}" {{ $application->batch_id == $batch->id ? 'selected' : '' }}>{{ $batch->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Session, Semester, and Section below Batch -->
                                    <div class="form-group">
                                        <label>Session</label>
                                        <select class="form-control" name="session_id" required>
                                            <option value="">{{ __('select') }}</option>
                                            @foreach($sessions as $session)
                                                <option value="{{ $session->id }}">{{ $session->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Semester</label>
                                        <select class="form-control" name="semester_id" required>
                                            <option value="">{{ __('select') }}</option>
                                            @foreach($semesters as $semester)
                                                <option value="{{ $semester->id }}">{{ $semester->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Section</label>
                                        <select class="form-control" name="section_id" required>
                                            <option value="">{{ __('select') }}</option>
                                            @foreach($sections as $section)
                                                <option value="{{ $section->id }}">{{ $section->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Date of Birth</label>
                                        <input type="date" class="form-control" name="dob" value="{{ $application->dob }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select class="form-control" name="gender" required>
                                            <option value="1" {{ $application->gender == 1 ? 'selected' : '' }}>Male</option>
                                            <option value="2" {{ $application->gender == 2 ? 'selected' : '' }}>Female</option>
                                            <option value="3" {{ $application->gender == 3 ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Mode of Study</label>
                                        <select class="form-control" name="mode_of_study" required>
                                            <option value="Full-time" {{ $application->mode_of_study == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                            <option value="Part-time" {{ $application->mode_of_study == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                            <option value="Online" {{ $application->mode_of_study == 'Online' ? 'selected' : '' }}>Online</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Nationality</label>
                                        <input type="text" class="form-control" name="nationality" value="{{ $application->nationality }}">
                                    </div>
                                    <div class="form-group">
                                        <label>National ID</label>
                                        <input type="text" class="form-control" name="national_id" value="{{ $application->national_id }}">
                                    </div>
                                    <!-- KCSE Details -->
                                    <div class="form-group">
                                        <label>KCSE Index No</label>
                                        <input type="text" class="form-control" name="kcse_index_no" value="{{ $application->kcse_index_no }}">
                                    </div>
                                    <div class="form-group">
                                        <label>KCSE Year</label>
                                        <input type="text" class="form-control" name="kcse_year" value="{{ $application->kcse_year }}">
                                    </div>

                                    <!-- County and Sub-County Dropdowns -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="county">{{ __('County') }} <span>*</span></label>
                                                <select class="form-control" name="county" id="county" required>
                                                    <option value="">{{ __('Select County') }}</option>
                                                    @foreach($counties as $county)
                                                    <option value="{{ $county->CountyID }}" 
                                                        {{ ($application->county->CountyID ?? null) == $county->CountyID ? 'selected' : '' }}>
                                                        {{ $county->CountyName }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sub_county">{{ __('Sub-County') }} <span>*</span></label>
                                                <select class="form-control" name="sub_county" id="sub_county" required>
                                                    <option value="">{{ __('Select Sub-County') }}</option>
                                                    @foreach($subCounties as $subCounty)
                                                    <option value="{{ $subCounty->SubCountyID }}" 
                                                        data-county-id="{{ $subCounty->CountyID }}"
                                                        {{ ($application->sub_county->SubCountyID ?? null) == $subCounty->SubCountyID ? 'selected' : '' }}>
                                                        {{ $subCounty->SubCountyName }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- KCSE Certificate and Result Slip Download Links -->
                                    
                                    <div class="row">
                                        <!-- KCSE Certificate -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>KCSE Certificate</label>
                                                @if($application->kcse_certificate)
                                                    <!-- Show download link if file exists -->
                                                    <a href="{{ asset('uploads/student/' . $application->kcse_certificate) }}" target="_blank" class="btn btn-success btn-sm">
                                                        Download KCSE Certificate
                                                    </a>
                                                    <p class="text-success mt-2">File already uploaded.</p>
                                                @else
                                                    <!-- Show file input if no file exists -->
                                                    <input type="file" class="form-control" name="kcse_certificate" accept=".pdf,.jpg,.jpeg,.png">
                                                    <small class="text-muted">Upload a PDF, JPG, or PNG file.</small>
                                                @endif
                                                <input type="hidden" name="existing_kcse_certificate" value="{{ $application->kcse_certificate }}">
                                            </div>
                                        </div>
                                    
                                        <!-- KCSE Result Slip -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>KCSE Result Slip</label>
                                                @if($application->kcse_result_slip)
                                                    <!-- Show download link if file exists -->
                                                    <a href="{{ asset('uploads/student/' . $application->kcse_result_slip) }}" target="_blank" class="btn btn-success btn-sm">
                                                        Download KCSE Result Slip
                                                    </a>
                                                    <p class="text-success mt-2">File already uploaded.</p>
                                                @else
                                                    <!-- Show file input if no file exists -->
                                                    <input type="file" class="form-control" name="kcse_result_slip" accept=".pdf,.jpg,.jpeg,.png">
                                                    <small class="text-muted">Upload a PDF, JPG, or PNG file.</small>
                                                @endif
                                                <input type="hidden" name="existing_kcse_result_slip" value="{{ $application->kcse_result_slip }}">
                                            </div>
                                        </div>
                                    </div>
<div class="form-group">
    <label>Student ID</label>
    <input type="text" class="form-control" name="student_id" value="{{ old('student_id', $application->student_id ?? '') }}" required>
</div>
                                    </div>






                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update Application & Register Student</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // When the county dropdown changes
        $('#county').change(function() {
            var selectedCountyID = $(this).val();

            // Hide all sub-county options
            $('#sub_county option').hide();

            // Show only the sub-counties that belong to the selected county
            $('#sub_county option[data-county-id="' + selectedCountyID + '"]').show();

            // Reset the sub-county dropdown to the default option
            $('#sub_county').val('');
        });

        // Trigger the change event on page load to set the initial state
        $('#county').trigger('change');
    });
</script>
@endsection