resource "aws_cloudwatch_log_group" "symfony" {
  name              = "/application/sfdemo"
  retention_in_days = 3
}

resource "aws_cloudwatch_log_stream" "structured" {
  name           = "structured"
  log_group_name = aws_cloudwatch_log_group.symfony.name
}

resource "aws_cloudwatch_log_stream" "unstructured" {
  name           = "unstructured"
  log_group_name = aws_cloudwatch_log_group.symfony.name
}
