<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>
        Bitcoin, Ethereum and Litecoin Gambling | Crypto.Games
    </title>
    <meta name='description'
          content='CryptoGames is a Bitcoin gambling site offering Dice, Blackjack, Roulette, Lottery, Poker, Plinko and Slot game to play also with Ethereum, Dogecoin & Litecoin.'/>
    <meta name='keywords'
          content='bitcoin,ethereum,litecoin,dogecoin,plinko,dice,roulette,blackjack,video poker,lottery,cryptogames,gambling,slot,games'/>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fork-awesome@1.1.7/css/fork-awesome.min.css"
          integrity="sha256-gsmEoJAws/Kd3CjuOQzLie5Q3yshhvmo7YNtBG7aaEY=" crossorigin="anonymous"/>
    <link href="{{ asset('js/fancybox/jquery.fancybox.css') }}" rel="stylesheet"/>
    <link rel="icon" href="{{ asset('favicon.ico') }}"/>
</head>


<body>
<nav>
    <div class="nav-image">
        <div class="nav-image-gradient"></div>
    </div>

    <div class="container">
        <div class="navigation d-none d-md-flex">
            <a href="{{ route('index') }}" class="logo">
                <img src="{{ asset('assets/logo.png') }}" alt="Crypto.Games"
                     title="Crypto.Games - Dice, Slot, Blackjack, Roulette, Video Poker, Plinko, Minesweeper, Lottery gambling"/>
            </a>

            <div class="links">
                <a href="https://blog.crypto.games" target="_blank" class="link">Blog</a>
                <a href="faq%3Fstyle=E.html" class="link a_index">FAQ</a>
                <a href="#" onclick="if (!window.__cfRLUnblockHandlers) return false; openPopup('dice')"
                   class="btn">Play now!</a>
            </div>
        </div>

        <div class="navigation d-block d-md-none">
            <a href="index.html" class="logo-vertical">
                <img src="{{ asset('assets/logo-vertical.png') }}"/>
            </a>
        </div>
    </div>
</nav>


