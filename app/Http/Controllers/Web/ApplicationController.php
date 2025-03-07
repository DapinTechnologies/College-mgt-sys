<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ApplicationSetting;
use Illuminate\Http\Request;
use App\Traits\FileUploader;
use App\Models\Application;
use App\Models\Province;
use App\Models\Program;
use Carbon\Carbon;
use App\Models\County;
use App\Models\SubCounty;
use App\Models\Student;
use App\Models\Batch;
use App\Models\Session;
use App\Models\Semester;
use App\Models\Section;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Toastr;
use DB;

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
        $this->route = 'application';
        $this->view = 'admin.application';
        $this->path = 'student';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        
        $data['programs'] = Program::where('status', '1')->orderBy('title', 'asc')->get();
        $data['provinces'] = Province::where('status', '1')->orderBy('title', 'asc')->get();
        $data['applications'] = Application::with(['county', 'subCounty'])->get();

        
       
        $data['applicationSetting'] = ApplicationSetting::where('slug', 'admission')->where('status', '1')->firstOrFail();


        return view($this->view.'.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all()); // Debugging line (optional)
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'nullable|string|max:20',
            'program' => 'required|exists:programs,id',
            'dob' => 'required|date',
            'gender' => 'required|in:1,2,3',
            'national_id' => 'nullable|string|max:255',
            'kcse_index_no' => 'nullable|string|max:255',
            'kcse_year' => 'nullable|string|max:255',
            'county_id' => 'nullable|exists:counties,CountyID', // Changed from 'county'
            'sub_county_id' => 'nullable|exists:sub_counties,SubCountyID', // Changed from 'sub_county'
            'kcse_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:20480', // 20MB max
            'kcse_result_slip' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:20480', // 20MB max
        ]);
    
        // Create a new Application instance
        $application = new Application;
    
        // Handle KCSE Certificate Upload
        if ($request->hasFile('kcse_certificate')) {
            $kcseCertificate = $request->file('kcse_certificate');
            $kcseCertificateName = time() . '_' . $kcseCertificate->getClientOriginalName();
            $kcseCertificate->move(public_path('uploads/student'), $kcseCertificateName);
            $application->kcse_certificate = $kcseCertificateName;
        }
    
        // Handle KCSE Result Slip Upload
        if ($request->hasFile('kcse_result_slip')) {
            $kcseResultSlip = $request->file('kcse_result_slip');
            $kcseResultSlipName = time() . '_' . $kcseResultSlip->getClientOriginalName();
            $kcseResultSlip->move(public_path('uploads/student'), $kcseResultSlipName);
            $application->kcse_result_slip = $kcseResultSlipName;
        }
    
        // Set Application fields
        $application->first_name = $request->input('first_name');
        $application->last_name = $request->input('last_name');
        $application->email = $request->input('email');
        $application->phone = $request->input('phone');
        $application->program_id = $request->input('program');
    
        $application->batch_id = $request->input('batch_id');
        $application->apply_date = Carbon::now();
    
        $application->dob = $request->input('dob');
        $application->gender = $request->input('gender');
        $application->national_id = $request->input('national_id');
        $application->kcse_index_no = $request->input('kcse_index_no');
        $application->kcse_year = $request->input('kcse_year');
    
        $application->county_id = $request->input('county_id'); // Changed from 'county'
        $application->sub_county_id = $request->input('sub_county_id'); // Changed from 'sub_county'
        $application->status = 1; // Set Application status to 1
    
        // Save the new Application
        $application->save();
    
        // Generate Registration Number
        $application->registration_no = intval(10000000) + $application->id;
        $application->save();
    
        // Redirect or return a response
        return redirect()->back()->with('success', 'Application created successfully.');
    }
    


    public function register($id)
    {
        // Fetch the application with the county and sub_county relationships loaded
        $application = Application::with(['county', 'sub_county'])->where('id', $id)->firstOrFail();
    
        // Fetch other necessary data
        $programs = Program::all();
        $batches = Batch::all();
        $sessions = Session::all();
        $semesters = Semester::all();
        $sections = Section::all();
    
        $counties = County::all();
        $subCounties = SubCounty::all();
    
        // Pass data to the view
        return view('admin.application.register', compact(
            'programs', 'batches', 'sessions', 'semesters',
            'sections', 'application', 'counties', 'subCounties'
        ));
    }


    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'student_id' => 'required|string|max:255|unique:students,student_id,' . $id, // Ensure student_id is unique
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'program_id' => 'required|exists:programs,id',
            'batch_id' => 'required|exists:batches,id',
          
            'admission_date'=>'required|date',
            'dob' => 'required|date',
            'gender' => 'required|in:1,2,3',
            'national_id' => 'nullable|string|max:255',
            'kcse_index_no' => 'nullable|string|max:255',
            'kcse_year' => 'nullable|string|max:255',
            'county_id' => 'nullable|exists:counties,CountyID',
            'sub_county_id' => 'nullable|exists:sub_counties,SubCountyID',
            'kcse_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:20480', // 2MB max
            'kcse_result_slip' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:20480', // 2MB max
        ]);
    
        // Find the application
        $application = Application::findOrFail($id);
    
        // Handle KCSE Certificate Upload
        if ($request->hasFile('kcse_certificate')) {
            $kcseCertificate = $request->file('kcse_certificate');
            $kcseCertificateName = time() . '_' . $kcseCertificate->getClientOriginalName();
            $kcseCertificate->move(public_path('uploads/student'), $kcseCertificateName);
            $application->kcse_certificate = $kcseCertificateName;
        } else {
            // Retain the existing file if no new file is uploaded
            $application->kcse_certificate = $request->input('existing_kcse_certificate');
        }
    
        // Handle KCSE Result Slip Upload
        if ($request->hasFile('kcse_result_slip')) {
            $kcseResultSlip = $request->file('kcse_result_slip');
            $kcseResultSlipName = time() . '_' . $kcseResultSlip->getClientOriginalName();
            $kcseResultSlip->move(public_path('uploads/student'), $kcseResultSlipName);
            $application->kcse_result_slip = $kcseResultSlipName;
        } else {
            // Retain the existing file if no new file is uploaded
            $application->kcse_result_slip = $request->input('existing_kcse_result_slip');
        }
    
        // Update the Application model
        $application->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'program_id' => $request->input('program_id'),
            'batch_id' => $request->input('batch_id'),
            'apply_date' => Carbon::now(),
            'dob' => $request->input('dob'),
            'gender' => $request->input('gender'),
            'national_id' => $request->input('national_id'),
            'kcse_index_no' => $request->input('kcse_index_no'),
            'kcse_year' => $request->input('kcse_year'),
            'county_id' => $request->input('county'),
            'sub_county_id' => $request->input('sub_county'),
            'kcse_certificate' => $application->kcse_certificate,
            'kcse_result_slip' => $application->kcse_result_slip,
            'status' => 2, // Set Application status to 2
        ]);
    
        // Find or create the Student model
        $student = Student::updateOrCreate(
            ['email' => $application->email], // Match by email
            [
                'student_id' => $request->input('student_id'), // Use manually entered student_id
                'registration_no' => $application->registration_no,
                'batch_id' => $application->batch_id,
                'program_id' => $application->program_id,
                'admission_date' => Carbon::now(),
                'first_name' => $application->first_name,
                'last_name' => $application->last_name,
                'email' => $application->email,
                'phone' => $application->phone,
                'dob' => $application->dob,
                'gender' => $application->gender,
                'national_id' => $application->national_id,
                'kcse_index_no' => $application->kcse_index_no,
                'kcse_year' => $application->kcse_year,
                'kcse_certificate' => $application->kcse_certificate,
                'kcse_result_slip' => $application->kcse_result_slip,
                'password' => Hash::make(Str::random(8)), // Generate and hash a random password
                'password_text' => Crypt::encryptString(Str::random(8)), // Encrypt the plaintext password
                'status' => 1, // Set Student status to 1
            ]
        );
    
        return redirect('/admin/admission/application')->with('success', 'Application and Student updated successfully.');
    }



}
