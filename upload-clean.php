<?php
// InfinityFree Compatible Version - Clean Upload Handler
session_start();

// Basic configuration
$uploadDir = 'uploads/';
$maxFileSize = 5242880; // 5MB in bytes
$allowedTypes = array('html', 'css', 'js', 'txt', 'zip');
$maxFolderSize = 20971520; // 20MB in bytes

// Create upload directory
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Simple IP function
function getClientIP() {
    $ip = '';
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

// File size formatter
function formatBytes($bytes) {
    if ($bytes < 1024) return $bytes . ' bytes';
    elseif ($bytes < 1048576) return round($bytes / 1024, 2) . ' KB';
    return round($bytes / 1048576, 2) . ' MB';
}

// Get file icon
function getIcon($ext) {
    switch($ext) {
        case 'html': return 'fab fa-html5';
        case 'css': return 'fab fa-css3-alt';
        case 'js': return 'fab fa-js-square';
        case 'txt': return 'fas fa-file-alt';
        case 'zip': return 'fas fa-file-archive';
        default: return 'fas fa-file';
    }
}

// Watermark configuration
function getWatermarkSettings() {
    $defaults = array(
        'enabled' => true,
        'text' => '⚡ Free Hosting',
        'link' => 'https://your-domain.com',
        'position' => 'bottom-right',
        'color' => '#FF6B35',
        'opacity' => '0.9',
        'size' => 'small'
    );
    
    if (isset($_SESSION['watermark_config'])) {
        return $_SESSION['watermark_config'];
    }
    return $defaults;
}

// Add watermark to HTML
function addWatermark($htmlContent) {
    $config = getWatermarkSettings();
    
    if (!$config['enabled']) {
        return $htmlContent;
    }
    
    // Position styles
    $positions = array(
        'bottom-right' => 'bottom: 10px; right: 10px;',
        'bottom-left' => 'bottom: 10px; left: 10px;',
        'top-right' => 'top: 10px; right: 10px;',
        'top-left' => 'top: 10px; left: 10px;'
    );
    
    // Size styles
    $sizes = array(
        'small' => 'font-size: 12px; padding: 8px 15px;',
        'medium' => 'font-size: 14px; padding: 10px 18px;',
        'large' => 'font-size: 16px; padding: 12px 22px;'
    );
    
    $pos = isset($positions[$config['position']]) ? $positions[$config['position']] : $positions['bottom-right'];
    $sz = isset($sizes[$config['size']]) ? $sizes[$config['size']] : $sizes['small'];
    
    $watermarkCSS = "<style>
    .host-watermark {
        position: fixed;
        " . $pos . "
        background: linear-gradient(135deg, " . $config['color'] . " 0%, #FFD23F 100%);
        color: white;
        " . $sz . "
        border-radius: 25px;
        font-family: 'Segoe UI', sans-serif;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        z-index: 999999;
        transition: all 0.3s ease;
        opacity: " . $config['opacity'] . ";
    }
    .host-watermark:hover {
        transform: translateY(-2px);
        opacity: 1;
        color: white;
        text-decoration: none;
    }
    @media (max-width: 768px) {
        .host-watermark {
            font-size: 11px;
            padding: 6px 12px;
        }
    }
    </style>";
    
    $watermarkHTML = '<a href="' . htmlspecialchars($config['link']) . '" target="_blank" class="host-watermark">
        ' . htmlspecialchars($config['text']) . '
    </a>';
    
    // Inject watermark
    if (strpos($htmlContent, '</body>') !== false) {
        $htmlContent = str_replace('</body>', $watermarkHTML . '</body>', $htmlContent);
    } else {
        $htmlContent .= $watermarkHTML;
    }
    
    if (strpos($htmlContent, '</head>') !== false) {
        $htmlContent = str_replace('</head>', $watermarkCSS . '</head>', $htmlContent);
    } else {
        $htmlContent = $watermarkCSS . $htmlContent;
    }
    
    return $htmlContent;
}

// Process HTML files
function processHTML($filePath) {
    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    if ($ext === 'html') {
        $content = file_get_contents($filePath);
        $watermarked = addWatermark($content);
        file_put_contents($filePath, $watermarked);
        return true;
    }
    return false;
}

// ZIP extraction
function extractZip($zipPath, $extractDir) {
    $zip = new ZipArchive;
    $folderPath = $extractDir . 'folder_' . time() . '/';
    
    if ($zip->open($zipPath) === TRUE) {
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0755, true);
        }
        
        $zip->extractTo($folderPath);
        $zip->close();
        
        // Process HTML files
        $files = array();
        $indexFile = null;
        
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folderPath));
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $relativePath = str_replace($folderPath, '', $file->getPathname());
                $files[] = $relativePath;
                
                if (basename($file->getPathname()) === 'index.html') {
                    $indexFile = $relativePath;
                }
                
                if (strtolower(pathinfo($file->getPathname(), PATHINFO_EXTENSION)) === 'html') {
                    processHTML($file->getPathname());
                }
            }
        }
        
        return array(
            'success' => true,
            'folder_path' => $folderPath,
            'index_file' => $indexFile,
            'files' => $files
        );
    }
    
    return array('success' => false, 'message' => 'Cannot extract ZIP');
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $response = array('success' => false, 'message' => '');
    
    try {
        $file = $_FILES['file'];
        
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Upload error: ' . $file['error']);
        }
        
        if ($file['size'] > $maxFileSize) {
            throw new Exception('File too large. Max: ' . formatBytes($maxFileSize));
        }
        
        $pathInfo = pathinfo($file['name']);
        $extension = strtolower(isset($pathInfo['extension']) ? $pathInfo['extension'] : '');
        
        if (!in_array($extension, $allowedTypes)) {
            throw new Exception('File type not allowed. Supported: ' . implode(', ', $allowedTypes));
        }
        
        $originalName = isset($pathInfo['filename']) ? $pathInfo['filename'] : 'file';
        $uniqueName = $originalName . '_' . time() . '.' . $extension;
        $targetPath = $uploadDir . $uniqueName;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
            $host = $_SERVER['HTTP_HOST'];
            $publicUrl = $protocol . $host . '/' . $targetPath;
            
            if ($extension === 'zip') {
                $extractResult = extractZip($targetPath, $uploadDir);
                
                if ($extractResult['success']) {
                    unlink($targetPath);
                    
                    $folderName = basename($extractResult['folder_path']);
                    $folderUrl = $protocol . $host . '/' . $extractResult['folder_path'];
                    
                    $indexUrl = null;
                    if ($extractResult['index_file']) {
                        $indexUrl = $folderUrl . $extractResult['index_file'];
                    }
                    
                    if (!isset($_SESSION['uploaded_files'])) {
                        $_SESSION['uploaded_files'] = array();
                    }
                    
                    $_SESSION['uploaded_files'][] = array(
                        'name' => $file['name'],
                        'unique_name' => $folderName,
                        'size' => $file['size'],
                        'extension' => 'folder',
                        'upload_time' => time(),
                        'path' => $extractResult['folder_path'],
                        'public_url' => $folderUrl,
                        'index_url' => $indexUrl,
                        'files' => $extractResult['files'],
                        'is_folder' => true
                    );
                    
                    $response['success'] = true;
                    $response['message'] = 'HTML folder uploaded successfully!';
                    $response['file_url'] = $indexUrl ? $indexUrl : $folderUrl;
                    $response['folder_url'] = $folderUrl;
                    $response['index_url'] = $indexUrl;
                    $response['redirect'] = 'index.php';
                }
            } else {
                if ($extension === 'html') {
                    processHTML($targetPath);
                }
                
                if (!isset($_SESSION['uploaded_files'])) {
                    $_SESSION['uploaded_files'] = array();
                }
                
                $_SESSION['uploaded_files'][] = array(
                    'name' => $file['name'],
                    'unique_name' => $uniqueName,
                    'size' => $file['size'],
                    'extension' => $extension,
                    'upload_time' => time(),
                    'path' => $targetPath,
                    'public_url' => $publicUrl,
                    'is_folder' => false,
                    'watermarked' => ($extension === 'html') ? true : false
                );
                
                $response['success'] = true;
                $response['message'] = 'File uploaded successfully!' . (($extension === 'html') ? ' (With watermark)' : '');
                $response['file_url'] = $publicUrl;
                $response['redirect'] = 'index.php';
            }
        } else {
            throw new Exception('Failed to save file');
        }
        
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
    
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    } else {
        if ($response['success']) {
            header('Location: index.php?success=' . urlencode($response['message']));
        } else {
            header('Location: index.php?error=' . urlencode($response['message']));
        }
        exit;
    }
}

