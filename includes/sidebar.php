<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <i class="fas fa-laptop-code"></i> Institute ERP
    </div>
    <ul class="sidebar-menu">
        <li>
            <a href="<?php echo $base_url; ?>index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </li>
        
        <li style="padding: 1rem 1rem 0.5rem; font-size: 0.75rem; text-transform: uppercase; color: #818cf8; font-weight: 600; letter-spacing: 0.05em;">Management</li>
        
        <li>
            <a href="<?php echo $base_url; ?>modules/admissions/list.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'admissions') !== false ? 'active' : ''; ?>">
                <i class="fas fa-user-plus"></i> Admissions
            </a>
        </li>
        <li>
            <a href="<?php echo $base_url; ?>modules/students/list.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'students') !== false ? 'active' : ''; ?>">
                <i class="fas fa-user-graduate"></i> Students
            </a>
        </li>
        <li>
            <a href="<?php echo $base_url; ?>modules/courses/list.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'courses') !== false ? 'active' : ''; ?>">
                <i class="fas fa-book-open"></i> Courses
            </a>
        </li>
        <li>
            <a href="<?php echo $base_url; ?>modules/batches/list.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'batches') !== false ? 'active' : ''; ?>">
                <i class="fas fa-users"></i> Batches
            </a>
        </li>
        <li>
            <a href="<?php echo $base_url; ?>modules/trainers/list.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'trainers') !== false ? 'active' : ''; ?>">
                <i class="fas fa-chalkboard-teacher"></i> Trainers
            </a>
        </li>

        <li style="padding: 1rem 1rem 0.5rem; font-size: 0.75rem; text-transform: uppercase; color: #818cf8; font-weight: 600; letter-spacing: 0.05em;">Finance & Ops</li>

        <li>
            <a href="<?php echo $base_url; ?>modules/fees/receipts.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'fees') !== false ? 'active' : ''; ?>">
                <i class="fas fa-rupee-sign"></i> Fees
            </a>
        </li>
        <li>
            <a href="<?php echo $base_url; ?>modules/attendance/report.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'attendance') !== false ? 'active' : ''; ?>">
                <i class="fas fa-clipboard-user"></i> Attendance
            </a>
        </li>
        <li>
            <a href="<?php echo $base_url; ?>modules/exams/results.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'exams') !== false ? 'active' : ''; ?>">
                <i class="fas fa-file-alt"></i> Exams
            </a>
        </li>
        <li>
            <a href="<?php echo $base_url; ?>modules/certificates/list.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'certificates') !== false ? 'active' : ''; ?>">
                <i class="fas fa-certificate"></i> Certificates
            </a>
        </li>

        <li style="padding: 1rem 1rem 0.5rem; font-size: 0.75rem; text-transform: uppercase; color: #818cf8; font-weight: 600; letter-spacing: 0.05em;">System</li>

        <li>
            <a href="<?php echo $base_url; ?>modules/reports/index.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'reports') !== false ? 'active' : ''; ?>">
                <i class="fas fa-chart-bar"></i> Reports
            </a>
        </li>
        <li>
            <a href="<?php echo $base_url; ?>modules/settings/index.php" class="<?php echo strpos($_SERVER['PHP_SELF'], 'settings') !== false ? 'active' : ''; ?>">
                <i class="fas fa-cog"></i> Settings
            </a>
        </li>
    </ul>
</aside>
