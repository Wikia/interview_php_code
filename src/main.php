<?php

require_once 'vendor/autoload.php';
require_once 'domain.php';


use Ramsey\Uuid\Uuid;


// [SI] This is the first class in our applications slice that receives the user data
// it's being called by a framework that we use and that framework expects an HTML formatted string in return

class Controller {
    public function submitCarQuestionnaire( object $userInput ) {
        $user = new UserEntity(Uuid::uuid4(), $userInput->name, $userInput->age);
        $answers = new AnswersEntity(Uuid::uuid4(), $userInput->car ,$userInput->engine);
        $carQuestionnaire = new CarQuestionnaireEntity(Uuid::uuid4(), $user, $answers);

        $handler = new CarQuestionnaireHandler(new CarQuestionnaireRepository());
        $response = $handler->submit($carQuestionnaire);

        ExternalLogger::logSomeAdditionalParams([$userInput->userDevice, $userInput->submissionDate]);


        return '<div>' .
            '<p>Questionnaire summary:</p>' .
            '<li>' . $response->car . '</li>' .
            '<li>' . $response->engine . '</li>' .
            '</div>';
    }
}


class CarQuestionnaireRepository {
    public function save( CarQuestionnaireEntity $entity ): void {
        // [SI] Imagine that here we are storing the data to a Postgres database
        print "\n\nSave questionnaire of: " . $entity->user->name;

        MySqlAccessService::saveToTable('Questionnaires', [
            'id' => $entity->id,
            'userId' => $entity->user->id,
            'answersId' => $entity->questions->id
        ]);

        MySqlAccessService::saveToTable('Users', [
            'id' => $entity->user->id,
            'userName' => $entity->user->name,
            'userAge' => $entity->user->age
        ]);


        MySqlAccessService::saveToTable('Answers', [
            'id' => $entity->questions->id,
            'car' => $entity->questions->car,
            'engine' => $entity->questions->engine
        ]);
    }
}


class ExternalLogger {
    static public function logSomeAdditionalParams(array $paramsToLog) {
        print "\nLogging some params: " . implode(",", $paramsToLog) . "\n";
    }
}


class MySqlAccessService {
    static public function saveToTable(string $tableName, array $data ) {
        // [SI] Imagine that here we are storing the data in a Postgres database
        print "\nDB: saving to table " . $tableName . "\n";
        var_export($data);
        print "\n";
    }
}