<template id="alert">
    <form onclick="this.reset()" class="modal-mount fixed top left bottom right substrate overflow-auto z-index-100">
        <div class="pop-up absolute p-10px shadow-bold overflow-hidden rounded-5 w-320 dark-bg" onclick="event.cancelBubble=true">
            <div class="mt-30 py-20px px-10px align-center text-bold white-txt font-16">
                <output name="message"></output>
            </div>
            <div class="pop-up-footer align-center p-10px">
	            <button type="reset" class="btn btn-lg transparent hover-underline white-txt mr-5">[ Ok ]</button>
            </div>
        </div>
    </form>
</template>

<template id="confirm">
    <form onclick="this.reset()" class="modal-mount fixed top left bottom right substrate overflow-auto z-index-100">
        <div class="pop-up absolute p-10px shadow-bold overflow-hidden rounded-5 w-320 danger-bg" onclick="event.cancelBubble=true">
            <div class="mt-30 py-20px px-10px my-10 align-center text-bold white-txt font-16">
                <output name="message"></output>
            </div>
            <div class="pop-up-footer align-center p-10px">
	            <button type="submit" class="btn btn-md transparent hover-underline white-txt mr-5">[ {{ $translate->apply }} ]</button>
	            <button type="reset" class="btn btn-md transparent hover-underline white-txt mr-5">[ {{ $translate->cancel }} ]</button>
            </div>
        </div>
    </form>
</template>

<template id="prompt">
    <form onclick="this.reset()" class="modal-mount fixed top left bottom right substrate overflow-auto z-index-100">
        <div class="pop-up absolute p-10px shadow-bold overflow-hidden rounded-5 w-320 dark-bg" onclick="event.cancelBubble=true">
            <div class="mt-30 pt-10px pb-20px px-10px align-center text-bold white-txt font-16">
                <output name="message"></output>
                <input name="field" class="field w-100 mt-4 light-rainbow align-center" placeholder="..." autocomplete="off" required>
            </div>
            <div class="pop-up-footer align-center p-10px">
	            <button type="submit" class="btn btn-md transparent hover-underline white-txt mr-5">[ {{ $translate->apply }} ]</button>
	            <button type="reset" class="btn btn-md transparent hover-underline white-txt mr-5">[ {{ $translate->cancel }} ]</button>
            </div>
        </div>
    </form>
</template>