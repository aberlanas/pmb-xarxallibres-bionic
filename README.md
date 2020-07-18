# PMB For XarxaLlibres - BIONIC Version (18.04)

In this repository you will find a modified version of PMB from LliureX in order
to solve the `XarxaLlibres Situation`.

## Installation Over LliureX 19

### Install the Server Flavour.

From the official page [Of LliureX's ISOs](http://releases.lliurex.net/), download the Latest server and Install it in a VM with 2 Ethernet cards.

* eth0 -> Simulate ClassRoom Network (Internal NET)
* eth1 -> Bridge to Physical Ethernet Host device

### Execute the Zero-Server-Wizard.

In the ZeroCenter, search for the *Zero Server Wizard* assistant and run it.

### Update the system
	
```
sudo lliurex-upgrade -s
```

## Services

Apache and MySQL are the requisites, other stuff like **http_proxy** is recommended but not necessary.

## Installation

After a fresh installation from LliureX (Zero-Center):

Go to the path:

`/usr/share/`

And execute the next commands:

```
mv pmb pmb-orig 
git clone https://github.com/aberlanas/pmb-xarxallibres-bionic.git 
ln -s /usr/share/pmb-xarxallibres-bionic /usr/share/pmb
```


