<?php
// InfinityFree Compatible Watermark Settings
session_start();

// Default watermark settings
$watermarkSettings = array(
    'enabled' => true,
    'text' => '⚡ Free Hosting',
    'link' => 'https://your-domain.com',
    'position' => 'bottom-right',
    'color' => '#FF6B35',
    'opacity' => 0.9,
    'size' => 'small'
);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_watermark'])) {
    $watermarkSettings['enabled'] = isset($_POST['enabled']);
    $watermarkSettings['text'] = isset($_POST['text']) ? $_POST['text'] : '⚡ Free Hosting';
    $watermarkSettings['link'] = isset($_POST['link']) ? $_POST['link'] : 'https://your-domain.com';
    $watermarkSettings['position'] = isset($_POST['position']) ? $_POST['position'] : 'bottom-right';
    $watermarkSettings['color'] = isset($_POST['color']) ? $_POST['color'] : '#FF6B35';
    $watermarkSettings['opacity'] = isset($_POST['opacity']) ? (float)$_POST['opacity'] : 0.9;
    $watermarkSettings['size'] = isset($_POST['size']) ? $_POST['size'] : 'small';
    
    $_SESSION['watermark_config'] = $watermarkSettings;
    $success = "Watermark settings updated successfully!";
}

// Load from session
if (isset($_SESSION['watermark_config'])) {
    $watermarkSettings = $_SESSION['watermark_config'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watermark Settings - Free HTML Hosting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .glass-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            backdrop-filter: blur(5px);
        }
        
        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #FF6B35;
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
            color: white;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #FF6B35 0%, #FFD23F 100%);
            border: none;
            border-radius: 15px;
            padding: 12px 30px;
            font-weight: 600;
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 15px;
            padding: 12px 30px;
            font-weight: 600;
            backdrop-filter: blur(5px);
        }
        
        .preview-watermark {
            position: fixed;
            background: linear-gradient(135deg, var(--wm-color, #FF6B35) 0%, #FFD23F 100%);
            color: white;
            padding: 8px 15px;
            border-radius: 25px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 999999;
            opacity: var(--wm-opacity, 0.9);
        }
        
        .preview-watermark.small { font-size: 12px; padding: 8px 15px; }
        .preview-watermark.medium { font-size: 14px; padding: 10px 18px; }
        .preview-watermark.large { font-size: 16px; padding: 12px 22px; }
        
        .preview-watermark.bottom-right { bottom: 10px; right: 10px; }
        .preview-watermark.bottom-left { bottom: 10px; left: 10px; }
        .preview-watermark.top-right { top: 10px; right: 10px; }
        .preview-watermark.top-left { top: 10px; left: 10px; }
        
        .text-white { color: white !important; }
        .text-light { color: rgba(255, 255, 255, 0.8) !important; }
        
        .form-check-input:checked {
            background-color: #FF6B35;
            border-color: #FF6B35;
        }
        
        .alert-success {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: #28a745;
            backdrop-filter: blur(5px);
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="glass-container p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h1 class="text-white mb-3">
                            <i class="fas fa-paint-brush text-warning me-2"></i>
                            Watermark Settings
                        </h1>
                        <p class="text-light">Customize watermarks for hosted websites</p>
                    </div>

                    <?php if (isset($success)): ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?php echo $success; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="enabled" name="enabled" <?php echo $watermarkSettings['enabled'] ? 'checked' : ''; ?>>
                                    <label class="form-check-label text-white" for="enabled">
                                        <strong>Enable Watermarks</strong>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="text" class="form-label text-white">
                                    <i class="fas fa-text-width me-2"></i>Watermark Text
                                </label>
                                <input type="text" class="form-control" id="text" name="text" 
                                       value="<?php echo htmlspecialchars($watermarkSettings['text']); ?>" 
                                       placeholder="⚡ Free Hosting">
                            </div>

                            <div class="col-md-6">
                                <label for="link" class="form-label text-white">
                                    <i class="fas fa-link me-2"></i>Watermark Link
                                </label>
                                <input type="url" class="form-control" id="link" name="link" 
                                       value="<?php echo htmlspecialchars($watermarkSettings['link']); ?>" 
                                       placeholder="https://your-website.com">
                            </div>

                            <div class="col-md-6">
                                <label for="position" class="form-label text-white">
                                    <i class="fas fa-arrows-alt me-2"></i>Position
                                </label>
                                <select class="form-select" id="position" name="position">
                                    <option value="bottom-right" <?php echo $watermarkSettings['position'] === 'bottom-right' ? 'selected' : ''; ?>>Bottom Right</option>
                                    <option value="bottom-left" <?php echo $watermarkSettings['position'] === 'bottom-left' ? 'selected' : ''; ?>>Bottom Left</option>
                                    <option value="top-right" <?php echo $watermarkSettings['position'] === 'top-right' ? 'selected' : ''; ?>>Top Right</option>
                                    <option value="top-left" <?php echo $watermarkSettings['position'] === 'top-left' ? 'selected' : ''; ?>>Top Left</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="size" class="form-label text-white">
                                    <i class="fas fa-expand-arrows-alt me-2"></i>Size
                                </label>
                                <select class="form-select" id="size" name="size">
                                    <option value="small" <?php echo $watermarkSettings['size'] === 'small' ? 'selected' : ''; ?>>Small</option>
                                    <option value="medium" <?php echo $watermarkSettings['size'] === 'medium' ? 'selected' : ''; ?>>Medium</option>
                                    <option value="large" <?php echo $watermarkSettings['size'] === 'large' ? 'selected' : ''; ?>>Large</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="color" class="form-label text-white">
                                    <i class="fas fa-palette me-2"></i>Color
                                </label>
                                <input type="color" class="form-control" id="color" name="color" 
                                       value="<?php echo $watermarkSettings['color']; ?>" style="height: 50px;">
                            </div>

                            <div class="col-md-6">
                                <label for="opacity" class="form-label text-white">
                                    <i class="fas fa-adjust me-2"></i>Opacity: <span id="opacityValue"><?php echo $watermarkSettings['opacity']; ?></span>
                                </label>
                                <input type="range" class="form-range" id="opacity" name="opacity" 
                                       min="0.1" max="1" step="0.1" value="<?php echo $watermarkSettings['opacity']; ?>">
                            </div>

                            <div class="col-12">
                                <div class="d-flex gap-3 justify-content-center">
                                    <button type="submit" name="update_watermark" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Save Settings
                                    </button>
                                    <a href="index.php" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Live Preview -->
                    <div class="mt-5 pt-4 border-top border-light">
                        <h5 class="text-white mb-3">
                            <i class="fas fa-eye me-2"></i>Live Preview
                        </h5>
                        <div class="position-relative bg-dark rounded-3 p-4" style="height: 200px; overflow: hidden;">
                            <p class="text-light m-0">Website preview area...</p>
                            <div id="previewWatermark" class="preview-watermark <?php echo $watermarkSettings['position'] . ' ' . $watermarkSettings['size']; ?>" 
                                 style="--wm-color: <?php echo $watermarkSettings['color']; ?>; --wm-opacity: <?php echo $watermarkSettings['opacity']; ?>;">
                                <?php echo htmlspecialchars($watermarkSettings['text']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updatePreview() {
            var preview = document.getElementById('previewWatermark');
            var text = document.getElementById('text').value || '⚡ Free Hosting';
            var position = document.getElementById('position').value;
            var size = document.getElementById('size').value;
            var color = document.getElementById('color').value;
            var opacity = document.getElementById('opacity').value;
            
            preview.textContent = text;
            preview.className = 'preview-watermark ' + position + ' ' + size;
            preview.style.setProperty('--wm-color', color);
            preview.style.setProperty('--wm-opacity', opacity);
            
            document.getElementById('opacityValue').textContent = opacity;
        }

        document.getElementById('text').addEventListener('input', updatePreview);
        document.getElementById('position').addEventListener('change', updatePreview);
        document.getElementById('size').addEventListener('change', updatePreview);
        document.getElementById('color').addEventListener('change', updatePreview);
        document.getElementById('opacity').addEventListener('input', updatePreview);
        
        document.getElementById('enabled').addEventListener('change', function() {
            var preview = document.getElementById('previewWatermark');
            preview.style.display = this.checked ? 'block' : 'none';
        });
    </script>
</body>
</html>