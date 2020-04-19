@extends('CBBLe.layouts.mount')

@section('toolbar')
<button
    form="dictionary-{{ $handle }}"
    onclick="this.form.addLanguage(event)"
    class="tooltip b h-32 m-5 btn transparent"
    data-title="{{ $translate->{'add language'} }}">
    <svg viewBox="0 0 512 512" height="24">
        <use fill="#368" xlink:href="/c-bble/icons/main.svg#addlanguage"></use>
    </svg>
</button>
<button
    form="dictionary-{{ $handle }}"
    onclick="this.form.remove(event)"
    class="tooltip b h-32 m-5 btn transparent"
    data-title="{{ $translate->remove }} {{ $translate->dictionary }}">
    <svg viewBox="0 0 512 512" height="24">
        <use fill="#56AAFF" xlink:href="/c-bble/icons/main.svg#dropdictionary"></use>
    </svg>
</button>
@endsection

@section('body')
<form id="dictionary-{{ $handle }}" class="pop-up-body overflow-auto light-bg w-860 resize-h">
    <table width="100%" cellspacing="0" cellpadding="6" class="white-bg border-light font-13" rules="cols" bordercolor="#555">
        <thead>
            <tr class="light-rainbow">
                <td width="20"></td>
                <td align="center">Keywords</td>
                @foreach(array_keys($dictionary) as $lang)
                <th>{{ $lang }}</th>
                @endforeach
                <td width="20"></td>
                <td width="20"></td>
            </tr>
        </thead>
        <tbody>
            @empty($keys)
            <tr>
                <th class="white-bg cursor-pointer" title="{{ $translate->{'add row'} }}" align="center" onclick="addRow(this.parentNode)">+</th>
                <td align="center" contenteditable="true"></td>
                @foreach (array_keys($dictionary) as $lang)
				<td contenteditable="true"></td>
				@endforeach
                <th class="white-bg"></th>
                <th class="white-bg cursor-pointer" title="{{ $translate->{'delete row'} }}" align="center" onclick="deleteRow(this.parentNode)">✕</th>
            </tr>
            @endempty
            @foreach($keys as $lang => $key)
            <tr>
                <th class="white-bg cursor-pointer" title="{{ $translate->{'add row'} }}" align="center" onclick="addRow(this.parentNode)">+</th>
                <td align="center" contenteditable="true">{{ $key }}</td>
                @foreach (array_keys($dictionary) as $lang)
				<td contenteditable="true">{{ ($dictionary[$lang][$key] ?? null) }}</td>
				@endforeach
                <th class="success-bg white-txt cursor-pointer" title="Swap Row" align="center" onclick="swapRow(this.parentNode)">⇪</th>
                <th class="white-bg cursor-pointer" title="{{ $translate->{'delete row'} }}" align="center" onclick="deleteRow(this.parentNode)">✕</th>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script>
    (function(form){
        form.onsubmit = function(event){
            event.preventDefault();
            XHR.json({
                method: "PUT",
                addressee: "/Dictionaries/{{ $caption }}/{{ $subdomain }}",
                body: (function(wordlist){
                    var langs = form.querySelectorAll("table > thead > tr > th");
                    langs.forEach(function(cell) {
                        wordlist[cell.textContent.trim()] = {};
                    });
                    form.querySelectorAll("table > tbody > tr").forEach(function(row) {
                        var key = "";
                        row.querySelectorAll("td").forEach(function(cell, i) {
                            if (i > 0) {
                                wordlist[langs[i - 1].textContent][key] = cell.textContent.trim().replace(/(\s){2,}/g, " ").replace(/"/g, "‟");
                            } else {
                                key = cell.textContent.trim().replace(/(\s){2,}/g, " ").replace(/"/g, "‟");
                            }
                        });
                    });
                    return wordlist;
                })({}),
                onsuccess: function(response){
                    PopUpPool['{{ $handle }}'].drop();
                }
            })
        }
        form.onreset = function(event){
            event.preventDefault();
            PopUpPool['{{ $handle }}'].drop();
        }
        form.remove = function(event){
            event.preventDefault();
            showConfirm("{{ $translate->alerts('delete this dictionary') }}?", function(){
                XHR.push({
                    method: "delete",
                    addressee: "/Dictionaries/{{ $caption }}/{{ $subdomain }}",
                    onsuccess: function(response){
                        PopUpPool['{{ $handle }}'].drop();
                    }
                });
            });
        }
        form.addLanguage = function(event){
            event.preventDefault();
            showPrompt("{{ $translate->{'language index'} }}", function(language){
                language = language.toLowerCase();
                if (/^[a-z]{2}$/.test(language)) {
                    form.querySelector("table > thead > tr").lastElementChild.insertAdjacentElement(
                        "beforebegin",
                        document.create("th", {}, language)
                    );
                    var cell = document.create("td", { contenteditable: "true" });
                    document.querySelectorAll("table > tbody > tr").forEach(function(row) {
                        row.lastElementChild.insertAdjacentElement(
                            "beforebegin",
                            cell.cloneNode()
                        );
                    });
                } else showAlert("Incorrect language index");
            }, "_ _");
        }
        form.onpaste = function(event){
            event.preventDefault();
            event.target.textContent = event.clipboardData.getData("text").replace(/\n+/, " ");
        }
        form.parentNode.querySelectorAll("svg").forEach(function (svg) {
            svg.parentNode.replaceChild(svg.cloneNode(true), svg)
        });
    })(document.currentScript.parentNode)
    </script>
</form>
@endsection

@section('footer')
<div class="pop-up-footer light-bg align-right px-10px py-5px">
	<button type="submit" form="dictionary-{{ $handle }}" class="btn btn-md primary-bg hover-danger-bg white-txt">{{ $translate->save }}</button>
	<button type="reset"  form="dictionary-{{ $handle }}" class="btn btn-md dark-bg hover-danger-bg white-txt">{{ $translate->cancel }}</button>
</div>
@endsection