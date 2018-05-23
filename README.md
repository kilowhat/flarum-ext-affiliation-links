# Affiliation Links by ![Flagrow logo](https://avatars0.githubusercontent.com/u/16413865?v=3&s=20) [Flagrow](https://discuss.flarum.org/d/1832-flagrow-extension-developer-group), a project of [Gravure](https://gravure.io/)

[![MIT license](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/flagrow/affiliation-links/blob/master/LICENSE.md) [![Build status](https://travis-ci.org/flagrow/affiliation-links.svg?branch=master)](https://travis-ci.org/flagrow/affiliation-links) [![Latest Stable Version](https://img.shields.io/packagist/v/flagrow/affiliation-links.svg)](https://packagist.org/packages/flagrow/affiliation-links) [![Total Downloads](https://img.shields.io/packagist/dt/flagrow/affiliation-links.svg)](https://packagist.org/packages/flagrow/affiliation-links) [![Support Us](https://img.shields.io/badge/flagrow.io-support%20us-yellow.svg)](https://flagrow.io/support-us) [![Join our Discord server](https://discordapp.com/api/guilds/240489109041315840/embed.png)](https://flagrow.io/join-discord)

This extension allows you to automatically turn links into custom affiliate or redirect links.

You can define a list of rules that once matched will turn the url into another value.
You can then inject the original url as part of that new url.

For example you can create a rule so that every url with domain `niceshop.tld` gets rewritten as `https://referaldomain.tld?redirect={url}`.
This will turn links like `https://niceshop.tld/amazing-product` into `https://referaldomain.tld/?redirect=https%3A%2F%2Fniceshop.tld%2Famazing-product`.

You can create more advanced rules with regular expression matching and capture groups.

The initial version of this extension was sponsored by [profesionalreview.com](https://www.profesionalreview.com/).

If you're only looking to add your Amazon Affiliate Tag to links, check out our [Amazon Affiliation extension](https://github.com/flagrow/amazon-affiliation).

## Installation

Use [Bazaar](https://discuss.flarum.org/d/5151-flagrow-bazaar-the-extension-marketplace) or install manually:

```bash
composer require flagrow/affiliation-links
```

## Updating

```bash
composer update flagrow/affiliation-links
php flarum migrate
php flarum cache:clear
```

## Support our work

Check out how to support Flagrow extensions at [flagrow.io/support-us](https://flagrow.io/support-us).

## Security

If you discover a security vulnerability within Affiliation Links, please send an email to the Gravure team at security@gravure.io. All security vulnerabilities will be promptly addressed.

Please include as many details as possible. You can use `php flarum info` to get the PHP, Flarum and extension versions installed.

## Links

- [Flarum Discuss post](https://discuss.flarum.org/d/12391-flagrow-affiliation-links-multi-purpose-affiliation-links-generator)
- [Source code on GitHub](https://github.com/flagrow/affiliation-links)
- [Report an issue](https://github.com/flagrow/affiliation-links/issues)
- [Download via Packagist](https://packagist.org/packages/flagrow/affiliation-links)

An extension by [Flagrow](https://flagrow.io/), a project of [Gravure](https://gravure.io/).
