@extends('admin/layout/layout')
@section('section')
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Manage Staff</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">All Staff</a></li>
            </ol>
        </div>
        
        <div class="row">
            <div class="col-xl-12">
                <form method="post" action="{{ route('staff.store') }}">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">All Staff</h4>
                            <a href="{{ url('staff') }}" class="btn btn-warning btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
                        </div>
                        <div class="card-body pb-2 svg-area px-3">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    @include('admin/layout/message')
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="full_name" class="form-label">Full Name <small class="text-danger">*</small>
                                                @error('full_name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </label>
                                            <input type="text" name="full_name" class="form-control" id="full_name" placeholder="Enter Full Name" required value="{{ old('full_name') }}">

                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label for="email" class="form-label">Email <small class="text-center">*</small>
                                                @error('email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </label>
                                            <input type="text" name="email" class="form-control" id="email" placeholder="jhon.wick@gmial.com" required value="{{ old('email') }}">
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label for="mobile" class="form-label">Mobile <small class="text-center">*</small>
                                                @error('mobile')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </label>
                                            <input type="text" name="mobile" class="form-control" id="mobile" placeholder="10 Digit Number" required value="{{ old('mobile') }}">
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="password" placeholder="******" required autocomplete="off">
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label for="confirm_password" class="form-label">Confirm Password</label>
                                            <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="****" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-foot6er">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection