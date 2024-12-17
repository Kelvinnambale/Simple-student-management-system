# Student Management System

A simple web application for managing student information using PHP and MySQL. 
This project allows users to add, update, and delete student records while adhering to basic security practices by sanitizing user input.

## Features

- **Add New Student**: Form to add new student details such as name, email, and age.
- **Edit Student**: Enable editing of existing student records.
- **Delete Student**: Remove student records safely with confirmation.
- **View Students**: Display a list of all students in a table format.
- **Input Sanitization**: Protects against SQL injection by sanitizing user inputs.
  
## Technologies Used

- PHP
- MySQL
- HTML/CSS
- JavaScript (for confirmation prompts)

## Installation

### Prerequisites

- Web server (e.g., Apache)
- Xampp

### Step-by-Step Guide

1. **Clone the Repository**:
    ```bash
    git clone https://github.com/yourusername/student-management-system.git
    ```

2. **Set Up the Database**:
    - Create a MySQL database named `student_management`.
    - Run the following SQL command to create a `students` table:
    ```sql
    CREATE TABLE students (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        age INT(3) NOT NULL
    );
    ```

3. **Configure Database Connection**:
    - Open the `config.php` file located at the root of the project.
    - Update the `$servername`, `$username`, `$password`, and `$dbname` variables as needed.

4. **Run the Application**:
    - Move the project files to your web server's root directory (e.g., `htdocs` for XAMPP).
    - Access the application via your web browser at `http://localhost/student-management-system`.

## Usage

- **Add a Student**: Fill out the form at the top of the page and click the "Add Student" button.
- **Edit a Student**: Click the "Edit" button next to the student you wish to modify.
- **Delete a Student**: Click the "Delete" button next to the student you wish to remove and confirm the deletion.

## Files Overview

- `config.php`: Handles database connection and main logic for CRUD operations.
- `index.php`: Main page for displaying the form and student list.
- HTML/CSS: Provides the basic layout and styling for the web application.

## Contributing

Contributions are welcome! Feel free to submit a pull request or open an issue for any feature suggestions or bug reports.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Author

[Kelvin Nambale](https://github.com/kelvinnambale)

