<style>
        /* --- EMBEDDED FOOTER CSS --- */
        .site-footer {
            background-color: #2c3e50; /* Dark navy for contrast */
            color: #ecf0f1;
            padding: 50px 0 20px;
            margin-top: 50px;
            font-family: 'Poppins', sans-serif;
        }

        .footer-area {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 30px;
        }

        .footer-column {
            flex: 1;
            min-width: 250px;
        }

        .footer-brand {
            color: #27ae60; /* Kenyan Green */
            font-size: 1.25rem;
            margin-bottom: 20px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .footer-column p {
            line-height: 1.6;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links li a {
            color: #bdc3c7;
            text-decoration: none;
            transition: 0.3s;
            font-size: 0.9rem;
        }

        .footer-links li a:hover {
            color: #27ae60;
            padding-left: 5px;
        }

        .footer-column i {
            margin-right: 10px;
            color: #27ae60;
        }

        .footer-line {
            border: 0;
            border-top: 1px solid rgba(255,255,255,0.1);
            margin: 30px 0;
        }

        .footer-copyright {
            text-align: center;
            font-size: 0.85rem;
            opacity: 0.7;
        }

        /* Responsive stack for mobile/Tecno Spark 10 */
        @media (max-width: 768px) {
            .footer-row {
                flex-direction: column;
                text-align: center;
            }
            .footer-links li a:hover {
                padding-left: 0;
            }
        }
    </style>

    <footer class="site-footer">
        <div class="footer-area">
            <div class="footer-row">
                
                <div class="footer-column">
                    <h5 class="footer-brand">Travel Guide Connect</h5>
                    <p>Connecting you to the hidden gems of Kenya. Your ultimate companion for exploring the 254, from the peaks of Mt. Kenya to the shores of Diani.</p>
                </div>

                <div class="footer-column">
                    <h5 class="footer-brand">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="http://localhost:8080/Travel_Guide_Connect/index.php">Home</a></li>
                        <li><a href="http://localhost:8080/Travel_Guide_Connect/attractions.php">Attractions</a></li>
                        <li><a href="http://localhost:8080/Travel_Guide_Connect/about.php">About Us</a></li>
                        <li><a href="http://localhost:8080/Travel_Guide_Connect/contact.php">Contact Support</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h5 class="footer-brand">Contact</h5>
                    <p><i class="fas fa-home"></i> Nairobi, Kenya</p>
                    <p><i class="fas fa-envelope"></i> info@tconnect.co.ke</p>
                    <p><i class="fas fa-phone"></i> +254 700 000 000</p>
                </div>

            </div>

            <hr class="footer-line">

            <div class="footer-copyright">
                <p>© 2026 Copyright: <strong>Travel Guide Connect Team</strong></p>
            </div>
        </div>
    </footer>

    <script>
        // Placeholder for the external script.js logic
        console.log("Footer loaded. Port 8080 paths active.");
        
        // Example: Auto-update the year if you don't want to hardcode 2026
        // document.querySelector('.footer-copyright strong').innerHTML += " " + new Date().getFullYear();
    </script>

</body>
</html>