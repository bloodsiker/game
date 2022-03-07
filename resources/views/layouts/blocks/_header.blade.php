<nav class="navbar navbar-default navbar-fixed-top sticky">
    <div class="container-fluid" id="navbarGames">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Меню</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            @php
                $currency = \App\Models\Currency::where('idc', request()->route('currency'))->first();
            @endphp

            <a class="navbar-brand" href="{{ route('index') }}">
                <img class="tilt-left" src="{{ asset('assets/currency/'. $currency->idc . '.png') }}" width="60"
                     alt="Crypto.Games - Cryptocurrency Dice, Slot and Blackjack gambling"
                     title="На главную"/>
            </a>

            <div class="navbar-text pull-left">
                <div>
                    <span id="lblUsdBalance" data-toggle="tooltip" class="tooltipLink"
                          data-placement="right" title="">
                        <span id="lblBalance" style="color: white;">Баланс: {{ round(auth()->check() ? auth()->user()->getBalance(request()->route('currency')) : 0, 2) }}</span>
                        <span id="lblCoinName" style="color: white; text-transform: uppercase">{{ $currency ? $currency->idc : '' }}</span>
                    </span>
                    <span id="lblPending" class="small"></span>
                </div>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            @php
                $currencies = \App\Models\Currency::where('is_active', true)->get();
            @endphp
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-type="coins" data-toggle="dropdown"
                       role="button" aria-haspopup="true" aria-expanded="false">Сменить валюту<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                        @foreach($currencies as $curr)
                            <li>
                                <a class='coin' href='{{ route(request()->route()->getName(), ['currency' => $curr->idc]) }}' data-type='coin'
                                   data-game='blackjack' data-coin='btc' data-name='bitcoin'>
                                    <img src='{{ asset('assets/currency/'. $curr->idc . '.png') }}' width=15>&nbsp;{{ $curr->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav custom-menu">
                <li><a class="a_fwindow" href="{{ route('account.reward', ['currency' => request()->route('currency')]) }}">Бонусы</a></li>
                <li><a class="a_fwindow" href="https://crypto.games/faq">Помощь</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">

                <li><a href="#switchcolor" data-color="light" title="Swith to Light color"><i class="fa fa-sun-o fa-lg fa-fw" aria-hidden="true"></i></a></li>

                <li>
                    <a href="bitcoin.html#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user fa-fw fa-lg fa-fw" aria-hidden="true"></i>Your account <span
                            class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                        <li><a class="a_swindow" href="deposit.html"><i
                                    class="fa fa-bank fa-fw fa-lg fa-fw" aria-hidden="true"></i>Deposit</a></li>
                        <li><a class="a_fwindow" href="https://crypto.games/account/exchange"><i
                                    class="fa fa-exchange fa-fw fa-lg fa-fw" aria-hidden="true"></i>Exchange</a>
                        </li>
                        <li><a class="a_fwindow" href="withdraw.html"><i
                                    class="fa fa-suitcase fa-fw fa-lg fa-fw" aria-hidden="true"></i>Withdraw</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="a_fwindow" href="{{ route('account.reward', ['currency' => request()->route('currency')]) }}">
                                <i class="fa fa-gift fa-fw fa-lg fa-fw" aria-hidden="true"></i>Бонусы</a>
                        </li>
                        <li><a class="a_swindow" href="https://crypto.games/contests"><i
                                    class="fa fa-trophy fa-fw fa-lg fa-fw" aria-hidden="true"></i>Contests</a></li>
                        <li><a class="a_swindow" href="{{ route('account.info') }}">
                                <i class="fa fa-user fa-fw fa-lg fa-fw" aria-hidden="true"></i>Информация</a>
                        </li>
                        <li><a class="a_swindow" href="settings.html"><i
                                    class="fa fa-cog fa-fw fa-lg fa-fw" aria-hidden="true"></i>Settings</a></li>
                        @if (Auth::user())
                            <li class="divider"></li>
                            <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out fa-lg fa-fw" aria-hidden="true"></i>Выход</a></li>
                        @endif

                    </ul>
                </li>

                @if(!auth()->check())
                    <li><a class="a_gwindow" href="register.html"><i class="fa fa-sign-in fa-lg fa-fw" aria-hidden="true"></i>Log in</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="sidebar-item">
            <a href="{{ route('dice', ['currency' => $currency->idc]) }}" class="sidebar-link @if(request()->route()->getName() === 'dice') sidebar-link_active @endif">
{{--                <span class="sidebar-link__new-label" style="display:none;">New</span>--}}
                <span class="sidebar-link__image"><img src="{{ asset('assets/games/dice.svg') }}" alt="Dice"></span>
                <span class="sidebar-link__name">Dice</span>
            </a>
        </div>
        <div class="sidebar-item">
            <a href="{{ route('mines', ['currency' => $currency->idc]) }}" class="sidebar-link @if(request()->route()->getName() === 'mines') sidebar-link_active @endif">
                <span class="sidebar-link__image"><img src="{{ asset('assets/games/miner.svg') }}" alt="Mines"></span>
                <span class="sidebar-link__name">Mines</span>
            </a>
        </div>
        <div class="sidebar-item">
            <a href="{{ route('keno', ['currency' => $currency->idc]) }}" class="sidebar-link @if(request()->route()->getName() === 'keno') sidebar-link_active @endif">
                <span class="sidebar-link__image"><img src="{{ asset('assets/games/keno.svg') }}" alt="Keno"></span>
                <span class="sidebar-link__name">Keno</span>
            </a>
        </div>
        <div class="sidebar-item">
            <a href="{{ route('coinflip', ['currency' => $currency->idc]) }}" class="sidebar-link @if(request()->route()->getName() === 'coinflip') sidebar-link_active @endif">
                <span class="sidebar-link__image"><img src="{{ asset('assets/games/coinflip.svg') }}" alt="Coin Flip"></span>
                <span class="sidebar-link__name">Coin Flip</span>
            </a>
        </div>
        <div class="sidebar-item">
            <a href="{{ route('dice_v2', ['currency' => $currency->idc]) }}" class="sidebar-link @if(request()->route()->getName() === 'dice_v2') sidebar-link_active @endif">
                <span class="sidebar-link__image"><img src="{{ asset('assets/games/dice.svg') }}" alt="Dice V2"></span>
                <span class="sidebar-link__name">Dice V2</span>
            </a>
        </div>
    </div>
</div>
