<x-layout>
    <x-slot:title>{{ $title ?? 'Tambah Kategori dan Sub Kategori' }}</x-slot>

    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <h1 class="text-3xl font-bold mb-6">Tambah Kategori dan Subkategori</h1>
        <form action="{{ route('kategori.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="nama_kategori" class="block mb-2">Nama Kategori:</label>
                <input type="text" name="nama_kategori" id="nama_kategori" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <h3 class="text-xl font-semibold mb-3">Subkategori</h3>
                <div id="subkategori-wrapper" class="space-y-4">
                    <div class="subkategori-item flex items-center space-x-2">
                        <input type="text" name="subkategori[]"
                            class="subkategori flex-grow px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required placeholder="Nama Subkategori">
                        <button type="button"
                            class="remove-subkategori px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">Hapus</button>
                    </div>
                </div>
                <button type="button" id="add-subkategori"
                    class="mt-4 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Tambah
                    Subkategori</button>
            </div>

            <button type="submit"
                class="w-full px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Tambah
                Kategori</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const subkategoriWrapper = document.getElementById('subkategori-wrapper');
            const addSubkategoriButton = document.getElementById('add-subkategori');

            // Fungsi untuk menambah subkategori
            addSubkategoriButton.addEventListener('click', function() {
                const newSubkategori = document.createElement('div');
                newSubkategori.className = 'subkategori-item flex items-center space-x-2';
                newSubkategori.innerHTML = `
                    <input type="text" name="subkategori[]"
                        class="subkategori flex-grow px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required placeholder="Nama Subkategori">
                    <button type="button"
                        class="remove-subkategori px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">Hapus</button>
                `;
                subkategoriWrapper.appendChild(newSubkategori);
            });

            // Fungsi untuk menghapus subkategori
            subkategoriWrapper.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-subkategori')) {
                    e.target.closest('.subkategori-item').remove();
                }
            });
        });
    </script>
</x-layout>
