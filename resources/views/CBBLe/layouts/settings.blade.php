@extends('CBBLe.layouts.modal-mount')

@section('toolbar')

@endsection

@section('body')
<div class="pop-up-body overflow-auto soft-bg w-640 p-5px">
    <div class="tabs main-bg p-10px">
        @if($privileges)
        <input id="extension-tab" type="radio" name="settings-tabs" class="checked-bold checked-underline" checked hidden>
        <label for="extension-tab" class="mx-5 font-15 text-light dark-txt cursor-pointer hover-underline capitalize">{{ $translate->{$current} }}</label>
        <div class="tab px-10px border-box font-13">
            @include("CBBLe.{$current}.config")
        </div>
        <input id="site-tab" type="radio" name="settings-tabs" class="checked-bold checked-underline" hidden>
        <label for="site-tab" class="mx-5 font-15 text-light dark-txt cursor-pointer hover-underline">{{ $translate->site }}</label>
        <div class="tab border-box font-13" autocomplete="off">
            @include('CBBLe.components.config.site')
        </div>
        @endif
        <input id="dasboard-tab" type="radio" name="settings-tabs" class="checked-bold checked-underline"  @if(!$privileges) checked @endif hidden>
        <label for="dasboard-tab" class="mx-5 font-15 text-light dark-txt cursor-pointer hover-underline">Dashboard</label>
        <div class="tab px-10px border-box font-13 flex flex-items-stretch flex-wrap" autocomplete="off">
            @include('CBBLe.components.config.personal')
            @include('CBBLe.components.config.global')
        </div>
        <br clear="both">
    </div>
</div>
@endsection

@section('footer')

@endsection