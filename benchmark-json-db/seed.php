<?php

use App\models\ItemMysql;
use App\models\ItemPostgres;
use App\models\ItemMongoDb;
use App\utils\ConnectionUtils;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

const LIMIT = 1000000;

$faker = Faker\Factory::create('pl_PL');

$progressBar = new ProgressBar(new ConsoleOutput(), LIMIT);
$progressBar->start();
$progressBar->setRedrawFrequency(1000);

ConnectionUtils::setupMySqlConnection();
ConnectionUtils::setupPostgresConnection();
ConnectionUtils::setupMongoDbConnection();

for ($i = 0; $i < LIMIT; $i++) {
    $person = createPerson($faker);
    saveToMysql($person);
    saveToPostgres($person);
    saveToMongoDb($person);
    $progressBar->advance();
}
$progressBar->finish();

function saveToMysql(stdClass $person) {
    $row = new ItemMysql();
    $row->data = $person;
    $row->save();
}

function saveToPostgres(stdClass $person) {
    $row = new ItemPostgres();
    $row->data = $person;
    $row->save();
}

function saveToMongoDb(stdClass $person) {
    $row = new ItemMongoDb();
    $row->data = $person;
    $row->save();
}

function createPerson($faker) {
    $person = new stdClass;
    $person->name = $faker->firstName;
    $person->surname = $faker->lastName;
    $person->birtDate = $faker->date;
    $person->birthPlace = $faker->city;
    $person->birthCountry = $faker->country;
    $person->pesel = $faker->pesel;
    $person->resident = $faker->boolean;
    $person->sex = $faker->randomElement(['MALE', 'FEMALE']);
    $person->citizenshipCountry = $faker->country;
    $person->lawAbility = $faker->randomElement(['FULL', 'LIMITED', 'NONE']);

    $person->contactData = new stdClass;
    $person->contactData->country = $faker->country;
    $person->contactData->postalCode = $faker->postcode;
    $person->contactData->city = $faker->city;
    $person->contactData->street = $faker->streetName;
    $person->contactData->streetNo = $faker->buildingNumber;

    $person->contactData->phoneHomeCountry = $faker->country;
    $person->contactData->phoneHomePrefix = $faker->randomNumber(3);
    $person->contactData->phoneHome = $faker->phoneNumber;

    $person->contactData->phoneOfficeCountry = $faker->country;
    $person->contactData->phoneOfficePrefix = $faker->randomNumber(3);
    $person->contactData->phoneOffice = $faker->phoneNumber;
    $person->contactData->email = $faker->safeEmail;

    $person->personDocument = new stdClass;
    $person->personDocument->number = $faker->personalIdentityNumber;
    $person->personDocument->documentType = $faker->randomElement(['ID', 'TEMP_ID', 'PASSPORT']);
    $person->personDocument->issuedDate = $faker->date;
    $person->personDocument->validDate = $faker->date;
    $person->personDocument->country = $faker->country;

    $person->personType = $faker->randomElement(['PERSON', 'OTHER', 'ENTREPRENEUR', 'FREELANCER']);
    $person->pep = $faker->boolean;
    $person->pepFamily = $faker->boolean;
    $person->pepCooperator = $faker->boolean;
    $person->questionablePersonDocument = $faker->boolean(10);
    return $person;
}

