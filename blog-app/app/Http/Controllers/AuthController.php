<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Requests\Auth\VerificationRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function login (): View|Factory|Application
    {
        return view('auth.login');
    }

    /**
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function processLogin (LoginRequest $request): RedirectResponse
    {
        $allData = $request->all();
        $user = User::where('email', $allData['email'])->first();
        if (!$user) {
            return redirect()->back()->with('error', "Email not found");
        }
        if (!Hash::check($allData['password'], $user->password)) {
            return redirect()->back()->with('error', "Wrong Email Or Password");
        }
        Auth::login($user);
        return redirect()->route('home')->with('success', "Login Successful!");
    }

    /**
     * @return Application|Factory|View
     */
    public function register (): View|Factory|Application
    {
        return view('auth.register');
    }

    /**
     * @param RegistrationRequest $request
     * @return RedirectResponse
     */
    public function processRegistration (RegistrationRequest $request): RedirectResponse
    {
        $allData = $request->all();
        $code = randomNumber(4);
        $data = [
            'name' => $allData['name'],
            'email' => $allData['email'],
            'verification_code' => $code,
            'password' => Hash::make($allData['password']),
        ];
        $user = User::create($data);
        $this->_sendVerificationMail($user->email, $user->name, $code);
        return redirect()->route('verification')->with('success', "Registration Successful!");
    }
    /**
     * @return Application|Factory|View
     */
    public function verification (): View|Factory|Application
    {
        return view('auth.verification');
    }

    /**
     * @param VerificationRequest $request
     * @return RedirectResponse
     */
    public function processVerification (VerificationRequest $request): RedirectResponse
    {
        $allData = $request->all();
        $user = User::where('email', $allData['email'])->where('verification_code', $allData['code'])->first();
        if (!$user) {
            return redirect()->back()->with('error', "Invalid Code");
        }
        $data = [
            'verification_code' => null,
            'email_verified' => true
        ];
        User::where('id', $user->id)->update($data);
        return redirect()->route('login')->with('success', "Verification Successful!");
    }

    /**
     * @return RedirectResponse
     */
    public function logout (): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('home')->with('success', "Registration Successful!");
    }

    /**
     * @param string $email
     * @param string $name
     * @param string $code
     * @return void
     */
    private function _sendVerificationMail (string $email, string $name, string $code): void
    {
        $data['appName'] = 'Blog App';
        $data['code'] = $code;
        Mail::send('emails.email_verification', $data, function ($message) use ($email, $name) {
            $message->from('blog@gmail.com', 'Blog App');
            $message->to($email, $name)->subject('Verification Code');
        });
    }
}
