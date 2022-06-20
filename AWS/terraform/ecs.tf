resource "aws_lb" "ecs" {
  name               = "ecs"
  internal           = false
  load_balancer_type = "application"
  security_groups    = [aws_security_group.elb_http.id]
  subnets            = local.public_subnet_ids
  idle_timeout    = 30

  #enable_deletion_protection = true

  #access_logs {
  #  bucket  = aws_s3_bucket.lb_logs.bucket
  #  prefix  = "test-lb"
  #  enabled = true
  #}

  tags = {
    Environment = "production"
  }
}

resource "aws_lb_target_group" "ecs" {
  port     = 80
  protocol = "HTTP"
  vpc_id   = local.vpc_id

  target_type = "ip"
  load_balancing_algorithm_type = "least_outstanding_requests"
  deregistration_delay = 180

  #stickiness {
  #  enabled = true
  #  type    = "lb_cookie"
  #}

  health_check {
    healthy_threshold   = 2
    unhealthy_threshold = 2
    timeout             = 3
    interval            = 30
    protocol            = "HTTP"
    path                = "/"
  }

  depends_on = [
    aws_lb.ecs
  ]

  lifecycle {
    create_before_destroy = true
  }
}

resource "aws_lb_listener" "ecs" {
  load_balancer_arn = aws_lb.ecs.arn

  port              = 80
  protocol          = "HTTP"

  default_action {
    type             = "forward"
    target_group_arn = aws_lb_target_group.ecs.arn
  }
}

resource "aws_ecs_cluster" "demo" {
   name = "demo"
}
