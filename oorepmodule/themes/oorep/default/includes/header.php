<?php

/**
 * Support the htmlinject hook, which allows modules to change header, pre and post body on all pages.
 */
$this->data['htmlinject'] = [
    'htmlContentPre' => [],
    'htmlContentPost' => [],
    'htmlContentHead' => [],
];

$jquery = [];
if (array_key_exists('jquery', $this->data)) {
    $jquery = $this->data['jquery'];
}

if (array_key_exists('pageid', $this->data)) {
    $hookinfo = [
        'pre' => &$this->data['htmlinject']['htmlContentPre'],
        'post' => &$this->data['htmlinject']['htmlContentPost'],
        'head' => &$this->data['htmlinject']['htmlContentHead'],
        'jquery' => &$jquery,
        'page' => $this->data['pageid']
    ];

    SimpleSAML\Module::callHooks('htmlinject', $hookinfo);
}
// - o - o - o - o - o - o - o - o - o - o - o - o -

/**
 * Do not allow to frame SimpleSAMLphp pages from another location.
 * This prevents clickjacking attacks in modern browsers.
 *
 * If you don't want any framing at all you can even change this to
 * 'DENY', or comment it out if you actually want to allow foreign
 * sites to put SimpleSAMLphp in a frame. The latter is however
 * probably not a good security practice.
 */
header('X-Frame-Options: SAMEORIGIN');

?><!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="initial-scale=1.0" />
<script type="text/javascript" src="/<?php echo $this->data['baseurlpath']; ?>resources/script.js"></script>
<title><?php
if (array_key_exists('header', $this->data)) {
    echo $this->data['header'];
} else {
    echo 'SimpleSAMLphp';
}
?></title>

    <!--
    <link rel="stylesheet" type="text/css" href="/<?php echo $this->data['baseurlpath']; ?>resources/oorep/default.css" />
    -->

    <link rel="icon" type="image/icon" href="<?php echo htmlspecialchars(SimpleSAML\Module::getModuleURL('oorepmodule/img/favicon.ico')); ?>" />

    <!--
    <link rel="icon" type="image/icon" href="/<?php echo $this->data['baseurlpath']; ?>resources/icons/favicon.ico" />
    -->
<?php

if (!empty($jquery)) {
    $version = '1.8';
    if (array_key_exists('version', $jquery)) {
        $version = $jquery['version'];
    }

    if ($version == '1.8') {
        if (isset($jquery['core']) && $jquery['core']) {
            echo '<script type="text/javascript" src="/'.$this->data['baseurlpath'].'resources/jquery-1.8.js"></script>'."\n";
        }

        if (isset($jquery['ui']) && $jquery['ui']) {
            echo '<script type="text/javascript" src="/'.$this->data['baseurlpath'].'resources/jquery-ui-1.8.js"></script>'."\n";
        }

        if (isset($jquery['css']) && $jquery['css']) {
            echo '<link rel="stylesheet" media="screen" type="text/css" href="/'.$this->data['baseurlpath'].
                'resources/uitheme1.8/jquery-ui.css" />'."\n";
        }
    }
}

if (isset($this->data['clipboard.js'])) {
    echo '<script type="text/javascript" src="/'.$this->data['baseurlpath'].'resources/clipboard.min.js"></script>'."\n";
}

if (!empty($this->data['htmlinject']['htmlContentHead'])) {
    foreach ($this->data['htmlinject']['htmlContentHead'] as $c) {
        echo $c;
    }
}

if ($this->isLanguageRTL()) {
    ?>
    <link rel="stylesheet" type="text/css" href="/<?php echo $this->data['baseurlpath']; ?>resources/default-rtl.css" />
<?php
}
?>
    <meta name="robots" content="noindex, nofollow" />

<?php
if (array_key_exists('head', $this->data)) {
    echo '<!-- head -->'.$this->data['head'].'<!-- /head -->';
}
?>

  <link rel="stylesheet" type="text/css" href="<?php echo htmlspecialchars(SimpleSAML\Module::getModuleURL('oorepmodule/third-party/bootstrap-4.1.3/css/bootstrap.min.css')); ?>" />

  <script src="<?php echo htmlspecialchars(SimpleSAML\Module::getModuleURL('oorepmodule/third-party/jquery-3.3.1.min.js')); ?>"></script>
  <script src="<?php echo htmlspecialchars(SimpleSAML\Module::getModuleURL('oorepmodule/third-party/popper.min.js')); ?>"></script>
  <script src="<?php echo htmlspecialchars(SimpleSAML\Module::getModuleURL('oorepmodule/third-party/bootstrap-4.1.3/js/bootstrap.min.js')); ?>"></script>

