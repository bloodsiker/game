<!doctype html>
<html class="fixed">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta id="vp" name="viewport" content="width=device-width,initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/CgqVO0jQpd_D3fHKSXQKZ_VwbLA.js') }}"></script>
    <link rel="icon" href="{{ asset('favicon.ico') }}"/>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet"/>
    <link href="{{ asset('js/bootstrap-switch/css/bootstrap3/bootstrap-switch.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('js/datatables/dataTables.bootstrap.css') }}"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css" rel="stylesheet"/>
    <link href="{{ asset('css/popup.css') }}" rel="stylesheet"/>
    <script src="{{ asset('js/jquery-2.1.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap-switch/js/bootstrap-switch.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatables/js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

    @stack('head_style')

    <script type="text/javascript">

        if (screen.width < 750) {
            var mvp = document.getElementById('vp');
            mvp.setAttribute('content', 'width=750');
        }


        $(document).ready(function () {
            $(".number").keyup(function () {
                var start = this.selectionStart;
                var end = this.selectionEnd;
                this.value = this.value.replace(/[^0-9\.]/g, '');
                this.setSelectionRange(start, end);
            });
        });
    </script>

    @stack('head_scripts')

    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer
            type="f6c058ff71eb3d79b70cd59f-text/javascript"></script>
</head>
<body>

@yield('content')

<script src="{{ asset('js/rocket-loader.min.js') }}" data-cf-settings="f6c058ff71eb3d79b70cd59f-|49" defer=""></script>

@stack('scripts')

</body>
</html>
