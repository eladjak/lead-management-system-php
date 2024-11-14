# Lead Management System

A comprehensive lead management system built with PHP, designed to efficiently collect and manage customer inquiries. This system provides a user-friendly interface for lead submission and administrative management.

## Features

- 📝 Lead submission form with real-time validation
- 📱 Responsive design for mobile and desktop
- 🔍 Advanced search and filtering capabilities
- 📊 Administrative dashboard for lead management
- ✏️ Edit and update lead information
- 🗑️ Delete leads with confirmation
- 👀 Quick preview of lead details
- 📱 Mobile-optimized tables with horizontal scrolling
- 🔒 Secure data handling and validation

## Technologies Used

- **Frontend:**
  - HTML5
  - CSS3
  - JavaScript/jQuery
  - Bootstrap 5
  - Font Awesome
  - DataTables
  - SweetAlert2

- **Backend:**
  - PHP 7.4+
  - MySQL
  - PDO for database operations

- **Additional Libraries:**
  - DataTables Responsive
  - Bootstrap Icons

## Installation and Running

1. **Prerequisites:**
   - PHP 7.4 or higher
   - MySQL 5.7 or higher
   - Apache/Nginx web server
   - Composer (optional)

2. **Setup:**
   ```bash
   # Clone the repository
   git clone https://github.com/eladjak/lead-management-system-php.git
   cd lead-management-system-php

   # Import database structure
   mysql -u your_username -p your_database_name < database/schema.sql

   # Configure database connection
   cp includes/config.example.php includes/config.php
   # Edit config.php with your database credentials
   ```

3. **Configuration:**
   - Update database credentials in `includes/config.php`
   - Ensure proper permissions on directories
   - Configure your web server to point to the project directory

4. **Running:**
   - Access the application through your web server
   - Default URLs:
     - Lead Form: `http://localhost/lead-management-system-php/`
     - Admin Panel: `http://localhost/lead-management-system-php/admin.php`

## File Structure 
lead-management-system-php/
├── assets/
│ ├── css/
│ │ └── style.css
│ └── js/
│ ├── main.js
│ └── admin.js
├── includes/
│ ├── config.php
│ └── db.php
├── database/
│ └── schema.sql
├── admin.php
├── index.php
├── process_lead.php
├── update_lead.php
├── delete_lead.php
├── get_lead.php
└── README.md


## Notes

- Ensure proper security measures in production
- Regularly backup your database
- Keep dependencies updated
- Monitor error logs
- Test thoroughly before deployment

## Developer

Elad Ya'akobovitch, a 37-year-old full-stack developer with certification from John Bryce College. Passionate about technology, creativity, and personal growth. Currently seeking opportunities in the high-tech industry.

### Contact Information

- Email: eladhiteclearning@gmail.com
- LinkedIn: [linkedin.com/in/eladyaakobovitchcodingdeveloper](https://www.linkedin.com/in/eladyaakobovitchcodingdeveloper/)
- GitHub: [github.com/eladjak](https://github.com/eladjak)
- Phone: +972 52-542-7474

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.