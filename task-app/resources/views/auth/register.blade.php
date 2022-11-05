@extends('layouts.auth')

@section('title', "Registration")

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            Register
        </div>
        <div class="card-body">
            <form action="{{route('register.process')}}" method="post">
                @csrf
                <div class="form-group mt-3">
                    <labe>Name</labe>
                    <input type="text" name="name" class="form-control" placeholder="Jhone Doe" value="{{old('name')}}">
                    @if (isset($errors) && $errors->has('name'))
                        <span class="text-danger"><strong>{{ $errors->first('name') }}</strong></span>
                    @endif
                </div>
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
                    <input type="password" name="password" class="form-control" placeholder="@#423423d"
                           value="{{old('password')}}">
                    @if (isset($errors) && $errors->has('password'))
                        <span class="text-danger"><strong>{{ $errors->first('password') }}</strong></span>
                    @endif
                </div>
                <div class="form-group mt-3">
                    <labe>Confirm Password</labe>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="@#423423d"
                           value="{{old('password_confirmation')}}">
                    @if (isset($errors) && $errors->has('password_confirmation'))
                        <span class="text-danger"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mt-3">Register</button>
            </form>
        </div>
    </div>
@endsection
