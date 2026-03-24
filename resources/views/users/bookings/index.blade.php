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
                            <th scope="col" class="px-4 py-3">Relevant Order</th>
                            <th scope="col" class="px-4 py-3">Traffic Order Type</th>
                            <th scope="col" class="px-4 py-3">Notice Type</th>
                            
                            <th scope="col" class="px-4 py-3">Start Time</th>
                            <th scope="col" class="px-4 py-3">End Time</th>
                            <th scope="col" class="px-4 py-3">Start Date</th>
                            <th scope="col" class="px-4 py-3">End Date</th>
                            <th scope="col" class="px-4 py-3">Submission Date</th>
                            
                            <th scope="col" class="px-4 py-3">plan</th>                        
                            <th scope="col" class="px-4 py-3">plan Document</th>
                            <th scope="col" class="px-4 py-3">Work Permit</th>
                            <th scope="col" class="px-4 py-3">Permit Number</th>
                            
                            <th scope="col" class="px-4 py-3">Authourity</th>
                            <th scope="col" class="px-4 py-3">Borough</th>
                            <th scope="col" class="px-4 py-3">Work Place Borough</th>
                            <th scope="col" class="px-4 py-3">101 agreement</th>
                            <th scope="col" class="px-4 py-3">Work Place</th>
                            <th scope="col" class="px-4 py-3">Type of Closure</th>
                            <th scope="col" class="px-4 py-3">Work purpose</th>
                            <th scope="col" class="px-4 py-3">Effect Order Type</th>
                            <th scope="col" class="px-4 py-3">Veicle from</th>
                            <th scope="col" class="px-4 py-3">Prohibition of Traffic</th>
                            <th scope="col" class="px-4 py-3">Order year</th>
                            <th scope="col" class="px-4 py-3">Order Under Section</th>
                            <th scope="col" class="px-4 py-3">Order Type</th>
                            <th scope="col" class="px-4 py-3">Type suspension values</th>
                            <th scope="col" class="px-4 py-3">Place at</th>
                            <th scope="col" class="px-4 py-3">Diversion Plans</th>
                            
                            
                            <th scope="col" class="px-4 py-3">Transport for London</th>
                            <th scope="col" class="px-4 py-3">Road</th>
                            <th scope="col" class="px-4 py-3">Road affected by the order</th>
                            <th scope="col" class="px-4 py-3">Copy of the order</th>
                            <th scope="col" class="px-4 py-3">Reasons for the proposals</th>
                            <th scope="col" class="px-4 py-3">Proposed order</th>
                            <th scope="col" class="px-4 py-3">Objection</th>
                            <th scope="col" class="px-4 py-3">Quoting reference</th>
                            <th scope="col" class="px-4 py-3">Bus Priority</th>
                            
                            <th scope="col" class="px-4 py-3">Appropriate Person Title</th>
                            <th scope="col" class="px-4 py-3">Address</th>
                            <th scope="col" class="px-4 py-3">Signature</th>
                            
                            <th scope="col" class="px-4 py-3">Proof Reading Document</th>
                            <th scope="col" class="px-4 py-3">Proof Document Status</th>
                            <th scope="col" class="px-4 py-3">Document Approved/Reject</th>
                            <th scope="col" class="px-4 py-3">Status</th>
                            <th scope="col" class="px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $key => $booking)
                            <tr class="border-b">
                                <td class="px-4 py-3">{{ $key + 1 }}</td>
                                <td class="px-4 py-3">{{ $booking->relevant_order == "" ? $booking->proposed_installation : $booking->relevant_order }}</td>
                                
                                <td class="px-4 py-3">{{ $booking->booking_type }}</td>
                                <td class="px-4 py-3">{{ $booking->notice_type }}</td>
                                
                                <td class="px-4 py-3">{{ $booking->start_time }}</td>
                                <td class="px-4 py-3">{{ $booking->end_time }}</td>
                                <td class="px-4 py-3">{{ $booking->from_date }}</td>
                                <td class="px-4 py-3">{{ $booking->to_date }}</td>
                                <td class="px-4 py-3">{{ $booking->created_at }}</td>
                                
                                <td class="px-4 py-3">{{ $booking->plan }}</td>
                                <td class="px-4 py-3">
                                    @if($booking->plan_document != Null)
                                    <a href="{{asset($booking->plan_document) }}"target="_blank">View Plan Doc</a>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $booking->work_permit }}</td>
                                <td class="px-4 py-3">{{ $booking->permit_number }}</td>
                                
                                
                                <td class="px-4 py-3">{{ $booking->Authourities }}</td>
                                <td class="px-4 py-3">{{ $booking->borough }}</td>
                                <td class="px-4 py-3">{{ $booking->work_place_borough }}</td>
                                <td class="px-4 py-3">{{ $booking->agreement_101 }}</td>
                                <td class="px-4 py-3">{{ $booking->work_place }}</td>
                                <td class="px-4 py-3">{{ $booking->closure_type }}</td>
                                <td class="px-4 py-3">{{ $booking->work_purpose }}</td>
                                <td class="px-4 py-3">{{ $booking->effect_orders }}</td>
                                <td class="px-4 py-3">{{ $booking->vehicle_from }}</td>
                                <td class="px-4 py-3">{{ $booking->prohibition_traffic }}</td>
                                <td class="px-4 py-3">{{ $booking->order_year }}</td>
                                <td class="px-4 py-3">{{ $booking->order_under_section }}</td>
                                <td class="px-4 py-3">{{ $booking->order_type }}</td>
                                <td class="px-4 py-3">{{ $booking->type_suspension_values }}</td>
                                <td class="px-4 py-3">{{ $booking->place_at }}</td>
                                <td class="px-4 py-3">{{ $booking->diversion_plans }}</td>
                                
                                
                                <td class="px-4 py-3">{{ $booking->transport_for }}</td>
                                <td class="px-4 py-3">{{ $booking->road }}</td>
                                <td class="px-4 py-3">{{ $booking->road_affected_by_the_order }}</td>
                                <td class="px-4 py-3">{{ $booking->copy_of_the_order }}</td>
                                <td class="px-4 py-3">{{ $booking->reasons_for_the_proposals }}</td>
                                <td class="px-4 py-3">{{ $booking->bus_priority }}</td>
                                <td class="px-4 py-3">{{ $booking->proposed_order }}</td>
                                <td class="px-4 py-3">{{ $booking->objections }}</td>
                                <td class="px-4 py-3">{{ $booking->quoting_reference }}</td>
                                
                                
                                <td class="px-4 py-3">{{ $booking->person_title }}</td>
                                <td class="px-4 py-3">{{ $booking->palestra_address }}</td>
                                <td class="px-4 py-3">
                                    @if($booking->signature != Null)
                                    <a href="{{asset($booking->signature) }}"target="_blank">View Signature</a>
                                    @endif
                                </td>
                                
                               
                                
                                <td class="px-4 py-3">
                                    @if($booking->proof_pdf != Null)
                                    <a href="{{asset($booking->proof_pdf) }}"target="_blank">View PDF</a>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $booking->pdf_status }}</td>
                                
                                <th class="px-4 py-3">
                                    <select  class="form-control border p-1 border-dark text-dark" name="update_proof_doc_status" id="update_proof_doc_status" onchange="location = this.options[this.selectedIndex].value;" style="width: 100px;">
                                        <option class="p-1" selected disabled>*Select*</option>
                                        <option class="p-1" value="{{ route('user.update_proof_doc_status', ['booking_id'=>$booking->id,'doc_status'=>'Approved']) }}"> Approved</option>
                                        <option class="p-1" value="{{ route('user.update_proof_doc_status', ['booking_id'=>$booking->id,'doc_status'=>'Reject']) }}">Reject</option>
                                    </select>
                                </th>
                                
                                <td class="px-4 py-3">{{ $booking->status }}</td>
                                
                                
                                <td class="px-4 py-3 flex justify-center items-center gap-2">
                                    <a href="{{ route('user.download', $booking->id) }}" target="_blank" class="block py-2 px-4 bg-green-500 text-white transition-all border border-green-600 rounded">View</a>
                                    <!-- <div class="py-1">-->
                                    <!--    <form action="{{ route('user.destroy', $booking->id) }}" method = "POST">-->
                                    <!--                    {{ csrf_field() }}-->
                                    <!--                    {{ method_field('DELETE') }}-->
                                    <!--                    <button type="submit" class="block bg-red-500 hover:bg-red-600 transition-all py-2 px-4 text-sm text-slate-100 hover:text-white rounded" onclick="return confirm('Do you really want to delete Booking ID: {{ $booking->id }}?')">Delete</button>-->
                                    <!--    </form>-->
                                    <!--</div>-->
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