@php
    use Carbon\Carbon;
    
    // Parse the effective_at_certain_times date from MySQL
    $effectiveAt = Carbon::parse($booking->effective_at_certain_times);
    $formattedEffectiveAt = $effectiveAt->format('h:i A jS F Y');
    
    $until_time = Carbon::parse($booking->until_time);
    $until_time_formattedEffectiveAt = $until_time->format('h:i A jS F Y');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Download - Draft</title>
    <meta name="author" content="TfL Street Management" />
    <meta name="created" content="2019-07-12T09:43:00" />
    <meta name="changedby" content="Tariq Mehmood" />
    <meta name="changed" content="2024-10-13T12:51:00" />
    <meta name="AppVersion" content="16.0000" />
    <meta name="Company" content="TfL Street Management" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

            <!-- Modal body -->
            <div class="p-4 md:p-5" id="contentModel">
                <div class="p-5 px-10">
                    <div class="flex items-center justify-center mb-3">
                        <h1 class="text-4xl font-bold">{{ $booking->transport_for }}</h1>
                    </div>
                    <div class="flex items-center justify-center mb-3">
                        <h1 class="text-3xl font-bold">PUBLIC NOTICE:</h1>
                    </div>
                    <div class="flex items-center justify-center mb-3">
                        <h1 class="text-3xl font-bold">ROAD TRAFFIC REGULATION ACT 1984</h1>    
                    </div>
                    <div class="flex items-center justify-center mb-2">
                        <h1 class="text-3xl font-bold">{{ $booking->road }}</h1>
                    </div>
                    <div class="container mx-auto">
                        <ol class="list-decimal">
                            <li class="mb-3 text-lg text-gray-800 md:text-xl">
                                    {{ $booking->transport_for }} hereby gives {{ $booking->notice_type }} it made the above named Order, under section 6 
                                    of the Road Traffic Regulation Act 1984. The Order will come into force on {{ \Carbon\Carbon::parse($booking->from_date)->isoFormat('Do MMM YYYY')}}.
                            </li>
                            <li class="mb-3 text-lg text-gray-800 md:text-xl">
                                <span>{{ $booking->transport_for }}</span>, hereby gives notice that it intends to make the above-named Order under section 6 of the Road Traffic Regulation Act 1984.
                            </li>
                            <li class="mb-3 text-lg text-gray-800 md:text-xl">
                                The general nature and effect of the Order will be to {{ $booking->effect_of_the_order }}.
                            </li>
                            <li class="mb-3 text-lg text-gray-800 md:text-xl">
                                The road which would be affected by the Order is {{ $booking->road_affected_by_the_order }}.
                            </li>
                            <li class="mb-3 text-lg text-gray-800 md:text-xl">
                                A copy of the Order, a statement of {{ $booking->transport_for }} reasons for the proposals, and a map indicating the location and effect of the Order can be inspected during normal office hours at the offices of: 
                                <ul class="list-disc ml-4">
                                    <li>{{ $booking->transport_for }} <br /> {{ $booking->proposed_order }}.</li>
                                </ul>
                            </li>
                            
                            @if($booking->notice_type == "Notice of Making")
                                <li class="mb-3 text-lg text-gray-800 md:text-xl">
                                    Any person wishing to question the validity of the Order or of any of its provisions on the grounds that they are not within 
                                    the relevant powers conferred by the Act or that any requirement of the Act has not been complied with, 
                                    that person may, within six weeks from the date on which the Order is made, make application for the purpose to the High Court.
                                </li>
                            @else 
                                <li class="mb-3 text-lg text-gray-800 md:text-xl">
                                    All Objections and other representations to the proposed Order must be made in 
                                    writing and must specify the grounds on which they are made. Objections and representations
                                    must be sent to {{ $booking->objections }} {{ $booking->transport_for }}, {{ $booking->proposed_order }} 
                                    {{ $booking->quoting_reference }}, {{ $booking->road }} {{ \Carbon\Carbon::parse($booking->from_date)->isoFormat('YYYY')}}, to arrive before {{ \Carbon\Carbon::parse($booking->from_date)->isoFormat('YYYY')}}.  
                                    Objections and other representations may be communicated to other persons who may be affected.
                                </li>
                            @endif
                            <p class="mt-4">Dated this {{ \Carbon\Carbon::parse($booking->created_at)->isoFormat('MMM Do YYYY')}}</p>
                            
                            <div>
                                <img src="https://drafts.firstpros.net/{{ $booking->signature }}" alt="{{ $booking->transport_for }}" class="h-24 object-cover my-2 bg-blend-multipl" />
                            </div>
                        </ol>
                    </div>

                        <p class="mt-4 text-base font-bold">Appropriate Person</p>
                        <p class="text-base italic font-bold"><span>{{ $booking->person_title }}</span>, <span class="font-normal">{{ $booking->transport_for }}</span></p>
                        <p class="text-base">{{ $booking->palestra_address }}</p>
                            

                        <p class="mt-4">Gives notice that it has {{ $booking->notice_type }}</p>    
                            
                </div>
                <!-- Share Button -->
                <div class="mt-4 text-center py-4">
                    <button id="shareButton" class="bg-blue-600 text-white py-2 px-4 rounded-lg">Share</button>
                </div>
                
            </div>
            
        </div>
        
    </div>
    
    
        <script>
            document.getElementById('shareButton').addEventListener('click', async () => {
                if (navigator.share) {
                    try {
                        await navigator.share({
                            title: 'Share the Public Notice',
                            text: '{{ $booking->transport_for }} - Public Notice',
                            url: window.location.href
                        });
                    } catch (error) {
                        console.error('Error sharing:', error);
                    }
                } else {
                    alert('Sharing is not supported in this browser.');
                }
            });
        </script>
</body>

</html>
