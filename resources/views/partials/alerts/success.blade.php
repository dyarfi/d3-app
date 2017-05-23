@if(Session::has('flash_message'))
<div class="container">
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
</div>
@endif
