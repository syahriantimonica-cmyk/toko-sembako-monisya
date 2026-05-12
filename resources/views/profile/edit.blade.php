@extends('layouts.app')

@section('content')
    <div x-data="{ hasPhoto: {{ $user->profile_photo ? 'true' : 'false' }} }" class="min-h-screen bg-slate-100 py-6 md:py-8 w-full">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 w-full">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900">Pengaturan Profil</h1>
                <p class="mt-2 text-sm text-slate-600">Kelola informasi akun dan keamanan Anda</p>
            </div>

            <!-- Status Messages -->
            @if(session('status') === 'profile-updated')
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-800 shadow-sm">
                    ✓ Profil berhasil diperbarui
                </div>
            @endif
            @if(session('status') === 'photo-deleted')
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-800 shadow-sm">
                    ✓ Foto profil berhasil dihapus
                </div>
            @endif

            <!-- Profile Card -->
            <div class="mb-8 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <!-- Header Section -->
                <div class="border-b border-slate-200 p-6 md:p-8">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:gap-8 items-center lg:items-start text-center lg:text-left">
                        <!-- Avatar -->
                        <div class="relative">
                            <template x-if="hasPhoto">
                                <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : '' }}" alt="{{ $user->name }}" class="h-28 w-28 rounded-2xl object-cover border-4 border-emerald-100 shadow-md" />
                            </template>
                            <template x-if="!hasPhoto">
                                <div class="flex h-28 w-28 items-center justify-center rounded-2xl border-4 border-primary-100 bg-gradient-to-br from-primary-400 to-primary-600 shadow-md">
                                    <span class="text-4xl font-bold text-white">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $user->name)[1] ?? '', 0, 1)) }}
                                    </span>
                                </div>
                            </template>
                            @if(Auth::user()->role === 'admin')
                                <button type="button" onclick="document.getElementById('profile_photo_upload').click();" class="absolute bottom-0 right-0 flex h-8 w-8 items-center justify-center rounded-full border-2 border-white bg-primary-600 text-white shadow-md hover:bg-primary-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            @endif
                        </div>

                        <!-- User Info -->
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-slate-900">{{ $user->name }}</h2>
                            <p class="mt-1 text-sm text-slate-600">{{ $user->email }}</p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700 capitalize">
                                    {{ $user->role === 'admin' ? 'Administrator' : 'Kasir' }}
                                </span>
                                <template x-if="hasPhoto">
                                    <span class="inline-flex rounded-full bg-primary-100 px-3 py-1 text-sm font-medium text-primary-700">
                                        ✓ Foto Aktif
                                    </span>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Section -->
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 md:space-y-8 p-6 md:p-8 w-full">
                    @csrf
                    @method('PATCH')

                    <!-- Informasi Profil -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Informasi Profil</h3>
                            <p class="mt-1 text-sm text-slate-600">Perbarui data pribadi Anda</p>
                        </div>

                        <!-- Nama -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-900">Nama Lengkap</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', $user->name) }}" 
                                class="mt-3 w-full max-w-xl rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 transition placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100" 
                                placeholder="Masukkan nama lengkap"
                            />
                            @error('name')
                                <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-900">Email</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email', $user->email) }}" 
                                class="mt-3 w-full max-w-xl rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 transition placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100" 
                                placeholder="Masukkan email"
                            />
                            @error('email')
                                <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Profile Photo Upload -->
                        <div>
                            <label for="profile_photo" class="block text-sm font-semibold text-slate-900">Foto Profil</label>
                            <div class="mt-3 flex flex-col sm:flex-row items-center gap-4">
                                <div id="photoUploadBox" class="flex-1">
                                    <label for="profile_photo" class="flex cursor-pointer items-center gap-3 rounded-xl border-2 border-dashed border-slate-300 px-6 py-6 transition hover:border-primary-400 hover:bg-primary-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-slate-700">Klik untuk upload foto</p>
                                            <p class="text-xs text-slate-500">JPG, PNG, WEBP (Max 2MB)</p>
                                        </div>
                                        <input 
                                            type="file" 
                                            id="profile_photo" 
                                            name="profile_photo" 
                                            class="hidden" 
                                            accept="image/jpeg,image/png,image/webp"
                                            onchange="document.getElementById('photoFileName').textContent = this.files[0]?.name || ''"
                                        />
                                    </label>
                                    <p id="photoFileName" class="mt-2 text-sm text-primary-600"></p>
                                </div>

                                <template x-if="hasPhoto">
                                    <button type="button" @click="if(confirm('Hapus foto profil?')) { 
                                        fetch('{{ route('profile.deletePhoto') }}', {
                                            method: 'POST',
                                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json'},
                                            body: JSON.stringify({_method: 'DELETE'})
                                        }).then(r => r.json()).then(d => { if(d.success) hasPhoto = false; });
                                    }" class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700 transition hover:bg-rose-100">
                                        Hapus Foto
                                    </button>
                                </template>
                            </div>
                            @error('profile_photo')
                                <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Keamanan Password -->
                    <div class="border-t border-slate-200 pt-8">
                        <div class="mb-6 space-y-1 px-1">
                            <h3 class="text-lg font-bold text-slate-900 leading-relaxed">Keamanan</h3>
                            <p class="text-sm text-slate-600 leading-relaxed">Ubah password akun Anda</p>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-slate-900">Password Baru</label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="mt-3 w-full max-w-xl rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 transition placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100" 
                                placeholder="Biarkan kosong jika tidak ingin mengubah"
                            />
                            <p class="mt-2 text-xs text-slate-500">Minimal 6 karakter</p>
                            @error('password')
                                <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div class="mt-4">
                            <label for="password_confirmation" class="block text-sm font-semibold text-slate-900">Konfirmasi Password</label>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                class="mt-3 w-full max-w-xl rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 transition placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-100" 
                                placeholder="Konfirmasi password baru"
                            />
                            @error('password_confirmation')
                                <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="border-t border-slate-200 pt-6 md:pt-8 flex flex-col md:flex-row gap-3">
                        <button 
                            type="submit" 
                            class="w-full md:w-auto rounded-xl bg-emerald-600 px-8 py-3 text-sm font-semibold text-white transition hover:bg-emerald-500 active:scale-95 text-center"
                        >
                            Simpan Perubahan
                        </button>
                        <a 
                            href="{{ route('dashboard') }}" 
                            class="w-full md:w-auto rounded-xl border border-slate-200 bg-white px-8 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 text-center"
                        >
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <input type="file" id="profile_photo_upload" name="profile_photo" class="hidden" accept="image/jpeg,image/png,image/webp" />
@endsection

