@extends('layouts.app')

@section('title', 'Tambah Pekerjaan')
@section('header', 'Tambah Pekerjaan')

@section('content')
    <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-lg mx-auto">
        <div class="bg-blue-600 p-4">
            <h2 class="text-xl text-white font-bold">Form Pekerjaan Baru</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('pekerjaan.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Nama Pekerjaan</label>
                    <input type="text" name="nama" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
                <div class="flex justify-end gap-2">
                    <a href="{{ route('pekerjaan.index') }}"
                        class="bg-gray-500 text-white font-bold py-2 px-4 rounded">Batal</a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
