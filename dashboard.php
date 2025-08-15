<?php 
require_once 'upload.php';
$uploadedFiles = getUploadedFiles();
$userIP = getUserIP();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Free HTML Hosting by Sushil Choudhary</title>
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
            --text-light: #F8F9FA;
            --shadow-color: rgba(255, 107, 53, 0.2);
        }
        
        body {
            background: linear-gradient(135deg, var(--dark-color), var(--darker-color));
            font-family: 'Hind Siliguri', sans-serif;
            min-height: 100vh;
            color: var(--text-light);
        }
        
        .dashboard-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        }
        
        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }
        
        .file-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .file-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .file-card:hover {
            background: rgba(255,255,255,0.1);
            transform: scale(1.02);
        }
        
        .file-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .logo {
            width: 40px;
            height: 40px;
            background: var(--dark-color);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .logo::before {
            content: '{ }';
            color: var(--primary-color);
            font-weight: bold;
            font-size: 16px;
            font-family: 'Courier New', monospace;
        }
        
        .navbar {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
        }
        
        /* Mobile Responsive Design */
        @media (max-width: 992px) {
            .navbar-toggler {
                border: none;
                background: rgba(255,255,255,0.1);
            }
            
            .file-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 2rem 1rem;
                margin: 1rem;
                border-radius: 20px;
            }
            
            .display-4 {
                font-size: 2.2rem;
                line-height: 1.2;
            }
            
            .file-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .file-card {
                padding: 1rem;
                margin-bottom: 1rem;
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
            
            .stats-card {
                margin-bottom: 1.5rem;
                padding: 1.5rem;
            }
            
            .action-buttons .d-flex {
                flex-direction: column;
                gap: 0.5rem;
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
            
            .display-4 {
                font-size: 1.8rem;
                margin-bottom: 1rem;
            }
            
            .file-card {
                padding: 1rem;
            }
            
            .btn-action {
                width: 35px;
                height: 35px;
                font-size: 0.8rem;
                margin: 2px;
            }
            
            .logo {
                width: 80px !important;
                height: 80px !important;
            }
            
            .navbar-brand span {
                font-size: 1rem;
            }
            
            .file-name {
                font-size: 0.9rem;
            }
            
            .file-size {
                font-size: 0.8rem;
            }
            
            footer .row {
                text-align: center;
            }
            
            footer .col-md-6 {
                margin-bottom: 2rem;
            }
        }

        @media (max-width: 400px) {
            .display-4 {
                font-size: 1.6rem;
            }
            
            .hero-section {
                padding: 1rem 0.5rem;
            }
            
            .file-card {
                padding: 0.8rem;
                font-size: 0.9rem;
            }
            
            .navbar-brand span {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="index.php">
                <div class="logo"></div>
                <span style="color: var(--light-color); font-weight: bold;">File Dashboard</span>
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link me-3" href="index.php" style="color: var(--text-light);">
                    <i class="fas fa-home me-2"></i>Home
                </a>
                <a class="nav-link me-3" href="analytics.php" style="color: var(--text-light);">
                    <i class="fas fa-chart-line me-2"></i>Analytics
                </a>
                <div class="nav-link" style="color: var(--secondary-color);">
                    <i class="fas fa-user-circle me-2"></i><?php echo htmlspecialchars($userIP); ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <!-- Quick Stats -->
        <div class="row mb-5">
            <div class="col-md-4 mb-3">
                <div class="dashboard-card p-4 text-center">
                    <i class="fas fa-files" style="font-size: 3rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
                    <h3 style="color: var(--secondary-color);"><?php echo count($uploadedFiles); ?></h3>
                    <p style="color: var(--text-light); opacity: 0.8; margin-bottom: 0;">Total Files</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="dashboard-card p-4 text-center">
                    <i class="fas fa-link" style="font-size: 3rem; color: var(--secondary-color); margin-bottom: 1rem;"></i>
                    <h3 style="color: var(--secondary-color);"><?php echo count(array_filter($uploadedFiles, function($f) { return pathinfo($f['name'], PATHINFO_EXTENSION) === 'html'; })); ?></h3>
                    <p style="color: var(--text-light); opacity: 0.8; margin-bottom: 0;">Live Websites</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="dashboard-card p-4 text-center">
                    <i class="fas fa-clock" style="font-size: 3rem; color: var(--accent-color); margin-bottom: 1rem;"></i>
                    <h3 style="color: var(--secondary-color);">24/7</h3>
                    <p style="color: var(--text-light); opacity: 0.8; margin-bottom: 0;">Online</p>
                </div>
            </div>
        </div>

        <!-- File Management -->
        <div class="dashboard-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 style="color: var(--text-light);">
                    <i class="fas fa-folder-open me-2" style="color: var(--primary-color);"></i>
                    Your Files
                </h4>
                <div>
                    <button class="btn btn-sm me-2" style="background: var(--primary-color); color: white;" onclick="location.href='index.php'">
                        <i class="fas fa-plus me-2"></i>Upload New
                    </button>
                    <button class="btn btn-sm" style="background: var(--secondary-color); color: var(--dark-color);" onclick="refreshPage()">
                        <i class="fas fa-refresh me-2"></i>Refresh
                    </button>
                </div>
            </div>

            <?php if (empty($uploadedFiles)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 4rem; color: var(--primary-color); margin-bottom: 2rem;"></i>
                    <h5 style="color: var(--text-light);">No files uploaded yet</h5>
                    <p style="color: var(--text-light); opacity: 0.7;">Upload your first file to get started</p>
                    <a href="index.php" class="btn btn-lg" style="background: var(--primary-color); color: white;">
                        <i class="fas fa-upload me-2"></i>Upload Files
                    </a>
                </div>
            <?php else: ?>
                <div class="file-grid">
                    <?php foreach ($uploadedFiles as $file): ?>
                        <div class="file-card" onclick="openFileOptions('<?php echo htmlspecialchars($file['name']); ?>', '<?php echo htmlspecialchars($file['url']); ?>')">
                            <div class="text-center">
                                <i class="<?php echo getFileIcon(strtolower(pathinfo($file['name'], PATHINFO_EXTENSION))); ?> file-icon" 
                                   style="color: var(--primary-color);"></i>
                                <h6 style="color: var(--text-light); margin-bottom: 10px;" title="<?php echo htmlspecialchars($file['name']); ?>">
                                    <?php echo strlen($file['name']) > 20 ? substr($file['name'], 0, 20) . '...' : $file['name']; ?>
                                </h6>
                                <small style="color: var(--text-light); opacity: 0.7;">
                                    <?php echo formatFileSize($file['size']); ?> • 
                                    <?php echo date('M j, Y', $file['upload_time']); ?>
                                </small>
                                <div class="mt-3">
                                    <span class="badge" style="background: var(--secondary-color); color: var(--dark-color);">
                                        <?php echo strtoupper(pathinfo($file['name'], PATHINFO_EXTENSION)); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Made by Section -->
        <div class="dashboard-card p-4 text-center">
            <h5 style="color: var(--text-light); margin-bottom: 1rem;">
                <i class="fas fa-heart me-2" style="color: var(--primary-color);"></i>
                Made with Love by Sushil Choudhary
            </h5>
            <p style="color: var(--text-light); opacity: 0.8; margin-bottom: 2rem;">
                Free HTML hosting solution - No limits, no ads, just pure hosting!
            </p>
            <div class="row">
                <div class="col-md-3 mb-2">
                    <small style="color: var(--success-color);">✓ Instant hosting</small>
                </div>
                <div class="col-md-3 mb-2">
                    <small style="color: var(--success-color);">✓ Online editor</small>
                </div>
                <div class="col-md-3 mb-2">
                    <small style="color: var(--success-color);">✓ Free forever</small>
                </div>
                <div class="col-md-3 mb-2">
                    <small style="color: var(--success-color);">✓ No registration</small>
                </div>
            </div>
        </div>
    </div>

    <!-- File Options Modal -->
    <div class="modal fade" id="fileOptionsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="background: var(--dark-color); border: 1px solid rgba(255,255,255,0.2);">
                <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.2);">
                    <h5 class="modal-title" style="color: var(--text-light);">File Options</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-light" onclick="openFile()">
                            <i class="fas fa-external-link-alt me-2"></i>Open File
                        </button>
                        <button class="btn btn-outline-light" onclick="copyLink()">
                            <i class="fas fa-copy me-2"></i>Copy Link
                        </button>
                        <button class="btn btn-outline-light" onclick="editFile()">
                            <i class="fas fa-edit me-2"></i>Edit File
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentFile = '';
        let currentUrl = '';

        function openFileOptions(fileName, fileUrl) {
            currentFile = fileName;
            currentUrl = fileUrl;
            const modal = new bootstrap.Modal(document.getElementById('fileOptionsModal'));
            modal.show();
        }

        function openFile() {
            window.open(currentUrl, '_blank');
            bootstrap.Modal.getInstance(document.getElementById('fileOptionsModal')).hide();
        }

        function copyLink() {
            navigator.clipboard.writeText(currentUrl).then(() => {
                alert('Link copied to clipboard!');
            });
            bootstrap.Modal.getInstance(document.getElementById('fileOptionsModal')).hide();
        }

        function editFile() {
            window.location.href = `edit.php?file=${encodeURIComponent(currentFile)}`;
        }

        function refreshPage() {
            location.reload();
        }
    </script>
</body>
</html>