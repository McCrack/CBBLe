<div class="p-10px">
@foreach (array_map(function($path){
    return (in_array(Auth::user()->role, JSON::load($path)['access']))
        ? basename(dirname($path))
        : null;
}, glob("../app/CBBLe/Extensions/*/config.json")) as $item)
    @isset($item)
    <a class="block py-10px border-bottom-dark @if($extension == $item) danger-txt @endif hover-primary-txt" href="/{{ $item }}">{{ $item }}</a>
    @endisset
@endforeach
</div>