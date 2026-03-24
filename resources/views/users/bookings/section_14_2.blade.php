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
            <h1 class="text-3xl font-bold text-blue-900 mb-2">@if($booking->borough == "City of London") {{ strtoupper($booking->borough) }} @else LONDON BOROUGH OF {{ strtoupper($booking->borough) }} @endif</h1>
            <p class="text-xl font-semibold">GLA 200- No. ---</p>
            <p class="text-xl font-semibold">PUBLIC NOTICE</p>
            <p class="text-xl font-semibold">ROAD TRAFFIC REGULATION ACT 1984 - SECTION 14(2) </p>
            <p class="text-lg font-bold">{{ strtoupper($booking->work_place) }} (@if($booking->borough == "City of London") {{ strtoupper($booking->borough) }} @else LONDON BOROUGH OF {{ strtoupper($booking->borough) }} @endif)</p>
            <p class="text-lg font-bold">(TEMPORARY PROHIBITION OF TRAFFIC) NOTICE {{ $booking->order_year }}</p>
        </div>

        <ul class="list-decimal p-8">
            <li>
                <p class="text-base leading-relaxed">
                    @if($booking->borough == "City of London") {{ $booking->borough }} @else London Borough of {{ $booking->borough }} @endif hereby gives notice under section {{ $booking->order_under_section }} of the Road Traffic Regulation Act 1984, that [because works are being or are proposed to be executed on or near------------,] [because of the likelihood of danger to the public or of serious damage to the road] [to enable litter clearing and cleaning to be discharged]-----------.
                </p><br>
                
            </li>
            
            
            <li>
                <p class="text-base leading-relaxed">
                    During the period starting at {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} on {{ \Carbon\Carbon::parse($booking->from_date)->isoFormat('Do MMM YYYY')}} and ending {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }} on {{ \Carbon\Carbon::parse($booking->to_date)->isoFormat('Do MMM YYYY')}} or when these works have been completed, whichever is sooner, no person shall cause or permit any vehicle to enter or proceed in [-------------].
                </p><br>
            </li>
            
            <li>
                <p class="text-base leading-relaxed">
                    The restrictions will only apply during such times and to such an extent as is indicated by traffic signs.
                </p><br>
            </li>
            
            
            <li>
                <p class="text-base leading-relaxed">
                    The restrictions will not apply to any vehicle being used for the purpose of those works, or for fire brigade, ambulance or police purposes, or anything done with the permission of or at the direction of a police constable in uniform or a person authorised by {{ $booking->Authourities }}. At such times as the prohibition is in force an alternative route will be indicated by traffic signs: {{ $booking->diversion_plans }}.
                </p><br>
            </li>
            
            <!--<li>-->
            <!--    <p class="text-base leading-relaxed">-->
            <!--        The purpose of the Order is to enable {{ $booking->work_purpose }} works to take place at {{ $booking->place_at }}.-->
            <!--    </p><br>-->
            <!--</li>-->
            
            <!--<li>-->
            <!--    <p class="text-base leading-relaxed">-->
            <!--        The effect of the oder will be {{ $booking->effect_orders }} any vehicle from {{ $booking->type_suspension_values }} on {{ $booking->work_place }}. The Order will be effective at certain times from {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} on {{ \Carbon\Carbon::parse($booking->from_date)->isoFormat('Do MMM YYYY')}} until {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }} on {{ \Carbon\Carbon::parse($booking->to_date)->isoFormat('Do MMM YYYY')}} or when the works have been completed whichever is the sooner.  The prohibition will apply only during such times and to such extent as shall from time to time be indicated by traffic signs.-->
            <!--    </p><br>-->
            <!--</li>-->
            
            <!--<li>-->
            <!--    <p class="text-base leading-relaxed">The prohibitions will not apply in respect of:</p>-->
            <!--    <ul class="list-disc ml-4">-->
            <!--        <li>Any vehicle being used for the purposes of those works or for fire brigade, ambulance, or police purposes;</li>-->
            <!--        <li>Anything done with the permission or at the direction of a police constable in uniform or a person authorized by {{ $booking->Authourities }}.</li>-->
            <!--    </ul>-->
            <!--    <br>-->
            <!--</li>-->

            <!--<li>-->
            <!--    <p class="text-base leading-relaxed">At such times as the prohibition is in force, an alternative route will be indicated by traffic signs: {{ $booking->diversion_plans }}.</p>-->
            <!--</li>-->
            
            <p class="mt-4">Dated this {{ \Carbon\Carbon::parse($booking->created_at)->isoFormat('Do MMM YYYY')}}</p>
            
            
            <p class="mt-4 text-base font-bold">Appropriate Person</p>
            <p class="text-base italic">Person Title: {{ $booking->person_title }}, {{ $booking->Authourities }}</p>
            <p class="text-base">Palestra Address: {{ $booking->palestra_address }}</p>
            
            
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
