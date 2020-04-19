<div id="{{ $handle }}" class="mount fixed z-index-100">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <div class="pop-up shadow-bold overflow-hidden rounded-3">
        <button
            class="absolute top right transparent border-none h-24 font-14 white-txt m-5 cursor-pointer"
            onclick="PopUpPool['{{ $handle }}'].drop()"
            title="{{ $translate->close }}">✕</button>
        <div class="pop-up-topbar bar-bg white-txt flex flex-items-center justify-start">
            <div class="uppercase font-16 px-20px py-10px inline-block cursor-move text-medium">
                {{ $caption }}
                <script>
                (function(bar){
	                bar.onmousedown=function(event){
		                event.preventDefault();
		                var mount = bar.parent(3),
			                y = event.clientY - mount.offsetTop,
			                x = event.clientX - mount.offsetLeft;
                        for (var handle in PopUpPool) {
                            PopUpPool[handle].mount.style.zIndex = 99;
                        }
                        mount.style.zIndex = 100;
		                var substrate = document.create("div", {
                            class: "fixed top left bottom right z-index-100"
                        });
		                document.body.appendChild(substrate);
		                document.onmousemove=function(event){
			                let top = event.clientY - y;
			                let left = event.clientX - x;
			                mount.style.top = (top > 0) ? top+"px" : "0";
			                mount.style.left = (left > 0) ? left+"px" : "0";
		                }
		                document.onmouseup = function(){
			                document.onmouseup =
                            document.onmousemove = null;
			                document.body.removeChild(substrate);
		                }
	                }
                })(document.currentScript.parentNode)
                </script>
            </div>
		    @yield('toolbar')
        </div>
        
        @yield('body')

        @yield('footer')
    </div>
</div>