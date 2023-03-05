@extends('layouts.app-iframe')

@push('head_scripts')
    <script src="{{ asset('js/account.js') }}" type="text/javascript"></script>
@endpush

@section('content')

    <div class="container-fluid">

        <div class="row">
            <ul class="nav nav-tabs" id="tab_slot">
                <li class='@if(session('tab') === 'account' || empty(session('tab'))) active @endif'><a href="#account" data-toggle="tab" class="text-def">Аккаунт</a></li>
                <li class="@if(session('tab') === 'security')) active @endif"><a href="#security" data-toggle="tab" class="text-def">Безопасность</a></li>
                <li><a href="#privacy" data-toggle="tab" class="text-def">Конфиденциальность</a></li>
{{--                <li><a href="#api" data-toggle="tab" class="text-def">API</a></li>--}}
                <li><a href="#emergency" data-toggle="tab" class="text-def">Адрес для экстренных случаев</a></li>
{{--                <li><a href="#exclude" data-toggle="tab" class="text-def">Self-Exclusion</a></li>--}}
            </ul>
            <br/>
            <div class="tab-content account-content">
                <div class="tab-pane fade in @if(session('tab') === 'account' || empty(session('tab'))) active @endif" id="account">
                    <form method="post" action="{{ route('account.setting') }}" id="popup">
                        @csrf
                        <input type="hidden" name="action" value="account">
                        <div class="well">
                            @if (session('error_account'))
                                <div class="alert alert-danger" role="alert">
                                    <span>{{ session('error_account') }}</span>
                                </div>
                            @endif

                            @if (session('success_account'))
                                <div class="alert alert-success" role="alert">
                                    <span>{{ session('success_account') }}</span>
                                </div>
                            @endif

                            <div>
                                <div class="input-group">
                                    <span class="input-group-addon fixed-width" id="basic-addon2">Никнейм:</span>
                                    <input name="login" type="text" value="{{ auth()->user()->login }}" id="login"
                                           class="form-control"/>
                                </div>
                            </div>

    {{--                        <div>--}}
    {{--                            <div class="input-group">--}}
    {{--                                <span class="input-group-addon fixed-width"--}}
    {{--                                      id="basic-addon8">Conversion currency:</span>--}}
    {{--                                <button class='btn btn-default dropdown-toggle' data-toggle='dropdown'--}}
    {{--                                        aria-expanded='false'>--}}
    {{--                                    <span id='currency_name'>USD</span>--}}
    {{--                                    <span class='caret'></span>--}}
    {{--                                </button>--}}
    {{--                                <ul class='dropdown-menu pull-right' role='menu'>--}}
    {{--                                    <li><a href='#' data-currency='BTC'>BTC </a></li>--}}
    {{--                                    <li><a href='#' data-currency='EUR'>EUR </a></li>--}}
    {{--                                    <li><a href='#' data-currency='USD'>USD </a></li>--}}
    {{--                                </ul>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
                        </div>


                        <input type="submit" name="ctl00$ContentPlaceHolder1$btnSave" value="Сохранить изменения"
                               id="ContentPlaceHolder1_btnSave" class="btn btn-default center-block"/>

                        <input name="ctl00$ContentPlaceHolder1$txtCurrency" type="text" value="USD" id="txtCurrency" style="visibility: hidden"/>
                    </form>
                </div>

                <div class="tab-pane fade in @if(session('tab') === 'security')) active @endif" id="security">
                    <form method="post" action="{{ route('account.setting') }}" id="popup">
                        @csrf
                        <input type="hidden" name="action" value="security">
                        <div class="well">
                            <span>Здесь вы можете изменить пароль.</span>
                        </div>
                        <div class="well">
                            @if (session('error_security'))
                                <div class="alert alert-danger" role="alert">
                                    <span>{{ session('error_security') }}</span>
                                </div>
                            @endif

                            @if (session('success_security'))
                                <div class="alert alert-success" role="alert">
                                    <span>{{ session('success_security') }}</span>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="email">E-mail address:</label>
                                <input name="email" type="text" value="maldini2@ukr.net"
                                       id="txtMail" disabled="disabled" class="aspNetDisabled form-control"/>
                            </div>

                            <div class="form-group">
                                <label for="email">Пароль:</label>
                                <input name="password" type="text" value="" id="password" class="aspNetDisabled form-control"/>
                            </div>
                        </div>


                        <div>
                            <input type="submit" name="ctl00$ContentPlaceHolder1$btnTwoFactor" value="Add 2FA" id="2fa" class="btn btn-default"/>
                        </div>


                        <br/>


                        <input type="submit" name="ctl00$ContentPlaceHolder1$btnSave1" value="Сохранить изменения"
                               id="ContentPlaceHolder1_btnSave1" class="btn btn-default center-block"/>
                        <br/>
                        <input name="ctl00$ContentPlaceHolder1$txtPassMailing" type="text" value="true" id="txtPassMailing"
                               style="visibility: hidden"/>
                    </form>
                </div>


                <div class="tab-pane fade in " id="privacy">
                    <div class="well">
                        Это расширенная панель конфиденциальности. Здесь вы можете скрыть статистику прибыли из своего профиля и скрыть свой
                        никнейм одним из следующих способов. Если вы скроете свой псевдоним, ваше имя будет
                        отображаться как [Скрыто] на соответствующей вкладке.
                    </div>
                    <div>

                        <div class="well">
                            <div class="input-group">
                                <span class="input-group-addon fixed-width2" id="basic-addon11">Скрыть мою прибыль:</span>
                                <input type="checkbox" name="privacy_profit" checked/>
                            </div>
                            <br/>
                            <div class="input-group">
                                <span class="input-group-addon fixed-width2" id="basic-addon12">Скрыть мой никнейм в больших выиграшах:</span>
                                <input type="checkbox" name="privacy_high"/>
                            </div>
                            <br/>
                            <div class="input-group">
                                <span class="input-group-addon fixed-width2" id="basic-addon13">Скрыть мой никнейм в последних ставках:</span>
                                <input type="checkbox" name="privacy_bets" checked/>
                            </div>
                            <br/>
                            <div class="input-group">
                                <span class="input-group-addon fixed-width2" id="basic-addon15">Скрыть мой ник в топе игроков:</span>
                                <input type="checkbox" name="privacy_stats"/>
                            </div>
                        </div>


                        <input type="submit" name="btn_privacy_save" value="Сохранить изменения" id="" class="btn btn-default center-block"/><br/>
                    </div>
                </div>

{{--                <div class="tab-pane fade in " id="api">--}}
{{--                    <div class="well">--}}
{{--                        API lets developers write their own scripts or bots to bet on our site. API documentation can be--}}
{{--                        found <a href="https://api.crypto.games" target="_blank">here</a>.<br/>--}}
{{--                    </div>--}}
{{--                    <div class="well">--}}
{{--                        <div class="form-group">--}}
{{--                            <br/>--}}
{{--                            <input type="submit" name="ctl00$ContentPlaceHolder1$btnGetKey"--}}
{{--                                   value="Show personal API key" id="ContentPlaceHolder1_btnGetKey"--}}
{{--                                   class="btn btn-default" ReadOnly="true"/>--}}
{{--                            <input type="submit" name="ctl00$ContentPlaceHolder1$btnGetNewKey"--}}
{{--                                   value="Generate new personal API key" id="ContentPlaceHolder1_btnGetNewKey"--}}
{{--                                   class="btn btn-default"/>--}}
{{--                            <br/>--}}
{{--                            <br/>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="tab-pane fade in " id="emergency">
                    <div class="well">
                        В случае возникновения чрезвычайной ситуации все ваши средства будут выведены на ваши аварийные адреса.
                        Если вы не указали какой-либо адрес, мы будем использовать ваши последние использовавшиеся адреса для вывода средств.
                        <br/>
                    </div>
                    <div class="well">
                        <div class="form-group">
                            <label>EthereumClassic аварийный адрес:</label>
                            <input name="ctl00$ContentPlaceHolder1$txtEmergency" type="text" id="txtEmergency"
                                   class="form-control"/><br/>
                            <input type="submit" name="ctl00$ContentPlaceHolder1$btnSaveEmergency"
                                   value="Сохранить аварийный адрес" id="ContentPlaceHolder1_btnSaveEmergency"
                                   class="btn btn-default"/>
                            <br/>
                            <br/>


                        </div>
                    </div>
                </div>


                <div class="tab-pane fade in " id="fork">
                    <div class="well">
                        Please enter your BCH SV address below. More information about the fork and distribution can be
                        found on our blog.<br/>
                    </div>
                    <div class="well">
                        <div class="form-group">
                            <label>BCH SV address:</label>
                            <input name="ctl00$ContentPlaceHolder1$txtFork" type="text" id="txtFork"
                                   class="form-control"/><br/>
                            <input type="submit" name="ctl00$ContentPlaceHolder1$btnSaveFork"
                                   value="Save BCH SV address" id="ContentPlaceHolder1_btnSaveFork"
                                   class="btn btn-default"/>
                            <br/>
                            <br/>


                        </div>
                    </div>
                </div>


{{--                <div class="tab-pane fade in " id="exclude">--}}
{{--                    <div class="well">--}}
{{--                        Should you wish to take a break from gambling, we provide the following options to help you--}}
{{--                        control your gambling including Self-Exclusion.<br/>--}}
{{--                        During your selected period you will be locked out of the Website. This will block you from--}}
{{--                        using all Games on the Website for the period of your choosing.--}}
{{--                    </div>--}}
{{--                    <div class="well">--}}
{{--                        <div class="input-group">--}}
{{--                            <span class="input-group-addon fixed-width" id="basic-addon20">Timeout:</span>--}}
{{--                            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"--}}
{{--                                    aria-expanded="false">--}}
{{--                                <span id="timeout_name">DAYS </span><span class='caret'></span>--}}
{{--                            </button>--}}
{{--                            <ul class="dropdown-menu pull-right" role="menu">--}}
{{--                                <li><a href='#' data-timeout='1' data-name='1 DAY'>1 DAY</a></li>--}}
{{--                                <li><a href='#' data-timeout='5' data-name='7 DAYS'>7 DAYS</a></li>--}}
{{--                                <li><a href='#' data-timeout='30' data-name='30 DAYS'>30 DAYS</a></li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                        <br/>--}}
{{--                        <div class="input-group">--}}
{{--                            <span class="input-group-addon fixed-width" id="basic-addon21">Self-exclude:</span>--}}
{{--                            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"--}}
{{--                                    aria-expanded="false">--}}
{{--                                <span id="exclude_name">MONTHS </span><span class='caret'></span>--}}
{{--                            </button>--}}
{{--                            <ul class="dropdown-menu pull-right" role="menu">--}}
{{--                                <li><a href='#' data-exclude='6' data-name='6 MONTHS'>6 MONTHS</a></li>--}}
{{--                                <li><a href='#' data-exclude='12' data-name='1 YEAR'>1 YEAR</a></li>--}}
{{--                                <li><a href='#' data-exclude='24' data-name='2 YEARS'>2 YEARS</a></li>--}}
{{--                                <li><a href='#' data-exclude='60' data-name='5 YEARS'>5 YEARS</a></li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                        <br/>--}}
{{--                        <input type="submit" name="ctl00$ContentPlaceHolder1$btnExclude" value="Save"--}}
{{--                               id="ContentPlaceHolder1_btnExclude" class="btn btn-default"/>--}}

{{--                        <br/>--}}
{{--                        <br/>--}}


{{--                        <input name="ctl00$ContentPlaceHolder1$txtTimeout" type="text" id="txtTimeout"--}}
{{--                               style="visibility: hidden"/>--}}
{{--                        <input name="ctl00$ContentPlaceHolder1$txtExclude" type="text" id="txtExclude"--}}
{{--                               style="visibility: hidden"/>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>

    </div>


@endsection
