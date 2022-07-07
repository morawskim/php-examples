resource "aws_cloudwatch_log_group" "codebuild-SymfonyAwsDemo" {
  name              = "/aws/codebuild/SymfonyAwsDemo"
  retention_in_days = 3
}

resource "aws_iam_policy" "CodeBuildBasePolicy-SymfonyAwsDemo-eu-central-1" {
  description = "Policy used in trust relationship with CodeBuild"
  name        = "CodeBuildBasePolicy-SymfonyAwsDemo-eu-central-1"
  path        = "/service-role/"
  policy = <<POLICY
{
  "Statement": [
    {
      "Action": [
        "logs:CreateLogGroup",
        "logs:CreateLogStream",
        "logs:PutLogEvents"
      ],
      "Effect": "Allow",
      "Resource": [
        "arn:aws:logs:eu-central-1:*:log-group:/aws/codebuild/SymfonyAwsDemo",
        "arn:aws:logs:eu-central-1:*:log-group:/aws/codebuild/SymfonyAwsDemo:*"
      ]
    },
    {
      "Action": [
        "s3:PutObject",
        "s3:GetObject",
        "s3:GetObjectVersion",
        "s3:GetBucketAcl",
        "s3:GetBucketLocation"
      ],
      "Effect": "Allow",
      "Resource": [
        "arn:aws:s3:::codepipeline-eu-central-1-*"
      ]
    },
    {
      "Action": [
        "codebuild:CreateReportGroup",
        "codebuild:CreateReport",
        "codebuild:UpdateReport",
        "codebuild:BatchPutTestCases",
        "codebuild:BatchPutCodeCoverages"
      ],
      "Effect": "Allow",
      "Resource": [
        "arn:aws:codebuild:eu-central-1:*:report-group/SymfonyAwsDemo-*"
      ]
    }
  ],
  "Version": "2012-10-17"
}
POLICY
}

resource "aws_iam_role" "codebuild-SymfonyAwsDemo-service-role" {
  assume_role_policy = <<POLICY
{
  "Statement": [
    {
      "Action": "sts:AssumeRole",
      "Effect": "Allow",
      "Principal": {
        "Service": "codebuild.amazonaws.com"
      }
    }
  ],
  "Version": "2012-10-17"
}
POLICY

  managed_policy_arns  = [aws_iam_policy.CodeBuildBasePolicy-SymfonyAwsDemo-eu-central-1.arn]
  max_session_duration = "3600"
  name                 = "codebuild-SymfonyAwsDemo-service-role"
  path                 = "/service-role/"
}

resource "aws_iam_role_policy_attachment" "tf-codebuild-SymfonyAwsDemo-service-role_CodeBuildBasePolicy-SymfonyAwsDemo-eu-central-1" {
  policy_arn = aws_iam_policy.CodeBuildBasePolicy-SymfonyAwsDemo-eu-central-1.arn
  role       = aws_iam_role.codebuild-SymfonyAwsDemo-service-role.name
}

resource "aws_codebuild_project" "SymfonyAwsDemo" {
  artifacts {
    encryption_disabled    = "false"
    override_artifact_name = "false"
    type                   = "NO_ARTIFACTS"
  }

  badge_enabled = "false"
  build_timeout = "60"

  cache {
    type = "NO_CACHE"
  }

  environment {
    compute_type                = "BUILD_GENERAL1_SMALL"
    image                       = "thecodingmachine/php:8.1-v4-cli-node16"
    image_pull_credentials_type = "SERVICE_ROLE"
    privileged_mode             = "false"
    type                        = "LINUX_CONTAINER"
  }

  logs_config {
    cloudwatch_logs {
      status = "ENABLED"
    }

    s3_logs {
      encryption_disabled = "false"
      status              = "DISABLED"
    }
  }

  name           = "SymfonyAwsDemo"
  queued_timeout = "480"
  service_role   = aws_iam_role.codebuild-SymfonyAwsDemo-service-role.arn

  source {
    git_clone_depth = "1"

    git_submodules_config {
      fetch_submodules = "false"
    }

    insecure_ssl        = "false"
    location            = "https://github.com/morawskim/aws-php-demo"
    report_build_status = "false"
    type                = "GITHUB"
  }
}
