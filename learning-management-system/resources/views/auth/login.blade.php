@extends('layouts.auth')

@section('title', "Login")

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            Login
        </div>
        <div class="card-body">
            <form action="{{route('login.process')}}" method="post">
                @csrf
                <div class="form-group mt-3">
                    <labe>Email</labe>
                    <input type="email" name="email" class="form-control" placeholder="john@email.com"
                           value="{{old('email')}}">
                    @if (isset($errors) && $errors->has('email'))
                        <span class="text-danger"><strong>{{ $errors->first('email') }}</strong></span>
                    @endif
                </div>
                <div class="form-group mt-3">
                    <labe>Password</labe>
                    <input type="password" name="password" class="form-control" placeholder="@#423423d">
                    @if (isset($errors) && $errors->has('password'))
                        <span class="text-danger"><strong>{{ $errors->first('password') }}</strong></span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mt-3">Login</button>
            </form>
        </div>
    </div>
@endsection
