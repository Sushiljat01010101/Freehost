# 🚀 Free HTML Hosting Platform

A comprehensive PHP-based HTML hosting platform with automatic watermark injection, perfect for hosting HTML/CSS/JS websites with built-in branding protection.

## ✨ Features

### Core Hosting Features
- **File Upload**: Drag & drop HTML, CSS, JS, TXT, and ZIP files
- **ZIP Extraction**: Automatic extraction and hosting of ZIP folders
- **Instant URLs**: Generate public URLs for all uploaded files
- **Mobile Responsive**: Works perfectly on all devices

### 🎨 Watermark System
- **Automatic Injection**: All HTML files get watermarks automatically
- **Customizable**: Change text, position, colors, size, and opacity
- **Non-removable**: Users cannot remove watermarks from hosted sites
- **Professional Design**: Modern glassmorphism styling with animations

### 🛠️ Admin Features
- **Settings Panel**: Full watermark customization interface
- **Live Preview**: See changes in real-time
- **File Management**: View, copy URLs, and delete uploaded files
- **Analytics Ready**: Built-in structure for usage tracking

## 🌐 Deployment Options

### Option 1: Render (Recommended)
**Best for production use**
- ✅ No PHP restrictions
- ✅ Free SSL certificates
- ✅ GitHub integration
- ✅ Better performance
- ✅ Custom domains supported

[📖 Follow Render Deployment Guide](RENDER-DEPLOYMENT.md)

### Option 2: InfinityFree
**Budget option with limitations**
- ⚠️ PHP code restrictions
- ⚠️ Limited file operations
- ✅ Completely free
- ✅ cPanel access

[📖 Follow InfinityFree Guide](DEPLOYMENT-GUIDE.md)

## 🚀 Quick Start (Render)

1. **Fork this repository** to your GitHub account

2. **Sign up at Render.com** and create a new Web Service

3. **Connect your GitHub repository** and configure:
   ```
   Build Command: composer install --no-dev
   Start Command: php -S 0.0.0.0:$PORT -t .
   ```

4. **Deploy** and visit your new URL!

5. **Configure watermarks** at `/watermark-settings.php`

## 📁 File Structure

```
/
├── index.php              # Main homepage with upload interface
├── upload.php             # Backend file handling and watermark injection
├── watermark-settings.php # Admin panel for watermark customization
├── analytics.php          # Usage analytics dashboard
├── dashboard.php          # File management interface
├── templates.php          # Pre-built website templates
├── help.php              # User tutorials and help
├── composer.json          # PHP dependencies for Render
├── render.yaml           # Render deployment configuration
└── uploads/              # Directory for user-uploaded files
```

## 🎨 Customization

### Update Branding
1. Change platform name in `index.php`
2. Update watermark default text in `upload.php`
3. Modify color scheme in CSS variables
4. Replace social media links in footer

### Watermark Settings
Access the admin panel at `/watermark-settings.php` to customize:
- Watermark text and link
- Position (4 corners available)
- Colors and opacity
- Size (small/medium/large)
- Enable/disable functionality

## 🔧 Technical Details

### Requirements
- PHP 8.0+
- ZIP extension enabled
- File upload permissions
- Session support

### Security Features
- File type validation
- Size restrictions (5MB per file, 20MB per ZIP)
- Path sanitization
- Session-based storage

### Watermark Implementation
- CSS injection into HTML files
- Fixed positioning with high z-index
- Responsive design for mobile devices
- Hover effects and animations

## 📊 Performance

### Optimizations
- Minimal PHP dependencies
- Efficient file handling
- CSS/JS minification ready
- Mobile-first responsive design

### Scalability
- Session-based file tracking
- Modular code structure
- Database integration ready
- Cloud storage compatible

## 🎯 Use Cases

### Perfect For:
- **Web Developers**: Showcase client work with branding
- **Agencies**: Host client sites with watermarks
- **Students**: Share projects with attribution
- **Freelancers**: Demo work with built-in marketing

### Industries:
- Web development agencies
- Educational institutions
- Portfolio hosting services
- Client demo platforms

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

## 👨‍💻 Author

**Sushil Choudhary**
- GitHub: [@sushilchoudhary](https://github.com/sushilchoudhary)
- Website: [Your Website](https://your-website.com)

## 🙏 Acknowledgments

- Built with modern PHP and responsive design principles
- Inspired by the need for affordable hosting solutions
- Designed for InfinityFree and Render compatibility

---

**Made with ❤️ for the developer community**

*Transform your HTML hosting business with automatic watermarking!*