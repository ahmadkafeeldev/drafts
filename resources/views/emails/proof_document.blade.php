<!DOCTYPE html>
<html>
<body>
    <p>Hi {{$username}},</p>
    <p>{{$content}}</p>

    <p><b>Booking Details:</b></p>
    <p>Booking Title: {{ $booking->title }}</p>
    <p>Publish Date: {{ $booking->publish_date }}</p>
    <p>Booking Type: {{ $booking->booking_type }} {{ $booking->notice_type }}</p>
    <p>Proof Reading Doc Status: {{ $booking->pdf_status }}</p>
    <p></p>
    
    <p>Kindly Visit Your <a href="{{route('home')}}">Dashboard</a> For More Information.</p>
    <p>Thanks</p>
</body>

</html>
