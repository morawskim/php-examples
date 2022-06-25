resource "aws_security_group" "ecs_alb_podinfo" {
  name        = "ecs_alb_podinfo"
  description = "Allow HTTP traffic to podinfo through Elastic Load Balancer"
  vpc_id = local.vpc_id

  ingress {
    from_port   = 80
    to_port     = 80
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  egress {
    from_port       = 0
    to_port         = 0
    protocol        = "-1"
    cidr_blocks     = ["0.0.0.0/0"]
  }

  tags = {
    Name = "Allow HTTP through ELB Security Group"
  }
}

resource "aws_security_group" "ecs_task_podinfo" {
  name        = "ecs_task_podinfo"
  description = "Security group for ECS task podinfo"
  vpc_id = local.vpc_id

  ingress {
    from_port   = 9898
    to_port     = 9898
    protocol    = "tcp"
    security_groups = [aws_security_group.ecs_alb_podinfo.id]
  }

  egress {
    from_port       = 0
    to_port         = 0
    protocol        = "-1"
    cidr_blocks     = ["0.0.0.0/0"]
  }

  tags = {
    Name = "Podinfo in ECS"
  }
}

resource "aws_lb" "ecs-podinfo" {
  name               = "ecs-podinfo"
  internal           = false
  load_balancer_type = "application"
  security_groups    = [aws_security_group.ecs_alb_podinfo.id]
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

resource "aws_lb_target_group" "ecs-podinfo" {
  port     = 9898
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
    aws_lb.ecs-podinfo
  ]

  lifecycle {
    create_before_destroy = true
  }
}

resource "aws_lb_listener" "ecs-podinfo" {
  load_balancer_arn = aws_lb.ecs-podinfo.arn

  port              = 80
  protocol          = "HTTP"

  default_action {
    type             = "forward"
    target_group_arn = aws_lb_target_group.ecs-podinfo.arn
  }
}

output "ecs_podinfo_domain" {
  value = aws_lb.ecs-podinfo.dns_name
}