<div class="container">
    <section id="hero-section">
        <div class="row align-items-center">
            <div class="col-md-5">
                <div class="hero-content">
                    <h1>Catch the winning spirit!</h1>
                    <p>Play your favorite game, use the coin of your choice & chat with your friends. Simple, social and
                        most importantly entertaining!</p>
                    <button class="btn btn-primary"
                            onclick="if (!window.__cfRLUnblockHandlers) return false; openPopup('dice')"
                            data-cf-modified-68380b26a5082d0829e5b438-="">Play now!
                    </button>
                </div>
            </div>
            <div class="col-sm-7 d-none d-md-block">
                <div id="results-wrapper">
                    <div class="results">
                        <table class="results-table">
                            <thead>
                            <tr>
                                <th>Game</th>
                                <th>User</th>
                                <th>Bet</th>
                                <th>Payout</th>
                            </tr>
                            </thead>
                            <tbody id="results-table-body">
                            <tr>
                                <td class="result-game"><img src="{{ asset('assets/games/roulette.png') }}">Roulette
                                </td>
                                <td class="result-user">jdausti</td>
                                <td class="result-bet"><img src="{{ asset('assets/coins/ETC.png') }}">0.4000</td>
                                <td class="result-payout positive"><img src="{{ asset('assets/coins/ETC.png') }}">14.0000
                                </td>
                            </tr>
                            <tr>
                                <td class="result-game"><img src="/index/assets/games/blackjack.png">Blackjack</td>
                                <td class="result-user">Heorot714</td>
                                <td class="result-bet"><img src="/index/assets/coins/DOGE.png">3437</td>
                                <td class="result-payout negative"><img src="/index/assets/coins/DOGE.png">-3437</td>
                            </tr>
                            <tr>
                                <td class="result-game"><img src="/index/assets/games/roulette.png">Roulette</td>
                                <td class="result-user">jdausti</td>
                                <td class="result-bet"><img src="/index/assets/coins/ETC.png">0.4000</td>
                                <td class="result-payout positive"><img src="/index/assets/coins/ETC.png">14.0000</td>
                            </tr>
                            <tr>
                                <td class="result-game"><img src="/index/assets/games/dice.png">Dice</td>
                                <td class="result-user">Tan248</td>
                                <td class="result-bet"><img src="/index/assets/coins/DOGE.png">205</td>
                                <td class="result-payout positive"><img src="/index/assets/coins/DOGE.png">1024</td>
                            </tr>
                            <tr>
                                <td class="result-game"><img src="/index/assets/games/roulette.png">Roulette</td>
                                <td class="result-user">jdausti</td>
                                <td class="result-bet"><img src="/index/assets/coins/ETC.png">0.4000</td>
                                <td class="result-payout positive"><img src="/index/assets/coins/ETC.png">14.0000</td>
                            </tr>
                            <tr>
                                <td class="result-game"><img src="/index/assets/games/dice.png">Dice</td>
                                <td class="result-user">Sarif79</td>
                                <td class="result-bet"><img src="/index/assets/coins/DOGE.png">1341</td>
                                <td class="result-payout negative"><img src="/index/assets/coins/DOGE.png">-1341</td>
                            </tr>
                            <tr>
                                <td class="result-game"><img src="/index/assets/games/blackjack.png">Blackjack</td>
                                <td class="result-user">Heorot714</td>
                                <td class="result-bet"><img src="/index/assets/coins/DOGE.png">4606</td>
                                <td class="result-payout negative"><img src="/index/assets/coins/DOGE.png">-4606</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="games-section">
        <div class="row">
            <div class='col-6 col-md-4 col-lg-4'>
                <div class='game' onclick="if (!window.__cfRLUnblockHandlers) return false; openPopup('dice')"
                     data-cf-modified-68380b26a5082d0829e5b438-="">
                    <div class='game-background'
                         style='background-image: url("{{ asset('assets/games/dice-bg.png') }}")'></div>
                    <div class='game-icon' style='background-image: url("{{ asset('assets/games/dice.png') }}")'></div>
                    <div class='game-name'>Dice</div>
                    <div class='game-edge'>1.0% Edge</div>
                </div>
            </div>
            <div class='col-6 col-md-4 col-lg-4'>
                <div class='game'
                     onclick="if (!window.__cfRLUnblockHandlers) return false; openPopup(&quot;blackjack&quot;)"
                     data-cf-modified-68380b26a5082d0829e5b438-="">
                    <div class='game-background'
                         style='background-image: url("{{ asset('assets/games/blackjack-bg.png') }}")'></div>
                    <div class='game-icon'
                         style='background-image: url("{{ asset('assets/games/blackjack.png') }}")'></div>
                    <div class='game-name'>Blackjack</div>
                    <div class='game-edge'>1.25% Edge</div>
                </div>
            </div>
            <div class='col-6 col-md-4 col-lg-4'>
                <div class='game'
                     onclick="if (!window.__cfRLUnblockHandlers) return false; openPopup(&quot;minesweeper&quot;)"
                     data-cf-modified-68380b26a5082d0829e5b438-="">
                    <div class='game-background'
                         style='background-image: url("{{ asset('assets/games/minesweeper-bg.png') }}")'></div>
                    <div class='game-icon'
                         style='background-image: url("{{ asset('assets/games/minesweeper.png') }}")'></div>
                    <div class='game-name'>Minesweeper</div>
                    <div class='game-edge'>1.0% Edge</div>
                </div>
            </div>
            <div class='col-6 col-md-4 col-lg-4'>
                <div class='game'
                     onclick="if (!window.__cfRLUnblockHandlers) return false; openPopup(&quot;plinko&quot;)"
                     data-cf-modified-68380b26a5082d0829e5b438-="">
                    <div class='game-background'
                         style='background-image: url("{{ asset('assets/games/plinko-bg.png') }}")'></div>
                    <div class='game-icon'
                         style='background-image: url("{{ asset('assets/games/plinko.png') }}")'></div>
                    <div class='game-name'>Plinko</div>
                    <div class='game-edge'>1.72% Edge</div>
                </div>
            </div>
            <div class='col-6 col-md-4 col-lg-4'>
                <div class='game'
                     onclick="if (!window.__cfRLUnblockHandlers) return false; openPopup('dicev2')">
                    <div class='game-background'
                         style='background-image: url("{{ asset('assets/games/dicev2-bg.png') }}")'></div>
                    <div class='game-icon'
                         style='background-image: url("{{ asset('assets/games/dicev2.png') }}")'></div>
                    <div class='game-name'>DiceV2</div>
                    <div class='game-edge'>1.0% Edge</div>
                </div>
            </div>
            <div class='col-6 col-md-4 col-lg-4'>
                <div class='game'
                     onclick="if (!window.__cfRLUnblockHandlers) return false; openPopup(&quot;lottery&quot;)"
                     data-cf-modified-68380b26a5082d0829e5b438-="">
                    <div class='game-background'
                         style='background-image: url("{{ asset('assets/games/lottery-bg.png') }}")'></div>
                    <div class='game-icon'
                         style='background-image: url("{{ asset('assets/games/lottery.png') }}")'></div>
                    <div class='game-name'>Lottery</div>
                    <div class='game-edge'>0.0% Edge</div>
                </div>
            </div>

        </div>
    </section>


    <div class='game-popup-wrapper animate__animated ' id='game-popup-dice' style='display: none;'>
        <div class='game-popup-overlay animate__animated animate__fadeIn'
             onclick="if (!window.__cfRLUnblockHandlers) return false; closePopup(&quot;dice&quot;)"
             data-cf-modified-68380b26a5082d0829e5b438-=""></div>
        <div class='container'>
            <div class='game-popup animate__animated animate__fadeInDown'
                 style='background-image: url("{{ asset('assets/games/dice-bg.png') }}")'>
                <div class='game-popup-close-btn'
                     onclick="if (!window.__cfRLUnblockHandlers) return false; closePopup('dice')"
                     data-cf-modified-68380b26a5082d0829e5b438-="">
                    <svg viewBox='0 0 24 24'>
                        <path
                            d='M5.293 6.707l5.293 5.293-5.293 5.293c-0.391 0.391-0.391 1.024 0 1.414s1.024 0.391 1.414 0l5.293-5.293 5.293 5.293c0.391 0.391 1.024 0.391 1.414 0s0.391-1.024 0-1.414l-5.293-5.293 5.293-5.293c0.391-0.391 0.391-1.024 0-1.414s-1.024-0.391-1.414 0l-5.293 5.293-5.293-5.293c-0.391-0.391-1.024-0.391-1.414 0s-0.391 1.024 0 1.414z'></path>
                    </svg>
                </div>

                <div class='game-popup-header'>
                    <img class='game-popup-header-icon' src='{{ asset('assets/games/dice.png') }}' alt='Dice'/>
                    <div class='game-popup-header-info'>
                        <div class='game-popup-header-edge'>1.0% Edge</div>
                        <div class='game-popup-header-name'>Dice</div>
                        <div class='game-popup-header-description'>Dice is a crypto-oriented game where you have a
                            greater range and higher fidelity of potential outcomes (0.000-99.999). Your task is to
                            predict whether the lucky number that the Dice will roll is higher or lower than a certain
                            digit.
                        </div>
                    </div>
                </div>
                <div class='game-popup-coins-title'>Select the coin you would like to play with</div>
                <div class='game-popup-coins row'>
                    <div class='col-6 col-md-4 col-lg-3'><a href='{{ route('dice', ['currency' => 'usd']) }}' class='game-popup-coin'><img
                                src='index/assets/coins/BTC.png' alt='Bitcoin'/>Usd (USD)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='{{ route('dice', ['currency' => 'uah']) }}' class='game-popup-coin'><img
                                src='index/assets/coins/ETH.png' alt='Ethereum'/>Uah (UAH)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='{{ route('dice', ['currency' => 'rub']) }}' class='game-popup-coin'><img
                                src='index/assets/coins/LTC.png' alt='Litecoin'/>Rub (RUB)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='dice/solana.html' class='game-popup-coin'><img
                                src='index/assets/coins/SOL.png' alt='Solana'/>Solana (SOL)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='dice/dogecoin.html' class='game-popup-coin'><img
                                src='index/assets/coins/DOGE.png' alt='Dogecoin'/>Dogecoin (DOGE)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='dice/monero.html' class='game-popup-coin'><img
                                src='index/assets/coins/XMR.png' alt='Monero'/>Monero (XMR)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='dice/bitcoincash.html' class='game-popup-coin'><img
                                src='index/assets/coins/BCH.png' alt='BitcoinCash'/>BitcoinCash (BCH)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='dice/ethereumclassic.html'
                                                            class='game-popup-coin'><img
                                src='index/assets/coins/ETC.png' alt='EthereumClassic'/>EthereumClassic (ETC)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='dice/dash.html' class='game-popup-coin'><img
                                src='index/assets/coins/DASH.png' alt='Dash'/>Dash (DASH)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='dice/neogas.html' class='game-popup-coin'><img
                                src='index/assets/coins/GAS.png' alt='NeoGas'/>NeoGas (GAS)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='dice/playmoney.html' class='game-popup-coin'><img
                                src='index/assets/coins/PLAY.png' alt='PlayMoney'/>PlayMoney (PLAY)</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class='game-popup-wrapper animate__animated ' id='game-popup-roulette' style='display: none;'>
        <div class='game-popup-overlay animate__animated animate__fadeIn'
             onclick="if (!window.__cfRLUnblockHandlers) return false; closePopup(&quot;roulette&quot;)"
             data-cf-modified-68380b26a5082d0829e5b438-=""></div>
        <div class='container'>
            <div class='game-popup animate__animated animate__fadeInDown'
                 style='background-image: url("{{ asset('assets/games/roulette-bg.png') }}")'>
                <div class='game-popup-close-btn'
                     onclick="if (!window.__cfRLUnblockHandlers) return false; closePopup(&quot;roulette&quot;)"
                     data-cf-modified-68380b26a5082d0829e5b438-="">
                    <svg viewBox='0 0 24 24'>
                        <path
                            d='M5.293 6.707l5.293 5.293-5.293 5.293c-0.391 0.391-0.391 1.024 0 1.414s1.024 0.391 1.414 0l5.293-5.293 5.293 5.293c0.391 0.391 1.024 0.391 1.414 0s0.391-1.024 0-1.414l-5.293-5.293 5.293-5.293c0.391-0.391 0.391-1.024 0-1.414s-1.024-0.391-1.414 0l-5.293 5.293-5.293-5.293c-0.391-0.391-1.024-0.391-1.414 0s-0.391 1.024 0 1.414z'></path>
                    </svg>
                </div>

                <div class='game-popup-header'>
                    <img class='game-popup-header-icon' src='{{ asset('assets/games/roulette.png') }}' alt='Roulette'/>
                    <div class='game-popup-header-info'>
                        <div class='game-popup-header-edge'>2.7% Edge</div>
                        <div class='game-popup-header-name'>Roulette</div>
                        <div class='game-popup-header-description'>Roulette is a very popular casino game that was named
                            after the French word "roulette", which means as much as 'little wheel'. The rules are
                            relatively simple and easy-to-understand. However, roulette offers a surprisingly high level
                            of depth for serious betters.
                        </div>
                    </div>
                </div>
                <div class='game-popup-coins-title'>Select the coin you would like to play with</div>
                <div class='game-popup-coins row'>
                    <div class='col-6 col-md-4 col-lg-3'><a href='roulette/bitcoin.html' class='game-popup-coin'><img
                                src='index/assets/coins/BTC.png' alt='Bitcoin'/>Bitcoin (BTC)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='roulette/ethereum.html' class='game-popup-coin'><img
                                src='index/assets/coins/ETH.png' alt='Ethereum'/>Ethereum (ETH)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='roulette/litecoin.html' class='game-popup-coin'><img
                                src='index/assets/coins/LTC.png' alt='Litecoin'/>Litecoin (LTC)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='roulette/solana.html' class='game-popup-coin'><img
                                src='index/assets/coins/SOL.png' alt='Solana'/>Solana (SOL)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='roulette/dogecoin.html' class='game-popup-coin'><img
                                src='index/assets/coins/DOGE.png' alt='Dogecoin'/>Dogecoin (DOGE)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='roulette/monero.html' class='game-popup-coin'><img
                                src='index/assets/coins/XMR.png' alt='Monero'/>Monero (XMR)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='roulette/bitcoincash.html'
                                                            class='game-popup-coin'><img
                                src='index/assets/coins/BCH.png' alt='BitcoinCash'/>BitcoinCash (BCH)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='roulette/ethereumclassic.html'
                                                            class='game-popup-coin'><img
                                src='index/assets/coins/ETC.png' alt='EthereumClassic'/>EthereumClassic (ETC)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='roulette/dash.html' class='game-popup-coin'><img
                                src='index/assets/coins/DASH.png' alt='Dash'/>Dash (DASH)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='roulette/neogas.html' class='game-popup-coin'><img
                                src='index/assets/coins/GAS.png' alt='NeoGas'/>NeoGas (GAS)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='roulette/playmoney.html' class='game-popup-coin'><img
                                src='index/assets/coins/PLAY.png' alt='PlayMoney'/>PlayMoney (PLAY)</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class='game-popup-wrapper animate__animated ' id='game-popup-blackjack' style='display: none;'>
        <div class='game-popup-overlay animate__animated animate__fadeIn'
             onclick="if (!window.__cfRLUnblockHandlers) return false; closePopup(&quot;blackjack&quot;)"
             data-cf-modified-68380b26a5082d0829e5b438-=""></div>
        <div class='container'>
            <div class='game-popup animate__animated animate__fadeInDown'
                 style='background-image: url("{{ asset('assets/games/blackjack-bg.png') }}")'>
                <div class='game-popup-close-btn'
                     onclick="if (!window.__cfRLUnblockHandlers) return false; closePopup(&quot;blackjack&quot;)"
                     data-cf-modified-68380b26a5082d0829e5b438-="">
                    <svg viewBox='0 0 24 24'>
                        <path
                            d='M5.293 6.707l5.293 5.293-5.293 5.293c-0.391 0.391-0.391 1.024 0 1.414s1.024 0.391 1.414 0l5.293-5.293 5.293 5.293c0.391 0.391 1.024 0.391 1.414 0s0.391-1.024 0-1.414l-5.293-5.293 5.293-5.293c0.391-0.391 0.391-1.024 0-1.414s-1.024-0.391-1.414 0l-5.293 5.293-5.293-5.293c-0.391-0.391-1.024-0.391-1.414 0s-0.391 1.024 0 1.414z'></path>
                    </svg>
                </div>

                <div class='game-popup-header'>
                    <img class='game-popup-header-icon' src='{{ asset('assets/games/blackjack.png') }}'
                         alt='Blackjack'/>
                    <div class='game-popup-header-info'>
                        <div class='game-popup-header-edge'>1.25% Edge</div>
                        <div class='game-popup-header-name'>Blackjack</div>
                        <div class='game-popup-header-description'>Blackjack or 21 is a popular casino game around the
                            world. It's a banking game in which the aim of the player is to achieve a hand whose points
                            total nearer to 21 than the banker's hand, but without exceeding 21.
                        </div>
                    </div>
                </div>
                <div class='game-popup-coins-title'>Select the coin you would like to play with</div>
                <div class='game-popup-coins row'>
                    <div class='col-6 col-md-4 col-lg-3'><a href='blackjack/bitcoin.html' class='game-popup-coin'><img
                                src='index/assets/coins/BTC.png' alt='Bitcoin'/>Bitcoin (BTC)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='blackjack/ethereum.html' class='game-popup-coin'><img
                                src='index/assets/coins/ETH.png' alt='Ethereum'/>Ethereum (ETH)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='blackjack/litecoin.html' class='game-popup-coin'><img
                                src='index/assets/coins/LTC.png' alt='Litecoin'/>Litecoin (LTC)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='blackjack/solana.html' class='game-popup-coin'><img
                                src='index/assets/coins/SOL.png' alt='Solana'/>Solana (SOL)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='blackjack/dogecoin.html' class='game-popup-coin'><img
                                src='index/assets/coins/DOGE.png' alt='Dogecoin'/>Dogecoin (DOGE)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='blackjack/monero.html' class='game-popup-coin'><img
                                src='index/assets/coins/XMR.png' alt='Monero'/>Monero (XMR)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='blackjack/bitcoincash.html'
                                                            class='game-popup-coin'><img
                                src='index/assets/coins/BCH.png' alt='BitcoinCash'/>BitcoinCash (BCH)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='blackjack/ethereumclassic.html'
                                                            class='game-popup-coin'><img
                                src='index/assets/coins/ETC.png' alt='EthereumClassic'/>EthereumClassic (ETC)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='blackjack/dash.html' class='game-popup-coin'><img
                                src='index/assets/coins/DASH.png' alt='Dash'/>Dash (DASH)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='blackjack/neogas.html' class='game-popup-coin'><img
                                src='index/assets/coins/GAS.png' alt='NeoGas'/>NeoGas (GAS)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='blackjack/playmoney.html' class='game-popup-coin'><img
                                src='index/assets/coins/PLAY.png' alt='PlayMoney'/>PlayMoney (PLAY)</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class='game-popup-wrapper animate__animated ' id='game-popup-minesweeper' style='display: none;'>
        <div class='game-popup-overlay animate__animated animate__fadeIn'
             onclick="if (!window.__cfRLUnblockHandlers) return false; closePopup(&quot;minesweeper&quot;)"
             data-cf-modified-68380b26a5082d0829e5b438-=""></div>
        <div class='container'>
            <div class='game-popup animate__animated animate__fadeInDown'
                 style='background-image: url("{{ asset('assets/games/minesweeper-bg.png') }}")'>
                <div class='game-popup-close-btn'
                     onclick="if (!window.__cfRLUnblockHandlers) return false; closePopup(&quot;minesweeper&quot;)"
                     data-cf-modified-68380b26a5082d0829e5b438-="">
                    <svg viewBox='0 0 24 24'>
                        <path
                            d='M5.293 6.707l5.293 5.293-5.293 5.293c-0.391 0.391-0.391 1.024 0 1.414s1.024 0.391 1.414 0l5.293-5.293 5.293 5.293c0.391 0.391 1.024 0.391 1.414 0s0.391-1.024 0-1.414l-5.293-5.293 5.293-5.293c0.391-0.391 0.391-1.024 0-1.414s-1.024-0.391-1.414 0l-5.293 5.293-5.293-5.293c-0.391-0.391-1.024-0.391-1.414 0s-0.391 1.024 0 1.414z'></path>
                    </svg>
                </div>

                <div class='game-popup-header'>
                    <img class='game-popup-header-icon' src='{{ asset('assets/games/minesweeper.png') }}'
                         alt='Minesweeper'/>
                    <div class='game-popup-header-info'>
                        <div class='game-popup-header-edge'>1.0% Edge</div>
                        <div class='game-popup-header-name'>Minesweeper</div>
                        <div class='game-popup-header-description'>Minesweeper is a single-player puzzle video game. The
                            objective of the game is to clear a rectangular board containing hidden "mines" or bombs
                            without detonating any of them.
                        </div>
                    </div>
                </div>
                <div class='game-popup-coins-title'>Select the coin you would like to play with</div>
                <div class='game-popup-coins row'>
                    <div class='col-6 col-md-4 col-lg-3'><a href='minesweeper/bitcoin.html' class='game-popup-coin'><img
                                src='index/assets/coins/BTC.png' alt='Bitcoin'/>Bitcoin (BTC)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='minesweeper/ethereum.html'
                                                            class='game-popup-coin'><img
                                src='index/assets/coins/ETH.png' alt='Ethereum'/>Ethereum (ETH)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='minesweeper/litecoin.html'
                                                            class='game-popup-coin'><img
                                src='index/assets/coins/LTC.png' alt='Litecoin'/>Litecoin (LTC)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='minesweeper/solana.html' class='game-popup-coin'><img
                                src='index/assets/coins/SOL.png' alt='Solana'/>Solana (SOL)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='minesweeper/dogecoin.html'
                                                            class='game-popup-coin'><img
                                src='index/assets/coins/DOGE.png' alt='Dogecoin'/>Dogecoin (DOGE)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='minesweeper/monero.html' class='game-popup-coin'><img
                                src='index/assets/coins/XMR.png' alt='Monero'/>Monero (XMR)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='minesweeper/bitcoincash.html' class='game-popup-coin'><img
                                src='index/assets/coins/BCH.png' alt='BitcoinCash'/>BitcoinCash (BCH)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='minesweeper/ethereumclassic.html'
                                                            class='game-popup-coin'><img
                                src='index/assets/coins/ETC.png' alt='EthereumClassic'/>EthereumClassic (ETC)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='minesweeper/dash.html' class='game-popup-coin'><img
                                src='index/assets/coins/DASH.png' alt='Dash'/>Dash (DASH)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='minesweeper/neogas.html' class='game-popup-coin'><img
                                src='index/assets/coins/GAS.png' alt='NeoGas'/>NeoGas (GAS)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='minesweeper/playmoney.html'
                                                            class='game-popup-coin'><img
                                src='index/assets/coins/PLAY.png' alt='PlayMoney'/>PlayMoney (PLAY)</a></div>
                </div>
            </div>
        </div>
    </div>

    <div class='game-popup-wrapper animate__animated ' id='game-popup-plinko' style='display: none;'>
        <div class='game-popup-overlay animate__animated animate__fadeIn'
             onclick="if (!window.__cfRLUnblockHandlers) return false; closePopup(&quot;plinko&quot;)"
             data-cf-modified-68380b26a5082d0829e5b438-=""></div>
        <div class='container'>
            <div class='game-popup animate__animated animate__fadeInDown'
                 style='background-image: url("{{ asset('assets/games/plinko-bg.png') }}")'>
                <div class='game-popup-close-btn'
                     onclick="if (!window.__cfRLUnblockHandlers) return false; closePopup(&quot;plinko&quot;)"
                     data-cf-modified-68380b26a5082d0829e5b438-="">
                    <svg viewBox='0 0 24 24'>
                        <path
                            d='M5.293 6.707l5.293 5.293-5.293 5.293c-0.391 0.391-0.391 1.024 0 1.414s1.024 0.391 1.414 0l5.293-5.293 5.293 5.293c0.391 0.391 1.024 0.391 1.414 0s0.391-1.024 0-1.414l-5.293-5.293 5.293-5.293c0.391-0.391 0.391-1.024 0-1.414s-1.024-0.391-1.414 0l-5.293 5.293-5.293-5.293c-0.391-0.391-1.024-0.391-1.414 0s-0.391 1.024 0 1.414z'></path>
                    </svg>
                </div>

                <div class='game-popup-header'>
                    <img class='game-popup-header-icon' src='{{ asset('assets/games/plinko.png') }}' alt='Plinko'/>
                    <div class='game-popup-header-info'>
                        <div class='game-popup-header-edge'>1.72% Edge</div>
                        <div class='game-popup-header-name'>Plinko</div>
                        <div class='game-popup-header-description'>Plinko is a very simple game where you drop a ball
                            from the top of a pegged pyramid and watch it randomly bounce all the way to the bottom.
                            Once it reaches the bottom, the slot that it falls into corresponds to a payout value.
                        </div>
                    </div>
                </div>
                <div class='game-popup-coins-title'>Select the coin you would like to play with</div>
                <div class='game-popup-coins row'>
                    <div class='col-6 col-md-4 col-lg-3'><a href='plinko/bitcoin.html' class='game-popup-coin'><img
                                src='index/assets/coins/BTC.png' alt='Bitcoin'/>Bitcoin (BTC)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='plinko/ethereum.html' class='game-popup-coin'><img
                                src='index/assets/coins/ETH.png' alt='Ethereum'/>Ethereum (ETH)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='plinko/litecoin.html' class='game-popup-coin'><img
                                src='index/assets/coins/LTC.png' alt='Litecoin'/>Litecoin (LTC)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='plinko/solana.html' class='game-popup-coin'><img
                                src='index/assets/coins/SOL.png' alt='Solana'/>Solana (SOL)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='plinko/dogecoin.html' class='game-popup-coin'><img
                                src='index/assets/coins/DOGE.png' alt='Dogecoin'/>Dogecoin (DOGE)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='plinko/monero.html' class='game-popup-coin'><img
                                src='index/assets/coins/XMR.png' alt='Monero'/>Monero (XMR)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='plinko/bitcoincash.html' class='game-popup-coin'><img
                                src='index/assets/coins/BCH.png' alt='BitcoinCash'/>BitcoinCash (BCH)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='plinko/ethereumclassic.html'
                                                            class='game-popup-coin'><img
                                src='index/assets/coins/ETC.png' alt='EthereumClassic'/>EthereumClassic (ETC)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='plinko/dash.html' class='game-popup-coin'><img
                                src='index/assets/coins/DASH.png' alt='Dash'/>Dash (DASH)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='plinko/neogas.html' class='game-popup-coin'><img
                                src='index/assets/coins/GAS.png' alt='NeoGas'/>NeoGas (GAS)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='plinko/playmoney.html' class='game-popup-coin'><img
                                src='index/assets/coins/PLAY.png' alt='PlayMoney'/>PlayMoney (PLAY)</a></div>
                </div>
            </div>
        </div>
    </div>

    <div class='game-popup-wrapper animate__animated ' id='game-popup-lottery' style='display: none;'>
        <div class='game-popup-overlay animate__animated animate__fadeIn'
             onclick="if (!window.__cfRLUnblockHandlers) return false; closePopup(&quot;lottery&quot;)"
             data-cf-modified-68380b26a5082d0829e5b438-=""></div>
        <div class='container'>
            <div class='game-popup animate__animated animate__fadeInDown'
                 style='background-image: url("{{ asset('assets/games/lottery-bg.png') }}")'>
                <div class='game-popup-close-btn'
                     onclick="if (!window.__cfRLUnblockHandlers) return false; closePopup(&quot;lottery&quot;)"
                     data-cf-modified-68380b26a5082d0829e5b438-="">
                    <svg viewBox='0 0 24 24'>
                        <path
                            d='M5.293 6.707l5.293 5.293-5.293 5.293c-0.391 0.391-0.391 1.024 0 1.414s1.024 0.391 1.414 0l5.293-5.293 5.293 5.293c0.391 0.391 1.024 0.391 1.414 0s0.391-1.024 0-1.414l-5.293-5.293 5.293-5.293c0.391-0.391 0.391-1.024 0-1.414s-1.024-0.391-1.414 0l-5.293 5.293-5.293-5.293c-0.391-0.391-1.024-0.391-1.414 0s-0.391 1.024 0 1.414z'></path>
                    </svg>
                </div>

                <div class='game-popup-header'>
                    <img class='game-popup-header-icon' src='{{ asset('assets/games/lottery.png') }}' alt='Lottery'/>
                    <div class='game-popup-header-info'>
                        <div class='game-popup-header-edge'>0.0% Edge</div>
                        <div class='game-popup-header-name'>Lottery</div>
                        <div class='game-popup-header-description'>A lottery is a game of chance or process in which
                            winners are selected by a random drawing. The draw takes place five times per week.
                        </div>
                    </div>
                </div>
                <div class='game-popup-coins-title'>Select the coin you would like to play with</div>
                <div class='game-popup-coins row'>
                    <div class='col-6 col-md-4 col-lg-3'><a href='lottery/bitcoin.html' class='game-popup-coin'><img
                                src='index/assets/coins/BTC.png' alt='Bitcoin'/>Bitcoin (BTC)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='lottery/ethereum.html' class='game-popup-coin'><img
                                src='index/assets/coins/ETH.png' alt='Ethereum'/>Ethereum (ETH)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='lottery/litecoin.html' class='game-popup-coin'><img
                                src='index/assets/coins/LTC.png' alt='Litecoin'/>Litecoin (LTC)</a></div>
                    <div class='col-6 col-md-4 col-lg-3'><a href='lottery/dogecoin.html' class='game-popup-coin'><img
                                src='index/assets/coins/DOGE.png' alt='Dogecoin'/>Dogecoin (DOGE)</a></div>
                </div>
            </div>
        </div>
    </div>

    <section id="features-section">
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="feature">
                    <img class="feature-icon" src="{{ asset('assets/icons/vip.png') }}"/>
                    <h2 class="feature-title">VIP membership</h2>
                    <p class="feature-message">Become a Premium VIP Member for a month and enjoy the benefits that will
                        enrich your gambling adventures.</p>
                </div>
            </div>

            <div class="col-sm-6 col-md-4">
                <div class="feature">
                    <img class="feature-icon" src="{{ asset('assets/icons/provably-fair.png') }}"/>
                    <h2 class="feature-title">Provably fair</h2>
                    <p class="feature-message">We utilize the industry standard for provably fair gaming. Verify
                        drawings with our or 3rd party verification tools.</p>
                </div>
            </div>

            <div class="col-sm-6 col-md-4">
                <div class="feature">
                    <img class="feature-icon" src="{{ asset('assets/icons/fast-withdrawals.png') }}"/>
                    <h2 class="feature-title">Fast withdrawals</h2>
                    <p class="feature-message">Get your winnings paid out to your wallet on your own terms. Simply
                        select the withdrawal speed and confirm.</p>
                </div>
            </div>

            <div class="col-sm-6 col-md-4">
                <div class="feature">
                    <img class="feature-icon" src="{{ asset('assets/icons/progressive-jackpots.png') }}"/>
                    <h2 class="feature-title">Progressive jackpots</h2>
                    <p class="feature-message">With every bet on dice and roulette you have the chance to win our ever
                        growing jackpot.</p>
                </div>
            </div>

            <div class="col-sm-6 col-md-4">
                <div class="feature">
                    <img class="feature-icon" src="{{ asset('assets/icons/low-house-edge.png') }}"/>
                    <h2 class="feature-title">Low house edge</h2>
                    <p class="feature-message">You’re here to win often and a lot. Our games have extremely low house
                        edge, starting at only 1%.</p>
                </div>
            </div>

            <div class="col-sm-6 col-md-4">
                <div class="feature">
                    <img class="feature-icon" src="{{ asset('assets/icons/secure-and-private.png') }}"/>
                    <h2 class="feature-title">Secure and private</h2>
                    <p class="feature-message">We don’t collect sensitive private information such as bank accounts,
                        which makes your stay with us safe and private.</p>
                </div>
            </div>
        </div>
    </section>


    <!---------------- Social ---------------->
    <section class="social-section">
        <div class="row justify-content-center">
            <a href="https://www.facebook.com/CryptoGames/" title="Facebook" target="_blank"
               class="social mr-4 mr-md-5">
                <img src="{{ asset('assets/icons/facebook.png') }}"/></a>
            <a href="https://twitter.com/Crypto_Games" title="Twitter" target="_blank" class="social mr-4 mr-md-5">
                <img src="{{ asset('assets/icons/twitter.png') }}"/></a>
            <a href="https://discord.gg/Z6tD7kD" title="Discord" target="_blank" class="social mr-4 mr-md-5">
                <img src="{{ asset('assets/icons/discord.png') }}"/></a>
            <a href="https://www.youtube.com/user/GamesCrypto?sub_confirmation=1" title="Youtube" target="_blank"
               class="social mr-4 mr-md-5">
                <img src="{{ asset('assets/icons/youtube.png') }}"/>
            </a>
        </div>
    </section>


    <section id="jackpot-section">
        <div class="jackpots">

        </div>
    </section>
</div>

<div id="footer">
    <footer>
        <div class="container">
            <div class="footer-partners">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <a href="https://itechlabs.com/certificates/muchgaming/RNG_Certificate_UK_MuchGaming_17Nov20.pdf"
                           target="_blank" rel="noreferrer noopener">
                            <img src="images/itechRNG.png" height="50" alt="iTech Labs RNG Certificate"/>
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="https://cryptogambling.org/" target="_blank" rel="noreferrer noopener">
                            <img src="images/cgf.png" height="50" alt="CryptoGamingFoundation"/>
                        </a>
                    </div>
                </div>
            </div>

            <div class="footer-links">
                <a class="btn footer-link a_index" href="faq%3Fstyle=7.html">FAQ</a>
                <a class="btn footer-link a_index" href="https://crypto.games/terms?style=7">Terms of Service</a>
                <a class="btn footer-link a_index" href="https://crypto.games/privacy?style=7">Privacy Policy</a>
                <a class="btn footer-link a_index" href="responsiblegaming%3Fstyle=7.html">Responsible Gaming</a>
                <a class="btn footer-link a_index" href="selfexclusion%3Fstyle=7.html">Self-Exclusion</a>
                <a class="btn footer-link a_index" href="fairness%3Fstyle=7.html">Fairness</a>
                <a class="btn footer-link a_index" href="https://crypto.games/codeofconduct?style=7">Code of Conduct</a>
                <a class="btn footer-link a_index" href="disputeresolution%3Fstyle=7.html">Dispute Resolution</a>
                <a class="btn footer-link a_index" href="partners%3Fstyle=7.html">Partners</a>
                <a class="btn footer-link a_index" href="https://crypto.games/aml?style=7">AML statement</a>
                <a class="btn footer-link a_index" href="https://crypto.games/aboutus?style=7">About us</a>
                <a class="btn footer-link a_index" href="vip%3Fstyle=7.html">VIP Membership</a>
                <a class="btn footer-link" target="_blank" href="https://forum.crypto.games/promotions/">Promotions</a>
                <a class="btn footer-link" target="_blank" href="https://blog.crypto.games">Blog</a>
                <a class="btn footer-link" target="_blank" href="https://forum.crypto.games">Forum</a>
                <a class="btn footer-link" target="_blank" href="http://status.crypto.games">Status page</a>
            </div>

            <div class="copyright">
                CryptoGames is owned and operated by MuchGaming B.V. situated at Fransche Bloemweg 4, Willemstad,
                Curaçao.<br/>
                © 2021 CryptoGames operates under the License No. 8048/JAZ issued to Antillephone, Authorized and
                Regulated by the Government of Curacao.
            </div>
        </div>
    </footer>
</div>


<script src="{{ asset('js/jquery-2.1.0.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="{{ asset('js/main-page.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/fancybox/jquery.fancybox.pack.js') }}" type="text/javascript"></script>


<script type="text/javascript">

    if (top.location != self.location) {
        top.location = self.location.href;
    }

    $(document).ready(function () {
        $(".a_index").fancybox({
            autoscale: true,
            transitionIn: 'none',
            transitionOut: 'none',
            type: 'iframe',
        });
    });


</script>
<script src="{{ asset('js/rocket-loader.min.js') }}"
        data-cf-settings="68380b26a5082d0829e5b438-|49" defer=""></script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/v652eace1692a40cfa3763df669d7439c1639079717194"
        integrity="sha512-Gi7xpJR8tSkrpF7aordPZQlW2DLtzUlZcumS8dMQjwDHEnw9I7ZLyiOj/6tZStRBGtGgN6ceN6cMH8z7etPGlw=="
        data-cf-beacon='{"rayId":"6cfaca308f5bcc8b","token":"520b949809f841929d9c3a5c1c83d877","version":"2021.12.0","si":100}'
        crossorigin="anonymous"></script>
</body>
</html>
