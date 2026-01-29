<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? APP_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
/* ==========================================
   HEADER & NAVBAR
========================================== */

.main-header {
    background: linear-gradient(135deg, #2c3e50 0%, #1a2634 100%);
    color: white;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    border-bottom: 1px solid rgba(255,255,255,0.08);
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    min-height: 4.5rem;
    padding: 0 1rem;
}

.navbar-brand {
    font-weight: 700;
    font-size: 1.5rem;
}

.brand-link {
    display: flex;
    align-items: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
}

.brand-icon {
    font-size: 1.8rem;
    margin-right: 0.6rem;
    color: #f1c40f;
}

.brand-text {
    letter-spacing: 0.5px;
}

/* Menu items */
.navbar-menu {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.navbar-start,
.navbar-end {
    display: flex;
    align-items: center;
    gap: 0.35rem;
}

.navbar-item {
    color: #dfe6e9;
    padding: 0.7rem 1rem;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 0.55rem;
    font-size: 0.95rem;
    transition: all 0.25s ease;
    text-decoration: none;
}

.navbar-item:hover {
    background: rgba(255,255,255,0.1);
    color: white;
    transform: translateY(-1px);
}

/* User area */
.user-dropdown-trigger {
    display: flex;
    align-items: center;
    gap: 0.7rem;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.25s ease;
    position: relative;
}

.user-dropdown-trigger:hover {
    background: rgba(255,255,255,0.08);
}

.user-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    overflow: hidden;
    background: rgba(255,255,255,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #bdc3c7;
}

.avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-details {
    display: flex;
    flex-direction: column;
}

.user-name {
    font-weight: 600;
    font-size: 0.95rem;
}

.user-role {
    font-size: 0.78rem;
    opacity: 0.8;
    text-transform: capitalize;
}

.chevron {
    font-size: 0.85rem;
    opacity: 0.7;
    transition: transform 0.3s ease;
}

/* Logout button */
.logout-btn {
    background: rgba(231, 76, 60, 0.15);
    color: #e74c3c;
    font-weight: 500;
}

.logout-btn:hover {
    background: rgba(231, 76, 60, 0.3);
    color: white;
}

/* Burger menu */
.navbar-burger {
    display: none;
    flex-direction: column;
    justify-content: space-around;
    width: 2rem;
    height: 1.5rem;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 0;
}

.navbar-burger span {
    height: 3px;
    width: 100%;
    background: white;
    border-radius: 10px;
    transition: all 0.4s ease;
}

.navbar-burger.active span:nth-child(1) {
    transform: rotate(45deg) translate(5px, 5px);
}
.navbar-burger.active span:nth-child(2) {
    opacity: 0;
}
.navbar-burger.active span:nth-child(3) {
    transform: rotate(-45deg) translate(7px, -6px);
}

/* Mobile menu */
@media (max-width: 1023px) {
    .navbar-burger {
        display: flex;
    }

    .navbar-menu {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #2c3e50;
        flex-direction: column;
        justify-content: flex-start;
        padding: 5rem 2rem 2rem;
        transform: translateY(-100%);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 999;
    }

    .navbar-menu.is-active {
        transform: translateY(0);
    }

    .navbar-start,
    .navbar-end {
        flex-direction: column;
        width: 100%;
        align-items: stretch;
    }

    .navbar-item {
        justify-content: flex-start;
        padding: 1.1rem 1.5rem;
        font-size: 1.1rem;
        border-radius: 0;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    .logout-btn {
        margin-top: 2rem;
        border-radius: 8px;
        justify-content: center;
    }

    .user-dropdown-trigger {
        flex-direction: row;
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        margin-bottom: 1rem;
    }
}

/* ==========================================
   NOTIFICATIONS
========================================== */

.notification {
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    animation: slideIn 0.3s ease-out;
}

.notification.is-success {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    color: #155724;
    border-left: 4px solid #28a745;
}

.notification.is-error {
    background: linear-gradient(135deg, #f8d7da, #f5c6cb);
    color: #721c24;
    border-left: 4px solid #dc3545;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
    </style>
</head>
<body>
    <header class="main-header">
        <div class="container">
            <nav class="navbar">
                <!-- Brand -->
                <div class="navbar-brand">
                    <a href="<?php echo BASE_URL; ?>/dashboard" class="brand-link">
                        <i class="fas fa-lightbulb brand-icon"></i>
                        <span class="brand-text"><?php echo APP_NAME; ?></span>
                    </a>
                </div>

                <!-- Desktop + Mobile menu container -->
                <div class="navbar-menu" id="navbar-menu">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Left side navigation -->
                        <div class="navbar-start">
                            <a href="<?php echo BASE_URL; ?>/dashboard" class="navbar-item">
                                <i class="fas fa-home"></i>
                                <span>Dashboard</span>
                            </a>
                            <a href="<?php echo BASE_URL; ?>/members" class="navbar-item">
                                <i class="fas fa-users"></i>
                                <span>Members</span>
                            </a>
                            <a href="<?php echo BASE_URL; ?>/events" class="navbar-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Events</span>
                            </a>
                            <a href="<?php echo BASE_URL; ?>/projects" class="navbar-item">
                                <i class="fas fa-tasks"></i>
                                <span>Projects</span>
                            </a>
                            <a href="<?php echo BASE_URL; ?>/reports" class="navbar-item">
                                <i class="fas fa-chart-line"></i>
                                <span>Reports</span>
                            </a>
                        </div>

                        <!-- Right side (user + logout) -->
                        <div class="navbar-end">
                            <div class="navbar-item user-dropdown-trigger" id="user-menu-trigger">
                                <div class="user-avatar">
                                    <?php if (!empty($_SESSION['profile_pic'])): ?>
                                        <img src="<?php echo $_SESSION['profile_pic']; ?>" alt="User" class="avatar-img">
                                    <?php else: ?>
                                        <i class="fas fa-user-circle"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="user-details">
                                    <span class="user-name"><?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></span>
                                    <span class="user-role"><?php echo ucfirst($_SESSION['role'] ?? 'member'); ?></span>
                                </div>
                                <i class="fas fa-chevron-down chevron"></i>
                            </div>

                            <a href="<?php echo BASE_URL; ?>/auth/logout" class="navbar-item logout-btn">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Hamburger -->
                <button class="navbar-burger" id="navbar-burger" aria-label="menu" aria-expanded="false">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </button>
            </nav>
        </div>
    </header>

    <div class="container main-container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="notification is-success">
                <i class="fas fa-check-circle"></i>
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="notification is-error">
                <i class="fas fa-exclamation-circle"></i>
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <main class="main-content">
