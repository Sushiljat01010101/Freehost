<?php 
require_once 'upload.php';

// Get file to edit
$fileToEdit = $_GET['file'] ?? '';
$fileContent = '';
$fileName = '';
$fileExtension = '';

if ($fileToEdit && isset($_SESSION['uploaded_files'])) {
    foreach ($_SESSION['uploaded_files'] as $file) {
        if ($file['unique_name'] === $fileToEdit) {
            if (file_exists($file['path'])) {
                $fileContent = file_get_contents($file['path']);
                $fileName = $file['name'];
                $fileExtension = $file['extension'];
            }
            break;
        }
    }
}

if (!$fileName) {
    header('Location: index.php?error=File not found');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit <?php echo htmlspecialchars($fileName); ?> - NewtonNexus</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- CodeMirror CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/theme/monokai.min.css">
    <!-- Siliguri Font -->
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #FF6B35;
            --secondary-color: #FFD23F;
            --accent-color: #FFA726;
            --dark-color: #1a1a2e;
            --darker-color: #16213e;
            --light-color: #f8f9fa;
            --text-light: #ffffff;
            --text-dark: #2c3e50;
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Hind Siliguri', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--dark-color) 0%, var(--darker-color) 100%);
            min-height: 100vh;
            color: var(--text-light);
            overflow-x: hidden;
            position: relative;
        }
        
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(135deg, var(--dark-color), var(--darker-color));
        }
        
        .animated-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 25% 25%, var(--primary-color) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, var(--secondary-color) 0%, transparent 50%);
            opacity: 0.1;
            animation: float 20s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(1deg); }
            66% { transform: translateY(10px) rotate(-1deg); }
        }
        
        .logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 12px;
            position: relative;
            box-shadow: 0 8px 16px rgba(255, 107, 53, 0.3);
        }
        
        .logo::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            box-shadow: inset 0 0 10px rgba(0,0,0,0.2);
        }
        
        .logo::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
        }
        
        .navbar {
            background: var(--glass-bg) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--text-light) !important;
            text-decoration: none;
        }
        
        .nav-link {
            color: var(--text-light) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 25px;
            padding: 0.5rem 1.5rem !important;
            margin: 0 0.25rem;
        }
        
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }
        
        .hero-section {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 25px;
            color: var(--text-light);
            padding: 2rem;
            margin: 2rem 0;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .editor-container {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .editor-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--text-light);
            padding: 1rem 1.5rem;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .editor-body {
            padding: 0;
        }
        
        .CodeMirror {
            height: 500px;
            font-size: 14px;
            font-family: 'Monaco', 'Consolas', monospace;
            background: rgba(0,0,0,0.8) !important;
        }
        
        .CodeMirror-gutters {
            background: rgba(0,0,0,0.9) !important;
            border-right: 1px solid rgba(255,255,255,0.1);
        }
        
        .btn-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 25px;
            padding: 0.7rem 2rem;
            font-weight: 600;
            color: var(--text-light);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 8px 16px rgba(255, 107, 53, 0.3);
        }
        
        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(255, 107, 53, 0.4);
            color: var(--text-light);
        }
        
        .btn-outline-custom {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 25px;
            padding: 0.7rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-outline-custom:hover {
            background: var(--primary-color);
            color: var(--text-light);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(255, 107, 53, 0.3);
        }
        
        .file-info {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            padding: 1.5rem;
            border-radius: 20px;
            margin-bottom: 1.5rem;
            color: var(--text-light);
        }
        
        .form-control {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 15px;
            color: var(--text-light);
            padding: 12px 20px;
        }
        
        .form-control:focus {
            background: rgba(255,255,255,0.15);
            border-color: var(--primary-color);
            color: var(--text-light);
            box-shadow: 0 0 20px rgba(255, 107, 53, 0.3);
        }
        
        .form-control::placeholder {
            color: rgba(248, 249, 250, 0.6);
        }
        
        .stats-badge {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 8px 16px;
            color: var(--text-light);
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .alert {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            color: var(--text-light);
        }
        
        .alert-success {
            border-color: rgba(0, 184, 148, 0.5);
            background: rgba(0, 184, 148, 0.1);
        }
        
        /* Mobile Responsive Design */
        @media (max-width: 992px) {
            .navbar-toggler {
                border: none;
                background: rgba(255,255,255,0.1);
            }
            
            .CodeMirror {
                height: 350px;
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 2rem 1rem;
                margin: 1rem;
                border-radius: 20px;
            }
            
            .display-6 {
                font-size: 2rem;
                line-height: 1.2;
            }
            
            .CodeMirror {
                height: 300px;
            }
            
            .editor-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
                padding: 1rem;
            }
            
            .navbar-collapse {
                background: rgba(0,0,0,0.8);
                border-radius: 15px;
                padding: 1rem;
                margin-top: 1rem;
            }
            
            .navbar-nav {
                text-align: center;
            }
            
            .btn-custom {
                width: 100%;
                margin-bottom: 0.5rem;
                font-size: 0.9rem;
            }
            
            .file-info {
                margin-bottom: 1.5rem;
                padding: 1rem;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding: 0 15px;
            }
            
            .hero-section {
                padding: 1.5rem 1rem;
                margin: 0.5rem;
            }
            
            .display-6 {
                font-size: 1.8rem;
                margin-bottom: 1rem;
            }
            
            .CodeMirror {
                height: 250px;
            }
            
            .editor-container {
                margin-bottom: 1.5rem;
            }
            
            .logo {
                width: 80px !important;
                height: 80px !important;
            }
            
            .navbar-brand span {
                font-size: 1rem;
            }
            
            .form-control {
                font-size: 0.9rem;
            }
            
            .stats-badge {
                font-size: 0.8rem;
                padding: 6px 12px;
            }
            
            footer .row {
                text-align: center;
            }
            
            footer .col-md-6 {
                margin-bottom: 2rem;
            }
        }

        @media (max-width: 400px) {
            .display-6 {
                font-size: 1.6rem;
            }
            
            .hero-section {
                padding: 1rem 0.5rem;
            }
            
            .CodeMirror {
                height: 200px;
            }
            
            .editor-header {
                padding: 0.8rem;
                font-size: 0.9rem;
            }
            
            .file-info {
                padding: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="animated-bg"></div>
    
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="index.php">
                <div class="logo"></div>
                <span style="color: var(--light-color); font-weight: bold;">Code Editor</span>
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php" style="color: var(--text-light);">
                    <i class="fas fa-arrow-left me-2"></i>Back to Files
                </a>
                <div class="stats-badge ms-3">
                    <i class="fas fa-file-code me-2"></i><?php echo htmlspecialchars($fileName); ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container">
        <div class="hero-section animate__animated animate__fadeIn">
            <div class="container text-center">
                <h1 class="display-6 mb-3 animate__animated animate__fadeInDown">
                    <i class="<?php echo getFileIcon($fileExtension); ?> me-2" style="color: var(--secondary-color);"></i>Edit File
                </h1>
                <p class="lead animate__animated animate__fadeInUp">
                    Edit करें, save करें और instantly deploy करें - <?php echo htmlspecialchars($fileName); ?>
                </p>
            </div>
        </div>
    </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container mb-5">
        <form method="POST" action="upload.php" id="editForm">
            <input type="hidden" name="save_file" value="1">
            <input type="hidden" name="file_name" value="<?php echo htmlspecialchars($fileToEdit); ?>">
            
            <div class="row">
                <div class="col-lg-8">
                    <!-- Code Editor -->
                    <div class="card editor-container animate__animated animate__fadeInLeft">
                        <div class="editor-header">
                            <div>
                                <i class="fas fa-code me-2"></i>
                                <strong><?php echo htmlspecialchars($fileName); ?></strong>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-success btn-sm btn-custom me-2">
                                    <i class="fas fa-save me-1"></i>Save File
                                </button>
                                <?php if ($fileExtension === 'html'): ?>
                                <button type="button" class="btn btn-info btn-sm btn-custom" onclick="updatePreview()">
                                    <i class="fas fa-eye me-1"></i>Preview
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="editor-body">
                            <textarea name="file_content" id="code-editor" class="form-control"><?php echo htmlspecialchars($fileContent); ?></textarea>
                        </div>
                    </div>
                </div>
                
                <?php if ($fileExtension === 'html'): ?>
                <div class="col-lg-4">
                    <!-- Live Preview -->
                    <div class="card animate__animated animate__fadeInRight animate__delay-1s">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-browser me-2"></i>Live Preview
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <iframe id="preview-frame" class="preview-container w-100" style="border: none; min-height: 400px;"></iframe>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer style="background: linear-gradient(135deg, var(--darker-color), var(--dark-color)); margin-top: 4rem; padding: 3rem 0;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <div class="logo me-3" style="width: 50px; height: 50px;"></div>
                        <div>
                            <h4 style="color: var(--text-light); margin: 0;">Free HTML Hosting</h4>
                            <small style="color: var(--secondary-color);">Made with ❤️ by Sushil Choudhary</small>
                        </div>
                    </div>
                    <p style="color: var(--text-light); opacity: 0.8;">
                        Code Editor - Edit करें, save करें और instantly deploy करें।
                    </p>
                </div>
                <div class="col-md-6 text-center">
                    <h6 style="color: var(--secondary-color); margin-bottom: 1rem;">Need more tools?</h6>
                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                        <a href="html-editor.php" class="btn btn-custom">
                            <i class="fas fa-code me-2"></i>HTML Editor
                        </a>
                        <a href="analytics.php" class="btn btn-outline-custom">
                            <i class="fas fa-chart-bar me-2"></i>Analytics
                        </a>
                    </div>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.2); margin: 2rem 0;">
            <div class="text-center">
                <p style="color: var(--text-light); opacity: 0.6; margin: 0;">
                    © 2025 Free HTML Hosting by Sushil Choudhary. Made with passion for developers.
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CodeMirror JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/htmlmixed/htmlmixed.min.js"></script>

    <script>
        // Initialize CodeMirror
        const fileExtension = '<?php echo $fileExtension; ?>';
        let mode = 'text/plain';
        
        switch(fileExtension) {
            case 'html':
                mode = 'text/html';
                break;
            case 'css':
                mode = 'text/css';
                break;
            case 'js':
                mode = 'text/javascript';
                break;
        }
        
        const editor = CodeMirror.fromTextArea(document.getElementById('code-editor'), {
            lineNumbers: true,
            theme: 'monokai',
            mode: mode,
            indentUnit: 2,
            smartIndent: true,
            tabSize: 2,
            electricChars: true,
            autoCloseBrackets: true,
            matchBrackets: true,
            lineWrapping: true
        });

        // Auto-save functionality
        let saveTimeout;
        editor.on('change', function() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(function() {
                // Auto-save could be implemented here
                console.log('Changes detected...');
            }, 2000);
        });

        // Live preview for HTML files
        <?php if ($fileExtension === 'html'): ?>
        function updatePreview() {
            const content = editor.getValue();
            const previewFrame = document.getElementById('preview-frame');
            const blob = new Blob([content], { type: 'text/html' });
            const url = URL.createObjectURL(blob);
            previewFrame.src = url;
        }
        
        // Update preview on load
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(updatePreview, 1000);
        });
        
        // Auto-update preview on changes
        editor.on('change', function() {
            clearTimeout(window.previewTimeout);
            window.previewTimeout = setTimeout(updatePreview, 1000);
        });
        <?php endif; ?>

        // Form submission
        document.getElementById('editForm').addEventListener('submit', function(e) {
            // Update textarea with editor content before submit
            editor.save();
            
            // Show saving indicator
            const saveBtn = document.querySelector('button[type="submit"]');
            const originalText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Saving...';
            saveBtn.disabled = true;
            
            // Re-enable after a delay (form will submit)
            setTimeout(function() {
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
            }, 2000);
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl+S to save
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                document.getElementById('editForm').submit();
            }
            
            // Ctrl+P for preview (HTML files only)
            <?php if ($fileExtension === 'html'): ?>
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                updatePreview();
            }
            <?php endif; ?>
        });
    </script>
</body>
</html>