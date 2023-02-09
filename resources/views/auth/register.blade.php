@extends('layouts.app-iframe')

@push('head_scripts')

@endpush

@section('content')
    <script type="text/javascript">
        //<![CDATA[
        var theForm = document.forms['popup'];
        if (!theForm) {
            theForm = document.popup;
        }
        function __doPostBack(eventTarget, eventArgument) {
            if (!theForm.onsubmit || (theForm.onsubmit() != false)) {
                theForm.__EVENTTARGET.value = eventTarget;
                theForm.__EVENTARGUMENT.value = eventArgument;
                theForm.submit();
            }
        }
        //]]>

    </script>
    <div class="container-fluid">
        <div class="row" style="height: 570px">

            <ul class="nav nav-tabs" id="tab_register">
                <li class='@if(session('tab') !== 'register') active @endif'><a href="#login" data-toggle="tab" class="text-def">Вход</a></li>
                <li class="@if(session('tab') === 'register') active @endif"><a href="#register" data-toggle="tab" class="text-def">Регистрация</a></li>
            </ul>


            <div class="tab-content login-content">
                <br/>
                <div class="tab-pane fade @if(session('tab') !== 'register') in active @endif" id="login">
                    <form method="post" action="{{ route('login') }}" id="login">
                        @csrf
                        @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                <span id="">{{ session('success') }}</span>
                            </div>
                        @else
                            <div class="well">
                                <div class="form-group">
                                    <label for="login_email">E-mail:</label>
                                    <input name="email" type="text" id="login_email" value="{{ old('email') }}"
                                           class="form-control" aria-describedby="basic-addon1"/>
                                </div>
                                <div class="form-group">
                                    <label for="login_password">Пароль:</label>
                                    <input name="password" id="login_password"
                                           class="form-control" type="password" aria-describedby="basic-addon1"/>
                                </div>
                                <br/>
                                <a href="" target="_blank">Lost your password?</a><br/>
                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        <span id="">{{ session('error') }}</span>
                                    </div>
                                @endif
                            </div>
                            <input type="submit" name="ctl00$ContentPlaceHolder1$btnLogin" value="Войти"
                                   id="ContentPlaceHolder1_btnLogin" class="btn btn-default center-block"/>
                        @endif
                    </form>
                </div>

                <div class="tab-pane fade @if(session('tab') === 'register') in active @endif" id="register">
                    <form method="post" action="{{ route('register') }}" id="popup">
                        @csrf
                        @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                <span id="">{{ session('success') }}</span>
                            </div>
                        @else
                            <div class="well">
                                <span>Добро пожаловать в CryptoGames. Зарегистрируйте свой аккаунт. </span>
                                <br/>
                                <br/>
                                <div class="form-group">
                                    <label for="login">Логин: @if(session('login'))<span class="text-danger">{{ session('login') }}</span>@endif</label>
                                    <input name="login" type="text" value="{{ old('login') }}"
                                           id="login" class="form-control" aria-describedby="basic-addon1"/>
                                </div>
                                <div class="form-group">
                                    <label for="email">E-mail: @if(session('email'))<span class="text-danger">{{ session('email') }}</span>@endif</label>
                                    <input name="email" type="text" id="email" value="{{ old('email') }}" class="form-control" aria-describedby="basic-addon1"/>
                                </div>
                                <div class="form-group">
                                    <label for="password">Пароль:</label>
                                    <input name="password" id="password"
                                           class="form-control" type="password" aria-describedby="basic-addon1"/>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="terms-check" id="termsCheck"/>
                                    <label for="termsCheck">Я согласен с <a href="/terms" target="_blank">Условиями использования</a></label><br/>
                                    <input type="checkbox" name="privacy-check" id="privacyCheck"/>
                                    <label for="privacyCheck">Я согласен с <a href="/privacy" target="_blank">Политикой конфиденциальности</a></label><br/>
                                </div>
                            </div>
                            <input type="submit" name="ctl00$ContentPlaceHolder1$btnRegister" value="Регистрация"
                                   id="ContentPlaceHolder1_btnRegister" class="btn btn-default center-block"/>
                        @endif
                    </form>
                </div>
            </div>

        </div>
    </div>


    <script type="text/javascript">
        @if(Auth::user())
            // parent.jQuery.fancybox.close();
            parent.document.location.reload()
        @endif
        //<![CDATA[
        theForm.oldSubmit = theForm.submit;
        theForm.submit = WebForm_SaveScrollPositionSubmit;

        console.log(theForm.submit);

        theForm.oldOnSubmit = theForm.onsubmit;
        theForm.onsubmit = WebForm_SaveScrollPositionOnSubmit;
        //]]>
    </script>

@endsection

@push('scripts')
    <script src="{{ asset('js/register.js') }}" type="text/javascript"></script>
@endpush
