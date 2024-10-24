<x-layout>
    <x-slot:title>Daftar Kategori dan Subkategori</x-slot>
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Daftar Kategori dan Subkategori</h1>
            <a href="{{ route('kategori.create') }}"
                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                Tambah Kategori
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th
                            class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                            Kategori
                        </th>
                        <th
                            class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                            Subkategori
                        </th>
                        <th
                            class="px-6 py-3 border-b-2 border-gray-300 bg-gray-100 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoris as $kategori)
                        <tr>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm font-medium text-gray-900">
                                {{ $kategori->nama_kategori }}
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm text-gray-900">
                                @if ($kategori->subkategoris->count() > 0)
                                    <ul class="list-disc list-inside space-y-2">
                                        @foreach ($kategori->subkategoris as $subkategori)
                                            <li>{{ $subkategori->nama_sub_kategori }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-500 italic">Tidak ada subkategori</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm text-gray-900 space-x-2">
                                <a href="{{ route('kategori.edit', $kategori->id) }}"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Edit
                                </a>
                                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3"
                                class="px-6 py-4 border-b border-gray-200 text-center text-sm text-gray-500">
                                Belum ada kategori yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $kategoris->links() }}
    </div>
</x-layout>
