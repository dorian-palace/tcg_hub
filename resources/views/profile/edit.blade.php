@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-light-primary py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-light-primary rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold text-white mb-6">Modifier mon profil</h1>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="space-y-4">
                    <!-- Photo de profil -->
                    <div class="flex items-center space-x-6">
                        <div class="flex-shrink-0">
                            @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" 
                                     class="h-24 w-24 rounded-full object-cover border-4 border-light-secondary">
                            @else
                                <div class="h-24 w-24 rounded-full bg-light-secondary text-blue-400 flex items-center justify-center border-4 border-light-secondary">
                                    <span class="text-3xl font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div>
                            <label for="avatar" class="block text-sm font-medium text-gray-300">Photo de profil</label>
                            <input type="file" id="avatar" name="avatar" accept="image/*"
                                class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                            <p class="mt-1 text-sm text-gray-400">PNG, JPG ou GIF jusqu'à 2MB</p>
                            @error('avatar')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300">Nom</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-300">Adresse</label>
                        <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}"
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('address')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-300">Ville</label>
                        <input type="text" id="city" name="city" value="{{ old('city', $user->city) }}"
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('city')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-300">Code postal</label>
                        <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}"
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-300">Pays</label>
                        <select id="country" name="country"
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                            <option value="France" {{ old('country', $user->country) == 'France' ? 'selected' : '' }}>France</option>
                            <option value="Belgique" {{ old('country', $user->country) == 'Belgique' ? 'selected' : '' }}>Belgique</option>
                            <option value="Suisse" {{ old('country', $user->country) == 'Suisse' ? 'selected' : '' }}>Suisse</option>
                            <option value="Canada" {{ old('country', $user->country) == 'Canada' ? 'selected' : '' }}>Canada</option>
                            <option value="Luxembourg" {{ old('country', $user->country) == 'Luxembourg' ? 'selected' : '' }}>Luxembourg</option>
                        </select>
                        @error('country')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-300">Téléphone</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-300">Bio</label>
                        <textarea id="bio" name="bio" rows="3"
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300">Nouveau mot de passe</label>
                        <input type="password" id="password" name="password"
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password-confirm" class="block text-sm font-medium text-gray-300">Confirmer le mot de passe</label>
                        <input type="password" id="password-confirm" name="password_confirmation"
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-light-text focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Mettre à jour le profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection