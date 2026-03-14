<?php 
session_start();
include 'includes/header.php'; 
?>

<section class="hero">
    <div class="hero-content">
        <h1>Travel Guide Connect</h1>
        <p>Explore. Connect. Experience.</p>
        
        <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
            <h2 id="welcome-msg">Welcome back, <?php echo htmlspecialchars($_SESSION["name"]); ?>!</h2>
        <?php else: ?>
            <div class="auth-buttons">
                <a href="auth/signup.php" class="btn-primary">Get Started</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="services">
    <div class="service-card" id="attractions-card">
        <i class="fas fa-map-marked-alt"></i>
        <h3>Attractions</h3>
        <p>Discover top Kenyan destinations.</p>
        <a href="attractions.php" class="btn-secondary">Explore</a>
    </div>

    <div class="service-card" id="guides-card">
        <i class="fas fa-user-tie"></i>
        <h3>Local Guides</h3>
        <p>Find experts for your journey.</p>
        <a href="guides.php" class="btn-secondary">Find Guides</a>
    </div>
</section>

<script src="assets/js/script.js"></script>
<?php include 'includes/footer.php'; ?>