@extends('layouts.app')

@section('title', 'Edit RW')
@section('header', 'Edit RW')

@section('content')
    <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-lg mx-auto">
        <div class="bg-yellow-500 p-4">
            <h2 class="text-xl text-white font-bold">Edit Data RW</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('rw.update', $rw->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Nomor RW</label>
                    <input type="text" name="nomor" value="{{ $rw->nomor }}"
                        class="w-full border p-2 rounded focus:ring-2 focus:ring-yellow-500" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Pilih Dusun</label>
                    <select name="dusun_id" class="w-full border p-2 rounded bg-white" required>
                        @foreach ($dusuns as $d)
                            <option value="{{ $d->id }}" {{ $rw->dusun_id == $d->id ? 'selected' : '' }}>
                                {{ $d->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <a href="{{ route('rw.index') }}" class="bg-gray-500 text-white font-bold py-2 px-4 rounded">Batal</a>
                    <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
