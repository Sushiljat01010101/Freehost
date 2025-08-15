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
    <title>Free HTML Hosting - Made by ❤️ Sushil Choudhary</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Highlight.js for code editing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/atom-one-dark.min.css">
    <!-- Siliguri Font -->
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #FF6B35;     /* Orange from logo */
            --secondary-color: #FFD23F;   /* Yellow from logo */
            --accent-color: #F4A261;      /* Light orange */
            --dark-color: #2B1B17;        /* Dark background */
            --darker-color: #1A0E0A;      /* Darker shade */
            --light-color: #FFFFFF;       /* White */
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
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><text y="15" font-size="12" font-family="monospace" fill="%23ffffff20">{ } [ ] &lt; &gt;</text></svg>') repeat;
            opacity: 0.1;
        }
        
        .upload-card {
            border: 1px solid rgba(255, 107, 53, 0.3);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-bottom: 2rem;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
            backdrop-filter: blur(10px);
            overflow: hidden;
            position: relative;
        }
        
        .upload-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }
        
        .upload-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0,0,0,0.4);
            border-color: var(--primary-color);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--dark-color);
            font-weight: 700;
            border-bottom: none;
            padding: 1.5rem;
            position: relative;
        }
        
        .card-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
        }
        
        .file-list {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .file-item {
            transition: all 0.3s ease;
            border-left: 4px solid var(--primary-color);
            margin-bottom: 15px;
            border-radius: 12px;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .file-item:hover {
            background: rgba(255, 107, 53, 0.1);
            transform: translateX(10px) scale(1.02);
            border-left-color: var(--secondary-color);
            box-shadow: 0 5px 20px rgba(255, 107, 53, 0.2);
        }
        
        .file-icon {
            font-size: 1.5rem;
            margin-right: 10px;
            color: var(--primary-color);
        }
        
        .loading-spinner {
            display: none;
            width: 3rem;
            height: 3rem;
        }
        
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 2rem 0;
            margin-top: auto;
            font-family: 'Hind Siliguri', sans-serif;
        }
        
        /* Drag and drop area */
        .dropzone {
            border: 2px dashed var(--secondary-color);
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: rgba(162, 155, 254, 0.05);
        }
        
        .dropzone:hover, .dropzone.dragover {
            background: rgba(255, 107, 53, 0.1);
            border-color: var(--primary-color);
            transform: scale(1.02);
        }
        
        /* Logo Styling */
        .logo-container {
            display: inline-flex;
            align-items: center;
            gap: 15px;
        }
        
        .logo {
            width: 50px;
            height: 50px;
            background: var(--dark-color);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        
        .logo::before {
            content: '{ }';
            color: var(--primary-color);
            font-weight: bold;
            font-size: 20px;
            font-family: 'Courier New', monospace;
        }
        
        .logo::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 3px;
            background: var(--secondary-color);
            border-radius: 2px;
        }
        
        /* Advanced Button Styling */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
            background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
        }
        
        /* Stats Cards */
        .stats-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.15);
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: bold;
            color: var(--secondary-color);
        }
        
        /* Animated Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
            overflow: hidden;
        }
        
        .animated-bg::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(255, 107, 53, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 210, 63, 0.1) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translate(0px, 0px) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }
        
        .dropzone i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        /* Action buttons */
        .btn-action {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 5px;
        }
        
        /* Custom buttons */
        .btn-custom {
            font-family: 'Hind Siliguri', sans-serif;
            font-weight: 500;
            letter-spacing: 0.5px;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        /* Hosting link styling */
        .hosting-link .form-control {
            font-size: 11px;
            font-family: 'Courier New', monospace;
            color: #666;
        }
        
        .hosting-link .input-group {
            border-radius: 5px;
        }
        
        .copy-success {
            background-color: var(--success-color) !important;
            color: white !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #5a4bc2;
            border-color: #5a4bc2;
        }
        
        /* Alert customization */
        .alert {
            font-family: 'Hind Siliguri', sans-serif;
            border-radius: 8px;
        }
        
        /* Mobile First Responsive Design */
        @media (max-width: 992px) {
            .navbar-nav .nav-item {
                text-align: center;
                margin: 0.5rem 0;
            }
            
            .hero-section .col-lg-4 {
                margin-top: 2rem;
            }
            
            .logo {
                width: 100px !important;
                height: 100px !important;
            }
            
            .navbar-toggler {
                border: none;
                background: rgba(255,255,255,0.1);
            }
            
            .navbar-toggler:focus {
                box-shadow: none;
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 2rem 1rem;
                margin: 1rem;
                border-radius: 20px;
            }
            
            .display-4 {
                font-size: 2.5rem;
                line-height: 1.2;
            }
            
            .lead {
                font-size: 1.1rem;
            }
            
            .stats-card {
                margin-bottom: 1rem;
                padding: 1.5rem;
            }
            
            .upload-area, .dropzone {
                padding: 2rem 1rem;
                margin: 1rem 0;
            }
            
            .navbar-brand {
                font-size: 1.1rem;
            }
            
            .navbar-nav {
                text-align: center;
                margin-top: 1rem;
            }
            
            .stats-badge {
                display: none;
            }
            
            .quick-action-card {
                margin-bottom: 1.5rem;
                text-align: center;
                padding: 1.5rem;
            }
            
            .quick-action-card h6 {
                font-size: 1rem;
            }
            
            .btn-custom {
                padding: 0.6rem 1.5rem;
                font-size: 0.9rem;
                width: 100%;
                margin-bottom: 0.5rem;
            }
            
            .action-cards .col-md-3 {
                margin-bottom: 1.5rem;
            }
            
            .file-card {
                margin-bottom: 1rem;
            }
            
            .navbar-collapse {
                background: rgba(0,0,0,0.8);
                border-radius: 15px;
                padding: 1rem;
                margin-top: 1rem;
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
                font-size: 2rem;
                margin-bottom: 1rem;
            }
            
            .lead {
                font-size: 1rem;
                margin-bottom: 1.5rem;
            }
            
            .stats-card {
                padding: 1rem;
                margin-bottom: 1rem;
            }
            
            .stats-number {
                font-size: 1.5rem;
            }
            
            .upload-area, .dropzone {
                padding: 1.5rem 1rem;
                margin: 1rem 0;
            }
            
            .dropzone i {
                font-size: 2rem;
            }
            
            .uploaded-files {
                padding: 1rem;
            }
            
            .file-card {
                margin-bottom: 1rem;
                padding: 1rem;
            }
            
            .d-flex.gap-2 {
                flex-direction: column;
                gap: 0.5rem !important;
            }
            
            .logo {
                width: 80px !important;
                height: 80px !important;
            }
            
            .logo-container {
                justify-content: center;
            }
            
            .navbar-brand span {
                font-size: 1rem;
            }
            
            footer .row {
                text-align: center;
            }
            
            footer .col-md-6 {
                margin-bottom: 2rem;
            }
            
            .btn-action {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 400px) {
            .display-4 {
                font-size: 1.8rem;
            }
            
            .hero-section {
                padding: 1rem 0.5rem;
                margin: 0.5rem;
            }
            
            .upload-area, .dropzone {
                padding: 1rem 0.5rem;
            }
            
            .stats-card {
                padding: 0.8rem;
                font-size: 0.9rem;
            }
            
            .stats-number {
                font-size: 1.3rem;
            }
            
            .quick-action-card {
                padding: 1rem;
            }
            
            .file-card {
                padding: 0.8rem;
            }
            
            .navbar-brand span {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-bg"></div>
    
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
        <div class="container">
            <a class="navbar-brand animate__animated animate__fadeIn logo-container" href="index.php">
                <div class="logo"></div>
                <span style="color: var(--light-color); font-weight: bold;">Free HTML Hosting</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="html-editor.php" style="color: var(--text-light);">
                            <i class="fab fa-html5 me-1" style="color: var(--secondary-color);"></i>HTML Editor
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="edit.php" style="color: var(--text-light);">
                            <i class="fas fa-code me-1" style="color: var(--primary-color);"></i>Code Editor
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php" style="color: var(--text-light);">
                            <i class="fas fa-tachometer-alt me-1" style="color: var(--accent-color);"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="templates.php" style="color: var(--text-light);">
                            <i class="fas fa-layer-group me-1" style="color: var(--secondary-color);"></i>Templates
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="help.php" style="color: var(--text-light);">
                            <i class="fas fa-question-circle me-1" style="color: var(--success-color);"></i>Help
                        </a>
                    </li>
                    <li class="nav-item">
                        <div class="stats-card" style="margin: 0; padding: 8px 15px; font-size: 0.9rem;">
                            <i class="fas fa-user-circle me-1" style="color: var(--secondary-color);"></i>
                            <span style="color: var(--text-light);"><?php echo htmlspecialchars($userIP); ?></span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section animate__animated animate__fadeIn">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">
                        Free HTML Hosting
                    </h1>
                    <p class="lead mb-4">
                        Upload, edit और share करें अपनी web files को instantly। 
                        बिल्कुल free hosting solution - Made with ❤️ by Sushil Choudhary
                    </p>
                    <div class="row mt-4">
                        <div class="col-md-4 mb-3">
                            <div class="stats-card">
                                <div class="stats-number"><?php echo count($uploadedFiles); ?></div>
                                <div style="color: var(--text-light);">Files Hosted</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stats-card">
                                <div class="stats-number">∞</div>
                                <div style="color: var(--text-light);">Free Forever</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stats-card">
                                <div class="stats-number">5MB</div>
                                <div style="color: var(--text-light);">Max File Size</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="logo" style="width: 150px; height: 150px; margin: 0 auto; font-size: 4rem;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container mb-5">
        <!-- Success/Error Messages -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?php 
                $message = $_GET['success'];
                if (strpos($message, 'Link: ') !== false) {
                    $parts = explode('Link: ', $message);
                    echo htmlspecialchars($parts[0]);
                    if (isset($parts[1])) {
                        $url = urldecode($parts[1]);
                        echo '<br><strong>Your hosting link:</strong><br>';
                        echo '<div class="input-group mt-2">';
                        echo '<input type="text" class="form-control" value="' . htmlspecialchars($url) . '" readonly id="success-url">';
                        echo '<button class="btn btn-outline-success" type="button" onclick="copyToClipboard(\'success-url\')">';
                        echo '<i class="fas fa-copy"></i></button></div>';
                    }
                } else {
                    echo htmlspecialchars($message);
                }
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i><?php echo htmlspecialchars($_GET['error']); ?>
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
                        <small style="color: var(--text-light); opacity: 0.8;">Click to upload files</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="upload-card h-100" style="cursor: pointer;" onclick="location.href='html-editor.php'">
                    <div class="card-body text-center">
                        <i class="fab fa-html5" style="font-size: 2rem; color: var(--secondary-color);"></i>
                        <h5 class="mt-2" style="color: var(--text-light);">HTML Editor</h5>
                        <small style="color: var(--text-light); opacity: 0.8;">Create new website</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="upload-card h-100" style="cursor: pointer;" onclick="location.href='templates.php'">
                    <div class="card-body text-center">
                        <i class="fas fa-layer-group" style="font-size: 2rem; color: var(--accent-color);"></i>
                        <h5 class="mt-2" style="color: var(--text-light);">Templates</h5>
                        <small style="color: var(--text-light); opacity: 0.8;">Ready-to-use designs</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="upload-card h-100" style="cursor: pointer;" onclick="location.href='analytics.php'">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-line" style="font-size: 2rem; color: var(--success-color);"></i>
                        <h5 class="mt-2" style="color: var(--text-light);">Analytics</h5>
                        <small style="color: var(--text-light); opacity: 0.8;"><?php echo count($uploadedFiles); ?> total files</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advanced Upload Card -->
        <div class="card upload-card animate__animated animate__fadeInUp">
            <div class="card-header">
                <h3 class="card-title mb-0">
                    <i class="fas fa-cloud-upload-alt me-2"></i>Advanced File Upload
                </h3>
                <small style="opacity: 0.8;">Drag & drop multiple files or click to browse</small>
            </div>
            <div class="card-body p-4">
                <div class="dropzone mb-4" id="dropzone">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <h4>Drag & Drop Files Here</h4>
                    <p style="color: var(--text-light); opacity: 0.8;">Support करता है HTML, CSS, JS, TXT files</p>
                    <p class="small" style="color: var(--text-light); opacity: 0.6;">Maximum file size: 5MB | Instant hosting links</p>
                </div>
                
                <form method="POST" enctype="multipart/form-data" id="uploadForm" action="upload.php">
                    <input type="file" name="file" id="fileInput" class="d-none" required accept=".html,.css,.js,.txt" multiple>
                    <div class="row">
                        <div class="col-md-8">
                            <div id="fileInfo" style="color: var(--text-light); opacity: 0.8;">No file selected</div>
                            <div id="fileProgress" class="mt-2" style="display: none;">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <button type="submit" class="btn btn-primary btn-lg" id="uploadBtn">
                                <span id="btnText"><i class="fas fa-upload me-2"></i>Upload Files</span>
                                <div class="spinner-border text-light loading-spinner" role="status" id="loadingSpinner" style="display: none;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </form>
                
                <!-- Upload Tips -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-check-circle me-2" style="color: var(--success-color);"></i>
                            <small style="color: var(--text-light);">Instant hosting links</small>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-check-circle me-2" style="color: var(--success-color);"></i>
                            <small style="color: var(--text-light);">Online editor included</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-check-circle me-2" style="color: var(--success-color);"></i>
                            <small style="color: var(--text-light);">Copy-paste URLs</small>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-check-circle me-2" style="color: var(--success-color);"></i>
                            <small style="color: var(--text-light);">100% free forever</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- File List -->
        <div class="card animate__animated animate__fadeInUp animate__delay-1s">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-folder-open me-2"></i>Your Files
                    </h3>
                    <span class="badge bg-light text-dark">
                        <?php echo count($uploadedFiles); ?> files
                    </span>
                </div>
            </div>
            <div class="card-body p-4">
                <?php if (empty($uploadedFiles)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i>
                        <p class="text-muted">No files uploaded yet. Upload your first file above!</p>
                    </div>
                <?php else: ?>
                    <div class="file-list">
                        <?php foreach ($uploadedFiles as $index => $file): ?>
                            <div class="file-item p-3 mb-3 border border-light bg-light animate__animated animate__fadeInRight" style="animation-delay: <?php echo $index * 0.1; ?>s">
                                <div class="row align-items-center">
                                    <div class="col-md-5">
                                        <div class="d-flex align-items-center">
                                            <i class="file-icon <?php echo getFileIcon($file['extension']); ?>"></i>
                                            <div>
                                                <h6 class="mb-0"><?php echo htmlspecialchars($file['name']); ?></h6>
                                                <small class="text-muted">
                                                    <?php echo formatFileSize($file['size']); ?> • 
                                                    <?php echo date('M d, Y H:i', $file['upload_time']); ?>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <?php if (isset($file['public_url'])): ?>
                                            <div class="hosting-link">
                                                <small class="text-muted d-block">Hosting Link:</small>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control form-control-sm" 
                                                           value="<?php echo htmlspecialchars($file['public_url']); ?>" 
                                                           readonly id="url-<?php echo $index; ?>">
                                                    <button class="btn btn-outline-primary btn-sm" type="button" 
                                                            onclick="copyToClipboard('url-<?php echo $index; ?>')"
                                                            data-bs-toggle="tooltip" title="Copy Link">
                                                        <i class="fas fa-copy"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo htmlspecialchars($file['public_url'] ?? $file['path']); ?>" 
                                               class="btn btn-success btn-action" target="_blank" 
                                               data-bs-toggle="tooltip" title="View File">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="upload.php?action=edit&file=<?php echo urlencode($file['unique_name']); ?>" 
                                               class="btn btn-primary btn-action" 
                                               data-bs-toggle="tooltip" title="Edit File">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="upload.php?action=delete&file=<?php echo urlencode($file['unique_name']); ?>" 
                                               class="btn btn-danger btn-action" 
                                               data-bs-toggle="tooltip" title="Delete File"
                                               onclick="return confirm('Are you sure you want to delete this file?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
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
                        बिल्कुल मुफ्त HTML hosting solution। Upload करें, edit करें, और instantly share करें अपनी websites।
                    </p>
                </div>
                <div class="col-md-3">
                    <h6 style="color: var(--secondary-color); margin-bottom: 1rem;">Features</h6>
                    <ul style="list-style: none; padding: 0;">
                        <li style="color: var(--text-light); opacity: 0.8; margin-bottom: 0.5rem;">
                            <i class="fas fa-check me-2" style="color: var(--success-color);"></i>Instant hosting
                        </li>
                        <li style="color: var(--text-light); opacity: 0.8; margin-bottom: 0.5rem;">
                            <i class="fas fa-check me-2" style="color: var(--success-color);"></i>Online editor
                        </li>
                        <li style="color: var(--text-light); opacity: 0.8; margin-bottom: 0.5rem;">
                            <i class="fas fa-check me-2" style="color: var(--success-color);"></i>No registration
                        </li>
                        <li style="color: var(--text-light); opacity: 0.8; margin-bottom: 0.5rem;">
                            <i class="fas fa-check me-2" style="color: var(--success-color);"></i>100% Free
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 style="color: var(--secondary-color); margin-bottom: 1rem;">Quick Links</h6>
                    <ul style="list-style: none; padding: 0;">
                        <li><a href="index.php" style="color: var(--text-light); opacity: 0.8; text-decoration: none;">Home</a></li>
                        <li><a href="dashboard.php" style="color: var(--text-light); opacity: 0.8; text-decoration: none;">Dashboard</a></li>
                        <li><a href="html-editor.php" style="color: var(--text-light); opacity: 0.8; text-decoration: none;">HTML Editor</a></li>
                        <li><a href="analytics.php" style="color: var(--text-light); opacity: 0.8; text-decoration: none;">Analytics</a></li>
                    </ul>
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

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Highlight.js for syntax highlighting -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script>
    
    <script>
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Drag and drop functionality
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('fileInput');
        
        dropzone.addEventListener('click', () => fileInput.click());
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            dropzone.classList.add('dragover');
        }
        
        function unhighlight() {
            dropzone.classList.remove('dragover');
        }
        
        dropzone.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length) {
                fileInput.files = files;
                updateFileInfo(files[0]);
            }
        }
        
        fileInput.addEventListener('change', function() {
            if (this.files.length) {
                updateFileInfo(this.files[0]);
            }
        });
        
        function updateFileInfo(file) {
            const fileInfo = document.getElementById('fileInfo');
            fileInfo.innerHTML = `
                <i class="fas fa-file me-1"></i>
                <strong>${file.name}</strong> (${formatFileSize(file.size)})
            `;
        }
        
        function formatFileSize(bytes) {
            if (bytes < 1024) return bytes + ' bytes';
            else if (bytes < 1048576) return (bytes / 1024).toFixed(2) + ' KB';
            else return (bytes / 1048576).toFixed(2) + ' MB';
        }
        
        // Upload form handling
        document.getElementById('uploadForm').addEventListener('submit', function() {
            const btn = document.getElementById('uploadBtn');
            const spinner = document.getElementById('loadingSpinner');
            const btnText = document.getElementById('btnText');
            
            btn.disabled = true;
            btnText.textContent = 'Uploading...';
            spinner.style.display = 'inline-block';
        });
        
        // Copy URL to clipboard function
        function copyToClipboard(inputId) {
            const input = document.getElementById(inputId);
            const button = input.nextElementSibling;
            const originalIcon = button.innerHTML;
            
            // Select and copy the URL
            input.select();
            input.setSelectionRange(0, 99999); // For mobile devices
            
            navigator.clipboard.writeText(input.value).then(function() {
                // Show success feedback
                button.innerHTML = '<i class="fas fa-check"></i>';
                button.classList.add('copy-success');
                
                // Show toast notification
                showToast('Hosting link copied to clipboard!', 'success');
                
                // Restore button after 2 seconds
                setTimeout(function() {
                    button.innerHTML = originalIcon;
                    button.classList.remove('copy-success');
                }, 2000);
            }).catch(function() {
                // Fallback for older browsers
                try {
                    document.execCommand('copy');
                    showToast('Hosting link copied!', 'success');
                } catch (err) {
                    showToast('Failed to copy link', 'error');
                }
            });
        }
        
        // Toast notification function
        function showToast(message, type) {
            const toast = document.createElement('div');
            toast.className = `toast-notification ${type}`;
            toast.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                    <span>${message}</span>
                </div>
            `;
            
            // Add styles
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#00b894' : '#d63031'};
                color: white;
                padding: 12px 16px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 9999;
                font-family: 'Hind Siliguri', sans-serif;
                font-size: 14px;
                animation: slideInRight 0.3s ease-out;
            `;
            
            document.body.appendChild(toast);
            
            // Remove toast after 3 seconds
            setTimeout(function() {
                toast.style.animation = 'slideOutRight 0.3s ease-in';
                setTimeout(function() {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }, 3000);
        }
        
        // Add keyframe animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOutRight {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
        
        // Add animation to file items on page load
        document.addEventListener('DOMContentLoaded', function() {
            const fileItems = document.querySelectorAll('.file-item');
            fileItems.forEach((item, index) => {
                item.style.animationDelay = `${index * 0.1}s`;
                item.classList.add('animate__animated', 'animate__fadeInRight');
            });
        });
    </script>
</body>
</html>