@component('mail::message')
# {{ ucfirst($event->level) }}

{!! nl2br(e($event->message)) !!}

{{ config('app.name') }}
@endcomponent
