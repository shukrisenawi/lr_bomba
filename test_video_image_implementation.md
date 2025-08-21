# VideoImage Implementation Test Guide

## Overview
This document outlines the implementation of the `videoImage` responder type for the survey system.

## Features Implemented

### 1. Backend Implementation
- **File Upload Handling**: Added support for multiple file uploads (images and videos)
- **File Storage**: Files are saved to `public/upload/` directory
- **JSON Response Format**: File information is stored as JSON with the following structure:
```json
{
  "files": [
    {
      "filename": "timestamp_uniqueid.ext",
      "original_name": "original_filename.ext",
      "size": 1234567,
      "mime_type": "image/jpeg",
      "url": "http://domain.com/upload/filename.ext"
    }
  ],
  "upload_count": 1
}
```

### 2. Frontend Implementation
- **Drag & Drop Interface**: Users can drag and drop files onto the upload area
- **File Preview**: Images show thumbnails, videos show video icons
- **File Limit**: Respects the `limit` property from survey JSON (default: 5 files)
- **File Type Validation**: Accepts images (JPG, PNG, GIF) and videos (MP4, MOV, AVI, WMV)
- **File Size Limit**: Maximum 20MB per file

### 3. Survey Configuration
The survey JSON supports the following format for videoImage questions:
```json
{
  "id": "5",
  "text": "Upload your images or videos",
  "type": "videoImage",
  "limit": 5
}
```

### 4. Scoring System
- **Score Calculation**: Based on number of files uploaded
- **Maximum Score**: Equals the limit value
- **Formula**: `min(upload_count, limit)`

## File Structure Changes

### Modified Files:
1. `app/Http/Controllers/SurveyController.php`
   - Added file upload validation
   - Added `handleVideoImageUpload()` method
   - Updated question type handling

2. `app/Helpers/survey_helper.php` & `app/Helpers/survey_helper_updated.php`
   - Added `get_video_image_score()` function
   - Updated `calculate_question_score()` switch statement

3. `resources/views/survey/question-beautiful.blade.php`
   - Added videoImage question type rendering
   - Added drag & drop file upload interface
   - Added JavaScript for file handling

4. `resources/views/survey/question-beautiful-fixed.blade.php`
   - Same frontend implementation as above

## Testing the Implementation

### 1. Survey JSON Setup
Ensure your survey JSON includes a videoImage question:
```json
{
  "id": "test_video",
  "text": "Please upload images or videos related to your work",
  "type": "videoImage",
  "limit": 3
}
```

### 2. File Upload Test
1. Navigate to the survey question
2. Try uploading files via:
   - Drag and drop
   - Click to select files
3. Verify file previews appear
4. Submit the form
5. Check that files are saved in `public/upload/`

### 3. Data Storage Test
Check the database `survey_answers` table for the JSON response format.

### 4. Scoring Test
Verify that the scoring system correctly calculates scores based on upload count.

## Security Considerations
- File type validation on both frontend and backend
- File size limits (20MB max)
- Unique filename generation to prevent conflicts
- Files stored in public directory for easy access

## Future Enhancements
- File deletion functionality
- Image compression
- Video thumbnail generation
- Cloud storage integration
- Progress bars for large uploads
