<!doctype html>
<html class="fixed">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content=""/>

    {{--    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>--}}

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta name='description' content='Best bitcoin dice gambling game. Only 1% house edge and super fast rolls. Progressive jackpot included!'/>
    <meta name='keywords' content='bitcoin dice,bitcoin gambling dice,low house edge dice,jackpot dice,fast dice,popular dice,fast rolls dice'/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
{{--    <script src="{{ asset('js/CgqVO0jQpd_D3fHKSXQKZ_VwbLA.js') }}"></script>--}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
    <link rel="stylesheet" href="{{ asset('js/jquery-ui-1.11.4/jquery-ui.min.css') }}"/>
    <link href="{{ asset('css/chat_7.css') }}" rel="stylesheet"/>
    <link rel="icon" href="{{ asset('favicon.ico') }}"/>
    <link href="{{ asset('css/bootstrap.css?version=new.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/slick.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/slick-theme.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/games.css') }}" rel="stylesheet"/>

    @stack('head_css')

    <link href="{{ asset('js/fancybox/jquery.fancybox.css') }}" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css" rel="stylesheet"/>
    <script src="{{ asset('js/jquery-2.1.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery-ui-1.11.4/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/fancybox/jquery.fancybox.js') }}" type="text/javascript"></script>
{{--    <script src="{{ asset('js/highstock.js') }}" type="text/javascript"></script>--}}

{{--    <script src="{{ asset('js/highstock-theme.js') }}" type="text/javascript"></script>--}}

    @stack('head_scripts')

    <script>
        $(document).ready(function () {

            @if(!auth()->check())
            $.fancybox.open({
                href: "{{ route('register') }}",
                autoscale: false,
                autoDimensions: false,
                width: 500,
                transitionIn: 'none',
                transitionOut: 'none',
                type: 'iframe',
                closeClick: false,
                closeBtn: false,
                openEffect: 'none',
                closeEffect: 'none',
                helpers: {
                    overlay: {
                        closeClick: false,
                    }
                }
            });
            @endif

            if (window.LoggedIn == "True") {
                document.body.classList.add("logged-in")
            }
        });
    </script>

    <script src="{{ asset('js/games.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/js.cookies.js') }}" type="text/javascript"></script>

    @stack('game_scripts')
</head>
<body class="">
    <div class="container-fluid no-transition">
        <div class="row">

            @include('layouts.blocks._header')

            <div id="upper-alert" class="alert alert-info text-center" role="alert" style="display: none;">
                <button type="button" class="close">×</button>
                <span class="text"></span>
            </div>

            @yield('container')

            @include('layouts.blocks._footer')

        </div>
    </div>

@stack('scripts')

</body>
</html>
