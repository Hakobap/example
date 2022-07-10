<div>
    <p> {{ $name }} of {{ $company }} s business is using {{ $app }} to simplify scheduling and improve your workplace
        communication. </p>
    <p>You have been invited to {{ $app }}, which allows you to view your shifts and timesheets on both smartphone and
        computer.</p>
    <p>To log in, you’ll need to accept your invitation and create a password. To get started, click the link below NOW
        to activate your account:</p>
</div>

<div style="margin-top: 30px;margin-bottom: 30px;">
    <a href="{{ $inviteUrl }}">{{ $inviteUrl }}</a>
</div>

<div>
    <p>If your workplace uses the {{ $app }} Kiosk for iPad, you can login using this PIN: <strong>9729</strong></p>
</div>

<div style="margin-top: 15px;margin-bottom: 30px;">
    <p>Always keep your PIN private. You can change it on {{ $app }} at any time.</p>
</div>

<div>
    <p>Kind Regards,</p>

    <p style="margin-top: 15px;">{{ $app }}</p>
</div>