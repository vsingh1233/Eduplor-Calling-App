<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $batch->name }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-indigo-600 hover:underline">&larr; Back to Dashboard</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-4 px-4 sm:px-0">
                <p class="text-gray-600">Total Leads: <span class="font-bold">{{ $leads->count() }}</span></p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4 sm:px-0">
                @foreach($leads as $lead)
                    <div class="bg-white border rounded-xl p-5 shadow-sm flex flex-col justify-between h-full">
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $lead->name }}</h3>
                            
                            <div class="flex items-center text-gray-600 text-sm mb-1">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                {{ $lead->email }}
                            </div>
                            
                            <div class="flex items-center text-gray-600 text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                               {{ $lead->phone }}
                            </div>
                        </div>
                        
                       <a href="tel:{{ $lead->phone }}" class="w-full inline-flex items-center justify-center px-6 py-4 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-lg transition-colors text-base shadow-md uppercase tracking-wider">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path></svg>
                            Call Now
                        </a>
                    </div>
                @endforeach
            </div>

            @if($leads->isEmpty())
                <div class="bg-white p-8 text-center rounded-lg shadow-sm">
                    <p class="text-gray-500">No leads found in this batch.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>