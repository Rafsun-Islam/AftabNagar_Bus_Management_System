<style>
    /* CSS for the hover effect on navigation menu */
    header {
        background: transparent;
        backdrop-filter: blur(10px);  
    }

    nav ul li {
        display: inline-block;
        margin-right: 20px;
        /* Adjust spacing between menu items */
    }

    nav ul li a {
        text-decoration: none;
        color: white;
        /* Adjust the color of the links */
    }

    nav ul li a:hover {
        text-decoration: none;
        background: lightblue;
        /* color: #ff0000; Change color on hover */
        /* You can also add additional styles for hover effect */
        /* For example: background-color, font-weight, etc. */
    }
</style>
<header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="purchase_pass.php">Purchase</a></li>
            <li><a href="feedback.php">Feedback</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact_us.php">Contact Us</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>