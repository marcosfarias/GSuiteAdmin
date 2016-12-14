@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-10 col-md-offset-1">
<div class="panel panel-default">
<div class="panel-heading">
Grupo 
<br/><strong>{{$group->name}}</strong>
<br/>{{$group->email}}
<a class="pull-right" href="/groups/{{$group->id}}/members/add">Novo Membro</a>
</div>

<div class="panel-body">
	@if(Session::has('fail_message'))
	<div class="alert alert-success">{{Session::get('fail_message')}}</div>
	@endif
	@if(Session::has('success_message'))
		<div class="alert alert-success">{{Session::get('success_message')}}</div>
	@endif
	<table class="table">
		<th>Membro</th>
		<th>Papel</th>
		<th>Ações</th>
		<tbody>
		@foreach($groupMembers as $groupMember)
			<tr>
			<td>{{$groupMember->email}}</td>
			<td>{{$groupMember->role}}</td>
			<td>
				<a href="/groups/{{$groupMember->group_id}}/members/{{$groupMember->id}}/edit" class="btn btn-default btn-sm">Editar</a>
				{!! Form::model($groupMember, ['method' => 'DELETE', 'url'=>'groups/'.$groupMember->group_id.'/members/'.$groupMember->id.'/remove', 'style'=> 'display:inline'] ) !!}
				<button type="submit" class="btn btn-default btn-sm">Remover</button>
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
