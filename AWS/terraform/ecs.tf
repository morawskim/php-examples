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

output "ecs_domain" {
  value = aws_lb.ecs.dns_name
}

resource "aws_ecs_cluster" "demo" {
   name = "demo"
}

resource "aws_ecs_task_definition" "nginxdemo" {
  family                   = "nginxdemo"
  execution_role_arn       = aws_iam_role.ecs_task_execution_role.arn
  network_mode             = "awsvpc"
  requires_compatibilities = ["FARGATE"]
  cpu                      = 256 # 1 vCPU = 1024 CPU units
  memory                   = 512 # in MiB
  container_definitions    = jsonencode([{
    name        = "nginxhello"
    image       = "nginxdemos/hello:latest"
    essential   = true
    environment = [
      {name = "VAR", value = "VALUE"}
    ]
    memoryReservation = 60
    portMappings = [{
      protocol      = "tcp"
      containerPort = 80
      hostPort      = 80
    }]
    logConfiguration = {
      logDriver = "awslogs",
      options = {
        awslogs-group = "/ecs/nginxdemo"
        awslogs-region = var.region
        awslogs-stream-prefix = "ecs"
      }
    }
  }])
}

resource "aws_ecs_service" "nginxdemo" {
  name            = "nginxdemo"
  cluster         = aws_ecs_cluster.demo.id
  launch_type     = "FARGATE"
  task_definition = aws_ecs_task_definition.nginxdemo.arn
  desired_count   = 2

  network_configuration {
    security_groups = [aws_security_group.elb_http.id]
    subnets         = local.private_subnet_ids
  }

  load_balancer {
    target_group_arn = aws_lb_target_group.ecs.id
    container_name   = "nginxhello"
    container_port   = 80
  }
}

resource "aws_cloudwatch_log_group" "ecs-nginxdemo" {
  name              = "/ecs/nginxdemo"
  retention_in_days = 3
}
