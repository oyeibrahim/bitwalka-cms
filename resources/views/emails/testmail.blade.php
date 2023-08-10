@component('mail::message')

    {{ $name }}

    @component('mail::button', ['url' => 'https://laravel.com'])
        Click here
    @endcomponent

@endcomponent
