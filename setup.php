<?php
$host = 'localhost';
$user = 'root';
$pass = '';

// Connect to MySQL
$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS institute_erp";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the database
$conn->select_db("institute_erp");

// Table creation queries
$tables = [
    "CREATE TABLE IF NOT EXISTS settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        institute_name VARCHAR(100) NOT NULL,
        address TEXT,
        phone VARCHAR(20),
        email VARCHAR(100),
        logo_path VARCHAR(255),
        receipt_prefix VARCHAR(10) DEFAULT 'REC-',
        sms_api_key VARCHAR(255)
    )",
    
    "CREATE TABLE IF NOT EXISTS courses (
        id INT AUTO_INCREMENT PRIMARY KEY,
        course_name VARCHAR(100) NOT NULL,
        duration_months INT NOT NULL,
        total_fee DECIMAL(10,2) NOT NULL,
        monthly_fee DECIMAL(10,2) NOT NULL,
        registration_fee DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        exam_fee DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        certificate_fee DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        description TEXT,
        status ENUM('Active', 'Inactive') DEFAULT 'Active'
    )",

    "CREATE TABLE IF NOT EXISTS trainers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        trainer_id VARCHAR(20) UNIQUE NOT NULL,
        name VARCHAR(100) NOT NULL,
        mobile VARCHAR(15) NOT NULL,
        email VARCHAR(100),
        qualification VARCHAR(100),
        specialization VARCHAR(100),
        salary DECIMAL(10,2),
        status ENUM('Active', 'Inactive') DEFAULT 'Active'
    )",

    "CREATE TABLE IF NOT EXISTS batches (
        id INT AUTO_INCREMENT PRIMARY KEY,
        batch_name VARCHAR(100) NOT NULL,
        course_id INT,
        trainer_id INT,
        start_date DATE,
        end_date DATE,
        time_slot VARCHAR(50),
        status ENUM('Upcoming', 'Running', 'Completed') DEFAULT 'Upcoming',
        FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL,
        FOREIGN KEY (trainer_id) REFERENCES trainers(id) ON DELETE SET NULL
    )",

    "CREATE TABLE IF NOT EXISTS students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id VARCHAR(20) UNIQUE NOT NULL,
        full_name VARCHAR(100) NOT NULL,
        father_name VARCHAR(100),
        mother_name VARCHAR(100),
        mobile VARCHAR(15) NOT NULL,
        alt_mobile VARCHAR(15),
        email VARCHAR(100),
        dob DATE,
        gender ENUM('Male', 'Female', 'Other'),
        address TEXT,
        aadhaar VARCHAR(20),
        qualification VARCHAR(100),
        photo_path VARCHAR(255),
        admission_date DATE,
        status ENUM('Active', 'Completed', 'Dropped') DEFAULT 'Active'
    )",

    "CREATE TABLE IF NOT EXISTS admissions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT,
        course_id INT,
        batch_id INT,
        admission_date DATE,
        course_start_date DATE,
        course_end_date DATE,
        total_payable_fee DECIMAL(10,2),
        discount DECIMAL(10,2) DEFAULT 0.00,
        FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
        FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE RESTRICT,
        FOREIGN KEY (batch_id) REFERENCES batches(id) ON DELETE SET NULL
    )",

    "CREATE TABLE IF NOT EXISTS installments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        admission_id INT,
        installment_no INT,
        due_date DATE,
        amount DECIMAL(10,2),
        status ENUM('Pending', 'Paid') DEFAULT 'Pending',
        FOREIGN KEY (admission_id) REFERENCES admissions(id) ON DELETE CASCADE
    )",

    "CREATE TABLE IF NOT EXISTS fees_collection (
        id INT AUTO_INCREMENT PRIMARY KEY,
        receipt_no VARCHAR(50) UNIQUE NOT NULL,
        student_id INT,
        course_id INT,
        installment_id INT,
        month VARCHAR(20),
        amount_paid DECIMAL(10,2),
        fine DECIMAL(10,2) DEFAULT 0.00,
        discount DECIMAL(10,2) DEFAULT 0.00,
        payment_method ENUM('Cash', 'UPI', 'Bank Transfer', 'Card'),
        payment_date DATE,
        FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE RESTRICT,
        FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE RESTRICT,
        FOREIGN KEY (installment_id) REFERENCES installments(id) ON DELETE SET NULL
    )",

    "CREATE TABLE IF NOT EXISTS attendance (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT,
        batch_id INT,
        date DATE,
        status ENUM('Present', 'Absent', 'Leave'),
        FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
        FOREIGN KEY (batch_id) REFERENCES batches(id) ON DELETE CASCADE
    )",

    "CREATE TABLE IF NOT EXISTS exams (
        id INT AUTO_INCREMENT PRIMARY KEY,
        course_id INT,
        subject VARCHAR(100),
        date DATE,
        FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
    )",

    "CREATE TABLE IF NOT EXISTS exam_results (
        id INT AUTO_INCREMENT PRIMARY KEY,
        exam_id INT,
        student_id INT,
        marks DECIMAL(5,2),
        grade ENUM('A+', 'A', 'B', 'C', 'Fail'),
        FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE,
        FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
    )",

    "CREATE TABLE IF NOT EXISTS certificates (
        id INT AUTO_INCREMENT PRIMARY KEY,
        certificate_no VARCHAR(50) UNIQUE NOT NULL,
        student_id INT,
        course_id INT,
        duration VARCHAR(50),
        grade VARCHAR(10),
        completion_date DATE,
        issue_date DATE,
        FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
        FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
    )",
    
    "CREATE TABLE IF NOT EXISTS admin_users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('Admin', 'Staff') DEFAULT 'Admin',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )"
];

foreach ($tables as $query) {
    if ($conn->query($query) === TRUE) {
        echo "Table created successfully<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }
}

// Insert default settings
$check_settings = $conn->query("SELECT id FROM settings LIMIT 1");
if ($check_settings->num_rows == 0) {
    $conn->query("INSERT INTO settings (institute_name, receipt_prefix) VALUES ('ABC Computer Institute', 'REC-')");
    echo "Default settings inserted.<br>";
}

// Insert default admin
$check_admin = $conn->query("SELECT id FROM admin_users LIMIT 1");
if ($check_admin->num_rows == 0) {
    $hashed = password_hash('admin123', PASSWORD_DEFAULT);
    $conn->query("INSERT INTO admin_users (username, password, role) VALUES ('admin', '$hashed', 'Admin')");
    echo "Default admin user (admin/admin123) created.<br>";
}

echo "<br><strong>Setup Complete!</strong> <a href='index.php'>Go to Dashboard</a>";
$conn->close();
?>
