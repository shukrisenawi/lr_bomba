@props(['questionId' => '', 'label' => 'Masukkan jawapan:', 'existingAnswers' => []])

<div class="multi-text-container" data-question-id="{{ $questionId }}">
    <label class="block text-sm font-semibold text-gray-700 mb-2">
        {{ $label }}
    </label>

    <div class="space-y-3" id="multiTextInputs-{{ $questionId }}">
        @if(count($existingAnswers) > 0)
            @foreach($existingAnswers as $index => $answer)
                <div class="flex items-center space-x-2 input-group">
                    <input type="text" name="multi_text_answers[]" class="form-input-enhanced flex-1 text-lg"
                        placeholder="Taip jawapan anda di sini" data-input-index="{{ $index }}" value="{{ $answer }}">
                    <button type="button" class="add-input-btn text-green-500 hover:text-green-700 transition-colors"
                        onclick="addMultiTextInput(this)">
                        <i class="fas fa-plus-circle text-xl"></i>
                    </button>
                    <button type="button" class="remove-input-btn text-red-500 hover:text-red-700 transition-colors"
                        onclick="removeMultiTextInput(this)" style="display: {{ count($existingAnswers) > 1 ? 'block' : 'none' }};">
                        <i class="fas fa-minus-circle text-xl"></i>
                    </button>
                </div>
            @endforeach
        @else
            <!-- Initial input -->
            <div class="flex items-center space-x-2 input-group">
                <input type="text" name="multi_text_answers[]" class="form-input-enhanced flex-1 text-lg"
                    placeholder="Taip jawapan anda di sini" data-input-index="0">
                <button type="button" class="add-input-btn text-green-500 hover:text-green-700 transition-colors"
                    onclick="addMultiTextInput(this)">
                    <i class="fas fa-plus-circle text-xl"></i>
                </button>
                <button type="button" class="remove-input-btn text-red-500 hover:text-red-700 transition-colors"
                    onclick="removeMultiTextInput(this)" style="display: none;">
                    <i class="fas fa-minus-circle text-xl"></i>
                </button>
            </div>
        @endif
    </div>

    <!-- Hidden input for JSON storage -->
    <input type="hidden" name="answer" id="multiTextJson-{{ $questionId ?? 'default' }}" value="[]">
</div>

<style>
    .multi-text-container .input-group {
        transition: all 0.3s ease;
    }

    .multi-text-container .input-group:hover {
        transform: translateY(-1px);
    }

    .multi-text-container .form-input-enhanced {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.9);
    }

    .multi-text-container .form-input-enhanced:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .multi-text-container button {
        transition: all 0.3s ease;
        padding: 8px;
        border-radius: 50%;
    }

    .multi-text-container button:hover {
        transform: scale(1.1);
    }

    .multi-text-container button:active {
        transform: scale(0.9);
    }
</style>

<script>
    function addMultiTextInput(button) {
        const container = button.closest('.multi-text-container');
        const inputsContainer = container.querySelector('[id^="multiTextInputs-"]');
        const inputGroups = inputsContainer.querySelectorAll('.input-group');

        // Create new input group
        const newIndex = inputGroups.length;
        const newGroup = document.createElement('div');
        newGroup.className = 'flex items-center space-x-2 input-group';
        newGroup.innerHTML = `
        <input type="text"
               name="multi_text_answers[]"
               class="form-input-enhanced flex-1 text-lg"
               placeholder="Taip jawapan tambahan di sini"
               data-input-index="${newIndex}">
        <button type="button"
                class="add-input-btn text-green-500 hover:text-green-700 transition-colors"
                onclick="addMultiTextInput(this)">
            <i class="fas fa-plus-circle text-xl"></i>
        </button>
        <button type="button"
                class="remove-input-btn text-red-500 hover:text-red-700 transition-colors"
                onclick="removeMultiTextInput(this)">
            <i class="fas fa-minus-circle text-xl"></i>
        </button>
    `;

        inputsContainer.appendChild(newGroup);

        // Show remove button for all inputs except first if more than one
        updateRemoveButtons(inputsContainer);

        // Focus new input
        newGroup.querySelector('input').focus();

        // Update JSON
        updateMultiTextJson(container);
    }

    function removeMultiTextInput(button) {
        const container = button.closest('.multi-text-container');
        const inputsContainer = container.querySelector('[id^="multiTextInputs-"]');
        const inputGroup = button.closest('.input-group');

        // Add fade out animation
        inputGroup.style.transition = 'opacity 0.3s ease';
        inputGroup.style.opacity = '0';

        setTimeout(() => {
            inputGroup.remove();
            updateRemoveButtons(inputsContainer);
            updateMultiTextJson(container);
        }, 300);
    }

    function updateRemoveButtons(inputsContainer) {
        const inputGroups = inputsContainer.querySelectorAll('.input-group');
        const removeButtons = inputsContainer.querySelectorAll('.remove-input-btn');

        removeButtons.forEach(btn => {
            if (inputGroups.length > 1) {
                btn.style.display = 'block';
            } else {
                btn.style.display = 'none';
            }
        });
    }

    function updateMultiTextJson(container) {
        const inputs = container.querySelectorAll('input[name="multi_text_answers[]"]');
        const jsonInput = container.querySelector('[id^="multiTextJson-"]');

        const answers = Array.from(inputs)
            .map(input => input.value.trim())
            .filter(value => value !== '');

        jsonInput.value = JSON.stringify(answers);
    }

    // Initialize event listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Add input event listeners for real-time JSON update
        document.querySelectorAll('.multi-text-container').forEach(container => {
            container.addEventListener('input', function(e) {
                if (e.target.matches('input[name="multi_text_answers[]"]')) {
                    updateMultiTextJson(container);
                }
            });

            // Initialize JSON on load
            updateMultiTextJson(container);
        });
    });

    // Validation function
    function validateMultiText(container) {
        const inputs = container.querySelectorAll('input[name="multi_text_answers[]"]');
        const hasValidInput = Array.from(inputs).some(input => input.value.trim() !== '');

        if (!hasValidInput) {
            alert('Sila masukkan sekurang-kurangnya satu jawapan.');
            return false;
        }

        return true;
    }
</script>
