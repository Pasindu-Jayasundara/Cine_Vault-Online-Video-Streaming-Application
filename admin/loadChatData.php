<?php

session_start();
require "../connection/connection.php";

if (!empty($_SESSION["admin"])) {

    $year = $_POST["year"];

    $rs = Database::search("SELECT 
    `summary_month`,
    SUM(`active_users`) AS `active_user_count`,
    SUM(`basic_subscription`) AS `basic_subscription_count`,
    SUM(`basic_subscription` * `basic_price`) AS `basic_income`,
    SUM(`pro_subscription`) AS `pro_subscription_count`,
    SUM(`pro_subscription` * `pro_price`) AS `pro_income`,
    SUM(`primium_subscription`) AS `primium_subscription_count`,
    SUM(`primium_subscription` * `primium_price`) AS `primium_income`,
    SUM(`movie`) AS `movie_count`,
    SUM(`tv_series`) AS `tv_series_count` 
    FROM `summary` 
    INNER JOIN `summary_date` ON `summary_date`.`summary_date_id` = `summary`.`summary_date_summary_date_id` 
    INNER JOIN `summary_month` ON `summary_date`.`summary_month_summary_month_id` = `summary_month`.`summary_month_id`
    INNER JOIN `summary_year` ON `summary_month`.`summary_year_summary_year_id` = `summary_year`.`summary_year_id` 
    WHERE `summary_year`.`summary_year` LIKE '" . $year . "%'
    GROUP BY `summary_month`, `basic_price`, `pro_price`, `primium_price` -- Include non-aggregated columns in GROUP BY
    ORDER BY `summary_month` ASC;
    ");


    $main_array = array();

    for ($x = 0; $x < $rs->num_rows; $x++) {

        $arr = array();
        $data = $rs->fetch_assoc();

        $month_name = date("F", mktime(0, 0, 0, $data["summary_month"], 1));

        $arr["month"] = $month_name;
        $arr["active_users"] = $data["active_user_count"];
        $arr["basic_subscription_count"] = $data["basic_subscription_count"];
        $arr["pro_subscription_count"] = $data["pro_subscription_count"];
        $arr["primium_subscription_count"] = $data["primium_subscription_count"];
        $arr["monthly_income"] = intval($data["basic_income"]) + intval($data["pro_income"]) + intval($data["primium_income"]);
        $arr["movie_count"] = $data["movie_count"];
        $arr["tv_series_count"] = $data["tv_series_count"];

        array_push($main_array, $arr);
    }

    echo (json_encode($main_array));
} else {
    header("Location:index.php");
}

?>