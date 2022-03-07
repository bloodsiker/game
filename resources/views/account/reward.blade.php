@extends('layouts.app-iframe')

@push('head_scripts')
    <script type="text/javascript">
        var verifyCallback = function (response) {

        };
        var widgetId1;
        var widgetId2;
        var onloadCallback = function () {

            var correctCaptcha_faucet = function (response) {
                $("#txtRecaptcha1").val(response);
            };
            var correctCaptcha_voucher = function (response) {
                $("#txtRecaptcha2").val(response);
            };

            widgetId1 = grecaptcha.render('recaptcha1', {
                'sitekey': '6LfGZQMTAAAAAFLsy0d1IHi4zzhsow0F95Y2vUOz',
                'theme': 'light',
                'callback': correctCaptcha_faucet
            });

            widgetId2 = grecaptcha.render('recaptcha2', {
                'sitekey': '6LfGZQMTAAAAAFLsy0d1IHi4zzhsow0F95Y2vUOz',
                'theme': 'light',
                'callback': correctCaptcha_voucher
            });


        };

        var Idc = "{{ $currency->idc }}";

        var time = {{ $diff }};

        setInterval(function () {
            time = time + 1;
            if (time < 180) {
                $("#lblTime").text("Обратный отсчет: " + (180 - time).toString() + " секунд.");
            } else {
                $("#lblTime").text("");
            }
        }, 1000);

        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i].trim();
                if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
            }
            return "";
        }


        var LongId = getCookie("LongId");
        getHistory = function (type, longid) {
            $.ajax(
                {
                    type: 'POST',
                    url: '/getFaucetHistory',
                    data: JSON.stringify({type: type, longid: longid}),
                    contentType: "application/json; charset=utf-8",
                    dataType: "html",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (msg) {
                        console.log(msg);
                        if (type == "{{ \App\Models\FaucetHistory::TYPE_F }}") {
                            $("#faucet_history").html(msg);
                            $("#faucet_history_table").dataTable({
                                bFilter: false,
                                bLengthChange: false,
                                iDisplayLength: 12,
                                order: [[0, "desc"]]
                            });
                        } else {
                            $("#other_history").html(msg);
                            $("#other_history_table").dataTable({
                                bFilter: false,
                                bLengthChange: false,
                                iDisplayLength: 11,
                                order: [[0, "desc"]]
                            });
                        }
                    },
                });
        };

        $(document).ready(function () {

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                let target = $(e.target).attr("href");

                if (target == "#history") {
                    getHistory("{{ \App\Models\FaucetHistory::TYPE_F }}", LongId);
                } else if (target == "#other") {
                    getHistory("{{ \App\Models\FaucetHistory::TYPE_F }}", LongId);
                }
            });
        });
    </script>
@endpush

