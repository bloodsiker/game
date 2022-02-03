@extends('layouts.app-iframe')

@push('head_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#login_table').dataTable({
                bFilter: false,
                bLengthChange: false,
                iDisplayLength: 10,
                order: [[0, "desc"]]
            })
        });
    </script>
@endpush

@section('content')
    <form method="post" action="./info" id="popup">
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

            <div class="row">
                <ul class="nav nav-tabs" id="tab_slot">
                    <li class="active"><a href="#stats" data-toggle="tab" class="text-def">Ранг</a></li>
                    <li><a href="#kyc" data-toggle="tab" class="text-def">Verification (KYC)</a></li>
                    <li><a href="#balance" data-toggle="tab" class="text-def">Баланс</a></li>
                    <li><a href="#history" data-toggle="tab" class="text-def">История входов</a></li>
                </ul>

                <br/>
                <div class="tab-content account-content">

                    <div class="tab-pane fade in active" id="stats">
                        <iframe id="frame_stats" src="{{ route('account.player') }}"></iframe>
                    </div>
                    <div class="tab-pane fade in" id="kyc">
                        <div class="well">
                            Completing different verification tiers will unlock additional features and benefits for your
                            account, with each tier giving additional benefits.<br/><br/>
                            In some cases, an account will be flagged for KYC to help the casino assess suspicious activity
                            or to comply with anti-money laundering laws. <br/>If this is the case, you will need to
                            complete the appropriate tier if you wish to carry on using the site.
                        </div>
                        <table class='table table-striped'>
                            <tr>
                                <th>Tier</th>
                                <th>Completed</th>
                                <th>Task</th>
                                <th>Verify</th>
                                <th>Reward</th>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></td>
                                <td>E-mail verification</td>
                                <td></td>
                                <td>Access to deposits and withdraws</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></td>
                                <td>SMS verification</td>
                                <td></td>
                                <td>Receive two extra faucet levels</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span></td>
                                <td>Personal document verification</td>
                                <td></td>
                                <td>No speed limit on dice</td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane fade in" id="balance">
                        <div class="well">
                            <span>В списке ниже показаны все ваши балансы.</span>
                        </div>
                        <table class='table table-striped'>
                            <tr>
                                <th>Валюта</th>
                                <th>Название</th>
                                <th>Баланс</th>
                            </tr>
                            @foreach($currencies as $currency)
                                <tr>
                                    <td>{{ $currency->idc }}</td>
                                    <td>{{ $currency->name }}</td>
                                    <td>0.00000001</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="tab-pane fade in" id="history">
                        <div class="row">
                            <div class="col-xs-12">
                                <table id='login_table' class='table table-striped table-bordered'>
                                    <thead>
                                    <tr>
                                        <th>Дата</th>
                                        <th>IP адрес</th>
                                        <th>User Agent</th>
                                    <tbody>
                                    <tr>
                                        <td>2018-01-09 09:53:57</td>
                                        <td>185.41.248.109</td>
                                        <td>Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_2) Ap</td>
                                    </tr>
                                    <tr>
                                        <td>2018-08-27 09:49:59</td>
                                        <td>109.68.46.238</td>
                                        <td>Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36</td>
                                    </tr>
                                    <tr>
                                        <td>2017-12-05 21:35:59</td>
                                        <td>93.74.107.183</td>
                                        <td>Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_1) Ap</td>
                                    </tr>
                                    <tr>
                                        <td>2018-08-28 19:32:16</td>
                                        <td>93.74.147.1</td>
                                        <td>Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) Ap</td>
                                    </tr>
                                    <tr>
                                        <td>2018-09-17 14:55:30</td>
                                        <td>109.68.46.238</td>
                                        <td>Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36</td>
                                    </tr>
                                    <tr>
                                        <td>2018-09-18 07:33:16</td>
                                        <td>109.68.46.238</td>
                                        <td>Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36</td>
                                    </tr>
                                    <tr>
                                        <td>2018-06-01 07:19:17</td>
                                        <td>109.68.46.238</td>
                                        <td>Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36</td>
                                    </tr>
                                    <tr>
                                        <td>2018-06-05 17:23:20</td>
                                        <td>93.74.147.1</td>
                                        <td>Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) Ap</td>
                                    </tr>
                                    <tr>
                                        <td>2017-05-11 07:20:34</td>
                                        <td>194.44.242.242</td>
                                        <td>Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <script type="text/javascript">
            //<![CDATA[

            theForm.oldSubmit = theForm.submit;
            theForm.submit = WebForm_SaveScrollPositionSubmit;

            theForm.oldOnSubmit = theForm.onsubmit;
            theForm.onsubmit = WebForm_SaveScrollPositionOnSubmit;
            //]]>

        </script>
    </form>
@endsection

@push('scripts')

@endpush
