@component('mail::message')
# Recover Password

{{ $code }} is your Password recovery code.
<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
