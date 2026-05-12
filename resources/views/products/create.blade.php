@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-[32px] border border-white/10 bg-slate-900/80 p-6 shadow-2xl shadow-slate-950/40 backdrop-blur-lg">
            <div class="flex flex-col gap-2">
                <h2 class="text-3xl font-semibold tracking-tight text-white">Tambah Barang Baru</h2>
                <p class="text-sm text-slate-400">Tambahkan barang baru ke inventori toko.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <div>
                    <label for="nama_barang" class="block text-sm font-medium text-slate-900">Nama Barang</label>
                    <input id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}" required autofocus
                           class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-2 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500" />
                    @error('nama_barang') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="harga" class="block text-sm font-medium text-slate-900">Harga (Rp)</label>
                    <input id="harga" name="harga" type="number" value="{{ old('harga') }}" required min="0" step="0.01"
                           class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-2 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500" />
                    @error('harga') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="stok" class="block text-sm font-medium text-slate-900">Stok</label>
                    <input id="stok" name="stok" type="number" value="{{ old('stok') }}" required min="0"
                           class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-2 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500" />
                    @error('stok') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="gambar" class="block text-sm font-medium text-slate-900">Gambar Produk</label>
                    <input id="gambar" name="gambar" type="file" accept="image/*"
                           class="mt-2 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-emerald-600 file:text-white hover:file:bg-emerald-700" />
                    <p class="mt-2 text-sm text-slate-500">Format: JPG, PNG, GIF. Maksimal 2MB.</p>
                    @error('gambar') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div id="image-preview" class="hidden">
                    <label class="block text-sm font-medium text-slate-900">Preview Gambar</label>
                    <img id="preview-img" class="mt-3 h-32 w-32 rounded-xl object-cover border border-slate-200" />
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl border border-slate-300 text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 transition">Batal</a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 rounded-xl bg-emerald-600 text-sm font-medium text-white hover:bg-emerald-700 transition">Simpan Barang</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('gambar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('image-preview');
            const previewImg = document.getElementById('preview-img');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                preview.classList.add('hidden');
            }
        });
    </script>
@endsection
