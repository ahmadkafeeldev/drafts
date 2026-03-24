@extends('layouts.drafts.app')

@section('title', 'Drafts Dashboard')

@section('content')

<div class="row">
    <div class="col-md-12 ">
        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
        @endif
        @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
        @endif
    </div>
</div>

<div class="container mx-auto p-4 py-10">

    <h1 class="text-2xl font-bold tracking-tight text-white-800 sm:text-3xl sm:leading-none mb-10 p-4 rounded">Dashboard</h1>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <a href="#" class="block relative max-w-sm p-6 bg-gray-100 rounded-lg hover:bg-gray-200 transition duration-300 hover:border-gray-100">
            <h3 class="mb-2 text-2xl font-normal tracking-tight text-gray-800">1205</h3>
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-800">Total Pending Drafts</h5>
            <span class="absolute top-8 right-2 inline-flex items-center p-3 rounded-full text-sm font-medium bg-black text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m15 15 6-6m0 0-6-6m6 6H9a6 6 0 0 0 0 12h3" />
                </svg>
            </span>
        </a>

    <a href="#" class="block relative max-w-sm p-6 bg-gray-100 rounded-lg hover:bg-gray-200 transition duration-300 hover:border-gray-100">
        <h3 class="mb-2 text-2xl font-normal tracking-tight text-gray-800">125</h3>
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-800">Total Completed Drafts</h5>
        <span class="absolute top-8 right-2 inline-flex items-center p-3 rounded-full text-sm font-medium bg-black text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m15 15 6-6m0 0-6-6m6 6H9a6 6 0 0 0 0 12h3" />
            </svg>
        </span>
    </a>

    <a href="#" class="block relative max-w-sm p-6 bg-gray-100 rounded-lg hover:bg-gray-200 transition duration-300 hover:border-gray-100">
        <h3 class="mb-2 text-2xl font-normal tracking-tight text-gray-800">105</h3>
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-800">Total Processing Drafts</h5>
        <span class="absolute top-8 right-2 inline-flex items-center p-3 rounded-full text-sm font-medium bg-black text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m15 15 6-6m0 0-6-6m6 6H9a6 6 0 0 0 0 12h3" />
            </svg>
        </span>
    </a>

    <a href="#" class="block relative max-w-sm p-6 bg-gray-100 rounded-lg hover:bg-gray-200 transition duration-300 hover:border-gray-100">
        <h3 class="mb-2 text-2xl font-normal tracking-tight text-gray-800">205</h3>
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-800">Total Rejected Drafts</h5>
        <span class="absolute top-8 right-2 inline-flex items-center p-3 rounded-full text-sm font-medium bg-black text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m15 15 6-6m0 0-6-6m6 6H9a6 6 0 0 0 0 12h3" />
            </svg>
        </span>
    </a>

    </div>
    

</div>


@endsection

@section('script')

@endsection