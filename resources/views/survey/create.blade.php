@extends('layouts.app')

@section('title', 'Cipta Soal Selidik Baharu')

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-purple-600 via-pink-500 to-red-500 text-white rounded-2xl p-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Cipta Soal Selidik Baharu</h1>
                    <p class="text-purple-100">Reka bentuk soal selidik anda dengan mudah dan cantik</p>
                </div>
                <div class="hidden sm:block">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-plus text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Builder -->
            <div class="lg:col-span-2">
                <div class="glass-card p-6">
                    <h2 class="text-2xl font-bold gradient-text mb-6">Bina Soal Selidik</h2>

                    <form id="surveyForm" method="POST" action="{{ route('survey.store') }}" class="space-y-6">
                        @csrf

                        <!-- Survey Details -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Tajuk Soal Selidik</label>
                                <input type="text" name="title" class="form-input-enhanced w-full"
                                    placeholder="Contoh: Kajian Kepuasan Pelanggan" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan</label>
                                <textarea name="description" rows="3" class="form-input-enhanced w-full"
                                    placeholder="Jelaskan tujuan soal selidik ini..."></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Bahagian</label>
                                    <input type="text" name="section" class="form-input-enhanced w-full"
                                        placeholder="Contoh: A, B, C..." required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                                    <select name="category" class="form-input-enhanced w-full">
                                        <option value="general">Umum</option>
                                        <option value="work">Pekerjaan</option>
                                        <option value="health">Kesihatan</option>
                                        <option value="education">Pendidikan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Questions Section -->
                        <div class="border-t pt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-bold text-gray-800">Soalan</h3>
                                <button type="button" onclick="addQuestion()" class="btn-enhanced px-4 py-2 text-sm">
                                    <i class="fas fa-plus mr-2"></i>Tambah Soalan
                                </button>
                            </div>

                            <div id="questionsContainer" class="space-y-4">
                                <!-- Questions will be added here dynamically -->
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-4">
                            <button type="button" onclick="previewSurvey()"
                                class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors">
                                <i class="fas fa-eye mr-2"></i>Pratonton
                            </button>
                            <button type="submit" class="btn-enhanced px-8 py-3">
                                <i class="fas fa-save mr-2"></i>Simpan Soal Selidik
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Preview Panel -->
            <div class="lg:col-span-1">
                <div class="glass-card p-6 sticky top-4">
                    <h3 class="text-xl font-bold gradient-text mb-4">Pratonton</h3>
                    <div id="previewPanel" class="space-y-4">
                        <div class="text-center text-gray-500 py-8">
                            <i class="fas fa-eye-slash text-4xl mb-2"></i>
                            <p>Pratonton akan dipaparkan di sini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Question Template -->
    <template id="questionTemplate">
        <div class="question-item bg-white rounded-xl border-2 border-gray-200 p-4 space-y-4">
            <div class="flex items-center justify-between">
                <span class="question-number font-semibold text-gray-600">Soalan #<span class="number">1</span></span>
                <button type="button" onclick="removeQuestion(this)" class="text-red-500 hover:text-red-700">
                    <i class="fas fa-trash"></i>
                </button>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Teks Soalan</label>
                <input type="text" name="questions[][text]" class="form-input-enhanced w-full"
                    placeholder="Masukkan soalan anda..." required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Soalan</label>
                <select name="questions[][type]" class="form-input-enhanced w-full question-type"
                    onchange="toggleQuestionType(this)">
                    <option value="single_choice">Pilihan Tunggal</option>
                    <option value="multiple_choice">Pilihan Berganda</option>
                    <option value="text">Teks</option>
                    <option value="multiText">Multi-Teks (Boleh Tambah)</option>
                    <option value="numeric">Nombor</option>
                    <option value="rating">Penilaian</option>
                </select>
            </div>

            <div class="options-container space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Pilihan Jawapan</label>
                <div class="space-y-2">
                    <div class="flex items-center space-x-2">
                        <input type="text" name="questions[][options][]" class="form-input-enhanced flex-1"
                            placeholder="Pilihan 1">
                        <button type="button" onclick="addOption(this)" class="text-green-500 hover:text-green-700">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/enhanced-design.css') }}">
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            border-radius: 1.5rem;
        }

        .question-item {
            transition: all 0.3s ease;
        }

        .question-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .sticky {
            position: sticky;
            top: 1rem;
        }

        @media (max-width: 1024px) {
            .sticky {
                position: relative;
                top: 0;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        let questionCount = 0;

        function addQuestion() {
            questionCount++;
            const template = document.getElementById('questionTemplate');
            const clone = template.content.cloneNode(true);

            clone.querySelector('.number').textContent = questionCount;
            clone.querySelector('input[name="questions[][text]"]').name = `questions[${questionCount}][text]`;
            clone.querySelector('select[name="questions[][type]"]').name = `questions[${questionCount}][type]`;
            clone.querySelector('input[name="questions[][options][]"]').name = `questions[${questionCount}][options][]`;

            document.getElementById('questionsContainer').appendChild(clone);
            updatePreview();
        }

        function removeQuestion(button) {
            button.closest('.question-item').remove();
            updateQuestionNumbers();
            updatePreview();
        }

        function addOption(button) {
            const container = button.closest('.options-container');
            const optionDiv = document.createElement('div');
            optionDiv.className = 'flex items-center space-x-2';
            optionDiv.innerHTML = `
                <input type="text" name="${button.closest('.question-item').querySelector('input[name*="[text]"]').name.replace('[text]', '[options][]')}"
                       class="form-input-enhanced flex-1" placeholder="Pilihan baru">
                <button type="button" onclick="removeOption(this)"
                        class="text-red-500 hover:text-red-700">
                    <i class="fas fa-minus"></i>
                </button>
            `;
            container.querySelector('.space-y-2').appendChild(optionDiv);
        }

        function removeOption(button) {
            button.closest('.flex.items-center').remove();
            updatePreview();
        }

        function toggleQuestionType(select) {
            const questionItem = select.closest('.question-item');
            const optionsContainer = questionItem.querySelector('.options-container');

            if (['single_choice', 'multiple_choice', 'rating'].includes(select.value)) {
                optionsContainer.style.display = 'block';
            } else {
                optionsContainer.style.display = 'none';
            }
            updatePreview();
        }

        function updateQuestionNumbers() {
            const questions = document.querySelectorAll('.question-item');
            questions.forEach((q, index) => {
                q.querySelector('.number').textContent = index + 1;
            });
        }

        function updatePreview() {
            const title = document.querySelector('input[name="title"]').value || 'Tajuk Soal Selidik';
            const description = document.querySelector('textarea[name="description"]').value || 'Tiada keterangan';

            let previewHTML = `
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 text-white p-4 rounded-lg mb-4">
                    <h4 class="font-bold">${title}</h4>
                    <p class="text-sm opacity-90">${description}</p>
                </div>
            `;

            const questions = document.querySelectorAll('.question-item');
            questions.forEach((q, index) => {
                const text = q.querySelector('input[name*="[text]"]').value || `Soalan ${index + 1}`;
                const type = q.querySelector('select[name*="[type]"]').value;

                previewHTML += `
                    <div class="border border-gray-200 rounded-lg p-3">
                        <p class="font-semibold text-sm mb-2">${index + 1}. ${text}</p>
                        <p class="text-xs text-gray-500">Jenis: ${type}</p>
                    </div>
                `;
            });

            document.getElementById('previewPanel').innerHTML = previewHTML;
        }

        function previewSurvey() {
            // This would open a modal with full preview
            alert('Pratonton penuh akan ditambah dalam versi akan datang!');
        }

        // Initialize with one question
        document.addEventListener('DOMContentLoaded', function() {
            addQuestion();
        });
    </script>
@endpush
