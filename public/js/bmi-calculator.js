// BMI Calculator for registration form
document.addEventListener('DOMContentLoaded', function() {
    const heightInput = document.getElementById('height');
    const weightInput = document.getElementById('weight');
    const bmiInput = document.getElementById('bmi');

    // Function to calculate BMI
    function calculateBMI() {
        const height = parseFloat(heightInput.value);
        const weight = parseFloat(weightInput.value);

        // Validate inputs
        if (height > 0 && weight > 0) {
            // Convert height from cm to meters
            const heightInMeters = height / 100;
            // Calculate BMI: weight (kg) / (height (m))²
            const bmi = weight / (heightInMeters * heightInMeters);
            // Round to 2 decimal places
            const roundedBMI = Math.round(bmi * 100) / 100;

            // Set the BMI value
            bmiInput.value = roundedBMI;
        } else {
            // Clear BMI if inputs are invalid
            bmiInput.value = '';
        }
    }

    // Add event listeners for real-time calculation
    if (heightInput && weightInput && bmiInput) {
        heightInput.addEventListener('input', calculateBMI);
        weightInput.addEventListener('input', calculateBMI);

        // Also calculate on change events for better browser compatibility
        heightInput.addEventListener('change', calculateBMI);
        weightInput.addEventListener('change', calculateBMI);
    }
});
