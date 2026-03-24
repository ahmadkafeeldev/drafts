@extends('layouts.admin.app')
@section('content')

<div class="row">
    <div class="col-md-12 text-center">
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

<div class="mt-1">
    <div class="d-flex justify-content-center">   
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Update Food Category</h6>
            </div>
            <div class="card-body col">
            <div class="col">
            <form action="{{route ('admin.food.update',$food->id)}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
                <div class="form-outline mb-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-outline mb-2">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" value="{{$food->title}}">
                            </div>
                        </div>
                        
                        
                    </div>
                    
                    
                </div>
                <div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" style="width: 196px;" class="btn btn-primary btn-block mb-4">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection