resource "aws_s3_bucket" "sf_demo" {
  bucket_prefix = "sf-demo-"
  force_destroy = true
}

output "s3_bucket" {
  description = "S3 bucket name"
  value       = aws_s3_bucket.sf_demo.id
}
