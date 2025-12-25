@extends('layouts.app')

@section('title', 'Edit RT')
@section('header', 'Edit Data RT')

@section('content')
    <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-lg mx-auto">
        <div class="bg-yellow-500 p-4">
            <h2 class="text-xl text-white font-bold">✏️ Edit Data RT</h2>
        </div>

        <div class="p-6">
            <form action="{{ route('rt.update', $rt->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Induk RW</label>
                    <select name="rw_id" class="w-full border p-2 rounded focus:ring-2 focus:ring-yellow-500 bg-white"
                        required>
                        <option value="">-- Pilih RW --</option>
                        @foreach ($rws as $rw)
                            <option value="{{ $rw->id }}" {{ $rt->rw_id == $rw->id ? 'selected' : '' }}>
                                RW {{ $rw->nomor }} - ({{ $rw->dusun->nama }})
                            </option>
                        @endforeach
                    </select>
                    @error('rw_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Nomor RT</label>
                    <input type="text" name="nomor" value="{{ old('nomor', $rt->nomor) }}"
                        class="w-full border p-2 rounded focus:ring-2 focus:ring-yellow-500"
                        placeholder="Contoh: 01, 05, dll" required>
                    @error('nomor')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Nama Kepala RT</label>
                    <input type="text" name="kepala_rt" value="{{ old('kepala_rt', $rt->kepala_rt) }}"
                        class="w-full border p-2 rounded focus:ring-2 focus:ring-yellow-500"
                        placeholder="Nama Bapak/Ibu Ketua RT">
                    @error('kepala_rt')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <a href="{{ route('rt.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition duration-200">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded transition duration-200 shadow-md">
                        Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
