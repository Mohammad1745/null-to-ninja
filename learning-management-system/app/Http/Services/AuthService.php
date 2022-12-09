<?php

namespace App\Http\Services;

use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthService
{
    /**
     * @param array $data
     * @return array
     */
    public function processLogin (array $data): array
    {
        try {
            $user = User::where('email', $data['email'])->first();
            if (!$user) {
                return ['success' => false,'message' => "Email not found"];
            }
            if (!Hash::check($data['password'], $user->password)) {
                return ['success' => false,'message' => "Wrong Email Or Password"];
            }
            Auth::login($user);
            return ['success' => true,'message' => "Login Successful!"];
        }
        catch (\Exception $exception) {
            return ['success' => false,'message' => $exception->getMessage()];
        }
    }

    /**
     * @param array $data
     * @return array
     */
    public function processRegistration (array $data): array
    {
        try {
            $code = randomNumber(4);
            $formattedData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'verification_code' => $code,
                'password' => Hash::make($data['password']),
            ];
            $user = User::create($formattedData);
            $sendEmailJob = new SendEmailJob($user->email, $user->name, $code);
            $this->dispatch($sendEmailJob);
            return ['success' => true,'message' => "Registration Successful! Please check email for code"];
        }
        catch (\Exception $exception) {
            return ['success' => false,'message' => $exception->getMessage()];
        }
    }
}
