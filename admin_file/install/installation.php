<?php

use AST\FileSystem;

class Installation{

    public static function installDB($con, $prefix){
        $filePath = get_site_path() . "admin_file/install/data/install.sql";
        $templine = ''; 
        $lines = array();
        $lines = file($filePath);
        
        foreach ($lines as $line){
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;
                
            $templine .= $line;
            
            if (substr(trim($line), -1, 1) == ';'){
                $templine = str_replace('{{prefix}}', $prefix, $templine);
                mysqli_query($con, $templine);
                $templine = '';
            }
        
        }
        return true;
    }

    public static function instalToolData($conn, $prefix){
        foreach (glob(TOOLS_PATH . "*") as $filename){
            if( is_dir( $filename ) && file_exists( $filename . "/functions.php" ) ){
                $slug = basename($filename);
                $title = ucfirst(str_replace("-", " ", $slug));

                $checkQuery = "SELECT COUNT(*) AS slugCount FROM {$prefix}posts WHERE extra = '$slug'";
                $checkResult = mysqli_query($conn, $checkQuery);
                if( $checkResult ){
                    $row = mysqli_fetch_assoc($checkResult);
                    if( $row['slugCount'] == 0 ){
                        $createData = "INSERT INTO `{$prefix}posts` (`title`, `slug`, `author`, `description`, `status`, `type`, `views`, `extra`) VALUES ('$title', '$slug', 1, '', 'active', 'tool', 0, '$slug')";

                        mysqli_query($conn, $createData);
                    }
                }
            }
        }
    }

    public static function installPluginTools($path, $conn, $prefix){
        foreach (glob($path . "*") as $filename){
            if( is_dir( $filename ) && file_exists( $filename . "/install.php" ) )
                include $filename . "/install.php";
        }
    }

    public static function check_database(){
        if(
            isset($_POST['host']) && !empty($_POST['host'])
            && isset($_POST['dbname']) && !empty($_POST['dbname'])
            && isset($_POST['username']) && !empty($_POST['username'])
            && isset($_POST['password']) && !empty($_POST['password'])
        ){
            $host = trim($_POST['host']);
            $_SESSION['host'] = $_POST['host'];

            $dbname = trim($_POST['dbname']);
            $_SESSION['dbname'] = $_POST['dbname'];

            $username = trim($_POST['username']);
            $_SESSION['username'] = $_POST['username'];

            $password = trim($_POST['password']);
            $_SESSION['password'] = $_POST['password'];

            $prefix = trim($_POST['prefix']);
            $_SESSION['prefix'] = $_POST['prefix'];

            try {
                $conn = new mysqli($host, $username, $password, $dbname);
                if( ! $conn->connect_error ){
                    self::installDB($conn, $prefix);

                    self::installPluginTools(TOOLS_PATH, $conn, $prefix);
                    self::installPluginTools(PLUGINS_PATH, $conn, $prefix);

                    self::instalToolData($conn, $prefix);

                    $conn->close();
                    return true;
                }
            } catch (mysqli_sql_exception $th) {
                print_r($th);
            }
        }

        return false;
    }

    public static function setDefaultSettings($conn, $prefix){
        $settings = array(
            "activetheme" => "default",
            "siteurl" => $_POST['siteurl'],
            "sitepath" => $_POST['sitepath'],
            "install_plugins" => "a:0:{}",
            "basic" => "a:0:{}",
            "sitemap" => "a:0:{}",
            "menus" => "a:0:{}",
            "website_views" => 0,
            "adminemail" => $_POST['user_email']
        );

        foreach($settings as $k => $v){
            try {
                $conn->query("INSERT INTO `{$prefix}settings`(`option_name`, `option_value`) VALUES ('$k', '$v')");
            } catch (mysqli_sql_exception $th) {
                print_r($th);
            }
        }
    }

