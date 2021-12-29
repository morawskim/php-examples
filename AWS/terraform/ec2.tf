variable "ec2_key_name" {}

locals {
  vpc_id = aws_vpc.Main.id
  ec2_key_name = var.ec2_key_name
  ec2_ami_id = data.aws_ami.ubuntu.id
  ec2_app_instance_type = "t2.micro"
  ec2_private_subnet = aws_subnet.private_subnet.id
  ec2_public_subnet = aws_subnet.public_subnet.id
}

data "aws_ami" "ubuntu" {
  most_recent = true

  filter {
    name   = "name"
    values = ["ubuntu/images/hvm-ssd/ubuntu-focal-20.04-amd64-server-*"]
  }

  filter {
    name   = "virtualization-type"
    values = ["hvm"]
  }

  owners = ["099720109477"] # Canonical
}

# Create security group and ec2
resource "aws_security_group" "bastion" {
  name = "bastion"
  description = "SSH only"
  vpc_id = local.vpc_id

  # Allow SSH
  ingress {
    from_port = 22
    protocol = "tcp"
    to_port = 22
    cidr_blocks = ["0.0.0.0/0"]
  }

  egress {
    from_port       = 0
    to_port         = 0
    protocol        = "-1"
    cidr_blocks     = ["0.0.0.0/0"]
  }

  tags = {
    Name ="bastion-sg"
  }

  lifecycle {
    create_before_destroy = true
  }
}

resource "aws_security_group" "app" {
  name = "app"
  description = "SSH & HTTP"
  vpc_id = local.vpc_id

  # Allow SSH
  ingress {
    from_port = 22
    protocol = "tcp"
    to_port = 22
    security_groups = [aws_security_group.bastion.id]
  }

  # Allow Port 80
  ingress {
    from_port = 80
    protocol = "tcp"
    to_port = 80
    security_groups = [aws_security_group.bastion.id]
  }

  egress {
    from_port       = 0
    to_port         = 0
    protocol        = "-1"
    cidr_blocks     = ["0.0.0.0/0"]
  }

  tags = {
    Name ="app-sg"
  }

  lifecycle {
    create_before_destroy = true
  }
}

resource "aws_instance" "bastion" {
  ami = local.ec2_ami_id
  instance_type = "t2.micro"
  subnet_id = local.ec2_public_subnet
  key_name = local.ec2_key_name

  vpc_security_group_ids = [
    aws_security_group.bastion.id
  ]

  root_block_device {
    delete_on_termination = true
    volume_size = 8
    volume_type = "gp2"
  }

  tags = {
    Name ="Bastion"
    OS = "Ubuntu"
  }

  depends_on = [ aws_security_group.bastion ]
}

resource "aws_instance" "app" {
  count = 1
  ami = local.ec2_ami_id
  instance_type = local.ec2_app_instance_type
  subnet_id = local.ec2_private_subnet
  key_name = local.ec2_key_name

  vpc_security_group_ids = [
    aws_security_group.app.id
  ]

  root_block_device {
    delete_on_termination = true
    volume_size = 8
    volume_type = "gp2"
  }

  user_data = <<EOF
#!/bin/bash
apt-get -y update && apt-get -y install nginx
EOF

  tags = {
    Name ="App-${count.index}"
    OS = "Ubuntu"
  }

  depends_on = [ aws_security_group.app ]
}
