@component('mail::message')
    __Hi {!! ucwords($data['f_name']) . ucwords($data['l_name']) !!},__<br><br>
    You are receiving this email because we received a password reset request for your account. <br>
    @component('mail::button', ['url' => route('customer.auth.reset-password', $data['token']), 'color' => 'primary'])
        Reset Password
    @endcomponent
    This password reset link will expire in 60 minutes. <br>
    If you did not request a password reset, no further action is required. <br><br>
    @lang('Best Regards'),<br>
    {{ config('app.name') }}
@endcomponent
