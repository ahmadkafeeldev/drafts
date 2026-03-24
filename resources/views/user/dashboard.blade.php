@extends('layouts.user.app')
@section('title')
Account Details
@endsection
@section('content')
    <style>
      .sidebar ul {
        list-style-type: none;
      }
      a {
        text-decoration: none;
      }
      .sidebar ul > li {
        border-bottom: 2px solid #f3f3f3;
        color: #333;
        font-size: 14px;
        font-weight: 500;
        line-height: normal;
        position: relative;
        padding: 0;
      }
      .sidebar ul > li {
        display: block;
        padding: 3px 0;
        margin-left: -40px;
      }
      .sidebar ul li a {
        line-height: 24px;

        font-size: 15px;
        line-height: 24px;

        color: #333;
        display: block;
        outline: none;
        padding: 10px 0;
        text-decoration: none;
        background: #fbfbfb;
        padding-left: 20px;
      }
      .menu-dashboard {
        border: 2px solid #e8ecec;
        border-radius: 8px;
      }
      .sidebar ul li a span {
        padding-right: 10px;
        vertical-align: middle;
        color: #babebe;
        width: 35px;
        font-size: 22px;
        line-height: 20px;
      }

      /*avatat styling*/
      #avatar-div {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  border-style: solid;
  border-color: #ffd3d3;
  box-shadow: 0 0 8px 3px #B8B8B8;
  position: relative;
  margin: 10px auto;
}

#avatar-div img {
  height: 100%;
  width: 100%;
  border-radius: 50%;
}

#avatar-div i {
  position: absolute;
  top: 5px;
  right: -7px;
  /* border: 1px solid; */
  border-radius: 50%;
  /* padding: 11px; */
  height: 30px;
  width: 30px;
  display: flex !important;
  align-items: center;
  justify-content: center;
  background-color: white;
  /* color: cornflowerblue; */
  color: #fa2964;
  box-shadow: 0 0 8px 3px #B8B8B8;
}
      
</style>
    <div class="row">
        <div class="col-md-12 ">
            @if(session()->has('message'))
                <div class="alert alert-success text-center">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger text-center">
                    {{ session()->get('error') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="login-form">
                <div id="avatar-div">
                    <img src="{{ asset(Auth::user()->profile_image) }}" class="main-profile-img" />
                    <!--<i class="fas fa-edit"></i>-->
                </div>
               
                     <!---------avatar end----------->
                <form action="{{ route('user.update_profile') }}" method="post" enctype="multipart/form-data">
                    @csrf
                  <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                
                  <div class="row">
                  <div class="form-group col-md-6 col-sm-12">
                    <label for="cname">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ Auth::user()->first_name }}" required />
                  </div>
                  
                  <div class="form-group col-md-6 col-sm-12">
                    <label for="phone">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ Auth::user()->last_name }}"required/>
                  </div>
                  
                </div>
                
                <div class="row">
                  <div class="form-group col-md-6 col-sm-12">
                      <label for="company_name">Company Name</label>
                      <input type="text" class="form-control" id="company_name" name="company_name" value="{{ Auth::user()->company_name }}"required/>
                  </div>

                  <div class="form-group col-md-6 col-sm-12">
                      <label for="email">Email Address</label>
                      <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}"required readonly/>
                  </div>
                  
                </div>
                <div class="row">
                    <div class="form-group col-md-12 col-sm-12">
                       <label for="email">Profile Image</label>
                       <input type="file" class="form-control" id="file" name="profile_image"/>
                  </div>
                </div>
                <div class="row justify-content-center">
                    <button type="submit" class="w-100 btn btn-primary">Save</button>
                </div>
                  
                </form>
        </div>
      </div>
    </div>
@endsection

@section('script')

@endsection