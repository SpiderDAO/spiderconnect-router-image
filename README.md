# openwrtbuilder
Openwrt firmware bulk builder for multiple routers

## System Requirement  

- x86_64 platform  
- Ubuntu, Debian, or other Linux  
- You need to install the necessary software  

```bash
$ sudo apt-get update
$ sudo apt-get install device-tree-compiler subversion build-essential git-core libncurses5-dev zlib1g-dev gawk flex quilt libssl-dev xsltproc libxml-parser-perl mercurial bzr ecj cvs unzip git wget
```

Open your make_spiderconnect.sh
set variables
profiles - which firmware you want to build?
name of the profile you can get from column “device specs” in https://openwrt.org/toh/views/fwfiles_vs_dataentries_searchtable
remove brand name just - for example for GL.INET GL-AR150 column values are “gl.inet_gl-ar150”, so the profile name will be “gl-ar150”
run bash /make_spiderconnect.sh in your VirtualBox or Ubuntu- it will compile all profiles, plz check params inside 
if you running it the first time, or you switched OpenWRT to a later version - run the script 2 times => it will download related files

```bash
...
files="files_spiderconnect"
profiles=(gl-mt300n-v2 zbt-we1326 zbt-wr8305rt zbt-wg3526-16M)
project="spiderconnect"
imagebuilder_path="/root/!/"
openwrtver="19.07.7"