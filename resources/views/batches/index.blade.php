<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lead Batches Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header class="mb-6">
                    <h2 class="text-lg font-medium text-gray-900">Upload New Leads</h2>
                    <p class="mt-1 text-sm text-gray-600">Ensure your file has exactly these column headers: <strong class="text-red-500">name, phone, email</strong>.</p>
                </header>
                
                @if (session('status'))
                    <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('batches.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-xl">
                    @csrf
                    
                    <div>
                        <x-input-label for="user_id" :value="__('Assign To')" />
                        <select name="user_id" id="user_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                            @foreach($callers as $caller)
                                <option value="{{ $caller->id }}">{{ $caller->name }} @if($caller->id === auth()->id()) (You) @endif</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="file" :value="__('Spreadsheet File (.csv or .xlsx)')" />
                        <input type="file" name="file" id="file" accept=".csv, .xlsx" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none p-2" required>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Upload Leads') }}</x-primary-button>
                    </div>
                </form>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header class="mb-6">
                    <h2 class="text-lg font-medium text-gray-900">Your Lead Batches</h2>
                </header>
                
                @if($batches->isEmpty())
                    <p class="text-gray-500 text-sm">No batches uploaded yet.</p>
                @else
                    <div class="overflow-hidden rounded-lg border border-gray-200">
                        <ul class="divide-y divide-gray-200 bg-white">
                            @foreach ($batches as $batch)
                                <li class="p-4 hover:bg-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                    <div>
                                        <p class="text-base font-bold text-indigo-600">{{ $batch->name }}</p>
                                        <div class="text-sm text-gray-500 mt-1 flex flex-col sm:flex-row sm:gap-4">
                                            <span><strong>Assigned:</strong> {{ $batch->user->name }}</span>
                                            <span class="hidden sm:inline">|</span>
                                            <span><strong>Uploaded by:</strong> {{ $batch->uploader->name }}</span>
                                            <span class="hidden sm:inline">|</span>
                                            <span>{{ $batch->created_at->format('M j, Y') }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('batches.show', $batch) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 w-full sm:w-auto text-center justify-center">
                                        Open Batch
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>