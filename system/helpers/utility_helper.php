<?php

//session_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR' & quot);
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

if (!function_exists('notification')) {

    function notification($message) {
        $_SESSION['notification'] = $message;
    }

}
if (!function_exists('isPostBack')) {

    function isPostBack() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

}

if (!function_exists('message')) {

    function message($message) {
        
        ///echo $message;die;
        
        $_SESSION['message'] = $message;
       // echo $_SESSION['message'];die;
    }

}

if (!function_exists('exception')) {

    function exception($message) {
        $_SESSION['exception'] = $message;
    }

}
if (!function_exists('isHTTPS')) {

    function isHTTPS() {
        if (isset($_SERVER['HTTPS'])) {
            return strtolower($_SERVER['HTTPS']) == 'on';
        }
        return false;
    }

}

function insert($table, $data) {
    foreach ($data as $field => $value) {
        $fields[] = '`' . $field . '`';
        $values[] = "'" . mysql_real_escape_string($value) . "'";
    }
    $field_list = join(', ', $fields);
    $value_list = join(', ', $values);
    $query = "INSERT INTO `" . $table . "` (" . $field_list . ") VALUES (" . $value_list . ")";
    mysql_query($query) or die("Error: " . mysql_error());
    return mysql_insert_id();
}

function update($table, $data, $id_field, $id_value) {
    foreach ($data as $field => $value) {
        $fields[] = sprintf("%s = '%s'", $field, mysql_real_escape_string($value));
    }
    $field_list = join(',', $fields);
    $query = sprintf("UPDATE %s SET %s WHERE %s = '%s'", $table, $field_list, $id_field, $id_value);
    mysql_query($query) or die("Error: " . mysql_error());
}

if (!function_exists('result_array')) {

    function result_array($sql) {
        $result = array();
        $query = mysql_query($sql);
        while ($data = mysql_fetch_array($query)) {
            $result[] = $data;
        }
        $rows = count($result);
        if ($rows) {
            $total_global_rows = count($result);
            $total_inner_rows = count($result[0]);
            $count_total_inner_rows = $total_inner_rows / 2;

            for ($i = 0; $i < $total_global_rows; $i++) {
                for ($j = 0; $j < $count_total_inner_rows; $j++) {
                    unset($result[$i][$j]);
                }
            }
        }
        return $result;
    }

}
if (!function_exists('row_array')) {

    function row_array($sql) {
        $result = array();
        $query = mysql_query($sql);
        $data = mysql_fetch_assoc($query);
        return $data;
    }

}
if (!function_exists('dumpVar')) {

    function dumpVar($data) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit();
    }

}


if (!function_exists('get_user_id')) {

    function get_user_id() {
        if (isset($_SESSION['session_user_id'])) {
            return $_SESSION['session_user_id'];
        } else {
            return false;
        }
    }

}

function get_user_name($user_id) {
    if ($user_id == 0) {
        return "Admin";
    }
    $sql = "SELECT * FROM wzt_user WHERE user_id = $user_id LIMIT 1";
    $result = row_array($sql);
    return $result['first_name'] . ' ' . $result['last_name'];
}

if (!function_exists('is_admin_loggedin')) {

    function is_admin_loggedin() {
        if (isset($_SESSION['is_admin_loggedin'])) {
            return $_SESSION['is_admin_loggedin'];
        } else {
            return false;
        }
    }

}


if (!function_exists('check_user_login')) {

    function check_user_login() {
        if (isset($_SESSION['user_name']) && $_SESSION['user_loggedin'] > 0) {
            return true;
        } else {
            $_SESSION['session_url'] = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
            redirect(base_url() . 'welcome/login');
        }
    }

}

if (!function_exists('check_buyer_login')) {

    function check_buyer_login() {
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 2) {
            return true;
        } else {
            message("You are not authorized to view this page.");
            redirect(base_url());
        }
    }

}
if (!function_exists('is_buyer_login')) {

    function is_buyer_login() {
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 2) {
            return true;
        } else {
            return false;
        }
    }

}

if (!function_exists('check_seller_login')) {

    function check_seller_login() {
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1) {
            return true;
        } else {
            message("You are not authorized to view this page.");
            redirect(base_url());
        }
    }

}

if (!function_exists('is_user_loggedin')) {

    function is_user_loggedin() {
        if (isset($_SESSION['user_id']) && $_SESSION['user_loggedin'] > 0) {
            return true;
        } else {
            return false;
        }
    }

}

if (!function_exists('check_admin_login')) { //checkAdminLogin

    function check_admin_login() {
//dumpVar($_SESSION);
        if (isset($_SESSION['is_admin_loggedin'])) {
            return true;
        } else {

            redirect('admin');
        }
    }

}

if (!function_exists('admin_email')) {

    function admin_username() {
        return $_SESSION['admin_email'];
    }

}

