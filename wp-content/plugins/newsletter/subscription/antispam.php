<?php
/* @var $this NewsletterSubscriptionAdmin */
/* @var $controls NewsletterControls */
/* @var $logger NewsletterControls */

defined('ABSPATH') || exit;

if ($controls->is_action()) {

    if ($controls->is_action('save')) {
        // Processing IPs
        $list = $this->to_array($controls->data['ip_blacklist']);
        $controls->data['ip_blacklist'] = [];
        foreach ($list as $item) {
            $item = trim($item);
            if (substr($item, 0, 1) === '#') {
                $controls->data['ip_blacklist'][] = $item;
                continue;
            }
            $item = preg_replace('|[^0-9a-fA-F:./]|', '', $item);
            if (empty($item)) {
                continue;
            }
            if (strpos($item, '/', 2)) {
                list($ip, $bits) = explode('/', $item);
                $bits = (int) $bits;
                if (!$bits)
                    continue;
                $item = $ip . '/' . $bits;
            } else {
                
            }
            $controls->data['ip_blacklist'][] = $item;
        }

        $controls->data['address_blacklist'] = $this->to_array($controls->data['address_blacklist']);

        $this->save_main_options($controls->data, 'antispam');
        $controls->add_message_saved();
    }
} else {
    $controls->data = $this->get_options('antispam');
}

?>

<div class="wrap" id="tnp-wrap">

    <?php include NEWSLETTER_DIR . '/header.php'; ?>

    <div id="tnp-heading">
        <?php $controls->title_help('/subscription/antiflood') ?>
        <h2><?php _e('Subscription', 'newsletter') ?></h2>
        <?php include __DIR__ . '/nav.php' ?>
    </div>

    <div id="tnp-body">

        <?php $controls->show(); ?>

        <form method="post" action="">
            <?php $controls->init(); ?>


            <div id="tabs" class="tnp-tabs">
                <ul>
                    <li><a href="#tabs-general"><?php _e('General', 'newsletter') ?></a></li>
                    <li><a href="#tabs-blacklists"><?php _e('Blacklists', 'newsletter') ?></a></li>
                    <?php if (NEWSLETTER_DEBUG) { ?>
                        <li><a href="#tabs-debug">Debug</a></li>
                    <?php } ?>
                </ul>

                <div id="tabs-general">


                    <table class="form-table">
                        <tr>
                            <th>
                                <?php $controls->label(__('Disable antibot', 'newsletter'), '/subscription/antiflood') ?>
                            </th>
                            <td>
                                <?php $controls->yesno('disabled'); ?>
                                <p class="description">
                                    <?php _e('Disable for ajax form submission', 'newsletter'); ?>
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <th><?php $controls->label('Akismet', '/subscription/antiflood#akismet') ?></th>
                            <td>
                                <?php
                                $controls->select('akismet', array(
                                    0 => __('Disabled', 'newsletter'),
                                    1 => __('Enabled', 'newsletter')
                                ));
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th><?php $controls->label(__('Antiflood', 'newsletter'), '/subscription/antiflood#antiflood') ?></th>
                            <td>
                                <?php
                                $controls->select('antiflood', array(
                                    0 => __('Disabled', 'newsletter'),
                                    5 => '5 ' . __('seconds', 'newsletter'),
                                    10 => '10 ' . __('seconds', 'newsletter'),
                                    15 => '15 ' . __('seconds', 'newsletter'),
                                    30 => '30 ' . __('seconds', 'newsletter'),
                                    60 => '1 ' . __('minute', 'newsletter'),
                                    120 => '2 ' . __('minutes', 'newsletter'),
                                    300 => '5 ' . __('minutes', 'newsletter'),
                                    600 => '10 ' . __('minutes', 'newsletter'),
                                    900 => '15 ' . __('minutes', 'newsletter'),
                                    1800 => '30 ' . __('minutes', 'newsletter'),
                                    360 => '60 ' . __('minutes', 'newsletter')
                                ));
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php $controls->label(__('Captcha', 'newsletter'), '/subscription/antiflood/#captcha') ?> 
                            </th>
                            <td>
                                <?php $controls->enabled('captcha'); ?>
                            </td>
                        </tr>
                        <?php /*
                          <tr>
                          <th><?php _e('Domain check', 'newsletter') ?></th>
                          <td>
                          <?php
                          $controls->yesno('domain_check');
                          ?>
                          </td>
                          </tr>
                         */ ?>

                    </table>


                </div>

                <div id="tabs-blacklists">
                    <table class="form-table">
                        <tr>
                            <th>
                                <?php $controls->label(__('IP blacklist', 'newsletter'), '/subscription/antiflood/#ip-blacklist') ?>
                            </th>
                            <td>
                                <?php $controls->textarea('ip_blacklist'); ?>
                                <p class="description">
                                    <?php _e('One per line', 'newsletter') ?>
                                    IPv4 (aaa.bbb.ccc.ddd) supported. IPv6 supported. CIDR supported only for IPv4. Lines starting with # are
                                    considered comments.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php $controls->label(__('Address blacklist', 'newsletter'), '/subscription/antiflood/#email-blacklist') ?>
                            </th>
                            <td>
                                <?php $controls->textarea('address_blacklist'); ?>
                                <p class="description"><?php _e('One per line', 'newsletter') ?></p>
                            </td>
                        </tr>
                    </table>
                </div>

                <?php if (NEWSLETTER_DEBUG) { ?>
                    <div id="tabs-debug">
                        <pre><?php echo esc_html(json_encode($this->get_db_options('antispam'), JSON_PRETTY_PRINT)) ?></pre>
                    </div>
                <?php } ?>

            </div>

            <p>
                <?php $controls->button_save() ?>
            </p>

        </form>

    </div>

    <?php include NEWSLETTER_DIR . '/tnp-footer.php'; ?>

</div>
