# Installation

```bash
composer require diaeai/flysystem-file-response
```

# Example

```php
<?php
// routes/web.php
Route::get('video.mp4', function() {
    return Storage::disk('s3')->file('path/video.mp4');
});
```
