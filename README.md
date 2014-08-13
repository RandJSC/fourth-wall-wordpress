# Fourth Wall Events WordPress Theme

by Mike Green (mike@fifthroomcreative.com)

## Setup

```bash
[sudo] npm install -g bower coffee-script yo gulp
npm install
gulp # this will start watching the project for changes, so either hit CTRL-C to quit or do the rest in a new tab
vagrant up
vagrant ssh
cd /vagrant
gulp ssh:setup # this requires the staging server's SSH password
gulp db:downa # load up a copy of the staging database
logout
```
