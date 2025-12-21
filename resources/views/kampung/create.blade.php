@extends('layouts.app')

@section('title', 'Tambah Kampung')
@section('header', 'Tambah Data Kampung')

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-blue-600 p-4">
            <h2 class="text-white text-lg font-bold">Form Input Kampung</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('kampung.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Nama Kampung</label>
                    <input type="text" name="nama_kampung"
                        class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-200"
                        placeholder="Contoh: Kampung Durian Runtuh" required>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Nama Ketua/Kepala Kampung (Opsional)</label>
                    <input type="text" name="kepala_kampung"
                        class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-200"
                        placeholder="Nama Ketua Kampung">
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('kampung.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
