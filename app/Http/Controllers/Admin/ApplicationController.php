<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use App\Models\StudentRelative;
use App\Models\StudentEnroll;
use App\Models\EnrollSubject;
use Illuminate\Http\Request;
use App\Traits\FileUploader;
use App\Models\Application;
use App\Models\StatusType;
use App\Models\Province;
use App\Models\District;
use App\Models\Document;
use App\Models\Program;
use App\Models\Student;
use App\Models\Batch;
use App\Models\County;
use App\Models\SubCounty;
use Carbon\Carbon;
use Toastr;
use Auth;
use Hash;
use DB;
use App\Services\SmsService;
use App\Models\SmsConfiguration;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use App\Services\ApplicationSmsService;
use Illuminate\Support\Facades\Http;

class ApplicationController extends Controller
{
    use FileUploader;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_application', 1);
        $this->route = 'admin.application';
        $this->view = 'admin.application';
        $this->path = 'student';
        $this->access = 'application';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
{ 
    //dd("Hello");
    $data['title'] = $this->title; 
    $data['route'] = $this->route;
    $data['view'] = $this->view; 
    $data['path'] = $this->path;
    $data['access'] = $this->access; 

    // Default selection
    $data['selected_batch'] = $request->batch ?? '0'; // '0' for all batches
    $data['selected_program'] = $request->program ?? '0'; // '0' for all programs
    $data['selected_status'] = $request->status ?? '99'; // '99' for all statuses
    $data['selected_start_date'] = $request->start_date ?? null;
    $data['selected_end_date'] = $request->end_date ?? null;
    $data['selected_registration_no'] = $request->registration_no ?? null;

    $data['batches'] = Batch::where('status', '1')->orderBy('id', 'desc')->get();
    $data['programs'] = Program::where('status', '1')->orderBy('title', 'asc')->get();

    // Query applications with filters and convert the result to a collection
    $data['rows'] = collect(Application::when($request->start_date && $request->end_date, function ($query) use ($request) {
            $query->whereDate('apply_date', '>=', $request->start_date)
                  ->whereDate('apply_date', '<=', $request->end_date);
        })
        ->when($request->batch && $request->batch !== '0', fn($query) => $query->where('batch_id', $request->batch))
        ->when($request->program && $request->program !== '0', fn($query) => $query->where('program_id', $request->program))
        ->when($request->registration_no, fn($query) => $query->where('registration_no', 'LIKE', '%' . $request->registration_no . '%'))
        ->when($request->status && $request->status != '99', fn($query) => $query->where('status', $request->status))
        ->orderBy('created_at', 'desc')
        ->get());

    return view($this->view . '.index', $data);
}

    
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
       // dd('Hello Application');
        // Field Validation
        $request->validate([
            'student_id' => 'required|unique:students,student_id',
            'batch' => 'required',
            'program' => 'required',
            'session' => 'required',
            'semester' => 'required',
            'section' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required',
            'gender' => 'required',
            'dob' => 'required|date',
            'admission_date' => 'required|date',
            'photo' => 'nullable|image',
            'signature' => 'nullable|image',
            'kcse_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png', // KCSE certificate validation
            'kcse_result_slip' => 'nullable|file|mimes:pdf,jpg,jpeg,png', // KCSE result slip validation
            'county' => 'required', // County validation
            'sub_county' => 'required', // Sub-county validation
            'physical_address' => 'nullable|string', // Physical address validation
            'mode_of_education' => 'required', // Mode of education validation
        ]);
      

        // Random Password
        $password = str_random(8);
        $data = Application::where('registration_no', $request->registration_no)->firstOrFail();
    