</head>
<?php
$onLoad = '';
if (array_key_exists('autofocus', $this->data)) {
    $onLoad .= ' onload="SimpleSAML_focus(\''.$this->data['autofocus'].'\');"';
}
?>
<body<?php echo $onLoad; ?>>

<div class="container" id="wrap">

    <div class="text-center" style="padding-top:200px; padding-bottom:30px;" id="header">
	<h1><a href="https://www.oorep.com/">
		<img src="<?php echo htmlspecialchars(SimpleSAML\Module::getModuleURL('oorepmodule/img/logo_small.png')); ?>" alt="OOREP">
        </a></h1>
    </div>


    <?php

    $includeLanguageBar = false;
    if (!empty($_POST)) {
        $includeLanguageBar = false;
    }
    if (isset($this->data['hideLanguageBar']) && $this->data['hideLanguageBar'] === true) {
        $includeLanguageBar = false;
    }

    if ($includeLanguageBar) {
        $languages = $this->getLanguageList();
        ksort($languages);
        if (count($languages) > 1) {
            echo '<div id="languagebar">';
            $langnames = [
                'no' => 'Bokm??l', // Norwegian Bokm??l
                'nn' => 'Nynorsk', // Norwegian Nynorsk
                'se' => 'S??megiella', // Northern Sami
                'da' => 'Dansk', // Danish
                'en' => 'English',
                'de' => 'Deutsch', // German
                'sv' => 'Svenska', // Swedish
                'fi' => 'Suomeksi', // Finnish
                'es' => 'Espa??ol', // Spanish
                'ca' => 'Catal??', // Catalan
                'fr' => 'Fran??ais', // French
                'it' => 'Italiano', // Italian
                'nl' => 'Nederlands', // Dutch
                'lb' => 'L??tzebuergesch', // Luxembourgish
                'cs' => '??e??tina', // Czech
                'sl' => 'Sloven????ina', // Slovensk
                'lt' => 'Lietuvi?? kalba', // Lithuanian
                'hr' => 'Hrvatski', // Croatian
                'hu' => 'Magyar', // Hungarian
                'pl' => 'J??zyk polski', // Polish
                'pt' => 'Portugu??s', // Portuguese
                'pt-br' => 'Portugu??s brasileiro', // Portuguese
                'ru' => '?????????????? ????????', // Russian
                'et' => 'eesti keel', // Estonian
                'tr' => 'T??rk??e', // Turkish
                'el' => '????????????????', // Greek
                'ja' => '?????????', // Japanese
                'zh' => '????????????', // Chinese (simplified)
                'zh-tw' => '????????????', // Chinese (traditional)
                'ar' => '??????????????', // Arabic
                'he' => '????????????????', // Hebrew
                'id' => 'Bahasa Indonesia', // Indonesian
                'sr' => 'Srpski', // Serbian
                'lv' => 'Latvie??u', // Latvian
                'ro' => 'Rom??ne??te', // Romanian
                'eu' => 'Euskara', // Basque
                'af' => 'Afrikaans', // Afrikaans
                'zu' => 'IsiZulu', // Zulu
                'xh' => 'isiXhosa', // Xhosa
                'st' => 'Sesotho', // Sesotho
            ];

            $textarray = [];
            foreach ($languages as $lang => $current) {
                $lang = strtolower($lang);
                if ($current) {
                    $textarray[] = $langnames[$lang];
                } else {
                    $textarray[] = '<a href="'.htmlspecialchars(
                        \SimpleSAML\Utils\HTTP::addURLParameters(
                            \SimpleSAML\Utils\HTTP::getSelfURL(),
                            [$this->getTranslator()->getLanguage()->getLanguageParameterName() => $lang]
                        )
                    ).'">'.$langnames[$lang].'</a>';
                }
            }
            echo join(' | ', $textarray);
            echo '</div>';
        }
    }

    ?>
    <div id="content">

<?php

if (!empty($this->data['htmlinject']['htmlContentPre'])) {
    foreach ($this->data['htmlinject']['htmlContentPre'] as $c) {
        echo $c;
    }
}
$config = \SimpleSAML\Configuration::getInstance();
if(! $config->getBoolean('production', true)) {
    echo '<div class="caution">' . $this->t('{preprodwarning:warning:warning}'). '</div>';
}
