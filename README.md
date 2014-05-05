Wunderlist to Todoist converter
===============================

Converts exported Wunderlist tasks into something that you can import into Todoist.

##Requirements
Make sure [php](http://nz2.php.net/manual/en/install.php) is installed.

##Usage
[Export](http://support.wunderlist.com/customer/portal/articles/1183757-how-do-i-backup-export-and-import-my-data-) your lists from Wunderlist and save somewhere

Open up a terminal
```
cd /path/to/where/you/saved/this/script
wunderlist-to-todoist.php /path/to/wunderlist-export.json
```

This should save a txt file next to your Wunderlist export file.

In this file you should find the data in the necessary format so that you can use the "Import from Template" feature in Todoist.
