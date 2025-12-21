<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Dusun</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">
    <div class="container mx-auto max-w-lg bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Edit Dusun</h2>
        <form action="{{ route('dusun.update', $dusun->id) }}" method="POST">
            @csrf @method('PUT')
            <label class="block mb-2 font-bold">Nama Dusun</label>
            <input type="text" name="nama" value="{{ $dusun->nama }}" class="w-full border p-2 rounded mb-4"
                required>
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>
</body>

</html>
