@extends('layout')

@section('title', 'Add New User')

@section('content')
<section class="p-3" style="min-height:calc(100vh - 112px)">
    <div class="message"></div>

      <div class="row">
        <div class="col-md-12">
            <div class="container">
            <h1>Simple login Form!</h1>


        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
            {{ $error }}
        @endforeach
        @endif

            <form method="POST" action="{{ route('login_post') }}">
                @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address or Username or Phone Number</label>
                  <input type="text" name="data" class="form-control" id="exampleInputEmail1" value="{{ old('data') ?? 'admin' }}"  placeholder="Enter email or username or phone" >
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">Password </label>
                  <input type="password" name="password" class="form-control" id="exampleInputPassword1 "  placeholder="admin">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        </div>
</div>
</section>
@endsection

