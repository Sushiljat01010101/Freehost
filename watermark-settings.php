<?php
session_start();

// Watermark configuration
$watermarkConfig = [
    'enabled' => true,
    'text' => '⚡ Free Hosting',
    'link' => 'https://your-app.onrender.com',
    'position' => 'bottom-right',
    'color' => '#FF6B35',
    'opacity' => 0.9,
    'size' => 'small'
];

// Handle settings update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_watermark'])) {
    $watermarkConfig['enabled'] = isset($_POST['enabled']);
    $watermarkConfig['text'] = $_POST['text'] ?? '⚡ Free Hosting';
    $watermarkConfig['link'] = $_POST['link'] ?? 'https://free-html-hosting.replit.app';
    $watermarkConfig['position'] = $_POST['position'] ?? 'bottom-right';
    $watermarkConfig['color'] = $_POST['color'] ?? '#FF6B35';
    $watermarkConfig['opacity'] = (float)($_POST['opacity'] ?? 0.9);
    $watermarkConfig['size'] = $_POST['size'] ?? 'small';
    
    // Save to session (in production, save to database)
    $_SESSION['watermark_config'] = $watermarkConfig;
    $success = "Watermark settings updated successfully!";
}

// Load settings from session if available
if (isset($_SESSION['watermark_config'])) {
    $watermarkConfig = $_SESSION['watermark_config'];
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
        
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #FF6B35 0%, #FFD23F 100%);
            border: none;
            border-radius: 15px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.3);
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
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 999999;
            transition: all 0.3s ease;
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
                                    <input class="form-check-input" type="checkbox" id="enabled" name="enabled" <?php echo $watermarkConfig['enabled'] ? 'checked' : ''; ?>>
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
                                       value="<?php echo htmlspecialchars($watermarkConfig['text']); ?>" 
                                       placeholder="⚡ Free Hosting">
                            </div>

                            <div class="col-md-6">
                                <label for="link" class="form-label text-white">
                                    <i class="fas fa-link me-2"></i>Watermark Link
                                </label>
                                <input type="url" class="form-control" id="link" name="link" 
                                       value="<?php echo htmlspecialchars($watermarkConfig['link']); ?>" 
                                       placeholder="https://your-website.com">
                            </div>

                            <div class="col-md-6">
                                <label for="position" class="form-label text-white">
                                    <i class="fas fa-arrows-alt me-2"></i>Position
                                </label>
                                <select class="form-select" id="position" name="position">
                                    <option value="bottom-right" <?php echo $watermarkConfig['position'] === 'bottom-right' ? 'selected' : ''; ?>>Bottom Right</option>
                                    <option value="bottom-left" <?php echo $watermarkConfig['position'] === 'bottom-left' ? 'selected' : ''; ?>>Bottom Left</option>
                                    <option value="top-right" <?php echo $watermarkConfig['position'] === 'top-right' ? 'selected' : ''; ?>>Top Right</option>
                                    <option value="top-left" <?php echo $watermarkConfig['position'] === 'top-left' ? 'selected' : ''; ?>>Top Left</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="size" class="form-label text-white">
                                    <i class="fas fa-expand-arrows-alt me-2"></i>Size
                                </label>
                                <select class="form-select" id="size" name="size">
                                    <option value="small" <?php echo $watermarkConfig['size'] === 'small' ? 'selected' : ''; ?>>Small</option>
                                    <option value="medium" <?php echo $watermarkConfig['size'] === 'medium' ? 'selected' : ''; ?>>Medium</option>
                                    <option value="large" <?php echo $watermarkConfig['size'] === 'large' ? 'selected' : ''; ?>>Large</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="color" class="form-label text-white">
                                    <i class="fas fa-palette me-2"></i>Color
                                </label>
                                <input type="color" class="form-control" id="color" name="color" 
                                       value="<?php echo $watermarkConfig['color']; ?>" style="height: 50px;">
                            </div>

                            <div class="col-md-6">
                                <label for="opacity" class="form-label text-white">
                                    <i class="fas fa-adjust me-2"></i>Opacity: <span id="opacityValue"><?php echo $watermarkConfig['opacity']; ?></span>
                                </label>
                                <input type="range" class="form-range" id="opacity" name="opacity" 
                                       min="0.1" max="1" step="0.1" value="<?php echo $watermarkConfig['opacity']; ?>">
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
                            <div id="previewWatermark" class="preview-watermark <?php echo $watermarkConfig['position'] . ' ' . $watermarkConfig['size']; ?>" 
                                 style="--wm-color: <?php echo $watermarkConfig['color']; ?>; --wm-opacity: <?php echo $watermarkConfig['opacity']; ?>;">
                                <?php echo htmlspecialchars($watermarkConfig['text']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Live preview updates
        function updatePreview() {
            const preview = document.getElementById('previewWatermark');
            const text = document.getElementById('text').value || '⚡ Free Hosting';
            const position = document.getElementById('position').value;
            const size = document.getElementById('size').value;
            const color = document.getElementById('color').value;
            const opacity = document.getElementById('opacity').value;
            
            preview.textContent = text;
            preview.className = `preview-watermark ${position} ${size}`;
            preview.style.setProperty('--wm-color', color);
            preview.style.setProperty('--wm-opacity', opacity);
            
            // Update opacity display
            document.getElementById('opacityValue').textContent = opacity;
        }

        // Add event listeners
        document.getElementById('text').addEventListener('input', updatePreview);
        document.getElementById('position').addEventListener('change', updatePreview);
        document.getElementById('size').addEventListener('change', updatePreview);
        document.getElementById('color').addEventListener('change', updatePreview);
        document.getElementById('opacity').addEventListener('input', updatePreview);
        
        // Enable/disable preview
        document.getElementById('enabled').addEventListener('change', function() {
            const preview = document.getElementById('previewWatermark');
            preview.style.display = this.checked ? 'block' : 'none';
        });
    </script>
</body>
</html>