<style>
    /* Mengatur lebar maksimal dan posisi kolom keterangan agar tidak turun */
    .keterangan-cell {
        max-width: 250px;
        /* Atur lebar maksimal kolom keterangan */
        word-wrap: break-word;
        /* Memastikan teks terbungkus dengan baik */
    }

    .keterangan-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
        /* Spasi antar keterangan */
    }

    .keterangan-text {
        flex: 1;
        /* Memastikan teks tidak melampaui lebar kolom */
        white-space: normal;
        /* Memungkinkan pembungkusan teks */
    }

    .keterangan-biaya {
        white-space: nowrap;
        /* Mencegah angka biaya terbungkus */
        text-align: right;
        margin-left: 10px;
    }

    /* Mengatur tabel agar tidak menempel ke jendela */
    .table-container {
        padding: 10px 20px;
        /* Atur padding kiri dan kanan */
    }

    /* Memastikan kolom Bukti Invoice dan Actions tidak ikut ter-scroll */
    .freeze-right {
        position: sticky;
        right: 0;
        background: white;
        z-index: 1;
    }

    select {
        max-height: 100px;
        /* Tentukan tinggi maksimal dropdown ketika dibuka */
        overflow-y: auto;
        /* Memungkinkan scroll jika isi dropdown melebihi tinggi maksimal */
    }


    .freeze-right-100 {
        position: sticky;
        right: 100px;
        background: white;
        z-index: 1;
    }

    /* Mengatur ukuran tabel agar lebih kecil dan proporsional */
    table {
        width: auto;
        /* Membuat lebar tabel tidak memenuhi seluruh jendela */
        margin: auto;
        /* Pusatkan tabel di tengah */
        border-collapse: collapse;
        /* Menggabungkan border agar lebih rapi */
    }

    th,
    td {
        padding: 8px 12px;
        /* Sesuaikan padding agar lebih proporsional */
    }
</style>

