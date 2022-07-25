resource "aws_sqs_queue" "sf_sqs_dlq" {
  name = "symfony-demo-dlq"
  message_retention_seconds  = 1209600 # 14 days
  redrive_allow_policy = jsonencode({
    redrivePermission = "allowAll"
  })

  #redrive_allow_policy = jsonencode({
  #  redrivePermission = "byQueue",
  #  sourceQueueArns   = [aws_sqs_queue.sf_sqs.arn]
  #})

  tags = {
    Environment = "sf"
  }
}

resource "aws_sqs_queue" "sf_sqs" {
  name                       = "symfony-demo"
  delay_seconds              = 15
  max_message_size           = 2048
  visibility_timeout_seconds = 120
  message_retention_seconds  = 86400 # 24H
  receive_wait_time_seconds  = 20
  redrive_policy = jsonencode({
    deadLetterTargetArn = aws_sqs_queue.sf_sqs_dlq.arn
    maxReceiveCount     = 3
  })

  tags = {
    Environment = "sf"
  }
}

output sf_sqs_url {
  value = aws_sqs_queue.sf_sqs.url
}
