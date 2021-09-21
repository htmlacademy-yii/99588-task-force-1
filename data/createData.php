<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";

use TaskForce\app\parser\Parser;
use TaskForce\app\parser\column\ColumnString;
use TaskForce\app\parser\column\ColumnIntRand;
use TaskForce\app\parser\column\ColumnIntOrder;
use TaskForce\app\status\StatusNew;

function datetimeToStr(int $rand) :string {
    return date("Y-m-d h:m:s", $rand);
}


function createDataCategories($dir, $fileName) {
    $parser = new Parser($dir . "/" . $fileName);
    $parser->setTableName("category")
        ->pushColumnHandler(new ColumnString("name"))
        ->pushColumnHandler(new ColumnString("icon"))
        ->parseFile();
}

function createDataCities($dir, $fileName) {
    $parser = new Parser($dir . "/" . $fileName);
    $parser->setTableName("city")
        ->pushColumnHandler(new ColumnString("city"))
        ->pushColumnHandler(new ColumnString("lat"))
        ->pushColumnHandler(new ColumnString("long"))
        ->parseFile();
}

function createDataFeedback($dir, $fileName) {
    $descriptionHandler = new ColumnString("description");
    $descriptionHandler->setMaxValueLen(255);

    $employerIdHandler = new ColumnIntRand("user_id");
    $employerIdHandler->setMaxValue(20);

    $employerIdHandler = new ColumnIntRand("task_id");
    $employerIdHandler->setMaxValue(10);

    $parser = new Parser($dir . "/" . $fileName);
    $parser->setTableName("feedback")
        ->pushColumnHandler(new ColumnString("created_at"))
        ->pushColumnHandler(new ColumnString("rate"))
        ->pushColumnHandler($descriptionHandler)
        ->pushColumnHandler($employerIdHandler)
        ->pushColumnHandler($employerIdHandler)
        ->parseFile();
}

function createDataProfiles($dir, $fileName) {
    $parser = new Parser($dir . "/" . $fileName);
    $parser->setTableName("profile")
        ->pushColumnHandler(new ColumnString("address"))
        ->pushColumnHandler(new ColumnString("bd"))
        ->pushColumnHandler(new ColumnString("about"))
        ->pushColumnHandler(new ColumnString("phone"))
        ->pushColumnHandler(new ColumnString("skype"))
        ->parseFile();
}

function createDataTask($dir, $fileName) {
    $descriptionHandler = new ColumnString("description");
    $descriptionHandler->setMaxValueLen(255);

    $updateAtHandler = new ColumnIntRand("updated_at");
    $updateAtHandler->setMinValue(strtotime("-1 year"))
        ->setMaxValue(strtotime("now"))
        ->setModifyFunction("datetimeToStr");

    $StatusNew = new StatusNew();
    $statusHandler = new ColumnString("status");
    $statusHandler->setValue($StatusNew->getKey());

    $employerIdHandler = new ColumnIntRand("employer_id");
    $employerIdHandler->setMinValue(1)
        ->setMaxValue(10);

    $executorIdHandler = new ColumnIntRand("executor_id");
    $executorIdHandler->setMinValue(11)
        ->setMaxValue(21);

    $cityIdHandler = new ColumnIntRand("city_id");
    $cityIdHandler->setMaxValue(1100);

    $parser = new Parser($dir . "/" . $fileName);
    $parser->setTableName("task")
        ->pushColumnHandler(new ColumnString("created_at"))
        ->pushColumnHandler(new ColumnString("category_id"))
        ->pushColumnHandler($descriptionHandler)
        ->pushColumnHandler(new ColumnString("expire"))
        ->pushColumnHandler(new ColumnString("name"))
        ->pushColumnHandler(new ColumnString("address"))
        ->pushColumnHandler(new ColumnString("budget"))
        ->pushColumnHandler(new ColumnString("lat"))
        ->pushColumnHandler(new ColumnString("long"))
        ->pushColumnHandler($updateAtHandler)
        ->pushColumnHandler($statusHandler)
        ->pushColumnHandler($employerIdHandler)
        ->pushColumnHandler($executorIdHandler)
        ->pushColumnHandler($cityIdHandler)
        ->parseFile();
}

function createDataUsers($dir, $fileName) {
    $passwordHandler = new ColumnString("password");
    $passwordHandler->setModifyFunction("md5");

    $createdAtHandler = new ColumnIntRand("created_at");
    $createdAtHandler->setMinValue(strtotime("-2 year"))
        ->setMaxValue(strtotime("-1 year"))
        ->setModifyFunction("datetimeToStr");

    $updateAtHandler = new ColumnIntRand("updated_at");
    $updateAtHandler->setMinValue(strtotime("-1 year"))
        ->setMaxValue(strtotime("now"))
        ->setModifyFunction("datetimeToStr");

    $rateHandler = new ColumnIntRand("rate");
    $rateHandler->setMaxValue(5);

    $cityIdHandler = new ColumnIntRand("city_id");
    $cityIdHandler->setMaxValue(1100);

    $parser = new Parser($dir . "/" . $fileName);
    $parser->setTableName("user")
        ->pushColumnHandler(new ColumnString("email"))
        ->pushColumnHandler(new ColumnString("name"))
        ->pushColumnHandler($passwordHandler)
        ->pushColumnHandler($createdAtHandler)
        ->pushColumnHandler($updateAtHandler)
        ->pushColumnHandler($rateHandler)
        ->pushColumnHandler($cityIdHandler)
        ->pushColumnHandler(new ColumnIntOrder("profiles_id"))
        ->parseFile();
}

createDataCategories(__DIR__, "categories.csv");
createDataCities(__DIR__, "cities.csv");
createDataFeedback(__DIR__, "opinions.csv");
createDataProfiles(__DIR__, "profiles.csv");
createDataTask(__DIR__, "tasks.csv");
createDataUsers(__DIR__, "users.csv");