<x-layout>
    <x-slot:title>{{ $title ?? 'Invoices' }}</x-slot>

    {{-- <div id="loading" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-100 bg-opacity-50">
        <div class="loader"></div>
    </div> --}}

    <form class="relative mb-4" action="{{ route('posts.index') }}" method="GET" id="search-form">
        <div class="flex">
            <div class="relative">
                <label for="category" class="block text-sm font-medium text-gray-700"></label>
                <select name="category" id="category"
                    class="block bg-white w-full px-4 py-2.5 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="All Categories">All Categories</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ request('category') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="relative w-full">
                <input type="search" id="search-dropdown" value="{{ request('search') }}" name="search"
                    class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border border-gray-300 focus:ring-grey-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Search" autocomplete="off" />
                <button type="submit"
                    class="absolute top-0 end-0 p-2.5 h-full text-sm font-medium text-white bg-gray-700 rounded-e-lg border border-gray-700 hover:bg-gray-800 focus:ring-1 focus:outline-none focus:ring-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="grid items-end grid-cols-4 gap-4 mt-4">
            <div id="subkategori-container">
                <label for="subkategori_id" class="block text-sm font-medium text-gray-700">Sub Kategori</label>
                <select name="subkategori_id" id="subkategori_id"
                    class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Pilih Sub Kategori</option>
                    {{-- @if (isset($selectedSubKategori))
                        <option value="{{ $selectedSubKategori->id }}" selected>
                            {{ $selectedSubKategori->nama_sub_kategori }}</option>
                    @endif --}}
                    @if ($subKategoris)
                        @foreach ($subKategoris as $subKategori)
                            <option value="{{ $subKategori->id }}"
                                {{ request('subkategori_id') == $subKategori->id ? 'selected' : '' }}>
                                {{ $subKategori->nama_sub_kategori }}
                            </option>
                        @endforeach
                    @endif
                </select>

                {{-- <script>
                    $(document).ready(function() {
                        $('#kategori').on('change', function() {
                            var kategoriId = $(this).val();
                            $('#sub_kategori').empty().append('<option value="">Pilih Sub Kategori</option>');

                            if (kategoriId) {
                                $.ajax({
                                    url: '/get-subkategoris/' + kategoriId,
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(data) {
                                        $.each(data, function(key, value) {
                                            $('#sub_kategori').append('<option value="' + value.id +
                                                '">' + value.nama_sub_kategori + '</option>');
                                        });
                                    }
                                });
                            }
                        });
                    });
                </script> --}}
            </div>
            <div>
                <label for="search_seller" class="block text-sm font-medium text-gray-700">Penjual</label>
                <select name="search_seller" id="search_seller"
                    class="block w-full px-3 py-2 mt-1 overflow-auto bg-white border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm max-h-48">
                    <option value="">Pilih Penjual</option>
                    @foreach ($sellers as $seller)
                        <option value="{{ $seller->seller }}"
                            {{ request('search_seller') == $seller->seller ? 'selected' : '' }}>
                            {{ $seller->seller }}
                        </option>
                    @endforeach
                </select>

                <script>
                    $(document).ready(function() {
                        $('#search_seller').select2({
                            placeholder: 'Pilih Penjual',
                            ajax: {
                                url: '{{ route('get.sellers') }}', // Route yang sudah Anda buat
                                dataType: 'json',
                                delay: 250,
                                data: function(params) {
                                    return {
                                        term: params.term // Pencarian kata kunci yang diketik pengguna
                                    };
                                },
                                processResults: function(data) {
                                    return {
                                        results: $.map(data, function(item) {
                                            return {
                                                text: item.seller, // Teks yang akan ditampilkan di dropdown
                                                id: item.seller // Value yang akan disimpan
                                            }
                                        })
                                    };
                                },
                                cache: true
                            }
                        });
                    });
                </script>
            </div>
            <div>
                <label for="search_payer" class="block text-sm font-medium text-gray-700">Pembeli</label>
                <select name="search_payer" id="search_payer"
                    class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Pilih Pembeli</option>
                    @foreach ($payers as $payer)
                        <option value="{{ $payer->payer }}"
                            {{ request('search_payer') == $payer->payer ? 'selected' : '' }}>
                            {{ $payer->payer }}
                        </option>
                    @endforeach
                </select>
                <script>
                    $(document).ready(function() {
                        $('#search_payer').select2({
                            placeholder: 'Pilih Pembeli',
                            ajax: {
                                url: '{{ route('get.payers') }}', // Route yang sudah Anda buat
                                dataType: 'json',
                                delay: 250,
                                data: function(params) {
                                    return {
                                        term: params.term // Pencarian kata kunci yang diketik pengguna
                                    };
                                },
                                processResults: function(data) {
                                    return {
                                        results: $.map(data, function(item) {
                                            return {
                                                text: item.payer, // Teks yang akan ditampilkan di dropdown
                                                id: item.payer // Value yang akan disimpan
                                            }
                                        })
                                    };
                                },
                                cache: true
                            }
                        });
                    });
                </script>
            </div>

            <div>
                <label for="search_keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                <input type="text" name="search_keterangan" placeholder="Keterangan" id="search_keterangan"
                    value="{{ request('search_keterangan') }}"
                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    autocomplete="off">
            </div>

            <div class="flex items-center justify-between">
                <div id="date-range-picker" class="flex items-center w-full">
                    <div class="relative">
                        <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input id="datepicker-range-start" name="start_date" type="date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                            value="{{ request('start_date') }}">
                    </div>
                    <span class="mx-4 text-gray-700">to</span>
                    <div class="relative">
                        <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input id="datepicker-range-end" name="end_date" type="date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                            value="{{ request('end_date') }}">
                    </div>
                    <div>
                        <button type="button" onclick="clearForm()"
                            class=" ml-2 bg-gray-500 text-white px-3 py-1.5 rounded-md shadow-sm hover:bg-red-600 ">Clear</button>
                    </div>
                </div>


            </div>
        </div>
        </div>
    </form>



    @if ($hasSearch && $invoices->isNotEmpty())
        <form method="GET" action="{{ route('posts.index') }}" class="ml-10 ">
            <input type="hidden" name="search" value="{{ request('search') }}">
            <input type="hidden" name="category" value="{{ request('category') }}">
            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
            <label for="paginate" class="text-sm font-medium text-gray-700">Shows:</label>
            <select name="paginate" id="paginate"
                class="block py-2 pl-3 pr-10 mt-1 text-base text-white bg-gray-500 border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                onchange="this.form.submit()">
                {{-- <option value="5" {{ request('paginate') == 5 ? 'selected' : '' }}>5</option> --}}
                <option value="10" {{ request('paginate') == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('paginate') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('paginate') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('paginate') == 100 ? 'selected' : '' }}>100</option>
                <option value="1000" {{ request('paginate') == 1000 ? 'selected' : '' }}>1000</option>
            </select>
        </form>

        <div class="mx-10 overflow-x-auto">
            <table class="min-w-full mt-5 divide-y divide-gray-400">
                <thead class="bg-gray-500">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase">No</th>

                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase">ID
                            Invoice</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase">Bill
                            From
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase">Date
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase">Bill
                            to
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase">
                            Kategori
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase">
                            Sub Kategori
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase">
                            Keterangan</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase">
                            Alamat
                            Penjual</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase">
                            Alamat
                            Pembayar</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase">
                            Total
                            Biaya</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-gray-500"
                            style="position: sticky; right: 100px;; z-index: 1;">Bukti Invoice
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase bg-gray-500"
                            style="position: sticky; right: 0; z-index: 1;">Actions</th>
                    </tr>
                </thead>
                <tbody id="invoice-list" class="bg-white divide-y divide-gray-300 ">
                    @php
                        $no = ($invoices->currentPage() - 1) * $invoices->perPage() + 1;
                    @endphp
                    @foreach ($invoices as $post)
                        <tr data-category="{{ $post->kategori_id }}">
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900 whitespace-nowrap">
                                {{ $no++ }}</td>

                            <td class="px-6 py-4 text-sm font-semibold text-gray-900 whitespace-nowrap">
                                {{ $post->id_invoice }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $post->seller }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $post->date }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $post->payer }}</td>

                            <!-- Display Category -->
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                {{ $post->kategori ? $post->kategori->nama_kategori : 'Kategori tidak ditemukan' }}
                            </td>

                            <!-- Display Sub Category -->
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                {{ $post->subkategori ? $post->subkategori->nama_sub_kategori : 'tidak ditemukan' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-normal keterangan-cell">
                                @foreach ($post->keterangans as $keterangan)
                                    <div class="mb-2 keterangans-rows">
                                        <span class="keterangan-text">{{ $keterangan->keterangan }}</span>
                                        <span
                                            class="ml-4 keterangan-biaya">Rp{{ number_format($keterangan->biaya, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $post->alamat_seller }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $post->alamat_payer }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                Rp{{ number_format($post->total_biaya, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 bg-white whitespace-nowrap"
                                style="position: sticky; right: 100px; background: gray-300; z-index: 1;">
                                @if ($post->pdf_path)
                                    <a href="{{ Storage::url($post->pdf_path) }}" target="_blank"
                                        class="text-blue-600 hover:underline">Lihat Bukti</a>
                                @else
                                    Tidak ada bukti
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 bg-white whitespace-nowrap"
                                style="position: sticky; right: 0; background: gray-300; z-index: 1;">
                                <button class="px-1 py-1 mt-3 mr-1 bg-blue-500 rounded  hover:bg-blue-700"><a
                                        href="{{ route('posts.edit', $post->id) }}" class="mr-1 text-white ">Edit</a>
                                </button>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-1 py-1 text-white bg-red-600 rounded-md  hover:bg-red-700">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>


            </table>
        </div>
        <!-- Add this in your HTML where your CSRF token is defined -->
        <input type="hidden" id="csrf_token" value="{{ csrf_token() }}">

        {{-- Pagination --}}
        <div class="flex justify-center pb-10 my-8 pagination-wrapper">
            <nav aria-label="Page navigation example">
                <ul class="inline-flex h-10 -space-x-px text-base">
                    @if ($invoices->onFirstPage())
                        <li>
                            <span
                                class="flex items-center justify-center h-10 px-4 leading-tight text-gray-500 bg-white border border-gray-300 ms-0 border-e-0 rounded-s-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                                Previous
                            </span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $invoices->previousPageUrl() }}"
                                class="flex items-center justify-center h-10 px-4 leading-tight text-gray-500 bg-white border border-gray-300 ms-0 border-e-0 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                Previous
                            </a>
                        </li>
                    @endif

                    @if ($invoices->lastPage() > 1)
                        @for ($i = 1; $i <= $invoices->lastPage(); $i++)
                            @if ($i == $invoices->currentPage())
                                <li>
                                    <span aria-current="page"
                                        class="flex items-center justify-center h-10 px-4 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                                        {{ $i }}
                                    </span>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $invoices->url($i) }}"
                                        class="flex items-center justify-center h-10 px-4 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endif
                        @endfor
                    @endif

                    @if ($invoices->hasMorePages())
                        <li>
                            <a href="{{ $invoices->nextPageUrl() }}"
                                class="flex items-center justify-center h-10 px-4 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                Next
                            </a>
                        </li>
                    @else
                        <li>
                            <span
                                class="flex items-center justify-center h-10 px-4 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                                Next
                            </span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>



    @endif

    <form id="searchForm" method="GET" action="/posts" class="hidden">
        <input type="hidden" id="categoryInput" name="category" value="{{ request('category') }}">
        <input type="text" name="search" id="searchInput" placeholder="Search..."
            value="{{ request('search') }}">
        <button type="submit">Search</button>
    </form>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('category').addEventListener('change', function() {
            const kategoriId = this.value;
            const subkategoriSelect = document.getElementById('subkategori_id');


            // Kosongkan subkategori select sebelum menambahkan opsi baru
            subkategoriSelect.innerHTML = '<option value="">Pilih Sub Kategori</option>';

            if (kategoriId) {
                fetch(`/subkategoris/byKategori/${kategoriId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(subkategori => {
                            const option = document.createElement('option');
                            option.value = subkategori.id;
                            option.textContent = subkategori.nama_sub_kategori;
                            subkategoriSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching subcategories:', error);
                    });
            }
        });
        document.querySelector('form-search').addEventListener('submit', function(e) {
            var kategori = document.getElementById('kategori_id');
            var subkategori = document.getElementById('subkategori_id');
            var subkategoriContainer = document.getElementById('subkategori-container');

            if (!kategori.value) {
                e.preventDefault();
                document.getElementById('kategori-error').textContent = 'Silakan pilih kategori.';
            } else {
                document.getElementById('kategori-error').textContent = '';
            }

            if (!subkategoriContainer.classList.contains('hidden') && !subkategori.value) {
                e.preventDefault();
                document.getElementById('subkategori-error').textContent = 'Silakan pilih subkategori.';
            } else {
                document.getElementById('subkategori-error').textContent = '';
            }
        });
        document.addEventListener('DOMContentLoaded', () => {
            const deleteForms = document.querySelectorAll('form[method="POST"]');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();

                    Swal.fire({
                        title: 'Yakin hapus?',
                        text: "Hilang lho nanti",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(form.action, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'input[name="_token"]').value,
                                        'X-Requested-With': 'XMLHttpRequest'
                                    },
                                    body: new FormData(form)
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire('Deleted!',
                                            'Your file has been deleted.', 'success'
                                        ).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire('Error!',
                                            'There was an error deleting the data.',
                                            'error');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire('Error!',
                                        'There was an error deleting the data.',
                                        'error');
                                });
                        }
                    });
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    title: 'Success',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif
        });

        function clearForm() {
            // document.getElementById('category').value = 'All Category';
            document.getElementById('subkategori_id').value = '';
            document.getElementById('search_seller').value = '';
            document.getElementById('search_payer').value = '';
            document.getElementById('search_keterangan').value = '';
            document.getElementById('datepicker-range-start').value = '';
            document.getElementById('datepicker-range-end').value = '';
            document.getElementById('search-dropdown').value = '';
        }
    </script>
</x-layout>
