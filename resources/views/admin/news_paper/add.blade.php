@extends('layouts.admin.app')
@section('content')

<div class="row">
    <div class="col-md-8">
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
    <div class="col-md-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route ('admin.dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route ('admin.food.index')}}">Food Category List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Food Category</li>
            </ol>
        </nav>
    </div>
</div>

<div class="mt-1">
    <div class="d-flex justify-content-center">   
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add New Food Category</h6>
            </div>
            <div class="card-body col">
            <div class="col">
            <form action="{{route ('admin.food.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="form-outline mb-2">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-outline mb-2">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control">
                            </div>
                        </div>
                          
                        
                    </div>
                    <div class="row justify-content-end">
                        <div class="d-flex ">
                           <button type="submit" class="btn btn-primary btn-block mb-4">Add Event</button>
                       </div>  
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection