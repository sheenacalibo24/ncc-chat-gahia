#!/bin/bash
# NCC Chatbot Installation Script
# This script helps set up the NCC Chatbot on a fresh server

echo "================================================"
echo "  NCC Chatbot - Installation Script"
echo "  Northeastern Cebu Colleges"
echo "================================================"
echo ""

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "❌ PHP is not installed. Please install PHP 7.4 or higher."
    exit 1
fi

echo "✅ PHP is installed: $(php -v | head -n 1)"
echo ""

# Check if MySQL is available
echo "Checking MySQL connection..."
if mysql -u root -e "SELECT 1" &> /dev/null; then
    echo "✅ MySQL connection successful"
else
    echo "⚠️  MySQL connection requires password. You may need to enter credentials."
fi

echo ""
echo "================================================"
echo "  Setup Complete!"
echo "================================================"
echo ""
echo "📌 Next Steps:"
echo "   1. Start XAMPP (Apache + MySQL)"
echo "   2. Open: http://localhost/NCCchat"
echo "   3. The database will be created automatically"
echo ""
echo "📚 Documentation:"
echo "   - README.md - Full documentation"
echo "   - SETUP.md - Quick start guide"
echo ""
echo "🎨 Configuration:"
echo "   - Edit config/db.php to change database settings"
echo "   - Edit views/layouts/style.css to change colors"
echo "   - Edit config/db.php lines 64-76 to add more FAQ"
echo ""
