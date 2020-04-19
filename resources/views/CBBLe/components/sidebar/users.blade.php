<button
    class="float-right m-5 btn transparent"
    title="{{ $translate->add }} {{ $translate->dictionary }}"
    onclick="new POPUP('/Users/0')">
    <svg viewBox="0 0 512 512" height="24">
        <use fill="#56AAFF" xlink:href="/c-bble/icons/main.svg#adduser"></use>
    </svg>
</button>
<p class="m-10 mb-0 text-bold font-20 primary-txt">Staff</p>
<div class="px-20px py-10px">
	@foreach(Users::index() as $role => $group)
	    <div class="uppercase text-thin">{{ $role }}</div>
		<div class="py-10px ml-5 border-left-dark">
		    @foreach($group as $usr)
			<label
                onclick="new POPUP('/Users/{{ $usr->id }}')"
                class="block capitalize cursor-pointer hover-primary-txt">
                <span class="dark-txt">一</span> {{ $usr->name }}
            </label>
		    @endforeach
	    </div>
	@endforeach
</div>