@extends('layouts.app')

@section('title', 'Manage Sizes')

@section('content')
    <div class="space-y-6">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h3 class="text-2xl font-semibold text-gray-900">Sizes</h3>
                <p class="mt-2 text-sm text-gray-700">Manage available sizes and their stock</p>
            </div>
            <button type="button" onclick="openModal('createSizeModal')"
                class="inline-flex items-center gap-x-2 rounded-md bg-purple-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-purple-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-600">
                <svg class="-ml-0.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                Add Size
            </button>
        </div>

        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name</th>
                            <th
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Stock</th>
                            <th
                                class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($sizes as $size)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $size->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $size->stock }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <button
                                            onclick="editSize('{{ $size->id }}', '{{ $size->name }}', '{{ $size->stock }}')"
                                            class="p-2 text-purple-600 hover:text-purple-900 hover:bg-purple-50 rounded-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button onclick="openDeleteModal('{{ $size->id }}', '{{ $size->name }}')"
                                            class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No
                                    sizes found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Modal -->
        <div id="createSizeModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex min-h-screen items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <div
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <form action="{{ route('admin.sizes.store') }}" method="POST">
                        @csrf
                        <div class="bg-white p-6 space-y-6">
                            <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                                <h3 class="text-xl font-semibold text-gray-900">Add New Size</h3>
                            </div>

                            <div class="space-y-5">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                    <input type="text" name="name" id="name" required
                                        class="block w-full h-12 px-4 rounded-lg border-2 border-gray-300 shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Stock</label>
                                    <input type="number" name="stock" id="stock" required min="0"
                                        class="block w-full h-12 px-4 rounded-lg border-2 border-gray-300 shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                            <div class="flex items-center justify-end gap-x-3">
                                <button type="button" onclick="closeModal('createSizeModal')"
                                    class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-gray-900 border-2 border-gray-300 rounded-lg shadow-sm hover:bg-gray-50">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-semibold text-white bg-purple-600 border border-transparent rounded-lg shadow-sm hover:bg-purple-700">
                                    Create
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div id="editSizeModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex min-h-screen items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <div
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="bg-white p-6 space-y-6">
                            <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                                <h3 class="text-xl font-semibold text-gray-900">Edit Size</h3>
                            </div>

                            <div class="space-y-5">
                                <div>
                                    <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                    <input type="text" name="name" id="edit_name" required
                                        class="block w-full h-12 px-4 rounded-lg border-2 border-gray-300 shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="edit_stock"
                                        class="block text-sm font-medium text-gray-700 mb-2">Stock</label>
                                    <input type="number" name="stock" id="edit_stock" required min="0"
                                        class="block w-full h-12 px-4 rounded-lg border-2 border-gray-300 shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                            <div class="flex items-center justify-end gap-x-3">
                                <button type="button" onclick="closeModal('editSizeModal')"
                                    class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-gray-900 border-2 border-gray-300 rounded-lg shadow-sm hover:bg-gray-50">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-semibold text-white bg-purple-600 border border-transparent rounded-lg shadow-sm hover:bg-purple-700">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div id="deleteSizeModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex min-h-screen items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <div
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="bg-white p-6 space-y-6">
                            <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                                <h3 class="text-xl font-semibold text-gray-900">Delete Size</h3>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Are you sure you want to delete this size? This action
                                    cannot be undone.</p>
                                <p class="text-sm text-gray-900 mt-2">Size: <span id="deleteItemName"
                                        class="font-medium"></span></p>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                            <div class="flex items-center justify-end gap-x-3">
                                <button type="button" onclick="closeModal('deleteSizeModal')"
                                    class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-gray-900 border-2 border-gray-300 rounded-lg shadow-sm hover:bg-gray-50">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-semibold text-white bg-red-600 border border-transparent rounded-lg shadow-sm hover:bg-red-700">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div id="successAlert" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div id="errorAlert" class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    @endif

    @push('scripts')
        <script>
            function openModal(modalId) {
                document.getElementById(modalId).classList.remove('hidden');
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
            }

            function editSize(id, name, stock) {
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_stock').value = stock;
                document.getElementById('editForm').action = `/admin/sizes/${id}`;
                openModal('editSizeModal');
            }

            function openDeleteModal(id, name) {
                document.getElementById('deleteItemName').textContent = name;
                document.getElementById('deleteForm').action = `/admin/sizes/${id}`;
                openModal('deleteSizeModal');
            }

            // Auto hide alerts after 3 seconds
            document.addEventListener('DOMContentLoaded', function() {
                const alerts = document.querySelectorAll('#successAlert, #errorAlert');
                alerts.forEach(alert => {
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 3000);
                });
            });
        </script>
    @endpush
@endsection
