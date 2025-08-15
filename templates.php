<?php 
require_once 'upload.php';
$userIP = getUserIP();

$templates = [
    'portfolio' => [
        'name' => 'Portfolio Website',
        'description' => 'Professional portfolio for developers and designers',
        'icon' => 'fas fa-user-tie',
        'color' => '#FF6B35',
        'preview' => '/templates/portfolio-preview.png'
    ],
    'business' => [
        'name' => 'Business Landing',
        'description' => 'Clean business landing page template',
        'icon' => 'fas fa-building',
        'color' => '#FFD23F',
        'preview' => '/templates/business-preview.png'
    ],
    'blog' => [
        'name' => 'Blog Template',
        'description' => 'Modern blog template with responsive design',
        'icon' => 'fas fa-blog',
        'color' => '#F4A261',
        'preview' => '/templates/blog-preview.png'
    ],
    'ecommerce' => [
        'name' => 'E-commerce Store',
        'description' => 'Product showcase and store template',
        'icon' => 'fas fa-shopping-cart',
        'color' => '#27AE60',
        'preview' => '/templates/ecommerce-preview.png'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Templates - Free HTML Hosting</title>
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
        
        .template-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
        
        .template-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0,0,0,0.4);
        }
        
        .template-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }
        
        .template-preview {
            height: 200px;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .template-icon {
            font-size: 4rem;
            opacity: 0.3;
        }
        
        .navbar {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
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
        
        .btn-template {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-template:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
            color: white;
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
        
        /* Mobile Responsive Design */
        @media (max-width: 992px) {
            .navbar-toggler {
                border: none;
                background: rgba(255,255,255,0.1);
            }
            
            .template-card {
                margin-bottom: 1.5rem;
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
            
            .template-card {
                margin-bottom: 1.5rem;
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
            
            .btn-custom, .btn-template {
                width: 100%;
                margin-bottom: 0.5rem;
                font-size: 0.9rem;
            }
            
            .template-preview {
                height: 200px;
            }
            
            .template-icon {
                font-size: 3rem;
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
            
            .template-card {
                padding: 1rem;
                margin-bottom: 1rem;
            }
            
            .template-preview {
                height: 150px;
            }
            
            .template-icon {
                font-size: 2.5rem;
            }
            
            .logo {
                width: 80px !important;
                height: 80px !important;
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
        }

        @media (max-width: 400px) {
            .display-4 {
                font-size: 1.6rem;
            }
            
            .hero-section {
                padding: 1rem 0.5rem;
            }
            
            .template-card {
                padding: 0.8rem;
                font-size: 0.9rem;
            }
            
            .template-preview {
                height: 120px;
            }
            
            .template-icon {
                font-size: 2rem;
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
                <span style="color: var(--light-color); font-weight: bold;">Website Templates</span>
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link me-3" href="index.php" style="color: var(--text-light);">
                    <i class="fas fa-home me-2"></i>Home
                </a>
                <a class="nav-link me-3" href="html-editor.php" style="color: var(--text-light);">
                    <i class="fab fa-html5 me-2"></i>HTML Editor
                </a>
                <div class="nav-link" style="color: var(--secondary-color);">
                    <i class="fas fa-user-circle me-2"></i><?php echo htmlspecialchars($userIP); ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold mb-3 animate__animated animate__fadeInDown">
                Website Templates
            </h1>
            <p class="lead animate__animated animate__fadeInUp" style="color: var(--text-light); opacity: 0.8;">
                Ready-to-use templates for your projects. Instant deployment with one click!
            </p>
        </div>

        <!-- Templates Grid -->
        <div class="row">
            <?php foreach ($templates as $key => $template): ?>
                <div class="col-lg-6 mb-4">
                    <div class="template-card p-4 h-100 animate__animated animate__fadeInUp" 
                         style="animation-delay: <?php echo array_search($key, array_keys($templates)) * 0.1; ?>s"
                         onclick="selectTemplate('<?php echo $key; ?>')">
                        <div class="template-preview">
                            <i class="<?php echo $template['icon']; ?> template-icon" 
                               style="color: <?php echo $template['color']; ?>;"></i>
                        </div>
                        <h4 style="color: var(--text-light); margin-bottom: 1rem;">
                            <?php echo $template['name']; ?>
                        </h4>
                        <p style="color: var(--text-light); opacity: 0.8; margin-bottom: 2rem;">
                            <?php echo $template['description']; ?>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge" style="background: <?php echo $template['color']; ?>; color: white;">
                                    Ready to deploy
                                </span>
                            </div>
                            <button class="btn btn-template">
                                Use Template <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Custom Template Section -->
        <div class="template-card p-4 mt-5 text-center">
            <h3 style="color: var(--text-light); margin-bottom: 1rem;">
                <i class="fas fa-code me-2" style="color: var(--secondary-color);"></i>
                Create Custom Template
            </h3>
            <p style="color: var(--text-light); opacity: 0.8; margin-bottom: 2rem;">
                Start from scratch with our advanced HTML editor
            </p>
            <a href="html-editor.php" class="btn btn-template btn-lg">
                <i class="fas fa-plus me-2"></i>Start Coding
            </a>
        </div>

        <!-- Features -->
        <div class="row mt-5">
            <div class="col-md-4 mb-3">
                <div class="text-center">
                    <i class="fas fa-rocket" style="font-size: 2rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
                    <h5 style="color: var(--text-light);">Instant Deployment</h5>
                    <p style="color: var(--text-light); opacity: 0.7; font-size: 0.9rem;">
                        Templates deploy instantly with hosting links
                    </p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="text-center">
                    <i class="fas fa-mobile-alt" style="font-size: 2rem; color: var(--secondary-color); margin-bottom: 1rem;"></i>
                    <h5 style="color: var(--text-light);">Responsive Design</h5>
                    <p style="color: var(--text-light); opacity: 0.7; font-size: 0.9rem;">
                        All templates work perfectly on mobile devices
                    </p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="text-center">
                    <i class="fas fa-edit" style="font-size: 2rem; color: var(--accent-color); margin-bottom: 1rem;"></i>
                    <h5 style="color: var(--text-light);">Easy Customization</h5>
                    <p style="color: var(--text-light); opacity: 0.7; font-size: 0.9rem;">
                        Edit templates directly in your browser
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Template Selection Modal -->
    <div class="modal fade" id="templateModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: var(--dark-color); border: 1px solid rgba(255,255,255,0.2);">
                <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.2);">
                    <h5 class="modal-title" style="color: var(--text-light);">Deploy Template</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div id="selectedIcon"></div>
                        <h4 id="selectedName" style="color: var(--text-light); margin: 1rem 0;"></h4>
                        <p id="selectedDescription" style="color: var(--text-light); opacity: 0.8;"></p>
                    </div>
                    
                    <form id="templateForm">
                        <div class="mb-3">
                            <label style="color: var(--text-light); margin-bottom: 0.5rem;">Website Name:</label>
                            <input type="text" class="form-control" id="websiteName" 
                                   placeholder="Enter your website name" required
                                   style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); color: var(--text-light);">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-template btn-lg">
                                <i class="fas fa-rocket me-2"></i>Deploy Template
                            </button>
                            <button type="button" class="btn btn-outline-light" onclick="previewTemplate()">
                                <i class="fas fa-eye me-2"></i>Preview First
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let selectedTemplate = '';
        const templates = <?php echo json_encode($templates); ?>;

        function selectTemplate(templateKey) {
            selectedTemplate = templateKey;
            const template = templates[templateKey];
            
            document.getElementById('selectedIcon').innerHTML = 
                `<i class="${template.icon}" style="font-size: 3rem; color: ${template.color};"></i>`;
            document.getElementById('selectedName').textContent = template.name;
            document.getElementById('selectedDescription').textContent = template.description;
            
            const modal = new bootstrap.Modal(document.getElementById('templateModal'));
            modal.show();
        }

        function previewTemplate() {
            // Generate preview HTML based on template
            const template = templates[selectedTemplate];
            const websiteName = document.getElementById('websiteName').value || 'My Website';
            
            let htmlContent = generateTemplateHTML(selectedTemplate, websiteName);
            
            // Open preview in new window
            const previewWindow = window.open('', '_blank');
            previewWindow.document.write(htmlContent);
            previewWindow.document.close();
        }

        document.getElementById('templateForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const websiteName = document.getElementById('websiteName').value;
            const htmlContent = generateTemplateHTML(selectedTemplate, websiteName);
            
            // Create a blob and simulate file upload
            const blob = new Blob([htmlContent], { type: 'text/html' });
            const formData = new FormData();
            formData.append('file', blob, `${websiteName.toLowerCase().replace(/\s+/g, '-')}.html`);
            
            try {
                const response = await fetch('upload.php', {
                    method: 'POST',
                    body: formData
                });
                
                if (response.ok) {
                    window.location.href = 'index.php?success=Template deployed successfully!';
                } else {
                    alert('Error deploying template. Please try again.');
                }
            } catch (error) {
                alert('Error deploying template. Please try again.');
            }
        });

        function generateTemplateHTML(templateKey, websiteName) {
            const templates = {
                'portfolio': `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>${websiteName} - Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #FF6B35; --secondary: #FFD23F; }
        body { font-family: 'Arial', sans-serif; }
        .hero { background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; padding: 100px 0; }
        .card { border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: transform 0.3s; }
        .card:hover { transform: translateY(-5px); }
    </style>
</head>
<body>
    <div class="hero text-center">
        <div class="container">
            <h1 class="display-4">${websiteName}</h1>
            <p class="lead">Professional Developer & Designer</p>
            <a href="#portfolio" class="btn btn-light btn-lg">View My Work</a>
        </div>
    </div>
    <div class="container my-5" id="portfolio">
        <h2 class="text-center mb-5">My Projects</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Project 1</h5>
                        <p>Amazing web application built with modern technologies.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>`,
                
                'business': `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>${websiteName} - Business</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --primary: #FFD23F; --secondary: #FF6B35; }
        .hero { background: var(--primary); color: #2B1B17; padding: 80px 0; }
        .feature-box { padding: 30px; border-radius: 10px; background: #f8f9fa; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="hero text-center">
        <div class="container">
            <h1 class="display-4">${websiteName}</h1>
            <p class="lead">Growing Your Business with Innovation</p>
            <a href="#services" class="btn btn-dark btn-lg">Our Services</a>
        </div>
    </div>
    <div class="container my-5" id="services">
        <h2 class="text-center mb-5">What We Offer</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="feature-box text-center">
                    <i class="fas fa-chart-line fa-3x text-primary mb-3"></i>
                    <h4>Business Growth</h4>
                    <p>Strategic solutions to grow your business.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>`,
                
                'blog': `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>${websiteName} - Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header { background: #F4A261; color: white; padding: 50px 0; }
        .post { background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 30px; }
    </style>
</head>
<body style="background: #f8f9fa;">
    <div class="header text-center">
        <div class="container">
            <h1>${websiteName}</h1>
            <p class="lead">Sharing thoughts and experiences</p>
        </div>
    </div>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-8">
                <article class="post p-4">
                    <h2>Welcome to My Blog</h2>
                    <p class="text-muted">January 7, 2025</p>
                    <p>This is your first blog post. Start writing about topics you're passionate about!</p>
                </article>
            </div>
        </div>
    </div>
</body>
</html>`,
                
                'ecommerce': `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>${websiteName} - Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-card { border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s; }
        .product-card:hover { transform: translateY(-5px); }
        .hero { background: #27AE60; color: white; padding: 60px 0; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">${websiteName}</a>
        </div>
    </nav>
    <div class="hero text-center">
        <div class="container">
            <h1>Welcome to Our Store</h1>
            <p class="lead">Discover amazing products at great prices</p>
        </div>
    </div>
    <div class="container my-5">
        <h2 class="text-center mb-5">Featured Products</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card product-card">
                    <div class="card-body">
                        <h5>Product Name</h5>
                        <p class="text-muted">$99.99</p>
                        <button class="btn btn-success">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>`
            };
            
            return templates[templateKey] || templates['portfolio'];
        }
    </script>
</body>
</html>