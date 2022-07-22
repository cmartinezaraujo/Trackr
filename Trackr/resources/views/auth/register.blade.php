<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- First Name -->
            <div>
                <x-label for="first_name" :value="__('FirstName')" />

                <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                    :value="old('first_name')" required autofocus />
            </div>

            <!-- Last Name -->
            <div>
                <x-label for="last_name" :value="__('Last Name')" />

                <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')"
                    required autofocus />
            </div>

            <!-- Middle Name -->
            <div>
                <x-label for="middle_name" :value="__('Middle Name')" />

                <x-input id="middle_name" class="block mt-1 w-full" type="text" name="middle_name"
                    :value="old('middle_name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required />
            </div>

            <!-- Status -->
            <div class="mt-4">

                <x-label for="status">Select one for your current health status.</x-label>

                <div class="form-check form-check-inline">
                    <input class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 
                    bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top 
                    bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="status"
                        id="Healthy" value="healthy">
                    <label class="form-check-label inline-block text-gray-800" for="Healthy">Healthy</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 
                    bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top 
                    bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="status"
                        id="Sick" value="sick">

                    <label class="form-check-label inline-block text-gray-800" for="Sick">Sick</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 
                    bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top 
                    bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="status"
                        id="Quarantine" value="quarantine">
                    <label class="form-check-label inline-block text-gray-800" for="Quarantine">Quarantine</label>
                </div>
            </div>

            <!-- Vaccinated -->
            <div class="mt-4">
                <x-label for="vaccinated">Are you vaccinated?</x-label>

                <div class="form-check form-check-inline">
                    <input class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 
                    bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top 
                    bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="vaccinated"
                        id="yes" value="yes">
                    <label class="form-check-label inline-block text-gray-800" for="yes">Yes</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 
                    bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top 
                    bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="vaccinated"
                        id="no" value="no">
                    <label class="form-check-label inline-block text-gray-800" for="no">No</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 
                    bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top 
                    bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="vaccinated"
                        id="NA" value="NA">
                    <label class="form-check-label inline-block text-gray-800 opacity-50" for="NA">N/A</label>
                </div>
            </div>

            <!-- Hidden field for user role -->
            <input type="hidden" id="role_id" name="role_id" value="user">


            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>