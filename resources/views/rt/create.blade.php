@extends('layouts.app')

@section('title', 'Tambah RT')
@section('header', 'Tambah RT')

@section('content')
    <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-lg mx-auto">
        <div class="bg-blue-600 p-4">
            <h2 class="text-xl text-white font-bold">Form RT Baru</h2>
        </div>

        <div class="p-6">
            <form action="{{ route('rt.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block mb-2 font-bold text-gray-700">Nomor RT</label>
                    <input type="text" name="nomor" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500"
                        placeholder="Contoh: 001" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-2 font-bold text-gray-700">Pilih Dusun</label>
                    <select id="dusun_id" class="w-full border p-2 rounded bg-white focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Dusun Terlebih Dahulu --</option>
                        @foreach ($dusuns as $d)
                            <option value="{{ $d->id }}">{{ $d->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-2 font-bold text-gray-700">Pilih RW</label>
                    <select name="rw_id" id="rw_id" class="w-full border p-2 rounded bg-gray-100 cursor-not-allowed"
                        required disabled>
                        <option value="">-- Pilih Dusun di atas dulu --</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <a href="{{ route('rt.index') }}" class="bg-gray-500 text-white font-bold py-2 px-4 rounded">Batal</a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const allRws = @json($rws);
        const dusunSelect = document.getElementById('dusun_id');
        const rwSelect = document.getElementById('rw_id');

        dusunSelect.addEventListener('change', function() {
            const selectedDusunId = this.value;
            rwSelect.innerHTML = '<option value="">-- Pilih RW --</option>';

            if (selectedDusunId) {
                rwSelect.disabled = false;
                rwSelect.classList.remove('bg-gray-100', 'cursor-not-allowed');
                rwSelect.classList.add('bg-white');

                const filteredRws = allRws.filter(rw => rw.dusun_id == selectedDusunId);
                if (filteredRws.length > 0) {
                    filteredRws.forEach(rw => {
                        const option = document.createElement('option');
                        option.value = rw.id;
                        option.textContent = `RW ${rw.nomor}`;
                        rwSelect.appendChild(option);
                    });
                } else {
                    const option = document.createElement('option');
                    option.text = "Belum ada RW di Dusun ini";
                    rwSelect.appendChild(option);
                }
            } else {
                rwSelect.disabled = true;
                rwSelect.classList.add('bg-gray-100', 'cursor-not-allowed');
                rwSelect.innerHTML = '<option value="">-- Pilih Dusun di atas dulu --</option>';
            }
        });
    </script>
@endsection
