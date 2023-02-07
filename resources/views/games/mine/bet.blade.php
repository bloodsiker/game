@extends('layouts.app-iframe')

@push('head_style')
    <link href="{{ asset('css/fair.css') }}" rel="stylesheet"/>
@endpush

@push('head_scripts')

@endpush

@section('content')
    <form method="post" action="" id="popup">
        <div class="container-fluid">

            <h4>Номер ставки {{ number_format($mine->id, 0, ',', ',') }}
                <button id="btnCopy" class="btn btn-default" type="button" title="Copy bet URL to clipboard">
                    <i class="fa fa-clipboard" aria-hidden="true"></i>
                </button>
            </h4>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#results" data-toggle="tab">Результат</a></li>
            </ul>

            <div id="ContentPlaceHolder1_pnlDiceId">
                <div class="tab-content">
                    <div class="tab-pane active" id="results">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>Игрок</td>
                                <td>
                                    <input name="user" type="text" value="{{ $mine->user->login }}"
                                           readonly="readonly" id="user"
                                           class="form-control readonly"/>
                                </td>
                            </tr>
                            <tr>
                                <td>ID ставки</td>
                                <td>
                                    <input name="bet" type="text" value="{{ number_format($mine->id, 0, ',', ',') }}"
                                           readonly="readonly" id="bet"
                                           class="form-control readonly"/>
                                </td>
                            </tr>

                            <tr>
                                <td>Дата и время</td>
                                <td>
                                    <input name="ctl00$ContentPlaceHolder1$txtDatetime" type="text"
                                           value="{{ $mine->time_game->format('d.m.Y H:i:s') }}" readonly="readonly"
                                           id="ContentPlaceHolder1_txtDatetime" class="form-control readonly"/>
                                </td>
                            </tr>

                            <tr>
                                <td>Ставка</td>
                                <td>
                                    <div class="input-group">
                                        <input name="bet" type="text" value="{{ $mine->sum }}"
                                               readonly="readonly" id="bet"
                                               class="form-control readonly"/>
                                        <span class="input-group-addon">{{ $mine->currency->name }}</span>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>Мины</td>
                                <td>
                                    <input name="bet" type="text" value="{{ $mine->mines }}"
                                           readonly="readonly" id="bet"
                                           class="form-control readonly"/>
                                </td>
                            </tr>

                            <tr>
                                <td>Количество мин</td>
                                <td>
                                    <input name="bet" type="text" value="{{ $mine->count_mine }}"
                                           readonly="readonly" id="bet"
                                           class="form-control readonly"/>
                                </td>
                            </tr>

                            <tr>
                                <td>Выбранные поля</td>
                                <td>
                                    <input name="target" type="text" value="{{ $mine->revealed }}"
                                           readonly="readonly" id="target"
                                           class="form-control readonly"/>
                                </td>
                            </tr>

                            <tr>
                                <td>Выплата</td>
                                <td>
                                    <input name="multiplier" type="text" value="{{ $mine->coeff }}x"
                                           readonly="readonly" id="multiplier"
                                           class="form-control readonly"/>
                                </td>
                            </tr>

                            <tr>
                                <td>Прибыль</td>
                                <td>
                                    <div class="input-group">
                                        <input name="profit" type="text" value="{{ $mine->profit }}"
                                               readonly="readonly" id="profit"
                                               class="form-control readonly"/>
                                        <span class="input-group-addon">{{ $mine->currency->name }}</span>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
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
