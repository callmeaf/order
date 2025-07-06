<x-mail::message>
# {{ __('callmeaf-order::api_v1.mail.created.title', ['code' => $code]) }}

{{ __('callmeaf-order::api_v1.mail.created.body') }}

@component('mail::button', ['url' => $url])
{{ __('callmeaf-order::api_v1.mail.created.button') }}
@endcomponent

{{__('callmeaf-order::api_v1.mail.created.footer')}}

{{ config('app.name') }}
</x-mail::message>
