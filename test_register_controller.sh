#!/bin/bash

echo "🧪 Testing RegisterController Functions"
echo "====================================="

# Run feature tests
echo "Running Feature Tests..."
php artisan test tests/Feature/RegisterControllerTest.php --verbose

echo ""
echo "✅ RegisterController testing completed!"
echo ""
echo "📋 Test Summary:"
echo "- create() function: Displays consent form"
echo "- storeConsent() function: Stores consent data"
echo "- showDemographyForm() function: Displays demography form"
echo "- storeDemography() function: Completes registration"
echo ""
echo "📝 Manual Testing Guide:"
echo "1. Visit: http://localhost/register"
echo "2. Fill consent form with name, email, and check consent"
echo "3. Submit to proceed to demography form"
echo "4. Fill all required fields (age must be 45+)"
echo "5. Submit to complete registration"
echo ""
echo "🔍 Check REGISTER_TESTING_GUIDE.md for detailed instructions"