@section('content')
        <div class="container-fluid">

            <div class="row">
                <ul class="nav nav-tabs" id="tab_slot">
                    <li class='@if(!in_array(session('tab'), ['promocode'])) active @endif'><a href="#faucet" data-toggle="tab" class="text-def">Кран</a></li>
                    <li><a href="#levels" data-toggle="tab" class="text-def">Уровень крана</a></li>
                    <li><a href="#history" data-toggle="tab" class="text-def">История крана</a></li>
                    <li><a href="#invite" data-toggle="tab" class="text-def">Пригласить друга</a></li>
                    <li class=" @if(session('tab') === 'promocode') active @endif"><a href="#voucher" data-toggle="tab" class="text-def">Промокод</a></li>
                    <li><a href="#other" data-toggle="tab" class="text-def">Другие награды</a></li>
                </ul>

                <br/>
                <div class="tab-content rewards-content">
                    <div class="tab-pane fade in @if(!in_array(session('tab'), ['promocode'])) active @endif" id="faucet">
                        <form method="post" action="{{ route('account.reward', ['currency' => $currency->idc]) }}" id="popup">
                            @csrf
                            <div class="well">
                                <span>Вы можете запрашивать монеты, когда ваш баланс монет пуст и каждые 3 минуты с одного IP-адреса.</span><br/>
                                <span>Ваш уровень 11. Чтобы увеличить количество кранов, перейдите на вкладку «Уровень крана». У вас осталось 7 запросов на ближайшие 24 часа.</span>
                                <span id="lblTime"></span>
                                <br>
                                <p>Мультиаккаунты, использующие кран, будут заморожены</p>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">Сумма запроса:</span>
                                    <input name="amount" type="text" value="0.10"
                                           readonly="readonly" id="amount" class="form-control"/>
                                    <span class="input-group-addon">
                                    <span id="amount_currency">{{ $currency ? $currency->name : '' }}</span>
                                </span>
                            </div>
                            <br/>

                            @include('components.alert')

                            <input type="submit" name="btnRequest" value="Запрос" id="btnRequest" class="btn btn-default center-block"/><br/>
                        </form>
                    </div>
                    <div class="tab-pane fade in" id="levels">
                        <div class='well'><span>Ваш уровень крана рассчитывается как сумма всех отдельных уровней (столбцов) плюс любые бонусные уровни, на которые вы имеете право.</span>
                        </div>
                        <table class='table table-striped'>
                            <tr>
                                <th>Level</th>
                                <th>Wagered (ETC)</th>
                                <th>Wagered2 (ETC)</th>
                                <th>Referral commission (ETC)</th>
                                <th>Messages on chat</th>
                                <th>Loyalty (days)</th>
                            </tr>
                            <tr>
                                <td>0</td>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span>
                                    0.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span>
                                    0.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span>
                                    0.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span> 0</td>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span> 0</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span>
                                    100.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span>
                                    350.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    0.20000000
                                </td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 800
                                </td>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span> 30</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span>
                                    600.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    1300.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    2.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 1500
                                </td>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span> 90</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    2000.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    6000.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    10.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 5000
                                </td>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span> 120
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    10000.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    50000.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    50.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    10000
                                </td>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span> 180
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    100000.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    150000.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    150.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    30000
                                </td>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span> 365
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    200000.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    300000.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    400.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    60000
                                </td>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span> 730
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    400000.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    500000.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    800.00000000
                                </td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span>
                                    120000
                                </td>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 1460
                                </td>
                            </tr>
                            <br></table>
                        <br>
                        <table class='table table-striped'>
                            <tr>
                                <th>Wagered</th>
                                <th>Wagered2</th>
                                <th>Referral commission</th>
                                <th>Messages on chat</th>
                                <th>Loyalty (days)</th>
                                <th>Verification (Tier 2)</th>
                                <th>VIP</th>
                                <th><b>Total</b></th>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>1</td>
                                <td>0</td>
                                <td>0</td>
                                <td>6</td>
                                <td>2</td>
                                <td>0</td>
                                <td><b>11</b></td>
                            </tr>
                        </table>
                        <br>
                        <table class='table table-striped'>
                            <tr>
                                <th>Level</th>
                                <th>Faucet amount (ETC)</th>
                                <th>Faucet requests in 24h</th>
                                <th>Rank</th>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span> 0</td>
                                <td>0.00066125</td>
                                <td>10</td>
                                <td>Baby</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span> 1</td>
                                <td>0.00079350</td>
                                <td>12</td>
                                <td>Baby</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span> 2</td>
                                <td>0.00092575</td>
                                <td>17</td>
                                <td>Private</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span> 3</td>
                                <td>0.00105800</td>
                                <td>18</td>
                                <td>Private</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span> 4</td>
                                <td>0.00119025</td>
                                <td>19</td>
                                <td>Private</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span> 5</td>
                                <td>0.00132250</td>
                                <td>20</td>
                                <td>Private</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span> 6</td>
                                <td>0.00198375</td>
                                <td>21</td>
                                <td>Private First Class</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span> 7</td>
                                <td>0.00264500</td>
                                <td>22</td>
                                <td>Private First Class</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span> 8</td>
                                <td>0.00330625</td>
                                <td>23</td>
                                <td>Private First Class</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span> 9</td>
                                <td>0.00462875</td>
                                <td>24</td>
                                <td>Specialist</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span> 10</td>
                                <td>0.00595125</td>
                                <td>25</td>
                                <td>Specialist</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-ok text-success' aria-hidden='true'></span> 11</td>
                                <td>0.00727374</td>
                                <td>26</td>
                                <td>Specialist</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 12
                                </td>
                                <td>0.00925749</td>
                                <td>27</td>
                                <td>Corporal</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 13
                                </td>
                                <td>0.01190249</td>
                                <td>28</td>
                                <td>Corporal</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 14
                                </td>
                                <td>0.01454749</td>
                                <td>29</td>
                                <td>Corporal</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 15
                                </td>
                                <td>0.01719249</td>
                                <td>30</td>
                                <td>Sergeant</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 16
                                </td>
                                <td>0.01983748</td>
                                <td>31</td>
                                <td>Sergeant</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 17
                                </td>
                                <td>0.02314373</td>
                                <td>32</td>
                                <td>Sergeant</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 18
                                </td>
                                <td>0.02644998</td>
                                <td>33</td>
                                <td>Staff Sergeant</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 19
                                </td>
                                <td>0.02975622</td>
                                <td>34</td>
                                <td>Staff Sergeant</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 20
                                </td>
                                <td>0.03306247</td>
                                <td>35</td>
                                <td>Staff Sergeant</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 21
                                </td>
                                <td>0.03636872</td>
                                <td>36</td>
                                <td>Sergeant First Class</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 22
                                </td>
                                <td>0.03967497</td>
                                <td>37</td>
                                <td>Sergeant First Class</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 23
                                </td>
                                <td>0.04298121</td>
                                <td>38</td>
                                <td>Master Sergeant</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 24
                                </td>
                                <td>0.04628746</td>
                                <td>39</td>
                                <td>Master Sergeant</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 25
                                </td>
                                <td>0.04959371</td>
                                <td>40</td>
                                <td>First Sergeant</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 26
                                </td>
                                <td>0.05289995</td>
                                <td>41</td>
                                <td>First Sergeant</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 27
                                </td>
                                <td>0.05620620</td>
                                <td>42</td>
                                <td>Sergeant Major</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 28
                                </td>
                                <td>0.05951245</td>
                                <td>43</td>
                                <td>Sergeant Major</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 29
                                </td>
                                <td>0.06281870</td>
                                <td>44</td>
                                <td>Command Sergeant Major</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 30
                                </td>
                                <td>0.06612494</td>
                                <td>45</td>
                                <td>Sergeant Major Of The Army</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 31
                                </td>
                                <td>0.06612494</td>
                                <td>48</td>
                                <td>Lieutenant</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 32
                                </td>
                                <td>0.06612494</td>
                                <td>51</td>
                                <td>Captain</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 33
                                </td>
                                <td>0.06612494</td>
                                <td>54</td>
                                <td>Major</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 34
                                </td>
                                <td>0.06612494</td>
                                <td>57</td>
                                <td>Colonel</td>
                            </tr>
                            <tr>
                                <td><span class='glyphicon glyphicon-remove text-danger' aria-hidden='true'></span> 35
                                </td>
                                <td>0.06612494</td>
                                <td>60</td>
                                <td>Brigadier General</td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane fade in" id="history">
                        <div id="faucet_history">
                            <i class='fa fa-circle-o-notch fa-spin fa-2x fa-fw'></i>
                        </div>
                    </div>
                    <div class="tab-pane fade in " id="invite">
                        <div class="well">
                            <p>Мы предлагаем современную партнерскую систему. Вы всегда будете получать комиссию с каждого пользователя, которого вы привлечете.</p>
                            <p> Зарабатывайте 25% от преимущества казино с каждой ставки, сделанной вашим рефералом.</p>
                            <p>В отличие от традиционных партнерских программ, вы зарабатываете ту же комиссию независимо от того, выиграл игрок или проиграл!</p>
                        </div>
                        <div class="well">
                            <div class="form-group">
                                <label for="Referer">Ваша ссылка для привлечения рефералов:</label>
                                <input id="txtRefID" style="width: 500px;" type="text" class="form-control readonly"
                                       readonly="true" aria-describedby="basic-addon1"
                                       value="https://crypto.games?i=MmYmsKdNaP"/>
                            </div>
                        </div>
                        <div class="well">
                            <input type="submit" name="ctl00$ContentPlaceHolder1$btnCredit"
                                   value="Credit all pending earnings" id="ContentPlaceHolder1_btnCredit"
                                   class="btn btn-default"/><br/>


                            <br/>
                            <span>You have invited </span>
                            <span id="ContentPlaceHolder1_lblFriends">2</span><span> friends and earned:</span><br/>
                            <br/>

                            <span id="ContentPlaceHolder1_lblEarn">
                                <table class='table'><tr class='small'><th>Coin</th><th>Pending earnings</th><th>Dice earned</th><th>Slot earned</th><th>Blackjack earned</th><th>Roulette earned</th><th>Video Poker earned</th><th>Plinko earned</th><th>Minesweeper earned</th></tr> <tr
                                        class='small'><td>Bitcoin</td><td>0.000047120270</td><td>0.00004711</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td></tr><tr
                                        class='small'><td>BitcoinCash</td><td>0.000000000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td></tr><tr
                                        class='small'><td>Dash</td><td>0.000000000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td></tr><tr
                                        class='small'><td>Dogecoin</td><td>0.000000000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td></tr><tr
                                        class='small'><td>Ethereum</td><td>0.000000000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td></tr><tr
                                        class='small'><td>EthereumClassic</td><td>0.000000000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td></tr><tr
                                        class='small'><td>Litecoin</td><td>0.000000000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td></tr><tr
                                        class='small'><td>Monero</td><td>0.000691736920</td><td>0.00069175</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td></tr><tr
                                        class='small'><td>NeoGas</td><td>0.000000000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td></tr><tr
                                        class='small'><td>PlayMoney</td><td>500.819848388400</td><td>37.67499839</td><td>3.50000000</td><td>0.18000000</td><td>5.13000000</td><td>10.31625000</td><td>444.01860000</td><td>0.00000000</td></tr><tr
                                        class='small'><td>Solana</td><td>0.000000000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td><td>0.00000000</td></tr>
                                    </table>
                            </span>
                                <br>

                            <span class="small">Реферальные вознаграждения рассчитываются один раз в час.</span>
                        </div>
                    </div>
                    <div class="tab-pane fade in @if(session('tab') === 'promocode') active @endif" id="voucher">
                        <div class="well">
                            <span>Введите свой промокод, чтобы получить вознаграждение</span>
                        </div>
                        <form action="{{ route('account.promocode') }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <span class="input-group-addon">Промокод:</span>
                                <input name="promocode" type="text" id="promocode" class="form-control" value="" autocomplete="off"/>
                            </div>
                            <br/>

                            @if (session('error_promo'))
                                <div class="alert alert-danger" role="alert">
                                    <span>{{ session('error_promo') }}</span>
                                </div>
                            @endif

                            @if (session('success_promo'))
                                <div class="alert alert-success" role="alert">
                                    <span>{{ session('success_promo') }}</span>
                                </div>
                            @endif

                            <input type="submit" name="" value="Применить"
                                   id="btnRequestVoucher" class="btn btn-default center-block"/>
                        </form>
                    </div>
                    <div class="tab-pane fade in" id="other">
                        <span>The list below shows the tips, rain and other rewards that you have sent or received:</span>
                        <div id="other_history"><br/>
                            <i class='fa fa-circle-o-notch fa-spin fa-2x fa-fw'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/register.js') }}" type="text/javascript"></script>
@endpush
