@extends('layouts.app')

@section('content')
<div class="mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/group/{{ $group->id }}">Group</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Participant</li>
        </ol>
    </nav>
</div>
<div class="card">
    <div class="card-body">
        <div class="d-flex align-content-center justify-content-between">
            <h4>Tambah Participant</h4>
            <a href="/group/{{ $group->id }}" class="btn btn-warning">
                <span data-feather="arrow-left"></span> Kembali
            </a>
        </div>
        <form method="POST" class="" action="/group/{{ $group->id }}/participant" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="inputName" class="form-label">Name</label>
                <input type="text" name="name" value="{{old('name')}}"
                    class="form-control @error('name') is-invalid @enderror" id="inputname" aria-describedby="nameHelp">
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputPhone" class="form-label">Phone</label>
                <input type="text" name="phone" value="{{old('phone')}}"
                    class="form-control @error('phone') is-invalid @enderror" id="inputphone"
                    aria-describedby="phoneHelp">
                @error('phone')
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
