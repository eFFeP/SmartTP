<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

$app = Factory::getApplication();
$doc = $app->getDocument();
$user = Factory::getUser();
$this->language = $doc->language;
$this->direction = $doc->direction;

// Recupera i parametri del template
$siteName = $this->params->get('siteTitle', 'SmartTP');
$logoFile = $this->params->get('logoFile');

// Aggiungi fogli di stile e script
$doc->addStyleSheet(Uri::root(true) . '/templates/' . $this->template . '/css/template.css');
$doc->addScript(Uri::root(true) . '/templates/' . $this->template . '/js/template.js');

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <jdoc:include type="head" />
</head>

<body class="site <?php echo $this->direction === 'rtl' ? 'rtl' : ''; ?>">
    <div class="container">
        <header>
            <?php if ($this->countModules('logo')) : ?>
                <jdoc:include type="modules" name="logo" style="none" />
            <?php elseif ($logoFile) : ?>
                <img src="<?php echo Uri::root(true) . '/' . $logoFile; ?>" alt="<?php echo $siteName; ?>" class="logo">
            <?php else : ?>
                <h1><?php echo $siteName; ?></h1>
            <?php endif; ?>
        </header>

        <main>
            <?php if ($this->countModules('language')) : ?>
                <div class="lang-selector">
                    <jdoc:include type="modules" name="language" style="none" />
                </div>
            <?php else : ?>
                <div class="lang-selector">
                    <button class="lang-icon" data-lang="it">IT</button>
                    <button class="lang-icon" data-lang="fr">FR</button>
                    <button class="lang-icon" data-lang="de">DE</button>
                    <button class="lang-icon" data-lang="en">EN</button>
                </div>
            <?php endif; ?>

            <?php if ($this->countModules('login')) : ?>
                <jdoc:include type="modules" name="login" style="none" />
            <?php else : ?>
                <form id="loginForm" action="<?php echo Uri::root(true); ?>/index.php" method="post">
                    <input type="text" id="username" name="username" placeholder="<?php echo Text::_('TPL_SMARTTP_USERNAME'); ?>" required>
                    <input type="password" id="password" name="password" placeholder="<?php echo Text::_('TPL_SMARTTP_PASSWORD'); ?>" required>
                    <button type="submit" id="loginButton"><?php echo Text::_('TPL_SMARTTP_LOGIN'); ?></button>
                    <input type="hidden" name="option" value="com_users">
                    <input type="hidden" name="task" value="user.login">
                    <input type="hidden" name="return" value="<?php echo base64_encode(Uri::root()); ?>">
                    <?php echo JHtml::_('form.token'); ?>
                </form>
                <div class="links">
                    <a href="<?php echo Uri::root(true); ?>/index.php?option=com_users&view=reset" id="forgotPassword"><?php echo Text::_('TPL_SMARTTP_FORGOT_PASSWORD'); ?></a>
                    <a href="<?php echo Uri::root(true); ?>/index.php?option=com_users&view=registration" id="register"><?php echo Text::_('TPL_SMARTTP_REGISTER'); ?></a>
                </div>
            <?php endif; ?>

            <jdoc:include type="message" />
            <jdoc:include type="component" />
        </main>

        <footer>
            <?php if ($this->countModules('footer')) : ?>
                <jdoc:include type="modules" name="footer" style="none" />
            <?php else : ?>
                <p class="ps-design">PS Design</p>
            <?php endif; ?>
        </footer>
    </div>
</body>
</html>
