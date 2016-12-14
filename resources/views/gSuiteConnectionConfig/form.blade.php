@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-10 col-md-offset-1">
<div class="panel panel-default">
<div class="panel-heading">
Configs
</div>

<div class="panel-body">
@if(Session::has('success_message'))
	<div class="alert alert-success">{{Session::get('success_message')}}</div>
	@endif

	@if(Request::is('*/edit'))
	{!! Form::model($config, ['method' => 'PATCH', 'url'=>'gSuiteConnectionConfig/'.$config->id] ) !!}
	@else
	{!! Form::open(['url'=>'gSuiteConnectionConfig/save'] ) !!}
	@endif

	{!! Form::label('application_name','Nome do Aplicativo') !!}
	{!! Form::input('text','application_name', null, [ 'class' => 'form-control', 'auto-focus', 'placeholder' => 'Nome do Aplicativo' ]) !!}

	{!! Form::label('subject','Endereço da Conta que será Emulada (formato endereco@dominio)') !!}
	{!! Form::input('email','subject', null, [ 'class' => 'form-control', 'auto-focus', 'placeholder' => 'ie: admin@yourdomain.com' ]) !!}

	{!! Form::label('auth_config_path','Caminho completo para o arquivo de credenciais JSon') !!}
	{!! Form::input('text','auth_config_path', null, [ 'class' => 'form-control', 'auto-focus', 'placeholder' => '/Users/marcos-farias/Documents/workspace-php/GSuiteAdmin/service-account-credentials.json' ]) !!}

	{!! Form::label('scopes','Escopos (caso necessário, utilize vírgulas para separar múltiplos escopos)') !!}
	{!! Form::input('text','scopes', null, [ 'class' => 'form-control', 'auto-focus', 'placeholder' => 'https://www.googleapis.com/auth/admin.directory.user' ]) !!}


	{!! Form::submit('Salvar',[ 'class'=>'btn btn-primary' ]) !!}

	{!! Form::close() !!}
	</div>
	</div>
	</div>
	</div>
	</div>
	@endsection
