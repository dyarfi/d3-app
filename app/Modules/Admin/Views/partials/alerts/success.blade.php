@if(Session::has('flash_message'))
<div class="row-fluid">
    <div class="alert alert-block alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('flash_message') }}
    </div>
</div>
@endif
