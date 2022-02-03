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
                                <strong>Member since: </strong><span>10/05/2017 (active days: 843)</span><br/>
                                <strong>Chat messages: </strong><span>44</span><br/>
                                <strong>Faucet requests: </strong><span>3677</span><br/>
                                <strong>Friends invited: </strong><span>2</span><br/>
                                <strong>Tips and rain sent: </strong><span>0</span><br/>
                                <strong>Tips and rain received: </strong><span>16</span><br/>

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
                                <th>Coin / Bets</th>
                                <th>Dice</th>
                                <th>Slot</th>
                                <th>BJ</th>
                                <th>Roulette</th>
                                <th>Video Poker</th>
                                <th>Plinko</th>
                                <th>Mines</th>
                                <th>Total wagered</th>
                                <th>Total profit*</th>
                            </tr>
                            <tr>
                                <td><img src='/index/assets/coins/BCH.png' style='height:18px'
                                         title='BitcoinCash'></img>
                                </td>
                                <td>187,902</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>2.40782970</td>
                                <td>-0.03949430</td>
                            </tr>
                            <tr>
                                <td><img src='/index/assets/coins/BTC.png' style='height:18px' title='Bitcoin'></img>
                                </td>
                                <td>336,922</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>3</td>
                                <td>0.42369736</td>
                                <td>-0.02082627</td>
                            </tr>
                            <tr>
                                <td><img src='/index/assets/coins/DASH.png' style='height:18px' title='Dash'></img></td>
                                <td>2</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0.00067776</td>
                                <td>-0.00022592</td>
                            </tr>
                            <tr>
                                <td><img src='/index/assets/coins/DOGE.png' style='height:18px' title='Dogecoin'></img>
                                </td>
                                <td>262</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>1,226.31413082</td>
                                <td>-218.97860399</td>
                            </tr>
                            <tr>
                                <td><img src='/index/assets/coins/ETC.png' style='height:18px'
                                         title='EthereumClassic'></img></td>
                                <td>927,512</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>23</td>
                                <td>711</td>
                                <td>39</td>
                                <td>731.59316596</td>
                                <td>-13.28076171</td>
                            </tr>
                            <tr>
                                <td><img src='/index/assets/coins/ETH.png' style='height:18px' title='Ethereum'></img>
                                </td>
                                <td>30</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0.02051036</td>
                                <td>-0.00136901</td>
                            </tr>
                            <tr>
                                <td><img src='/index/assets/coins/GAS.png' style='height:18px' title='NeoGas'></img>
                                </td>
                                <td>7,704</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>9.11954284</td>
                                <td>-0.39932669</td>
                            </tr>
                            <tr>
                                <td><img src='/index/assets/coins/LTC.png' style='height:18px' title='Litecoin'></img>
                                </td>
                                <td>3,037</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0.52172321</td>
                                <td>-0.02571970</td>
                            </tr>
                            <tr>
                                <td><img src='/index/assets/coins/PLAY.png' style='height:18px' title='PlayMoney'></img>
                                </td>
                                <td>7,438</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>7</td>
                                <td>22</td>
                                <td>0</td>
                                <td>2,479,627.73294818</td>
                                <td>-172,649.99999999</td>
                            </tr>
                            <tr>
                                <td><img src='/index/assets/coins/SOL.png' style='height:18px' title='Solana'></img>
                                </td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0.00000000</td>
                                <td>0.00000000</td>
                            </tr>
                            <tr>
                                <td><img src='/index/assets/coins/XMR.png' style='height:18px' title='Monero'></img>
                                </td>
                                <td>79,786</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>12.25813862</td>
                                <td>-0.15740625</td>
                            </tr>
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
