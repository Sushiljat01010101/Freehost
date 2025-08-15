<?php 
require_once 'upload.php';
$userIP = getUserIP();

// Handle direct HTML creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_html'])) {
    $fileName = trim($_POST['file_name'] ?? '');
    $htmlContent = $_POST['html_content'] ?? '';
    
    if (!$fileName) {
        $fileName = 'untitled_' . time() . '.html';
    } elseif (!preg_match('/\.html?$/i', $fileName)) {
        $fileName .= '.html';
    }
    
    // Create uploads directory if needed
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    $uniqueName = pathinfo($fileName, PATHINFO_FILENAME) . '_' . time() . '.html';
    $filePath = $uploadDir . $uniqueName;
    
    if (file_put_contents($filePath, $htmlContent) !== false) {
        // Generate public URL for the file
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        $publicUrl = $protocol . $host . '/' . $filePath;
        
        // Add to session
        if (!isset($_SESSION['uploaded_files'])) {
            $_SESSION['uploaded_files'] = [];
        }
        
        $_SESSION['uploaded_files'][] = [
            'name' => $fileName,
            'unique_name' => $uniqueName,
            'size' => strlen($htmlContent),
            'extension' => 'html',
            'upload_time' => time(),
            'path' => $filePath,
            'public_url' => $publicUrl
        ];
        
        header('Location: index.php?success=HTML file created successfully! Link: ' . urlencode($publicUrl));
        exit;
    } else {
        $error = 'Failed to create HTML file';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML Editor - NewtonNexus</title>
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
        
        .navbar {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255,255,255,0.2);
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
        
        .hero-section {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            color: var(--text-light);
            padding: 3rem 0;
            margin: 2rem 0;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }
        
        .editor-container {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .editor-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }
        
        .editor-header {
            background: rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.2);
            color: var(--text-light);
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .CodeMirror {
            height: 500px;
            font-size: 14px;
            line-height: 1.5;
            background: rgba(0,0,0,0.4) !important;
            color: var(--text-light) !important;
        }
        
        .CodeMirror-gutters {
            background: rgba(0,0,0,0.2) !important;
            border-right: 1px solid rgba(255,255,255,0.1) !important;
        }
        
        .CodeMirror-linenumber {
            color: rgba(248, 249, 250, 0.5) !important;
        }
        
        .btn-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            color: white;
            font-weight: 600;
            font-family: 'Hind Siliguri', sans-serif;
            transition: all 0.3s ease;
        }
        
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
            color: white;
        }
        
        .btn-outline-custom {
            border: 2px solid var(--secondary-color);
            color: var(--secondary-color);
            background: transparent;
            border-radius: 25px;
            padding: 10px 28px;
            font-weight: 600;
            font-family: 'Hind Siliguri', sans-serif;
            transition: all 0.3s ease;
        }
        
        .btn-outline-custom:hover {
            background: var(--secondary-color);
            color: var(--dark-color);
            transform: translateY(-2px);
        }
        
        .template-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        
        .template-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }
        
        .template-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
        
        .template-card h6 {
            color: var(--text-light);
            margin-bottom: 0.5rem;
        }
        
        .template-card small {
            color: var(--text-light);
            opacity: 0.7;
        }
        
        .preview-frame {
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 15px;
            background: white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        .form-control {
            background: rgba(255,255,255,0.1);
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
            letter-spacing: 0.5px;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #5a4bc2;
            border-color: #5a4bc2;
        }
        
        .preview-container {
            border: 1px solid #ddd;
            border-radius: 10px;
            min-height: 400px;
            background: white;
        }
        

        
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 2rem 0;
            margin-top: auto;
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
            
            .template-card {
                margin-bottom: 1.5rem;
                padding: 1rem;
            }
            
            .preview-container {
                height: 250px;
            }
            
            .row > .col-lg-6 {
                margin-bottom: 2rem;
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
            
            .template-card {
                padding: 1rem;
                margin-bottom: 1rem;
            }
            
            .preview-container {
                height: 200px;
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
            
            .template-card {
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
                <span style="color: var(--light-color); font-weight: bold;">HTML Editor</span>
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php" style="color: var(--text-light);">
                    <i class="fas fa-arrow-left me-2"></i>Back to Home
                </a>
                <div class="stats-badge ms-3">
                    <i class="fas fa-user-circle me-2"></i><?php echo htmlspecialchars($userIP); ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container">
        <div class="hero-section animate__animated animate__fadeIn">
            <div class="container text-center">
                <h1 class="display-6 mb-3 animate__animated animate__fadeInDown">
                    <i class="fab fa-html5 me-2" style="color: var(--secondary-color);"></i>HTML Editor
                </h1>
                <p class="lead animate__animated animate__fadeInUp">
                    आसानी से बनाएं beautiful websites! Code करें, preview करें और instantly deploy करें।
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mb-5">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Quick Templates -->
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="mb-3" style="color: var(--text-light);">
                    <i class="fas fa-layer-group me-2" style="color: var(--secondary-color);"></i>Quick Templates
                </h3>
            </div>
            <div class="col-md-4">
                <div class="template-card animate__animated animate__fadeInUp" onclick="loadTemplate('basic')">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-file-code fa-3x mb-3" style="color: var(--primary-color);"></i>
                        <h6>Basic HTML</h6>
                        <small>Simple HTML page structure</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="template-card animate__animated animate__fadeInUp animate__delay-1s" onclick="loadTemplate('bootstrap')">
                    <div class="card-body text-center p-4">
                        <i class="fab fa-bootstrap fa-3x mb-3" style="color: var(--secondary-color);"></i>
                        <h6>Bootstrap Page</h6>
                        <small>Responsive page with Bootstrap</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card template-card animate__animated animate__fadeInUp animate__delay-2s" onclick="loadTemplate('landing')">
                    <div class="card-body text-center">
                        <i class="fas fa-rocket fa-3x text-primary mb-3"></i>
                        <h5>Landing Page</h5>
                        <p class="text-muted">Modern landing page template</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Editor and Preview -->
        <form method="POST" id="htmlForm">
            <input type="hidden" name="create_html" value="1">
            <div class="row mb-3">
                <div class="col-md-8">
                    <input type="text" name="file_name" class="form-control" placeholder="Enter file name (e.g., my-page.html)" id="fileName">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success btn-custom w-100">
                        <i class="fas fa-save me-1"></i>Save HTML File
                    </button>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6">
                    <!-- Code Editor -->
                    <div class="card editor-container animate__animated animate__fadeInLeft">
                        <div class="editor-header">
                            <div>
                                <i class="fas fa-code me-2"></i>
                                <strong>HTML Code</strong>
                            </div>
                            <div>
                                <button type="button" class="btn btn-info btn-sm btn-custom" onclick="updatePreview()">
                                    <i class="fas fa-eye me-1"></i>Preview
                                </button>
                                <button type="button" class="btn btn-warning btn-sm btn-custom" onclick="formatCode()">
                                    <i class="fas fa-indent me-1"></i>Format
                                </button>
                            </div>
                        </div>
                        <div class="editor-body">
                            <textarea name="html_content" id="html-editor" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <!-- Live Preview -->
                    <div class="card animate__animated animate__fadeInRight animate__delay-1s">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-browser me-2"></i>Live Preview
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <iframe id="preview-frame" class="preview-container w-100" style="border: none;"></iframe>
                        </div>
                    </div>
                </div>
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
                        HTML Editor - Code करें, preview करें, और instantly deploy करें।
                    </p>
                </div>
                <div class="col-md-6 text-center">
                    <h6 style="color: var(--secondary-color); margin-bottom: 1rem;">Ready to host your website?</h6>
                    <a href="index.php" class="btn btn-custom">
                        <i class="fas fa-rocket me-2"></i>Start Hosting Now
                    </a>
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
        const editor = CodeMirror.fromTextArea(document.getElementById('html-editor'), {
            lineNumbers: true,
            theme: 'monokai',
            mode: 'text/html',
            indentUnit: 2,
            smartIndent: true,
            tabSize: 2,
            electricChars: true,
            autoCloseBrackets: true,
            matchBrackets: true,
            lineWrapping: true
        });

        // Templates
        const templates = {
            basic: `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Web Page</title>
</head>
<body>
    <h1>Welcome to My Website</h1>
    <p>This is a basic HTML page.</p>
</body>
</html>`,
            
            bootstrap: `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">My Website</a>
        </div>
    </nav>
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="display-4">Welcome!</h1>
                <p class="lead">This is a Bootstrap-powered webpage.</p>
                <button class="btn btn-primary">Get Started</button>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>`,
            
            landing: `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 5rem 0;
        }
        .feature-icon {
            font-size: 3rem;
            color: #667eea;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-rocket me-2"></i>StartupName</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="#home">Home</a>
                <a class="nav-link" href="#features">Features</a>
                <a class="nav-link" href="#contact">Contact</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center" id="home">
        <div class="container">
            <h1 class="display-3 fw-bold mb-4">Build Something Amazing</h1>
            <p class="lead mb-5">Transform your ideas into reality with our powerful platform</p>
            <button class="btn btn-light btn-lg px-5">Get Started</button>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5" id="features">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <i class="fas fa-lightning-bolt feature-icon mb-3"></i>
                    <h4>Fast & Reliable</h4>
                    <p class="text-muted">Lightning fast performance you can rely on</p>
                </div>
                <div class="col-md-4 mb-4">
                    <i class="fas fa-shield-alt feature-icon mb-3"></i>
                    <h4>Secure</h4>
                    <p class="text-muted">Enterprise-grade security for your data</p>
                </div>
                <div class="col-md-4 mb-4">
                    <i class="fas fa-users feature-icon mb-3"></i>
                    <h4>Collaborative</h4>
                    <p class="text-muted">Work together with your team seamlessly</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4" id="contact">
        <div class="container text-center">
            <p>&copy; 2025 StartupName. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>`
        };

        // Load template
        function loadTemplate(templateName) {
            if (templates[templateName]) {
                editor.setValue(templates[templateName]);
                updatePreview();
            }
        }

        // Update preview
        function updatePreview() {
            const content = editor.getValue();
            const previewFrame = document.getElementById('preview-frame');
            const blob = new Blob([content], { type: 'text/html' });
            const url = URL.createObjectURL(blob);
            previewFrame.src = url;
        }

        // Format code (basic indentation)
        function formatCode() {
            const content = editor.getValue();
            // Basic HTML formatting - you could integrate a proper formatter here
            editor.setValue(content);
            editor.autoFormatRange({line: 0, ch: 0}, {line: editor.lineCount()});
        }

        // Auto-update preview
        editor.on('change', function() {
            clearTimeout(window.previewTimeout);
            window.previewTimeout = setTimeout(updatePreview, 1000);
        });

        // Load basic template on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadTemplate('basic');
        });

        // Form submission
        document.getElementById('htmlForm').addEventListener('submit', function(e) {
            editor.save(); // Update textarea with editor content
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl+S to save
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                document.getElementById('htmlForm').submit();
            }
            
            // Ctrl+P for preview
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                updatePreview();
            }
        });
    </script>
</body>
</html>