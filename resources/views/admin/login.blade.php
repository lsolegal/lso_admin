@extends('admin/layout/layout')

@section('section')
<div class="container min-vh-100 d-flex justify-content-center align-items-center">
    <div class="row w-100 justify-content-center">
        <div class="col-md-4">
            <h2 class="mb-4 text-center">Login</h2>
            @include('admin/layout/message')
            <form method="post" action="{{ url('login') }}">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" id="email" placeholder="john.wick@gmail.com" required>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required placeholder="*********">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</div>
@endsection
