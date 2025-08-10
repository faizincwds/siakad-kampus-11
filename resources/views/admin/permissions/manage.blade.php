<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Manajemen Permission untuk Role</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white p-6 shadow-md rounded">
            <form method="POST" action="{{ route('admin.permissions.manage.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="role" class="block font-semibold">Pilih Role:</label>
                    <select name="role_id" id="role" class="mt-1 w-full border-gray-300 rounded">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $role->id == $selectedRole->id ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block font-semibold mb-2">Daftar Permission:</label>

                    <div id="permissions-container" class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-4 gap-4">
                        @foreach ($permissions as $category => $permGroup)
                            <div class="bg-gray-50 p-4 rounded shadow-sm">
                                <h3 class="font-bold mb-2 capitalize text-indigo-700 border-b pb-1">
                                    {{ ucfirst($category) }}
                                </h3>
                                <div class="space-y-2">
                                    @foreach ($permGroup as $permission)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="permissions[]"
                                                value="{{ $permission->id }}"
                                                class="perm-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                {{ in_array($permission->id, $selectedRole->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-700"> {{ $permission->name }} </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <x-primary-button>Simpan</x-primary-button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('role').addEventListener('change', function () {
            let roleId = this.value;
            fetch(`{{ route('admin.permissions.manage') }}?role_id=${roleId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.permissions) {
                    document.querySelectorAll('.perm-checkbox').forEach(cb => {
                        cb.checked = data.permissions.includes(cb.value);
                    });
                }
            })
            .catch(error => {
                alert('Gagal mengambil permission.');
                console.error(error);
            });
        });
    </script>
</x-app-layout>
