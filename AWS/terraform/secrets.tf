resource "aws_secretsmanager_secret" "foo" {
  name = "sfdemo/terraform/foo"
}

resource "aws_secretsmanager_secret_version" "foo" {
  secret_id     = aws_secretsmanager_secret.foo.id
  secret_string = jsonencode({
    url = "https://example.com",
    token = "secret-token-which-is-stored-in-terraform-state"
  })
}
