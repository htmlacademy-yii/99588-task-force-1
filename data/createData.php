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
    $Parser = new Parser($dir . "/" . $fileName);
    $Parser->setTableName("category");

    $Parser->pushColumnHandler(new ColumnString("name"));

    $Parser->pushColumnHandler(new ColumnString("icon"));

    $Parser->parseFile();
}

function createDataCities($dir, $fileName) {
    $Parser = new Parser($dir . "/" . $fileName);
    $Parser->setTableName("city");

    $Parser->pushColumnHandler(new ColumnString("city"));

    $Parser->pushColumnHandler(new ColumnString("lat"));

    $Parser->pushColumnHandler(new ColumnString("long"));

    $Parser->parseFile();
}

function createDataFeedback($dir, $fileName) {
    $Parser = new Parser($dir . "/" . $fileName);
    $Parser->setTableName("feedback");

    $Parser->pushColumnHandler(new ColumnString("created_at"));

    $Parser->pushColumnHandler(new ColumnString("rate"));

    $descriptionHandler = new ColumnString("description");
    $descriptionHandler->setMaxValueLen(255);
    $Parser->pushColumnHandler($descriptionHandler);


    $employerIdHandler = new ColumnIntRand("user_id");
    $employerIdHandler->setMaxValue(20);
    $Parser->pushColumnHandler($employerIdHandler);

    $employerIdHandler = new ColumnIntRand("task_id");
    $employerIdHandler->setMaxValue(10);
    $Parser->pushColumnHandler($employerIdHandler);

    $Parser->parseFile();
}

function createDataProfiles($dir, $fileName) {
    $Parser = new Parser($dir . "/" . $fileName);
    $Parser->setTableName("profile");

    $Parser->pushColumnHandler(new ColumnString("address"));

    $Parser->pushColumnHandler(new ColumnString("bd"));

    $Parser->pushColumnHandler(new ColumnString("about"));

    $Parser->pushColumnHandler(new ColumnString("phone"));

    $Parser->pushColumnHandler(new ColumnString("skype"));

    $Parser->parseFile();
}

function createDataTask($dir, $fileName) {
    $Parser = new Parser($dir . "/" . $fileName);
    $StatusNew = new StatusNew();
    $Parser->setTableName("task");

    $Parser->pushColumnHandler(new ColumnString("created_at"));

    $Parser->pushColumnHandler(new ColumnString("category_id"));

    $descriptionHandler = new ColumnString("description");
    $descriptionHandler->setMaxValueLen(255);
    $Parser->pushColumnHandler($descriptionHandler);

    $Parser->pushColumnHandler(new ColumnString("expire"));

    $Parser->pushColumnHandler(new ColumnString("name"));

    $Parser->pushColumnHandler(new ColumnString("address"));

    $Parser->pushColumnHandler(new ColumnString("budget"));

    $Parser->pushColumnHandler(new ColumnString("lat"));

    $Parser->pushColumnHandler(new ColumnString("long"));

    $updateAtHandler = new ColumnIntRand("updated_at");
    $updateAtHandler->setMinValue(strtotime("-1 year"));
    $updateAtHandler->setMaxValue(strtotime("now"));
    $updateAtHandler->setModifyFunction("datetimeToStr");
    $Parser->pushColumnHandler($updateAtHandler);

    $statusHandler = new ColumnString("status");
    $statusHandler->setValue($StatusNew->getKey());
    $Parser->pushColumnHandler($statusHandler);

    $employerIdHandler = new ColumnIntRand("employer_id");
    $employerIdHandler->setMinValue(1);
    $employerIdHandler->setMaxValue(10);
    $Parser->pushColumnHandler($employerIdHandler);

    $executorIdHandler = new ColumnIntRand("executor_id");
    $executorIdHandler->setMinValue(11);
    $executorIdHandler->setMaxValue(21);
    $Parser->pushColumnHandler($executorIdHandler);

    $cityIdHandler = new ColumnIntRand("city_id");
    $cityIdHandler->setMaxValue(1100);
    $Parser->pushColumnHandler($cityIdHandler);

    $Parser->parseFile();
}

function createDataUsers($dir, $fileName) {
    $Parser = new Parser($dir . "/" . $fileName);
    $Parser->setTableName("user");

    $Parser->pushColumnHandler(new ColumnString("email"));

    $Parser->pushColumnHandler(new ColumnString("name"));

    $passwordHandler = new ColumnString("password");
    $passwordHandler->setModifyFunction("md5");
    $Parser->pushColumnHandler($passwordHandler);

    $createdAtHandler = new ColumnIntRand("created_at");
    $createdAtHandler->setMinValue(strtotime("-2 year"));
    $createdAtHandler->setMaxValue(strtotime("-1 year"));
    $createdAtHandler->setModifyFunction("datetimeToStr");
    $Parser->pushColumnHandler($createdAtHandler);

    $updateAtHandler = new ColumnIntRand("updated_at");
    $updateAtHandler->setMinValue(strtotime("-1 year"));
    $updateAtHandler->setMaxValue(strtotime("now"));
    $updateAtHandler->setModifyFunction("datetimeToStr");
    $Parser->pushColumnHandler($updateAtHandler);

    $rateHandler = new ColumnIntRand("rate");
    $rateHandler->setMaxValue(5);
    $Parser->pushColumnHandler($rateHandler);

    $cityIdHandler = new ColumnIntRand("city_id");
    $cityIdHandler->setMaxValue(1100);
    $Parser->pushColumnHandler($cityIdHandler);

    $Parser->pushColumnHandler(new ColumnIntOrder("profiles_id"));

    $Parser->parseFile();
}

createDataCategories(__DIR__, "categories.csv");
createDataCities(__DIR__, "cities.csv");
createDataFeedback(__DIR__, "opinions.csv");
createDataProfiles(__DIR__, "profiles.csv");
createDataTask(__DIR__, "tasks.csv");
createDataUsers(__DIR__, "users.csv");
