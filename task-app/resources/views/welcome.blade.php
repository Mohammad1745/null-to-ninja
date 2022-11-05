@extends(\Auth::user() ?'layouts.app' : 'layouts.auth')

@section('content')
    <div class="">
        <h1>CRUD Operations</h1>
        <h4>Create, Read, Update, Delete</h4>
    </div>
@endsection
