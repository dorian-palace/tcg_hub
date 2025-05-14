@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-light-primary py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-light-primary rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold text-primary mb-6">Modifier mon profil</h1>

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
                        <div class="flex-1">
                            <label for="avatar" class="block text-sm font-medium text-primary mb-2">Photo de profil</label>
                            <div class="mt-1 flex items-center">
                                <label for="avatar" class="relative cursor-pointer bg-white rounded-md font-medium text-primary hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-primary bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Choisir une photo
                                    </span>
                                    <input id="avatar" name="avatar" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="ml-4 text-sm text-secondary">PNG, JPG ou GIF jusqu'à 2MB</p>
                            </div>
                            @error('avatar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-primary">Nom</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-primary">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-primary">Adresse</label>
                        <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}"
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-primary">Ville</label>
                        <input type="text" id="city" name="city" value="{{ old('city', $user->city) }}"
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-primary">Code postal</label>
                        <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}"
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="country" class="block text-sm font-medium text-primary">Pays</label>
                        <select id="country" name="country"
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                            <option value="France" {{ old('country', $user->country) == 'France' ? 'selected' : '' }}>France</option>
                            <option value="Belgique" {{ old('country', $user->country) == 'Belgique' ? 'selected' : '' }}>Belgique</option>
                            <option value="Suisse" {{ old('country', $user->country) == 'Suisse' ? 'selected' : '' }}>Suisse</option>
                            <option value="Canada" {{ old('country', $user->country) == 'Canada' ? 'selected' : '' }}>Canada</option>
                            <option value="Luxembourg" {{ old('country', $user->country) == 'Luxembourg' ? 'selected' : '' }}>Luxembourg</option>
                        </select>
                        @error('country')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-primary">Téléphone</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="bio" class="block text-sm font-medium text-primary">Bio</label>
                        <textarea id="bio" name="bio" rows="3"
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-primary">Nouveau mot de passe</label>
                        <input type="password" id="password" name="password"
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password-confirm" class="block text-sm font-medium text-primary">Confirmer le mot de passe</label>
                        <input type="password" id="password-confirm" name="password_confirmation"
                            class="mt-1 block w-full px-3 py-2 bg-light-primary border border-light-secondary rounded-md shadow-sm placeholder-light-text-secondary text-primary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm">
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