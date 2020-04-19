<!DOCTYPE html>
<html prefix="og: https://ogp.me/ns#" lang="{{ $config->language }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $extension }} - {{ config('app.name') }}</title>

    <link rel="icon" href="/c-bble/favicon.svg" type="image/png">

    <meta name=msapplication-TileColor content="#000000">
    <meta name=theme-color content="#000000">

    <link rel="stylesheet" href="{{ asset('c-bble/css/c-bble.css') }}">
    <link rel="stylesheet" href="{{ asset('c-bble/css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset("c-bble/css/themes/{$config->theme}.css") }}">

    <script defer src="{{ asset('js/c-bble.js') }}"></script>
    <script defer src="{{ asset('c-bble/js/main.js') }}"></script>
    <script src="{{ asset('c-bble/js/ace/src-min/ace.js') }}"></script>
</head>
<body class="main-bg">
    <input id="sidebar-toggler" type="checkbox" hidden autocomplete="off">
    <div class="h-64 flex justify-between flex-items-center primary-bg white-txt shadow-light">
        <div class="nowrap">
            <span class="font-20 mr-20 px-20px valign-middle border-right-light">{{ config('app.name') }}</span>
            
            @yield('topbar')
        </div>
        
        <div class="font-12 flex flex-items-center pr-20px">

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mr-10 nowrap">
                {{ csrf_field() }}
                <button class="btn btn-sm danger-bg shadow-light white-txt mx-2" type="submit">Loagout</button>
                {{ Auth::user()->name }}
            </form>

            <div class="flex flex-align-center display-none-md ml-5">
                <label for="sidebar-toggler" class="sidebar-toggler cursor-pointer align-center">
			        <span class="hamburger inline-block relative">
				        <span class="block absolute"></span>
				        <span class="block absolute"></span>
			        </span>
		        </label>
            </div>
        </div>
    </div>
    <main class="grid relative">
        <aside class="sidebar overflow-hidden flex flex-items-stretch light-txt">
            <div class="bar icon font-24 light-txt h-100 flex flex-dir-col justify-between flex-items-center align-center">
                <div class="w-32">
                    <label data-title="{{ $translate->extensions }}" for="extensions-tab" class="tooltip r block py-5px cursor-pointer hover-underline">
                        <svg viewBox="0 0 512 512" height="24">
                            <use fill="#DDD" xlink:href="/c-bble/icons/main.svg#extensions"></use>
                        </svg>
                    </label>
                    @if(Dictionaries::checkAccess())
                    <label data-title="{{ $translate->dictionaries }}" for="dictionaries-tab" class="tooltip r block py-5px cursor-pointer hover-underline">
                        <svg viewBox="0 0 512 512" height="24">
                            <use fill="#BBB" xlink:href="/c-bble/icons/main.svg#dictionaries"></use>
                        </svg>
                    </label>
                    @endif
                    @if(Explorer::checkAccess())
                    <label data-title="Exolorer" for="explorer-tab" class="tooltip r block py-5px cursor-pointer hover-underline">
                        <svg viewBox="0 0 512 512" height="24">
                            <use fill="#777" xlink:href="/c-bble/icons/main.svg#folder"></use>
                        </svg>
                    </label>
                    @endif
                </div>
                <div></div>
                <div>
                    @if(Users::checkAccess())
                    <label data-title="{{ $translate->users }}" for="users-tab" class="tooltip r block py-5px cursor-pointer hover-underline">
                        <svg viewBox="0 0 512 512" height="24">
                            <use fill="#EEE" xlink:href="/c-bble/icons/main.svg#users"></use>
                        </svg>
                    </label>
                    @endif
                    <label data-title="{{ $translate->settings }}" onclick="new POPUP('/Settings/{{ $extension }}')" class="tooltip r block py-5px cursor-pointer hover-underline">
                        <svg viewBox="0 0 512 512" height="24">
                            <use fill="#DDD" xlink:href="/c-bble/icons/main.svg#settings"></use>
                        </svg>
                    </label>
                </div>
            </div>
            <nav class="h-100 flex-grow overflow-y-auto">
                <div class="tabs h-100 border-box">
                    <input id="extensions-tab" type="radio" name="sidebar-tabs" hidden checked autocomplete="on">
                    <label for="extensions-tab"></label>
                    <div class="tab px-10px border-box font-14">
                        @include('CBBLe.components.sidebar.extensions')
                    </div>

                    @if(Dictionaries::checkAccess())
                    <input id="dictionaries-tab" type="radio" name="sidebar-tabs" hidden autocomplete="on">
                    <label for="dictionaries-tab"></label>
                    <div class="tab border-box font-14">
                        @include('CBBLe.components.sidebar.dictionaries')
                    </div>
                    @endif

                    @if(Users::checkAccess())
                    <input id="users-tab" type="radio" name="sidebar-tabs" hidden autocomplete="on">
                    <label for="users-tab"></label>
                    <div class="tab border-box font-14">
                        @include('CBBLe.components.sidebar.users')
                    </div>
                    @endif

                    @if(Explorer::checkAccess())
                    <input id="explorer-tab" type="radio" name="sidebar-tabs" hidden autocomplete="on">
                    <label for="explorer-tab"></label>
                    <div class="tab border-box font-14 px-5px">
                        <p class="mt-10 ml-5 mb-0 text-bold font-20 primary-txt">Explorer</p>
                        <div class="py-5px ml-10 border-left-dark">
                        @include('CBBLe.components.sidebar.explorer', [
                            'root' => Explorer::index(),
                            'path' => "public"
                        ])
                        </div>
                    </div>
                    @endif

                    @yield('sidebar')
                    
                    <br clear="left">
                </div>
            </nav>
        </aside>
        <div>
            @yield('main')
        </div>
    </main>
    
    <form id="save-indicator" class="fixed right bottom">
        <input type="checkbox" name="indicator" autocomplete="off" hidden>
        <label class="icon font-24 white-txt inline-block w-48 h-48 align-center rounded m-5 shadow-light">💾</label>
        <script>
        var SaveIndicator;
        (function(form){
            SaveIndicator = form.indicator;
        })(document.currentScript.parentNode)
        </script>
    </form>
    @include('CBBLe.components.alerts')
</body>    
</html>