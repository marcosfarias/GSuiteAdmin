@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-10 col-md-offset-1">
<div class="panel panel-default">
<div class="panel-heading">
Grupos
<a class="pull-right" href="{{ url('groups/add')}}">Novo Grupo</a>
</div>

<div class="panel-body">
	@if(Session::has('fail_message'))
	<div class="alert alert-success">{{Session::get('fail_message')}}</div>
	@endif
	@if(Session::has('success_message'))
		<div class="alert alert-success">{{Session::get('success_message')}}</div>
	@endif
	<table class="table">
		<th>Nome</th>
		<th>E-mail</th>
		<th>Membros Diretos</th>
		<th>Ações</th>
		<tbody>
		@foreach($groups as $group)
			<tr>
			<td>{{$group->name}}</td>
			<td>{{$group->email}}</td>
			<td>{{$group->directMembersCount}}</td>
			<td>
				<a href="groups/{{$group->id}}/members" class="btn btn-default btn-sm">Membros</a>
				<a href="groups/{{$group->id}}/edit" class="btn btn-default btn-sm">Editar</a>
				{!! Form::model($group, ['method' => 'DELETE', 'url'=>'groups/'.$group->id, 'style'=> 'display:inline'] ) !!}
				<button type="submit" class="btn btn-default btn-sm">Excluir</button>
				{!! Form::close() !!}
			</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
</div>
</div>
</div>
</div>
@endsection
