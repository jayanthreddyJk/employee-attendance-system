<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Jobs\SendEmail;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register_employee(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z\s]+$/|min:3|max:30',
            'email' => 'required|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9._-]+@[a-zA-Z]{3,}\.[a-zA-Z]{2,}$/|unique:employees,email',
            'role' => 'required|regex:/^[a-zA-Z0-9\s]+$/|min:2|max:30',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'addEmployee')->withInput();
        }else{
            $data = $validator->validated();
            $data['password'] = bcrypt($request->input('password'));
            Employee::create($data);
            $mailData = [
                'title' => 'Welcome to Ardhas Technology!',
                'name' =>  $data['name'] . '!',
                'email' => $data['email'],
                'password' => $request->input('password')
            ];
            SendEmail::dispatch($mailData);
            return back()->withSuccess('Employee added Successfully');
        }
    }
    public function login_user(Request $request){
        $loginvalidator = Validator::make($request->all(), [
            'email' => 'required|regex:/^[a-zA-Z0-9]+[a-zA-Z0-9._-]+@[a-zA-Z]{3,}\.[a-zA-Z]{2,}$/',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'g-recaptcha-response' => 'required'
        ]);

        if ($loginvalidator->fails() || !$this->validateRecaptcha($request->input('g-recaptcha-response'))) {
            return redirect()->back()->withErrors($loginvalidator, 'login')->withInput();
        }else{
            $data = $loginvalidator->validated();
            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $user = Admin::where('email', $data['email'])->first();
                Auth::guard('admin')->login($user);
                session(['user_role' => 'admin']);
                return redirect()->intended('admin_dashboard');
            }
            if (Auth::guard('employee')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $user = Employee::where('email', $data['email'])->first();
                Auth::guard('employee')->login($user);
                session(['user_role' => 'employee']);
                return redirect()->intended('employee_dashboard');
            }
            return back()->withErrors(['loginerror' => 'Invalid credentials.'])->withInput();
        }
    }
    public function validateRecaptcha($recaptchaResponse)
    {
        $secretKey = config('services.recaptcha.secret_key');
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");
        $result = json_decode($response);
        return $result->success;
    }
    public function logout()
    {
        if (Auth::guard('employee')->check()) {
            Auth::guard('employee')->logout();
        }
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }
        session()->flush();
        return redirect()->route('home');
    }

}
