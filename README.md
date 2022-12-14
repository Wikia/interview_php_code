# Coding interview

Welcome to the Coding interview!

## The Purpose

The purpose of this repository is to create a discussion ground for the topic of good coding principles.

## The content

In the src/ folder you can find a handful of classes split into two files. The files represent layers of code.

- main.php - the concrete implementation of the application
- domain.php - the abstract definition of the applications business rules

Our application is far from complete but for the purpose of the Coding interview we distilled the minimum amount of code needed to be able to discuss good coding practices and patterns.

## The context

The business purpose of our hypothetical application is to collect information about its users and their cars. The information we are collecting directly from the user are as follows:
- about the user
  - name
  - age
- about users car
  - brand
  - engine size

We are also appending some information for debugging purposes, these are however not required by the stakeholders of the project, only for the dev team needs:
- submission timestamp
- the device used to submit information

## The application flow

Imagine that the user submits the data through an HTML form. **The data is validated** and ends up in a form of an object that looks like this: 

```php
$userInput = [
    // Data submitted by the user
    'name' => 'Tomek',
    'age' => 18,
    'car' => 'Dacia Sandero',
    'engine' => 1.0,
    // Data collected by the application
    'userDevice' => 'Android',
    'submissionDate' => '2200-02-02'
];
```

The framework that we use passes this object to the `class Controller` in the `main.php` file. This is the entry point to our slice of the application. The Controllers task is to push the request through the process, specifically to the domain layer and respond with an HTML template that will be embedded in the page. The entry point to the domain layer is the `class CarQuestionnaireHandler`. Once the handler deals with the submitted data according to the business requirements, an HTML template is being constructed and returned and from there the framework takes over again.

## Comments
There are two types of comments in this code. Comments prefixed with the [SI] tag are part of the explanation of this exercise slice of code for the benefit of the discussion. Other comments are something that the devs left during the development.

## The good, the bad and the ugly
What do you like about the code? Which of the principles that you are familiar with are being abide and which are being broken? 

## How to run it

To run this you have to have Docker installed on your machine.

Go to applications root directory and build a docker image
```
docker build --no-cache -t interview_php_code .
```

The only thing that you need to run are the tests
```
docker run -it --rm --name interview_php_code_runner -v $(pwd)/src:/usr/src/myapp/src interview_php_code ./vendor/bin/phpunit src
```