<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css') ?>">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const remainingTime = <?= $remainingTime ?>; // Get remaining time from PHP
            const submitButton = document.getElementById('submitButton');
            let countdown = remainingTime;

            if (countdown > 0) {
                submitButton.disabled = true; // Disable the button
                const countdownDisplay = document.getElementById('countdownDisplay');

                const timer = setInterval(function() {
                    // Calculate minutes and seconds
                    const minutes = Math.floor(countdown / 60);
                    const seconds = countdown % 60;

                    // Update the countdown display
                    countdownDisplay.textContent = `Coba lagi dalam ${minutes} Menit ${String(seconds).length == 1 ? '0'+seconds : seconds} Detik !`;

                    countdown--; // Decrement countdown

                    if (countdown < 0) {
                        clearInterval(timer);
                        submitButton.disabled = false; // Enable the button
                        countdownDisplay.textContent = ''; // Clear the message
                    }
                }, 1000);
            }
        });

    </script>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <b>Puskesmas</b> Admin
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                <form action="<?= base_url('backend/login'); ?>" method="post">
            <?= csrf_field();?>
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-user"></span></div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="col-4">
                            <img src="<?= base_url('uploads/captcha/captcha.png'); ?><?='?t='.time(); ?>" alt="CAPTCHA" id="captchaImage" style="border: 1px solid #ccc; border-radius: 5px; width: 120px; height: 40px; margin-bottom: 10px;" >
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control" name="captcha" required placeholder="Enter CAPTCHA">
                        </div>
                        <div class="col-12">
                            <small>
                                <a href="#" id="refreshCaptcha" style="text-decoration: none; color: blue;">Click here to refresh CAPTCHA</a>
                            </small>    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" id="submitButton" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div id="countdownDisplay" style="color: red;"></div> <!-- Countdown display -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>

    let loadCaptcha

    document.addEventListener('DOMContentLoaded', function() {
        console.log('Document is ready!');
        // Your code here...
        loadCaptcha = function() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', "<?= base_url('backend/captcha/generate'); ?>", true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // If needed, process the response
                    document.getElementById('captchaImage').src = '<?= base_url('uploads/captcha/captcha.png'); ?>?t='+ new Date().getTime(); // Update image source
                    console.log('Captcha refreshed!')
                } else {
                    console.error('Error fetching CAPTCHA image:', xhr.statusText);
                }
            };
            xhr.onerror = function() {
                console.error('Request failed');
            };
            xhr.send();
        }

        loadCaptcha();
    });

    // Refresh CAPTCHA on click
    document.getElementById('captchaImage').onclick = function() {
        loadCaptcha();
    };

    document.querySelector('form').onsubmit = function(event) {
        // Optionally, you can check for validity here before submission
        // Load CAPTCHA image when form is submitted
        event.preventDefault();
        console.log(event.target.action)
        console.log(event.target.method)
    
        this.submit()
        // console.log('form action :', this.action)
        // loadCaptcha();
    };

    document.getElementById('refreshCaptcha').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent default link behavior
        loadCaptcha();
    });
</script>

</body>
</html>
