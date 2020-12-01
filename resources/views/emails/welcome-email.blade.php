@component('mail::message')
# Welcome to freeCodeGram

The body of your message. BLABLABLA

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
