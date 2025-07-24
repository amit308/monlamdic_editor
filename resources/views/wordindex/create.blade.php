<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Dictionary Entry') }}
            </h2>
            <a href="{{ route('wordindex.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
                {{ __('Back to List') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="font-medium text-red-600">
                                {{ __('Whoops! Something went wrong.') }}
                            </div>

                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('wordindex.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Word -->
                            <div class="col-span-2">
                                <label for="word" class="block font-medium text-sm text-gray-700">{{ __('Word') }} <span class="text-red-500">*</span></label>
                                <input type="text" name="word" id="word" value="{{ old('word') }}" required
                                       class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            </div>

                            <!-- Explanation -->
                            <div class="col-span-2">
                                <label for="explanation" class="block font-medium text-sm text-gray-700">{{ __('Explanation') }}</label>
                                <textarea name="explanation" id="explanation" rows="6"
                                          class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('explanation') }}</textarea>
                            </div>

                            <!-- Note -->
                            <div class="col-span-2">
                                <label for="note" class="block font-medium text-sm text-gray-700">{{ __('Note') }}</label>
                                <textarea name="note" id="note" rows="3"
                                          class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('note') }}</textarea>
                            </div>

                            <!-- Key Word -->
                            <div>
                                <label for="Key_Word" class="block font-medium text-sm text-gray-700">{{ __('Key Word') }}</label>
                                <input type="text" name="Key_Word" id="Key_Word" value="{{ old('Key_Word') }}"
                                       class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            </div>

                            <!-- Origin -->
                            <div>
                                <label for="origin" class="block font-medium text-sm text-gray-700">{{ __('Origin') }}</label>
                                <input type="text" name="origin" id="origin" value="{{ old('origin') }}"
                                       class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            </div>

                            <!-- Grammar Section -->
                            <div class="col-span-2">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Grammar') }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <!-- Grammar Noun Checkbox-->
                                    <div>
                                        <label for="grammar_Noun" class="block font-medium text-sm text-gray-700 mb-2">{{ __('Noun') }}</label>
                                        <input type="checkbox" name="grammar_Noun" id="grammar_Noun" value="1" {{ old('grammar_Noun') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>

                                    <!-- Grammar Verb Checkbox -->
                                    <div>
                                        <label for="grammar_Verb" class="block font-medium text-sm text-gray-700 mb-2">{{ __('Verb') }}</label>
                                        <input type="checkbox" name="grammar_Verb" id="grammar_Verb" value="1" {{ old('grammar_Verb') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>

                                    <!-- Grammar Adjective Checkbox -->
                                    <div>
                                        <label for="grammar_Adjective" class="block font-medium text-sm text-gray-700 mb-2">{{ __('Adjective') }}</label>
                                        <input type="checkbox" name="grammar_Adjective" id="grammar_Adjective" value="1" {{ old('grammar_Adjective') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>

                                    <!-- Grammar Adverb Checkbox -->
                                    <div>
                                        <label for="grammar_Adverb" class="block font-medium text-sm text-gray-700 mb-2">{{ __('Adverb') }}</label>
                                        <input type="checkbox" name="grammar_Adverb" id="grammar_Adverb" value="1" {{ old('grammar_Adverb') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>

                                    <!-- Grammar Linking Verb Checkbox -->
                                    <div>
                                        <label for="grammar_LinkingVerb" class="block font-medium text-sm text-gray-700 mb-2">{{ __('Linking Verb') }}</label>
                                        <input type="checkbox" name="grammar_LinkingVerb" id="grammar_LinkingVerb" value="1" {{ old('grammar_LinkingVerb') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>

                                    <!-- Grammar Pronoun Checkbox -->
                                    <div>
                                        <label for="grammar_Pronoun" class="block font-medium text-sm text-gray-700 mb-2">{{ __('Pronoun') }}</label>
                                        <input type="checkbox" name="grammar_Pronoun" id="grammar_Pronoun" value="1" {{ old('grammar_Pronoun') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>

                                    <!-- Grammar Particle Checkbox -->
                                    <div>
                                        <label for="grammar_Particle" class="block font-medium text-sm text-gray-700 mb-2">{{ __('Particle') }}</label>
                                        <input type="checkbox" name="grammar_Particle" id="grammar_Particle" value="1" {{ old('grammar_Particle') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>

                                    <!-- Grammar Interjection Checkbox -->
                                    <div>
                                        <label for="grammar_Interjection" class="block font-medium text-sm text-gray-700 mb-2">{{ __('Interjection') }}</label>
                                        <input type="checkbox" name="grammar_Interjection" id="grammar_Interjection" value="1" {{ old('grammar_Interjection') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>

                                    <!-- Grammar Similarity Checkbox -->
                                    <div>
                                        <label for="grammar__similarity" class="block font-medium text-sm text-gray-700 mb-2">{{ __('Similarity') }}</label>
                                        <input type="checkbox" name="grammar__similarity" id="grammar__similarity" value="1" {{ old('grammar__similarity') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>

                                    <!-- Grammar Synonymy Checkbox -->
                                    <div>
                                        <label for="grammar_synonymy" class="block font-medium text-sm text-gray-700 mb-2">{{ __('Synonymy') }}</label>
                                        <input type="checkbox" name="grammar_synonymy" id="grammar_synonymy" value="1" {{ old('grammar_synonymy') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>

                                    <!-- Grammar Numeral Checkbox -->
                                    <div>
                                        <label for="grammar_numeral" class="block font-medium text-sm text-gray-700 mb-2">{{ __('Numeral') }}</label>
                                        <input type="checkbox" name="grammar_numeral" id="grammar_numeral" value="1" {{ old('grammar_numeral') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>

                                    <!-- Grammar Quantifier Checkbox -->
                                    <div>
                                        <label for="grammar_quantifier" class="block font-medium text-sm text-gray-700 mb-2">{{ __('Quantifier') }}</label>
                                        <input type="checkbox" name="grammar_quantifier" id="grammar_quantifier" value="1" {{ old('grammar_quantifier') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>
                                </div>

                                <!-- Additional Grammar Fields -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    <!-- Noun Type -->
                                    <div>
                                        <label for="Noun_Tayp" class="block font-medium text-sm text-gray-700">{{ __('Noun Type') }}</label>
                                        <input type="text" name="Noun_Tayp" id="Noun_Tayp" value="{{ old('Noun_Tayp') }}"
                                               class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    </div>
                                </div>

                                <!-- Status Fields -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                    <!-- Archaic Checkbox -->
                                    <div>
                                        <label for="archaic" class="block font-medium text-sm text-gray-700 mb-2">{{ __('Archaic') }}</label>
                                        <input type="checkbox" name="archaic" id="archaic" value="1" {{ old('archaic') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>

                                    <!-- Pending Checkbox -->
                                    <div>
                                        <label for="pending" class="block font-medium text-sm text-gray-700 mb-2">{{ __('Pending') }}</label>
                                        <input type="checkbox" name="pending" id="pending" value="1" {{ old('pending') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>

                                    <!-- New Word Checkbox -->
                                    <div>
                                        <label for="newword" class="block font-medium text-sm text-gray-700 mb-2">{{ __('New Word') }}</label>
                                        <input type="checkbox" name="newword" id="newword" value="1" {{ old('newword') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>
                                </div>
                            </div>

                            <!-- Phonetics Section -->
                            <div class="col-span-2">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Phonetics') }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- International Phonetic -->
                                    <div>
                                        <label for="internationalPhonetic" class="block font-medium text-sm text-gray-700">{{ __('International Phonetic') }}</label>
                                        <input type="text" name="internationalPhonetic" id="internationalPhonetic" value="{{ old('internationalPhonetic') }}"
                                               class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    </div>

                                    <!-- Phonetic Amdo -->
                                    <div>
                                        <label for="Phonetic_amdo" class="block font-medium text-sm text-gray-700">{{ __('Amdo') }}</label>
                                        <input type="text" name="Phonetic_amdo" id="Phonetic_amdo" value="{{ old('Phonetic_amdo') }}"
                                               class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    </div>

                                    <!-- Phonetic Lhasa -->
                                    <div>
                                        <label for="Phonetic_lhasa" class="block font-medium text-sm text-gray-700">{{ __('Lhasa') }}</label>
                                        <input type="text" name="Phonetic_lhasa" id="Phonetic_lhasa" value="{{ old('Phonetic_lhasa') }}"
                                               class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    </div>

                                    <!-- Phonetic Kham -->
                                    <div>
                                        <label for="Phonetic_kham" class="block font-medium text-sm text-gray-700">{{ __('Kham') }}</label>
                                        <input type="text" name="Phonetic_kham" id="Phonetic_kham" value="{{ old('Phonetic_kham') }}"
                                               class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    </div>
                                </div>
                            </div>

                            <!-- Terminology Section -->
                            <div class="col-span-2 mt-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Terminology & Domain') }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Domain -->
                                    <div>
                                        <label for="domain" class="block font-medium text-sm text-gray-700">{{ __('Domain') }}</label>
                                        <input type="text" name="domain" id="domain" value="{{ old('domain') }}"
                                               class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    </div>

                                    <!-- Subject -->
                                    <div>
                                        <label for="subject" class="block font-medium text-sm text-gray-700">{{ __('Subject') }}</label>
                                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                                               class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    </div>

                                    <!-- Term Type -->
                                    <div>
                                        <label for="termType" class="block font-medium text-sm text-gray-700">{{ __('Term Type') }}</label>
                                        <input type="text" name="termType" id="termType" value="{{ old('termType') }}"
                                               class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    </div>
                                </div>
                            </div>

                            <!-- Status and Metadata Section -->
                            <div class="col-span-2 mt-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Status & Metadata') }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Status -->
                                    <div>
                                        <label for="status" class="block font-medium text-sm text-gray-700">{{ __('Status') }}</label>
                                        <select name="status" id="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                            <option value="" {{ old('status') == '' ? 'selected' : '' }}>{{ __('None') }}</option>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                            <option value="review" {{ old('status') == 'review' ? 'selected' : '' }}>{{ __('Review') }}</option>
                                        </select>
                                    </div>

                                    <!-- Author -->
                                    <div>
                                        <label for="author" class="block font-medium text-sm text-gray-700">{{ __('Author') }}</label>
                                        <input type="text" name="author" id="author" value="{{ old('author') }}"
                                               class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    </div>

                                    <!-- Source -->
                                    <div>
                                        <label for="source" class="block font-medium text-sm text-gray-700">{{ __('Source') }}</label>
                                        <input type="text" name="source" id="source" value="{{ old('source') }}"
                                               class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    </div>
                                </div>
                            </div>

                            <!-- Editor Information -->
                            <div class="col-span-2">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Editorial Information') }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Editor -->
                                    <div>
                                        <label for="editor" class="block font-medium text-sm text-gray-700">{{ __('Editor') }}</label>
                                        <input type="text" name="editor" id="editor" value="{{ old('editor') }}"
                                               class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    </div>

                                    <!-- Editor Group -->
                                    <div>
                                        <label for="editor_group" class="block font-medium text-sm text-gray-700">{{ __('Editor Group') }}</label>
                                        <input type="text" name="editor_group" id="editor_group" value="{{ old('editor_group') }}"
                                               class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons with dual language support -->
                            <div class="flex flex-col items-center justify-center col-span-2 mt-8 space-y-6">


                                <!-- Secondary Tibetan Button -->
                                <div class="text-center w-full md:w-2/3">
                                    <button type="submit" class="bg-gradient-to-r from-amber-400 to-amber-500 text-gray-900 rounded-lg py-5 px-12 hover:from-amber-500 hover:to-amber-600 focus:outline-none focus:ring-4 focus:ring-amber-300 transition-colors duration-150 text-3xl shadow-md border border-amber-600 w-full">
                                        <span class="font-bold tracking-wide">གསར་བཟོ་བྱེད།</span>
                                    </button>
                                    <p class="text-sm text-gray-600 mt-3">༼ Create Entry ནོན་ནས་ཐོ་གསར་པ་བཟོ། ༽</p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