function check_create_access() {
    $user_id = get_user_id();
    $sql = "SELECT user_type FROM wzt_user WHERE user_id = $user_id;";
    $result = row_array($sql);
    if ($result['user_type'] != 1) {
        exception("You are not authorised to add  a deal.");
        redirect(base_url());
    }
}

if (!function_exists('password_encode')) {

    function password_encode($password) {
        return md5($password);
    }

}

if (!function_exists('password_decode')) {

    function password_decode($password) {
        return md5($password);
    }

}

function get_cat_list($category_id) {
    $sql = "SELECT * FROM wzt_category WHERE parent_category_id = $category_id ORDER BY name ASC";
    return result_array($sql);
}

function get_category_list() {
    $sql = "SELECT * FROM wzt_category ORDER BY name ASC";
    return result_array($sql);
}

function get_category_name($category_id) {
    $sql = "SELECT * FROM wzt_category WHERE category_id = $category_id";
    $result = row_array($sql);
    return $result['name'];
}

function get_single_image($deal_id) {
    $sql = "SELECT * FROM wzt_deal_image WHERE deal_id = $deal_id ORDER BY deal_image_id DESC LIMIT 1";
    $result = row_array($sql);
    return $result['image_name'];
}

function get_country_name($country_id) {
    $sql = "SELECT * FROM wzt_country WHERE country_id = $country_id LIMIT 1";
    $result = row_array($sql);
    return $result['country'];
}

function get_location_name($location_id) {
    $sql = "SELECT * FROM wzt_location WHERE location_id = $location_id LIMIT 1";
    $result = row_array($sql);
    return $result['location_name'];
}

function check_like($user_id, $deal_id) {
    $sql = "SELECT * FROM wzt_deal_like WHERE user_id = $user_id AND deal_id = $deal_id";
    // echo $sql; exit;
    $result = row_array($sql);
    return $result;
}

function check_favourite($user_id, $deal_id) {
    $sql = "SELECT * FROM wzt_user_favourite WHERE user_id = $user_id AND deal_id = $deal_id";
    // echo $sql; exit;
    $result = row_array($sql);
    return empty($result) ? 1 : 0;
}

function get_category_by_country($country_id) {
    $sql = "SELECT * FROM wzt_category WHERE `is_delete` = 0 AND country_id = $country_id ORDER BY name ASC";
    $result = result_array($sql);
    return $result;
}

function get_favourite_list($user_id) {
    $sql = "SELECT uf.*, w.title, w.deal_url
            FROM wzt_user_favourite uf
            JOIN wzt_deal w ON w.deal_id = uf.deal_id 
            WHERE uf.user_id = $user_id";
    // echo $sql; exit;
    $result = result_array($sql);
    return $result;
}

function user_info($user_id) {
    $sql = "SELECT * FROM wzt_user WHERE user_id = $user_id";
    $result = row_array($sql);
    return $result;
}

function get_rating($deal_id) {
    $sql = "SELECT COUNT(*) AS num_of_rating, SUM(rating_point) AS total_point FROM wzt_deal_rating WHERE deal_id = $deal_id";
    $result = row_array($sql);
    if ($result['num_of_rating'] > 0)
        return round($result['total_point'] / $result['num_of_rating'], 2);
    else
        return 0;
}

function check_rating($user_id, $deal_id) {
    $sql = "SELECT * FROM wzt_deal_rating WHERE user_id = $user_id AND deal_id = $deal_id";
    // echo $sql; exit;
    $result = row_array($sql);
    return $result;
}

function get_fevourited($deal_id) {
    $sql = "SELECT COUNT(*) as total_count FROM wzt_user_favourite WHERE deal_id = $deal_id";
    // echo $sql; exit;
    $result = row_array($sql);
    return $result['total_count'];
}

function get_visit_today($deal_id) {
    $today = date('Y-m-d', time());
    $sql = "SELECT COUNT(*) as total_count FROM wzt_deal_visit WHERE deal_id = $deal_id AND DATE(visited_on) =  '$today'";
    //echo $sql; exit;
    $result = row_array($sql);
    return $result['total_count'];
}

function get_position($deal_id) {
    $sql = "SELECT * FROM wzt_deal ORDER BY total_like DESC";
    // echo $sql; exit;
    $position = "";
    $result = result_array($sql);
    foreach ($result as $key => $value) {
        if ($value['deal_id'] == $deal_id) {
            $position = $key;
            break;
        }
    }
    return $position + 1;
}

function get_current_member() {
    $sql = "SELECT COUNT(*) as total_count FROM wzt_user WHERE is_logged_in = 1";
    //echo $sql; exit;
    $result = row_array($sql);
    return $result['total_count'];
}

