<?php
session_start();

// Configuration
$uploadDir = 'uploads/';
$maxFileSize = 5 * 1024 * 1024; // 5MB
$allowedExtensions = ['html', 'css', 'js', 'txt', 'zip'];
$maxFolderSize = 20 * 1024 * 1024; // 20MB for folder uploads

// Create upload directory if it doesn't exist
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

function getUserIP() {
    $ipkeys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
    foreach ($ipkeys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

function formatFileSize($bytes) {
    if ($bytes < 1024) return $bytes . ' bytes';
    elseif ($bytes < 1048576) return round($bytes / 1024, 2) . ' KB';
    else return round($bytes / 1048576, 2) . ' MB';
}

function getFileIcon($extension) {
    $icons = [
        'html' => 'fab fa-html5',
        'css' => 'fab fa-css3-alt',  
        'js' => 'fab fa-js-square',
        'txt' => 'fas fa-file-alt',
        'zip' => 'fas fa-file-archive',
        'folder' => 'fas fa-folder'
    ];
    return $icons[$extension] ?? 'fas fa-file';
}

// Function to extract ZIP files and handle HTML folder uploads
function extractHtmlFolder($zipFile, $uploadDir) {
    $zip = new ZipArchive;
    $extractPath = $uploadDir . 'folder_' . time() . '/';
    
    if ($zip->open($zipFile) === TRUE) {
        // Create extraction directory
        if (!is_dir($extractPath)) {
            mkdir($extractPath, 0755, true);
        }
        
        $zip->extractTo($extractPath);
        $zip->close();
        
        // Look for index.html in the extracted folder
        $indexFile = null;
        $folderStructure = scanFolderForIndex($extractPath);
        
        if ($folderStructure['index_file']) {
            $indexFile = $folderStructure['index_file'];
        }
        
        return [
            'success' => true,
            'folder_path' => $extractPath,
            'index_file' => $indexFile,
            'files' => $folderStructure['files']
        ];
    } else {
        return ['success' => false, 'message' => 'Could not extract ZIP file'];
    }
}

// Function to get watermark configuration
function getWatermarkConfig() {
    // Default configuration
    $defaultConfig = [
        'enabled' => true,
        'text' => '⚡ Free Hosting',
        'link' => 'https://your-app.onrender.com',
        'position' => 'bottom-right',
        'color' => '#FF6B35',
        'opacity' => 0.9,
        'size' => 'small'
    ];
    
    // Load from session if available
    return isset($_SESSION['watermark_config']) ? $_SESSION['watermark_config'] : $defaultConfig;
}

// Function to inject watermark into HTML files
function injectWatermark($htmlContent) {
    $config = getWatermarkConfig();
    
    // Check if watermarks are enabled
    if (!$config['enabled']) {
        return $htmlContent;
    }
    
    // Position classes
    $positionMap = [
        'bottom-right' => 'bottom: 10px; right: 10px;',
        'bottom-left' => 'bottom: 10px; left: 10px;',
        'top-right' => 'top: 10px; right: 10px;',
        'top-left' => 'top: 10px; left: 10px;'
    ];
    
    // Size settings
    $sizeMap = [
        'small' => 'font-size: 12px; padding: 8px 15px;',
        'medium' => 'font-size: 14px; padding: 10px 18px;',
        'large' => 'font-size: 16px; padding: 12px 22px;'
    ];
    
    $position = $positionMap[$config['position']] ?? $positionMap['bottom-right'];
    $size = $sizeMap[$config['size']] ?? $sizeMap['small'];
    
    $watermarkCSS = "
    <style>
    .freehost-watermark {
        position: fixed;
        {$position}
        background: linear-gradient(135deg, {$config['color']} 0%, #FFD23F 100%);
        color: white;
        {$size}
        border-radius: 25px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        z-index: 999999;
        transition: all 0.3s ease;
        opacity: {$config['opacity']};
    }
    .freehost-watermark:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
        opacity: 1;
        color: white;
        text-decoration: none;
    }
    @media (max-width: 768px) {
        .freehost-watermark {
            font-size: 11px;
            padding: 6px 12px;
        }
    }
    </style>";
    
    $watermarkHTML = '<a href="' . htmlspecialchars($config['link']) . '" target="_blank" class="freehost-watermark" title="Free HTML Hosting by Sushil Choudhary">
        ' . htmlspecialchars($config['text']) . '
    </a>';
    
    // Try to inject before closing body tag first
    if (strpos($htmlContent, '</body>') !== false) {
        $htmlContent = str_replace('</body>', $watermarkHTML . '</body>', $htmlContent);
    } else {
        // If no body tag, append at the end
        $htmlContent .= $watermarkHTML;
    }
    
    // Try to inject CSS before closing head tag
    if (strpos($htmlContent, '</head>') !== false) {
        $htmlContent = str_replace('</head>', $watermarkCSS . '</head>', $htmlContent);
    } else {
        // If no head tag, prepend CSS at the beginning
        $htmlContent = $watermarkCSS . $htmlContent;
    }
    
    return $htmlContent;
}

// Function to process HTML files and add watermarks
function processHTMLFile($filePath) {
    if (pathinfo($filePath, PATHINFO_EXTENSION) === 'html') {
        $content = file_get_contents($filePath);
        $watermarkedContent = injectWatermark($content);
        file_put_contents($filePath, $watermarkedContent);
        return true;
    }
    return false;
}

// Function to scan folder for index.html and get file structure
function scanFolderForIndex($folderPath) {
    $files = [];
    $indexFile = null;
    
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($folderPath)
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $relativePath = str_replace($folderPath, '', $file->getPathname());
            $files[] = $relativePath;
            
            // Check if this is index.html
            if (basename($file->getPathname()) === 'index.html') {
                $indexFile = $relativePath;
            }
            
            // Add watermark to HTML files
            if (pathinfo($file->getPathname(), PATHINFO_EXTENSION) === 'html') {
                processHTMLFile($file->getPathname());
            }
        }
    }
    
    return [
        'files' => $files,
        'index_file' => $indexFile
    ];
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $response = ['success' => false, 'message' => ''];
    
    try {
        $file = $_FILES['file'];
        
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('File upload error: ' . $file['error']);
        }
        
        // Check file size
        if ($file['size'] > $maxFileSize) {
            throw new Exception('File too large. Maximum size: ' . formatFileSize($maxFileSize));
        }
        
        // Check file extension
        $pathInfo = pathinfo($file['name']);
        $extension = strtolower($pathInfo['extension'] ?? '');
        
        if (!in_array($extension, $allowedExtensions)) {
            throw new Exception('File type not allowed. Supported: ' . implode(', ', $allowedExtensions));
        }
        
        // Generate unique filename
        $originalName = $pathInfo['filename'];
        $uniqueName = $originalName . '_' . time() . '.' . $extension;
        $targetPath = $uploadDir . $uniqueName;
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            // Generate public URL for the file
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
            $host = $_SERVER['HTTP_HOST'];
            $publicUrl = $protocol . $host . '/' . $targetPath;
            
            // Handle ZIP files (HTML folder uploads)
            if ($extension === 'zip') {
                $extractResult = extractHtmlFolder($targetPath, $uploadDir);
                
                if ($extractResult['success']) {
                    // Delete the ZIP file after extraction
                    unlink($targetPath);
                    
                    $folderName = basename($extractResult['folder_path']);
                    $folderUrl = $protocol . $host . '/' . $extractResult['folder_path'];
                    
                    // Generate index.html URL if found
                    $indexUrl = null;
                    if ($extractResult['index_file']) {
                        $indexUrl = $folderUrl . $extractResult['index_file'];
                    }
                    
                    // Store folder info in session
                    if (!isset($_SESSION['uploaded_files'])) {
                        $_SESSION['uploaded_files'] = [];
                    }
                    
                    $_SESSION['uploaded_files'][] = [
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
                    ];
                    
                    $response['success'] = true;
                    $response['message'] = 'HTML folder uploaded successfully!';
                    $response['file_url'] = $indexUrl ? $indexUrl : $folderUrl;
                    $response['folder_url'] = $folderUrl;
                    $response['index_url'] = $indexUrl;
                    $response['redirect'] = 'index.php';
                } else {
                    throw new Exception('Failed to extract HTML folder: ' . $extractResult['message']);
                }
            } else {
                // Regular file upload
                // Add watermark to HTML files
                if ($extension === 'html') {
                    processHTMLFile($targetPath);
                }
                
                // Store file info in session
                if (!isset($_SESSION['uploaded_files'])) {
                    $_SESSION['uploaded_files'] = [];
                }
                
                $_SESSION['uploaded_files'][] = [
                    'name' => $file['name'],
                    'unique_name' => $uniqueName,
                    'size' => $file['size'],
                    'extension' => $extension,
                    'upload_time' => time(),
                    'path' => $targetPath,
                    'public_url' => $publicUrl,
                    'is_folder' => false,
                    'watermarked' => $extension === 'html' ? true : false
                ];
                
                $response['success'] = true;
                $response['message'] = 'File uploaded successfully!' . ($extension === 'html' ? ' (With watermark added)' : '');
                $response['file_url'] = $publicUrl;
                $response['redirect'] = 'index.php';
            }
        } else {
            throw new Exception('Failed to save file');
        }
        
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
    
    // Return JSON response for AJAX or redirect for regular form
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

