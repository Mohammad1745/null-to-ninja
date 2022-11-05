@extends('layouts.auth')

@section('title', "Verification")

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            Verification
        </div>
        <div class="card-body">
            <form action="{{route('verification.process')}}" method="post">
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
                    <labe>Verification Code</labe>
                    <input type="text" name="code" class="form-control" placeholder="1234">
                    @if (isset($errors) && $errors->has('code'))
                        <span class="text-danger"><strong>{{ $errors->first('code') }}</strong></span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mt-3">Submit Code</button>
            </form>
        </div>
    </div>
@endsection
