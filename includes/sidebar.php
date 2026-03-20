<div class="sidebar" style="
    width: 250px; 
    background: #2c3e50; 
    height: 100vh; 
    position: fixed; 
    left: 0; 
    top: 0; 
    padding: 20px; 
    color: white; 
    box-sizing: border-box; /* This prevents padding from making the sidebar wider than 250px */
    z-index: 1000;
    overflow-y: auto; /* Adds a scrollbar only to the sidebar if your menu gets too long */
">
    <h2 style="color: #27ae60; text-align: center; margin-bottom: 5px;">T.G.C.</h2>
    <p style="text-align: center; font-size: 0.8rem; opacity: 0.7; margin-bottom: 20px;">Admin Control Panel</p>
    
    <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.1); margin: 20px 0;">
    
    <nav>
        <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="margin-bottom: 10px;">
                <a href="dashboard.php" style="color: white; text-decoration: none; font-weight: 500; display: flex; align-items: center; padding: 10px; border-radius: 8px; transition: 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='transparent'">
                    <i class="fas fa-home" style="width: 25px; color: #27ae60;"></i> Dashboard
                </a>
            </li>
            <li style="margin-bottom: 10px;">
                <a href="manage_bookings.php" style="color: white; text-decoration: none; font-weight: 500; display: flex; align-items: center; padding: 10px; border-radius: 8px; transition: 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='transparent'">
                    <i class="fas fa-calendar-check" style="width: 25px; color: #27ae60;"></i> Bookings
                </a>
            </li>
            <li style="margin-bottom: 10px;">
                <a href="manage_attractions.php" style="color: white; text-decoration: none; font-weight: 500; display: flex; align-items: center; padding: 10px; border-radius: 8px; transition: 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='transparent'">
                    <i class="fas fa-map-marker-alt" style="width: 25px; color: #27ae60;"></i> Attractions
                </a>
            </li>
            <li style="margin-bottom: 10px;">
                <a href="manage_guides.php" style="color: white; text-decoration: none; font-weight: 500; display: flex; align-items: center; padding: 10px; border-radius: 8px; transition: 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='transparent'">
                    <i class="fas fa-users" style="width: 25px; color: #27ae60;"></i> Staff/Guides
                </a>
            </li>
            
            <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.1); margin: 20px 0;">
            
            <li>
                <a href="logout.php" style="color: #e74c3c; text-decoration: none; font-weight: bold; display: flex; align-items: center; padding: 10px; border-radius: 8px; transition: 0.3s;" onmouseover="this.style.background='rgba(231, 76, 60, 0.1)'" onmouseout="this.style.background='transparent'">
                    <i class="fas fa-sign-out-alt" style="width: 25px;"></i> Logout
                </a>
            </li>
        </ul>
    </nav>
</div>