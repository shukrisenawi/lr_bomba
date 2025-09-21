@props(['question', 'existingAnswers' => []])

<div class="multi-text-multi-label-container" data-question-id="{{ $question['id'] }}">
    <div id="sets-container">
        @if(count($existingAnswers) > 0)
            @foreach($existingAnswers as $setIndex => $setData)
                <div class="input-set border-2 border-gray-200 rounded-xl p-4 mb-4">
                    @foreach ($question['multiLabel'] as $index => $label)
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ $label }}</label>
                            <input type="text" name="answer_set[{{ $setIndex }}][{{ $index }}]"
                                class="form-input-enhanced w-full text-lg" placeholder="Taip jawapan anda di sini"
                                value="{{ $setData[$label] ?? '' }}">
                        </div>
                    @endforeach
                    <div class="text-right">
                        <button type="button" class="remove-set-btn text-red-500 hover:text-red-700 transition-colors">
                            <i class="fas fa-minus-circle text-xl"></i> Hapus Set
                        </button>
                    </div>
                </div>
            @endforeach
        @else
            <!-- Initial Set -->
            <div class="input-set border-2 border-gray-200 rounded-xl p-4 mb-4">
                @foreach ($question['multiLabel'] as $index => $label)
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">{{ $label }}</label>
                        <input type="text" name="answer_set[0][{{ $index }}]"
                            class="form-input-enhanced w-full text-lg" placeholder="Taip jawapan anda di sini">
                    </div>
                @endforeach
                <div class="text-right">
                    <button type="button" class="remove-set-btn text-red-500 hover:text-red-700 transition-colors"
                        style="display: none;">
                        <i class="fas fa-minus-circle text-xl"></i> Hapus Set
                    </button>
                </div>
            </div>
        @endif
    </div>

    <button type="button" id="add-set-btn"
        class="w-full bg-green-500 text-white py-3 px-6 rounded-xl font-semibold hover:bg-green-600 transition-all duration-300 shadow-lg">
        <i class="fas fa-plus-circle mr-2"></i> Tambah Set
    </button>

    <input type="hidden" name="answer" id="multi-text-multi-label-json-{{ $question['id'] }}" value="[]">
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.querySelector(
            '.multi-text-multi-label-container[data-question-id="{{ $question['id'] }}"]');
        const setsContainer = container.querySelector('#sets-container');
        const addSetBtn = container.querySelector('#add-set-btn');
        const jsonInput = container.querySelector('#multi-text-multi-label-json-{{ $question['id'] }}');
        const questionLabels = @json($question['multiLabel']);

        let setCounter = {{ count($existingAnswers) > 0 ? count($existingAnswers) : 1 }};

        const updateRemoveButtons = () => {
            const sets = setsContainer.querySelectorAll('.input-set');
            sets.forEach((set, index) => {
                const removeBtn = set.querySelector('.remove-set-btn');
                if (sets.length > 1) {
                    removeBtn.style.display = 'inline-block';
                } else {
                    removeBtn.style.display = 'none';
                }
            });
        };

        const updateJson = () => {
            const sets = setsContainer.querySelectorAll('.input-set');
            const allSetsData = [];
            sets.forEach(set => {
                const inputs = set.querySelectorAll('input[type="text"]');
                const setData = {};
                let hasValue = false;
                inputs.forEach((input, index) => {
                    const label = questionLabels[index];
                    setData[label] = input.value;
                    if (input.value.trim() !== '') {
                        hasValue = true;
                    }
                });
                if (hasValue) {
                    allSetsData.push(setData);
                }
            });
            jsonInput.value = JSON.stringify(allSetsData);
        };

        addSetBtn.addEventListener('click', () => {
            const newSet = document.createElement('div');
            newSet.className = 'input-set border-2 border-gray-200 rounded-xl p-4 mb-4';

            let inputsHtml = '';
            questionLabels.forEach((label, index) => {
                inputsHtml += `
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">${label}</label>
                    <input type="text" name="answer_set[${setCounter}][${index}]" class="form-input-enhanced w-full text-lg" placeholder="Taip jawapan anda di sini">
                </div>
            `;
            });

            newSet.innerHTML = `
            ${inputsHtml}
            <div class="text-right">
                <button type="button" class="remove-set-btn text-red-500 hover:text-red-700 transition-colors">
                    <i class="fas fa-minus-circle text-xl"></i> Hapus Set
                </button>
            </div>
        `;

            setsContainer.appendChild(newSet);
            setCounter++;
            updateRemoveButtons();
        });

        setsContainer.addEventListener('click', (e) => {
            if (e.target.closest('.remove-set-btn')) {
                e.target.closest('.input-set').remove();
                updateRemoveButtons();
                updateJson();
            }
        });

        setsContainer.addEventListener('input', () => {
            updateJson();
        });

        updateRemoveButtons();
        updateJson(); // Initial call
    });
</script>
