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
    <div class="bg-gray-50 w-full max-w-6xl text-gray-900 font-sans p-8 rounded-lg">
        <div class="text-center mb-8 flex flex-col gap-2">
            <h1 class="text-3xl font-bold text-blue-900 mb-2">{{ $booking->transport_for }}</h1>
            <p class="text-xl font-semibold">PUBLIC NOTICE</p>
            <p class="text-lg font-bold">{{ $booking->A_10 }} GLA ROAD {{ $booking->borough_id }}</p>
            <p class="text-lg font-bold">{{ $booking->prohibition_traffic }} ORDER {{ $booking->order_year }}</p>
        </div>

        <ul class="list-decimal p-8">
            <li>
                <p class="text-base leading-relaxed">
                    {{ $booking->transport_for }} hereby {{ $booking->notice_type }} has made the above-named Traffic Order under section {{ $booking->order_under_section }} of the Road Traffic Regulation Act 1984 for the purpose specified in paragraph 2.
                </p>
            </li>
            
            <li>
                <p class="text-base leading-relaxed">
                    The purpose of the Order is to enable {{ $booking->work_type == "" ? $booking->work_type : 'No work type provided here' }} works to take place at {{ $booking->place_at }}.
                </p>
            </li>
            
            <li>
                <p class="text-base leading-relaxed">
                    The Order will be effective from {{ $formattedEffectiveAt }} until {{ $until_time_formattedEffectiveAt }} or when the works have been completed, whichever is sooner.
                </p>
            </li>
            
            <li>
                <p class="text-base leading-relaxed">The prohibitions will not apply in respect of:</p>
                <ul class="list-disc ml-4">
                    <li>Any vehicle being used for the purposes of those works or for fire brigade, ambulance, or police purposes;</li>
                    <li>Anything done with the permission or at the direction of a police constable in uniform or a person authorized by {{ $booking->transport_for }}.</li>
                </ul>
            </li>

            <li>
                <p class="text-base leading-relaxed">At such times as the prohibition is in force, an alternative route will be indicated by traffic signs {{ $booking->traffic_signs_via }}.</p>
            </li>

            <p class="mt-4">Dated this {{ $booking->date_day }} day of {{ $booking->date_month }} {{ $booking->date_year }}</p>
            
             @if($booking->notice_type == "Notice of Making")
                <p class="mt-4 text-base font-bold">Appropriate Person</p>
                <p class="text-base italic">Person Title, Transport for London</p>
                <p class="text-base">Palestra, 197 Blackfriars Road, London, SE1 8NJ</p>
            @endif
            
            <div>
                <img src="https://drafts.firstpros.net/{{ $booking->signature }}" alt="{{ $booking->transport_for }}" class="h-24 object-cover my-2 bg-blend-multipl" />
            </div>
        </ul>
        
        <!-- Share Button -->
        <div class="mt-4 text-center">
            <button id="shareButton" class="bg-blue-600 text-white py-2 px-4 rounded-lg">Share</button>
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
    </div>
</body>

</html>
