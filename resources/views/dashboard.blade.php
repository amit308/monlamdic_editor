<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('སྨོན་ལམ་ཚིག་མཛོད་མཐོང་སྟེགས་') }} <span class="font-normal">{{ __('Monlam Dictionary Dashboard') }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Dictionary Statistics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">{{ __('ཚིག་མཛོད་གནས་ཚུལ་') }} <span class="font-normal text-lg">{{ __('Dictionary Statistics') }}</span></h3>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-4">
                        <!-- Total Words -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-lg border border-blue-200 shadow-sm">
                            <h4 class="text-sm font-medium text-blue-700">{{ __('ཚིག་གྲངས་ཡོངས་བསྡོམས་') }}</h4>
                            <h4 class="text-sm font-medium text-blue-500 mb-2">{{ __('Total Words') }}</h4>
                            <p class="text-3xl font-bold text-blue-800">{{ $stats['total_words'] }}</p>
                        </div>

                        <!-- New Words -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-lg border border-green-200 shadow-sm">
                            <h4 class="text-sm font-medium text-green-700">{{ __('མིང་ཚིགགསར་པ་') }}</h4>
                            <h4 class="text-sm font-medium text-green-500 mb-2">{{ __('New Words') }}</h4>
                            <p class="text-3xl font-bold text-green-800">{{ $stats['new_words'] }}</p>
                        </div>

                        <!-- Pending Words -->
                        <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-4 rounded-lg border border-amber-200 shadow-sm">
                            <h4 class="text-sm font-medium text-amber-700">{{ __('བསྒུག་ནས་ཡོད་པའི་མིང་ཚིག') }}</h4>
                            <h4 class="text-sm font-medium text-amber-500 mb-2">{{ __('Pending Words') }}</h4>
                            <p class="text-3xl font-bold text-amber-800">{{ $stats['pending_words'] }}</p>
                        </div>

                        <!-- Archaic Words -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 rounded-lg border border-purple-200 shadow-sm">
                            <h4 class="text-sm font-medium text-purple-700">{{ __('གནའ་དུས་མིང་ཚིག') }}</h4>
                            <h4 class="text-sm font-medium text-purple-500 mb-2">{{ __('Archaic Words') }}</h4>
                            <p class="text-3xl font-bold text-purple-800">{{ $stats['archaic_words'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Latest Entries -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center border-b pb-2 mb-4">
                        <h3 class="text-xl font-bold text-gray-800">{{ __('ཉེ་ལམ་བཅུག་པའི་མིང་ཚིག') }} <span class="font-normal text-lg">{{ __('Latest Entries') }}</span></h3>
                        <a href="{{ route('wordindex.index') }}" class="text-blue-600 hover:text-blue-800 transition-colors duration-150 text-sm">{{ __('View All') }} →</a>
                    </div>

                    @if(count($latestWords) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Word') }}</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Explanation') }}</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('གནས་སྟངས་ / Status') }}</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('བཟོ་བཅོས་པ་ / Editor') }}</th>
                                        <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($latestWords as $word)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $word->word }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ Str::limit($word->explanation, 100) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if(isset($word->is_new) && $word->is_new)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        {{ __('གསར་འཇུག་ / New') }}
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        {{ __('བཟོ་བཅོས་ / Edited') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if(!empty($word->creator_name))
                                                    {{ $word->is_new ? $word->creator_name : $word->modifier_name }}
                                                @elseif(!empty($word->editor))
                                                    {{ $word->editor }}
                                                @else
                                                    <span class="text-gray-400">{{ __('མི་ཤེས་པ་ / Unknown') }}</span>
                                                @endif

                                                @if(!empty($word->dateTime))
                                                    <div class="text-xs text-gray-400 mt-1">
                                                        {{ date('Y-m-d', strtotime($word->dateTime)) }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('wordindex.show', $word->wordIndexId) }}" class="text-blue-600 hover:text-blue-900 mr-3">{{ __('View') }}</a>
                                                <a href="{{ route('wordindex.edit', $word->wordIndexId) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-gray-500">
                            {{ __('No dictionary entries found') }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">{{ __('མགྱོགས་མྱུར་འབྲེལ་ཐག་') }} <span class="font-normal text-lg">{{ __('Quick Links') }}</span></h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                        <!-- Create New Entry -->
                        <a href="{{ route('wordindex.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg border border-green-200 shadow-sm hover:bg-green-100 transition-colors duration-150">
                            <div class="bg-green-500 text-white p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-green-700">{{ __('མིང་ཚིགགསར་བཟོ་') }}</h4>
                                <p class="text-sm text-gray-600">{{ __('Create New Entry') }}</p>
                            </div>
                        </a>

                        <!-- Browse Dictionary -->
                        <a href="{{ route('wordindex.index') }}" class="flex items-center p-4 bg-blue-50 rounded-lg border border-blue-200 shadow-sm hover:bg-blue-100 transition-colors duration-150">
                            <div class="bg-blue-500 text-white p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-blue-700">{{ __('ཚིག་མཛོད་བཤེར་འཚོལ་') }}</h4>
                                <p class="text-sm text-gray-600">{{ __('Browse Dictionary') }}</p>
                            </div>
                        </a>

                        <!-- Search Words -->
                        <a href="{{ route('search') }}" class="flex items-center p-4 bg-purple-50 rounded-lg border border-purple-200 shadow-sm hover:bg-purple-100 transition-colors duration-150">
                            <div class="bg-purple-500 text-white p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-purple-700">{{ __('མིང་ཚིགའཚོལ་བཤེར་') }}</h4>
                                <p class="text-sm text-gray-600">{{ __('Search Words') }}</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
