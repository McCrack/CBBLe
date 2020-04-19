<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('c-bble/css/c-bble.css') }}">
    <link rel="stylesheet" href="{{ asset("c-bble/css/layout.css") }}">
    <link rel="stylesheet" href="{{ asset("c-bble/css/themes/{$config->theme}.css") }}">

    <script defer src="{{ asset('js/c-bble.js') }}"></script>
    <script defer src="{{ asset('c-bble/js/main.js') }}"></script>
    <script defer src="{{ asset('c-bble/js/explorer.js') }}"></script>
</head>
<body>
    <form id="directory" class="explorer grid grid-gap-5 font-12 align-center p-20px">
        @if($hasOutDir)
        <label class="folder" data-path="{{ $root }}">
            <div>
                <svg viewBox="0 0 512 512" height="80" class="inline-block">
                    <use fill="#F0F6FF" xlink:href="/c-bble/icons/explorer.svg#outfolder"></use>
                </svg>
                <div class="">●●</div>
            </div>
        </label>
        @endif
        @foreach($content as $file)
        @switch($file->type)
            @case("dir")
            <label
                class="folder"
                data-path="{{ $file->path }}"
                data-type="directory">
                @if($checkmode == "checkbox")
                <input
                    type="checkbox"
                    name="file"
                    value="{{ $file->path }}"
                    hidden>
                @endif
                <div>
                    <svg viewBox="0 0 512 512" height="80" class="inline-block">
                        <use fill="#56AAFF" xlink:href="/c-bble/icons/explorer.svg#folder"></use>
                    </svg>
                    <div>{{ $file->getBasename() }}</div>
                </div>
            </label>
            @break
            @case("image")
            <label
                class="file"
                data-path="{{ $file->path }}"
                data-type="image">
                <input
                    name="file"
                    type="{{ $checkmode }}"
                    value="{{ $file->path }}"
                    data-uri="{{ $file->uri }}"
                    hidden>
                <div>
                    <img src="{{ asset($file->uri) }}" height="80" alt="{{ $file->type }}" class="fit-contain">
                    <div>{{ $file->getBasename() }}</div>
                </div>
            </label>
            @break
            @default
            <label
                class="file"
                data-path="{{ $file->path }}"
                data-type="{{ $file->type }}">
                <input
                    name="file"
                    type="{{ $checkmode }}"
                    value="{{ $file->path }}"
                    data-uri="{{ $file->uri }}"
                    hidden>
                <div>
                    <svg viewBox="0 0 512 512" height="80" class="inline-block">
                        <use fill="#56AAFF" xlink:href="/c-bble/icons/explorer.svg#{{ $file->type }}"></use>
                    </svg>
                    <div>{{ $file->getBasename() }}</div>
                </div>
            </label>
            @break
        @endswitch
        @endforeach
        <script>
        var CONTEXT_MENU = null;
        const CURRENT_PATH = "{{ $current }}";
        (function(form){
            form.querySelectorAll('label').forEach(function(item){
                item.ondblclick = function(event){
                    if(item.classList.contains('folder')){
                        let set = parse_url(location.href).search;
                            set.path = item.dataset.path;
                        location.search = "?" + set.join('=', '&');
                    }else{
                        download(item.dataset.path);
                    }
                }
                item.oncontextmenu = function(event) {
					event.preventDefault();
                    event.cancelBubble = true;
                    try{
                        document.body.removeChild(CONTEXT_MENU);
                    }catch(e){}
                    showContextMenu(item, event);
				}
            });
            document.oncontextmenu = function(event) {
                event.preventDefault();
                try{
                    document.body.removeChild(CONTEXT_MENU);
                }catch(e){}
                showContextMenu(document.querySelector("#directory"), event);
            }
        })(document.currentScript.parentNode)
        </script>
    </form>
    <template id="context-menu">
        <button name="copy" class="border-none align-left cursor-pointer soft-bg hover-primary-bg">{{ $translate->explorer('copy') }}</button>
        <button name="cut" class="border-none align-left cursor-pointer soft-bg hover-primary-bg">{{ $translate->explorer('cut') }}</button>
        <button name="rename" class="border-none align-left cursor-pointer soft-bg hover-primary-bg">{{ $translate->explorer('rename') }}</button>
        <button name="delete" class="border-none align-left cursor-pointer soft-bg hover-danger-bg">{{ $translate->explorer('delete') }}</button>
    </template>
    <template id="unzip-item">
        <button name="unzip" class="border-none align-left cursor-pointer soft-bg hover-primary-bg">{{ $translate->explorer('unzip') }}</button>
    </template>
    <template id="zip-item">
        <button name="zip" class="border-none align-left cursor-pointer soft-bg hover-primary-bg">{{ $translate->explorer('zip') }}</button>
    </template>
    <template id="root-context-menu">
        <button name="upload" class="border-none align-left cursor-pointer soft-bg hover-primary-bg">{{ $translate->explorer('upload') }}</button>
        <button name="create" class="border-none align-left cursor-pointer soft-bg hover-primary-bg">{{ $translate->explorer('create directory') }}</button>
        <button name="select" class="border-none align-left cursor-pointer soft-bg hover-primary-bg">{{ $translate->explorer('select all') }}</button>
    </template>
    <template id="paste-item">
        <button name="paste" class="border-none align-left cursor-pointer soft-bg hover-primary-bg">{{ $translate->explorer('paste') }}</button>
    </template>
</body>
</html>