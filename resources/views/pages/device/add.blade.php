@extends('layouts.app')

@section('content')
<div class="mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/device">Device</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add</li>
        </ol>
    </nav>
</div>
<div class="card">
    <div class="card-body">
        <div class="d-flex align-content-center justify-content-between">
            <h4>Tambah Device</h4>
            <a href="{{url(session('links')[1])}}" class="btn btn-warning">
                <span data-feather="arrow-left"></span> Kembali
            </a>
        </div>
        <form method="POST" class="" action="/device" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
    <label for="inputDevice_id" class="form-label">Device ID</label>
    <input type="text" name="device_id" value="{{old('device_id')}}"
        class="form-control @error('device_id') is-invalid @enderror" id="inputdevice_id"
        aria-describedby="device_idHelp">
    @error('device_id')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="mb-3">
    <label for="inputPhone" class="form-label">No WA</label>
    <input type="text" name="phone" value="{{old('phone')}}"
        class="form-control @error('phone') is-invalid @enderror" id="inputphone"
        aria-describedby="phoneHelp">
    @error('phone')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="mb-3">
    <label for="inputStatus" class="form-label">Status</label>
    <input type="text" name="status" value="{{old('status')}}"
        class="form-control @error('status') is-invalid @enderror" id="inputstatus"
        aria-describedby="statusHelp">
    @error('status')
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
