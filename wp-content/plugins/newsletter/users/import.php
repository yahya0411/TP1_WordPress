<?php
defined('ABSPATH') || exit;
?>

<div class="wrap" id="tnp-wrap">

    <?php include NEWSLETTER_DIR . '/header.php'; ?>

    <div id="tnp-heading">

        <h2><?php _e('Import', 'newsletter') ?></h2>

    </div>

    <div id="tnp-body" class="tnp-users tnp-users-import">

        <p>
            The import features have been consolidated in the <strong>free</strong> Import Addon you can find on
            <a href="?page=<?php echo class_exists('NewsletterExtensions') ? 'newsletter_extensions_index' : 'newsletter_main_extensions' ?>">addons management panel</a>. Please install that addon to have:
        </p>
        <ul>
            <li>File upload or copy and paste of data</li>
            <li>Background processing for long set of data</li>
            <li>Quick bounced address import</li>
        </ul>

        <p>
            Documentation about Import Addon can be <a href="https://www.thenewsletterplugin.com/documentation/addons/extended-features/advanced-import/" target="_blank">found here</a>.</p>
        </p>

    </div>

    <?php include NEWSLETTER_DIR . '/tnp-footer.php'; ?>

</div>
