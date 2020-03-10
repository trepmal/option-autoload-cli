trepmal/option-autoload-cli
===========================

WP-CLI: Change option autoload value

[![Build Status](https://travis-ci.org/trepmal/option-autoload-cli.svg?branch=master)](https://travis-ci.org/trepmal/option-autoload-cli)

Quick links: [Using](#using) | [Installing](#installing) | [Contributing](#contributing) | [Support](#support)

## Using

This package implements the following commands:

### wp option autoload get

Get autoload for option

~~~
wp option autoload get <option> [--format=<format>]
~~~

**OPTIONS**

	<option>
		Name of option

	[--format=<format>]
		Format to use for the output. One of table, csv or json.
		---
		default: table
		options:
		  - table
		  - json
		  - csv
		  - yaml
		  - count
		---

**EXAMPLES**

    # Get autoload value for 'home'
    $ wp option autoload get home
    yes

    # Get autoload value for 'home' as json
    $ wp option autoload get home --format=json
    "yes"



### wp option autoload set

Set autoload for option

~~~
wp option autoload set <option> <yn>
~~~

**OPTIONS**

	<option>
		Name of option

	<yn>
		yes or no
		---
		options:
		  - yes
		  - no
		---


**EXAMPLES**

    # Set autoload value to 'no'for 'home'
    $ wp option autoload set home no
    Success: Autoload changed. Cache flushed.



### wp option autoload list

List all autoloaded (or not) options

~~~
wp option autoload list [<yn>] [--format=<format>]
~~~

**OPTIONS**

	[<yn>]
		yes or no
		---
		default: yes
		options:
		  - yes
		  - no
		---

	[--format=<format>]
		Format to use for the output. One of table, csv or json.
		---
		default: table
		options:
		  - table
		  - json
		  - csv
		  - yaml
		  - count
		---

**EXAMPLES**

    # List all un-autoloaded options
    $ wp option autoload list no
    +-------------------+
    | option_name       |
    +-------------------+
    | moderation_keys   |
    | recently_edited   |
    | blacklist_keys    |
    | uninstall_plugins |
    +-------------------+



### wp option autoload refresh

Refresh alloptions cache

~~~
wp option autoload refresh 
~~~

Alias to `wp cache delete alloptions options`

**OPTIONS**

none

**EXAMPLES**

    # Flush alloptions cache
    $ wp option autoload refresh
    Success: Object deleted.

## Installing

Installing this package requires WP-CLI v2.1 or greater. Update to the latest stable release with `wp cli update`.

Once you've done so, you can install this package with:

    wp package install git@github.com:trepmal/option-autoload-cli.git

## Contributing

We appreciate you taking the initiative to contribute to this project.

Contributing isn’t limited to just code. We encourage you to contribute in the way that best fits your abilities, by writing tutorials, giving a demo at your local meetup, helping other users with their support questions, or revising our documentation.

For a more thorough introduction, [check out WP-CLI's guide to contributing](https://make.wordpress.org/cli/handbook/contributing/). This package follows those policy and guidelines.

### Reporting a bug

Think you’ve found a bug? We’d love for you to help us get it fixed.

Before you create a new issue, you should [search existing issues](https://github.com/trepmal/option-autoload-cli/issues?q=label%3Abug%20) to see if there’s an existing resolution to it, or if it’s already been fixed in a newer version.

Once you’ve done a bit of searching and discovered there isn’t an open or fixed issue for your bug, please [create a new issue](https://github.com/trepmal/option-autoload-cli/issues/new). Include as much detail as you can, and clear steps to reproduce if possible. For more guidance, [review our bug report documentation](https://make.wordpress.org/cli/handbook/bug-reports/).

### Creating a pull request

Want to contribute a new feature? Please first [open a new issue](https://github.com/trepmal/option-autoload-cli/issues/new) to discuss whether the feature is a good fit for the project.

Once you've decided to commit the time to seeing your pull request through, [please follow our guidelines for creating a pull request](https://make.wordpress.org/cli/handbook/pull-requests/) to make sure it's a pleasant experience. See "[Setting up](https://make.wordpress.org/cli/handbook/pull-requests/#setting-up)" for details specific to working on this package locally.

## Support

Github issues aren't for general support questions, but there are other venues you can try: https://wp-cli.org/#support


*This README.md is generated dynamically from the project's codebase using `wp scaffold package-readme` ([doc](https://github.com/wp-cli/scaffold-package-command#wp-scaffold-package-readme)). To suggest changes, please submit a pull request against the corresponding part of the codebase.*
