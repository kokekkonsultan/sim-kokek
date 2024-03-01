@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')
<div class="container-fluid">
    <div class="text-center bg-light mb-5" style="border:2px solid #acd3fa;">
        <h2 class="text-primary font-weight-bolder" style="padding: 1em">{{strtoupper($title)}}</h2>
    </div>
    <div class="card card-body">

        


    </div>
</div>



@endsection

@section('javascript')
@endsection