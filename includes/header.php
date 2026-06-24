<?php
session_start();
// Include DB configuration
require_once __DIR__ . '/../config/db.php';

// Base URL for correct asset loading
$base_url = '/rec-net/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP Dashboard - Computer Institute</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/style.css">
</head>
<body>

    <!-- Sidebar -->
    <?php include __DIR__ . '/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="menu-toggle" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div class="topbar-right">
                <div class="user-profile">
                    <div class="user-avatar">A</div>
                    <span>Admin</span>
                    <i class="fas fa-chevron-down" style="font-size: 0.8rem;"></i>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="content">
