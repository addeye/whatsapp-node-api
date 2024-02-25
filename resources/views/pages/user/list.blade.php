@extends('layouts.app')

@section('content')
<div class="mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">User</li>
        </ol>
    </nav>
</div>
<div class="card">
    <div class="card-body">
        <div class="d-flex align-content-center justify-content-between mb-3">
            <h4 class="card-title mb-0">Data User</h4>
            <a href="/user/create" class="btn btn-primary">
                <span data-feather="plus"></span> Tambah
            </a>
        </div>
        <div class="d-flex justify-content-between align-content-center mb-3">
            <p class="m-0 py-2">Tampil {{$data->firstItem()}} sampai {{$data->lastItem()}} dari {{$data->total()}} data</p>
            <form>
                <div class="input-group">
                    <input type="search" name="cari" value="{{request('cari')}}" class="form-control" placeholder="Cari data..." aria-label="Cari data..." aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                          </svg>
                    </button>
                </div>
            </form>
        </div>
        <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">
                    <a href="?sort_name=name&sort_val={{$sort}}">Name
                        @if (request('sort_name')=='name' && request('sort_val')=='ASC')
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-up" viewBox="0 0 16 16">
                            <path d="M3.5 12.5a.5.5 0 0 1-1 0V3.707L1.354 4.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.498.498 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L3.5 3.707V12.5zm3.5-9a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"/>
                          </svg>
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-down" viewBox="0 0 16 16">
                            <path d="M3.5 2.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 11.293V2.5zm3.5 1a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"/>
                          </svg>
                        @endif
                    </a>
                </th>
                <th scope="col">
                    <a href="?sort_name=email&sort_val={{$sort}}">Email
                        @if (request('sort_name')=='email' && request('sort_val')=='ASC')
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-up" viewBox="0 0 16 16">
                            <path d="M3.5 12.5a.5.5 0 0 1-1 0V3.707L1.354 4.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.498.498 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L3.5 3.707V12.5zm3.5-9a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"/>
                          </svg>
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-down" viewBox="0 0 16 16">
                            <path d="M3.5 2.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 11.293V2.5zm3.5 1a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"/>
                          </svg>
                        @endif
                    </a>
                </th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $key=>$item)
                  <tr>
                    <td>{{ $data->firstItem() + $key}}</td>
                    <td>{{$item->name}}</td>
                    <td>
                        {{$item->email}}
                    </td>
                    <td>
                        <a class="btn btn-warning btn-sm" href="/user/{{$item->id}}">
                            <span data-feather="eye"></span>
                        </a>
                        <a class="btn btn-primary btn-sm" href="/user/{{$item->id}}/edit">
                            <span data-feather="edit"></span>
                        </a>

                        <a class="btn btn-danger btn-sm" href="javascript:" onclick="deleteData({{$item->id}})"><span data-feather="trash"></span></a>
                        <form class="d-none" id="formdelete-{{$item->id}}" action="/user/{{$item->id}}" method="POST">
                            @method('DELETE')
                            @csrf
                        </form>
                    </td>
                  </tr>
              @endforeach
            </tbody>
        </table>
        {!! $data->links(); !!}
    </div>
  </div>
@endsection

@section('js')
<script>
    function deleteData(id){
        if(confirm("Apakah anda yakin?")){
            document.getElementById('formdelete-'+id).submit()
        }
        return false;
    }
</script>
@endsection
