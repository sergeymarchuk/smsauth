<?php
    
    if (isset($_POST['logout']) && $_POST['logout'] == 'out') {
        session_destroy();

        header('location: http://localhost');
    }

    if (!empty($_SESSION['one_time_password']) && !empty($_POST['password']) && $_SESSION['one_time_password'] == $_POST['password']) {
?>
        <h1>Yahoo and rum bottle</h1>
        <h4>you are logged</h4>
        <form class='form-signin mt-5' action='index.php' method='post' style="width: 30%; min-width: 350px; margin: auto;">
            <input type='hidden' name='logout' value='out'>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Log out</button>
            <p class="mt-5 mb-3 text-muted">&copy 2018</p>
        </form>
<?php 
    } else {
        $password = getPassword();
        $_SESSION['one_time_password'] = $password;

        if (!empty($_POST['phoneNumber'])) {
            sendSMS($password, $_POST['phoneNumber']);
        }
?>
        <form class='form-signin mt-5' action='index.php' method='post' style="width: 30%; min-width: 350px; margin: auto;">
            <h1 class="h3 mb-3 font-weight-normal">Pleae sign in</h1>
            <input class="mb-3 btn-block" type='text' placeholder='your phone number' name='phoneNumber'
                <?php if (!empty($_POST['phoneNumber'])) {echo("value='{$_POST['phoneNumber']}'");} ?> >
            <input class="mb-3 btn-block" type='password' placeholder='entry password' name='password'>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted">&copy 2018</p>
        </form>
<?php
    }



    function getPassword() {
        $chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
        $password = null;

        for ($i = 0; $i < LENGTHPASSWORD; $i++) { 
            $password .= $chars[rand(0,strlen($chars) - 1)];
        }

        return $password;
    }

    function sendSMS($password, $phone) {
        $db = new PDO('mysql:host = 94.249.146.189; dbname = users', 'Marich', 'marich1986');

        $sms = $db->prepare("insert into Marich set number = ':phone', message = ':password', sender = 'Msg'");
        $sms->bindParam(":phone", "38".$phone);
        $sms->bindParam(':password', $password);

        $sms->execute();
        $db = null;
    }
?>
