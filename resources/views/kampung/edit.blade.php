@extends('layouts.app')

@section('title', 'Edit Kampung')
@section('header', 'Edit Data Kampung')

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-yellow-500 p-4">
            <h2 class="text-white text-lg font-bold">Edit Kampung</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('kampung.update', $kampung->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Nama Kampung</label>
                    <input type="text" name="nama_kampung" value="{{ $kampung->nama_kampung }}"
                        class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-yellow-200" required>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Nama Ketua/Kepala Kampung</label>
                    <input type="text" name="kepala_kampung" value="{{ $kampung->kepala_kampung }}"
                        class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-yellow-200">
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('kampung.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
                    <button type="submit"
                        class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 font-bold">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
