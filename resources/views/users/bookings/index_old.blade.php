@extends('layouts.drafts.app')
@section('content')

<script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a","950":"#172554"}
          }
        },
        fontFamily: {
          'body': [
        'Inter', 
        'ui-sans-serif', 
        'system-ui', 
        '-apple-system', 
        'system-ui', 
        'Segoe UI', 
        'Roboto', 
        'Helvetica Neue', 
        'Arial', 
        'Noto Sans', 
        'sans-serif', 
        'Apple Color Emoji', 
        'Segoe UI Emoji', 
        'Segoe UI Symbol', 
        'Noto Color Emoji'
      ],
          'sans': [
        'Inter', 
        'ui-sans-serif', 
        'system-ui', 
        '-apple-system', 
        'system-ui', 
        'Segoe UI', 
        'Roboto', 
        'Helvetica Neue', 
        'Arial', 
        'Noto Sans', 
        'sans-serif', 
        'Apple Color Emoji', 
        'Segoe UI Emoji', 
        'Segoe UI Symbol', 
        'Noto Color Emoji'
      ]
        }
      }
    }
</script>

@if(isset($message))
    <div class="alert alert-success text-center">
        {{ $message }}
    </div>
@endif



<section class="mt-4">
    <div class="mx-auto max-w-screen-3xl px-4 lg:px-12">
        <!-- Start coding here -->
        <div class="relative sm:rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-slate-300">
                        <tr>
                            <th scope="col" class="px-4 py-3">ID</th>
                            <th scope="col" class="px-4 py-3">Title</th>
                            <th scope="col" class="px-4 py-3">Borough</th>
                            <th scope="col" class="px-4 py-3">Traffic Order Type</th>
                            <th scope="col" class="px-4 py-3">Notice Type</th>
                            <th scope="col" class="px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $key => $booking)
                            <tr class="border-b">
                                <td class="px-4 py-3">{{ $key + 1 }}</td>
                                <td class="px-4 py-3">{{ $booking->relevant_order == "" ? $booking->proposed_installation : $booking->relevant_order }}</td>
                                <td class="px-4 py-3">{{ $booking->borough_id }}</td>
                                <td class="px-4 py-3">{{ $booking->work_type }}</td>
                                <td class="px-4 py-3">{{ $booking->notice_type }}</td>
                                <td class="px-4 py-3 flex justify-center items-center gap-2">
                                    <!--<a href="#" class="block py-2 px-4 hover:text-slate-100 transition-all border border-slate-600 hover:bg-slate-600 rounded">Share</a>-->
                                    <!--<a href="#" class="block py-2 px-4 hover:text-slate-100 transition-all border border-slate-600 hover:bg-slate-600 rounded">Upload</a>-->
                                    <a href="{{ route('user.download', $booking->id) }}" class="block py-2 px-4 hover:text-slate-100 transition-all border border-slate-600 hover:bg-slate-600 rounded">Download</a>
                                     <div class="py-1">
                                        <form action="{{ route('user.destroy', $booking->id) }}" method = "POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" class="block bg-red-500 hover:bg-red-600 transition-all py-2 px-4 text-sm text-slate-100 hover:text-white rounded" onclick="return confirm('Do you really want to delete Booking ID: {{ $booking->id }}?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
    
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

@endsection