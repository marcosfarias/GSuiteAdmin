@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-10 col-md-offset-1">
<div class="panel panel-default">
<div class="panel-heading">
Grupo
<a class="pull-right" href="{{ url('groups')}}">Lista de Grupos</a><br/>
@if(isset($group))
<a class="pull-right" href="/groups/{{$group->id}}/members" class="btn btn-default btn-sm">ver Membros</a>
@endif
</div>

<div class="panel-body">
	@if (session()->has('fail_message'))
	BDBFBF
	<div class="alert alert-success">{{$fail_message}} DDFDFDF</div>
	@endif
	@if(Session::has('success_message'))
	<div class="alert alert-success">{{Session::get('success_message')}}</div>
	@endif

	@if(Request::is('*/edit'))
	{!! Form::model($group, ['method' => 'PATCH', 'url'=>'groups/'.$group->id] ) !!}
	@else
	{!! Form::open(['url'=>'groups/save'] ) !!}
	@endif

		{!! Form::label('name','Nome') !!}
		{!! Form::input('text','name', null, [ 'class' => 'form-control', 'auto-focus', 'placeholder' => 'Nome do Grupo, exemplo: Alunos do 3º A do Ensino Médio' ]) !!}
	
		{!! Form::label('email','Conta (formato endereco@dominio) ') !!}
		{!! Form::input('email','email', null, [ 'class' => 'form-control', 'auto-focus', 'placeholder' => 'endereco@dominio, exemplo: alunos-em-3a@suaescola.com.br' ]) !!}
	
		{!! Form::label('description','Descrição') !!}
		{!! Form::input('text','description', null, [ 'class' => 'form-control', 'auto-focus', 'placeholder' => 'Descrição do Grupo' ]) !!}
	
		{!! Form::submit('Salvar',[ 'class'=>'btn btn-primary' ]) !!}

	{!! Form::close() !!}
</div>
</div>
</div>
</div>
</div>
@endsection
