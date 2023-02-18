<x-mail::message>
# {{trans('email.mail_password_changed_title')}}

    {!! trans('email.mail_password_changed_body',['first_name' => $user->first_name,'last_name' => $user->last_name]) !!}

    {{ config('app.name') }}
</x-mail::message>
