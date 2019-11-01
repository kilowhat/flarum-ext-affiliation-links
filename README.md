# Multi-Purpose Affiliation Links Generator for Flarum

[![MIT license](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/kilowhat/flarum-ext-affiliation-links/blob/master/LICENSE.md) [![Latest Stable Version](https://img.shields.io/packagist/v/kilowhat/flarum-ext-affiliation-links.svg)](https://packagist.org/packages/kilowhat/flarum-ext-affiliation-links)

This extension allows you to automatically turn links into custom affiliate or redirect links.

You can define a list of rules that once matched will turn the url into another value.
You can then inject the original url as part of that new url.

For example you can create a rule so that every url with domain `niceshop.tld` gets rewritten as `https://referaldomain.tld?redirect={url}`.
This will turn links like `https://niceshop.tld/amazing-product` into `https://referaldomain.tld/?redirect=https%3A%2F%2Fniceshop.tld%2Famazing-product`.

You can create more advanced rules with regular expression matching and capture groups.

## Installation

This extension can be installed on Flarum beta 10.x **only**.

```bash
composer require kilowhat/flarum-ext-affiliation-links
```

This extension replaces flagrow/affiliation-links and will automatically import its data.

## A KILOWHAT extension

This extension was written by Clark Winkelmann as part of a client contract and released under the MIT license in the hope that the code will be useful to others.

This extension is published on Packagist and you are welcome to install it on your own forum, however **no free support is offered**.

Please [contact me](https://clarkwinkelmann.com/flarum) if you are interested in contracting me to add features or update this extension.

## Links

- [Source on GitHub](https://github.com/kilowhat/flarum-ext-affiliation-links)
- [Package on Packagist](https://packagist.org/packages/kilowhat/flarum-ext-affiliation-links)
