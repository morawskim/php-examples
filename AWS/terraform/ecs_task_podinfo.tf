resource "aws_ecs_task_definition" "podinfo" {
  family                   = "podinfo"
  execution_role_arn       = aws_iam_role.ecs_task_execution_role.arn
  network_mode             = "awsvpc"
  requires_compatibilities = ["FARGATE"]
  cpu                      = 256 # 1 vCPU = 1024 CPU units
  memory                   = 512 # in MiB
  container_definitions    = jsonencode([{
    name        = "podinfo"
    image       = "stefanprodan/podinfo:6.1.6"
    essential   = true
    environment = [
      {name = "VARNAME", value = "VALUE"}
    ]
    memoryReservation = 60
    portMappings = [{
      protocol      = "tcp"
      containerPort = 9898
      hostPort      = 9898
    }]
    logConfiguration = {
      logDriver = "awslogs",
      options = {
        awslogs-group = "/ecs/podinfo"
        awslogs-region = var.region
        awslogs-stream-prefix = "ecs"
      }
    }
  }])
}

resource "aws_ecs_service" "podinfo" {
  name            = "podinfo"
  cluster         = aws_ecs_cluster.demo.id
  launch_type     = "FARGATE"
  task_definition = aws_ecs_task_definition.podinfo.arn
  desired_count   = 2

  network_configuration {
    security_groups = [aws_security_group.ecs_task_podinfo.id]
    subnets         = local.private_subnet_ids
  }

  load_balancer {
    target_group_arn = aws_lb_target_group.ecs-podinfo.id
    container_name   = "podinfo"
    container_port   = 9898
  }
}

resource "aws_cloudwatch_log_group" "ecs-podinfo" {
  name              = "/ecs/podinfo"
  retention_in_days = 3
}
