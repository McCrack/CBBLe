<div class="message white-bg border-light absolute shadow-light">
	<img src="{{ $image }}" class="fit-cover w-100 h-128">
	<article class="px-3 py-1 my-20 text-regular">
		<p class="h2 mb-5 text-medium">{{ $title }}</p>
		<p class="h3 mb-20 text-medium">{{ $subtitle }}</p>
		{!! $msg !!}
		<div class="align-right mt-20">
			<label for="message-toggler" class="btn btn-lg success-rainbow">Ok</label>
		</div>
	</article>
</div>