function get_total_income() {
    $sql = "SELECT sum(amount) as total_amount FROM wzt_payment WHERE status = 1";
    //echo $sql; exit;
    $result = row_array($sql);
    return $result['total_amount'];
}

function web_visiting() {
    $sess_id = session_id();
    $sql = "SELECT *  FROM wzt_web_visit WHERE session_id = '$sess_id'";
    $result = row_array($sql);
    if (empty($result)) {
        $data['session_id'] = $sess_id;
        $data['visit_time'] = date('Y-m-d H:i:s', time());
        insert('wzt_web_visit', $data);
    } else {
        $data['visit_time'] = date('Y-m-d H:i:s', time());
        update('wzt_web_visit', $data, 'session_id', $sess_id);
    }
}

function delete_record_of_user($user_id) {
    $sql = "SELECT *  FROM wzt_user WHERE user_id = $user_id";
    $user = row_array($sql);
    if (isset($user['image']))
        unlink('images/category_img/thumb_s_4/' . $user['image']);
    $sql = "SELECT *  FROM wzt_deal WHERE user_id = $user_id";
    $result = result_array($sql);
    if (!empty($result)) {
        foreach ($result as $key => $value) {
            $query = "DELETE FROM wzt_deal WHERE deal_id = {$value['deal_id']}";
            mysql_query($query);
            $query = "DELETE FROM wzt_user_favourite WHERE deal_id = {$value['deal_id']}";
            mysql_query($query);
            $query = "DELETE FROM wzt_deal_comment WHERE deal_id = {$value['deal_id']}";
            mysql_query($query);
            $query = "DELETE FROM wzt_deal_like WHERE deal_id = {$value['deal_id']}";
            mysql_query($query);
            $sql2 = "SELECT *  FROM wzt_deal_image WHERE deal_id = {$value['deal_id']}";
            $images = result_array($sql2);
            foreach ($images as $img) {
                $query = "DELETE FROM wzt_deal_image WHERE image_id = {$img['image_id']}";
                mysql_query($query);
                if ($img['image_name']) {
                    unlink('uploads/' . $img['image_name']);
                    unlink('uploads/thumb/' . $img['image_name']);
                }
            }
        }
    }
    $query = "DELETE FROM wzt_user_favourite WHERE user_id = $user_id";
    mysql_query($query);
    $query = "DELETE FROM wzt_deal_comment WHERE user_id = $user_id";
    mysql_query($query);
    $query = "DELETE FROM wzt_deal_like WHERE user_id = $user_id";
    $query = "DELETE FROM wzt_user WHERE user_id = $user_id";
    mysql_query($query);
}

function make_counter_value($total_count) {
    $str = "";
    $tc = (string) $total_count;
    $i = 6 - strlen($tc);
    while ($i > 0) {
        $str .= '0';
        $i--;
    }
    return $str.=$tc;
}

function count_deal_taken_or_interest($deal_id, $column) {
    $sql = "SELECT COUNT(*) as total_amount FROM wzt_deal_taken  WHERE deal_id = $deal_id AND $column = 1";
    $result = row_array($sql);
    return $result['total_amount'];
}

function get_current_visitor() {
    $sql = "SELECT COUNT(*) as total_amount FROM wzt_web_visit WHERE UNIX_TIMESTAMP( NOW( ) ) - UNIX_TIMESTAMP( `visit_time` ) <= 30";
    //echo $sql; exit;
    $result = row_array($sql);
    return $result['total_amount'];
}

function calculate_time_diff($date) {
    $date1 = date('Y-m-d', strtotime($date));
    $date2 = date('Y-m-d', time());
    $end_date = new DateTime($date1);
    $curr_date = new DateTime($date2);
    $days_between = $curr_date->diff($end_date)->format("%a");
    return $days_between;
}

function check_expired($end_date) {
    $date1 = date('Y-m-d', strtotime($end_date));
    $date2 = date('Y-m-d', time());
    if ($date2 > $date1) {
        return 1;
    } else {
        return 0;
    }
}

function get_model_name($product_model_id) {
    $sql = "SELECT * FROM wzt_product_model WHERE product_model_id = $product_model_id LIMIT 1";
    $result = row_array($sql);
    return $result['product_model_name'];
}

function get_brand_name($brand_id) {
    $sql = "SELECT * FROM wzt_product_brand WHERE brand_id = $brand_id LIMIT 1";
    $result = row_array($sql);
    return $result['brand_name'];
}

function get_colour_name($colour_id) {
    $sql = "SELECT * FROM wzt_product_colour WHERE product_colour_id = $colour_id LIMIT 1";
    $result = row_array($sql);
    return $result['product_colour_name'];
}

function get_city_name($city_id) {
    $sql = "SELECT * FROM wzt_city WHERE city_id = $city_id LIMIT 1";
    $result = row_array($sql);
    return $result['city_name'];
}

