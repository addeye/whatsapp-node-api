@extends('layouts.app')

@section('content')
<div class="mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item"><a href="/group">Group</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
</div>
<div class="card">
    <div class="card-body">
        <div class="d-flex align-content-center justify-content-between">
            <h4>Ubah Group</h4>
            <a href="{{url(session('links')[1])}}" class="btn btn-warning">
                <span data-feather="arrow-left"></span> Kembali
            </a>
        </div>
        <form method="POST" class="" action="/group/{{$data->id}}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="mb-3">
    <label for="inputName" class="form-label">Nama</label>
    <input type="text" name="name" value="{{$data->name}}"
        class="form-control @error('name') is-invalid @enderror" id="inputname"
        aria-describedby="nameHelp">
    @error('name')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="mb-3">
    <label for="inputDescription" class="form-label">Deskripsi</label>
    <textarea name="description" id="inputdescription" class="form-control @error('description') is-invalid @enderror" aria-describedby="descriptionHelp">{{$data->description}}</textarea>
    @error('description')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>


            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
    </div>
  </div>
@endsection
