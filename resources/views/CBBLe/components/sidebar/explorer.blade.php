@foreach($root as $folder => $content)
    <label onclick="new POPUP('/Explorer/show/radio/add?path={{ $path }}/{{ $folder }}')" class="block text-light my-8 cursor-pointer hover-primary-txt">
        <span class="dark-txt">-</span>
        <svg viewBox="0 0 512 512" width="18" class="valign-bottom">
            <use fill="#888" xlink:href="/c-bble/icons/main.svg#folder"></use>
        </svg>
        {{ $folder }}
    </label>
    @if(is_array($content))
    <div class="ml-20 border-left-dark">
        @include('CBBLe.components.sidebar.explorer', [
            'root' => $content,
            'path' => "{$path}/{$folder}"
        ])
    </div>
    @endif
@endforeach