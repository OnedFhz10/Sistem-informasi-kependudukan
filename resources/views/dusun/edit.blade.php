@extends('layouts.app')

@section('title', 'Edit Dusun')
@section('header', 'Edit Data Dusun')

@section('content')
    <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-lg mx-auto">
        <div class="bg-yellow-500 p-4">
            <h2 class="text-xl text-white font-bold">Edit Data Dusun</h2>
        </div>

        <div class="p-6">
            <form action="{{ route('dusun.update', $dusun->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Nama Dusun</label>
                    <input type="text" name="nama" value="{{ old('nama', $dusun->nama) }}"
                        class="w-full border p-2 rounded focus:ring-2 focus:ring-yellow-500" required>
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Nama Kepala Dusun</label>
                    <input type="text" name="kepala_dusun" value="{{ old('kepala_dusun', $dusun->kepala_dusun) }}"
                        class="w-full border p-2 rounded focus:ring-2 focus:ring-yellow-500"
                        placeholder="Nama Bapak/Ibu Kadus">
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('dusun.index') }}"
                        class="bg-gray-500 text-white font-bold py-2 px-4 rounded">Batal</a>
                    <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
