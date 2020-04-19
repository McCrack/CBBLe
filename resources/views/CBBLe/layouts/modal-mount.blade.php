<div id="{{ $handle }}" class="modal-mount fixed top left bottom right substrate overflow-auto z-index-100" onclick="PopUpPool['{{ $handle }}'].drop()">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <div class="pop-up absolute shadow-bold overflow-hidden rounded-3" onclick="event.cancelBubble=true">
        <div class="pop-up-topbar bar-bg white-txt">
            <button
				class="float-right transparent border-none h-24 font-14 white-txt m-5 cursor-pointer"
				onclick="PopUpPool['{{ $handle }}'].drop()"
				title="{{ $translate->close }}">✕</button>
            <div class="pop-up-caption font-14 px-10px py-10px inline-block cursor-move text-medium">
                {{ $caption }}
                <script>
                (function(bar){
	                bar.onmousedown=function(event){
		                event.preventDefault();
		                var popup = bar.parent(2),
			                y = event.clientY - popup.offsetTop,
			                x = event.clientX - popup.offsetLeft;
		                document.onmousemove=function(event){
			                let top = event.clientY - y;
			                let left = event.clientX - x;
			                popup.style.top = (top > 0) ? top+"px" : "0";
			                popup.style.left = (left > 0) ? left+"px" : "0";
		                }
		                document.onmouseup=function(){
			                document.onmousemove = null;
		                }
	                }
                })(document.currentScript.parentNode)
                </script>
            </div>
            <div class="inline-block align-center valign-middle">
		        @yield('toolbar')
            </div>
        </div>
        
        @yield('body')

        @yield('footer')
    </div>
</div>