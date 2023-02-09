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
    <form method="post" action="./Tap0K?nickname=Tap0K" id="popup">

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

            <br/>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="user">

                    <div class="well">
                        <div class="row">

                            <div class="col-sm-6">
                                <strong>Member since: </strong><span>{{ auth()->user()->created_at->format('Y-m-d') }} (active days: 843)</span><br/>
                                <strong>Faucet requests: </strong><span>{{ $faucet }}</span><br/>
                                <strong>Friends invited: </strong><span>{{ $invites }}</span><br/>
                            </div>
                            <div class="col-sm-3">
                                <div class="text-center">

                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="text-center">
                                    <h4>
                                        <img src='/images/ranks/rank4.png'
                                             style="max-height: 30px; padding-bottom:5px;"/><br/>
                                        Specialist </h4>
                                    <h3>Tap0K </h3>
                                    <h5 title='To receive Verified tag complete the Tier 3 KYC verification'>Verified <i
                                            class='fa fa-check-circle'></i></h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class='table table-striped'>
                            <tr>
                                <th>Coin/Bet</th>
                                <th>Dice</th>
                                <th>Keno</th>
                                <th>Coin Flip</th>
                                <th>Mines</th>
                                <th>Total wagered</th>
                                <th>Total profit*</th>
                            </tr>
                            @foreach($statistics as $statistic)
                                <tr>
                                    <td><img src="{{ asset('assets/currency/'. $statistic->currency->code . '.png') }}" style='height:18px' title='BitcoinCash'></td>
                                    <td>{{ $statistic->dice }}</td>
                                    <td>{{ $statistic->keno }}</td>
                                    <td>{{ $statistic->coinflip }}</td>
                                    <td>{{ $statistic->mines }}</td>
                                    <td>{{ $statistic->wagered }}</td>
                                    <td>{{ $statistic->profit }}</td>
                                </tr>
                            @endforeach
                        </table>
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
