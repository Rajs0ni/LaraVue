@extends('emails.layout.mail',['user' => $user])

@section('content')

<div>
    <br /><br />
    <div
        style='border: ridge black; padding: 70px 0; text-align: center; font-weight: 700; font-size: large;'>
        <span>{!! trans('sk.email_content/access_code',['otp' => $otp]) !!}</span>
    </div>
    <br />
    {!!trans('sk.email/regards')!!},<br /><br />
    <a href='#'>{!!trans('sk.email/team')!!}</a>
</div>

@endsection
