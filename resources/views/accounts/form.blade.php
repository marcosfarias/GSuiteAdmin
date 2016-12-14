@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-10 col-md-offset-1">
<div class="panel panel-default">
<div class="panel-heading">
Conta
<a class="pull-right" href="{{ url('accounts')}}">Listagem</a>
</div>

<div class="panel-body">
	@if(Session::has('fail_message'))
	<div class="alert alert-success">{{Session::get('fail_message')}}</div>
	@endif
	@if(Session::has('success_message'))
	<div class="alert alert-success">{{Session::get('success_message')}}</div>
	@endif

	@if(Request::is('*/edit'))
	{!! Form::model($account, ['method' => 'PATCH', 'url'=>'accounts/'.$account->id] ) !!}
	@else
	{!! Form::open(['url'=>'accounts/save'] ) !!}
	@endif

		{!! Form::label('first_name','Nome') !!}
		{!! Form::input('text','first_name', null, [ 'class' => 'form-control', 'auto-focus', 'placeholder' => 'Nome' ]) !!}
	
		{!! Form::label('last_name','Sobrenome') !!}
		{!! Form::input('text','last_name', null, [ 'class' => 'form-control', 'auto-focus', 'placeholder' => 'Sobrenome' ]) !!}
	
		{!! Form::label('account_address','Conta (formato endereco@dominio) ') !!}
		{!! Form::input('email','account_address', null, [ 'class' => 'form-control', 'auto-focus', 'placeholder' => 'endereco@dominio' ]) !!}
	
		{!! Form::label('password','Senha') !!}
		{!! Form::input('password','password', null, [ 'class' => 'form-control', 'auto-focus', 'placeholder' => 'Senha' ]) !!}
	
	
		{!! Form::submit('Salvar',[ 'class'=>'btn btn-primary' ]) !!}

	{!! Form::close() !!}
</div>
</div>
</div>
</div>
</div>
@endsection
