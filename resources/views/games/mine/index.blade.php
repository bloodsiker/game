@extends('layouts.layout')

@push('head_css')
    <link href="{{ asset('css/mines.css') }}" rel="stylesheet"/>
@endpush

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
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-lg-offset-0 col-md-offset-2 col-sm-offset-1">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#mine_game" class="text-def" data-toggle="tab"><i
                            class="fa fa-gamepad fa-lg" aria-hidden="true"></i>Игра</a></li>
                <li><a href="#how_to_play" class="text-def" data-toggle="tab"><i
                            class="fa fa-info-circle fa-lg" aria-hidden="true"></i>Как играть</a></li>
                <li><a href="#provable_fair" class="text-def" data-toggle="tab"><i
                            class="fa fa-balance-scale fa-lg" aria-hidden="true"></i>Provably fair</a></li>
            </ul>

            <div class="tab-content">
                <br/>
                <div class="tab-pane fade in active" id="mine_game">
                    <div class="row">
                        <div class="mines-game">
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 text-center">
                                <div class="well height-100">
                                    <span class="bet_text">Количество бомб:</span><br/>
                                    <div class="btn-group" role="group" aria-label="..." style="width: 101%;">
                                        <button id="btnBet1" type="button" class="btn btn-default"
                                                style="width: 20%;">3
                                        </button>
                                        <button id="btnBet2" type="button" class="btn btn-default"
                                                style="width: 20%;">5
                                        </button>
                                        <button id="btnBet3" type="button" class="btn btn-default"
                                                style="width: 20%;">10
                                        </button>
                                        <button id="btnBet4" type="button" class="btn btn-default"
                                                style="width: 20%;">20
                                        </button>
                                        <button id="btnBet4" type="button" class="btn btn-default"
                                                style="width: 20%;">24
                                        </button>
                                    </div>
                                    <div class="">
                                        <input id="txtBet" type="text" class="form-control fz-16 fw-600 text-center" value="3" autocomplete="of"/>
                                    </div>
                                    <br/>

                                    <span class="bet_text">Сумма ставки:</span><br/>
                                    <div class="group">
                                        <div class="choices">
                                            <div class="badges"><span class="btn">Max</span><span class="btn">Min</span></div>
                                            <input class="fz-16 fw-600" name="amount" type="text" value="10" autocomplete="off">
                                            <div class="badges"><span class="btn">X2</span><span class="btn">/2</span></div>
                                        </div>
                                    </div>

                                    <button class="play">Играть<img src="{{ asset('assets/icons/play.svg') }}" alt="Играть"></button>

                                    <div class="message_line">
                                        <div id="divManualMessage" class="alert text-center alert-danger" role="alert"
                                             style="display: none;">
                                            <p>Check your input parameters.</p>
                                        </div>
                                        <div id="divConfirmBet" class="alert text-center alert-info" role="alert"
                                             style="display: none;">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <p>Bet size is high.</p>
                                                    <input type="checkbox" name="chkConfirmBetAsk" id="chkConfirmBetAsk"/> Don't
                                                    ask me again
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
                            </div>
                            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6 text-center">
                                <div class="well height-100">
                                    <div class="board">
                                        <div  class="board__aside board__aside_left"><span>22</span></div>
                                        <div class="game">
                                        <span class="disabled is_opacity gameSuccess">
                                           <img src="{{ asset('assets/icons/mine_win.png') }}" alt="Успешно">
                                        </span>
                                            <span class="disabled is_opacity gameDanger">
                                           <img src="{{ asset('assets/icons/mine-loss.png') }}" alt="Неудача">
                                        </span>
                                            <span class="disabled gameDanger">
                                            <img src="{{ asset('assets/icons/mine-loss.png') }}" alt="Неудача">
                                        </span>
                                            <span class=""></span>
                                            <span class=""></span>
                                            <span class="disabled is_opacity gameSuccess">
                                            <img src="{{ asset('assets/icons/mine_win.png') }}" alt="Успешно">
                                        </span>
                                            <span class=""></span>
                                            <span class="disabled gameDanger">
                                           <img src="{{ asset('assets/icons/mine-loss.png') }}" alt="Неудача">
                                        </span>
                                            <span class=""></span>
                                            <span class="disabled gameSuccess">
                                            <img src="{{ asset('assets/icons/mine_win.png') }}" alt="Успешно">
                                            <i class="mines-reveal-animation"></i>
                                        </span>
                                            <span class=""></span>
                                            <span class=""></span>
                                            <span class="disabled gameSuccess">
                                           <img src="{{ asset('assets/icons/mine_win.png') }}" alt="Успешно">
                                        </span>
                                            <span class=""></span><span
                                                class=""></span><span class=""></span><span class=""></span><span
                                                class=""></span><span class=""></span><span class=""></span><span
                                                class=""></span><span class=""></span><span class=""></span><span
                                                class=""></span><span class=""></span>
                                        </div>
                                        <div class="board__aside board__aside_right"><span>3</span></div>
                                    </div>

                                    <div class="game-footer game-footer_mines">
                                        <div class="mines-footer-wrapper">
                                            <div class="mines-coeffs-slider" >
                                                <div>
                                                    <div class="mines-coeff mines-coeff-1 active">
                                                        <div class="coeff-square">
                                                            <div class="mines_step">Шаг <span
                                                                    class="coeff-step">1</span></div>
                                                            <div class="coeff-number-wrapper"><span
                                                                    class="coeff-x">x</span><span class="coeff-number">4.84</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="mines-coeff mines-coeff-2">
                                                        <div class="coeff-square">
                                                            <div class="mines_step">Шаг <span
                                                                    class="coeff-step">2</span></div>
                                                            <div class="coeff-number-wrapper"><span
                                                                    class="coeff-x">x</span><span class="coeff-number">29.1</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="mines-coeff mines-coeff-3">
                                                        <div class="coeff-square">
                                                            <div class="mines_step">Шаг <span
                                                                    class="coeff-step">3</span></div>
                                                            <div class="coeff-number-wrapper"><span
                                                                    class="coeff-x">x</span><span class="coeff-number">223.1</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="mines-coeff mines-coeff-4">
                                                        <div class="coeff-square">
                                                            <div class="mines_step">Шаг <span
                                                                    class="coeff-step">4</span></div>
                                                            <div class="coeff-number-wrapper"><span
                                                                    class="coeff-x">x</span><span class="coeff-number">2.45k</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="mines-coeff mines-coeff-5">
                                                        <div class="coeff-square">
                                                            <div class="mines_step">Шаг <span
                                                                    class="coeff-step">5</span></div>
                                                            <div class="coeff-number-wrapper"><span
                                                                    class="coeff-x">x</span><span class="coeff-number">51.54k</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="mines-coeff mines-coeff-4">
                                                        <div class="coeff-square">
                                                            <div class="mines_step">Шаг <span
                                                                    class="coeff-step">4</span></div>
                                                            <div class="coeff-number-wrapper"><span
                                                                    class="coeff-x">x</span><span class="coeff-number">2.45k</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="mines-coeff mines-coeff-5">
                                                        <div class="coeff-square">
                                                            <div class="mines_step">Шаг <span
                                                                    class="coeff-step">5</span></div>
                                                            <div class="coeff-number-wrapper"><span
                                                                    class="coeff-x">x</span><span class="coeff-number">51.54k</span>
                                                            </div>
                                                        </div>
                                                    </div>
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
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <ul class="nav nav-tabs " id="tab_result">
                <li class="active">
                    <a href="bitcoin.html#last_bets" class="fixed-tabs" data-toggle="tab"><i
                            class="fa fa-users fa-lg" aria-hidden="true"></i>All bets <span id="allbets_pause"
                                                                                            class="glyphicon glyphicon-pause"
                                                                                            aria-hidden="true"></span>
                    </a>
                </li>
                <li><a href="bitcoin.html#my_bets" class="fixed-tabs" data-toggle="tab"><i
                            class="fa fa-user fa-lg" aria-hidden="true"></i>Your bets <span id="yourbets_pause"
                                                                                            class="glyphicon glyphicon-pause"
                                                                                            aria-hidden="true"></span></a>
                </li>
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle fixed-tabs" data-toggle="dropdown" href="bitcoin.html#"
                       role="button" aria-expanded="false"><i class="fa fa-pie-chart fa-lg"
                                                              aria-hidden="true"></i>Statistic <span
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
                       role="button" aria-expanded="false"><i class="fa fa-trophy fa-lg" aria-hidden="true"></i>Top
                        players <span class="caret"></span></a>
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
                                <th>BetID</th>
                                <th class="hidden-xs">Time</th>
                                <th>User</th>
                                <th>Coin</th>
                                <th>Bet</th>
                                <th>Payout</th>
                                <th class="text-right">Profit</th>
                                <th>
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="my_bets">
                    <br/>
                    <div class="bets">
                        <table class="table table-striped table_bets_no_effects" id="table_my_bets">
                            <tr id="table_my_bets_head">
                                <th>BetID</th>
                                <th class="hidden-xs">Time</th>
                                <th>User</th>
                                <th>Coin</th>
                                <th>Bet</th>
                                <th>Payout</th>
                                <th>Target</th>
                                <th>Roll</th>
                                <th class="text-right">Profit</th>
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
    <script src="{{ asset('js/libs/slick.min.js') }}"></script>

    <script>
        if ($('.mines-coeffs-slider').length) {
            let slickSlider = $('.mines-coeffs-slider').slick({
                dots: false,
                infinite: false,
                arrows: true,
                speed: 300,
                slidesToShow: 4,
                slidesToScroll: 4,
            });

            // Переключаем слайд при клике на цвет товаров
            $('.switch-colour').on('click', function () {
                let colourId = $(this).data('option-colour');

                let slide = $('.product-big-slider').find('.product-big-item[data-option-colour=' + colourId + ']');
                if (slide[0]) {
                    let indexSlick = slide.data('slick-index');
                    slickSlider.slick('slickGoTo', parseInt(indexSlick));
                }
            });
        }
    </script>
@endpush
