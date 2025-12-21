<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kartu Keluarga</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-yellow-500 p-4">
                <h2 class="text-xl text-white font-bold">✏️ Edit Kartu Keluarga</h2>
            </div>
            <div class="p-6">
                <form action="{{ route('kk.update', $kk->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Nomor Kartu Keluarga</label>
                        <input type="text" name="nomor_kk" value="{{ old('nomor_kk', $kk->nomor_kk) }}"
                            maxlength="16" required class="w-full px-3 py-2 border rounded-lg bg-gray-100" readonly>
                        <p class="text-xs text-red-500 mt-1">*Nomor KK tidak bisa diubah sembarangan.</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Nama Kepala Keluarga</label>
                        <input type="text" name="kepala_keluarga"
                            value="{{ old('kepala_keluarga', $kk->kepala_keluarga) }}" required
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" rows="2" required
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500">{{ old('alamat_lengkap', $kk->alamat_lengkap) }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">RT / RW (Wilayah)</label>
                        <select name="rt_id" required
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500 bg-white">
                            @foreach ($rts as $rt)
                                <option value="{{ $rt->id }}" {{ $kk->rt_id == $rt->id ? 'selected' : '' }}>
                                    RT {{ $rt->nomor }} / RW {{ $rt->rw->nomor }} ({{ $rt->rw->dusun->nama }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('kk.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Batal</a>
                        <button type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">Update
                            KK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
