<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Dictionary Entry') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('wordindex.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
                    {{ __('Back to List') }}
                </a>
                <a href="{{ route('wordindex.show', ['wordindex' => $wordindex->wordIndexId]) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150">
                    {{ __('View Details') }}
                </a>
            </div>
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

                    <form method="POST" action="{{ route('wordindex.update', ['wordindex' => $wordindex->wordIndexId]) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Word -->
                            <div class="col-span-2">
                                <label for="word" class="block font-medium text-sm text-gray-700">{{ __('Word') }} <span class="text-red-500">*</span></label>
                                <input type="text" name="word" id="word" value="{{ old('word', $wordindex->word) }}" required
                                       class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            </div>

                            <!-- Explanation -->
                            <div class="col-span-2">
                                <label for="explanation" class="block font-medium text-sm text-gray-700">{{ __('Explanation') }}</label>
                                <textarea name="explanation" id="explanation" rows="6"
                                          class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('explanation', $wordindex->explanation) }}</textarea>
                            </div>

                            <!-- Note -->
                            <div class="col-span-2">
                                <label for="note" class="block font-medium text-sm text-gray-700">{{ __('Note') }}</label>
                                <textarea name="note" id="note" rows="3"
                                          class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('note', $wordindex->note) }}</textarea>
                            </div>

                            <!-- Key Word -->
                            <div>
                                <label for="Key_Word" class="block font-medium text-sm text-gray-700">{{ __('Key Word') }}</label>
                                <input type="text" name="Key_Word" id="Key_Word" value="{{ old('Key_Word', $wordindex->Key_Word) }}"
                                       class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            </div>

                            <!-- Origin -->
                            <div>
                                <label for="origin" class="block font-medium text-sm text-gray-700">{{ __('Origin') }}</label>
                                <input type="text" name="origin" id="origin" value="{{ old('origin', $wordindex->origin) }}"
                                       class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            </div>

                            <!-- Grammar Section -->
                            <div class="col-span-2">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Grammar') }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <!-- Grammar Checkboxes - First Column -->
                                    <div>
                                        <div class="flex items-center">
                                            <input type="checkbox" name="grammar_Noun" id="grammar_Noun" {{ old('grammar_Noun', $wordindex->grammar_Noun) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <label for="grammar_Noun" class="ml-2 text-sm text-gray-700">{{ __('Noun') }}</label>
                                        </div>
                                        <div class="flex items-center mt-2">
                                            <input type="checkbox" name="grammar_Verb" id="grammar_Verb" {{ old('grammar_Verb', $wordindex->grammar_Verb) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <label for="grammar_Verb" class="ml-2 text-sm text-gray-700">{{ __('Verb') }}</label>
                                        </div>
                                        <div class="flex items-center mt-2">
                                            <input type="checkbox" name="grammar_Adjective" id="grammar_Adjective" {{ old('grammar_Adjective', $wordindex->grammar_Adjective) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <label for="grammar_Adjective" class="ml-2 text-sm text-gray-700">{{ __('Adjective') }}</label>
                                        </div>
                                        <div class="flex items-center mt-2">
                                            <input type="checkbox" name="grammar_Adverb" id="grammar_Adverb" {{ old('grammar_Adverb', $wordindex->grammar_Adverb) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <label for="grammar_Adverb" class="ml-2 text-sm text-gray-700">{{ __('Adverb') }}</label>
                                        </div>
                                    </div>

                                    <!-- Grammar Checkboxes - Second Column -->
                                    <div>
                                        <div class="flex items-center">
                                            <input type="checkbox" name="grammar_LinkingVerb" id="grammar_LinkingVerb" {{ old('grammar_LinkingVerb', $wordindex->grammar_LinkingVerb) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <label for="grammar_LinkingVerb" class="ml-2 text-sm text-gray-700">{{ __('Linking Verb') }}</label>
                                        </div>
                                        <div class="flex items-center mt-2">
                                            <input type="checkbox" name="grammar_Pronoun" id="grammar_Pronoun" {{ old('grammar_Pronoun', $wordindex->grammar_Pronoun) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <label for="grammar_Pronoun" class="ml-2 text-sm text-gray-700">{{ __('Pronoun') }}</label>
                                        </div>
                                        <div class="flex items-center mt-2">
                                            <input type="checkbox" name="grammar_Particle" id="grammar_Particle" {{ old('grammar_Particle', $wordindex->grammar_Particle) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <label for="grammar_Particle" class="ml-2 text-sm text-gray-700">{{ __('Particle') }}</label>
                                        </div>
                                        <div class="flex items-center mt-2">
                                            <input type="checkbox" name="grammar_Interjection" id="grammar_Interjection" {{ old('grammar_Interjection', $wordindex->grammar_Interjection) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <label for="grammar_Interjection" class="ml-2 text-sm text-gray-700">{{ __('Interjection') }}</label>
                                        </div>
                                    </div>

                                    <!-- Additional Grammar - Third Column -->
                                    <div>
                                        <div class="flex items-center">
                                            <input type="checkbox" name="grammar__similarity" id="grammar__similarity" {{ old('grammar__similarity', $wordindex->grammar__similarity) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <label for="grammar__similarity" class="ml-2 text-sm text-gray-700">{{ __('Similarity') }}</label>
                                        </div>
                                        <div class="flex items-center mt-2">
                                            <input type="checkbox" name="grammar_synonymy" id="grammar_synonymy" {{ old('grammar_synonymy', $wordindex->grammar_synonymy) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <label for="grammar_synonymy" class="ml-2 text-sm text-gray-700">{{ __('Synonymy') }}</label>
                                        </div>
                                        <div class="flex items-center mt-2">
                                            <input type="checkbox" name="grammar_numeral" id="grammar_numeral" {{ old('grammar_numeral', $wordindex->grammar_numeral) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <label for="grammar_numeral" class="ml-2 text-sm text-gray-700">{{ __('Numeral') }}</label>
                                        </div>
                                        <div class="flex items-center mt-2">
                                            <input type="checkbox" name="grammar_quantifier" id="grammar_quantifier" {{ old('grammar_quantifier', $wordindex->grammar_quantifier) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <label for="grammar_quantifier" class="ml-2 text-sm text-gray-700">{{ __('Quantifier') }}</label>
                                        </div>
                                    </div>

                                    <!-- Noun Type, Archaic, Pending - Fourth Column -->
                                    <div>
                                        <div>
                                            <label for="Noun_Tayp" class="block font-medium text-sm text-gray-700">{{ __('Noun Type') }}</label>
                                            <input type="text" name="Noun_Tayp" id="Noun_Tayp" value="{{ old('Noun_Tayp', $wordindex->Noun_Tayp) }}"
                                                   class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                        </div>
                                        <div class="flex items-center mt-2">
                                            <input type="checkbox" name="archaic" id="archaic" {{ old('archaic', $wordindex->archaic) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <label for="archaic" class="ml-2 text-sm text-gray-700">{{ __('Archaic') }}</label>
                                        </div>
                                        <div class="flex items-center mt-2">
                                            <input type="checkbox" name="pending" id="pending" {{ old('pending', $wordindex->pending) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <label for="pending" class="ml-2 text-sm text-gray-700">{{ __('Pending') }}</label>
                                        </div>
                                        <div class="flex items-center mt-2">
                                            <input type="checkbox" name="newword" id="newword" {{ old('newword', $wordindex->newword) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <label for="newword" class="ml-2 text-sm text-gray-700">{{ __('New Word') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Phonetics Section -->
                            <div class="col-span-2 mt-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Phonetics') }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- International Phonetic -->
                                    <div>
                                        <label for="internationalPhonetic" class="block font-medium text-sm text-gray-700">{{ __('International Phonetic') }}</label>
                                        <input type="text" name="internationalPhonetic" id="internationalPhonetic" value="{{ old('internationalPhonetic', $wordindex->internationalPhonetic) }}"
                                               class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    </div>

                                    <!-- Phonetic Amdo -->
                                    <div>
                                        <label for="Phonetic_amdo" class="block font-medium text-sm text-gray-700">{{ __('Amdo') }}</label>
                                        <input type="text" name="Phonetic_amdo" id="Phonetic_amdo" value="{{ old('Phonetic_amdo', $wordindex->Phonetic_amdo) }}"
                                               class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    </div>

                                    <!-- Phonetic Lhasa -->
                                    <div>
                                        <label for="Phonetic_lhasa" class="block font-medium text-sm text-gray-700">{{ __('Lhasa') }}</label>
                                        <input type="text" name="Phonetic_lhasa" id="Phonetic_lhasa" value="{{ old('Phonetic_lhasa', $wordindex->Phonetic_lhasa) }}"
                                               class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    </div>

                                    <!-- Phonetic Kham -->
                                    <div>
                                        <label for="Phonetic_kham" class="block font-medium text-sm text-gray-700">{{ __('Kham') }}</label>
                                        <input type="text" name="Phonetic_kham" id="Phonetic_kham" value="{{ old('Phonetic_kham', $wordindex->Phonetic_kham) }}"
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
                                        <input type="text" name="domain" id="domain" value="{{ old('domain', $wordindex->domain) }}"
                                               class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    </div>

                                    <!-- Subject -->
                                    <div>
                                        <label for="subject" class="block font-medium text-sm text-gray-700">{{ __('Subject') }}</label>
                                        <input type="text" name="subject" id="subject" value="{{ old('subject', $wordindex->subject) }}"
                                               class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    </div>

                                    <!-- Term Type -->
                                    <div>
                                        <label for="termType" class="block font-medium text-sm text-gray-700">{{ __('Term Type') }}</label>
                                        <input type="text" name="termType" id="termType" value="{{ old('termType', $wordindex->termType) }}"
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
                                            <option value="" {{ old('status', $wordindex->status) == '' ? 'selected' : '' }}>{{ __('None') }}</option>
                                            <option value="active" {{ old('status', $wordindex->status) == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                            <option value="pending" {{ old('status', $wordindex->status) == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                            <option value="review" {{ old('status', $wordindex->status) == 'review' ? 'selected' : '' }}>{{ __('Review') }}</option>
                                        </select>
                                    </div>

                                    <!-- Author -->
                                    <div>
                                        <label for="author" class="block font-medium text-sm text-gray-700">{{ __('Author') }}</label>
                                        <input type="text" name="author" id="author" value="{{ old('author', $wordindex->author) }}"
                                               class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    </div>

                                    <!-- Source -->
                                    <div>
                                        <label for="source" class="block font-medium text-sm text-gray-700">{{ __('Source') }}</label>
                                        <input type="text" name="source" id="source" value="{{ old('source', $wordindex->source) }}"
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
                                        <input type="text" name="editor" id="editor" value="{{ old('editor', $wordindex->editor) }}"
                                               class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    </div>

                                    <!-- Editor Group -->
                                    <div>
                                        <label for="editor_group" class="block font-medium text-sm text-gray-700">{{ __('Editor Group') }}</label>
                                        <input type="text" name="editor_group" id="editor_group" value="{{ old('editor_group', $wordindex->editor_group) }}"
                                               class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons with dual language support -->
                            <div class="flex flex-col items-center justify-center col-span-2 mt-8 space-y-6">
                                <!-- Primary Save Button with Icon and Text -->


                                <!-- Secondary Tibetan Button -->
                                <div class="text-center w-full md:w-2/3">
                                    <button type="submit" class="bg-gradient-to-r from-amber-400 to-amber-500 text-gray-900 rounded-lg py-5 px-12 hover:from-amber-500 hover:to-amber-600 focus:outline-none focus:ring-4 focus:ring-amber-300 transition-colors duration-150 text-3xl shadow-md border border-amber-600 w-full">
                                        <span class="font-bold tracking-wide">ཉར་ཚགས་བྱེད།</span>
                                    </button>
                                    <p class="text-sm text-gray-600 mt-3">༼ Save Changes ནོན་ནས་ཉར་ཚགས་བྱེད། ༽</p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
