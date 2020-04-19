@extends('CBBLe.layouts.mount')

@section('toolbar')

@endsection

@section('body')
<form id="user-{{ $handle }}" class="pop-up-body w-640 overflow-auto p-5px soft-bg flex flex-items-stretch">
    <div class="w-256 py-20px px-10px main-bg">
        <div class="mx-20">
            <label class="capitalize">UserID:</label>
            <input name="user_id" class="field text-bold w-32" readonly value="{{ ($user->id ?? 0) }}">
            <input name="action" type="hidden" value="{{ $action }}">
        </div>
        <div class="mt-10 mx-20">
            <label class="block capitalize">{{ $translate->role }}</label>
            <div class="select w-100 white-bg">
                <input name="role" value="{{ ($user->role ?? 'suspend') }}" class="field w-100" autocomplete="off">
                <fieldset class="absolute w-100 light-txt font-13">
                    @foreach(["admin","developer","manager","suspend"] as $role)
                    <label class="dark-bg hover-primary-bg">{{ $role }}</label>
                    @endforeach
                    <script>
                    (function(container){
                        container.onmousedown = function(event){
                            container.form.role.value = event.target.textContent;
                        }
                    })(document.currentScript.parentNode)
                    </script>
                </fieldset>
            </div>
            <output name="role_msg" class="danger-txt font-12"></output>
        </div>
        <div class="mt-10 mx-20">
            <label class="block capitalize">{{ $translate->name }}</label>
            <input name="name" value="{{ ($user->name ?? null) }}" class="field w-100" autocomplete="off">
            <output name="name_msg" class="danger-txt font-12"></output>
        </div>
        <div class="mt-8 mx-20">
            <label class="block capitalize">E-Mail</label>
            <input name="email" type="email" value="{{ ($user->email ?? null) }}" class="field w-100" autocomplete="off">
            <output name="email_msg" class="danger-txt font-12"></output>
        </div>
        <div class="mt-8 mx-20 pb-20px">
            <label class="block capitalize">{{ $translate->password }}</label>
            <input name="password" value="" type="text" class="field w-100" placeholder="●●●●●" autocomplete="off">
            <output name="password_msg" class="danger-txt font-12"></output>
        </div>
    </div>
    <div class="dark-bg py-5px flex-grow">
        <pre data-name="config" class="h-100 w-100 m-0">{!! json_encode(
            $user->config ?? [
                'theme'     => $config->theme,
                'language'  => $config->language
            ],
            JSON_PRETTY_PRINT
        ) !!}</pre>
    </div>
    <script>
    (function(form){
        form.onsubmit = function(event){
            event.preventDefault();
            SaveIndicator.checked = true;
            XHR.json({
                method: (form.action.value == "save") ? "PUT" : "POST",
                addressee: "/Users/"+form.user_id.value,
                body: (function(data){
                    data = {
                        role:  form.role.value,
                        name:  form.name.value,
                        email: form.email.value,
                        config: JSON.parse(form.config.session.getValue())
                    }
                    if(form.password.value){
				        data['password'] = form.password.value;
			        }
                    return data;
                })({}),
                onsuccess: function(response){
                    response = JSON.parse(response);
                    if(response.status == "Success"){
                        SaveIndicator.checked = false;
                        PopUpPool['{{ $handle }}'].drop();
                    }else{
                        form.querySelectorAll('output').forEach(function(msg){
                            msg.value = "";
                        });
                        for(var field in response['errors']){
                            response['errors'][field].forEach(function(error){
                                form[field+'_msg'].value += error;
                            });
                        }
                    }
                }
            })
        }
        form.remove.onclick = function(event){
            event.preventDefault();
            showConfirm("{{ $translate->alerts('remove this user') }}?", function(){
                SaveIndicator.checked = true;
                XHR.push({
                    method: "DELETE",
                    addressee: "/Users/"+form.user_id.value,
                    onsuccess: function(response){
                        SaveIndicator.checked = false;
                        PopUpPool['{{ $handle }}'].drop();
                    }
                });
            });
        }
        form.onreset = function(event){
            event.preventDefault();
            PopUpPool['{{ $handle }}'].drop();
            SaveIndicator.checked = false;
        }
        form.config = ace.edit(form.querySelector("pre[data-name='config']"));
        form.config.setTheme("ace/theme/twilight");
        form.config.getSession().setMode("ace/mode/json");
        form.config.setShowInvisibles(false);
        form.config.setShowPrintMargin(false);
        form.config.resize();
    })(document.currentScript.parentNode)
    </script>
</form>
@endsection

@section('footer')
<div class="pop-up-footer light-bg align-right pr-10px pb-10px pt-5px">
	<button type="submit" form="user-{{ $handle }}" class="btn btn-md primary-bg hover-success-bg white-txt">{{ $translate->{$action} }}</button>
	@isset($user)
    <button type="reset" name="remove" form="user-{{ $handle }}" class="btn btn-md dark-bg hover-danger-bg white-txt">{{ $translate->delete }}</button>
    @endif
</div>
@endsection