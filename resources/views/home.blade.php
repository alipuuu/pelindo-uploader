@extends('layout.v_template')
@section('title', 'Success Login!!')
@section('content')
<div class="col-md-12">
    <div class="box-body">
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i>{{ __('Success Login!!') }}</h4>
                <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                    <div class="row">
                {{ __('You are logged in!') }}
            </div>
        </div>
    </div>
</div>
@endsection