// Function to recursively delete folder
function deleteFolder($folderPath) {
    if (!is_dir($folderPath)) {
        return false;
    }
    
    $files = array_diff(scandir($folderPath), array('.', '..'));
    foreach ($files as $file) {
        $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;
        if (is_dir($filePath)) {
            deleteFolder($filePath);
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
                // Delete physical file or folder
                if (isset($file['is_folder']) && $file['is_folder']) {
                    // Delete entire folder
                    if (is_dir($file['path'])) {
                        deleteFolder($file['path']);
                    }
                } else {
                    // Delete single file
                    if (file_exists($file['path'])) {
                        unlink($file['path']);
                    }
                }
                // Remove from session
                unset($_SESSION['uploaded_files'][$key]);
                $_SESSION['uploaded_files'] = array_values($_SESSION['uploaded_files']);
                break;
            }
        }
    }
    
    header('Location: index.php');
    exit;
}

// Handle file editing
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['file'])) {
    $fileToEdit = $_GET['file'];
    $fileContent = '';
    $fileName = '';
    
    if (isset($_SESSION['uploaded_files'])) {
        foreach ($_SESSION['uploaded_files'] as $file) {
            if ($file['unique_name'] === $fileToEdit) {
                if (file_exists($file['path'])) {
                    $fileContent = file_get_contents($file['path']);
                    $fileName = $file['name'];
                }
                break;
            }
        }
    }
    
    // Return file content for editing
    include 'edit.php';
    exit;
}

