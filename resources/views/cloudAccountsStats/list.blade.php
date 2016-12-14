@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-10 col-md-offset-1">
<div class="panel panel-default">
<div class="panel-heading">
Conta
<a class="pull-right" href="{{ url('cloudAccountsStats/sync')}}">Novo Sync</a>
</div>

<div class="panel-body">
@if(Session::has('list_message'))
	<div class="alert alert-success">{{Session::get('list_message')}}</div>
	@endif
	<table class="table">
	<th>Data</th>
	<th>Ativos na Nuvem</th>
	<th>Suspensos na Nuvem</th>
	<th>Ativos Localmente</th>
	<th>Suspensos Localmente</th>
	<th>Divergências em Ativos</th>
	<th>Divergências em Suspensos</th>
	<th>Ações</th>
	<tbody>

	@foreach($cloudAccountsStats as $cloudAccountsStat)
		<tr>
		<td>{{$cloudAccountsStat->updated_at}}</td>
		<td>{{$cloudAccountsStat->qty_cloud_active}}</td>
		<td>{{$cloudAccountsStat->qty_cloud_suspended}}</td>
		<td>{{$cloudAccountsStat->qty_locally_active}}</td>
		<td>{{$cloudAccountsStat->qty_locally_suspended}}</td>
		<td>{{$cloudAccountsStat->qty_divergence_active}}</td>
		<td>{{$cloudAccountsStat->qty_divergence_suspended}}</td>
		<td>
		<a href="cloudAccounts/{{$cloudAccountsStat->id}}" class="btn btn-default btn-sm">Detalhes</a>
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