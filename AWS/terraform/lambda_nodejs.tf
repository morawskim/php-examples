data "aws_iam_policy_document" "assume_role" {
  statement {
    actions = ["sts:AssumeRole"]

    principals {
      type        = "Service"
      identifiers = ["lambda.amazonaws.com"]
    }
  }
}

resource "aws_iam_role" "lambda_nodejs_demo" {
  assume_role_policy = data.aws_iam_policy_document.assume_role.json
  name               = "lambda-nodejs-demo"
}

resource "aws_iam_role_policy_attachment" "basic" {
  policy_arn = "arn:aws:iam::aws:policy/service-role/AWSLambdaBasicExecutionRole"
  role       = aws_iam_role.lambda_nodejs_demo.name
}

resource "aws_iam_role_policy_attachment" "s3" {
  policy_arn = "arn:aws:iam::aws:policy/AmazonS3ReadOnlyAccess"
  role       = aws_iam_role.lambda_nodejs_demo.name
}

output "role_arn" {
  description = "IAM role ARN"
  value       = aws_iam_role.lambda_nodejs_demo.arn
}

# lambda function
data "archive_file" "lambda" {
  type        = "zip"
  source_dir  = "${path.module}/../lambda-nodejs"
  output_path = "${path.module}/../functions.zip"
}

resource "aws_lambda_function" "nodejs" {
  filename      = "${path.module}/../functions.zip"
  function_name = "lambda-nodejs-example"
  role          = aws_iam_role.lambda_nodejs_demo.arn
  handler       = "index.handler"
  runtime       = "nodejs14.x"
  depends_on    = [aws_iam_role_policy_attachment.basic, aws_iam_role_policy_attachment.s3]
}

resource "aws_lambda_function_url" "nodejs_latest" {
  function_name      = aws_lambda_function.nodejs.function_name
  authorization_type = "NONE"
}

output "function_url" {
  description = "Function url"
  value       = aws_lambda_function_url.nodejs_latest.function_url
}
