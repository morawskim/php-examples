resource "aws_vpc" "Main" {
  cidr_block       = var.vpc_cidr
  instance_tenancy = "default"
  tags = {
    Name = "Main"
  }
}
resource "aws_internet_gateway" "IGW" {
  vpc_id =  aws_vpc.Main.id
  tags = {
    Name = "Main"
  }
}

# Create a Public and Private Subnets
resource "aws_subnet" "public_subnet" {
  for_each = var.subnets_public

  vpc_id =  aws_vpc.Main.id
  cidr_block = each.value["cidr"]
  availability_zone= each.value["az"]
  map_public_ip_on_launch = true
  tags = {
    Name = "MainPublic-${each.key}"
  }
}
resource "aws_subnet" "private_subnet" {
  for_each = var.subnets_private

  vpc_id =  aws_vpc.Main.id
  cidr_block = each.value["cidr"]
  availability_zone= each.value["az"]
  map_public_ip_on_launch = false
  tags = {
    Name = "MainPrivate-${each.key}"
  }
}

# NAT and elastic IP
resource "aws_eip" "natIP" {
  vpc   = true
  tags = {
    Name = "FOR MAIN VPC NAT"
  }
}
resource "aws_nat_gateway" "NAT" {
  allocation_id = aws_eip.natIP.id
  subnet_id = aws_subnet.public_subnet[var.default-az].id
  tags = {
    Name = "MainNAT"
  }
}

# Route table and association for Public Subnet
resource "aws_route_table" "PublicRT" {
  vpc_id =  aws_vpc.Main.id
  route {
    cidr_block = "0.0.0.0/0"
    gateway_id = aws_internet_gateway.IGW.id
  }
  tags = {
    Name = "MainPublic"
  }
}
resource "aws_route_table_association" "PublicRTAssociation" {
  for_each = aws_subnet.public_subnet

  subnet_id = each.value.id
  route_table_id = aws_route_table.PublicRT.id
}

# Route table and association for Private Subnet
resource "aws_route_table" "PrivateRT" {
  vpc_id = aws_vpc.Main.id
  route {
    cidr_block = "0.0.0.0/0"
    nat_gateway_id = aws_nat_gateway.NAT.id
  }
  tags = {
    Name = "MainPrivate"
  }
}
resource "aws_route_table_association" "PrivateRTAssociation" {
  for_each = aws_subnet.private_subnet

  subnet_id = each.value.id
  route_table_id = aws_route_table.PrivateRT.id
}
