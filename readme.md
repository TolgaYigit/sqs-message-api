# Sqs Message Api

Simple SQS message API which sends 1k random messages to SQS and receives them.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

Make sure your server meets the following requirements:

```
PHP >= 7.0
OpenSSL PHP Extension
PDO PHP Extension
Mbstring PHP Extension
```

### Installing

First, clone the repo:
```
$ git clone https://github.com/TolgaYigit/sqs-message-api.git
```

#### Install dependencies
```
$ cd sqs-message-api
$ composer install
```

#### Configure the Environment
Create `.env` file:
```
$ cat .env.example > .env
```
Enter your `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_REGION` credentials and desired `SQS_QUEUE_URL` to your `.env` file.

If you want you can edit database name, database username and database password in your `.env` file located in root folder.
NOTE: This project does not use database.

### API Routes
| HTTP Method	| Path | Method | Desciption  |
| ----- | ----- | ----- | ------------- |
| GET     	| /all | getAllMessages| Gets all messages from SQS
| GET      	| /status | getMessageStatus |  Gets approximate message count 
| POST     	| /send | sendMessages | Creates and sends 1k messages to SQS

## Built With

* [Lumen](https://lumen.laravel.com/) - The micro-framework by Laravel
* [AWS SDK for PHP](https://aws.amazon.com/sdk-for-php/)

## License

The Lumen framework is an open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)