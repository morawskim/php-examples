resource "aws_ecr_repository" "demo" {
  name                 = "demo"
  image_tag_mutability = "MUTABLE"
}
