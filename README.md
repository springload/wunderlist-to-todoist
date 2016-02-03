Wunderlist to Todoist converter
===============================

Converts exported Wunderlist tasks into something that you can import into Todoist.

## Requirements
* [php](http://nz2.php.net/manual/en/install.php)
* Ruby 2.2+

### Mac OS X

Use Homebrew:

    brew update
    brew install php

## Usage

### Making Export Files for Todoist

1. [Export](http://support.wunderlist.com/customer/portal/articles/1183757-how-do-i-backup-export-and-import-my-data-) your lists from Wunderlist and save somewhere.
2. Open up a terminal and `cd` to your working directory.

        git clone this_repos_url
        php wunderlist-to-todoist.php /path/to/wunderlist-export.json

3. This php script should save a txt file like: `wunderlist-export.json.todoist.txt`.
4. Split the txt file into specific project files with:

        ruby split_into_projects.rb wunderlist-export.json.todoist.txt

5. This ruby script should save `projects` directory and it have several txt files that are associated with Wunderlist projects.

### Manual Import

You can use the "Import from Template" feature in Todoist.
But you need to:

* Subscribe 'Todoist Premium' (paid plan)
* Import a project file for each project.

See: [A whole new way to create and share Todoist Templates - Todoist Blog](https://blog.todoist.com/2015/11/19/new-way-to-create-todoist-templates/)

### Import with Command

You might use [ddksr/cliist: Todoist commandline client](https://github.com/ddksr/cliist).

#### Install

Before installing you should have your API token of Todoist.
Get it from [Todoist App Management Console](https://developer.todoist.com/appconsole.html).

* Click 'Create New App'
* Put `cliist` in 'App Display Name'
* Get your 'Client ID' and 'Client Secret'.
* Get your access token of Todoist API. Instructions are:
    * In English: [API Documentation | Todoist Developer](https://developer.todoist.com/#oauth)
    * In Japanese: [SwiftでTodoist API使ってみた - Qiita](http://qiita.com/rayc5_/items/c49a234191507f28af9a)

After that,

1. Run:

        git clone https://github.com/ddksr/cliist`

2. `cd` into the cloned directory.
3. Type:

        cliist-install

4. Put your access token.
5. That's it.

Usage: [cliist/README.md at master · ddksr/cliist](https://github.com/ddksr/cliist/blob/master/README.md).

#### Import Projects with cliist

You might use cliist using your shell script.
For example:

    ./cliist.py -a 'TASK @thelabel' --project PROJ

But I cannot specify a project with this...

## Original Work

This is forked from [springload/wunderlist-to-todoist](https://github.com/springload/wunderlist-to-todoist).
