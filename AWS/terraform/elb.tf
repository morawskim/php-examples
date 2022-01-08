resource "aws_security_group" "elb_http" {
  name        = "elb_http"
  description = "Allow HTTP traffic to instances through Elastic Load Balancer"
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

resource "aws_security_group" "elb_ec2_app" {
  name        = "elb_ec2_app"
  description = "Security group for Web servers in ELB"
  vpc_id = local.vpc_id

  ingress {
    from_port   = 80
    to_port     = 80
    protocol    = "tcp"
    security_groups = [aws_security_group.elb_http.id]
  }

  ingress {
    from_port   = 22
    to_port     = 22
    protocol    = "tcp"
    security_groups = [local.sg_bastion_id]
  }

  egress {
    from_port       = 0
    to_port         = 0
    protocol        = "-1"
    cidr_blocks     = ["0.0.0.0/0"]
  }

  tags = {
    Name = "Web servers in ELB"
  }
}

resource "aws_launch_configuration" "web" {
  name_prefix = "web-"

  image_id = local.ec2_ami_id
  instance_type = local.ec2_app_instance_type
  key_name = local.ec2_key_name

  security_groups = [ aws_security_group.elb_ec2_app.id ]
  associate_public_ip_address = false

  root_block_device {
    delete_on_termination = true
    volume_size = 8
    volume_type = "gp2"
  }

  user_data = <<EOF
#!/bin/bash
apt-get -y update && apt-get -y install nginx
EOF

  lifecycle {
    create_before_destroy = true
  }
}

resource "aws_autoscaling_group" "autoscale_group" {
  launch_configuration = aws_launch_configuration.web.id
  vpc_zone_identifier = local.private_subnet_ids
  min_size = 1
  max_size = 2
  desired_capacity = 1

  target_group_arns = [aws_lb_target_group.app_lb.arn]
  default_cooldown = 300
  health_check_type = "ELB"

  enabled_metrics = [
    "GroupMinSize",
    "GroupMaxSize",
    "GroupDesiredCapacity",
    "GroupInServiceInstances",
    "GroupTotalInstances"
  ]
  metrics_granularity = "1Minute"

  tags = [
    {
      key = "AutoScale"
      value = "web"
      propagate_at_launch = true
    }
  ]
}

resource "aws_lb" "app_lb" {
  name               = "app-lb"
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

resource "aws_lb_target_group" "app_lb" {
  port     = 80
  protocol = "HTTP"
  vpc_id   = local.vpc_id

  load_balancing_algorithm_type = "least_outstanding_requests"

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
    aws_lb.app_lb
  ]

  lifecycle {
    create_before_destroy = true
  }
}

resource "aws_lb_listener" "app_lb" {
  load_balancer_arn = aws_lb.app_lb.arn

  port              = 80
  protocol          = "HTTP"

  default_action {
    type             = "forward"
    target_group_arn = aws_lb_target_group.app_lb.arn
  }
}

# Autoscaling up
resource "aws_autoscaling_policy" "web_policy_up" {
  name = "web_policy_up"
  scaling_adjustment = 1
  adjustment_type = "ChangeInCapacity"
  cooldown = 300
  autoscaling_group_name = aws_autoscaling_group.autoscale_group.name
}

resource "aws_cloudwatch_metric_alarm" "web_cpu_alarm_up" {
  alarm_name = "web_cpu_alarm_up"
  comparison_operator = "GreaterThanOrEqualToThreshold"
  evaluation_periods = "2"
  metric_name = "CPUUtilization"
  namespace = "AWS/EC2"
  period = "120"
  statistic = "Average"
  threshold = "60"

  dimensions = {
    AutoScalingGroupName = aws_autoscaling_group.autoscale_group.name
  }

  alarm_description = "This metric monitor EC2 instance CPU utilization"
  alarm_actions = [ aws_autoscaling_policy.web_policy_up.arn ]
}

# Autoscaling down
resource "aws_autoscaling_policy" "web_policy_down" {
  name = "web_policy_down"
  scaling_adjustment = -1
  adjustment_type = "ChangeInCapacity"
  cooldown = 300
  autoscaling_group_name = aws_autoscaling_group.autoscale_group.name
}

resource "aws_cloudwatch_metric_alarm" "web_cpu_alarm_down" {
  alarm_name = "web_cpu_alarm_down"
  comparison_operator = "LessThanOrEqualToThreshold"
  evaluation_periods = "2"
  metric_name = "CPUUtilization"
  namespace = "AWS/EC2"
  period = "120"
  statistic = "Average"
  threshold = "30"

  dimensions = {
    AutoScalingGroupName = aws_autoscaling_group.autoscale_group.name
  }

  alarm_description = "This metric monitor EC2 instance CPU utilization"
  alarm_actions = [ aws_autoscaling_policy.web_policy_down.arn ]
}
