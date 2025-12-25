@extends('layouts.app')
@section('title', 'Tambah RT')
@section('content')
    <div class="bg-white p-6 rounded shadow max-w-lg mx-auto">
        <h2 class="text-xl font-bold mb-4">Tambah RT Baru</h2>
        <form action="{{ route('rt.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-bold mb-1">Induk RW</label>
                <select name="rw_id" class="w-full border p-2 rounded" required>
                    <option value="">-- Pilih RW --</option>
                    @foreach ($rws as $rw)
                        <option value="{{ $rw->id }}">
                            RW {{ $rw->nomor }} - {{ $rw->dusun->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-bold mb-1">Nomor RT</label>
                <input type="text" name="nomor" class="w-full border p-2 rounded" placeholder="Contoh: 05" required>
            </div>

            <div class="mb-4">
                <label class="block font-bold mb-1">Nama Kepala RT</label>
                <input type="text" name="kepala_rt" class="w-full border p-2 rounded" placeholder="Nama Bapak/Ibu RT">
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded font-bold">Simpan</button>
        </form>
    </div>
@endsection
