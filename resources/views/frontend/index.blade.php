@extends('frontend/layout/layout')
@section('section')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2 class="mb-4 text-center">Free Kundli Online</h2>
                <form method="post" action="{{ url('get-kundli') }}">
                  @csrf
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="full_name" class="form-label">Full Name</label>
                      <input type="text" name="full_name" class="form-control" id="full_name" placeholder="Enter full name" required>
                    </div>
                    <div class="col-md-6">
                      <label for="dob" class="form-label">Date of Birth</label>
                      <input type="date" name="dob" class="form-control" id="dob" required>
                    </div>
                    <div class="col-md-6">
                      <label for="tob" class="form-label">Time of Birth</label>
                      <input type="time" class="form-control" id="tob" name="tob" required>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="birth_place" class="form-label">Place of Birth</label>
                      <input type="text" class="form-control" name="birth_place" id="birth_place" placeholder="Enter place of birth" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label d-block">Gender</label>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="gender" id="male" value="male" required>
                          <label class="form-check-label" for="male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                          <label class="form-check-label" for="female">Female</label>
                        </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary w-100">Get Your kundli</button>
                </form>
            </div>
            <div class="col-md-6">
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nobis pariatur assumenda debitis aspernatur dicta iure quia nihil veritatis unde. Distinctio illum tenetur optio incidunt at dicta nesciunt exercitationem. Ad, reprehenderit. <br>
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nobis pariatur assumenda debitis aspernatur dicta iure quia nihil veritatis unde. Distinctio illum tenetur optio incidunt at dicta nesciunt exercitationem. Ad, reprehenderit.
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nobis pariatur assumenda debitis aspernatur dicta iure quia nihil veritatis unde. Distinctio illum tenetur optio incidunt at dicta nesciunt exercitationem. Ad, reprehenderit.
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nobis pariatur assumenda debitis aspernatur dicta iure quia nihil veritatis unde. Distinctio illum tenetur optio incidunt at dicta nesciunt exercitationem. Ad, reprehenderit.<br>
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nobis pariatur assumenda debitis aspernatur dicta iure quia nihil veritatis unde. Distinctio illum tenetur optio incidunt at dicta nesciunt exercitationem. Ad, reprehenderit.
            </div>
        </div>
    </div>
@endsection