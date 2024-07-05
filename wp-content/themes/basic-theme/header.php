<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Custom CSS -->
     <link rel="stylesheet" href="<?php bloginfo('stylesheet_url');?>css/main.css">
    <title><?php bloginfo('name');?></title>

    <?php wp_head();?>

</head>
<body <?php body_class();?>>
    <nav class="d-flex align-items-center justify-content-between p-4" style="gap:20px;">
        <div class="d-flex justify-content-center align-items-center btn btn-light" >
            <p id="live-clock" style="margin:0;"></p>
        </div>

        <div class="hamburger-menu">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <nav class="menu">
        <div class="menu-toggle"> 
            <button class="close-menu">&times;</button>
        </div>
        <ul>

            <?php $home_url = home_url();?>
            <li><a href="<?php echo $home_url?>/">Home</a></li>
            <li><a href="<?php echo $home_url?>/it">IT</a></li>
            <li><a href="<?php echo $home_url?>/engineering">ENGINEERING</a></li>
            <li><a href="<?php echo $home_url?>/hr">HRD</a></li>
            <li><a href="<?php echo $home_url?>/hadist">HADIST</a></li>
               <li><a href="<?php echo $home_url?>/sales">SALES</a></li>
            <li><a href="<?php echo $home_url?>/other">OTHER</a></li>
            <li><a href="<?php echo $home_url?>//wp-admin/profile.php" class="">Profile</a></li>
            <li>
                <?php
                    // Cek apakah pengguna sudah login
                    if ( is_user_logged_in() ) {
                        // Mendapatkan URL logout
                        $logout_url = wp_logout_url( home_url() ); // Redirect ke halaman utama setelah logout, Anda dapat mengubahnya sesuai kebutuhan
                    
                        // Output tombol logout
                        echo '<a class="btn btn-danger" href="' . esc_url( $logout_url ) . '">Logout</a>';
                    }
                ?>
            </li>


            
        </ul>
        </nav>    

    </nav>

    <script>
        // Fungsi untuk mendapatkan timestamp hanya jam, menit, dan detik
        function getTimestamp() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            return `${hours}:${minutes}:${seconds}`;
        }

        // Fungsi untuk memperbarui konten elemen HTML dengan timestamp setiap detik
        function updateTimestamp() {
            const timestampElement = document.getElementById('live-clock');
            timestampElement.textContent = getTimestamp();
        }

        // Memperbarui timestamp setiap detik
        setInterval(updateTimestamp, 1000);





        document.querySelector('.hamburger-menu').addEventListener('click', function() {
        document.querySelector('.menu').classList.toggle('active');
        });

        document.querySelector('.close-menu').addEventListener('click', function() {
        document.querySelector('.menu').classList.remove('active');
        });
    </script>



                 