// Delete folder function
function removeFolder($folderPath) {
    if (!is_dir($folderPath)) return false;
    
    $files = array_diff(scandir($folderPath), array('.', '..'));
    foreach ($files as $file) {
        $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;
        if (is_dir($filePath)) {
            removeFolder($filePath);
        } else {
            unlink($filePath);
        }
    }
    return rmdir($folderPath);
}

// Handle file deletion
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['file'])) {
    $fileToDelete = $_GET['file'];
    
    if (isset($_SESSION['uploaded_files'])) {
        foreach ($_SESSION['uploaded_files'] as $key => $file) {
            if ($file['unique_name'] === $fileToDelete) {
                if (isset($file['is_folder']) && $file['is_folder']) {
                    if (is_dir($file['path'])) {
                        removeFolder($file['path']);
                    }
                } else {
                    if (file_exists($file['path'])) {
                        unlink($file['path']);
                    }
                }
                unset($_SESSION['uploaded_files'][$key]);
                $_SESSION['uploaded_files'] = array_values($_SESSION['uploaded_files']);
                break;
            }
        }
    }
    header('Location: index.php');
    exit;
}

// Get uploaded files
function getUploadedFiles() {
    return isset($_SESSION['uploaded_files']) ? $_SESSION['uploaded_files'] : array();
}
?>