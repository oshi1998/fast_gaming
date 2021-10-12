<!-- info section -->
<section class="info_section ">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="info_contact">
                    <h5>
                        <a href="" class="navbar-brand">
                            <span>
                            <?= $store->st_name ?>
                            </span>
                        </a>
                    </h5>
                    <p>
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <?= $store->st_address ?>
                    </p>
                    <p>
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <?= $store->st_phone ?>
                    </p>
                    <p>
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <?= $store->st_email ?>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info_form ">
                    <h5>
                        Newsletter
                    </h5>
                    <form action="">
                        <input type="email" placeholder="Enter your email">
                        <button>
                            Subscribe
                        </button>
                    </form>
                    <div class="social_box">
                        <a target="_blank" href="<?= $store->st_facebook ?>">
                            <i class="fa fa-facebook" aria-hidden="true"></i>
                        </a>
                        <a target="_blank" href="<?= $store->st_twitter ?>">
                            <i class="fa fa-twitter" aria-hidden="true"></i>
                        </a>
                        <a target="_blank" href="<?= $store->st_ig ?>">
                            <i class="fa fa-instagram" aria-hidden="true"></i>
                        </a>
                        <a target="_blank" href="<?= $store->st_youtube ?>">
                            <i class="fa fa-youtube" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- end info_section -->


<!-- footer section -->
<footer class="footer_section">
    <div class="container">
        <p>
            &copy; <span id="displayYear"></span> All Rights Reserved By
            <a href="javascript:void(0)"><?= $store->st_name ?></a>
        </p>
    </div>
</footer>
<!-- footer section -->

<!-- bootstrap js -->
<script src="js/bootstrap.js"></script>
<!-- custom js -->
<script src="js/custom.js"></script>

<script>
    function logout() {
        $.ajax({
            method: "get",
            url: "app/api/auth/logout.php",
            success: function() {
                window.location.reload();
            }
        });
    }
</script>