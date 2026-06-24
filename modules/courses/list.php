<?php
require_once __DIR__ . '/../../includes/header.php';

// Handle delete
if(isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM courses WHERE id = $id");
    echo "<script>window.location.href='list.php';</script>";
}
?>

<div class="page-header">
    <h1 class="page-title">Courses List</h1>
    <a href="add.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Course</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Course Name</th>
                    <th>Duration</th>
                    <th>Total Fee</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if($conn) {
                    $res = $conn->query("SELECT * FROM courses ORDER BY id DESC");
                    if($res && $res->num_rows > 0) {
                        while($row = $res->fetch_assoc()) {
                            $status_class = $row['status'] == 'Active' ? 'badge-success' : 'badge-danger';
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td><strong>{$row['course_name']}</strong></td>
                                    <td>{$row['duration_months']} Months</td>
                                    <td>₹" . number_format($row['total_fee'], 2) . "</td>
                                    <td><span class='badge {$status_class}'>{$row['status']}</span></td>
                                    <td>
                                        <a href='add.php?id={$row['id']}' class='btn btn-primary' style='padding:0.3rem 0.6rem;font-size:0.8rem;'><i class='fas fa-edit'></i></a>
                                        <a href='list.php?delete={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this course?\");' class='btn btn-danger' style='padding:0.3rem 0.6rem;font-size:0.8rem;'><i class='fas fa-trash'></i></a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' style='text-align:center;'>No courses found. <a href='add.php'>Add one now</a>.</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
