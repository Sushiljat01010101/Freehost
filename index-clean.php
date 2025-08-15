<?php 
require_once 'upload-clean.php';
$uploadedFiles = getUploadedFiles();
$userIP = getClientIP();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Free HTML Hosting - Made with ❤️ by Sushil Choudhary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #FF6B35;
            --secondary-color: #FFD23F;
            --accent-color: #F4A261;
            --dark-color: #2B1B17;
            --darker-color: #1A0E0A;
            --light-color: #FFFFFF;
            --success-color: #27AE60;
            --danger-color: #E74C3C;
            --text-light: #F8F9FA;
            --shadow-color: rgba(255, 107, 53, 0.2);
        }
        
        body {
            background: linear-gradient(135deg, var(--dark-color), var(--darker-color));
            font-family: 'Hind Siliguri', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: var(--text-light);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--dark-color);
            padding: 4rem 0;
            border-radius: 0 0 30px 30px;
            margin-bottom: 3rem;
            box-shadow: 0 8px 25px var(--shadow-color);
            position: relative;
            overflow: hidden;
        }
        
        .upload-card {
            border: 1px solid rgba(255, 107, 53, 0.3);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .upload-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(255, 107, 53, 0.2);
            border-color: var(--primary-color);
        }
        
        .drag-drop-area {
            border: 3px dashed var(--primary-color);
            border-radius: 15px;
            padding: 3rem;
            text-align: center;
            background: rgba(255, 107, 53, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .drag-drop-area:hover, .drag-drop-area.drag-over {
            background: rgba(255, 107, 53, 0.2);
            border-color: var(--secondary-color);
            transform: scale(1.02);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
        }
        
        .file-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .file-item:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        .stats-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .stats-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-5px);
        }
        
        .navbar {
            background: rgba(43, 27, 23, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 107, 53, 0.2);
        }
        
        .navbar-nav .nav-link {
            transition: all 0.3s ease;
            margin: 0 0.5rem;
            border-radius: 10px;
            padding: 0.5rem 1rem !important;
        }
        
        .navbar-nav .nav-link:hover {
            background: rgba(255, 107, 53, 0.2);
            transform: translateY(-1px);
        }
        
        .footer {
            background: rgba(26, 14, 10, 0.95);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255, 107, 53, 0.2);
            margin-top: auto;
            padding: 2rem 0;
        }
        
        .alert-success {
            background: rgba(39, 174, 96, 0.2);
            border: 1px solid rgba(39, 174, 96, 0.3);
            color: var(--success-color);
            backdrop-filter: blur(5px);
        }
        
        .alert-danger {
            background: rgba(231, 76, 60, 0.2);
            border: 1px solid rgba(231, 76, 60, 0.3);
            color: var(--danger-color);
            backdrop-filter: blur(5px);
        }
        
        .progress {
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        
        .progress-bar {
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-radius: 10px;
        }
        
        @media (max-width: 768px) {
            .hero-section {
                padding: 2rem 0;
                margin-bottom: 2rem;
            }
            
            .drag-drop-area {
                padding: 2rem 1rem;
            }
            
            .upload-card {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand animate__animated animate__fadeInLeft" href="#" style="font-size: 1.5rem;">
                <i class="fas fa-rocket me-2" style="color: var(--secondary-color);"></i>
                <span>Free HTML Hosting</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="watermark-clean.php" style="color: var(--text-light);">
                            <i class="fas fa-paint-brush me-1" style="color: var(--secondary-color);"></i>Watermark
                        </a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <i class="fas fa-user me-1"></i>IP: <?php echo htmlspecialchars($userIP); ?>
                </span>
            </div>
        </div>
    </nav>

    <main style="margin-top: 76px;">
        <!-- Hero Section -->
        <section class="hero-section animate__animated animate__fadeIn">
            <div class="container text-center">
                <h1 class="display-4 fw-bold mb-3 animate__animated animate__fadeInUp">
                    🚀 Free HTML Hosting Platform
                </h1>
                <p class="lead mb-4 animate__animated animate__fadeInUp animate__delay-1s">
                    Upload kare, Host kare, Share kare - Bilkul FREE!
                </p>
                <div class="animate__animated animate__fadeInUp animate__delay-2s">
                    <span class="badge bg-light text-dark me-2 p-2">HTML</span>
                    <span class="badge bg-light text-dark me-2 p-2">CSS</span>
                    <span class="badge bg-light text-dark me-2 p-2">JavaScript</span>
                    <span class="badge bg-light text-dark me-2 p-2">ZIP Folders</span>
                </div>
            </div>
        </section>

        <div class="container">
            <!-- Alert Messages -->
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo htmlspecialchars($_GET['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php echo htmlspecialchars($_GET['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="upload-card h-100" style="cursor: pointer;" onclick="document.getElementById('fileInput').click()">
                        <div class="card-body text-center">
                            <i class="fas fa-plus-circle" style="font-size: 2rem; color: var(--primary-color);"></i>
                            <h5 class="mt-2" style="color: var(--text-light);">Quick Upload</h5>
                            <small style="color: var(--text-light); opacity: 0.8;">Files या ZIP folders</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="upload-card h-100" style="cursor: pointer;" onclick="location.href='watermark-clean.php'">
                        <div class="card-body text-center">
                            <i class="fas fa-paint-brush" style="font-size: 2rem; color: var(--secondary-color);"></i>
                            <h5 class="mt-2" style="color: var(--text-light);">Watermark Settings</h5>
                            <small style="color: var(--text-light); opacity: 0.8;">Customize branding</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="upload-card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-line" style="font-size: 2rem; color: var(--success-color);"></i>
                            <h5 class="mt-2" style="color: var(--text-light);">Total Files</h5>
                            <h3 style="color: var(--primary-color);"><?php echo count($uploadedFiles); ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="upload-card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-server" style="font-size: 2rem; color: var(--accent-color);"></i>
                            <h5 class="mt-2" style="color: var(--text-light);">Status</h5>
                            <span class="badge bg-success">Online</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Section -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="upload-card mb-4">
                        <div class="card-header border-0" style="background: rgba(255, 107, 53, 0.1);">
                            <h4 class="mb-0" style="color: var(--text-light);">
                                <i class="fas fa-cloud-upload-alt me-2" style="color: var(--primary-color);"></i>
                                File Upload
                            </h4>
                        </div>
                        <div class="card-body">
                            <form id="uploadForm" method="post" enctype="multipart/form-data">
                                <div class="drag-drop-area" id="dragDropArea">
                                    <i class="fas fa-cloud-upload-alt fa-3x mb-3" style="color: var(--primary-color);"></i>
                                    <h5 style="color: var(--text-light);">Drag & Drop Files Here</h5>
                                    <p style="color: var(--text-light); opacity: 0.8;">या click करके select करें</p>
                                    <input type="file" id="fileInput" name="file" style="display: none;" 
                                           accept=".html,.css,.js,.txt,.zip">
                                    <div class="mt-3">
                                        <button type="button" class="btn btn-primary" onclick="document.getElementById('fileInput').click()">
                                            <i class="fas fa-folder-open me-2"></i>Choose File
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="progress mt-3" id="uploadProgress" style="display: none;">
                                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="col-lg-4">
                    <div class="stats-card mb-4">
                        <h5 style="color: var(--text-light);">
                            <i class="fas fa-info-circle me-2" style="color: var(--secondary-color);"></i>
                            Platform Info
                        </h5>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span style="color: var(--text-light);">Max File Size:</span>
                                <strong style="color: var(--primary-color);">5MB</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span style="color: var(--text-light);">Supported:</span>
                                <strong style="color: var(--success-color);">HTML, CSS, JS, TXT, ZIP</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span style="color: var(--text-light);">Watermark:</span>
                                <strong style="color: var(--secondary-color);">Auto Added</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Uploaded Files -->
            <?php if (!empty($uploadedFiles)): ?>
            <div class="upload-card">
                <div class="card-header border-0" style="background: rgba(255, 107, 53, 0.1);">
                    <h4 class="mb-0" style="color: var(--text-light);">
                        <i class="fas fa-files-o me-2" style="color: var(--primary-color);"></i>
                        Uploaded Files (<?php echo count($uploadedFiles); ?>)
                    </h4>
                </div>
                <div class="card-body">
                    <?php foreach ($uploadedFiles as $file): ?>
                        <div class="file-item">
                            <div class="d-flex justify-content-between align-items-start flex-wrap">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1" style="color: var(--text-light);">
                                        <i class="<?php echo getIcon($file['extension']); ?> me-2" 
                                           style="color: var(--primary-color);"></i>
                                        <?php echo htmlspecialchars($file['name']); ?>
                                    </h6>
                                    <small style="color: var(--text-light); opacity: 0.8;">
                                        Size: <?php echo formatBytes($file['size']); ?> | 
                                        Uploaded: <?php echo date('d M Y, H:i', $file['upload_time']); ?>
                                        <?php if (isset($file['watermarked']) && $file['watermarked']): ?>
                                            | <span style="color: var(--secondary-color);">
                                                <i class="fas fa-paint-brush"></i> Watermarked
                                            </span>
                                        <?php endif; ?>
                                    </small>
                                </div>
                                <div class="btn-group mt-2 mt-md-0">
                                    <?php if (isset($file['is_folder']) && $file['is_folder'] && $file['index_url']): ?>
                                        <a href="<?php echo htmlspecialchars($file['index_url']); ?>" 
                                           class="btn btn-sm btn-primary" target="_blank">
                                            <i class="fas fa-external-link-alt"></i> Website
                                        </a>
                                    <?php else: ?>
                                        <a href="<?php echo htmlspecialchars($file['public_url']); ?>" 
                                           class="btn btn-sm btn-primary" target="_blank">
                                            <i class="fas fa-external-link-alt"></i> View
                                        </a>
                                    <?php endif; ?>
                                    
                                    <button class="btn btn-sm btn-outline-light" 
                                            onclick="copyToClipboard('<?php echo htmlspecialchars($file['public_url']); ?>')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                    
                                    <a href="?action=delete&file=<?php echo urlencode($file['unique_name']); ?>" 
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Delete this file?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h5 style="color: var(--primary-color);">Free HTML Hosting Platform</h5>
                    <p style="color: var(--text-light); opacity: 0.8;">
                        Made with ❤️ by <strong>Sushil Choudhary</strong> - 
                        InfinityFree compatible PHP hosting solution
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="social-links">
                        <a href="#" class="text-decoration-none me-3" style="color: var(--secondary-color);">
                            <i class="fab fa-github fa-lg"></i>
                        </a>
                        <a href="#" class="text-decoration-none me-3" style="color: var(--secondary-color);">
                            <i class="fab fa-linkedin fa-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // File upload handling
        const fileInput = document.getElementById('fileInput');
        const dragDropArea = document.getElementById('dragDropArea');
        const uploadForm = document.getElementById('uploadForm');
        const uploadProgress = document.getElementById('uploadProgress');

        // Drag and drop
        dragDropArea.addEventListener('click', () => fileInput.click());
        dragDropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dragDropArea.classList.add('drag-over');
        });
        dragDropArea.addEventListener('dragleave', () => {
            dragDropArea.classList.remove('drag-over');
        });
        dragDropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dragDropArea.classList.remove('drag-over');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                uploadFile();
            }
        });

        fileInput.addEventListener('change', uploadFile);

        function uploadFile() {
            const file = fileInput.files[0];
            if (!file) return;

            const formData = new FormData(uploadForm);
            uploadProgress.style.display = 'block';

            fetch('upload-clean.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'index-clean.php?success=' + encodeURIComponent(data.message);
                } else {
                    window.location.href = 'index-clean.php?error=' + encodeURIComponent(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                window.location.href = 'index-clean.php?error=Upload failed';
            })
            .finally(() => {
                uploadProgress.style.display = 'none';
                fileInput.value = '';
            });
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                const toast = document.createElement('div');
                toast.className = 'toast align-items-center text-white bg-success border-0 position-fixed';
                toast.style.top = '20px';
                toast.style.right = '20px';
                toast.style.zIndex = '9999';
                toast.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-check me-2"></i>URL copied to clipboard!
                        </div>
                    </div>
                `;
                document.body.appendChild(toast);
                const bsToast = new bootstrap.Toast(toast);
                bsToast.show();
                setTimeout(() => document.body.removeChild(toast), 3000);
            });
        }
    </script>
</body>
</html>