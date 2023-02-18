<x-mail::message>
    # {{trans('email.mail_password_reset_title')}}

    {!! trans('email.mail_password_reset_body',['first_name' => $user->first_name,'last_name' => $user->last_name,'url' => $url]) !!}

    {{ config('app.name') }}
</x-mail::message>