function get_area_name($area_id) {
    $sql = "SELECT * FROM wzt_area WHERE area_id = $area_id LIMIT 1";
    $result = row_array($sql);
    return $result['area_name'];
}

function get_product_id($product_model_id) {
    $sql = "SELECT * FROM wzt_product_model WHERE product_model_id = $product_model_id LIMIT 1";
    $result = row_array($sql);
    return $result['product_id'];
}

function check_favorite($product_advertise_id) {
    $user_id = $_SESSION['session_user_id'];
    $sql = "SELECT * FROM wzt_favourite_list WHERE user_id = $user_id AND product_advertise_id = $product_advertise_id";
    $result = row_array($sql);
    return empty($result) ? 1 : 2;
}

function check__package_taken($package_id) {
    //dumpVar($package_id);
    $user_id = $_SESSION['session_user_id'];
    $sql = "SELECT * FROM wzt_user_package WHERE package_id = $package_id AND user_id = $user_id ";
    $result = row_array($sql);
//    dumpVar($result);
//    exit;
    return empty($result) ? 1 : 2;
}

function birthday($birthday) {
    $age = @strtotime($birthday);
    if ($age === false) {
        return false;
    }
    list($y1, $m1, $d1) = explode("-", @date("Y-m-d", $age));
    $now = @strtotime("now");
    list($y2, $m2, $d2) = explode("-", @date("Y-m-d", $now));
    $age = $y2 - $y1;
    if ((int) ($m2 . $d2) < (int) ($m1 . $d1))
        $age -= 1;
    return $age;
}

function get_sender_name($sender_id) {
    $sql = "SELECT * FROM wzt_user WHERE user_id = $sender_id LIMIT 1";
    $result = row_array($sql);
    return $result['username'];
}

function get_sender_age($sender_id) {
    $sql = "SELECT * FROM wzt_user WHERE user_id = $sender_id LIMIT 1";
    $result = row_array($sql);
    $date = $result['birth_year'] . '-' . $result['birth_month'];
    $age = @strtotime($date);
    if ($age === false) {
        return false;
    }
    list($y1, $m1, $d1) = explode("-", @date("Y-m-d", $age));
    $now = @strtotime("now");
    list($y2, $m2, $d2) = explode("-", @date("Y-m-d", $now));
    $age = $y2 - $y1;
    if ((int) ($m2 . $d2) < (int) ($m1 . $d1))
        $age -= 1;
    return $age;
}

function get_sender_city($sender_id) {
    $sql = "SELECT * FROM wzt_user WHERE user_id = $sender_id LIMIT 1";
    $result = row_array($sql);
    return $result['city'];
}

function get_sender_description($sender_id) {
    $sql = "SELECT * FROM wzt_user WHERE user_id = $sender_id LIMIT 1";
    $result = row_array($sql);
    return $result['sharing_information'];
}

function get_receiver_name($receiver_id) {
    $sql = "SELECT * FROM wzt_user WHERE user_id = $receiver_id LIMIT 1";
    $result = row_array($sql);
    return $result['username'];
}

function get_package_name($package_id) {
    $sql = "SELECT * FROM wzt_package WHERE package_id = $package_id LIMIT 1";
    $result = row_array($sql);
    return $result['package_name'];
}

function get_package_price($package_id) {
    $sql = "SELECT * FROM wzt_package WHERE package_id = $package_id LIMIT 1";
    $result = row_array($sql);
    return $result['package_price'];
}

function get_outgoing_amount($package_id) {
    $sql = "SELECT * FROM wzt_package WHERE package_id = $package_id LIMIT 1";
    $result = row_array($sql);
    return $result['message_outgoing'];
}

function get_incoming_amount($package_id) {
    $sql = "SELECT * FROM wzt_package WHERE package_id = $package_id LIMIT 1";
    $result = row_array($sql);
    return $result['message_incoming'];
}

function get_incoming_credit() {
    $sql = "SELECT * FROM wzt_user WHERE user_id = {$_SESSION['session_user_id']}";
    $result = row_array($sql);
    return $result['incoming_credit'];
}


function check_package() {
    $sql = "SELECT * FROM wzt_user_package_old WHERE user_id = {$_SESSION['session_user_id']} AND expired_status = 0";
    $result = row_array($sql);
    return $result;
}

function get_country($country_id)
{
    $sql = "SELECT country_name FROM country WHERE country_id = '{$country_id}'";
    $result = row_array($sql);
    return $result['country_name'];
}
function get_state($state_id)
{
    $sql = "SELECT states_name FROM states WHERE id = '{$state_id}'";
    $result = row_array($sql);
    return $result['states_name'];
}
function get_city($city_id)
{
    $sql = "SELECT cities FROM cities WHERE id = {$city_id}";
    $result = row_array($sql);
    return $result['cities'];
}


?>