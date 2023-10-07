<?php
/* @var $this NewsletterSubscriptionAdmin */
/* @var $controls NewsletterControls */
/* @var $logger NewsletterLogger */

defined('ABSPATH') || exit;

if (!$controls->is_action()) {
    $controls->data = $this->get_options('lists', $language);

} else {
    if ($controls->is_action('save')) {

        // Processing lists for specific language
        if ($language) {
            for ($i = 0; $i <= NEWSLETTER_LIST_MAX; $i++) {
                if (empty($controls->data['list_' . $i])) {
                    unset($controls->data['list_' . $i]);
                }
            }
        }

        $this->save_options($controls->data, 'lists', $language);
        $controls->add_message_saved();
    }
    if ($controls->is_action('unlink')) {
        $wpdb->query("update " . NEWSLETTER_USERS_TABLE . " set list_" . ((int) $controls->button_data) . "=0");
        $controls->add_message_done();
    }
}

// Conditions for the count query
$conditions = [];
for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) {
    $conditions[] = "count(case list_$i when 1 then 1 else null end) list_$i";
}

$main_options = $this->get_options('lists', '');

$status = array(0 => __('Private', 'newsletter'), 1 => __('Public', 'newsletter'));

$count = $wpdb->get_row("select " . implode(',', $conditions) . ' from ' . NEWSLETTER_USERS_TABLE);
?>
<script>
    jQuery(function () {
        jQuery(".tnp-notes").tooltip({
            content: function () {
                return this.title;
            }
        });
    });
</script>
<div class="wrap tnp-lists" id="tnp-wrap">

    <?php include NEWSLETTER_ADMIN_HEADER ?>

    <div id="tnp-heading">
        <?php $controls->title_help('/subscription/newsletter-lists/') ?>
        <h2><?php _e('Lists', 'newsletter') ?></h2>

    </div>

    <div id="tnp-body">

        <?php $controls->show(); ?>

        <form method="post" action="">
            <?php $controls->init(); ?>
            <p>
                <?php $controls->button_save(); ?>
            </p>

            <div id="tabs">
                <ul>
                    <li><a href="#tabs-general"><?php _e('Lists', 'newsletter') ?></a></li>

                    <?php if (NEWSLETTER_DEBUG) { ?>
                        <li><a href="#tabs-debug">Debug</a></li>
                    <?php } ?>
                </ul>
                <div id="tabs-general">

                    <?php $this->language_notice() ?>

                    <table class="widefat" style="width: auto; max-width: 800px" scope="presentation">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php _e('Name', 'newsletter') ?></th>
                                <?php if (!$language) { ?>
                                    <th><?php _e('Type', 'newsletter') ?></th>
                                    <th style="white-space: nowrap"><?php _e('Enforced', 'newsletter') ?> <i class="fas fa-info-circle tnp-notes" title="<?php esc_attr_e('If you check this box, all your new subscribers will be automatically added to this list', 'newsletter') ?>"></i></th>
                                    <?php if ($is_multilanguage) { ?>
                                        <th><?php _e('Enforced by language', 'newsletter') ?></th>
                                    <?php } ?>
                                <?php } ?>
                                <th><?php _e('Subscribers', 'newsletter') ?></th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <?php for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) { ?>
                            <?php
                            if ($language && empty($main_options['list_' . $i])) {
                                continue;
                            }
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td>
                                    <?php $placeholder = !$language ? '' : $main_options['list_' . $i] ?>                            
                                    <?php $controls->text('list_' . $i, 40, $placeholder); ?>
                                </td>
                                <?php if (!$language) { ?>
                                    <td><?php $controls->select('list_' . $i . '_status', $status); ?></td>
                                    <td style="text-align: center">
                                        <?php $controls->checkbox('list_' . $i . '_forced'); ?>
                                    </td>
                                    <?php if ($is_multilanguage) { ?>
                                        <td><?php $controls->languages('list_' . $i . '_languages'); ?></td>
                                    <?php } ?>
                                <?php } ?>

                                <td>
                                    <?php //echo $wpdb->get_var("select count(*) from " . NEWSLETTER_USERS_TABLE . " where list_" . $i . "=1 and status='C'"); ?>
                                    <?php
                                    $field = 'list_' . $i;
                                    echo $count->$field;
                                    ?>
                                </td>

                                <td>
                                    <?php if (!$language) { ?>
                                        <?php $controls->button_confirm('unlink', __('Unlink everyone', 'newsletter'), '', $i); ?>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td colspan="7">
                                    <?php $notes = apply_filters('newsletter_lists_notes', array(), $i); ?>
                                    <?php
                                    $text = '';
                                    foreach ($notes as $note) {
                                        $text .= esc_html($note) . '<br>';
                                    }
                                    if (!empty($text)) {
                                        echo $text;
                                        //echo '<i class="fas fa-info-circle tnp-notes" title="', esc_attr($text), '"></i>';
                                    }
                                    ?> 

                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>

                <?php if (NEWSLETTER_DEBUG) { ?>
                    <div id="tabs-debug">
                        <pre><?php echo esc_html(json_encode($this->get_db_options('lists', $language), JSON_PRETTY_PRINT)) ?></pre>
                    </div>
                <?php } ?>

            </div>

            <p>
                <?php $controls->button_save(); ?>
            </p>
        </form>
    </div>

    <?php include NEWSLETTER_ADMIN_FOOTER ?>

</div>