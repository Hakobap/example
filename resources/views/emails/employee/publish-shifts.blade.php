<div>
    <p>{{ auth()->user()->parent_id ? 'Your employee has changed his shifts.'  : 'Your employer has published your new shifts.' }}</p>
</div>

<div style="margin-top: 30px; margin-bottom: 30px;">
    <a href="{{ url('/') }}">{{ url('/') }}</a>
</div>

<div>
    <p>Kind Regards,</p>

    <p style="margin-top: 15px;">{{ $app }}</p>
</div>