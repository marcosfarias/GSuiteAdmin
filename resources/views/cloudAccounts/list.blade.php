@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-10 col-md-offset-1">
<div class="panel panel-default">
<div class="panel-heading">
Resultado do Sync das {{$cloudAccountsStats[0]->created_at}}
<a class="pull-right" href="{{ url('cloudAccountsStats')}}">Visão Cloud</a>
</div>

<div class="panel-body">
	<table class="table">
		<th>Nome</th>
		<th>Sobrenome</th>
		<th>Conta</th>
		<th>Status Nuvem</th>
		<th>Status Local</th>
		<th>Status</th>
		<tbody>
		@foreach($cloudAccounts as $cloudAccount)
			<tr>
			<td>{{$cloudAccount->first_name}}</td>
			<td>{{$cloudAccount->last_name}}</td>
			<td>{{$cloudAccount->account_address}}</td>
			<td>{{$cloudAccount->cloud_status}}</td>
			<td>{{$cloudAccount->local_status}}</td>
			<td>{{$cloudAccount->status}}</td>
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
