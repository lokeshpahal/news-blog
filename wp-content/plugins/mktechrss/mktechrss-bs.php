<?php

if (!function_exists("get_option") || !function_exists("add_filter")) {
    die();
}
?>

<?php
if (isset($_POST['Submit'])) {
    $csyn_bs_options['username'] = $_POST['username'];
    $csyn_bs_options['password'] = $_POST['password'];
    $csyn_bs_options['protectedterms'] = $_POST['protectedterms'];

    $update_csyn_query = update_option(CSYN_THEBESTSPINNER_OPTIONS, $csyn_bs_options);
    if ($update_csyn_query) {
        $text = 'The Best Spinner Setting Updated<br />';
    } else {
        $text = __('No Option Updated');
    }
}
?>
<?php
if (!empty($text)) {
    echo '<div id="message" class="updated fade"><p>' . $text . '</p></div>';
}
?>
<style type="text/css">
	.wrap h2{border: 1px solid #e1e1e1;padding: 5px 5px 5px 5px;background: #fff;font-family: sans-serif;}
	.main-box{width:99%;float:left;padding:5px;margin-bottom:10px;border:1px solid #e1e1e1;background: #fff;}
</style>
<div class="wrap">
    <h2>The Best Spinner Settings</h2>
	<div class="main-box">
    <form method="post" name="general_settings">
        <table class="form-table">
            <tr>
                <th align="left">Account info</th>
                <td align="left">
                    <?php
                    $url = 'http://thebestspinner.com/api.php';
                    $data = array();
                    $data['action'] = 'authenticate';
                    $data['format'] = 'php';
                    $data['username'] = $csyn_bs_options['username'];
                    $data['password'] = $csyn_bs_options['password'];
                    $result = unserialize(csyn_curl_post($url, $data, $info));
                    echo '<a href="http://www.cyberseo.net/partners/thebestspinner.php" target="_blank"><strong>The Best Spinner</strong></a> service is ';
                    if (isset($result['success']) && $result['success'] == 'true') {
                        echo 'available.';
                    } else {
                        echo 'unavailable.';
                        if (isset($result['error'])) {
                            echo ' ' . $result['error'];
                        }
                    }
                    if ($csyn_bs_options['username'] == '' || $csyn_bs_options['password'] == '') {
                        //echo '<br />Please enter your username and password below or apply for your <a href="http://www.cyberseo.net/partners/thebestspinner.php" target="_blank"><strong>The Best Spinner</strong></a> account.';
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <th align="left">Username</th>
                <td align="left">
                    <input type="text" name="username" size="40" value="<?php echo $csyn_bs_options['username'];
                    ?>">
                </td>
            </tr>

            <tr>
                <th align="left">Password</th>
                <td align="left">
                    <input type="text" name="password" size="40" value="<?php echo $csyn_bs_options['password']; ?>">
                </td>
            </tr>	

            <tr>
                <th align="left">Protected terms</th>
                <td align="left">
                    <input type="text" name="protectedterms" size="40" value="<?php echo $csyn_bs_options['protectedterms']; ?>">
                </td>
            </tr>			

        </table>
        <br />
        <div align="center">
            <input type="submit" name="Submit" class="button-primary"
                   value="Update Options" />&nbsp;&nbsp;<input type="button"
                   name="cancel" value="Cancel" class="button"
                   onclick="javascript:history.go(-1)" />
        </div>
    </form>
</div>
</div>
