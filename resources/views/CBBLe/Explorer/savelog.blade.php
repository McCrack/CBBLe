@extends('CBBLe.layouts.modal-mount')

@section('toolbar')

@endsection

@section('body')
<form id="savelog-{{ $handle }}" class="pop-up-body w-512 h-320 pt-10px light-bg border-box overflow-auto font-12 nowrap">

    <div class="absolute bottom w-100 soft-bg p-10px border-box">
        <output name="current"></output>
        <progress class="w-100 block" value="0"></progress>
    </div>    
</form>
@endsection

@section('footer')

@endsection