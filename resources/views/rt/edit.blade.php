@extends('layouts.app')

@section('title', 'Edit RT')
@section('header', 'Edit RT')

@section('content')
    <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-lg mx-auto">
        <div class="bg-yellow-500 p-4">
            <h2 class="text-xl text-white font-bold">Edit Data RT</h2>
        </div>

        <div class="p-6">
            <form action="{{ route('rt.update', $rt->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-4">
                    <label class="block mb-2 font-bold text-gray-700">Nomor RT</label>
                    <input type="text" name="nomor" value="{{ $rt->nomor }}"
                        class="w-full border p-2 rounded focus:ring-2 focus:ring-yellow-500" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-2 font-bold text-gray-700">Pilih Dusun</label>
                    <select id="dusun_id" class="w-full border p-2 rounded bg-white focus:ring-2 focus:ring-yellow-500">
                        <option value="">-- Pilih Dusun --</option>
                        @foreach ($dusuns as $d)
                            <option value="{{ $d->id }}" {{ $rt->rw->dusun_id == $d->id ? 'selected' : '' }}>
                                {{ $d->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-2 font-bold text-gray-700">Pilih RW</label>
                    <select name="rw_id" id="rw_id"
                        class="w-full border p-2 rounded bg-white focus:ring-2 focus:ring-yellow-500" required>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <a href="{{ route('rt.index') }}" class="bg-gray-500 text-white font-bold py-2 px-4 rounded">Batal</a>
                    <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const allRws = @json($rws);
        const currentRwId = "{{ $rt->rw_id }}";
        const dusunSelect = document.getElementById('dusun_id');
        const rwSelect = document.getElementById('rw_id');

        function populateRw(selectedDusunId, selectedRwId = null) {
            rwSelect.innerHTML = '<option value="">-- Pilih RW --</option>';
            if (selectedDusunId) {
                rwSelect.disabled = false;
                const filteredRws = allRws.filter(rw => rw.dusun_id == selectedDusunId);
                if (filteredRws.length > 0) {
                    filteredRws.forEach(rw => {
                        const option = document.createElement('option');
                        option.value = rw.id;
                        option.textContent = `RW ${rw.nomor}`;
                        if (selectedRwId && rw.id == selectedRwId) option.selected = true;
                        rwSelect.appendChild(option);
                    });
                } else {
                    const option = document.createElement('option');
                    option.text = "Belum ada RW di Dusun ini";
                    rwSelect.appendChild(option);
                }
            } else {
                rwSelect.disabled = true;
            }
        }

        populateRw(dusunSelect.value, currentRwId);
        dusunSelect.addEventListener('change', function() {
            populateRw(this.value, null);
        });
    </script>
@endsection
