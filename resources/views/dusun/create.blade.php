@extends('layouts.app')

@section('title', 'Edit Dusun')
@section('header', 'Edit Dusun')

@section('content')
    <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-lg mx-auto">
        <div class="bg-yellow-500 p-4">
            <h2 class="text-xl text-white font-bold">Edit Data Dusun</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('dusun.update', $dusun->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Nama Dusun</label>
                    <input type="text" name="nama" value="{{ $dusun->nama }}"
                        class="w-full border p-2 rounded focus:ring-2 focus:ring-yellow-500" required>
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
