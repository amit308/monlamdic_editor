<x-app-layout>
    <div class="bg-gradient-to-br from-blue-600 to-indigo-800 py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div>
                <form action="{{ route('dictionary.search') }}" method="GET" class="space-y-4">
                    <div class="flex flex-col md:flex-row shadow-lg rounded-lg overflow-hidden">
                        <div class="flex-grow">
                            <input type="text"
                                name="search_term"
                                value="{{ $searchTerm }}"
                                placeholder="{{ __('མིང་ཚིགའཚོལ་ཞིབ་ཀྱི་ཐ་སྙད་འབྲི་རོགས། / Enter search term') }}"
                                class="w-full px-4 py-3 text-base border-none focus:ring-0 focus:outline-none"
                                autofocus>
                        </div>
                        <button type="submit" class="flex-none bg-blue-900 hover:bg-blue-800 text-white px-6 py-3 transition-colors duration-150">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                {{ __('འཚོལ་བ། / Search') }}
                            </span>
                        </button>
                    </div>

                    <div class="hidden md:flex items-center space-x-6 text-white text-sm">
                        <!-- Search Type -->
                        <div class="flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="search_type" value="contains" {{ $searchType == 'contains' ? 'checked' : '' }} class="h-4 w-4 text-blue-600">
                                <span class="ml-2">{{ __('བརྗོད་ཚིག་ཚང་མའི་ནང་ཡོད་པ། / Contains') }}</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="search_type" value="startsWith" {{ $searchType == 'startsWith' ? 'checked' : '' }} class="h-4 w-4 text-blue-600">
                                <span class="ml-2">{{ __('འདི་ནས་འགོ་རྩོམ་པ། / Starts with') }}</span>
                            </label>
                        </div>

                        <!-- Search Field -->
                        <div class="flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="search_field" value="word" {{ $searchField == 'word' ? 'checked' : '' }} class="h-4 w-4 text-blue-600">
                                <span class="ml-2">{{ __('མིང་ཚིག / Word') }}</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="search_field" value="explanation" {{ $searchField == 'explanation' ? 'checked' : '' }} class="h-4 w-4 text-blue-600">
                                <span class="ml-2">{{ __('འགྲེལ་བཤད། / Explanation') }}</span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="py-6 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search Results -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">
                        @if($searchTerm)
                            {{ __('འཚོལ་འབྲས་ / Search Results:') }} "{{ $searchTerm }}"
                        @else
                            {{ __('ཚིག་མཛོད་མིང་ཚིག / Dictionary Entries') }}
                        @endif
                        <span class="text-gray-500 font-normal">({{ $results->total() }} {{ __('entries') }})</span>
                    </h2>
                </div>

                @if($results->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($results as $word)
                            <div class="p-6 hover:bg-gray-50">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $word->word }}</h3>
                                        <p class="text-gray-600">{{ Str::limit($word->explanation, 200) }}</p>

                                        <!-- Word Meta Information -->
                                        <div class="mt-3 flex flex-wrap items-center gap-3 text-sm text-gray-500">
                                            @if($word->grammar_Noun == 1)
                                                <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-800 text-xs">{{ __('མིང་ཚིག / Noun') }}</span>
                                            @endif

                                            @if($word->grammar_Verb == 1)
                                                <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs">{{ __('བྱ་ཚིག / Verb') }}</span>
                                            @endif

                                            @if($word->grammar_Adjective == 1)
                                                <span class="px-2 py-1 rounded-full bg-purple-100 text-purple-800 text-xs">{{ __('ཁྱད་ཚིག / Adjective') }}</span>
                                            @endif

                                            @if($word->newword == 1)
                                                <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs">{{ __('གསར་པ། / New') }}</span>
                                            @endif

                                            @if($word->archaic == 1)
                                                <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-800 text-xs">{{ __('གནའ་དུས། / Archaic') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="ml-4 flex-shrink-0">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('wordindex.show', $word->wordIndexId) }}" class="px-3 py-1 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-md text-sm transition-colors duration-150">
                                                {{ __('ལྟ་བ། / View') }}
                                            </a>
                                            @auth
                                                <a href="{{ route('wordindex.edit', $word->wordIndexId) }}" class="px-3 py-1 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-md text-sm transition-colors duration-150">
                                                    {{ __('བཟོ་བཅོས། / Edit') }}
                                                </a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        {{ $results->links() }}
                    </div>
                @else
                    <div class="p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">{{ __('མིང་ཚིགརྙེད་མ་སོང་།') }}</h3>
                        <p class="mt-1 text-gray-500">{{ __('No matching dictionary entries found.') }}</p>
                        <div class="mt-6">
                            <a href="{{ route('dictionary.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                                {{ __('འཚོལ་ཞིབ་ཤོག་ངོས་ལ་ཕྱིར་ལོག་བྱེད། / Back to Search') }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
