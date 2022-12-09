<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Services\AuthService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private AuthService $service;

    /**
     * @param AuthService $service
     */
    function __construct (AuthService $service)
    {
        $this->service = $service;
    }

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
        $response = $this->service->processLogin($request->all());

        return $response['success'] ?
            redirect()->route('home')->with('success', $response['message'])
            : redirect()->back()->with('error', $response['message']);
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
        $response = $this->service->processRegistration($request->all());

        return $response['success'] ?
            redirect()->route('verification')->with('success', $response['message'])
            : redirect()->back()->with('error', $response['message']);
    }
}
