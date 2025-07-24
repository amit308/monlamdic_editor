<x-app-layout>
    <div class="relative bg-gradient-to-br from-blue-600 to-indigo-800 py-16 md:py-24">
        <div class="absolute inset-0 bg-pattern opacity-10"></div>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white tracking-tight">
                    {{ __('སྨོན་ལམ་ཚིག་མཛོད་ཆེན་མོ།') }}
                </h1>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-blue-100 sm:mt-4">
                    {{ __('Monlam Dictionary Search') }}
                </p>

                <div class="mt-10 max-w-3xl mx-auto">
                    <form action="{{ route('dictionary.search') }}" method="GET" class="space-y-4">
                        <div class="flex flex-col md:flex-row shadow-lg rounded-lg overflow-hidden">
                            <div class="flex-grow">
                                <input type="text"
                                    name="search_term"
                                    placeholder="{{ __('མིང་ཚིགའཚོལ་ཞིབ་ཀྱི་ཐ་སྙད་འབྲི་རོགས། / Enter search term') }}"
                                    class="w-full px-5 py-4 text-lg border-none focus:ring-0 focus:outline-none"
                                    autofocus>
                            </div>
                            <button type="submit" class="flex-none bg-blue-900 hover:bg-blue-800 text-white px-6 py-4 transition-colors duration-150">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    {{ __('འཚོལ་བ། / Search') }}
                                </span>
                            </button>
                        </div>

                        <div class="flex flex-col md:flex-row md:items-center text-white space-y-4 md:space-y-0 md:space-x-6 mt-4">
                            <!-- Search Type -->
                            <div>
                                <label class="flex items-center">
                                    <input type="radio" name="search_type" value="contains" checked class="h-4 w-4 text-blue-600">
                                    <span class="ml-2">{{ __('བརྗོད་ཚིག་ཚང་མའི་ནང་ཡོད་པ། / Contains') }}</span>
                                </label>
                                <label class="flex items-center mt-2">
                                    <input type="radio" name="search_type" value="startsWith" class="h-4 w-4 text-blue-600">
                                    <span class="ml-2">{{ __('འདི་ནས་འགོ་རྩོམ་པ། / Starts with') }}</span>
                                </label>
                            </div>

                            <!-- Search Field -->
                            <div>
                                <label class="flex items-center">
                                    <input type="radio" name="search_field" value="word" checked class="h-4 w-4 text-blue-600">
                                    <span class="ml-2">{{ __('མིང་ཚིག / Word') }}</span>
                                </label>
                                <label class="flex items-center mt-2">
                                    <input type="radio" name="search_field" value="explanation" class="h-4 w-4 text-blue-600">
                                    <span class="ml-2">{{ __('འགྲེལ་བཤད། / Explanation') }}</span>
                                </label>
                            </div>

                            <!-- Advanced Filters Toggle -->
                            <div class="ml-auto md:ml-0">
                                <button type="button" id="advancedToggle" class="flex items-center text-blue-200 hover:text-white transition-colors duration-150">
                                    <span>{{ __('མཐོ་རིམ་འཚོལ་ཞིབ། / Advanced Search') }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Advanced Search Options (Hidden by default) -->
                        <div id="advancedOptions" class="hidden bg-white bg-opacity-10 p-4 rounded-lg text-white">
                            <h4 class="font-medium mb-3">{{ __('བརྡ་སྤྲོད་དབྱེ་བ། / Grammar Categories') }}</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <label class="flex items-center">
                                    <input type="checkbox" name="filters[grammar][]" value="Noun" class="h-4 w-4 text-blue-600">
                                    <span class="ml-2">{{ __('མིང་ཚིག / Noun') }}</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="filters[grammar][]" value="Verb" class="h-4 w-4 text-blue-600">
                                    <span class="ml-2">{{ __('བྱ་ཚིག / Verb') }}</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="filters[grammar][]" value="Adjective" class="h-4 w-4 text-blue-600">
                                    <span class="ml-2">{{ __('ཁྱད་ཚིག / Adjective') }}</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="filters[grammar][]" value="Adverb" class="h-4 w-4 text-blue-600">
                                    <span class="ml-2">{{ __('བྱེད་ཚིག / Adverb') }}</span>
                                </label>
                            </div>

                            <div class="mt-4">
                                <h4 class="font-medium mb-3">{{ __('གནས་སྟངས། / Status') }}</h4>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="filters[newword]" value="1" class="h-4 w-4 text-blue-600">
                                        <span class="ml-2">{{ __('མིང་ཚིགགསར་པ། / New Words') }}</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="filters[archaic]" value="1" class="h-4 w-4 text-blue-600">
                                        <span class="ml-2">{{ __('གནའ་དུས་མིང་ཚིག / Archaic Words') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Dictionary Statistics -->
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('ཚིག་མཛོད་གནས་ཚུལ་') }} <span class="font-normal">{{ __('Dictionary Stats') }}</span></h2>

                <div class="flex flex-wrap justify-center gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-md text-center min-w-[200px]">
                        <div class="text-3xl font-bold text-blue-700">{{ number_format($stats['total_words']) }}</div>
                        <div class="text-gray-500 mt-1">{{ __('མིང་ཚིགཡོངས་བསྡོམས་ / Total Words') }}</div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md text-center min-w-[200px]">
                        <div class="text-3xl font-bold text-green-600">{{ number_format($stats['new_words']) }}</div>
                        <div class="text-gray-500 mt-1">{{ __('མིང་ཚིགགསར་པ་ / New Words') }}</div>
                    </div>
                </div>
            </div>

            <!-- Featured Words Section -->
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('དམིགས་བསལ་མིང་ཚིག') }} <span class="font-normal">{{ __('Featured Words') }}</span></h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($featuredWords as $word)
                        <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $word->word }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($word->explanation, 120) }}</p>
                            <a href="{{ route('wordindex.show', $word->wordIndexId) }}" class="text-blue-600 hover:text-blue-800 transition-colors duration-150">
                                {{ __('རྫོགས་པར་ལྟ་བ་ / View Full Entry') }} →
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const advancedToggle = document.getElementById('advancedToggle');
            const advancedOptions = document.getElementById('advancedOptions');

            advancedToggle.addEventListener('click', function() {
                advancedOptions.classList.toggle('hidden');
            });
        });
    </script>
    @endpush
</x-app-layout>
