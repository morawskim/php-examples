resource "aws_cloudwatch_event_rule" "sf_demo" {
  name        = "sf-demo"
  description = "Capture each Symfony demo event"

  event_pattern = <<EOF
{
  "source": [
    "sf-demo"
  ]
}
EOF
}

resource "aws_cloudwatch_event_target" "cloudwatch" {
  rule = aws_cloudwatch_event_rule.sf_demo.name
  arn  = aws_cloudwatch_log_group.event_bridge.arn
  target_id = "SendToCloudWatch"
}

resource "aws_cloudwatch_log_group" "event_bridge" {
  name              = "/aws/events/sf-demo"
  retention_in_days = 1
}

resource "aws_cloudwatch_log_resource_policy" "sf_event_bridge" {
  policy_document = data.aws_iam_policy_document.sf_event_bridge_policy.json
  policy_name     = "sf_event_bridge-cloudwatch"
}

data "aws_iam_policy_document" "sf_event_bridge_policy" {
  statement {
    actions = [
      "logs:CreateLogStream",
      "logs:PutLogEvents",
      "logs:CreateLogGroup",
      "logs:DescribeLogStreams"
    ]

    resources = [
      "${aws_cloudwatch_log_group.event_bridge.arn}:*"
    ]

    principals {
      identifiers = ["events.amazonaws.com", "delivery.logs.amazonaws.com"]
      type        = "Service"
    }

    condition {
      test     = "ArnEquals"
      values   = [aws_cloudwatch_event_rule.sf_demo.arn]
      variable = "aws:SourceArn"
    }
  }
}
