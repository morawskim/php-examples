locals {
  vpc_id = aws_vpc.Main.id
  ec2_key_name = var.ec2_key_name
  ec2_ami_id = data.aws_ami.ubuntu.id
  ec2_app_instance_type = "t2.micro"
  sg_bastion_id = aws_security_group.bastion.id
  private_subnet_ids = toset([for k, v in aws_subnet.private_subnet : v.id])
  public_subnet_ids = toset([for k, v in aws_subnet.public_subnet : v.id])
  ec2_default_public_subnet = aws_subnet.public_subnet[var.default-az].id
}

# The AWS region to use
variable "region" {
  default = "eu-central-1"
}

variable "ec2_key_name" {}

variable "vpc_cidr" {
    default = "10.0.0.0/16"
}

variable "subnets_public" {
  description = "Map of public subnets"
  type        = map(any)
  default = {
    az-a = {
      az = "eu-central-1a"
      cidr = "10.0.1.0/24"
    },
    az-b = {
      az = "eu-central-1b"
      cidr = "10.0.2.0/24"
    },
    az-c = {
      az = "eu-central-1c"
      cidr = "10.0.3.0/24"
    }
  }
}

variable "subnets_private" {
  description = "Map of private subnets"
  type        = map(any)
  default = {
    az-a = {
      az = "eu-central-1a"
      cidr = "10.0.101.0/24"
    },
    az-b = {
      az = "eu-central-1b"
      cidr = "10.0.102.0/24"
    },
    az-c = {
      az = "eu-central-1c"
      cidr = "10.0.103.0/24"
    }
  }
}

variable "default-az" {
    default = "az-a"
}
