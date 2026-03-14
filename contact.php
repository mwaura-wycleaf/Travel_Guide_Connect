<?php include 'includes/header.php'; ?>

<main class="contact-container">
    <section class="contact-hero">
        <h1>Get In Touch</h1>
        <p>Have questions about a destination? We'd love to hear from you.</p>
    </section>

    <div class="contact-content">
        <div class="contact-form-section">
            <h2>Send us a Message</h2>

            <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                <div style="color: green; padding: 10px; border: 1px solid green; margin-bottom: 20px;">
                  Message sent successfully! We will get back to you soon.
                </div>
             <?php endif; ?>
            <form action="processes/send_message.php" method="POST" class="contact-form">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" placeholder="What is this about?">
                </div>

                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" placeholder="Write your message here..." required></textarea>
                </div>

                <button type="submit" class="btn-submit">Send Message</button>
            </form>
        </div>

        <div class="contact-info-section">
            <h2>Our Office</h2>
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <p>Nairobi, Kenya<br>Central Business District</p>
            </div>
            
            <div class="info-item">
                <i class="fas fa-phone-alt"></i>
                <p>+254 700 000 000</p>
            </div>

            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <p>info@tconnect.co.ke</p>
            </div>

            <div class="social-links">
                <h3>Follow Us</h3>
                <div class="icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>