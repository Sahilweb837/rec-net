<?php
require_once __DIR__ . '/includes/header.php';

// Fetch stats
$stats = [
    'total_students' => 0,
    'active_students' => 0,
    'running_courses' => 0,
    'monthly_collection' => 0
];

if($conn) {
    // Total Students
    $res = $conn->query("SELECT COUNT(id) as count FROM students");
    if($res) $stats['total_students'] = $res->fetch_assoc()['count'];

    // Active Students
    $res = $conn->query("SELECT COUNT(id) as count FROM students WHERE status='Active'");
    if($res) $stats['active_students'] = $res->fetch_assoc()['count'];

    // Running Courses
    $res = $conn->query("SELECT COUNT(id) as count FROM courses WHERE status='Active'");
    if($res) $stats['running_courses'] = $res->fetch_assoc()['count'];

    // Monthly Collection (Current Month)
    $current_month = date('Y-m'); // e.g., 2026-06
    $res = $conn->query("SELECT SUM(amount_paid) as total FROM fees_collection WHERE DATE_FORMAT(payment_date, '%Y-%m') = '$current_month'");
    if($res) {
        $row = $res->fetch_assoc();
        $stats['monthly_collection'] = $row['total'] ? $row['total'] : 0;
    }
}
?>

<div class="page-header">
    <h1 class="page-title">Dashboard Overview</h1>
    <div>
        <a href="<?php echo $base_url; ?>modules/admissions/new.php" class="btn btn-primary"><i class="fas fa-plus"></i> New Admission</a>
        <a href="<?php echo $base_url; ?>modules/fees/collect.php" class="btn btn-success"><i class="fas fa-rupee-sign"></i> Collect Fee</a>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-details">
            <h3><?php echo number_format($stats['total_students']); ?></h3>
            <p>Total Students</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon success">
            <i class="fas fa-user-check"></i>
        </div>
        <div class="stat-details">
            <h3><?php echo number_format($stats['active_students']); ?></h3>
            <p>Active Students</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon warning">
            <i class="fas fa-laptop-code"></i>
        </div>
        <div class="stat-details">
            <h3><?php echo number_format($stats['running_courses']); ?></h3>
            <p>Running Courses</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon danger">
            <i class="fas fa-wallet"></i>
        </div>
        <div class="stat-details">
            <h3>₹<?php echo number_format($stats['monthly_collection'], 2); ?></h3>
            <p>Monthly Collection</p>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="form-col" style="flex: 2;">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Admissions</h3>
                <a href="<?php echo $base_url; ?>modules/admissions/list.php" class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($conn) {
                            $query = "SELECT a.admission_date, s.student_id, s.full_name, c.course_name, s.status 
                                      FROM admissions a 
                                      JOIN students s ON a.student_id = s.id 
                                      JOIN courses c ON a.course_id = c.id 
                                      ORDER BY a.id DESC LIMIT 5";
                            $res = $conn->query($query);
                            if($res && $res->num_rows > 0) {
                                while($row = $res->fetch_assoc()) {
                                    $status_class = $row['status'] == 'Active' ? 'badge-success' : 'badge-warning';
                                    echo "<tr>
                                            <td>{$row['student_id']}</td>
                                            <td>{$row['full_name']}</td>
                                            <td>{$row['course_name']}</td>
                                            <td>" . date('d M Y', strtotime($row['admission_date'])) . "</td>
                                            <td><span class='badge {$status_class}'>{$row['status']}</span></td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' style='text-align:center;'>No recent admissions</td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="form-col" style="flex: 1;">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Today's Receipts</h3>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Receipt</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($conn) {
                            $today = date('Y-m-d');
                            $query = "SELECT receipt_no, amount_paid FROM fees_collection WHERE payment_date = '$today' ORDER BY id DESC LIMIT 5";
                            $res = $conn->query($query);
                            if($res && $res->num_rows > 0) {
                                while($row = $res->fetch_assoc()) {
                                    echo "<tr>
                                            <td><i class='fas fa-receipt' style='color:var(--text-secondary);margin-right:5px;'></i> {$row['receipt_no']}</td>
                                            <td style='font-weight:600;color:var(--secondary-color);'>₹{$row['amount_paid']}</td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2' style='text-align:center;color:var(--text-secondary);'>No receipts today</td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
