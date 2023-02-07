@extends('layouts.app-iframe')

@push('head_scripts')
    <script src="{{ asset('js/account.js') }}" type="text/javascript"></script>
@endpush

@section('content')

    <div class="container-fluid">

        <div class="row">
            <ul class="nav nav-tabs" id="tab_slot">
                <li class='active'><a href="#account" data-toggle="tab" class="text-def">Account</a></li>
                <li><a href="#security" data-toggle="tab" class="text-def">Security</a></li>
                <li><a href="#privacy" data-toggle="tab" class="text-def">Privacy</a></li>
                <li><a href="#api" data-toggle="tab" class="text-def">API</a></li>
                <li><a href="#emergency" data-toggle="tab" class="text-def">Emergency address</a></li>
                <li><a href="#avatar" data-toggle="tab" class="text-def">Avatar</a></li>
                <li><a href="#exclude" data-toggle="tab" class="text-def">Self-Exclusion</a></li>
            </ul>
            <br/>
            <div class="tab-content account-content">
                <div class="tab-pane fade in active" id="account">
                    <div class="well">
                        <div>
                            <div class="input-group">
                                <span class="input-group-addon fixed-width" id="basic-addon2">Public nickname:</span>
                                <input name="ctl00$ContentPlaceHolder1$txtNick" type="text" value="Tap0K" id="txtNick"
                                       class="form-control"/>
                            </div>
                        </div>
                        <br/>

                        <div>
                            <div class="input-group">
                                <span class="input-group-addon fixed-width"
                                      id="basic-addon8">Conversion currency:</span>
                                <button class='btn btn-default dropdown-toggle' data-toggle='dropdown'
                                        aria-expanded='false'><span id='currency_name'>USD        </span><span
                                        class='caret'></span></button>
                                <ul class='dropdown-menu pull-right' role='menu'>
                                    <li><a href='#' data-currency='BTC'>BTC </a></li>
                                    <li><a href='#' data-currency='EUR'>EUR </a></li>
                                    <li><a href='#' data-currency='USD'>USD </a></li>
                                </ul>
                            </div>
                        </div>

                        <br/>
                    </div>


                    <input type="submit" name="ctl00$ContentPlaceHolder1$btnSave" value="Save changes"
                           id="ContentPlaceHolder1_btnSave" class="btn btn-default center-block"/>

                    <input name="ctl00$ContentPlaceHolder1$txtCurrency" type="text" value="USD       " id="txtCurrency"
                           style="visibility: hidden"/>
                </div>

                <div class="tab-pane fade in " id="security">
                    <div class="well">
                        <span>We recommend you to setup a password so that your account is more secure.</span>
                    </div>
                    <div class="well">
                        <div class="form-group">
                            <label for="email">E-mail address:</label>
                            <input name="ctl00$ContentPlaceHolder1$txtMail" type="text" value="maldini2@ukr.net"
                                   id="txtMail" disabled="disabled" class="aspNetDisabled form-control"/>
                        </div>
                    </div>


                    <div>
                        <input type="submit" name="ctl00$ContentPlaceHolder1$btnPass" value="Change password"
                               id="ContentPlaceHolder1_btnPass" class="btn btn-default"/>
                        <input type="submit" name="ctl00$ContentPlaceHolder1$btnTwoFactor" value="Add 2FA"
                               id="ContentPlaceHolder1_btnTwoFactor" class="btn btn-default"/>

                    </div>


                    <br/>


                    <input type="submit" name="ctl00$ContentPlaceHolder1$btnSave1" value="Save changes"
                           id="ContentPlaceHolder1_btnSave1" class="btn btn-default center-block"/>
                    <br/>
                    <input name="ctl00$ContentPlaceHolder1$txtPassMailing" type="text" value="true" id="txtPassMailing"
                           style="visibility: hidden"/>
                </div>


                <div class="tab-pane fade in " id="privacy">
                    <div class="well">
                        This is the advanced privacy panel. Here you can choose to hide your profit stats from your
                        profile and hide your nickname from any of the options below. Hiding your nickname will show
                        your name as [Hidden] on their respective tab.
                    </div>
                    <div>

                        <div class="well">
                            <div class="input-group">
                                <span class="input-group-addon fixed-width2" id="basic-addon11">Hide my profit:</span>
                                <input type="checkbox" name="privacy_profit" checked/>
                            </div>
                            <br/>
                            <div class="input-group">
                                <span class="input-group-addon fixed-width2" id="basic-addon12">Hide my nickname in high rolls:</span>
                                <input type="checkbox" name="privacy_high"/>
                            </div>
                            <br/>
                            <div class="input-group">
                                <span class="input-group-addon fixed-width2" id="basic-addon13">Hide my nickname in last bets:</span>
                                <input type="checkbox" name="privacy_bets" checked/>
                            </div>
                            <br/>
                            <div class="input-group">
                                <span class="input-group-addon fixed-width2" id="basic-addon15">Hide my nickname in top players:</span>
                                <input type="checkbox" name="privacy_stats"/>
                            </div>
                        </div>


                        <input type="submit" name="ctl00$ContentPlaceHolder1$btnPrivacySave" value="Save changes"
                               id="ContentPlaceHolder1_btnPrivacySave" class="btn btn-default center-block"/><br/>

                        <input name="ctl00$ContentPlaceHolder1$txtPrivacyProfit" type="text" value="true"
                               id="txtPrivacyProfit" style="visibility: hidden"/>
                        <input name="ctl00$ContentPlaceHolder1$txtPrivacyHigh" type="text" value="false"
                               id="txtPrivacyHigh" style="visibility: hidden"/>
                        <input name="ctl00$ContentPlaceHolder1$txtPrivacyBets" type="text" value="true"
                               id="txtPrivacyBets" style="visibility: hidden"/>
                        <input name="ctl00$ContentPlaceHolder1$txtPrivacyStats" type="text" value="false"
                               id="txtPrivacyStats" style="visibility: hidden"/>
                    </div>
                </div>
                <div class="tab-pane fade in " id="api">
                    <div class="well">
                        API lets developers write their own scripts or bots to bet on our site. API documentation can be
                        found <a href="https://api.crypto.games" target="_blank">here</a>.<br/>
                    </div>
                    <div class="well">
                        <div class="form-group">
                            <br/>
                            <input type="submit" name="ctl00$ContentPlaceHolder1$btnGetKey"
                                   value="Show personal API key" id="ContentPlaceHolder1_btnGetKey"
                                   class="btn btn-default" ReadOnly="true"/>
                            <input type="submit" name="ctl00$ContentPlaceHolder1$btnGetNewKey"
                                   value="Generate new personal API key" id="ContentPlaceHolder1_btnGetNewKey"
                                   class="btn btn-default"/>
                            <br/>
                            <br/>

                        </div>
                    </div>
                </div>

                <div class="tab-pane fade in " id="emergency">
                    <div class="well">
                        In case of any emergency, all your funds will be withdrawn to your emergency addresses. If you
                        haven't set any address, we'll use your last used withdrawal addresses.<br/>
                    </div>
                    <div class="well">
                        <div class="form-group">
                            <label>EthereumClassic emergency address:</label>
                            <input name="ctl00$ContentPlaceHolder1$txtEmergency" type="text" id="txtEmergency"
                                   class="form-control"/><br/>
                            <input type="submit" name="ctl00$ContentPlaceHolder1$btnSaveEmergency"
                                   value="Save emergency address" id="ContentPlaceHolder1_btnSaveEmergency"
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

                <div class="tab-pane fade in " id="avatar">
                    <div class="well">
                        We offer you a chance to set avatar using <a href="https://www.gravatar.com" target="_blank">Gravatar</a>
                        service. Your e-mail address stays private and won't be visible to other players.<br/>
                    </div>
                    <div class="well">
                        <div class="form-group">
                            <label>Gravatar e-mail address:</label>
                            <input name="ctl00$ContentPlaceHolder1$txtAvatar" type="text" id="txtAvatar"
                                   class="form-control"/><br/>
                            <input type="submit" name="ctl00$ContentPlaceHolder1$btnAvatar" value="Save address"
                                   id="ContentPlaceHolder1_btnAvatar" class="btn btn-default"/>
                            <br/>
                            <br/>


                        </div>
                    </div>
                </div>


                <div class="tab-pane fade in " id="exclude">
                    <div class="well">
                        Should you wish to take a break from gambling, we provide the following options to help you
                        control your gambling including Self-Exclusion.<br/>
                        During your selected period you will be locked out of the Website. This will block you from
                        using all Games on the Website for the period of your choosing.
                    </div>
                    <div class="well">
                        <div class="input-group">
                            <span class="input-group-addon fixed-width" id="basic-addon20">Timeout:</span>
                            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false">
                                <span id="timeout_name">DAYS </span><span class='caret'></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href='#' data-timeout='1' data-name='1 DAY'>1 DAY</a></li>
                                <li><a href='#' data-timeout='5' data-name='7 DAYS'>7 DAYS</a></li>
                                <li><a href='#' data-timeout='30' data-name='30 DAYS'>30 DAYS</a></li>
                            </ul>
                        </div>
                        <br/>
                        <div class="input-group">
                            <span class="input-group-addon fixed-width" id="basic-addon21">Self-exclude:</span>
                            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false">
                                <span id="exclude_name">MONTHS </span><span class='caret'></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href='#' data-exclude='6' data-name='6 MONTHS'>6 MONTHS</a></li>
                                <li><a href='#' data-exclude='12' data-name='1 YEAR'>1 YEAR</a></li>
                                <li><a href='#' data-exclude='24' data-name='2 YEARS'>2 YEARS</a></li>
                                <li><a href='#' data-exclude='60' data-name='5 YEARS'>5 YEARS</a></li>
                            </ul>
                        </div>
                        <br/>
                        <input type="submit" name="ctl00$ContentPlaceHolder1$btnExclude" value="Save"
                               id="ContentPlaceHolder1_btnExclude" class="btn btn-default"/>

                        <br/>
                        <br/>


                        <input name="ctl00$ContentPlaceHolder1$txtTimeout" type="text" id="txtTimeout"
                               style="visibility: hidden"/>
                        <input name="ctl00$ContentPlaceHolder1$txtExclude" type="text" id="txtExclude"
                               style="visibility: hidden"/>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection
