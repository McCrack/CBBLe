@extends('CBBLe.layouts.mount')

@section('toolbar')

<button
    name="upload"
    form="explorer-{{ $handle }}"
    class="tooltip b h-32 px-5px mx-4 btn transparent"
    data-title="{{ $translate->explorer('upload') }}">
    <svg viewBox="0 0 512 512" height="26">
        <use fill="white" xlink:href="/c-bble/icons/main.svg#cloud"></use>
    </svg>
</button>
<button
    name="remove"
    form="explorer-{{ $handle }}"
    class="tooltip b h-32 px-5px mx-4 btn transparent"
    data-title="{{ $translate->explorer('delete selected') }}">
    <svg viewBox="0 0 512 512" height="26">
        <use fill="white" xlink:href="/c-bble/icons/main.svg#trash"></use>
    </svg>
</button>
<button
    name="create"
    form="explorer-{{ $handle }}"
    class="tooltip b h-32 px-5px mx-4 btn transparent"
    data-title="{{ $translate->explorer('create directory') }}">
    <svg viewBox="0 0 512 512" height="24">
        <use fill="white" xlink:href="/c-bble/icons/main.svg#addfolder"></use>
    </svg>
</button>

@endsection

@section('body')
<form id="explorer-{{ $handle }}" class="pop-up-body overflow-auto w-920 white-bg vh-75 resize-b font-none">
    <object data="/Explorer/content?{{ $query }}" class="w-100 h-100"></object>
    <script>
    (function(form){
        var explorer = form.querySelector("object");
        form.parentNode.querySelectorAll("svg").forEach(function (svg) {
            svg.parentNode.replaceChild(svg.cloneNode(true), svg)
        });
        form.upload.onclick = function(event){
            event.preventDefault();
            explorer.contentWindow.upload();
        }
        form.create.onclick = function(event){
            event.preventDefault();
            explorer.contentWindow.createDirectory("{{ $translate->explorer('create directory') }}");
        }
        form.remove.onclick = function(event){
            event.preventDefault();
            explorer.contentWindow.removeSelected("{{ $translate->alerts('delete selected') }}?");
        }
        form.onsubmit = function(event){
            event.preventDefault();
        }
        form.onreset = function(event){
            event.preventDefault();
            PopUpPool['{{ $handle }}'].drop();
        }
    })(document.currentScript.parentNode)
    </script>
</form>
@endsection

@section('footer')
@if($button)
<div class="pop-up-footer light-bg align-right px-10px py-5px">
	<button type="submit" form="explorer-{{ $handle }}" class="btn btn-md primary-bg hover-danger-bg white-txt">{{ $translate->{$button} }}</button>
	<button type="reset"  form="explorer-{{ $handle }}" class="btn btn-md dark-bg hover-danger-bg white-txt">{{ $translate->cancel }}</button>
</div>
@endif
@endsection