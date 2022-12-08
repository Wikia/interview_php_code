<?php

require_once 'main.php';

abstract class Entity {
    public string $id;

    public function __construct( string $id ) {
        $this->id = $id;
    }

    static public function loggingConstructor( ...$params ) {
        print 'New entity created with params:';
        var_export( $params );

        return self::__construct( ...$params );
    }
}


class UserEntity extends Entity {
    public string $name;
    public int $age;

    public function __construct( string $id, string $name, int $age ) {
        parent::__construct( $id );
        $this->name = $name;
        $this->age = $age;

    }

    // I don't need this here
    static public function loggingConstructor( ...$params ): void {
        return;
    }
}


class AnswersEntity extends Entity {
    public string $car;
    public float $engine;

    public function __construct( string $id, string $car, float $engine ) {
        parent::__construct( $id );
        $this->car = $car;
        $this->engine = $engine;
    }

    // I don't need this here
    static public function loggingConstructor( ...$params ): void {
        return;
    }
}


class CarQuestionnaireEntity extends Entity {
    public UserEntity $user;
    public AnswersEntity $questions;

    public function __construct( string $id, UserEntity $user, AnswersEntity $questions
    ) {
        parent::__construct( $id );
        $this->user = $user;
        $this->questions = $questions;
    }
}


class CarQuestionnaireHandler{
    private CarQuestionnaireRepository $repository;

    public function __construct( CarQuestionnaireRepository $repository ) {
        $this->repository = $repository;
    }

    public function submit( CarQuestionnaireEntity $questionnaire ) {
        $this->repository->save($questionnaire);
        return $this->analyzeAnswers($questionnaire->questions);
    }

    private function analyzeAnswers( AnswersEntity $answers ): CarQuestionnaireResponse {
        $engineComment = (string) $answers->engine;

        // Many more engine types to come soon!!!
        switch($answers->engine) {
            case 1.0: {
                $engineComment = $engineComment . ' engine is so efficient!';
                break;
            }
            case 2.0: {
                $engineComment = $engineComment . ' engine is so powerful!';
                break;
            }
            default: {
                $engineComment = $engineComment . ' engine is so... average...';
                break;
            }
        }

        return new CarQuestionnaireResponse(
            $answers->car . ' is an amazing car!',
            $engineComment
        );
    }


}


class CarQuestionnaireResponse {
    public string $car;
    public string $engine;

    public function __construct( string $car, string $engine ) {
        $this->car = $car;
        $this->engine = $engine;
    }
}