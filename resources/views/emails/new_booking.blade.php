<!DOCTYPE html>
<html>
<body>
    <p>Hi Admin,</p>
    <p>You Have A New Booking.</p><br>
    <p><b>Booking Details:</b></p>
    <p>Client Name: {{ $user->first_name }} {{ $user->last_name }}</p>
    <p>Client Email: {{ $user->email }}</p>
    <p>Booking Title: {{ $booking->title }}</p>
    <p>News Paper: 
        @if(isset($news_paper->name))
            {{ $news_paper->name }}
        @endif
    </p>
    <p>Borough: {{ $borough->name }}</p>
    <p>Publish Date: {{ $booking->publish_date }}</p>
    <p>Booking Type: {{ $booking->booking_type }} {{ $booking->notice_type }}</p>
    <p></p>
    <p>Kindly Visit <a href="{{route('home')}}">Admin Panel</a> For More Information.</p>
    <p>Thanks</p>
</body>

</html>
