<?php

namespace Kilowhat\AffiliationLinks\Tests;

use Kilowhat\AffiliationLinks\UrlReplacer;
use PHPUnit\Framework\TestCase;

class UrlReplacerTest extends TestCase
{
    const REPLACEMENT = 'https://example.com/?url={url}';

    protected function assertMatching(UrlReplacer $replacer, $uri)
    {
        $this->assertEquals('https://example.com/?url=' . urlencode($uri), $replacer->replace($uri), "Replacer should have matched $uri");
    }

    protected function assertNotMatching(UrlReplacer $replacer, $uri)
    {
        $this->assertNull($replacer->replace($uri), "Replacer should not have matched $uri");
    }

    public function test_uri_component()
    {
        $replacer = new UrlReplacer([
            [
                'component' => 'uri',
                'type' => 'exact',
                'pattern' => 'https://flarum.org/',
                'replacement' => self::REPLACEMENT,
            ],
        ]);
        $this->assertMatching($replacer, 'https://flarum.org/');

        $replacer = new UrlReplacer([
            [
                'component' => 'uri',
                'type' => 'exact',
                'pattern' => 'https://flarum.org/other',
                'replacement' => self::REPLACEMENT,
            ],
        ]);
        $this->assertNotMatching($replacer, 'https://flarum.org/');

        $replacer = new UrlReplacer([
            [
                'component' => 'uri',
                'type' => 'exact',
                'pattern' => 'http://flarum.org/',
                'replacement' => self::REPLACEMENT,
            ],
        ]);
        $this->assertNotMatching($replacer, 'https://flarum.org/');
    }

    public function test_host_component()
    {
        $replacer = new UrlReplacer([
            [
                'component' => 'host',
                'type' => 'exact',
                'pattern' => 'flarum.org',
                'replacement' => self::REPLACEMENT,
            ],
        ]);

        $this->assertMatching($replacer, 'https://flarum.org/');
        $this->assertMatching($replacer, 'http://flarum.org/');
        $this->assertMatching($replacer, 'https://flarum.org/other');
        $this->assertNotMatching($replacer, 'https://flarum.localhost/');
    }

    public function test_path_component()
    {
        $replacer = new UrlReplacer([
            [
                'component' => 'path',
                'type' => 'exact',
                'pattern' => '/test',
                'replacement' => self::REPLACEMENT,
            ],
        ]);

        $this->assertMatching($replacer, 'https://flarum.org/test');
        $this->assertMatching($replacer, 'https://flagrow.io/test');
        $this->assertNotMatching($replacer, 'https://flarum.org/');
        $this->assertNotMatching($replacer, 'https://flarum.org/other');
    }

    public function test_simple_type()
    {
        $replacer = new UrlReplacer([
            [
                'component' => 'host',
                'type' => 'simple',
                'pattern' => 'flarum.org',
                'replacement' => self::REPLACEMENT,
            ],
        ]);
        $this->assertMatching($replacer, 'https://flarum.org/');
        $this->assertNotMatching($replacer, 'https://discuss.flarum.org/');

        $replacer = new UrlReplacer([
            [
                'component' => 'host',
                'type' => 'simple',
                'pattern' => '*flarum.org',
                'replacement' => self::REPLACEMENT,
            ],
        ]);
        $this->assertMatching($replacer, 'https://flarum.org/');
        $this->assertMatching($replacer, 'https://discuss.flarum.org/');
        $this->assertMatching($replacer, 'https://otherflarum.org/');
        $this->assertNotMatching($replacer, 'https://flarum.org.localhost/');

        $replacer = new UrlReplacer([
            [
                'component' => 'host',
                'type' => 'simple',
                'pattern' => '*.flarum.org',
                'replacement' => self::REPLACEMENT,
            ],
        ]);
        $this->assertMatching($replacer, 'https://discuss.flarum.org/');
        $this->assertMatching($replacer, 'https://other.flarum.org/');
        $this->assertNotMatching($replacer, 'https://flarum.org/');
        $this->assertNotMatching($replacer, 'https://otherflarum.org/');
    }

    public function test_regex_type()
    {
        $replacer = new UrlReplacer([
            [
                'component' => 'host',
                'type' => 'regex',
                'pattern' => '~^[a-z]{2}\.localhost$~',
                'replacement' => self::REPLACEMENT,
            ],
        ]);
        $this->assertMatching($replacer, 'https://ab.localhost/');
        $this->assertMatching($replacer, 'https://cd.localhost/');
        $this->assertNotMatching($replacer, 'https://abcd.localhost/');
        $this->assertNotMatching($replacer, 'https://a2.localhost/');

        $replacer = new UrlReplacer([
            [
                'component' => 'host',
                'type' => 'regex',
                'pattern' => '~\.localhost$~',
                'replacement' => self::REPLACEMENT,
            ],
        ]);
        $this->assertMatching($replacer, 'https://test.localhost/');
        $this->assertMatching($replacer, 'https://sub.other.localhost/');
    }

    public function test_url_replacement()
    {
        $replacer = new UrlReplacer([
            [
                'component' => 'host',
                'type' => 'simple',
                'pattern' => '*',
                'replacement' => 'https://example.com/?url={url}',
            ],
        ]);
        $this->assertEquals('https://example.com/?url=https%3A%2F%2Fflarum.org%2F', $replacer->replace('https://flarum.org/'));

        $replacer = new UrlReplacer([
            [
                'component' => 'host',
                'type' => 'simple',
                'pattern' => '*',
                'replacement' => 'https://example.com/?url={url}&other=1',
            ],
        ]);
        $this->assertEquals('https://example.com/?url=https%3A%2F%2Fflarum.org%2F&other=1', $replacer->replace('https://flarum.org/'));

        $replacer = new UrlReplacer([
            [
                'component' => 'host',
                'type' => 'simple',
                'pattern' => '*',
                'replacement' => 'https://example.com/{url}',
            ],
        ]);
        $this->assertEquals('https://example.com/https%3A%2F%2Fflarum.org%2F', $replacer->replace('https://flarum.org/'));
    }

    public function test_rawurl_replacement()
    {
        $replacer = new UrlReplacer([
            [
                'component' => 'host',
                'type' => 'simple',
                'pattern' => '*',
                'replacement' => '{rawurl}?param=1',
            ],
        ]);
        $this->assertEquals('https://flarum.org/?param=1', $replacer->replace('https://flarum.org/'));
    }

    public function test_regex_replacement()
    {
        $replacer = new UrlReplacer([
            [
                'component' => 'uri',
                'type' => 'regex',
                'pattern' => '~^https://flarum\.org(/.*)$~',
                'replacement' => 'https://example.com/?path={1}',
            ],
        ]);
        $this->assertEquals('https://example.com/?path=%2F', $replacer->replace('https://flarum.org/'));
        $this->assertEquals('https://example.com/?path=%2Ftest', $replacer->replace('https://flarum.org/test'));

        $replacer = new UrlReplacer([
            [
                'component' => 'uri',
                'type' => 'regex',
                'pattern' => '~^https://flarum\.org(/.*)$~',
                'replacement' => 'https://example.com{raw1}',
            ],
        ]);
        $this->assertEquals('https://example.com/', $replacer->replace('https://flarum.org/'));
        $this->assertEquals('https://example.com/test', $replacer->replace('https://flarum.org/test'));
    }
}
