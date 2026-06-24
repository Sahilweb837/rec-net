<?php
require_once __DIR__ . '/../../includes/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$is_edit = $id > 0;

$course = [
    'course_name' => '',
    'duration_months' => '',
    'total_fee' => '',
    'monthly_fee' => '',
    'registration_fee' => '0',
    'exam_fee' => '0',
    'certificate_fee' => '0',
    'description' => '',
    'status' => 'Active'
];

if($is_edit && $conn) {
    $res = $conn->query("SELECT * FROM courses WHERE id = $id");
    if($res && $res->num_rows > 0) {
        $course = $res->fetch_assoc();
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_course'])) {
    $name = $conn->real_escape_string($_POST['course_name']);
    $duration = (int)$_POST['duration_months'];
    $total = (float)$_POST['total_fee'];
    $monthly = (float)$_POST['monthly_fee'];
    $reg = (float)$_POST['registration_fee'];
    $exam = (float)$_POST['exam_fee'];
    $cert = (float)$_POST['certificate_fee'];
    $desc = $conn->real_escape_string($_POST['description']);
    $status = $conn->real_escape_string($_POST['status']);

    if($is_edit) {
        $sql = "UPDATE courses SET 
                course_name='$name', duration_months=$duration, total_fee=$total, 
                monthly_fee=$monthly, registration_fee=$reg, exam_fee=$exam, 
                certificate_fee=$cert, description='$desc', status='$status' 
                WHERE id=$id";
    } else {
        $sql = "INSERT INTO courses (course_name, duration_months, total_fee, monthly_fee, registration_fee, exam_fee, certificate_fee, description, status) 
                VALUES ('$name', $duration, $total, $monthly, $reg, $exam, $cert, '$desc', '$status')";
    }

    if($conn->query($sql)) {
        echo "<script>alert('Course saved successfully!'); window.location.href='list.php';</script>";
    } else {
        $error = "Error saving course: " . $conn->error;
    }
}
?>

<div class="page-header">
    <h1 class="page-title"><?php echo $is_edit ? 'Edit' : 'Add New'; ?> Course</h1>
    <a href="list.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back to List</a>
</div>

<div class="card">
    <?php if(isset($error)) echo "<div style='color:red;margin-bottom:1rem;'>$error</div>"; ?>
    <form method="POST" action="">
        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">Course Name *</label>
                    <input type="text" name="course_name" class="form-control" value="<?php echo htmlspecialchars($course['course_name']); ?>" required placeholder="e.g. Full Stack Development">
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">Duration (Months) *</label>
                    <input type="number" name="duration_months" class="form-control" value="<?php echo $course['duration_months']; ?>" required placeholder="e.g. 6">
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">Total Fee (₹) *</label>
                    <input type="number" step="0.01" name="total_fee" class="form-control" value="<?php echo $course['total_fee']; ?>" required>
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">Monthly Fee (₹) *</label>
                    <input type="number" step="0.01" name="monthly_fee" class="form-control" value="<?php echo $course['monthly_fee']; ?>" required>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">Registration Fee (₹)</label>
                    <input type="number" step="0.01" name="registration_fee" class="form-control" value="<?php echo $course['registration_fee']; ?>">
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">Exam Fee (₹)</label>
                    <input type="number" step="0.01" name="exam_fee" class="form-control" value="<?php echo $course['exam_fee']; ?>">
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label class="form-label">Certificate Fee (₹)</label>
                    <input type="number" step="0.01" name="certificate_fee" class="form-control" value="<?php echo $course['certificate_fee']; ?>">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Course Description</label>
            <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($course['description']); ?></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="Active" <?php echo $course['status'] == 'Active' ? 'selected' : ''; ?>>Active</option>
                <option value="Inactive" <?php echo $course['status'] == 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
            </select>
        </div>

        <button type="submit" name="save_course" class="btn btn-success"><i class="fas fa-save"></i> Save Course</button>
    </form>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
