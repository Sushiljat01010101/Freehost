<?php 
require_once 'upload.php';
$uploadedFiles = getUploadedFiles();
$userIP = getUserIP();

// Calculate analytics data
$totalFiles = count($uploadedFiles);
$totalSize = 0;
$fileTypes = [];
$recentFiles = 0;
$cutoffTime = time() - (7 * 24 * 60 * 60); // 7 days ago

foreach ($uploadedFiles as $file) {
    $totalSize += $file['size'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $fileTypes[$ext] = ($fileTypes[$ext] ?? 0) + 1;
    
    if ($file['upload_time'] > $cutoffTime) {
        $recentFiles++;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard - Free HTML Hosting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        
        .analytics-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .analytics-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        }
        
        .analytics-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }
        
        .metric-value {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--secondary-color);
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            background: rgba(255,255,255,0.05);
            border-radius: 15px;
            padding: 20px;
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
        
        /* Mobile Responsive Design */
        @media (max-width: 992px) {
            .navbar-toggler {
                border: none;
                background: rgba(255,255,255,0.1);
            }
            
            .chart-container {
                height: 300px;
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
            
            .lead {
                font-size: 1.1rem;
            }
            
            .stats-card {
                margin-bottom: 1.5rem;
                padding: 1.5rem;
            }
            
            .chart-container {
                height: 250px;
                margin-bottom: 2rem;
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
            
            .stats-card {
                padding: 1rem;
                margin-bottom: 1rem;
            }
            
            .stats-number {
                font-size: 1.5rem;
            }
            
            .chart-container {
                height: 200px;
                margin-bottom: 1.5rem;
            }
            
            .card {
                margin-bottom: 1rem;
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
            
            .stats-card {
                padding: 0.8rem;
                font-size: 0.9rem;
            }
            
            .stats-number {
                font-size: 1.3rem;
            }
            
            .chart-container {
                height: 180px;
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
                <span style="color: var(--light-color); font-weight: bold;">Analytics Dashboard</span>
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php" style="color: var(--text-light);">
                    <i class="fas fa-arrow-left me-2"></i>Back to Home
                </a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <!-- Stats Overview -->
        <div class="row mb-5">
            <div class="col-md-3 mb-4">
                <div class="analytics-card p-4 text-center h-100">
                    <i class="fas fa-files" style="font-size: 3rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
                    <div class="metric-value"><?php echo $totalFiles; ?></div>
                    <div style="color: var(--text-light); opacity: 0.8;">Total Files</div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="analytics-card p-4 text-center h-100">
                    <i class="fas fa-hdd" style="font-size: 3rem; color: var(--secondary-color); margin-bottom: 1rem;"></i>
                    <div class="metric-value"><?php echo formatFileSize($totalSize); ?></div>
                    <div style="color: var(--text-light); opacity: 0.8;">Total Size</div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="analytics-card p-4 text-center h-100">
                    <i class="fas fa-clock" style="font-size: 3rem; color: var(--accent-color); margin-bottom: 1rem;"></i>
                    <div class="metric-value"><?php echo $recentFiles; ?></div>
                    <div style="color: var(--text-light); opacity: 0.8;">This Week</div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="analytics-card p-4 text-center h-100">
                    <i class="fas fa-user" style="font-size: 3rem; color: var(--success-color); margin-bottom: 1rem;"></i>
                    <div class="metric-value">1</div>
                    <div style="color: var(--text-light); opacity: 0.8;">Active User</div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- File Types Chart -->
            <div class="col-md-6 mb-4">
                <div class="analytics-card p-4">
                    <h4 class="mb-3" style="color: var(--text-light);">
                        <i class="fas fa-chart-pie me-2" style="color: var(--primary-color);"></i>
                        File Types Distribution
                    </h4>
                    <div class="chart-container">
                        <canvas id="fileTypesChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Upload Activity -->
            <div class="col-md-6 mb-4">
                <div class="analytics-card p-4">
                    <h4 class="mb-3" style="color: var(--text-light);">
                        <i class="fas fa-chart-line me-2" style="color: var(--secondary-color);"></i>
                        Storage Usage
                    </h4>
                    <div class="chart-container">
                        <div class="row h-100 align-items-center">
                            <div class="col-12 text-center">
                                <div class="progress mb-3" style="height: 20px;">
                                    <div class="progress-bar progress-bar-striped" 
                                         style="width: <?php echo min(($totalSize / (50 * 1024 * 1024)) * 100, 100); ?>%; 
                                                background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));">
                                    </div>
                                </div>
                                <h3 style="color: var(--secondary-color);"><?php echo formatFileSize($totalSize); ?> / 50MB</h3>
                                <p style="color: var(--text-light); opacity: 0.8;">
                                    Storage Used (<?php echo round(($totalSize / (50 * 1024 * 1024)) * 100, 1); ?>%)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Files Table -->
        <div class="analytics-card p-4 mb-4">
            <h4 class="mb-3" style="color: var(--text-light);">
                <i class="fas fa-history me-2" style="color: var(--accent-color);"></i>
                Recent Files
            </h4>
            <div class="table-responsive">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr style="border-color: rgba(255,255,255,0.2);">
                            <th>File Name</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Upload Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $recentFiles = array_slice(array_reverse($uploadedFiles), 0, 10);
                        foreach ($recentFiles as $file): 
                        ?>
                        <tr style="border-color: rgba(255,255,255,0.1);">
                            <td>
                                <i class="<?php echo getFileIcon(strtolower(pathinfo($file['name'], PATHINFO_EXTENSION))); ?> me-2" 
                                   style="color: var(--primary-color);"></i>
                                <?php echo htmlspecialchars($file['name']); ?>
                            </td>
                            <td>
                                <span class="badge" style="background: var(--accent-color); color: var(--dark-color);">
                                    <?php echo strtoupper(pathinfo($file['name'], PATHINFO_EXTENSION)); ?>
                                </span>
                            </td>
                            <td><?php echo formatFileSize($file['size']); ?></td>
                            <td><?php echo date('M j, Y g:i A', $file['upload_time']); ?></td>
                            <td>
                                <a href="<?php echo htmlspecialchars($file['url']); ?>" target="_blank" 
                                   class="btn btn-sm" style="background: var(--primary-color); color: white;">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // File Types Chart
        const ctx = document.getElementById('fileTypesChart').getContext('2d');
        const fileTypesData = <?php echo json_encode($fileTypes); ?>;
        
        const colors = ['#FF6B35', '#FFD23F', '#F4A261', '#27AE60', '#E74C3C'];
        
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(fileTypesData),
                datasets: [{
                    data: Object.values(fileTypesData),
                    backgroundColor: colors,
                    borderColor: 'rgba(255,255,255,0.2)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#F8F9FA',
                            padding: 20,
                            font: {
                                family: 'Hind Siliguri'
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>