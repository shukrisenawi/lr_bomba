# Debug VideoImage Upload Issues

## Issues Fixed

### 1. **Missing Form Enctype** ✅
**Problem**: Form was missing `enctype="multipart/form-data"` 
**Solution**: Added conditional enctype for videoImage questions

### 2. **Added Comprehensive Debugging** ✅
Added logging to track:
- File upload detection
- Validation process
- File saving process
- Database insertion

## How to Debug

### 1. Check Laravel Logs
Look at `storage/logs/laravel.log` for debug information:

```bash
tail -f storage/logs/laravel.log
```

### 2. Test Upload Process
1. Go to the videoImage question in your survey
2. Try uploading a file
3. Check the logs for these messages:
   - "VideoImage validation rules"
   - "Validation passed for videoImage" 
   - "VideoImage Upload Debug"
   - "File uploaded"
   - "Answer saved successfully"

### 3. Check Database
Look in `survey_answers` table for the JSON data:
```sql
SELECT * FROM survey_answers WHERE question_id = '10' ORDER BY created_at DESC;
```

### 4. Check File System
Look in `public/upload/` directory for uploaded files.

## Common Issues & Solutions

### Issue 1: Files not uploading
**Symptoms**: No files in `public/upload/` directory
**Check**: 
- Form has `enctype="multipart/form-data"`
- File input has `name="files[]"`
- Directory permissions are correct

### Issue 2: Database not saving
**Symptoms**: Files upload but no database entry
**Check**:
- SurveyResponse exists for the user/section
- Question ID matches exactly
- No validation errors

### Issue 3: JavaScript errors
**Symptoms**: File selection doesn't work
**Check**:
- Browser console for JavaScript errors
- File input element exists
- Event handlers are attached

## Test Commands

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Check Permissions
```bash
chmod 755 public/upload
```

### Test File Upload Manually
Create a simple test form to isolate the issue:

```html
<form method="POST" action="/test-upload" enctype="multipart/form-data">
    @csrf
    <input type="file" name="files[]" multiple>
    <button type="submit">Upload</button>
</form>
```

## Expected Log Output

When working correctly, you should see:
```
[timestamp] VideoImage validation rules: {...}
[timestamp] Validation passed for videoImage
[timestamp] VideoImage Upload Debug: {"has_files":true,...}
[timestamp] File uploaded: {"filename":"...","path":"..."}
[timestamp] Saving answer data: {...}
[timestamp] Answer saved successfully: {"answer_id":123}
```

## Next Steps

1. Try uploading a file now
2. Check the Laravel logs immediately after
3. Share the log output if still having issues
4. Check if files appear in `public/upload/`
5. Check if data appears in database
