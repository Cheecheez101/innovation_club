        </main>

        <footer class="main-footer">
            <div class="container">
                <div class="footer-content">
                    <div class="footer-section">
                        <div class="footer-logo">
                            <i class="fas fa-lightbulb"></i>
                            <span><?php echo APP_NAME; ?></span>
                        </div>
                        <p>Innovating the future through technology and creativity</p>
                        <div class="footer-status">
                            <span class="status-indicator online">
                                <i class="fas fa-circle"></i>
                                System Online
                            </span>
                        </div>
                    </div>

                    <div class="footer-section">
                        <h4>Quick Links</h4>
                        <ul class="footer-links">
                            <li><a href="<?php echo BASE_URL; ?>/dashboard">Dashboard</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/members">Members</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/events">Events</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/projects">Projects</a></li>
                        </ul>
                    </div>

                    <div class="footer-section">
                        <h4>Resources</h4>
                        <ul class="footer-links">
                            <li><a href="<?php echo BASE_URL; ?>/reports">Reports</a></li>
                            <li><a href="#">Documentation</a></li>
                            <li><a href="#">Support</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>

                    <div class="footer-section">
                        <h4>Connect</h4>
                        <div class="social-links">
                            <a href="#" class="social-link" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link" title="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link" title="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="social-link" title="GitHub">
                                <i class="fab fa-github"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="footer-bottom">
                    <div class="footer-info">
                        <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?> Management System v<?php echo APP_VERSION; ?></p>
                        <p>Developed for Diploma in ICT Trade Project</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="<?php echo BASE_URL; ?>/assets/js/main.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const burger = document.getElementById('navbar-burger');
            const menu = document.getElementById('navbar-menu');

            if (burger && menu) {
                burger.addEventListener('click', () => {
                    burger.classList.toggle('active');
                    menu.classList.toggle('is-active');
                    const expanded = burger.getAttribute('aria-expanded') === 'true';
                    burger.setAttribute('aria-expanded', !expanded);
                });

                // Close menu when clicking a link (optional)
                document.querySelectorAll('.navbar-item').forEach(link => {
                    link.addEventListener('click', () => {
                        burger.classList.remove('active');
                        menu.classList.remove('is-active');
                        burger.setAttribute('aria-expanded', 'false');
                    });
                });
            }
        });
    </script>
</body>
</html>

<style>
/* ==========================================
   FOOTER
========================================== */

.main-footer {
    background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%);
    color: #ecf0f1;
    margin-top: 4rem;
    position: relative;
    overflow: hidden;
}

.main-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #f1c40f, #e67e22, #e74c3c, #9b59b6, #3498db);
    background-size: 400% 400%;
    animation: footerGradient 8s ease infinite;
}

@keyframes footerGradient {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.footer-content {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 3rem;
    padding: 3rem 0 2rem;
}

.footer-section {
    display: flex;
    flex-direction: column;
}

.footer-logo {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: #f1c40f;
}

.footer-logo i {
    font-size: 1.8rem;
}

.footer-section p {
    color: #bdc3c7;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.footer-section h4 {
    color: #ecf0f1;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    position: relative;
}

.footer-section h4::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 30px;
    height: 2px;
    background: #f1c40f;
    border-radius: 1px;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 0.5rem;
}

.footer-links a {
    color: #bdc3c7;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
}

.footer-links a:hover {
    color: #f1c40f;
    transform: translateX(5px);
}

.social-links {
    display: flex;
    gap: 1rem;
    margin-top: 0.5rem;
}

.social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    color: #bdc3c7;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 1.1rem;
}

.social-link:hover {
    background: #f1c40f;
    color: #2c3e50;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(241, 196, 15, 0.3);
}

.footer-status {
    margin-top: 1rem;
}

.status-indicator {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: rgba(46, 204, 113, 0.15);
    color: #2ecc71;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
    border: 1px solid rgba(46, 204, 113, 0.3);
}

.status-indicator i {
    font-size: 0.6rem;
}

.footer-bottom {
    border-top: 1px solid rgba(255,255,255,0.1);
    padding: 2rem 0;
    margin-top: 2rem;
    text-align: center;
}

.footer-info p {
    margin: 0.25rem 0;
    color: #95a5a6;
    font-size: 0.9rem;
}

.footer-info p:first-child {
    color: #ecf0f1;
    font-weight: 500;
}

/* ==========================================
   RESPONSIVE DESIGN
========================================== */

@media (max-width: 1024px) {
    .footer-content {
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }
}

@media (max-width: 768px) {
    .main-footer {
        margin-top: 2rem;
    }

    .footer-content {
        grid-template-columns: 1fr;
        gap: 2rem;
        padding: 2rem 0 1rem;
    }

    .footer-section {
        text-align: center;
    }

    .footer-logo {
        justify-content: center;
    }

    .social-links {
        justify-content: center;
    }

    .footer-links a:hover {
        transform: none;
    }

    .footer-bottom {
        padding: 1.5rem 0;
        margin-top: 1.5rem;
    }
}

@media (max-width: 480px) {
    .footer-content {
        padding: 1.5rem 0 0.5rem;
    }

    .social-links {
        gap: 0.75rem;
    }

    .social-link {
        width: 35px;
        height: 35px;
        font-size: 1rem;
    }
}

/* ==========================================
   GENERAL LAYOUT
========================================== */

.main-container {
    min-height: calc(100vh - 200px);
    padding: 0 1rem;
}

.main-content {
    flex: 1;
    padding-bottom: 2rem;
}

/* Container utilities */
.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* ==========================================
   UTILITY CLASSES
========================================== */

.text-center { text-align: center; }
.text-left { text-align: left; }
.text-right { text-align: right; }

.mt-1 { margin-top: 0.25rem; }
.mt-2 { margin-top: 0.5rem; }
.mt-3 { margin-top: 1rem; }
.mt-4 { margin-top: 1.5rem; }
.mt-5 { margin-top: 3rem; }

.mb-1 { margin-bottom: 0.25rem; }
.mb-2 { margin-bottom: 0.5rem; }
.mb-3 { margin-bottom: 1rem; }
.mb-4 { margin-bottom: 1.5rem; }
.mb-5 { margin-bottom: 3rem; }

.hidden { display: none !important; }
.is-hidden { display: none !important; }

@media (max-width: 768px) {
    .container {
        padding: 0 0.75rem;
    }

    .main-container {
        padding: 0 0.5rem;
    }
}
</style>
