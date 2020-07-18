# PMB For XarxaLlibres - BIONIC Version (18.04)

In this repository you will find a modified version of PMB from LliureX in order
to solve the `XarxaLlibres Situation`.

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


