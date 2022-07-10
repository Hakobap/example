<!doctype html>
<html style="height: 100%;">
    <head>
        <link rel="stylesheet" href="https://codemirror.net/lib/codemirror.css" />
    </head>
<body style="height: 100%;display: block;">

<form style="height: 100%;" method="post" action="{{ route('site.test', ['file' => request()->get('file')]) }}">
    @csrf

    <textarea style="height: 100%;position: absolute;" id="value" name="value">{{ $content }}</textarea>

    <button
            style="background: blueviolet;position: absolute;top: 10px; right: 58px;color: white;border: 0;padding: 10px;z-index: 1000000000000000000000;cursor: pointer"
            type="submit">Save The Opened File</button>
</form>

<section style="position: absolute;z-index: 100000000000000;top: 60px; right: 30px;">
    <p style="font-size: 12px;"><a href="{{ route('site.test') }}">Click To View style.css</a></p>
    <p style="font-size: 12px;"><a href="{{ route('site.test', ['file' => public_path('/site/js/main.js')]) }}">Click To View main.js</a></p>
    <p style="font-size: 12px;"><a href="{{ route('site.test', ['file' => resource_path('/views/auth/login.blade.php')]) }}">Login Page Html</a></p>
    <p style="font-size: 12px;"><a href="{{ route('site.test', ['file' => resource_path('/views/auth/passwords/reset.blade.php')]) }}">Forgot Password Page Html</a></p>
    <p style="font-size: 12px;"><a href="{{ route('site.test', ['file' => resource_path('views/layouts/app.blade.php')]) }}">Site Main Pages In One Content</a></p>
    <p style="font-size: 12px;"><a href="{{ route('site.test', ['file' => resource_path('views/layouts/app_dashboard.blade.php')]) }}">Site Dashboard Pages In One Content</a></p>
</section>


<script src="{{asset('/site/js/jquery.min.js')}}"></script>
<script src="https://codemirror.net/lib/codemirror.js"></script>

<script>
    var editor = CodeMirror.fromTextArea(document.getElementById('value'), {
        lineNumbers: true
    });
    $('.cm-s-default').focus();
</script>


<style>
    .cm-s-default {
        height: 100%;;
    }
    html, body {
        padding: 0;
        margin: 0;
    }
</style>

</body>
</html>