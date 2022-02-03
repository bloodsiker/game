@extends('layouts.layout-fluid')

@push('head_scripts')
    <script type="text/javascript">
        var coin = "{{ $currency->idc }}";
        var style = "7";
        var coinname = "{{ $currency->name }}";
        var decimals = "6";
        var conv_currency = "BTC";
        var conv_price = "1.000000000000000000";
        var totalchannels = "5";
        var ratio = "10000000";
        var Balance = {{ auth()->check() ? auth()->user()->getBalance(request()->route('currency')) : 0 }};
        var BalanceCredits = 0;
        var serverTime = "{{ \Carbon\Carbon::now()->getPreciseTimestamp(3) }}";
        var LoggedIn = "{{ auth()->check() ? 'True' : 'False' }}";
        var ShowLogIn = "True";

        $(document).ready(function () {

            @if(!auth()->check())
                $.fancybox.open({
                    href: "{{ route('register') }}",
                    autoscale: false,
                    autoDimensions: false,
                    width: 500,
                    transitionIn: 'none',
                    transitionOut: 'none',
                    type: 'iframe',
                    closeClick: true,
                    closeBtn: true,
                    openEffect: 'none',
                    closeEffect: 'none',
                    helpers: {
                        overlay: {
                            closeClick: false,
                        }
                    }
                });
            @endif

            if (window.LoggedIn == "True") {
                document.body.classList.add("logged-in")
            }
        });
    </script>

    <script type="text/javascript">
        var idc = "{{ $currency->idc }}";
        var coinname = "{{ $currency->name }}";
        var style = "7";
        var maxwin = "500000";
        var minbid = "0.10";
        var effects = "0";
        var edge = "{{ $game->edge }}";
        var conv_price = "1.000000000000000000";
        var conv_currency = "BTC";
        var hotkeys = "";
        var decimals = "6";
        var highrollamount = "5000";
        var maxratio = "9920";
        var gamename = "{{ $game->name }}";
        var coinslist = [];

        if (screen.width < 750) {
            var mvp = document.getElementById('vp');
            mvp.setAttribute('content', 'width=750');
        }

    </script>
@endpush


