<form autocomplete="off">
    <div class="flex justify-between flex-items-center py-20px">
        <p class="text-bold font-18">Access to extension</p>
        <fieldset class="w-128 mr-20 pr-20px border-right">
            @foreach($roles as $item)
            <label class="capitalize block">
                <input
                    type="checkbox"
                    name="access"
                    @if(in_array($item->role, $extension['access'])) checked @endif
                    value="{{ $item->role }}">
                <span>{{ $item->role }}</span>
            </label>
            @endforeach
        </fieldset>

        <p class="text-bold font-18 ml-10">Privileged User Roles</p>
        <fieldset class="w-128">
            @foreach($roles as $item)
            <label class="capitalize block">
                <input
                    type="checkbox"
                    name="privileges"
                    @if(in_array($item->role, $extension['privileges'])) checked @endif
                    value="{{ $item->role }}">
                <span>{{ $item->role }}</span>
            </label>
            @endforeach
        </fieldset>
    </div>
    <script>
    (function(form){
        form.onsubmit = function(event){
            event.preventDefault();
        }
        form.oninput = function(event){
            SaveIndicator.checked = true;
            clearTimeout(TIMEOUT);
            TIMEOUT = setTimeout(function(){
                if(event.target.type == "checkbox"){
                    var value = [];
                    if(form[event.target.name].length > 0){
                        form[event.target.name].forEach(function(inp){
                            if(inp.checked){
                                value.push(inp.value);
                            }
                        });
                    }else if(event.target.checked){
                        value = [event.target.value];
                    }
                }else{
                    var value = event.target.value;
                }
                form.save(event.target.name, value);
            }, 3000);
        }
        form.customSelect = function(field, val){
            if(form[field].value != val){
                SaveIndicator.checked = true;
                form[field].value = val;
                
                form.save(field, val);
            }
        }
        form.save = function(field, value){
            XHR.json({
                method: "POST",
                addressee: "/Settings/{{ $current }}",
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