<?php 
require_once 'upload.php';
$userIP = getUserIP();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help & Tutorial - Free HTML Hosting</title>
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
        
        .help-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        
        .help-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }
        
        .step-number {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-color);
            font-weight: bold;
            margin-right: 1rem;
            flex-shrink: 0;
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
        
        .code-block {
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            padding: 1rem;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            overflow-x: auto;
        }
        
        /* Mobile Responsive Design */
        @media (max-width: 992px) {
            .navbar-toggler {
                border: none;
                background: rgba(255,255,255,0.1);
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
            
            .help-section {
                padding: 1.5rem 1rem;
                margin-bottom: 1.5rem;
            }
            
            .code-block {
                font-size: 0.8rem;
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
            
            .display-4 {
                font-size: 1.8rem;
                margin-bottom: 1rem;
            }
            
            .help-section {
                padding: 1rem;
                margin-bottom: 1rem;
            }
            
            .logo {
                width: 80px !important;
                height: 80px !important;
            }
            
            .navbar-brand span {
                font-size: 1rem;
            }
            
            .code-block {
                font-size: 0.75rem;
                padding: 0.8rem;
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
            
            .help-section {
                padding: 0.8rem;
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
                <span style="color: var(--light-color); font-weight: bold;">Help & Tutorial</span>
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php" style="color: var(--text-light);">
                    <i class="fas fa-arrow-left me-2"></i>Back to Home
                </a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold mb-3 animate__animated animate__fadeInDown">
                Free HTML Hosting Guide
            </h1>
            <p class="lead animate__animated animate__fadeInUp" style="color: var(--text-light); opacity: 0.8;">
                आसान steps में सीखें कि कैसे करें अपनी website host मुफ्त में!
            </p>
        </div>

        <!-- Quick Start Guide -->
        <div class="help-card p-4">
            <h3 style="color: var(--secondary-color); margin-bottom: 2rem;">
                <i class="fas fa-rocket me-2"></i>Quick Start (तुरंत शुरू करें)
            </h3>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="d-flex">
                        <div class="step-number">1</div>
                        <div>
                            <h5 style="color: var(--text-light);">Upload Your HTML File</h5>
                            <p style="color: var(--text-light); opacity: 0.8;">
                                अपनी HTML file को drag & drop करें या click करके upload करें।
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="d-flex">
                        <div class="step-number">2</div>
                        <div>
                            <h5 style="color: var(--text-light);">Get Instant Link</h5>
                            <p style="color: var(--text-light); opacity: 0.8;">
                                तुरंत मिल जाएगी आपकी website का live link!
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="d-flex">
                        <div class="step-number">3</div>
                        <div>
                            <h5 style="color: var(--text-light);">Share & Edit</h5>
                            <p style="color: var(--text-light); opacity: 0.8;">
                                Link को share करें और online edit भी कर सकते हैं।
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="d-flex">
                        <div class="step-number">4</div>
                        <div>
                            <h5 style="color: var(--text-light);">Manage Files</h5>
                            <p style="color: var(--text-light); opacity: 0.8;">
                                Dashboard में सभी files को manage करें।
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- HTML Tutorial -->
        <div class="help-card p-4">
            <h3 style="color: var(--secondary-color); margin-bottom: 2rem;">
                <i class="fab fa-html5 me-2"></i>Basic HTML Tutorial
            </h3>
            
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <h5 style="color: var(--text-light); margin-bottom: 1rem;">सबसे basic HTML structure:</h5>
                    <div class="code-block">
&lt;!DOCTYPE html&gt;
&lt;html lang="hi"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;title&gt;My Website&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;h1&gt;Welcome to My Site!&lt;/h1&gt;
    &lt;p&gt;यह मेरी पहली website है।&lt;/p&gt;
&lt;/body&gt;
&lt;/html&gt;
                    </div>
                </div>
                <div class="col-lg-6">
                    <h5 style="color: var(--text-light); margin-bottom: 1rem;">Common HTML tags:</h5>
                    <ul style="color: var(--text-light); opacity: 0.8;">
                        <li><code>&lt;h1&gt;</code> से <code>&lt;h6&gt;</code> - Headings के लिए</li>
                        <li><code>&lt;p&gt;</code> - Paragraphs के लिए</li>
                        <li><code>&lt;a href=""&gt;</code> - Links के लिए</li>
                        <li><code>&lt;img src=""&gt;</code> - Images के लिए</li>
                        <li><code>&lt;div&gt;</code> - Container के लिए</li>
                        <li><code>&lt;button&gt;</code> - Buttons के लिए</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Features Overview -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="help-card p-4 h-100">
                    <i class="fas fa-upload" style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
                    <h5 style="color: var(--text-light); margin-bottom: 1rem;">File Upload</h5>
                    <ul style="color: var(--text-light); opacity: 0.8; font-size: 0.9rem;">
                        <li>Drag & drop support</li>
                        <li>Multiple file formats</li>
                        <li>5MB max file size</li>
                        <li>Instant hosting links</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="help-card p-4 h-100">
                    <i class="fas fa-code" style="font-size: 2.5rem; color: var(--secondary-color); margin-bottom: 1rem;"></i>
                    <h5 style="color: var(--text-light); margin-bottom: 1rem;">Online Editor</h5>
                    <ul style="color: var(--text-light); opacity: 0.8; font-size: 0.9rem;">
                        <li>Syntax highlighting</li>
                        <li>Live preview</li>
                        <li>HTML, CSS, JS support</li>
                        <li>Auto-save feature</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="help-card p-4 h-100">
                    <i class="fas fa-chart-line" style="font-size: 2.5rem; color: var(--accent-color); margin-bottom: 1rem;"></i>
                    <h5 style="color: var(--text-light); margin-bottom: 1rem;">Analytics</h5>
                    <ul style="color: var(--text-light); opacity: 0.8; font-size: 0.9rem;">
                        <li>File statistics</li>
                        <li>Storage usage</li>
                        <li>Upload activity</li>
                        <li>File type breakdown</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="help-card p-4">
            <h3 style="color: var(--secondary-color); margin-bottom: 2rem;">
                <i class="fas fa-question-circle me-2"></i>Frequently Asked Questions
            </h3>
            
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.2); margin-bottom: 1rem;">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1"
                                style="background: transparent; color: var(--text-light); border: none;">
                            क्या यह service सच में free है?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="color: var(--text-light); opacity: 0.8;">
                            जी हाँ, यह service 100% मुफ्त है। कोई hidden charges नहीं हैं।
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.2); margin-bottom: 1rem;">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2"
                                style="background: transparent; color: var(--text-light); border: none;">
                            कितनी files upload कर सकते हैं?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="color: var(--text-light); opacity: 0.8;">
                            कोई limit नहीं है! आप जितनी चाहें files upload कर सकते हैं।
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.2);">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3"
                                style="background: transparent; color: var(--text-light); border: none;">
                            कौन से file formats support करता है?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="color: var(--text-light); opacity: 0.8;">
                            HTML, CSS, JavaScript, और TXT files को support करता है।
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="help-card p-4 text-center">
            <h4 style="color: var(--text-light); margin-bottom: 1rem;">
                <i class="fas fa-heart me-2" style="color: var(--primary-color);"></i>
                Made with Love by Sushil Choudhary
            </h4>
            <p style="color: var(--text-light); opacity: 0.8;">
                अगर कोई problem हो तो बेझिझक पूछें! हम help करने के लिए हमेशा ready हैं।
            </p>
            <a href="index.php" class="btn btn-lg" style="background: var(--primary-color); color: white; border-radius: 25px; padding: 12px 30px;">
                <i class="fas fa-rocket me-2"></i>Start Hosting Now
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>