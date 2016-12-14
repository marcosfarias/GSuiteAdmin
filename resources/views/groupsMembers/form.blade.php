@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-10 col-md-offset-1">
<div class="panel panel-default">
<div class="panel-heading">
Novo Membro para Grupo 
<br/><strong>{{$group->name}}</strong>
<br/>{{$group->email}}
<a class="pull-right" href="{{ url('groups')}}">Listagem de Grupos</a>
<a href="/groups/{{$group->id}}/members" class="btn btn-default btn-sm">Membros</a>
</div>

<div class="panel-body">
	@if(Session::has('fail_message'))
	<div class="alert alert-success">{{Session::get('fail_message')}}</div>
	@endif
	@if(Session::has('success_message'))
	<div class="alert alert-success">{{Session::get('success_message')}}</div>
	@endif

	@if(Request::is('*/edit'))
	{!! Form::model($groupMember, ['method' => 'PATCH', 'url'=>'groups/'.$group->id.'/members/'.$groupMember->id.'/update'] ) !!}
		{!! Form::label('email','Membro') !!}
		{!! Form::input('email','email', null, [ 'class' => 'form-control', 'readonly' ]) !!}
	@else
	{!! Form::open(['url'=>'groups/'.$group->id.'/members/save'] ) !!}
		{!! Form::label('email','Conta (formato endereco@dominio) ') !!}
		{!! Form::input('email','email', null, [ 'class' => 'form-control', 'auto-focus', 'placeholder' => 'endereco@dominio, exemplo: alunos-em-3a@suaescola.com.br' ]) !!}
	@endif

		{!! Form::hidden('group_id', $group->id) !!}
	
		{!! Form::label('role','Papel (pode ser MEMBER, MANAGER ou OWNER)') !!}
		{!! Form::input('text','role', null, [ 'class' => 'form-control', 'auto-focus', 'placeholder' => 'Função: MEMBER, MANAGER ou OWNER' ]) !!}
	
		{!! Form::submit('Salvar',[ 'class'=>'btn btn-primary' ]) !!}

	{!! Form::close() !!}
</div>
</div>
</div>
</div>
</div>
@endsection
