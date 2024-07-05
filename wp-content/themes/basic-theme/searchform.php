<form role="search" style="width:70%;" class="d-flex flex-row" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">

        <input type="search" style="height:40px;" class="search-field" placeholder="Your Favorite" value="<?php echo get_search_query(); ?>" name="s" required />
        <button type="submit" style="height:40px;" class="border-white search-btn" >Search!</button>
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
                                <li><a href="<?php echo $home_url?>/cuti" class="">Pengajuan Cuti</a></li>
                                <li><a href="<?php echo $home_url?>/izin" class="">Pengajuan Izin</a></li>
                                <li><a href="<?php echo $home_url?>/wp-admin/profile.php">Profile</a></li>
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

  
</form>

<script type="text/javascript">
    document.querySelector('.hamburger-menu').addEventListener('click', function() {
  document.querySelector('.menu').classList.toggle('active');
    });

    document.querySelector('.close-menu').addEventListener('click', function() {
    document.querySelector('.menu').classList.remove('active');
    });
</script>
