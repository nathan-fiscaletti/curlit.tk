Vagrant.configure("2") do |config|
    config.vm.define "curlit-testbox", primary: true, autostart: true do |curlit|
        curlit.vm.box = "bento/ubuntu-16.04"
        curlit.vm.network "public_network"
        curlit.vm.synced_folder "./", "/var/www/html", create: true, group: "www-data", owner: "www-data"

        curlit.vm.provider "virtualbox" do |v|
            v.name = "CurlIt! Test Box"
            v.customize ["modifyvm", :id, "--memory", "512"]
        end

        curlit.vm.provision "shell", path: "provisioning/provision_vagrant.sh"
        curlit.vm.provision "shell" do |s|
            s.args = ["localhost", "curlit", "root", "password"]
            s.path = "provisioning/database_create.sh"
        end
    end
end