@extends('layouts.layout')

@push('head_css')
    <link href="{{ asset('css/dice_v2.css') }}" rel="stylesheet"/>
@endpush

@push('game_scripts')
    <script src="{{ asset('js/dice_v2.js') }}" type="text/javascript"></script>
@endpush

@push('head_scripts')
    <script type="text/javascript">
        var coin = "{{ $currency->code }}";
        var style = "7";
        var coinname = "{{ $currency->name }}";
        var decimals = "6";
        var totalchannels = "5";
        var ratio = "10000000";
        var Balance = {{ auth()->check() ? auth()->user()->getBalance(request()->route('currency')) : 0 }};
        var BalanceCredits = 0;
        var serverTime = "{{ \Carbon\Carbon::now()->getPreciseTimestamp(3) }}";
        var LoggedIn = "{{ auth()->check() ? 'True' : 'False' }}";
        var ShowLogIn = "True";
    </script>

    <script type="text/javascript">
        var idc = "{{ $currency->code }}";
        var accuracy = "{{ $currency->accuracy }}";
        var coinname = "{{ $currency->name }}";
        var style = "7";
        var maxwin = "500000";
        var minbid = "0.10";
        var effects = "0";
        var edge = "{{ $game->edge }}";
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
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-lg-offset-0 col-md-offset-2 col-sm-offset-1">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#mine_game" class="text-def" data-toggle="tab"><i
                            class="fa fa-gamepad fa-lg" aria-hidden="true"></i>Игра</a></li>
                <li><a href="#how_to_play" class="text-def" data-toggle="tab"><i
                            class="fa fa-info-circle fa-lg" aria-hidden="true"></i>Как играть</a></li>
            </ul>

            <div class="tab-content">
                <br/>
                <div class="tab-pane fade in active" id="mine_game">
                    <div class="row">
                        <div class="dice_v2-game">
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 text-center">
                                <div class="well height-100">
                                    <span class="bet_text">Сумма ставки:</span><br/>

                                    <div class="chips">
                                        <div class="pokerchip white"></div>
                                        <div class="pokerchip red"></div>
                                        <div class="pokerchip blue"></div>
                                        <div class="pokerchip green"></div>
                                        <div class="pokerchip black"></div>
                                    </div>

                                    <div class="btn-group" role="group" aria-label="..." style="width: 101%;">
                                        <button id="btnBet1" type="button" class="btn btn-default"
                                                style="width: calc(100% /2);"> Отмена
                                        </button>
                                        <button id="btnBet2" type="button" class="btn btn-default"
                                                style="width: calc(100% /2)">x2 Удвоить
                                        </button>
                                    </div>

                                    <button class="game-dice_v2__button" id="btnRoll"><span>Играть</span></button>

                                    <div class="message_line">
                                        <div id="divManualMessage" class="alert text-center alert-danger" role="alert"
                                             style="display: none;">
                                            <p></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6 text-center">
                                <div class="well height-100">

                                    <div class="dice">
                                        <ol class="die-list even-roll" data-roll="1" id="die-1">
                                            <li class="die-item" data-side="1">
                                                <span class="dot"></span>
                                            </li>
                                            <li class="die-item" data-side="2">
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </li>
                                            <li class="die-item" data-side="3">
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </li>
                                            <li class="die-item" data-side="4">
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </li>
                                            <li class="die-item" data-side="5">
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </li>
                                            <li class="die-item" data-side="6">
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </li>
                                        </ol>
                                        <ol class="die-list odd-roll" data-roll="1" id="die-2">
                                            <li class="die-item" data-side="1">
                                                <span class="dot"></span>
                                            </li>
                                            <li class="die-item" data-side="2">
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </li>
                                            <li class="die-item" data-side="3">
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </li>
                                            <li class="die-item" data-side="4">
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </li>
                                            <li class="die-item" data-side="5">
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </li>
                                            <li class="die-item" data-side="6">
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="dice">
                                        <ol class="die-list even-roll" data-roll="1" id="die-3">
                                            <li class="die-item" data-side="1">
                                                <span class="dot"></span>
                                            </li>
                                            <li class="die-item" data-side="2">
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </li>
                                            <li class="die-item" data-side="3">
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </li>
                                            <li class="die-item" data-side="4">
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </li>
                                            <li class="die-item" data-side="5">
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </li>
                                            <li class="die-item" data-side="6">
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="dice-bet">
                                        <div class="container-bet">
                                            <div class="row-bet">
                                                <div class="cell-bet cell-bet-wide">
                                                    <div class="arrow-top"></div>
                                                    <div class="bet-number">Low <br> 3 - 9</div>
                                                    <div class="bet-coef">x2</div>
                                                </div>
                                            </div>
                                            <div class="row-bet">
                                                <div class="cell-bet cell-bet-wide">
                                                    <div class="arrow-top"></div>
                                                    <div class="bet-number">Any <br> Double</div>
                                                    <div class="bet-coef">x2</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-bet">
                                            <div class="row-bet">
                                                <div class="cell-bet">
                                                    <div class="arrow-top"></div>
                                                    <div class="bet-number">3</div>
                                                    <div class="bet-coef">x150</div>
                                                </div>
                                                <div class="cell-bet">
                                                    <div class="arrow-top"></div>
                                                    <div class="bet-number">4</div>
                                                    <div class="bet-coef">x50</div>
                                                </div>
                                                <div class="cell-bet">
                                                    <div class="arrow-top"></div>
                                                    <div class="bet-number">5</div>
                                                    <div class="bet-coef">x25</div>
                                                </div>
                                                <div class="cell-bet">
                                                    <div class="arrow-top"></div>
                                                    <div class="bet-number">6</div>
                                                    <div class="bet-coef">x15</div>
                                                </div>
                                                <div class="cell-bet">
                                                    <div class="arrow-top"></div>
                                                    <div class="bet-number">7</div>
                                                    <div class="bet-coef">x10</div>
                                                </div>
                                                <div class="cell-bet">
                                                    <div class="arrow-top"></div>
                                                    <div class="bet-number">8</div>
                                                    <div class="bet-coef">x7</div>
                                                </div>
                                                <div class="cell-bet">
                                                    <div class="arrow-top"></div>
                                                    <div class="bet-number">9</div>
                                                    <div class="bet-coef">x6</div>
                                                </div>
                                                <div class="cell-bet">
                                                    <div class="arrow-top"></div>
                                                    <div class="bet-number">10</div>
                                                    <div class="bet-coef">x5</div>
                                                </div>
                                            </div>

                                            <div class="row-bet">
                                                <div class="cell-bet">
                                                    <div class="arrow-top"></div>
                                                    <div class="bet-number">11</div>
                                                    <div class="bet-coef">x5</div>
                                                </div>
                                                <div class="cell-bet">
                                                    <div class="arrow-top"></div>
                                                    <div class="bet-number">12</div>
                                                    <div class="bet-coef">x6</div>
                                                </div>
                                                <div class="cell-bet">
                                                    <div class="arrow-top"></div>
                                                    <div class="bet-number">13</div>
                                                    <div class="bet-coef">x7</div>
                                                </div>
                                                <div class="cell-bet">
                                                    <div class="arrow-top"></div>
                                                    <div class="bet-number">14</div>
                                                    <div class="bet-coef">x10</div>
                                                </div>
                                                <div class="cell-bet">
                                                    <div class="arrow-top"></div>
                                                    <div class="bet-number">15</div>
                                                    <div class="bet-coef">x10</div>
                                                </div>
                                                <div class="cell-bet">
                                                    <div class="arrow-top"></div>
                                                    <div class="bet-number">16</div>
                                                    <div class="bet-coef">x25</div>
                                                </div>
                                                <div class="cell-bet">
                                                    <div class="arrow-top"></div>
                                                    <div class="bet-number">17</div>
                                                    <div class="bet-coef">x50</div>
                                                </div>
                                                <div class="cell-bet">
                                                    <div class="arrow-top"></div>
                                                    <div class="bet-number">18</div>
                                                    <div class="bet-coef">x150</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-bet">
                                            <div class="row-bet">
                                                <div class="cell-bet cell-bet-wide">
                                                    <div class="arrow-top"></div>
                                                    <div class="bet-number">High <br> 12 - 18</div>
                                                    <div class="bet-coef">x2</div>
                                                </div>
                                            </div>
                                            <div class="row-bet">
                                                <div class="cell-bet cell-bet-wide">
                                                    <div class="arrow-top"></div>
                                                    <div class="bet-number">Any <br> Triple</div>
                                                    <div class="bet-coef">x25</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
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
                        <h5>How do I increase my bet speed?</h5> Betting 0.00001 Bitcoin or above will
                        prioritize your bet speed. As your bet amount approaches the minimum bet of the coin,
                        your bet speed will decrease. Simply stated: the greater amount you gamble, the faster
                        the server will process your result. Alternatively, completing the verification process
                        and completing the Tier3 KYC.
                    </div>

                    <div class="well">
                        <h5>What is this game?</h5> This game is called Dice, but it is not the typical game of
                        luck and probability using a simple cube with numbered sides. Instead, it is a
                        crypto-oriented Dice game where you have a greater range and higher fidelity of
                        potential outcomes (0.000-99.999). Your task is to predict whether the lucky number that
                        the Dice will roll is higher or lower than a certain digit. If you're new to Dice and
                        have absolutely no clue how to play this game, we explained the basics below.
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
                        <h5>Keyboard shortcuts:</h5> If you want to use them, there are several keyboard
                        shortcuts listed below:
                        <ul>
                            <li><i>Roll High</i> [H], <i>Roll Low</i> [L]<br></li>
                            <li><i>Bet size:</i> Min [Q], 1/2 [W], x2 [E], Max [R]<br></li>
                            <li><i>Payout:</i> Min [A], -1 [S], +1 [D], Max [F]</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <ul class="nav nav-tabs " id="tab_result">
                <li class="active">
                    <a href="#last_bets" class="fixed-tabs" data-toggle="tab"><i
                            class="fa fa-users fa-lg" aria-hidden="true"></i>Все ставки <span id="allbets_pause"
                                                                                            class="glyphicon glyphicon-pause"
                                                                                            aria-hidden="true"></span>
                    </a>
                </li>
                <li><a href="#my_bets" class="fixed-tabs" data-toggle="tab"><i
                            class="fa fa-user fa-lg" aria-hidden="true"></i>Мои ставки <span id="yourbets_pause"
                                                                                            class="glyphicon glyphicon-pause"
                                                                                            aria-hidden="true"></span></a>
                </li>
            </ul>

            <div class="tab-content div_table">
                <div class="tab-pane fade in active" id="last_bets">
                    <br/>
                    <div class="bets">
                        <table class="table table-striped table_bets_no_effects" id="table_last_bets">
                            <tr id="table_all_bets_head">
                                <th>ID</th>
                                <th class="hidden-xs">Время</th>
                                <th>Игрок</th>
                                <th>Валюта</th>
                                <th>Ставка</th>
                                <th>Выплата</th>
                                <th class="text-right">Выигрыш</th>
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
                                <th>ID</th>
                                <th class="hidden-xs">Время</th>
                                <th>Игрок</th>
                                <th>Валюта</th>
                                <th>Ставка</th>
                                <th>Выплата</th>
                                <th class="text-right">Выигрыш</th>
                                <th></th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

@endpush
