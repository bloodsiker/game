@extends('layouts.app-iframe')

@push('head_scripts')
    <script src="{{ asset('js/withdraw.js') }}" type="text/javascript"></script>
@endpush

@section('content')

    <div class="container-fluid">
        <div class="row">
            <ul class="nav nav-tabs">
                <li class='active'><a href="#withdraw" data-toggle="tab" class="text-def">Вывод</a></li>
                <li><a href="#history" class="text-def" data-toggle="tab">История</a></li>
            </ul>
            <br/>
            <div class="tab-content withdraw-content">
                <div class="tab-pane fade in active" id="withdraw">
                    <div id="ContentPlaceHolder1_pnlWithdraw">

                        <div class="well">
                            <span>Минимальный вывод 1.36640000 ETC.</span><br/>
                            <br/>
                            <div class="input-group">
                                <span class="input-group-addon">Сумма на вывод:</span>
                                <input name="ctl00$ContentPlaceHolder1$txtAmount" type="text" value="0.00000000"
                                       id="txtAmount" class="form-control number"/>
                                <span class="input-group-addon">
                            <span id="ContentPlaceHolder1_lblCoin">ETC</span></span>
                            </div>
                            <br/>

                            <div class="input-group" id="">
                                <span class="input-group-addon">Your wallet address:</span>
                                <input name="ctl00$ContentPlaceHolder1$txtAddress" type="text"
                                       value="Your balance is too low." id="ContentPlaceHolder1_txtAddress"
                                       disabled="disabled" class="aspNetDisabled form-control"/>
                            </div>
                        </div>

                        <br/>
                        <input type="submit" name="ctl00$ContentPlaceHolder1$btnSave" value="Выплата"
                               id="ContentPlaceHolder1_btnSave" disabled="disabled"
                               class="aspNetDisabled btn btn-default center-block"/><br/>

                    </div>


                </div>
                <div class="tab-pane fade in" id="history">
                    <table id='history_table' class='table table-striped table-bordered'>
                        <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Сумма</th>
                            <th>Валюта</th>
                            <th>Платежная система</th>
                            <th>Транзакция</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection
