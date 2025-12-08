@extends('admin.layouts.admin.app')
@section('title', 'Data Warga')

@section('content')
<div class="card">
  <div class="card-body d-flex justify-content-between align-items-center">
    <h4 class="card-title mb-0">Data Warga</h4>
    <a href="{{ route('admin.warga.create') }}" class="btn btn-primary">Tambah Data</a>
  </div>
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama</th>
          <th>Alamat</th>
          <th>No HP</th>
          <th>Pekerjaan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($warga as $i => $item)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td>{{ $item->nama }}</td>
          <td>{{ $item->alamat }}</td>
          <td>{{ $item->no_hp }}</td>
          <td>{{ $item->pekerjaan }}</td>
          <td class="text-nowrap">
            <a href="{{ route('admin.warga.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
            <form action="{{ route('admin.warga.destroy', $item->id) }}" method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button onclick="return confirm('Yakin hapus data ini?')" class="btn btn-sm btn-danger">Hapus</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center text-muted">Belum ada data</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
