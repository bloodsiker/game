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
                                    <td>{{ $currency->name }}</td>
                                    <td>{{ $currency->name }}</td>
                                    <td>{{ Auth::user()->{$currency->code} }}</td>
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
                                    @foreach(auth()->user()->login_histories as $history)
                                        <tr>
                                            <td>{{ $history->created_at->format('Y-m-d H:i:s') }}</td>
                                            <td>{{ $history->ip }}</td>
                                            <td>{{ $history->user_agent }}</td>
                                        </tr>
                                    @endforeach
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
