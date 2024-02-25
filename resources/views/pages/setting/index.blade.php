@extends('layouts.app')

@section('content')
<div class="mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Setting</li>
        </ol>
    </nav>
</div>
<div class="col-md-6 offset-md-3">

    <div class="card">
        <div class="card-body">
            <div class="d-flex align-content-center justify-content-between">
                <h4>Data Seting</h4>
            </div>
            {{-- Create message success and error --}}
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <form method="POST" class="" action="/setting" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="inputbase_url" class="form-label">Base URL</label>
                    <input type="text" name="base_url" value="{{$data->base_url}}"
                        class="form-control @error('base_url') is-invalid @enderror" id="inputbase_url" aria-describedby="nameHelp">
                    @error('base_url')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="inputtoken" class="form-label">Token</label>
                    <input type="text" name="token" value="{{$data->token}}"
                        class="form-control @error('token') is-invalid @enderror" id="inputtoken" aria-describedby="nameHelp">
                    @error('token')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
