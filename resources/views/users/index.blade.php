@extends('layouts.drafts.app')

@section('title', 'Public Notice')

@section('styles')

@endsection

@section('content')

<script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
<!--<link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />-->

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>


<!-- Add modal -->
<div id="add-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    Add New Draft
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="add-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <!-- Modal body -->
                <form action="{{ route('user.save_draft') }}" method="POST" enctype="multipart/form-data" >
                    <div class="p-4 md:p-5 space-y-4">
                        @csrf  
                            <p class="mb-3 text-lg flex flex-row items-center justify-between  text-gray-800 w-full gap-3 md:text-xl">
                                <span>Booking Type</span>
                                <input type="text" name="booking_type" class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block w-1/2 mx-2"
                                    placeholder="Type here..." required />
                            </p>
                            
                            <p class="mb-3 text-lg flex flex-row items-center justify-between  text-gray-800 w-full gap-3 md:text-xl">
                                <span>Order Type</span>
                                <input type="text" name="order_type" class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block w-1/2 mx-2"
                                    placeholder="Type here..." required />
                            </p>
                            
                            <p class="mb-3 text-lg flex flex-row items-center justify-between  text-gray-800 w-full gap-3 md:text-xl">
                                <span>Notice Type</span>
                                <input type="text" name="notice_type" class="border-none rounded-full bg-slate-100 text-gray-900 text-lg rounded-lg block w-1/2 mx-2"
                                    placeholder="Type here..." required />
                            </p>
                    </div>
            <!-- Modal footer -->
            <div class="flex items-center gap-3 justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="add-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
            </div>
                           </form>
        </div>
    </div>
</div>

<div class="mx-auto py-4 px-16"y>
    
    @if(session()->has('message'))
            <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
              <span class="font-medium">Success! </span>{{ session()->get('message') }}
            </div>
            @endif
            @if(session()->has('error'))
            <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
              <span class="font-medium">Failure! </span>{{ session()->get('error') }}
            </div>
            @endif
            
            
    <div class="flex flex-wrap justify-between items-center gap-2 mt-10 mb-2">
        <h1 class="text-2xl font-bold mb-4">Drafts List</h1>
        <button data-modal-target="add-modal" data-modal-toggle="add-modal" type="button" class="bg-blue-500 flex items-center text-md text-white rounded-lg p-1 hover:bg-blue-600 transition-all py-2 px-4" data-toggle="modal" data-target="#exampleModal">
            <span>Add New</span>
        </button>
    </div>
    
    @if($drafts->isEmpty())
        <p>No drafts available.</p>
    @else
<table class="table-auto w-full text-left">
    <thead>
        <tr class="bg-black text-white">
            <th class="px-2 py-2 sm:px-4">ID</th>
            <th class="px-2 py-2 sm:px-4">Booking Type</th>
            <th class="px-2 py-2 sm:px-4">Order Type</th>
            <th class="px-2 py-2 sm:px-4">Notice Type</th>
            <th class="px-2 py-2 sm:px-4">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($drafts as $draft)
        <tr>
            <td class="border px-2 py-2 sm:px-4">{{ $draft->id }}</td>
            <td class="border px-2 py-2 sm:px-4">{{ $draft->booking_type }}</td>
            <td class="border px-2 py-2 sm:px-4">{{ $draft->order_type }}</td>
            <td class="border px-2 py-2 sm:px-4">{{ $draft->notice_type }}</td>
            <td class="border px-2 py-2 sm:px-4">
                <div class="flex flex-wrap justify-center items-center gap-2">
                    <div class = "col-md-2 col-6">
                                                    <form action="{{ route('user.destroy', $draft->id) }}" method = "POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type = "submit" name = "submit" value = "submit" data-toggle="tooltip" title="Delete Area" onclick = "return confirm('Do You Really Want to Delete?')" class = "bg-slate-900 text-white rounded-lg p-1 hover:bg-slate-700 transition-all">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                              <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div> 
                    <div class="ml-1">
                        <button type="button" name="edit" class="bg-blue-500 text-white rounded-lg p-1 hover:bg-blue-600 transition-all" data-modal-target="editNewsPaperModalLabel{{ $draft->id }}" data-modal-toggle="editNewsPaperModalLabel{{ $draft->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </button>
                    </div>
                </div>
            </td>
        </tr>

        <!-- Edit Modal -->
        <div id="editNewsPaperModalLabel{{ $draft->id }}" tabindex="-1" class="hidden fixed inset-0 z-50 w-full h-full overflow-auto justify-center items-center">
            <div class="relative p-4 w-full max-w-xl md:max-w-2xl">
                <div class="bg-white rounded-lg shadow">
                    <div class="flex justify-between p-4 md:p-5 border-b">
                        <h3 class="text-lg md:text-xl font-semibold">Edit Draft <span class="bg-blue-500 text-white rounded-full py-1 px-3">{{ $draft->id }}</span></h3>
                        <button type="button" class="text-gray-400 hover:text-gray-900" data-modal-hide="editNewsPaperModalLabel{{ $draft->id }}">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-4 md:p-5">
                        <form action="{{ route('user.draft_update', $draft->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="space-y-3 md:space-y-4">
                                <p class="flex justify-between items-center">
                                    <span class="text-sm md:text-lg">Booking Type</span>
                                    <input type="text" name="booking_type" class="border-none rounded-full bg-slate-100 w-2/3 md:w-1/2" value="{{ $draft->booking_type }}" required />
                                </p>
                                <p class="flex justify-between items-center">
                                    <span class="text-sm md:text-lg">Order Type</span>
                                    <input type="text" name="order_type" class="border-none rounded-full bg-slate-100 w-2/3 md:w-1/2" value="{{ $draft->order_type }}" required />
                                </p>
                                <p class="flex justify-between items-center">
                                    <span class="text-sm md:text-lg">Notice Type</span>
                                    <input type="text" name="notice_type" class="border-none rounded-full bg-slate-100 w-2/3 md:w-1/2" value="{{ $draft->notice_type }}" required />
                                </p>
                            </div>
                            <div class="flex justify-end mt-4">
                                <button type="button" class="text-sm text-gray-900 bg-white border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-100" data-modal-hide="editNewsPaperModalLabel{{ $draft->id }}">Close</button>
                                <button type="submit" class="ml-2 text-white bg-blue-700 px-4 py-2 rounded-lg hover:bg-blue-800">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @endforeach
    </tbody>
</table>

    @endif
</div>

@endsection