@extends('layouts.app-iframe')

@push('head_style')
    <link href="{{ asset('css/fair.css') }}" rel="stylesheet"/>
@endpush

@push('head_scripts')

@endpush

@section('content')
    <form method="post" action="./7248712378?type=3&amp;id=7248712378" id="popup">
        <div class="container-fluid">

            <h4>Номер ставки {{ number_format($dice->id, 0, ',', ',') }}
                <button id="btnCopy" class="btn btn-default" type="button" title="Copy bet URL to clipboard"><i
                        class="fa fa-clipboard" aria-hidden="true"></i></button>
            </h4>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#results" data-toggle="tab">Результат</a></li>
                <li><a href="#fair" data-toggle="tab">Проверка ставки</a></li>
            </ul>

            <div id="ContentPlaceHolder1_pnlDiceId">
                <div class="tab-content">
                    <div class="tab-pane active" id="results">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>Игрок</td>
                                <td>
                                    <input name="user" type="text" value="{{ $dice->user->login }}"
                                           readonly="readonly" id="user"
                                           class="form-control readonly"/>
                                </td>
                            </tr>
                            <tr>
                                <td>ID ставки</td>
                                <td>
                                    <input name="bet" type="text" value="{{ number_format($dice->id, 0, ',', ',') }}"
                                           readonly="readonly" id="bet"
                                           class="form-control readonly"/>
                                </td>
                            </tr>

                            <tr>
                                <td>Дата и время</td>
                                <td>
                                    <input name="ctl00$ContentPlaceHolder1$txtDatetime" type="text"
                                           value="{{ $dice->time_game->format('d.m.Y H:i:s') }}" readonly="readonly"
                                           id="ContentPlaceHolder1_txtDatetime" class="form-control readonly"/>
                                </td>
                            </tr>

                            <tr>
                                <td>Ставка</td>
                                <td>
                                    <div class="input-group">
                                        <input name="bet" type="text" value="{{ $dice->bet }}"
                                               readonly="readonly" id="bet"
                                               class="form-control readonly"/>
                                        <span class="input-group-addon">{{ $dice->currency->name }}</span>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>Цель</td>
                                <td>
                                    <input name="target" type="text" value="{{ $dice->target }}"
                                           readonly="readonly" id="target"
                                           class="form-control readonly"/>
                                </td>
                            </tr>

                            <tr>
                                <td>Выплата</td>
                                <td>
                                    <input name="multiplier" type="text" value="{{ $dice->multiplier }}x"
                                           readonly="readonly" id="multiplier"
                                           class="form-control readonly"/>
                                </td>
                            </tr>

                            <tr>
                                <td>Результат</td>
                                <td>
                                    <input name="roll" type="text" value="{{ $dice->roll }}"
                                           readonly="readonly" id="roll"
                                           class="form-control readonly"/>
                                </td>
                            </tr>

{{--                            <tr>--}}
{{--                                <td>--}}
{{--                                    <div class="cg-tooltip">--}}
{{--                                        <span>Jackpot number*</span>--}}
{{--                                        <span class="cg-tooltip-text">Check FAQ how to win Jackpot</span>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <input name="ctl00$ContentPlaceHolder1$txtJackpotNumber" type="text" value="12"--}}
{{--                                           readonly="readonly" id="ContentPlaceHolder1_txtJackpotNumber"--}}
{{--                                           class="form-control readonly"/>--}}
{{--                                </td>--}}
{{--                            </tr>--}}

                            <tr>
                                <td>Прибыль</td>
                                <td>
                                    <div class="input-group">
                                        <input name="profit" type="text" value="{{ $dice->profit }}"
                                               readonly="readonly" id="profit"
                                               class="form-control readonly"/>
                                        <span class="input-group-addon">{{ $dice->currency->name }}</span>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="fair">

                        <table class="table">
                            <tbody>
                            <tr>
                                <td>Server seed</td>
                                <td>
                                    <input name="ctl00$ContentPlaceHolder1$txtDiceIdServerSeed" type="text"
                                           value="Nw5upFzNk4tnHnCnAbN4MhgV93cEP2MJM8LGYzT0" readonly="readonly"
                                           id="ContentPlaceHolder1_txtDiceIdServerSeed" class="form-control readonly"/>
                                </td>
                            </tr>
                            <tr>
                                <td>Client seed</td>
                                <td>
                                    <input name="ctl00$ContentPlaceHolder1$txtDiceIdClientSeed" type="text"
                                           value="DK8k2BS57TWkMJTNFZ1Tolzr0AfhxhhEn0QRiRnJ" readonly="readonly"
                                           id="ContentPlaceHolder1_txtDiceIdClientSeed" class="form-control readonly"/>
                                </td>
                            </tr>
                            <tr>
                                <td>SHA512 hash</td>
                                <td>
                                    <input name="ctl00$ContentPlaceHolder1$txtDiceIdSha512" type="text"
                                           value="f1d7d97790f974e14b48ac81645dc103c664e01f7128cc5f6106a4cbe90b9e71a14eeaf9df3afcd9d94727eaf03e3f529b2437a410c329b54570be19652e5070"
                                           readonly="readonly" id="ContentPlaceHolder1_txtDiceIdSha512"
                                           class="form-control readonly"/>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <br/>
                        <table class='table table-striped'>
                            <tr>
                                <th>Step:</th>
                                <th>Hex:</th>
                                <th>Decimal:</th>
                                <th>Last digits:</th>
                                <th>Result:</th>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>f1d7d</td>
                                <td>990589</td>
                                <td>90.589</td>
                                <td>90.589</td>
                            </tr>
                        </table>
                        <br/>
                        <span>More info about provably fair system in provably fair tab.</span><br/>
                        <br/>
                        <div>
                            <a href='https://dicesites.com/crypto-games/verifier?game=dice&ss=Nw5upFzNk4tnHnCnAbN4MhgV93cEP2MJM8LGYzT0&cs=DK8k2BS57TWkMJTNFZ1Tolzr0AfhxhhEn0QRiRnJ&ssh=8af5271b50f5f3cc5f15045f2b0dc7cec795c57ea648b822b5ec292056d6e58a'
                               target='_blank' rel='noreferrer noopener'>Third party verifier.</a></div>
                    </div>
                </div>

            </div>

            <script type="text/javascript">
                $(document).ready(function () {
                    $("#btnCopy").click(function (e) {
                        var dummy = document.createElement('input'),
                            text = window.location.href;
                        document.body.appendChild(dummy);
                        dummy.value = text;
                        dummy.select();
                        document.execCommand('copy');
                        document.body.removeChild(dummy);
                    });
                });
            </script>

        </div>


        <script type="text/javascript">
            //<![CDATA[

            theForm.oldSubmit = theForm.submit;
            theForm.submit = WebForm_SaveScrollPositionSubmit;

            theForm.oldOnSubmit = theForm.onsubmit;
            theForm.onsubmit = WebForm_SaveScrollPositionOnSubmit;
            //]]>
        </script>

        @endsection

        @push('scripts')
            <script src="{{ asset('js/register.js') }}" type="text/javascript"></script>
    @endpush
