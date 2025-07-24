<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dictionary Entries') }}
            </h2>
            <a href="{{ route('wordindex.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150">
                {{ __('Add New Entry') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Advanced Search Form -->
                    <div class="mb-8 border border-blue-200 rounded-lg overflow-hidden shadow-lg">
                        <!-- Search Header -->
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-4 text-white">
                            <h3 class="text-xl font-bold">{{ __('འཚོལ་ཞིབ་མཐུན་རྐྱེན།') }} <span class="text-sm ml-2">(Advanced Search)</span></h3>
                        </div>
                        
                        <form action="{{ route('wordindex.index') }}" method="GET" class="bg-white">
                            <div class="p-6">
                                <!-- Search Fields Container -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <!-- Word Search -->
                                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 shadow-sm">
                                        <h4 class="text-lg font-bold mb-3 text-blue-800">{{ __('ཚིག་འཚོལ།') }} <span class="text-sm font-normal text-gray-600">(Word Search)</span></h4>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Search Term') }}</label>
                                                <input type="text" name="word_search" value="{{ isset($searchParams) ? $searchParams['word_search'] : '' }}" 
                                                    placeholder="ཚིག་འདི་འཚོལ..." 
                                                    class="border-blue-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm py-3 px-4 w-full text-lg">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Search Pattern') }}</label>
                                                <div class="flex space-x-4">
                                                    <label class="inline-flex items-center">
                                                        <input type="radio" name="word_search_type" value="contains" {{ !isset($searchParams) || $searchParams['word_search_type'] == 'contains' ? 'checked' : '' }} class="form-radio h-5 w-5 text-blue-600">
                                                        <span class="ml-2 text-gray-700">{{ __('Contains (%ཀ%)') }}</span>
                                                    </label>
                                                    <label class="inline-flex items-center">
                                                        <input type="radio" name="word_search_type" value="starts_with" {{ isset($searchParams) && $searchParams['word_search_type'] == 'starts_with' ? 'checked' : '' }} class="form-radio h-5 w-5 text-blue-600">
                                                        <span class="ml-2 text-gray-700">{{ __('Starts with (ཀ%)') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Explanation Search -->
                                    <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-100 shadow-sm">
                                        <h4 class="text-lg font-bold mb-3 text-indigo-800">{{ __('འགྲེལ་བཤད་འཚོལ།') }} <span class="text-sm font-normal text-gray-600">(Explanation Search)</span></h4>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Search Term') }}</label>
                                                <input type="text" name="explanation_search" value="{{ isset($searchParams) ? $searchParams['explanation_search'] : '' }}" 
                                                    placeholder="འགྲེལ་བཤད་འདི་འཚོལ..." 
                                                    class="border-indigo-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-3 px-4 w-full text-lg">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Search Pattern') }}</label>
                                                <div class="flex space-x-4">
                                                    <label class="inline-flex items-center">
                                                        <input type="radio" name="explanation_search_type" value="contains" {{ !isset($searchParams) || $searchParams['explanation_search_type'] == 'contains' ? 'checked' : '' }} class="form-radio h-5 w-5 text-indigo-600">
                                                        <span class="ml-2 text-gray-700">{{ __('Contains (%ཀ%)') }}</span>
                                                    </label>
                                                    <label class="inline-flex items-center">
                                                        <input type="radio" name="explanation_search_type" value="starts_with" {{ isset($searchParams) && $searchParams['explanation_search_type'] == 'starts_with' ? 'checked' : '' }} class="form-radio h-5 w-5 text-indigo-600">
                                                        <span class="ml-2 text-gray-700">{{ __('Starts with (ཀ%)') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Search Button -->
                            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 border-t border-gray-200">
                                <a href="{{ route('wordindex.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition ease-in-out duration-150">
                                    <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    {{ __('གསར་འདོན།') }} <span class="ml-1 text-xs">(Reset)</span>
                                </a>
                                <button type="submit" class="inline-flex items-center px-5 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 border border-transparent rounded-md font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                                    <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    {{ __('འཚོལ།') }} <span class="ml-1 text-xs">(Search)</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Flash Message -->
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Dictionary Entries Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Word</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Explanation</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($entries as $entry)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-base font-medium text-gray-900">{{ $entry->word }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ Str::limit($entry->explanation, 100) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('wordindex.show', ['wordindex' => $entry->wordIndexId]) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                                <a href="{{ route('wordindex.edit', ['wordindex' => $entry->wordIndexId]) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <form action="{{ route('wordindex.destroy', ['wordindex' => $entry->wordIndexId]) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this entry?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No dictionary entries found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $entries->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
