<x-layout>
    <x-slot:title>Edit Data</x-slot:title>
    <h2 class="max-w-md mx-auto p-4 bg-white rounded-lg shadow-md text-center font-semibold mb-6">Edit Data</h2>
    <form action="{{ route('posts.update', $invoice->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off"
        class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 gap-6">
            <!-- ID Invoice -->
            <div>
                <label for="id_invoice" class="block text-sm font-medium text-gray-700">ID / Invoice</label>
                <input
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-50"
                    type="text" id="id_invoice" name="id_invoice" value="{{ $invoice->id_invoice }}" required
                    autocomplete="off">
            </div>

            <!-- Kategori -->
            <div>
                <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-50"
                    id="kategori_id" name="kategori_id" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ $invoice->kategori_id == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                <span class="error-message" id="kategori-error"></span>
            </div>

            <div id="subkategori-container">
                <label for="subkategori_id" class="block text-sm font-medium text-gray-700">Subkategori</label>
                <select name="subkategori_id" id="subkategori_id"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Pilih Subkategori</option>
                    @if (isset($selectedSubKategori))
                        <option value="{{ $selectedSubKategori->id }}" selected>
                            {{ $selectedSubKategori->nama_sub_kategori }}</option>
                    @endif
                </select>
                <span class="error-message" id="subkategori-error"></span>
            </div>



            <!-- Date -->
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                <input
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-50"
                    type="date" id="date" name="date" value="{{ $invoice->date }}" required
                    autocomplete="off">
            </div>

            <!-- Penjual -->
            <div>
                <label for="seller" class="block text-sm font-medium text-gray-700">Penjual</label>
                <input
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-50"
                    type="text" id="seller" name="seller" value="{{ $invoice->seller }}" required
                    autocomplete="off">
            </div>

            <!-- Alamat Penjual -->
            <div>
                <label for="alamat_seller" class="block text-sm font-medium text-gray-700">Alamat Penjual</label>
                <input
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-50"
                    type="text" id="alamat_seller" name="alamat_seller" value="{{ $invoice->alamat_seller }}"
                    required autocomplete="off">
            </div>

            <!-- Pembeli -->
            <div>
                <label for="payer" class="block text-sm font-medium text-gray-700">Pembeli</label>
                <input
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-50"
                    type="text" id="payer" name="payer" value="{{ $invoice->payer }}" required
                    autocomplete="off">
            </div>

            <!-- Alamat Pembeli -->
            <div>
                <label for="alamat_payer" class="block text-sm font-medium text-gray-700">Alamat Pembeli</label>
                <input
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-50"
                    type="text" id="alamat_payer" name="alamat_payer" value="{{ $invoice->alamat_payer }}" required
                    autocomplete="off">
            </div>

            <!-- Jumlah Keterangan -->
            <div>
                <label for="keterangan_count" class="block text-sm font-medium text-gray-700">Jumlah Keterangan</label>
                <input
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-50 no-spinner"
                    type="number" id="keterangan_count" name="keterangan_count" min="1"
                    value="{{ count($invoice->keterangans) }}" required autocomplete="off" readonly>
            </div>

            <!-- Tambah Keterangan -->
            <div>
                <button type="button" onclick="addKeteranganField()"
                    class="mt-2 w-full bg-green-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300 ease-in-out transform hover:scale-105">Tambah
                    Keterangan</button>
            </div>

            <!-- Field Keterangan -->
            <div id="keterangan-fields" class="grid grid-cols-1 gap-6">
                @foreach ($invoice->keterangans as $index => $keterangan)
                    <div class="grid grid-cols-1 gap-4 mt-3 keterangan-item" id="keterangan-field-{{ $index + 1 }}">
                        <div>
                            <label for="keterangan_{{ $index + 1 }}"
                                class="block text-sm font-medium text-gray-700 keterangan-label">Keterangan
                                {{ $index + 1 }}</label>
                            <input
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-50"
                                type="text" id="keterangan_{{ $index + 1 }}" name="keterangan[]"
                                value="{{ $keterangan->keterangan }}" required autocomplete="off">
                        </div>
                        <div>
                            <label for="biaya_keterangan_{{ $index + 1 }}"
                                class="block text-sm font-medium text-gray-700 biaya-label">Biaya
                                {{ $index + 1 }}</label>
                            <input
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-50 biaya-input no-spinner"
                                type="number" id="biaya_keterangan_{{ $index + 1 }}" name="biaya_keterangan[]"
                                value="{{ $keterangan->biaya }}" oninput="calculateTotalBiaya()" required
                                autocomplete="off">
                        </div>
                        <div>
                            <button type="button" onclick="deleteKeterangan({{ $index + 1 }})"
                                class="mt-2 bg-red-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300 ease-in-out transform hover:scale-105">Delete</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Total Biaya -->
            <div>
                <label for="total_biaya" class="block text-sm font-medium text-gray-700">Total Biaya</label>
                <input
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-50"
                    type="text" id="total_biaya" name="total_biaya" value="{{ $invoice->total_biaya }}" readonly
                    autocomplete="off">
            </div>

            <!-- Bukti Invoice -->
            <div>
                <label for="pdf_file" class="block text-sm font-medium text-gray-700">Bukti Invoice</label>
                <input
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-50"
                    type="file" id="pdf_file" name="pdf_file">
                @if ($invoice->pdf_path)
                    <p class="mt-2 text-sm text-gray-500">Bukti saat ini: <a
                            href="{{ Storage::url($invoice->pdf_path) }}" target="_blank"
                            class="text-blue-600 hover:underline">Lihat Bukti</a></p>
                @endif
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="mt-2 w-full bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 ease-in-out transform hover:scale-105">Submit</button>
            </div>

            <!-- Back Button -->
            <div>
                <a href="{{ route('posts.index') }}"
                    class=" w-full bg-slate-400 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-300 ease-in-out transform hover:scale-105 text-center block">Back</a>
            </div>
        </div>
    </form>

    <style>
        .error-message {
            color: red;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* CSS untuk menghilangkan spinner pada input number dan date */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button,
        input[type="date"]::-webkit-inner-spin-button,
        input[type="date"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"],
        input[type="date"] {
            -moz-appearance: textfield;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Event listener untuk perubahan kategori
        document.getElementById('kategori_id').addEventListener('change', function() {
            const kategoriId = this.value;
            const subkategoriSelect = document.getElementById('subkategori_id');

            // Kosongkan subkategori select sebelum menambahkan opsi baru
            subkategoriSelect.innerHTML = '<option value="">Pilih Subkategori</option>';

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

        // Validasi tambahan untuk subkategori
        document.querySelector('form').addEventListener('submit', function(e) {
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
        let keteranganCount = {{ count($invoice->keterangans) }}; // Mulai dari jumlah keterangan yang ada

        function addKeteranganField() {
            const keteranganFields = document.getElementById('keterangan-fields');
            const existingItems = document.querySelectorAll('.keterangan-item');
            const newIndex = existingItems.length + 1; // Set the new index based on current items

            var newItem = document.createElement('div');
            newItem.className = 'grid grid-cols-1 gap-4 mt-3 keterangan-item';
            newItem.setAttribute('id', `keterangan-field-${newIndex}`);

            newItem.innerHTML = `
        <div>
            <label for="keterangan_${newIndex}" class="block text-sm font-medium text-gray-700">Keterangan ${newIndex}</label>
            <input class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-50" type="text" id="keterangan_${newIndex}" name="keterangan[]" required autocomplete="off" placeholder="Masukkan Keterangan">
        </div>
        <div>
            <label for="biaya_keterangan_${newIndex}" class="block text-sm font-medium text-gray-700">Biaya ${newIndex}</label>
            <input class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-50 biaya-input no-spinner" type="number" id="biaya_keterangan_${newIndex}" name="biaya_keterangan[]" oninput="calculateTotalBiaya()" required autocomplete="off" placeholder="Masukkan Biaya">
        </div>
        <div>
            <button type="button" onclick="deleteKeterangan(${newIndex})" class="mt-2 bg-red-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300 ease-in-out transform hover:scale-105">Delete</button>
        </div>
    `;
            keteranganFields.appendChild(newItem);
            updateKeteranganCount(); // Update the jumlah keterangan
        }

        function deleteKeterangan(index) {
            var element = document.getElementById(`keterangan-field-${index}`);
            if (element) {
                element.remove();
                recalculateKeteranganNumbers(); // Renumber items
                calculateTotalBiaya();
            }
        }

        function recalculateKeteranganNumbers() {
            var keteranganItems = document.querySelectorAll('#keterangan-fields > div');
            keteranganItems.forEach(function(item, idx) {
                const newIndex = idx + 1;
                item.setAttribute('id', `keterangan-field-${newIndex}`);
                item.querySelector('label[for^="keterangan_"]').textContent = `Keterangan ${newIndex}`;
                item.querySelector('label[for^="biaya_keterangan_"]').textContent = `Biaya ${newIndex}`;
                item.querySelector('input[id^="keterangan_"]').setAttribute('id', `keterangan_${newIndex}`);
                item.querySelector('input[id^="biaya_keterangan_"]').setAttribute('id',
                    `biaya_keterangan_${newIndex}`);
                item.querySelector('button').setAttribute('onclick', `deleteKeterangan(${newIndex})`);
            });
            updateKeteranganCount();
        }

        function calculateTotalBiaya() {
            var biayaFields = document.querySelectorAll('input[name="biaya_keterangan[]"]');
            var totalBiaya = 0;

            biayaFields.forEach(function(field) {
                totalBiaya += parseFloat(field.value) || 0;
            });

            document.getElementById('total_biaya').value = totalBiaya.toFixed(2);
        }

        function updateKeteranganCount() {
            document.getElementById('keterangan_count').value = document.querySelectorAll('.keterangan-item').length;
        }

        // Batasi input biaya agar tidak bisa negatif
        document.addEventListener('DOMContentLoaded', function() {
            // Batasi input biaya agar tidak bisa negatif
            document.querySelectorAll('.biaya-input').forEach(function(element) {
                element.addEventListener('input', function() {
                    if (this.value < 0) {
                        this.value = ''; // Kosongkan nilai jika negatif
                    }
                });
            });

            updateKeteranganIndices();
            updateKeteranganCount();

            // Menampilkan alert sukses jika ada pesan sukses di session
            @if (session('success'))
                Swal.fire({
                    title: 'Success',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif
        });


        // Menampilkan alert kesalahan jika ada pesan kesalahan di session
        @if (session('error'))
            Swal.fire({
                title: 'Error',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                title: 'Error',
                text: '{{ $errors->first('id_invoice') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif

        // Validasi input hanya angka
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.biaya-input').forEach(function(element) {
                element.addEventListener('keypress', function(e) {
                    if (e.which < 48 || e.which > 57) {
                        e.preventDefault();
                    }
                });
            });

            // Validasi untuk kategori
            document.querySelector('form').addEventListener('submit', function(e) {
                var kategori = document.getElementById('kategori_id');
                var errorMessage = document.getElementById('kategori-error');

                if (!kategori.value) {
                    e.preventDefault(); // Mencegah form dari submit jika kategori belum dipilih
                    errorMessage.textContent = 'Silakan pilih kategori.'; // Tampilkan pesan error
                    errorMessage.style.color = 'red'; // Tambahkan warna merah untuk pesan error
                } else {
                    errorMessage.textContent = ''; // Hapus pesan error jika kategori sudah dipilih
                }
            });

        });
    </script>
</x-layout>
