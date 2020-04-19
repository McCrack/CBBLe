<form class="pt-20px flex justify-between flex-items-start flex-wrap">
    <div class="mt-8 px-5px w-50 border-box">
        <label class="block capitalize">{{ $translate->main("site name") }}</label>
        <input name="site_name" value="{{ ($site['site name'] ?? null) }}" class="field w-100">
        <output name="site_name_msg" class="danger-txt font-12"></output>
    </div>
    <div class="mt-8 px-5px w-50 border-box">
        <label class="block">E-Mail</label>
        <input name="email" type="email" value="{{ ($site['email'] ?? null) }}" class="field w-100">
        <output name="email_msg" class="danger-txt font-12"></output>
    </div>
    <div class="mt-8 px-5px w-50 border-box flex flex-items-strart">
        <div class="w-25">
            <label class="block capitalize">{{ $translate->language }}</label>
            <div class="select w-100">
                <input name="language" value="{{ ($site['language'] ?? null) }}" class="field cursor-pointer w-100" readonly>
                <fieldset
                    onmousedown="this.form.customSelect('language', event.target.textContent)"
                    class="absolute w-100 sidebar-bg white-txt shadow-light font-12 z-index-2">
                    @foreach($site['languages'] as $lang)
                    <label class="hover-primary-bg">{{ $lang }}</label>
                    @endforeach
                </fieldset>
            </div>
        </div>
        <div class="w-75 pl-10px">
            <label class="block">{{ $translate->languages }}</label>
            <div data-name="languages" onclick="event.target.classList.contains('tag') ? this.removeChild(event.target) : null" class="field tags-field w-100 h-32">
                @foreach($site['languages'] as $lang)
                <span class="tag">{{ $lang }}</span>
                @endforeach
                <input oninput="taginate(event, 2, 2)" class="flex-basis h-100 ml-5 border-none transparent outline-none">
            </div>
        </div>
    </div>

    <div class="mt-8 px-5px w-50 border-box flex flex-items-strart">
        <div class="w-25">
            <label class="block capitalize">{{ $translate->locality }}</label>
            <div class="select w-100">
                <input name="locality" value="{{ ($site['locality'] ?? null) }}" class="field w-100 cursor-pointer" readonly>
                <fieldset
                    onmousedown="this.form.customSelect('locality', event.target.textContent)"
                    class="absolute w-100 sidebar-bg white-txt shadow-light font-12 z-index-2">
                    @foreach($site['localities'] as $local)
                    <label class="hover-primary-bg">{{ $local }}</label>
                    @endforeach
                </fieldset>
            </div>
        </div>
        <div class="w-75 pl-5px">
            <label class="block">{{ $translate->localities }}</label>
            <div data-name="localities" onclick="event.target.classList.contains('tag') ? this.removeChild(event.target) : null" class="field tags-field w-100 h-32">
                @foreach($site['localities'] as $local)
                <span class="tag">{{ $local }}</span>
                @endforeach
                <input oninput="taginate(event, 2, 2)" class="ml-5">
            </div>
        </div>
    </div>
    
    <div class="mt-8 px-5px border-box flex-basis">
        <label class="block">Logo URI</label>
        <input name="logo" type="url" value="{{ ($site['logo'] ?? null) }}" class="field w-100">
        <output name="logo_msg" class="danger-txt font-12"></output>
    </div>
                
    <div class="mt-8 px-5px w-50 border-box">
        <label class="block text-bold">Exchange Rates</label>
        <table width="100%" rules="cols" cellspacing="0" cellpadding="6" class="font-13 border-light" bordercolor="#DDD">
	        <col width="25"><col><col><col width="25">
            <tbody data-name="currency" align="center">
	        @foreach($site['currency'] as $currency => $rate)
		        <tr>
			        <th class="white-bg cursor-pointer" title="Add row" align="center" onclick="addRow(this.parentNode)">+</th>
			        <td contenteditable="true">{{ $currency }}</td>
    		        <td contenteditable="true">{{ $rate }}</td>
		            <th class="white-bg cursor-pointer" title="Delete row" align="center" onclick="deleteRow(this.parentNode)">✕</th>
	            </tr>
	        @endforeach
	        </tbody>
	    </table>
    </div>
    <div class="mt-8 px-5px w-50 border-box">
        <label class="block">Phones</label>
        <table width="100%" cellspacing="0" cellpadding="6" class="font-13 border-light">
	        <col width="25"><col><col width="25"><col width="25">
            <tbody data-name="phones" align="center">
	        @empty($site['phones'])
                <tr>
		            <th class="white-bg cursor-pointer" title="Add row" align="center" onclick="addRow(this.parentNode)">+</th>
		            <td contenteditable="true"></td>
                    <th></th>
		            <th class="white-bg cursor-pointer" title="Delete row" align="center" onclick="deleteRow(this.parentNode)">✕</th>
	            </tr>
            @else
            @foreach($site['phones'] as $phone)
	            <tr>
		            <th class="white-bg cursor-pointer" title="Add row" align="center" onclick="addRow(this.parentNode)">+</th>
		            <td contenteditable="true">{{ $phone }}</td>
                    <th class="primary-bg white-txt cursor-pointer" title="Swap Row" align="center" onclick="swapRow(this.parentNode)">⇪</th>
		            <th class="white-bg cursor-pointer" title="Delete row" align="center" onclick="deleteRow(this.parentNode)">✕</th>
	            </tr>
	        @endforeach
            @endempty
	        </tbody>
	    </table>
    </div>
    <div class="flex-basis pt-20px pb-10px pr-5px align-right">
        <button type="submit" class="btn btn-md white-txt primary-bg hover-danger-bg">{{ $translate->save }}</button>
    </div>
    <script>
    (function(form){
        form.onsubmit = function(event){
            event.preventDefault();
            XHR.json({
                method: "PATCH",
                addressee: "/Settings",
                body: {
                    'site name' : form.site_name.value,
                    'email'     : form.email.value,
                    'logo'      : form.logo.value,
                    'language'  : form.language.value,
                    'locality'  : form.locality.value,
                    'languages' : (function(languages){
                        form.querySelectorAll("div[data-name='localities'] > .tag").forEach(function(tag){
                            languages.push(tag.textContent)
                        });
                        return languages;
                    })([]),
                    'localities': (function(localities){
                        form.querySelectorAll("div[data-name='localities'] > .tag").forEach(function(tag){
                            localities.push(tag.textContent)
                        });
                        return localities;
                    })([]),
                    'currency'  : (function(currency, key){
                        form.querySelectorAll("tbody[data-name='currency'] > tr > td").forEach(function(cell, i){
                            if(i%2 && key){
								currency[key] = cell.textContent.trim();
							}else if(cell.textContent.length) {
								key = cell.textContent.trim();
							}
                        });
                        return currency;
                    })({}),
                    'phones'    : (function(phones){
                        form.querySelectorAll("tbody[data-name='phones'] > tr > td").forEach(function(cell){
                            phones.push(cell.textContent.trim())
                        });
                        return phones;
                    })([])
                },
                onsuccess: function(response){
                    response = JSON.parse(response);
                    if(response.status == "Success"){
                        SaveIndicator.checked = false;
                    }
                }
            });
        }
        form.oninput = function(event){
            SaveIndicator.checked = true;
        }
        form.customSelect = function(field, val){
            if(form[field].value != val){
                SaveIndicator.checked = true;
                form[field].value = val;
            }
        }
    })(document.currentScript.parentNode)
    </script>
</form>