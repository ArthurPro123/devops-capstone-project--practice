#!/bin/bash
echo "****************************************"
echo " Setting up Capstone Environment"
echo "****************************************"

GITHUB_ACCOUNT=ArthurPro123
PROJECT_DIR=devops-capstone-project--practice

if test -z "$SN_ICR_NAMESPACE"; then
	SN_ICR_NAMESPACE=sn-labs-arthurssl
fi

# Note: The environment variable SN_ICR_NAMESPACE contains
# your image namespace in the IBM Cloud Container Registry.

PATH_TO_DEPLOYMENT_MANIFEST="deploy/deployment.yaml"


echo "Installing Python 3.9 and Virtual Environment"
sudo apt-get update
sudo DEBIAN_FRONTEND=noninteractive apt-get install -y python3.9 python3.9-venv

echo "Checking the Python version..."
python3.9 --version

echo "Creating a Python virtual environment"
python3.9 -m venv ~/venv

echo "Configuring the developer environment..."
echo "# DevOps Capstone Project additions" >> ~/.bashrc

echo "export GITHUB_ACCOUNT=$GITHUB_ACCOUNT" >> ~/.bashrc
echo "export PROJECT_DIR=$PROJECT_DIR" >> ~/.bashrc
echo "export SN_ICR_NAMESPACE=$SN_ICR_NAMESPACE" >> ~/.bashrc
echo "export PATH_TO_DEPLOYMENT_MANIFEST=$PATH_TO_DEPLOYMENT_MANIFEST" >> ~/.bashrc


## echo 'export PS1="\[\e]0;\u:\W\a\]${debian_chroot:+($debian_chroot)}\[\033[01;32m\]\u\[\033[00m\]:\[\033[01;34m\]\W\[\033[00m\]\$ "' >> ~/.bashrc

# A shorter variant:
echo 'export PS1="[\[\033[01;32m\]\u\[\033[00m\]: \[\033[01;34m\]\W\[\033[00m\]]\$ "' >> ~/.bashrc

echo "source ~/venv/bin/activate" >> ~/.bashrc

echo "Installing Python dependencies..."
source ~/venv/bin/activate && python3.9 -m pip install --upgrade pip wheel
source ~/venv/bin/activate && pip install -r requirements.txt

echo "Starting the Postgres Docker container..."
make db

echo "Checking the Postgres Docker container..."
docker ps

echo "****************************************"
echo " Capstone Environment Setup Complete"
echo "****************************************"
echo ""
echo "Use 'exit' to close this terminal and open a new one to initialize the environment"
echo ""
