# README

## Pre Requirements

Go to directory `src` and execute command `composer install`.

## Create role and policy
1. Create role `aws iam create-role --role-name lambda-php-demo --assume-role-policy-document file://lambdaPHPRole.json`
1. Attach policy to role `aws iam attach-role-policy --role-name lambda-php-demo --policy-arn arn:aws:iam::aws:policy/service-role/AWSLambdaBasicExecutionRole`
1. Get role ARN `aws iam get-role --role-name lambda-php-demo --query Role.Arn --output text`

## Create a zip file

1. Create zip file `pushd src; zip -r9q ../function.zip .; popd`
1. Check files and privileges in ZIP file `zipinfo function.zip`

## Create the function with a PHP runtime layer

```
aws lambda create-function \
--function-name lambda-php-bref-example \
--role $(aws iam get-role --role-name lambda-php-demo --query Role.Arn --output text) \
--handler index.php \
--runtime provided.al2 \
--layers "arn:aws:lambda:eu-central-1:209497400698:layer:php-81:28" \
--zip-file fileb://function.zip
```

## Publish new version of function

Create a new ZIP file, from edited source code.

```
aws lambda update-function-code \
--function-name lambda-php-bref-example \
--zip-file fileb://function.zip
```

## Invoke function

```
aws lambda invoke \
--function-name lambda-php-bref-example \
--invocation-type RequestResponse \
--cli-binary-format raw-in-base64-out \
--payload '{"name": "Marcin"}' \
output.json
```

## Check result

`cat output.json`
