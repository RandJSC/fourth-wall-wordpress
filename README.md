# Fourth Wall Events WordPress Theme

by Mike Green (mike@fifthroomcreative.com)

## Setup

```bash
[sudo] npm install -g gulp
npm install
mkdir plugins uploads
gulp              # <--[This compiles everything and creates a build folder]
gulp plugins:down # download plugins from staging
gulp uploads:down # download staging's uploads folder
vagrant up        # boot the virtual machine
gulp db:down      # sync the staging database into the VM
```
