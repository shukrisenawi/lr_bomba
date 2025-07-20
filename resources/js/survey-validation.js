/**
 * Enhanced Survey Form Validation Module
 * Provides real-time validation and user feedback for survey forms
 */

class SurveyValidator {
    constructor(formSelector) {
        this.form = document.querySelector(formSelector);
        this.fields = {};
        this.errors = {};
        this.init();
    }

    init() {
        if (!this.form) return;

        this.setupValidation();
        this.bindEvents();
    }

    setupValidation() {
        // Define validation rules based on field types
        this.validationRules = {
            'answer': {
                required: true,
                validate: (value, field) => {
                    const type = field.dataset.type || 'text';

                    switch(type) {
                        case 'single_choice':
                            return this.validateSingleChoice(field);
                        case 'numeric':
                            return this.validateNumeric(value);
                        case 'text':
                            return this.validateText(value);
                        default:
                            return value.trim().length > 0;
                    }
                },
                message: {
                    required: 'Sila pilih atau masukkan jawapan',
                    invalid: 'Jawapan tidak sah'
                }
            }
        };
    }

    validateSingleChoice(field) {
        const checked = field.querySelector('input[type="radio"]:checked');
        return checked !== null;
    }

    validateNumeric(value) {
        const num = parseFloat(value);
        return !isNaN(num) && isFinite(num);
    }

    validateText(value) {
        return value.trim().length > 0 && value.trim().length <= 500;
    }

    bindEvents() {
        // Real-time validation
        this.form.addEventListener('input', (e) => {
            this.validateField(e.target);
        });

        this.form.addEventListener('change', (e) => {
            this.validateField(e.target);
        });

        // Form submission
        this.form.addEventListener('submit', (e) => {
            if (!this.validateForm()) {
                e.preventDefault();
                this.showFirstError();
            }
        });
    }

    validateField(field) {
        const fieldName = field.name;
        const rule = this.validationRules[fieldName];

        if (!rule) return true;

        let isValid = true;
        let errorMessage = '';

        // Check required
        if (rule.required && !field.value.trim()) {
            isValid = false;
            errorMessage = rule.message.required;
        } else if (rule.validate && !rule.validate(field.value, field)) {
            isValid = false;
            errorMessage = rule.message.invalid;
        }

        this.toggleFieldError(field, isValid, errorMessage);
        return isValid;
    }

    validateForm() {
        let isValid = true;
        const fields = this.form.querySelectorAll('[name="answer"]');

        fields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });

        return isValid;
    }

    toggleFieldError(field, isValid, message) {
        const fieldContainer = field.closest('.form-group') || field.parentElement;
        const errorElement = fieldContainer.querySelector('.error-message');

        if (isValid) {
            field.classList.remove('error');
            field.classList.add('valid');
            if (errorElement) {
                errorElement.remove();
            }
        } else {
            field.classList.add('error');
            field.classList.remove('valid');

            if (!errorElement) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message text-red-500 text-sm mt-1';
                errorDiv.textContent = message;
                fieldContainer.appendChild(errorDiv);
            } else {
                errorElement.textContent = message;
            }
        }
    }

    showFirstError() {
        const firstError = this.form.querySelector('.error');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
    }

    // Utility method to add shake animation
    shakeForm() {
        this.form.style.animation = 'shake 0.5s';
        setTimeout(() => {
            this.form.style.animation = '';
        }, 500);
    }
}

// Initialize validation on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initialize for question forms
    const questionForms = document.querySelectorAll('form[action*="survey.store"]');
    questionForms.forEach(form => {
        new SurveyValidator(form);
    });

    // Initialize for edit forms
    const editForms = document.querySelectorAll('form[action*="survey.update"]');
    editForms.forEach(form => {
        new SurveyValidator(form);
    });
});

// CSS for shake animation
const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }

    .form-input-enhanced.error {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .form-input-enhanced.valid {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    .error-message {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
document.head.appendChild(style);

// Export for use in other modules
window.SurveyValidator = SurveyValidator;
