<x-layouts.default>
    <div class="mx-auto container h-screen p-12">
        <div class="flex justify-center py-18">
            <x-card>
                <x-slot name="title">
                    Register
                </x-slot>
                <x-slot name="content">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-control">
                            <label for="username" class="label">Username</label>
                            <input type="username" id="username" name="username" placeholder="Username" class="input input-bordered"
                                value="{{ old('username') }}" required>
                            <x-alert.input-error :field="'username'" />
                        </div>

                        <div class="form-control">
                            <label for="email" class="label">Email</label>
                            <input type="email" id="email" name="email" placeholder="Email Address" class="input input-bordered"
                                value="{{ old('email') }}" required>
                            <x-alert.input-error :field="'email'" />
                        </div>

                        <div class="form-control">
                            <label for="password" class="label">Password</label>
                            <input type="password" id="password" name="password" placeholder="Password" class="input input-bordered"
                                required>
                            <x-alert.input-error :field="'password'" />
                        </div>

                        <div class="form-control">
                            <label for="password_confirmation" class="label">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                placeholder="Password Confirmation" class="input input-bordered" required>
                        </div>

                        <div class="form-control">
                            <label for="phone_number" class="label">Phone Number</label>
                            <input type="text" id="phone_number" name="phone_number" placeholder="Phone Number" class="input input-bordered"
                                value="{{ old('phone_number') }}">
                        </div>

                        <div class="form-control">
                            <label for="address" class="label">Address</label>
                            <input type="text" id="address" name="address" placeholder="Address" class="input input-bordered"
                                value="{{ old('address') }}">
                        </div>

                        <div class="form-control mt-6">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </x-slot>
            </x-card>
        </div>
    </div>
</x-layouts.default>
