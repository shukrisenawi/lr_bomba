<div class="survey-accordion">
    <div class="accordion-item border border-gray-200 rounded-lg mb-4">
        <button
            class="accordion-header w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 transition-colors duration-200"
            onclick="toggleAccordion(this)">
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-500 mr-3 transition-transform duration-200"></i>
                <span class="font-semibold text-gray-900">{{ $title }}</span>
                <span class="ml-2 text-sm text-gray-600">({{ count($items) }} soalan)</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-600">{{ $subtitle ?? '' }}</span>
                <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200"></i>
            </div>
        </button>
        <div class="accordion-content bg-white overflow-hidden max-h-0 transition-all duration-300 ease-in-out">
            <div class="p-4 border-t border-gray-200">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

<style>
    .survey-accordion .accordion-content {
        transition: max-height 0.3s ease-in-out;
    }

    .survey-accordion .accordion-item.active .accordion-header {
        background-color: #f3f4f6;
    }

    .survey-accordion .accordion-item.active .accordion-header i.fa-chevron-right {
        transform: rotate(90deg);
    }

    .survey-accordion .accordion-item.active .accordion-header i.fa-chevron-down {
        transform: rotate(180deg);
    }
</style>

<script>
    function toggleAccordion(header) {
        const accordionItem = header.closest('.accordion-item');
        const content = header.nextElementSibling;
        const chevronRight = header.querySelector('.fa-chevron-right');
        const chevronDown = header.querySelector('.fa-chevron-down');

        if (accordionItem.classList.contains('active')) {
            // Close accordion
            accordionItem.classList.remove('active');
            content.style.maxHeight = '0';
            chevronRight.style.transform = 'rotate(0deg)';
            chevronDown.style.transform = 'rotate(0deg)';
        } else {
            // Open accordion
            accordionItem.classList.add('active');
            content.style.maxHeight = content.scrollHeight + 'px';
            chevronRight.style.transform = 'rotate(90deg)';
            chevronDown.style.transform = 'rotate(180deg)';
        }
    }

    // Initialize all accordions as closed
    document.addEventListener('DOMContentLoaded', function() {
        const accordions = document.querySelectorAll('.survey-accordion .accordion-item');
        accordions.forEach(item => {
            const content = item.querySelector('.accordion-content');
            content.style.maxHeight = '0';
        });
    });
</script>
</div>
