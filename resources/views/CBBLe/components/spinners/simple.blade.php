<div class="slideshow flex p-1">
    <div class="slider relative overflow-hidden">
    @foreach($mediaset as $i=>$img)
        <input id="s-{{ $hendler }}-{{ $i }}" name="spinner-{{ $hendler }}" type="radio" hidden @if($loop->first) checked @endif>
        <figure class="slide absolute top left h-100 w-100">
            <img
            src="{{ $img['url'] }}"
            data-src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
            alt="{{ $img['alt'] }} Photo {{ ($i+1) }}"
            title="{{ $img['alt'] }} photo {{ ($i+1) }}"
            class="absolute top left h-100 w-100 fit-contain">
            @if(!$loop->first)
            <label class="absolute left cursor-pointer spinner-btn" for="s-{{ $hendler }}-{{ ($i-1) }}">❮</label>
            @endif
        
            @if(!$loop->last)
            <label class="absolute right cursor-pointer spinner-btn" for="s-{{ $hendler }}-{{ ($i+1) }}">❯</label>
            @endif
        </figure>
    @endforeach
    </div>
    <div class="img-list columns-3-lg columns-2-md">
    @foreach($mediaset as $i=>$img)
        <label for="s-{{ $hendler }}-{{ $i }}" class="cursor-pointer">
            <img
            src="{{ $img['url'] }}"
            data-src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
            alt="{{ $img['alt']}} preview"
            class="h-80 w-100 fit-cover border-dark rounded-3">
        </label>
    @endforeach
    </div>
</div>