    public static function create_user(){
        if(
            isset($_POST['user_name']) && !empty($_POST['user_name'])
            && isset($_POST['user_email']) && !empty($_POST['user_email'])
            && isset($_POST['user_password']) && !empty($_POST['user_password'])
            && isset($_POST['websiteurl']) && !empty($_POST['websiteurl'])
        ){
            $host = $_SESSION['host'];
            $dbname = $_SESSION['dbname'];
            $username = $_SESSION['username'];
            $password = $_SESSION['password'];
            $prefix = $_SESSION['prefix'];

            $name = $_POST['user_name'];
            $_SESSION['user_name'] = $name;

            $email = $_POST['user_email'];
            $_SESSION['user_email'] = $email;

            $userpassword = $_POST['user_password'];
            $_SESSION['user_password'] = $userpassword;

            $user_name = trim(explode("@", $email)[0]);
            $date = date("Y-m-d H:i:s");
            $passwordhash = generate_password($userpassword);
    
            try {
                $conn = new mysqli($host, $username, $password, $dbname);
                if( ! $conn->connect_error ){
                    if( $conn->query("INSERT INTO `{$prefix}users`(`name`, `username`, `email`, `role`, `password`, `status`, `date`) VALUES ('$name', '$user_name', '$email', 'administrator', '$passwordhash', 'active', '$date')") ){
                        
                        //setup default settings
                        self::setDefaultSettings($conn, $prefix);
                        
                        return true;
                    }

                    $conn->close();
                }
            } catch (mysqli_sql_exception $th) {
                
            }
        }
        
        return false;
    }

    public static function update_config(){
        $host = $_SESSION['host'];
        $dbname = $_SESSION['dbname'];
        $dbuser = $_SESSION['username'];
        $dbpass = $_SESSION['password'];
        $prefix = $_SESSION['prefix'];

        $configFile = get_site_path() . "admin_file/install/data/config.php";
        if( file_exists( $configFile ) ){
            $content = file_get_contents($configFile);
            $content = str_replace(array(
                '{{dbname}}',
                '{{dbuser}}',
                '{{dbpass}}',
                '{{dbhost}}',
                '{{dbprefix}}'
            ), array(
                $dbname,
                $dbuser,
                $dbpass,
                $host,
                $prefix
            ), $content);

            $installFile = get_site_path() . "config.php";
            return file_put_contents($installFile, $content);
        }
        return false;
    }

    public static function getNextValue($array, $previousValue, $op=1) {
        foreach ($array as $key => $value) {
            if ($value === $previousValue) {
                $nextKey = $key + $op;
                if (array_key_exists($nextKey, $array)) {
                    $nextValue = $array[$nextKey];
                    return $nextValue;
                }
                break;
            }
        }
        return null;
    }

    public static function next(){
        $page = trim($_POST['page']);
        return self::getNextValue(self::steps(), $page);
    }

    public static function prev(){
        $page = trim($_POST['page']);
        return self::getNextValue(self::steps(), $page, -1);
    }

    public static function current(){
        return trim($_POST['page']);
    }

    public static function steps(){
        return array("home", "requirement", "database", "admin", "complete");
    }

    public static function badge($text, $type="success"){
        echo sprintf("<span class='badge bg-%s'>%s</span>", $type, $text);
    }

    public static function check_requirement(){
        $requirements = array(
            "version" => version_compare(PHP_VERSION, '8.0.0') >= 0,
            "mysqli" => extension_loaded("mysqli"),
            "file_get_contents" => function_exists("file_get_contents"),
            "pdo" => extension_loaded("pdo"),
            "whoisport" => function_exists('fsockopen') && fsockopen('whois.internic.net', 43),
            "gd" => extension_loaded('gd'),
            "curl" => extension_loaded('curl'),
            "xml" => extension_loaded('xml'),
            "imagick" => class_exists('Imagick'),
            "exec" => function_exists('shell_exec') || function_exists('exec')
        );

        $filewritable = array(
            "config" => is_writable(get_site_path() . "config.php"),
            "uploads" => is_writable(get_site_path() . "app/uploads"),
            "temp" => is_writable(get_site_path() . "app/temp")
        );

        $allChecked = true;
        foreach($requirements as $k => $v){
            if( ! $v ){
                $allChecked = false;
                break;
            }
        }

        if( $allChecked ){
            foreach($filewritable as $k => $v){
                if( ! $v ){
                    $allChecked = false;
                    break;
                }
            }
        }

        return (object) array(
            "requirements" => (object) $requirements,
            "files" => (object) $filewritable,
            "allcheck" => $allChecked
        );
    }

}