@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 col-sm-10 col-xs-12 col-lg-offset-0 col-md-offset-2 col-sm-offset-1">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#manual_bet" class="text-def" data-toggle="tab"><i
                            class="fa fa-gamepad fa-lg" aria-hidden="true"></i>Ручная ставка</a></li>
                <li><a href="#auto_bet" class="text-def" data-toggle="tab"><i
                            class="fa fa-android fa-lg" aria-hidden="true"></i>Авто ставки</a></li>
                <li><a href="#how_to_play" class="text-def" data-toggle="tab"><i
                            class="fa fa-info-circle fa-lg" aria-hidden="true"></i>How to play</a></li>
                <li><a href="#provable_fair" class="text-def" data-toggle="tab"><i
                            class="fa fa-balance-scale fa-lg" aria-hidden="true"></i>Provably fair</a></li>
            </ul>

            <div class="tab-content">
                <br/>
                <div class="tab-pane fade in active" id="manual_bet">
                    <div class="well">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
                                <span class="bet_text">Размер ставки:</span><br/>
                                <div class="btn-group" role="group" aria-label="..." style="width: 101%;">
                                    <button id="btnBet1" type="button" class="btn btn-default"
                                            style="width: 25%;">Min
                                    </button>
                                    <button id="btnBet2" type="button" class="btn btn-default"
                                            style="width: 25%;">1/2
                                    </button>
                                    <button id="btnBet3" type="button" class="btn btn-default"
                                            style="width: 25%;">x2
                                    </button>
                                    <button id="btnBet4" type="button" class="btn btn-default"
                                            style="width: 25%;">Max
                                    </button>
                                </div>
                                <div class="input-group">
                                    <input id="txtBet" type="text" class="form-control text-right"/>
                                    <span class="input-group-addon">{{ $currency->name }}</span>
                                </div>
                                <br/>
                                <span class="bet_text">Сумма выигрыша:</span>
                                <div class="input-group">
                                    <input id="txtWinAmount" type="text"
                                           class="form-control text-right form-control-readonly"
                                           readonly="true"/>
                                    <span class="input-group-addon">{{ $currency->name }}</span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
                                <span class="bet_text">Выплата:</span><br/>
                                <div class="btn-group" role="group" aria-label="..." style="width: 101%;">
                                    <button id="btnPay1" type="button" class="btn btn-default"
                                            style="width: 25%;">Min
                                    </button>
                                    <button id="btnPay2" type="button" class="btn btn-default"
                                            style="width: 25%;"><i class="fa fa-minus" aria-hidden="true"></i>
                                    </button>
                                    <button id="btnPay3" type="button" class="btn btn-default"
                                            style="width: 25%;"><i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                    <button id="btnPay4" type="button" class="btn btn-default"
                                            style="width: 25%;">Max
                                    </button>
                                </div>
                                <div class="input-group">
                                    <input id="txtMultiplier" type="text" class="form-control text-right"/>
                                    <span class="input-group-addon">X</span>
                                </div>
                                <br/>
                                <span class="bet_text">Шанс выигрыша:</span>
                                <div class="input-group">
                                    <input id="txtChance" type="text"
                                           class="form-control text-right form-control-readonly"
                                           readonly="true"/>
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="well" style="min-height: 130px;">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                                <button id="btnRollOver" type="button" class="btn btn-default">
                                        <span>Больше<br/>
                                            51.00</span>
                                </button>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                <div id="txtManualResultNumber" class="alert alert-success alert-fit"
                                     role="alert" style="display: none;">
                                    <span></span>
                                </div>
                                <div id="manual_line_loading" class="line_loading">
                                    <i class="fa fa-circle-o-notch fa-2x fa-fw fast-spin"></i>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-left">
                                <button id="btnRollUnder" type="button" class="btn btn-default">
                                        <span>Меньше<br/>
                                            49.00</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="message_line">
                        <div id="divManualMessage" class="alert text-center alert-danger" role="alert"
                             style="display: none;">
                            <p>Check your input parameters.</p>
                        </div>
                        <div id="divConfirmBet" class="alert text-center alert-info" role="alert"
                             style="display: none;">
                            <div class="row">
                                <div class="col-lg-6">
                                    <p>Размер ставки высок.</p>
                                    <input type="checkbox" name="chkConfirmBetAsk" id="chkConfirmBetAsk"/> Не спрашивать меня снова
                                </div>
                                <div class="col-lg-6">
                                    <button id="btnConfirmBet" type="button" class="btn btn-default">Confirm
                                        bet
                                    </button>
                                    <br/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="auto_bet">
                    <div class="well">
                        <div class="row">
                            <div id="auto_bet_left" class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
                                <span class="bet_text">Размер базовой ставки:</span><br/>
                                <div class="btn-group" role="group" aria-label="..." style="width: 101%;">
                                    <button id="btnAutoBet1" type="button" class="btn btn-default"
                                            style="width: 25%;">Min
                                    </button>
                                    <button id="btnAutoBet2" type="button" class="btn btn-default"
                                            style="width: 25%;">1/2
                                    </button>
                                    <button id="btnAutoBet3" type="button" class="btn btn-default"
                                            style="width: 25%;">x2
                                    </button>
                                    <button id="btnAutoBet4" type="button" class="btn btn-default"
                                            style="width: 25%;">Max
                                    </button>
                                </div>
                                <div class="input-group">
                                    <input id="txtAutoBet" type="text" class="form-control text-right"/>
                                    <span class="input-group-addon">{{ $currency->name }}</span>
                                </div>
                                <br/>
                                <span class="bet_text">При победе:</span><br/>
                                <div class="input-group input-group-sm">
                                        <span class="input-group-addon">
                                            <input type="radio" name="rdWin" value="return" aria-label="..."/>
                                        </span>
                                    <input type="text" class="form-control form-control-readonly"
                                           aria-label="..." value="Вернуться к базовой" readonly="true"/>
                                </div>
                                <div class="input-group input-group-sm">
                                        <span class="input-group-addon">
                                            <input type="radio" name="rdWin" value="inc" aria-label="..."/>
                                        </span>
                                    <span class="input-group-addon form-control-readonly">Увеличить ставку на</span>
                                    <input id="txtWinInc" type="text" class="form-control number"
                                           aria-label="..."/>
                                    <span class="input-group-addon">%</span>
                                </div>
                                <div class="input-group input-group-sm">
                                        <span class="input-group-addon">
                                            <input type="radio" name="rdWin" value="dec" aria-label="..."/>
                                        </span>
                                    <span class="input-group-addon form-control-readonly">Уменьшить ставку на</span>
                                    <input id="txtWinDec" type="text" class="form-control number"
                                           aria-label="..."/>
                                    <span class="input-group-addon">%</span>
                                </div>
                                <br/>
                                <span class="bet_text">При проигрыше:</span><br/>
                                <div class="input-group input-group-sm">
                                        <span class="input-group-addon">
                                            <input type="radio" name="rdRoll" value="over" aria-label="..."/>
                                        </span>
                                    <span class="input-group-addon">Больше</span>
                                    <input id="txtAutoRollOver" type="text"
                                           class="form-control form-control-readonly" aria-label="..."
                                           readonly="true"/>
                                </div>
                                <div class="input-group input-group-sm">
                                        <span class="input-group-addon">
                                            <input type="radio" name="rdRoll" value="under" aria-label="..."/>
                                        </span>
                                    <span class="input-group-addon">Меньше</span>
                                    <input id="txtAutoRollUnder" type="text"
                                           class="form-control form-control-readonly" aria-label="..."
                                           readonly="true"/>
                                </div>
                                <div class="input-group input-group-sm">
                                        <span class="input-group-addon">
                                            <input type="radio" name="rdRoll" value="swapwin" aria-label="..."/>
                                        </span>
                                    <input type="text" class="form-control form-control-readonly"
                                           aria-label="..." value="Переключаться больше/меньше при победе" readonly="true"/>
                                </div>
                                <div class="input-group input-group-sm">
                                        <span class="input-group-addon">
                                            <input type="radio" name="rdRoll" value="swaploss" aria-label="..."/>
                                        </span>
                                    <input type="text" class="form-control form-control-readonly"
                                           aria-label="..." value="Переключаться больше/меньше при проигрыше" readonly="true"/>
                                </div>
                                <div class="input-group input-group-sm">
                                        <span class="input-group-addon">
                                            <input type="radio" name="rdRoll" value="swapall" aria-label="..."/>
                                        </span>
                                    <input type="text" class="form-control form-control-readonly"
                                           aria-label="..." value="Переключение больше/меньше после каждой ставки"
                                           readonly="true"/>
                                </div>
                            </div>
                            <div id="auto_bet_right" class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center">
                                <span class="bet_text">Выплата:</span><br/>
                                <div class="btn-group" role="group" aria-label="..." style="width: 101%;">
                                    <button id="btnAutoPay1" type="button" class="btn btn-default"
                                            style="width: 25%;">Min
                                    </button>
                                    <button id="btnAutoPay2" type="button" class="btn btn-default"
                                            style="width: 25%;"><i class="fa fa-minus" aria-hidden="true"></i>
                                    </button>
                                    <button id="btnAutoPay3" type="button" class="btn btn-default"
                                            style="width: 25%;"><i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                    <button id="btnAutoPay4" type="button" class="btn btn-default"
                                            style="width: 25%;">Max
                                    </button>
                                </div>
                                <div class="input-group">
                                    <input id="txtAutoMultiplier" type="text"
                                           class="form-control text-right number"/>
                                    <span class="input-group-addon">X</span>
                                </div>
                                <br/>
                                <span class="bet_text">При проигрыше</span><br/>
                                <div class="input-group input-group-sm">
                                        <span class="input-group-addon">
                                            <input type="radio" name="rdLoss" value="return" aria-label="..."/>
                                        </span>
                                    <input type="text" class="form-control form-control-readonly"
                                           aria-label="..." value="Вернуться к базовой" readonly="true"/>
                                </div>
                                <div class="input-group input-group-sm">
                                        <span class="input-group-addon">
                                            <input type="radio" name="rdLoss" value="inc" aria-label="..."/>
                                        </span>
                                    <span class="input-group-addon form-control-readonly">Увеличить ставку на</span>
                                    <input id="txtLossInc" type="text" class="form-control number"
                                           aria-label="..."/>
                                    <span class="input-group-addon">%</span>
                                </div>
                                <div class="input-group input-group-sm">
                                        <span class="input-group-addon">
                                            <input type="radio" name="rdLoss" value="dec" aria-label="..."/>
                                        </span>
                                    <span class="input-group-addon form-control-readonly">Уменьшить ставку на</span>
                                    <input id="txtLossDec" type="text" class="form-control number"
                                           aria-label="..."/>
                                    <span class="input-group-addon">%</span>
                                </div>
                                <br/>
                                <span class="bet_text">Лимиты:</span><br/>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon form-control-readonly">Количество роллов:</span>
                                    <input id="txtMaxRolls" type="text" class="form-control number"
                                           aria-label="..."/>
                                </div>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon form-control-readonly">Ролл каждые</span>
                                    <input id="txtRollSec" type="text" class="form-control number"
                                           aria-label="..."/>
                                    <span class="input-group-addon">миллисекунды (мин)</span>
                                </div>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon form-control-readonly">Остановиться, если баланс выше</span>
                                    <input id="txtLargerThan" type="text" class="form-control number"
                                           aria-label="..."/>
                                    <span class="input-group-addon">{{ $currency->name }}</span>
                                </div>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon form-control-readonly">Остановиться, если баланс ниже</span>
                                    <input id="txtSmallerThan" type="text" class="form-control number"
                                           aria-label="..."/>
                                    <span class="input-group-addon">{{ $currency->name }}</span>
                                </div>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon form-control-readonly">Максимальный размер ставки</span>
                                    <input id="txtMaxBet" type="text" class="form-control number"
                                           aria-label="..."/>
                                    <span class="input-group-addon">{{ $currency->name }}</span>
                                </div>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon form-control-readonly">Минимальный размер ставки</span>
                                    <input id="txtMinBet" type="text" class="form-control number"
                                           aria-label="..."/>
                                    <span class="input-group-addon">{{ $currency->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="well">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-2 col-xs-2 text-right">
                                <button id="btnStart" type="button" class="btn btn-default"><span>Старт</span>
                                </button>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-8 text-center">
                                <div class="input-group" id="profit_group">
                                    <span class="input-group-addon form-control-readonly">Прибыль:</span>
                                    <input id="txtProfit" type="text" class="form-control readonly"
                                           aria-label="..." readonly="true"/>
                                    <span class="input-group-addon">{{ $currency->name }} <i id="auto_line_loading"
                                                                                             class="fa fa-circle-o-notch fa-spin fa-fw"></i></span>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-2 col-xs-2 text-left">
                                <button id="btnStop" type="button" class="btn btn-default"><span>Стоп</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div id="divAutoMessage" class="alert alert-danger" role="alert" style="display: none;">
                            <p>Check your input parameters.</p>
                        </div>
                        <div id="divAutoTimeout" class="alert alert-warning" role="alert"
                             style="display: none;">
                            <p>Couldn't connect to server, please try again</p>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="how_to_play">
                    <div class="well">
                        <h5>Bet amounts:</h5>
                        <ul>
                            <li>Maximum bet amount is: 20.00 Bitcoin</li>
                            <li>Maximum win amount per bet is: 2.00 Bitcoin</li>
                        </ul>
                    </div>


                    <div class="well">
                        <h5>How can I win the Jackpot?</h5> You can win the Jackpot when your dice bet meets ALL
                        of the following criteria:
                        <ul>
                            <li>Dice roll is a winning roll of 7.777 or 77.777<br></li>
                            <li>Last two digits of Server seed + client seed combined and encrypted in SHA512
                                are 77 (the Jackpot number if you click on betID)<br></li>
                            <li>Bet amount and profit have to be at least 0.00000150 Bitcoin.<br></li>
                            <li>You will receive 100% of the Jackpot if win amount is above 0.0040 Bitcoin. If
                                win amounts is lower, you will receive a proportional share of the Jackpot with
                                the minimum set to 1%.
                            </li>
                        </ul>
                    </div>

                    <div class="well">
                        <h5>Как увеличить скорость ставок?</h5>
                        Ставки 0,00001 биткойн или выше будут иметь приоритет в скорости вашей ставки. По мере того, как сумма
                        вашей ставки приближается к минимальной ставке монеты, скорость вашей ставки будет уменьшаться.
                        Проще говоря: чем большую сумму вы играете, тем быстрее сервер обработает ваш результат.
                        В качестве альтернативы, завершив процесс проверки и заполнив Tier3 KYC.
                    </div>

                    <div class="well">
                        <h5>Что это за игра?</h5>
                        Эта игра называется Dice, но это не обычная игра на удачу и вероятность, в которой используется простой куб
                        с пронумерованными сторонами. Вместо этого это крипто-ориентированная игра в кости, в которой у вас есть больший
                        диапазон и более высокая точность потенциальных результатов (0,000–99,999). Ваша задача состоит в том, чтобы предсказать,
                        будет ли счастливое число, которое выпадет на кости, больше или меньше определенной цифры. Если вы новичок в Dice и
                        совершенно не знаете, как играть в эту игру, мы объяснили основы ниже.
                    </div>


                    <div class="well">
                        <h5>How to play?</h5> The following is a brief explanation on how to play Dice on
                        CryptoGames:<br>
                        <ol>
                            <li>Deposit funds to your personal deposit address and wait for one confirmation. As
                                soon as we receive the transaction, you can start gambling.
                            </li>
                            <li>Select the amount you want to wager in one bet and enter that amount in the “Bet
                                Size” field.
                            </li>
                            <li>Select your payout multiplier, but remember, the chance of winning the bet
                                depends on your payout, so choose wisely. This is your lucky number. You can
                                select this within the range of 0.000 to 99.999. The gist here is to ensure that
                                this digit will just be perfect to match your prediction.
                            </li>
                            <li>Now two numbers are shown to you. There is one number to roll high (over the
                                shown number) and one to roll low (below the number shown). You have to decide
                                whether to play high or low.
                            <li>A number is rolled after you have made your prediction and pressed roll over or
                                under. Numbers can go from 0.000 to 99.999. If the number within the range you
                                picked, you win the bet and receive the payout shown to you. If the number is
                                not within your predicted range, your bet is lost and you lose the amount
                                wagered.
                            </li>
                        </ol>
                    </div>


                    <div class="well">
                        <h5>Горячие клавиши:</h5>
                        Если вы хотите их использовать, есть несколько сочетаний клавиш, перечисленных ниже:
                        <ul>
                            <li><i>Roll High</i> [H], <i>Roll Low</i> [L]<br></li>
                            <li><i>Bet size:</i> Min [Q], 1/2 [W], x2 [E], Max [R]<br></li>
                            <li><i>Payout:</i> Min [A], -1 [S], +1 [D], Max [F]</li>
                        </ul>
                    </div>
                </div>
                <div class="tab-pane fade" id="provable_fair">
                    <div class="well">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">Last server seed SHA256:</span>
                            <input readonly="readonly" id="txtLastServerSeed256" type="text"
                                   class="form-control"/>
                        </div>
                        <br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">Last server seed:</span>
                            <input readonly="readonly" id="txtLastServerSeed" type="text" class="form-control"/>
                        </div>
                        <br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">Last client seed:</span>
                            <input readonly="readonly" id="txtLastClientSeed" type="text"
                                   class="form-control readonly"/>
                        </div>
                        <br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">Next server seed SHA256:</span>
                            <input readonly="readonly" id="txtNextServerSeed256" type="text"
                                   class="form-control readonly"/>
                        </div>
                        <br/>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon">Next client seed:</span>
                            <input id="txtNextClientSeed" type="text" class="form-control" readonly
                                   placeholder="Type in your client seed"/>
                            <span class="input-group-btn">
                                        <button id="btnRandomSeed" class="btn btn-default" data-toggle="tooltip"
                                                data-placement="top" title="Your computer generates new random seed"
                                                type="button">Randomize</button>
                                    </span>
                        </div>
                        <br/>
                        <input type="checkbox" id="chkManualSeed" style="margin-left: 3em"/>
                        I understand the risks, I want to manually change my client seed
                        <div id="divManualSeedNonce" style="display: none;">
                            <input type="checkbox" id="chkManualSeedNonce" style="margin-left: 3em"/>
                            I wish to add nonce
                        </div>
                    </div>
                    <div class="well">
                        <h5>What is provable fairness and how does it work?</h5>
                        Provable fairness is a technology facilitated by cryptocurrency and blockchain
                        technology that makes it impossible for a player or casino to cheat. You no longer have
                        to be suspicious of the house for bets lost. So, whatever game you are playing, you can
                        be confident that the result is fair and accurate given the provable fairness of our
                        gambling platform.
                        To check each bet, you can click on the BetID where you will be given more detailed
                        information for each individual bet.

                        <p>
                            <u>Seeds</u> are generated strings that are used for cryptographic purposes. The
                            list below explains the seeds used in our process.<br/>
                            (Seed labels italicized for some reason in Dice tab)<br/>
                            <i>Last server seed SHA256:</i> Last seed generated on our side (encrypted
                            SHA256)<br/>
                            <i>Last server seed:</i> Last server seed generated by our side<br/>
                            <i>Last client seed:</i> Last client seed generated on your side<br/>
                            <i>Next server seed SHA256:</i> Next server seed (encrypted SHA256)<br/>
                            <i>Next client seed:</i> Your next client seed<br/>
                            <i>SHA512 hash:</i> Server seed and client seed combined and encrypted in
                            SHA512<br/>
                            <br/>
                            To check if your last bet was truly fair, go to an online <a
                                title="SHA512 generator" href="http://www.miniwebtool.com/sha512-hash-generator"
                                target="_blank">SHA512 generator</a>, copy and paste the Server and Client seed
                            to receive the SHA512 hash.<br/>
                            Next, convert the first five characters from <a title="Hexadecimal to Decimal"
                                                                            href="http://www.binaryhexconverter.com/hex-to-decimal-converter"
                                                                            target="_blank">Hexadecimal to
                                Decimal</a> and you'll receive six numbers. Take the last five numbers and you have
                            the Dice result. If there are more than six numbers, this step is skipped the next
                            five characters from the Hexadecimal string are used.<br/>
                            <br/>
                            A video about the provably fair system we use <a
                                href="https://www.youtube.com/watch?v=oG3BgALUHRc" target="_blank">Youtube</a>.
                        </p>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <ul class="nav nav-tabs " id="tab_result">
                <li class="active">
                    <a href="bitcoin.html#last_bets" class="fixed-tabs" data-toggle="tab"><i
                            class="fa fa-users fa-lg" aria-hidden="true"></i>Все ставки <span id="allbets_pause"
                                                                                              class="glyphicon glyphicon-pause"
                                                                                              aria-hidden="true"></span>
                    </a>
                </li>
                <li><a href="bitcoin.html#my_bets" class="fixed-tabs" data-toggle="tab"><i
                            class="fa fa-user fa-lg" aria-hidden="true"></i>Мои ставки <span id="yourbets_pause"
                                                                                             class="glyphicon glyphicon-pause"
                                                                                             aria-hidden="true"></span></a>
                </li>
                <li><a href="bitcoin.html#high_rollers" class="fixed-tabs" data-toggle="tab"><i
                            class="fa fa-star fa-lg" aria-hidden="true"></i>Высокие роллы <span class="badge"
                                                                                                id="badge_high_roller"></span></a>
                </li>
                <li><a href="bitcoin.html#jackpots" class="fixed-tabs" data-toggle="tab"><i
                            class="fa fa-diamond fa-lg" aria-hidden="true"></i>Джекпоты <span class="badge"
                                                                                              id="badge_jackpot"></span></a>
                </li>
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle fixed-tabs" data-toggle="dropdown" href="bitcoin.html#"
                       role="button" aria-expanded="false"><i class="fa fa-pie-chart fa-lg"
                                                              aria-hidden="true"></i>Статистика <span
                            class="caret"></span></a>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <li><a href="bitcoin.html#statistic" data-toggle="tab"><i class="fa fa-line-chart fa-fw"
                                                                                  aria-hidden="true"></i>Dice
                                data</a></li>
                        <li><a href="bitcoin.html#statistic_graph" data-toggle="tab"><i
                                    class="fa fa-pie-chart fa-fw" aria-hidden="true"></i>All charts</a></li>

                    </ul>
                </li>

                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle fixed-tabs" data-toggle="dropdown" href="bitcoin.html#"
                       role="button" aria-expanded="false"><i class="fa fa-trophy fa-lg" aria-hidden="true"></i>Лучшие игроки
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <li><a href="bitcoin.html#mostwagered" data-toggle="tab"><i
                                    class="fa fa-line-chart fa-fw" aria-hidden="true"></i>Most wagered</a></li>
                        <li><a href="bitcoin.html#mostbids" data-toggle="tab"><i class="fa fa-bar-chart fa-fw"
                                                                                 aria-hidden="true"></i>Most
                                bids</a></li>
                        <li><a href="bitcoin.html#mostprofit" data-toggle="tab"><i class="fa fa-money fa-fw"
                                                                                   aria-hidden="true"></i>Most
                                profit</a></li>
                        <li><a href="bitcoin.html#mosttips" data-toggle="tab"><i class="fa fa-gift fa-fw"
                                                                                 aria-hidden="true"></i>Most
                                tips dealt</a></li>
                        <li><a href="bitcoin.html#mostchat" data-toggle="tab"><i class="fa fa-comment-o fa-fw"
                                                                                 aria-hidden="true"></i>Most
                                chat messages</a></li>
                    </ul>
                </li>
            </ul>

            <div class="tab-content div_table">
                <div class="tab-pane fade in active" id="last_bets">
                    <br/>
                    <div class="bets">
                        <table class="table table-striped table_bets_no_effects" id="table_last_bets">
                            <tr id="table_all_bets_head">
                                <th>Ставка</th>
                                <th class="hidden-xs">Время</th>
                                <th>Игрок</th>
                                <th>Валюта</th>
                                <th>Ставка</th>
                                <th>Выплата</th>
                                <th>Цель</th>
                                <th>Ролл</th>
                                <th class="text-right">Прибыль</th>
                                <th></th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="my_bets">
                    <br/>
                    <div class="bets">
                        <table class="table table-striped table_bets_no_effects" id="table_my_bets">
                            <tr id="table_my_bets_head">
                                <th>Ставка</th>
                                <th class="hidden-xs">Время</th>
                                <th>Игрок</th>
                                <th>Валюта</th>
                                <th>Ставка</th>
                                <th>Выплата</th>
                                <th>Цель</th>
                                <th>Ролл</th>
                                <th class="text-right">Прибыль</th>
                                <th></th>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="high_rollers">
                    <br/>
                    <div class="bets">
                        <table class="table table-striped" id="table_high_rollers">
                            <tr id="table_high_rollers_head">
                                <th>Game</th>
                                <th>BetID</th>
                                <th class="hidden-xs">Time</th>
                                <th>User</th>
                                <th>Coin</th>
                                <th>Bet</th>
                                <th class="text-right">Profit</th>
                                <th></th>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="jackpots">
                    <br/>
                    <div class="bets">
                        <div class="well text-center">
                            <div class="row">
                                <strong id="txtJackpotBalance">Jackpot balance:</strong>
                            </div>
                        </div>
                        <table class="table table-striped" id="table_jackpots_2">
                            <tr id="table_jackpots_head_2">
                                <th>Game</th>
                                <th>BetID</th>
                                <th class="hidden-xs">Date</th>
                                <th>User</th>
                                <th>Coin</th>
                                <th><span id="lblPortion" data-toggle="tooltip" class="tooltipLink"
                                          data-placement="right"
                                          data-original-title="Part of jackpot is determined by win amount. More in FAQ.">Part <span
                                            class="glyphicon glyphicon-question-sign"></span></span></th>
                                <th class="text-right">Reward</th>
                                <th></th>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade in" id="statistic">
                    <br/>
                    <div class="bets">
                        <div id="global_stats">
                            <br/>
                            <i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
                            <br/>
                        </div>
                        <div id="user_stats"></div>
                        <br/>
                        <span class="small_info">Data is refreshed once every 10 minutes.</span>
                    </div>
                </div>
                <div class="tab-pane fade in" id="statistic_graph">
                    <br/>
                    <div class="bets">
                        <div id="chart_coins"
                             style="min-width: 350px; height: 350px; max-width: 600px; margin: 0 auto; float: left;"></div>
                        <div id="chart_games"
                             style="min-width: 350px; height: 350px; max-width: 600px; margin: 0 auto; float: left;"></div>
                    </div>
                    <span class="small_info">Data is refreshed once every 10 minutes.</span>
                </div>
                <div class="tab-pane fade in" id="statistic_all">
                    <br/>
                    <div class="bets">
                        <div id="all_global_stats">
                            <br/>
                            <i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>
                            <br/>
                        </div>
                    </div>
                    <span class="small_info">Data is refreshed once every 10 minutes.</span>
                </div>

                <div class="tab-pane fade in" id="mostwagered">
                    <br/>
                    <div class="bets">
                        <div id="mostwagered_table">
                        </div>
                        <span class="small_info">Data is refreshed once every 10 minutes.</span>
                    </div>
                </div>
                <div class="tab-pane fade in" id="mostbids">
                    <br/>
                    <div class="bets">
                        <div id="mostbids_table">
                        </div>
                        <span class="small_info">Data is refreshed once every 10 minutes.</span>
                    </div>
                </div>
                <div class="tab-pane fade in" id="mostprofit">
                    <br/>
                    <div class="bets">
                        <div id="mostprofit_table">
                        </div>
                        <span class="small_info">Data is refreshed once every 10 minutes.</span>
                    </div>
                </div>
                <div class="tab-pane fade in" id="mosttips">
                    <br/>
                    <div class="bets">
                        <div id="mosttips_table">
                        </div>
                        <span class="small_info">Data is refreshed once every 10 minutes.</span>
                    </div>
                </div>
                <div class="tab-pane fade in" id="mostchat">
                    <br/>
                    <div class="bets">
                        <div id="mostchat_table">
                        </div>
                        <span class="small_info">Data is refreshed once every 10 minutes.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush
