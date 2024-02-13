@extends('include_backend/template_backend')

@section('style')

@endsection

@section('content')
    <div class="container row justify-content-center">
            <h3 class=" text-center my-2">Queue Laravel</h3>
            <br><br>
            <div class="col-md-4 p-4">
                @if (session('status'))
                <div class="alert alert-primary" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <form action="{{ route('post-email') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Nama">
                    </div>
                    <div class="form-group my-3">
                        <label for="email">Email Tujuan</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email Tujuan">
                    </div>
                    <div class="form-group my-3">
                        <label for="name">Body Deskripsi</label>
                        <textarea name="body" class="form-control" id="" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">Kirim Email</button>
                    </div>
            </div>
    </div>
@endsection

@section('javascript')

@endsection
