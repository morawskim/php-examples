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

resource "aws_instance" "bastion" {
  ami = local.ec2_ami_id
  instance_type = "t2.micro"
  subnet_id = local.ec2_default_public_subnet
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
