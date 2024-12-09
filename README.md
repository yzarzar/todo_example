# PHP Todo Application

A simple and elegant todo application built with PHP and MySQL.

## Features

### User Authentication
- Secure login system
- Session-based authentication
- Protected routes for authenticated users only

### Todo Management
- Create new todos with titles
- View list of all todos
- Delete completed todos
- User-specific todos (each user can only see their own todos)

### User Interface
- Clean and modern design using Tailwind CSS
- Responsive layout that works on all devices
- Intuitive user interactions
- Real-time feedback on actions

### Security Features
- SQL injection prevention
- XSS protection through HTML entity encoding
- Session security measures
- Form validation and sanitization

## Project Structure

```
src/
├── app/         # Core application files
├── config/      # Configuration files
├── helpers/     # Helper functions
├── views/       # View templates
└── css/         # Styling files
```

## Requirements
- PHP 7.4+
- MySQL 5.7+
- Web server (Apache/Nginx)
- Modern web browser

## Getting Started
1. Clone the repository
2. Set up your database credentials in `src/config/connect_db.php`
3. Import the database schema
4. Start your web server
5. Navigate to the application URL

## Contributing
Contributions are welcome! Please feel free to submit a Pull Request.