        // Insert Data
        try {
            DB::beginTransaction();
    
            $application = new Student;
            $application->student_id = $request->student_id;
            $application->registration_no = $request->registration_no;
            $application->batch_id = $request->batch;
            $application->program_id = $request->program;
            $application->admission_date = Carbon::parse($request->admission_date)->format('Y-m-d');

    
            // Personal Information
            $application->first_name = $request->first_name;
            $application->last_name = $request->last_name;
            $application->father_name = $request->father_name;
            $application->mother_name = $request->mother_name;
            $application->father_occupation = $request->father_occupation;
            $application->mother_occupation = $request->mother_occupation;
            $application->email = $request->email;
            $application->password = Hash::make($password);
            $application->password_text = Crypt::encryptString($password);
    
            // Location Information
            $application->county = $request->county; // Store county
            $application->sub_county = $request->sub_county; // Store sub-county
            $application->permanent_address = $request->physical_address; // Store physical address as permanent address
    
            // Gender
            $application->gender = $request->gender; // Store gender
    
            // Mode of Education
            $application->mode_of_education = $request->mode_of_education; // Store mode of education
    
            // KCSE Results
            if ($request->hasFile('kcse_certificate')) {
                $application->kcse_certificate = $this->uploadMedia($request, 'kcse_certificate', $this->path);
            }
            if ($request->hasFile('kcse_result_slip')) {
                $application->kcse_result_slip = $this->uploadMedia($request, 'kcse_result_slip', $this->path);
            }
    
            // Other Fields
            $application->dob = $request->dob;
            $application->phone = $request->phone;
            $application->emergency_phone = $request->emergency_phone;
            $application->religion = $request->religion;
            $application->caste = $request->caste;
            $application->mother_tongue = $request->mother_tongue;
            $application->marital_status = $request->marital_status;
            $application->blood_group = $request->blood_group;
            $application->nationality = $request->nationality;
            $application->national_id = $request->national_id;
            $application->passport_no = $request->passport_no;
    
            // School Information
            $application->school_name = $request->school_name;
            $application->school_exam_id = $request->school_exam_id;
            $application->school_graduation_year = $request->school_graduation_year;
            $application->school_graduation_point = $request->school_graduation_point;
            $application->collage_name = $request->collage_name;
            $application->collage_exam_id = $request->collage_exam_id;
            $application->collage_graduation_year = $request->collage_graduation_year;
            $application->collage_graduation_point = $request->collage_graduation_point;
    
            // Upload Files
            if ($request->hasFile('photo')) {
                $application->photo = $this->uploadImage($request, 'photo', $this->path, 300, 300);
            } else {
                $application->photo = $data->photo;
            }
            if ($request->hasFile('signature')) {
                $application->signature = $this->uploadImage($request, 'signature', $this->path, 300, 100);
            } else {
                $application->signature = $data->signature;
            }
    
            $application->status = '1';
            $application->created_by = Auth::guard('web')->user()->id;
            $application->save();
    
            // Attach Status
            $application->statuses()->attach($request->statuses);
    
            // Student Relatives
            if (is_array($request->relations)) {
                foreach ($request->relations as $key => $relation) {
                    if ($relation != '' && $relation != null) {
                        $relation = new StudentRelative;
                        $relation->student_id = $application->id;
                        $relation->relation = $request->relations[$key];
                        $relation->name = $request->relative_names[$key];
                        $relation->occupation = $request->occupations[$key];
                        $relation->phone = $request->relative_phones[$key];
                        $relation->address = $request->addresses[$key];
                        $relation->save();
                    }
                }
            }
    
            // Student Documents
            if (is_array($request->documents)) {
                $documents = $request->file('documents');
                foreach ($documents as $key => $attach) {
                    $valid_extensions = ['JPG', 'JPEG', 'jpg', 'jpeg', 'png', 'gif', 'ico', 'svg', 'webp', 'pdf', 'doc', 'docx', 'txt', 'zip', 'rar', 'csv', 'xls', 'xlsx', 'ppt', 'pptx', 'mp3', 'avi', 'mp4', 'mpeg', '3gp', 'mov', 'ogg', 'mkv'];
                    $file_ext = $attach->getClientOriginalExtension();
                    if (in_array($file_ext, $valid_extensions, true)) {
                        $filename = $attach->getClientOriginalName();
                        $extension = $attach->getClientOriginalExtension();
                        $fileNameToStore = str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_', $filename) . '_' . time() . '.' . $extension;
                        $attach->move('uploads/' . $this->path . '/', $fileNameToStore);
    
                        $document = new Document;
                        $document->title = $request->titles[$key];
                        $document->attach = $fileNameToStore;
                        $document->save();
                        $document->students()->attach($application->id);
                    }
                }
            }
    
            // Student Enroll
            $enroll = new StudentEnroll();
            $enroll->student_id = $application->id;
            $enroll->program_id = $request->program;
            $enroll->session_id = $request->session;
            $enroll->semester_id = $request->semester;
            $enroll->section_id = $request->section;
            $enroll->created_by = Auth::guard('web')->user()->id;
            $enroll->save();
    
            // Assign Subjects
            $enrollSubject = EnrollSubject::where('program_id', $request->program)->where('semester_id', $request->semester)->where('section_id', $request->section)->first();
            if (isset($enrollSubject)) {
                foreach ($enrollSubject->subjects as $subject) {
                    $enroll->subjects()->attach($subject->id);
                }
            }
    
            // Application Status Update
            $data->status = '2';
            $data->updated_by = Auth::guard('web')->user()->id;
            $data->save();
    
            DB::commit();
    
            Toastr::success(__('msg_created_successfully'), __('msg_success'));
            return redirect()->route($this->route . '.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error(__('msg_created_error'), __('msg_error'));
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $data['row'] = $application;

        return view($this->view.'.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        

        $data['provinces'] = Province::where('status', '1')
                            ->orderBy('title', 'asc')->get();
        $data['present_districts'] = District::where('status', '1')
                            ->where('province_id', $application->present_province)
                            ->orderBy('title', 'asc')->get();
        $data['permanent_districts'] = District::where('status', '1')
                            ->where('province_id', $application->permanent_province)
                            ->orderBy('title', 'asc')->get();
        $data['statuses'] = StatusType::where('status', '1')->get();
        $data['batches'] = Batch::where('status', '1')->orderBy('id', 'desc')->get();

        $data['row'] = $application;


        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        //
        if($application->status == 0){
        $application->status = '1';
        }else{
        $application->status = '0';
        }
        $application->updated_by = Auth::guard('web')->user()->id;
        $application->save();

        
        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        DB::beginTransaction();
        // Delete
        $this->deleteMultiMedia($this->path, $application, 'photo');
        $this->deleteMultiMedia($this->path, $application, 'signature');
        $this->deleteMultiMedia($this->path, $application, 'school_transcript');
        $this->deleteMultiMedia($this->path, $application, 'school_certificate');
        $this->deleteMultiMedia($this->path, $application, 'collage_transcript');
        $this->deleteMultiMedia($this->path, $application, 'collage_certificate');
        
        $application->delete();
        DB::commit();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
