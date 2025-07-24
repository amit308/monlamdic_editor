<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('View Dictionary Entry') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('wordindex.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
                    {{ __('Back to List') }}
                </a>
                <a href="{{ route('wordindex.edit', ['wordindex' => $wordindex->wordIndexId]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo transition ease-in-out duration-150">
                    {{ __('Edit') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $wordindex->word }}</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-lg font-semibold mb-2">{{ __('Explanation') }}</h4>
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    {!! nl2br(e($wordindex->explanation)) !!}
                                </div>
                            </div>

                            <div>
                                <h4 class="text-lg font-semibold mb-2">{{ __('Note') }}</h4>
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    {!! nl2br(e($wordindex->note ?? 'N/A')) !!}
                                </div>
                            </div>

                            <div>
                                <h4 class="text-lg font-semibold mb-2">{{ __('Key Word') }}</h4>
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    {{ $wordindex->Key_Word ?? 'N/A' }}
                                </div>
                            </div>

                            <div>
                                <h4 class="text-lg font-semibold mb-2">{{ __('Origin') }}</h4>
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    {{ $wordindex->origin ?? 'N/A' }}
                                </div>
                            </div>
                        </div>

                        <h3 class="text-xl font-semibold mt-4 mb-2">{{ __('Grammar Information') }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach(['grammar_Noun', 'grammar_Verb', 'grammar_Adjective', 'grammar_Adverb', 
                                     'grammar_LinkingVerb', 'grammar_Pronoun', 'grammar_Particle', 
                                     'grammar_Interjection', 'grammar__similarity', 'grammar_synonymy', 
                                     'grammar_numeral', 'grammar_quantifier'] as $field)
                                @php
                                    $fieldName = str_replace('grammar_', '', $field);
                                    $fieldName = str_replace('_', ' ', $fieldName);
                                    $fieldName = ucfirst($fieldName);
                                @endphp
                                @if(!empty($wordindex->$field))
                                    <div class="p-2 bg-gray-50 rounded">
                                        <span class="font-medium">{{ $fieldName }}:</span> {{ $wordindex->$field }}
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <h3 class="text-xl font-semibold mt-4 mb-2">{{ __('Phonetics') }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <span class="font-medium">International:</span> 
                                {{ $wordindex->internationalPhonetic ?? 'N/A' }}
                            </div>
                            <div>
                                <span class="font-medium">Amdo:</span> 
                                {{ $wordindex->Phonetic_amdo ?? 'N/A' }}
                            </div>
                            <div>
                                <span class="font-medium">Lhasa:</span> 
                                {{ $wordindex->Phonetic_lhasa ?? 'N/A' }}
                            </div>
                            <div>
                                <span class="font-medium">Kham:</span> 
                                {{ $wordindex->Phonetic_kham ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="text-sm text-gray-500">
                                <p>{{ __('Editor') }}: {{ $wordindex->editor ?? 'N/A' }}</p>
                                <p>{{ __('Editor Group') }}: {{ $wordindex->editor_group ?? 'N/A' }}</p>
                                <p>{{ __('Date') }}: {{ $wordindex->dateTime ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
