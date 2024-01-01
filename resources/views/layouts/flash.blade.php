@if(session('success'))
<div class="alert alert-success alert-dismissible alert-alt fade show">
	<strong>{{session('success')}}</strong>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible alert-alt fade show">
	<strong>{{session('error')}}</strong>
</div>
@endif