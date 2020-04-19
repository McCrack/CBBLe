<p class="m-10 mb-0 text-bold font-20 primary-txt">Dictionaries</p>
<div class="px-20px py-10px">
    @foreach(Dictionaries::index() as $subdomain => $dictionaries)
        <div class="uppercase text-thin" data-subdomain="{{ $subdomain }}">
            {{ $subdomain }}
            <label
                title="{{ $translate->add }} {{ $translate->dictionary }}"
                onclick="addDictionary(this.parentNode)"
                class="valign-middle cursor-pointer font-18 white-txt hover-underline">
                <svg viewBox="0 0 512 512" height="18">
                    <use fill="#56AAFF" xlink:href="/c-bble/icons/main.svg#adddictionary"></use>
                </svg>
            </label>
        </div>
        <div class="py-10px ml-5 border-left-dark">
        @foreach($dictionaries as $dictionary)
            <label
            onclick="new POPUP('/Dictionaries/{{ $dictionary }}/{{ $subdomain }}')"
            class="block capitalize cursor-pointer hover-primary-txt">
                <span class="dark-txt">一</span>
                {{ $dictionary }}
            </label>
        @endforeach
        </div>
    @endforeach
</div>