@extends('layouts.app')

@section('content')
<div class="mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/device">Device</a></li>
            <li class="breadcrumb-item active" aria-current="page">Show</li>
        </ol>
    </nav>
</div>
<div class="card">
    <div class="card-body">
        <div class="d-flex align-content-center justify-content-between">
            <h4>Detail Device</h4>
            <a href="{{url(session('links')[1])}}" class="btn btn-warning">
                <span data-feather="arrow-left"></span> Kembali
            </a>
        </div>
        <table class="table">
            <tr>
                <th>Device ID</th>
                <td>{{$data->device_id}}</td>
            </tr>

            <tr>
                <th>No WA</th>
                <td>{{$data->phone}}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <button class="btn btn-danger" onclick="getQrcode()" data-bs-toggle="modal" data-bs-target="#linkDevice" type="button">
                        Link Device On Whatsapp
                    </button>
                </td>
            </tr>
        </table>
    </div>
</div>

{{-- create modal --}}
<div class="modal fade" id="linkDevice" tabindex="-1" aria-labelledby="linkDeviceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="linkDeviceLabel">Link Device On Whatsapp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center align-items-center p-3">
                    <div id="qrcode"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    //create ajax javascript
    function getQrcode(){
        fetch('/device-create')
        .then(response => response.text())
        .then(data => {
            new QRCode(document.getElementById("qrcode"), data);
        });
    }
</script>
@endsection
