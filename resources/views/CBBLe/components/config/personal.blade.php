<form class="p-10px w-50 border-box">
    
    <p class="font-14 primary-txt text-bold">Personal:</p>
    
    <div class="m-5">
        <label class="block">{{ $translate->theme }}</label>
        <div class="select w-100">
            <input name="theme" value="{{ ($personal['theme'] ?? $global['theme'] ?? null) }}" class="field w-100 cursor-pointer" readonly>
            <fieldset
                onmousedown="this.form.customSelect('theme', event.target.textContent)"
                class="absolute w-100 sidebar-bg white-txt shadow-light font-12 z-index-2">
                @foreach($themes as $theme)
                <label class="hover-primary-bg">{{ $theme['filename'] }}</label>
                @endforeach
            </fieldset>
        </div>
    </div>
    <div class="m-5">
        <label class="block">{{ $translate->language }}</label>
        <div class="select w-100">
            <input name="language" value="{{ ($personal['language'] ?? $global['language'] ?? null) }}" class="field w-100 cursor-pointer" readonly>
            <fieldset
                onmousedown="this.form.customSelect('language', event.target.textContent)"
                class="absolute w-100 sidebar-bg white-txt shadow-light font-12 z-index-2">
                @foreach($global['languages'] as $lang)
                <label class="hover-primary-bg">{{ $lang }}</label>
                @endforeach
            </fieldset>
        </div>
    </div>
    <script>
    (function(form){
        form.onsubmit = function(event){
            event.preventDefault();
        }
        form.customSelect = function(field, val){
            if(form[field].value != val){
                SaveIndicator.checked = true;
                form[field].value = val;
                
                form.save(field, val);
            }
        }
        form.oninput = function(event){
            SaveIndicator.checked = true;
            clearTimeout(TIMEOUT);
            TIMEOUT = setTimeout(function(){
                if(event.target.type == "checkbox"){
                    var value = [];
                    form[event.target.name].forEach(function(inp){
                        if(inp.checked){
                            value.push(inp.value);
                        }
                    });
                }else{
                    var value = event.target.value;
                }
                form.save(event.target.name, value);
            }, 3000);
        }
        form.save = function(field, value){
            XHR.json({
                method: "PUT",
                addressee: "/Settings/personal",
                body: {
                    name: field,
                    value: value
                },
                onsuccess: function(response){
                    response = JSON.parse(response);
                    if(response.status == "Success"){
                        SaveIndicator.checked = false;
                    }
                }
            });
        }
    })(document.currentScript.parentNode)
    </script>
</form>