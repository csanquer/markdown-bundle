<?php

namespace Csanquer\Bundle\MarkdownBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PreviewControllerTest extends WebTestCase
{
    /**
     * @dataProvider providerMarkdownPreview
     */
    public function testMarkdownPreview($markdown, $useTemplate,$expected, $expectedStatusCode)
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/markdown/preview', array('markdown' => $markdown, 'use_template' => $useTemplate));

        $this->assertEquals($expectedStatusCode, $client->getResponse()->getStatusCode());
        $this->assertEquals($expected, $client->getResponse()->getContent());
    }

    public function providerMarkdownPreview()
    {
        return array(
            //data set #0
            array(
                '',
                false,
                '',
                200
            ),
            //data set #1
            array(
                <<<MARKDOWN
Test
====

Code example :

```php
<?php
phpinfo();

```

MARKDOWN
                ,
                false,
                <<<HTML
<h1>Test</h1>
<p>Code example :</p>
<pre><code class="php geshi"><ol><li class="li1"><div class="de1"><span class="kw2">&lt;?php</span></div></li><li class="li1"><div class="de1"><a href="http://www.php.net/phpinfo"><span class="kw3">phpinfo</span></a><span class="br0">&#40;</span><span class="br0">&#41;</span><span class="sy0">;</span></div></li><li class="li1"><div class="de1">&nbsp;</div></li></ol></code></pre>
HTML
                ,
                200
            ),
            array(
                <<<MARKDOWN
Test
====

Code example :

```php
<?php
phpinfo();

```

MARKDOWN
            ,
                true,
                <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Markdown Preview</title>
</head>
<body>
    <div class="content">
        <h1>Test</h1>
<p>Code example :</p>
<pre><code class="php geshi"><ol><li class="li1"><div class="de1"><span class="kw2">&lt;?php</span></div></li><li class="li1"><div class="de1"><a href="http://www.php.net/phpinfo"><span class="kw3">phpinfo</span></a><span class="br0">&#40;</span><span class="br0">&#41;</span><span class="sy0">;</span></div></li><li class="li1"><div class="de1">&nbsp;</div></li></ol></code></pre>
    </div>
</body>
</html>

HTML
            ,
                200
            ),
        );
    }
}
