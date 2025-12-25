@extends('layouts.app')

@section('title', 'Tambah Dusun')
@section('header', 'Tambah Dusun Baru')

@section('content')
    <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-lg mx-auto">
        <div class="bg-blue-600 p-4">
            <h2 class="text-xl text-white font-bold">Tambah Data Dusun</h2>
        </div>

        <div class="p-6">
            <form action="{{ route('dusun.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Nama Dusun</label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                        class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Dusun Wage"
                        required>
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Nama Kepala Dusun</label>
                    <input type="text" name="kepala_dusun" value="{{ old('kepala_dusun') }}"
                        class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500"
                        placeholder="Nama Bapak/Ibu Kadus">
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('dusun.index') }}"
                        class="bg-gray-500 text-white font-bold py-2 px-4 rounded">Batal</a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