// Save edited file
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_file']) && isset($_POST['file_name']) && isset($_POST['file_content'])) {
    $fileToSave = $_POST['file_name'];
    $content = $_POST['file_content'];
    
    if (isset($_SESSION['uploaded_files'])) {
        foreach ($_SESSION['uploaded_files'] as $file) {
            if ($file['unique_name'] === $fileToSave) {
                if (file_put_contents($file['path'], $content) !== false) {
                    header('Location: index.php?success=File saved successfully!');
                } else {
                    header('Location: index.php?error=Failed to save file');
                }
                exit;
            }
        }
    }
    
    header('Location: index.php?error=File not found');
    exit;
}

// Get uploaded files for display
function getUploadedFiles() {
    $files = $_SESSION['uploaded_files'] ?? [];
    
    // Generate public URLs for existing files if not already set
    foreach ($files as $index => $file) {
        if (!isset($file['public_url']) && isset($file['path'])) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
            $host = $_SERVER['HTTP_HOST'];
            $publicUrl = $protocol . $host . '/' . $file['path'];
            $files[$index]['public_url'] = $publicUrl;
        }
    }
    
    // Update session with URLs
    $_SESSION['uploaded_files'] = $files;
    
    return $files;
}

// Main page display
$uploadedFiles = getUploadedFiles();
$userIP = getUserIP();
?>