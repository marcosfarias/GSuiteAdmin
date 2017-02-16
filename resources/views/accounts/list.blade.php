@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-10 col-md-offset-1">
<div class="panel panel-default">
<div class="panel-heading">
Conta
<a class="pull-right" href="{{ url('accounts/add')}}">Nova Conta</a>
<br/><a class="pull-right" href="{{ url('cloudAccountsStats')}}">Visão Cloud</a>
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
		<th>Sobrenome</th>
		<th>Conta</th>
		<th>source_id</th>
		<th>Ações</th>
		<tbody>
		@foreach($accounts as $account)
			<tr>
			<td>{{$account->first_name}}</td>
			<td>{{$account->last_name}}</td>
			<td>{{$account->account_address}}</td>
			<td>{{$account->source_id}}</td>
			<td>
				<a href="accounts/{{$account->id}}/edit" class="btn btn-default btn-sm">Editar</a>
				{!! Form::model($account, ['method' => 'DELETE', 'url'=>'accounts/'.$account->id, 'style'=> 'display:inline'] ) !!}
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
